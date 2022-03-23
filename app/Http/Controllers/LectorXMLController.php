<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xml;

class LectorXMLController extends Controller
{
    var $pila = array(); // variable global, de tipo LIFO
	var $datosLimpios = array(); //variable global que donde se extraen solo datos especificados en la funcion limpia datos, LIFO
	var $percepciones = "";
	var $deducciones = "";
	var $otros = "";



	#Lee el xml
	public function LectorXML($xml){
		
        try {

            $xml = $this->removeColonsFromRSS($xml); //se remueven caracteres especiales de los xml
            $xml = simplexml_load_string($xml); //se convierte el xml a una cadena
			//dump($xml);
			$percepciones = isset(json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['nomina12_Percepcion']) ? json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['nomina12_Percepcion']: false;
			$dedupciones = isset(json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento']['nomina12_Nomina']['nomina12_Deducciones']['nomina12_Deduccion']) ? json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento']['nomina12_Nomina']['nomina12_Deducciones']['nomina12_Deduccion']: false;
			$otros = isset( json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento']['nomina12_Nomina']['nomina12_OtrosPagos'] ) ? json_decode(json_encode(response()->json($xml)->getData()), true)['cfdi_Complemento']['nomina12_Nomina']['nomina12_OtrosPagos']: false;

			//dd($interaConcepto['nomina12_Nomina']['nomina12_Percepciones']);
			if ($percepciones) {

				$this->recursiveArray($percepciones);

				foreach ($this->pila as $key => $value) {
					//$value = "TotalOtrasDeducciones: 3504.56";
					$posClaveVehicular = strpos(strtoupper($value),":");

					$llave = substr($value,0, $posClaveVehicular);
					$valor = substr($value,$posClaveVehicular+1 );

					$this->percepciones .= "$llave ||$valor\n";

				}
			}
			
			//dump($dedupciones);

			if ($dedupciones) {
				//dump('dedcio');
				$this->pila = array();
				$this->recursiveArray($dedupciones);
				//DUMP($this->pila);

				foreach ($this->pila as $key => $value) {
					//$value = "TotalOtrasDeducciones: 3504.56";
					$posClaveVehicular = strpos(strtoupper($value),":");

					$llave = substr($value,0, $posClaveVehicular);
					$valor = substr($value,$posClaveVehicular+1 );

					$this->deducciones .= "$llave ||$valor\n";
						#lo guardo en pila
					//$this->datosLimpios = array_merge($this->datosLimpios);

				}
			}
			
			//dump($otros);
			if ($otros) {
				//dump('otrs');

				$this->pila = array();
				$this->recursiveArray($otros);
				//DUMP($this->pila);
				foreach ($this->pila as $key => $value) {
					//$value = "TotalOtrasDeducciones: 3504.56";
					$posClaveVehicular = strpos(strtoupper($value),":");
	
					$llave = substr($value,0, $posClaveVehicular);
					$valor = substr($value,$posClaveVehicular+1 );
	
					$this->otros .= "$llave ||$valor\n";
						 #lo guardo en pila
					//$this->datosLimpios = array_merge($this->datosLimpios);
	
				}
			}
			//dd('jeje');

			try {
                $interaConcepto = json_decode(json_encode(response()->json($xml)->getData()), true);

				$flight = new Xml;
				$flight->uuid = $interaConcepto['cfdi_Complemento']['tfd_TimbreFiscalDigital']['@attributes']['UUID'];
				$flight->sellosat  = $interaConcepto['cfdi_Complemento']['tfd_TimbreFiscalDigital']['@attributes']['SelloSAT'];
				$flight->fechatimbrado  = $interaConcepto['cfdi_Complemento']['tfd_TimbreFiscalDigital']['@attributes']['FechaTimbrado'];
				$flight->sellocfd  = $interaConcepto['cfdi_Complemento']['tfd_TimbreFiscalDigital']['@attributes']['SelloCFD'];
				$flight->nocertificadosat  = $interaConcepto['cfdi_Complemento']['tfd_TimbreFiscalDigital']['@attributes']['NoCertificadoSAT'];
				$flight->rfcprovcertif= $interaConcepto['cfdi_Complemento']['tfd_TimbreFiscalDigital']['@attributes']['RfcProvCertif'];
				$flight->folio = $interaConcepto['@attributes']['Folio'];
				$flight->fecha = $interaConcepto['@attributes']['Fecha'];
				$flight->sello = $interaConcepto['@attributes']['Sello'];
				$flight->formapago = $interaConcepto['@attributes']['FormaPago'];
				$flight->nocertificado = $interaConcepto['@attributes']['NoCertificado'];
				$flight->certificado = $interaConcepto['@attributes']['Certificado'];
				$flight->subtotal = $interaConcepto['@attributes']['SubTotal'];
				$flight->descuento = isset ($interaConcepto['@attributes']['Descuento']) ? $interaConcepto['@attributes']['Descuento']: null;
				$flight->moneda = $interaConcepto['@attributes']['Moneda'];
				$flight->total = $interaConcepto['@attributes']['Total'];
				$flight->tipodecomprobante = $interaConcepto['@attributes']['TipoDeComprobante'];
				$flight->metodopago = $interaConcepto['@attributes']['MetodoPago'];
				$flight->lugarexpedicion = $interaConcepto['@attributes']['LugarExpedicion'];

				$flight->nomina_emisor_registropatronal = isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Emisor']['@attributes']['RegistroPatronal']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Emisor']['@attributes']['RegistroPatronal']: null;
				$flight->nomina_emisor_origenrecurso = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Emisor']['nomina12_EntidadSNCF']['@attributes']['OrigenRecurso'];
				$flight->nomina_fechapago = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['FechaPago'];
				$flight->nomina_fechainicialpago = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['FechaInicialPago'];
				$flight->nomina_fechafinalpago = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['FechaFinalPago'];
				$flight->nomina_numdiaspagados = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['NumDiasPagados'];
				$flight->nomina_totalpercepciones = isset( $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['TotalPercepciones']) ?$interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['TotalPercepciones'] : null;
				$flight->nomina_totaldeducciones = isset ($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['TotalDeducciones']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['TotalDeducciones']: null;
				$flight->nomina_totalotrospagos= isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['TotalOtrosPagos']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['@attributes']['TotalOtrosPagos']: null;

				$flight->nomina_receptor_curp = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['Curp'];
				$flight->nomina_receptor_numseguridadsocial= isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['NumSeguridadSocial']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['NumSeguridadSocial']: null;
				$flight->nomina_receptor_fechainiciorellaboral= isset( $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['FechaInicioRelLaboral'] ) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['FechaInicioRelLaboral']: null;
				$flight->nomina_receptor_antiguedad= isset( $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['Antigüedad']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['Antigüedad']: null;
				$flight->nomina_receptor_tipocontrato= $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['TipoContrato'];
				$flight->nomina_receptor_tiporegimen= $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['TipoRegimen'];
				$flight->nomina_receptor_numempleado= $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['NumEmpleado'];
				$flight->nomina_receptor_departamento= $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['Departamento'];
				$flight->nomina_receptor_puesto= isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['Puesto']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['Puesto']: null;
				$flight->nomina_receptor_riesgopuesto= isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['RiesgoPuesto']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['RiesgoPuesto']:null;
				$flight->nomina_receptor_periodicidadpago= $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['PeriodicidadPago'];
				$flight->nomina_receptor_salariodiariointegrado= isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['SalarioDiarioIntegrado']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['SalarioDiarioIntegrado']: null ;
				$flight->nomina_receptor_claveentfed = $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Receptor']['@attributes']['ClaveEntFed'];
				
				$flight->conceptos_claveprodserv = $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['ClaveProdServ'];
				$flight->conceptos_cantidad = $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['Cantidad'];
				$flight->conceptos_claveunidad = $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['ClaveUnidad'];
				$flight->conceptos_descripcion = $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['Descripcion'];
				$flight->conceptos_valorunitario = $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['ValorUnitario'];
				$flight->conceptos_importe = $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['Importe'];
				$flight->conceptos_descuento = isset( $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['Descuento']) ? $interaConcepto['cfdi_Conceptos']['cfdi_Concepto']['@attributes']['Descuento']: null;

				$flight->emisor_rfc = $interaConcepto['cfdi_Emisor']['@attributes']['Rfc'];
				$flight->emisor_nombre = $interaConcepto['cfdi_Emisor']['@attributes']['Nombre'];
				$flight->emisor_regimenfiscal = $interaConcepto['cfdi_Emisor']['@attributes']['RegimenFiscal'];

				$flight->receptor_rfc = $interaConcepto['cfdi_Receptor']['@attributes']['Rfc'];
				$flight->receptor_nombre = $interaConcepto['cfdi_Receptor']['@attributes']['Nombre'];
				$flight->receptor_usocfdi = $interaConcepto['cfdi_Receptor']['@attributes']['UsoCFDI'];

				$flight->nomina_percepciones_totalsueldos = isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['@attributes']['TotalSueldos']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['@attributes']['TotalSueldos']:null;
				$flight->nomina_percepciones_totalgravado = isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['@attributes']['TotalGravado']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['@attributes']['TotalGravado']:null ;
				$flight->nomina_percepciones_totalexento = isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['@attributes']['TotalExento']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Percepciones']['@attributes']['TotalExento']: null;
				$flight->nomina_deducciones_totalotrasdeducciones =  isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Deducciones']['@attributes']['TotalOtrasDeducciones']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Deducciones']['@attributes']['TotalOtrasDeducciones']: null;
				$flight->nomina_deducciones_totalimpuestosretenidos = isset($interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Deducciones']['@attributes']['TotalImpuestosRetenidos']) ? $interaConcepto['cfdi_Complemento']['nomina12_Nomina']['nomina12_Deducciones']['@attributes']['TotalImpuestosRetenidos']: null;

				$flight->nomina_percepciones_detalle = $this->percepciones;
				$flight->nomina_deducciones_detalle = $this->deducciones;
				$flight->nomina_otrasdeducciones_detalle = $this->otros;
	
				$flight->save();
				//dd($interaConcepto);
				//$interaConcepto[]

            } catch (\Throwable $th) {
				\Log::error($th->getMessage().' en el archivo '.$th->getFile().' linea '.$th->getLine());
				dump($xml);
                dump( $th);
            }

		

        } catch (\Throwable $th) {
			\Log::error($th->getMessage().' en el archivo '.$th->getFile().' linea '.$th->getLine());
			dump($xml);
			dump( $th);

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
