<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LectorXMLController extends Controller
{
    var $pila = array(); // variable global, de tipo LIFO
	var $datosLimpios = array(); //variable global que donde se extraen solo datos especificados en la funcion limpia datos, LIFO

	#Lee el xml
	public function LectorXML($xml){
		
        try {

            $xml = $this->removeColonsFromRSS($xml); //se remueven caracteres especiales de los xml
            $xml = simplexml_load_string($xml); //se convierte el xml a una cadena
            dump($xml);
            /* try {
                //de la etiqueta complemento, extraigo su contenido con get data, lo paso a notacion objeto tipo JS
                $interaComplemento = json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento'];
                //llamo a la funcion recursiva y le envío como parametro en json el cfdi complemento
                $this->recursiveArray($interaComplemento);

            } catch (\Throwable $th) {
                //throw $th;
            } */
            /* try {
                $interaAddenda = json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Addenda'];
                $this->recursiveArray($interaAddenda);

            } catch (\Throwable $th) {
				\Log::error($th->getMessage().' en el archivo '.$th->getFile().' linea '.$th->getLine());

                //throw $th;
            } */
            try {
                $interaConcepto = json_decode(json_encode(response()->json($xml)->getData()), true)['@attributes'];
                dd($interaConcepto);
//                $interaConcepto = json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Conceptos'];

                $this->recursiveArray($interaConcepto);

            } catch (\Throwable $th) {
				\Log::error($th->getMessage().' en el archivo '.$th->getFile().' linea '.$th->getLine());

                //throw $th;
            }
			//dd($this->pila);
            //$this->limpiaDatos($this->pila);
			//dd($this->datosLimpios);
			
			$data = array(
				//'datosLimpios' => $this->datosLimpios,
				'pila' =>$this->pila);
            return $data;

        } catch (\Throwable $th) {
			\Log::error($th->getMessage().' en el archivo '.$th->getFile().' linea '.$th->getLine());
            return false;
        }


	}
    #Guarda el xml en mongo y retorna los datos fiscales

	private function removeColonsFromRSS($xml){

		$xml = preg_replace('~(</?|\s)([a-z0-9_]+):~is', '$1$2_', $xml);
        return $xml;
	}

	private function recursiveArray($array){
        //pregunto si es un arreglo, ya que luego el nodo no trae nada
        if (is_array($array)) {
            //el arreglo, que es un json lo intero
            foreach ($array as $key => $value) {
                //en key tenemos cosas como array a la n, pero cuando array es igual a @attributes significa que ya llegamo
                //a lo más profundo del árbol, o matriz a la n
                if ( $key === '@attributes' ) {
                    //si ya llegamos a lo más ondo de la primera rama, interamos el arreglo de esa rama de nuevo, donde keys cosas como
                    //fecha, modelo, rfc, niv, etc.
                    foreach ($value as $k => $v) {
                        //así que ahora a K, que es key, le hago algo así como "rfc_receptor: fulano del tal"
                        $k = $k.": ".$v;
                        //y lo guardo en la pila y se va a reptir n veces y así saco cada dato del rfc
                        array_push($this->pila,$k);
                    }
                }else{
                    //pero si no he llegado a lo ancho y profundo del nodo, tomo ahora el nodo hijo y lo intero recursivamente hasta que llegue al fondo
                    $this->recursiveArray( $value );
                }
            }
        }

    }

    private function limpiaDatos($data){
        //inicializo contadores para ver registrar incidencias
        $contadorNIV=0;
        $contadorSerie=0;
        $contadorCV=0;
        $contadorCVTipo2 = 0;
    	$contadorDescripcion=0;
        $contadorMarca = 0;
        $contadorMotor = 0;
    	$contadorTipo = 0;
    	$contadorNumeroSerie = 0;
        //y le digo que intere la pila que ya trae todos los datos interados recursivamente
    	foreach ($data as $key => $value) {
    		#Palabra a buscar
            $findClaveVehicular = 'CLAVEVEHICULAR:';//16
            $findClaveVehicularTipo2 = 'CVEVEHICULAR: '; //15
            $findMotor= 'MOTOR: ';//7
    		$findNiv = 'NIV:';//5
    		$finModelo = 'MODELO:'; //8
    		$findDescripcion = 'DESCRIPCION:';
    		$findMarca = 'TIPO:';//6
    		$findTipo = 'MARCA:';//7
            $findNumeroSerie = 'NUMEROSERIE:';//13
			$findNumeroSerieTipo2 = 'SERIE: ';//8
			//$findNumeroSerieTipo3 = 'NOIDENTIFICACION';//18
			
    		#Busca si existe la palabra
            $posClaveVehicular = strpos(strtoupper($value), $findClaveVehicular);
            $posClaveVehicularTipo2 = strpos(strtoupper($value), $findClaveVehicularTipo2);
            $posNumeroMotor = strpos(strtoupper($value), $findMotor);
    		$posNIV = strpos(strtoupper($value), $findNiv);
    		$posModelo = strpos(strtoupper($value), $finModelo);
    		$posDescripcion = strpos(strtoupper($value), $findDescripcion);
    		$posMarca = strpos(strtoupper($value), $findMarca);
    		$posTipo = strpos(strtoupper($value), $findTipo);
            $posNumeroSerie = strpos(strtoupper($value), $findNumeroSerie);
			$posNumeroSerieTipo2= strpos(strtoupper($value), $findNumeroSerieTipo2);
			//$posNumeroSerieTipo3= strpos(strtoupper($value), $findNumeroSerieTipo3);
            #Si existe la palabra

    		if ($posNumeroSerie === 0) {
    			#Uso un contador por si hay más de una incidencia en esa palabra
    			$contadorNumeroSerie++;
    			#Si hay más de una incidencia
    			if ($contadorNumeroSerie > 1) {
                    #la palabra numero de serie tiene 13 caracteres
    				$numeroDeSerie = substr($value, 13);
                    #al key le doy un nombre a la n
    				$key = strval('NumerodeSerie_'.$contadorNumeroSerie);
                    #guardo en un arrelo ese nombre a la n con el numero de serie que vive en value
    				$this->datosLimpios[$key] = $numeroDeSerie;
                    #lo guardo en pila
    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{
                    #aquí cae cuando es la primera ves que encuentra la palabra numero serie
    				$numeroDeSerie = substr($value, 13);
                    #guardo en un arrelo ese nombre a la n con el numero de serie que vive en value
    				$this->datosLimpios['NumerodeSerie'] = $numeroDeSerie;
                     #lo guardo en pila
    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posModelo === 0) {

    			$modelo = substr($value, 8);

    			$this->datosLimpios['Modelo'] = $modelo;

    			$this->datosLimpios = array_merge($this->datosLimpios);
    		}elseif ($posNIV === 0) {

    			$contadorNIV++;

    			if ($contadorNIV > 1) {

					$niv = substr($value, 5);
					$niv =str_replace(' ', '', $niv);
					if (strlen($niv) != 17) {
						$contadorNIV--;
						continue;
					}

    				$key = strval('NIV_'.$contadorNIV);

    				$this->datosLimpios[$key] = $niv;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

					$niv = substr($value, 5);
					$niv =str_replace(' ', '', $niv);
					if (strlen($niv) != 17) {
						$contadorNIV--;
						continue;
					}

    				$this->datosLimpios['NIV'] = $niv;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posDescripcion === 0) {

    			$contadorDescripcion++;

    			if ($contadorDescripcion > 1) {

    				$descripcion = substr($value, 13);

    				$key = strval('Descripcion_'.$contadorDescripcion);

    				$this->datosLimpios[$key] = $descripcion;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$descripcion = substr($value, 13);

    				$this->datosLimpios['Descripcion'] = $descripcion;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posMarca === 0) {

    			$contadorMarca++;

    			if ($contadorMarca > 1) {

    				$marca = substr($value, 7);

    				$key = strval('Marca_'.$contadorMarca);

    				$this->datosLimpios[$key] = $marca;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$marca = substr($value, 7);

    				$this->datosLimpios['Marca'] = $marca;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posTipo === 0) {

    			$contadorTipo++;

    			if ($contadorTipo > 1) {

    				$tipo = substr($value, 6);

    				$key = strval('Tipo_'.$contadorTipo);

    				$this->datosLimpios[$key] = $tipo;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$tipo = substr($value, 6);

    				$this->datosLimpios['Tipo'] = $tipo;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posNumeroSerie === 0) {

    			$contadorNumeroSerie++;

    			if ($contadorNumeroSerie > 1) {

					$numeroDeSerie = substr($value, 13);
					$numeroDeSerie =str_replace(' ', '', $numeroDeSerie);
					if (strlen($numeroDeSerie) != 17) {
						$contadorNumeroSerie--;
						continue;
					}
    				$key = strval('NumerodeSerie_'.$contadorNumeroSerie);

    				$this->datosLimpios[$key] = $numeroDeSerie;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

					$numeroDeSerie = substr($value, 13);
					$numeroDeSerie =str_replace(' ', '', $numeroDeSerie);
					if (strlen($numeroDeSerie) != 17) {
						$contadorNumeroSerie--;
						continue;
					}
    				$this->datosLimpios['NumerodeSerie'] = $numeroDeSerie;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posClaveVehicular === 0) {

    			$contadorCV++;

    			if ($contadorCV > 1) {

    				$claveVehicular = substr($value, 16);

    				$key = strval('ClaveVehicular_'.$contadorCV);

    				$this->datosLimpios[$key] = $claveVehicular;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$claveVehicular = substr($value, 16);

    				$this->datosLimpios['ClaveVehicular'] = $claveVehicular;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posClaveVehicularTipo2 === 0) {

    			$contadorCVTipo2++;

    			if ($contadorCVTipo2 > 1) {

    				$claveVehicular = substr($value, 14);

    				$key = strval('ClaveVehicular_'.$contadorCVTipo2);

    				$this->datosLimpios[$key] = $claveVehicular;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$claveVehicular = substr($value, 14);

    				$this->datosLimpios['ClaveVehicular'] = $claveVehicular;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posNumeroMotor === 0) {

    			$contadorMotor++;

    			if ($contadorMotor > 1) {

    				$motor = substr($value, 7);

    				$key = strval('Motor_'.$contadorMotor);

    				$this->datosLimpios[$key] = $motor;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$motor = substr($value, 7);

    				$this->datosLimpios['Motor'] = $motor;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}elseif ($posNumeroSerieTipo2 === 0) {

    			$contadorSerie++;

    			if ($contadorSerie > 1) {

					$numeroDeSerie = substr($value, 7);
					$numeroDeSerie =str_replace(' ', '', $numeroDeSerie);
					if (strlen($numeroDeSerie) != 17) {
						$contadorSerie--;
						continue;
					}

    				$key = strval('NIV_'.$contadorSerie);

    				$this->datosLimpios[$key] = $numeroDeSerie;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

					$numeroDeSerie = substr($value, 7);
					$numeroDeSerie =str_replace(' ', '', $numeroDeSerie);
					if (strlen($numeroDeSerie) != 17) {
						$contadorSerie--;
						continue;
					}
    				$this->datosLimpios['NIV'] = $numeroDeSerie;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		}/* elseif ($posNumeroSerieTipo3 === 0) {

    			$contadorSerie++;

    			if ($contadorSerie > 1) {

    				$numeroDeSerie = substr($value, 18);

    				$key = strval('NIV_'.$contadorSerie);

    				$this->datosLimpios[$key] = $numeroDeSerie;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}else{

    				$numeroDeSerie = substr($value, 18);

    				$this->datosLimpios['NIV'] = $numeroDeSerie;

    				$this->datosLimpios = array_merge($this->datosLimpios);

    			}
    		} */
    	}
    }
}
