<?php

namespace App\Imports;

use App\Models\Newtable;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    private $direccion;
    private $folio;
    private $apoderado_nombre;
    private $nombre;
    private $contador = 0;
    private $numero_registro;
    private $telefono;
    private $nombre_apoderado;
    private $escritura_apoderado;
    private $fecha_apoderado;
    private $notaria_apoderado;
    private $escritura_constitutiva;
    private $fecha_constitutiva;
    private $notaria_constitutiva;
    private $shcp_registro;
    private $imss_registro;
    private $infonavit_registro;
    private $otros_registro;
    private $capital;
    private $especialidades;
    private $fecha_constancia;
    private $invitaciones_restringidas;
    private $puesto_autoriza;
    private $nombre_autoriza;
    private $nombre_reviso;
    private $puesto_reviso;
    private $email_registro;
    private $modificaciones_constitutiva;
    private $fecha_inscripcion_registro;
    private $fecha_modificacion_registro;

    public function model(array $row)
    {   
        $this->contador ++;
        /* dump($this->contador);
        dump($row); */
        /* Algoritmo antes del 2020 */

        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
                $this->folio = (isset($row[9])) ? substr( $row[9], 7): null;
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                                # code...
            break;
            case 6:
                $this->direccion .= $row[3];
            break;
            case 7:
                $this->nombre .= $row[0];

                $this->direccion .= $row[3];
                $this->numero_registro .= $row[8];
                # code...
            break;
            case 8:
                $this->nombre .= $row[0];

                $this->direccion .= $row[3];

                # code...
            break;
            case 9:
                                                # code...
            break;
            case 10:
                                                    # code...
            break;
            case 11:
                if(substr($row[3], 0 ,1) != " "){
                    $this->direccion .= $row[3];
                }
                
            break;
            case 12:
                $this->nombre_apoderado .= $row[1];
                $this->escritura_apoderado .= $row[5];
                $this->telefono .= $row[8];

                # code...
            break;
            case 13:
                $this->nombre_apoderado .= " ".$row[1];
                $this->fecha_apoderado .= $row[5];
                # code...
            break;
            case 14:
                $this->notaria_apoderado .= $row[5];
                # code...
            break;
            case 15:
                $this->escritura_constitutiva .= $row[1];
                $this->notaria_apoderado .= $row[5];
                # code...
            break;
            case 16:
                $this->fecha_constitutiva .= $row[1];
                # code...
            break;
            case 17:
                $this->notaria_constitutiva .= $row[1];
                $this->especialidades .= $row[8];
                # code...
            break;
            case 18:
                $this->especialidades .= $row[8];
                $this->notaria_constitutiva .= $row[1];

                # code...
            break;
            case 19:
                $this->especialidades .= $row[8];
                # code...
            break;
            case 20:
                $this->especialidades .= $row[8];
                $this->capital .= $row[4];

                # code...
            break;
            case 21:
                $this->especialidades .= " ".$row[8];
                $this->shcp_registro .= $row[1];

                # code...
            break;
            case 22:
                $this->imss_registro .= $row[1];

                if(!$row[8] == "Otras (Especificar)"){
                    $this->especialidades .= $row[8];

                }

                # code...
            break;
            case 23:
                $this->infonavit_registro .= $row[1];
                $this->capital .= $row[5];
                $this->otros_registro .= $row[8];

            break;
            case 24:
                if($row[8] == "Otras (Especificar)"){
                    $this->otros_registro = $row[8];

                }
                $this->otros_registro .= " ".$row[8];
            break;
            case 25:
                                                                                                                # code...
            break;
            case 26:
                                                                                                                    # code...
            break;
            case 27:
                $this->puesto_autoriza .= $row[8];
            break;
            case 28:
                $this->puesto_autoriza .= $row[8];
                # code...
            break;
            case 29:
                                    # code...
            break;
            case 30:
                $this->fecha_constancia .= $row[0];
                $this->invitaciones_restringidas  = (isset($row[4])) ? true : false;

                # code...
            break;
            case 31:
                $this->nombre_autoriza = $row[8];
                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? : "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                   
                    ]);                          # code...
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */

        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
                $this->folio = $row[9];
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion .= $row[3];
                $this->numero_registro .= $row[8];


            break;
            case 6:
                $this->nombre .= $row[0];

            break;
            case 7:

            break;
            case 8:
                $this->nombre .= $row[0];

                $this->direccion .= $row[3];

                # code...
            break;
            case 9:
                                                # code...
            break;
            case 10:
                                                    # code...
            break;
            case 11:
                $this->escritura_apoderado .= $row[5];
                $this->telefono .= $row[8];



            break;
            case 12:
                $this->nombre_apoderado .= $row[0];
                $this->fecha_apoderado .= $row[5];
                $this->telefono .= " ".$row[8];

                # code...
            break;
            case 13:
                $this->notaria_apoderado .= $row[5];

            break;
            case 14:
                $this->escritura_constitutiva .= $row[1];

            break;
            case 15:
                $this->fecha_constitutiva .= $row[1];
                $this->especialidades .= $row[8];

                # code...
            break;
            case 16:
                $this->notaria_constitutiva .= $row[1];

            break;
            case 17:
               
            break;
            case 18:

                # code...
            break;
            case 19:
                $this->shcp_registro .= $row[1];
                # code...
            break;
            case 20:
                $this->imss_registro .= $row[1];
                $this->capital .= $row[4];

             

                # code...
            break;
            case 21:
                $this->infonavit_registro .= $row[1];
                $this->otros_registro .= $row[8];


                # code...
            break;
            case 22:

            
                //$this->email_registro .= $row[1];


                # code...
            break;
            case 23:
                $this->puesto_reviso .=  $row[3];
                $this->puesto_autoriza .= $row[8];

            break;
            case 24:
                $this->fecha_constancia .= $row[1];

               
            break;
            case 25:
                                                                                                                # code...
            break;
            case 26:
                                                                                                                    # code...
            break;
            case 27:
            break;
            case 28:
                $this->nombre_reviso .= $row[3];
                $this->nombre_autoriza .= $row[8];

                
            break;
            case 29:
                                 
            break;
            case 30:

            break;
            case 31:

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? : "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                  
                    ]);                          # code...
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */

        /* algoritmo 2020 */
        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion = $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:
               
                $this->nombre = $row[0];

            break;
            case 7:

            break;
            case 8:
            break;

            case 9:
                # code...
            break;
            case 10:
                                # code...
            break;
            case 11:

            $this->nombre_apoderado .= $row[1];
            $this->escritura_apoderado .= $row[5];
            $this->telefono .= $row[8];



            break;
            case 12:
                $this->nombre_apoderado .= $row[0];
                $this->fecha_constitutiva .= $row[5];


            # code...
            break;
            case 13:
                if ($this->nombre_apoderado == " Nombre:") {
                    $this->nombre_apoderado = $row[1];
                }

            $this->notaria_apoderado .= $row[5];

            break;
            case 14:
            $this->escritura_constitutiva .= $row[1];
            $this->escritura_constitutiva .= $row[2];



            break;
            case 15:
                
                $this->fecha_apoderado .= $row[1];
                $this->modificaciones_constitutiva .= $row[3];


            # code...
            break;
            case 16:
                $this->especialidades .= $row[8];

            $this->notaria_constitutiva .= $row[1];

            break;
            case 17:
                $this->notaria_constitutiva .= $row[1];
            break;
            case 18:

            # code...
            break;
            case 19:
            # code...
            break;
            case 20:
                $this->shcp_registro .= $row[1];



            # code...
            break;
            case 21:
                $this->imss_registro .= $row[1];
                $this->capital .= $row[4];

            


            # code...
            break;
            case 22:

                $this->infonavit_registro .= $row[1];
                $this->otros_registro .= $row[8];
                $this->capital = $row[4];



            # code...
            break;
            case 23:
                $this->email_registro .= $row[1];

           

            break;
            case 24:
                $this->puesto_reviso .=  $row[3];
                $this->puesto_autoriza .= $row[8];


            break;
            case 25:
                $this->fecha_constancia = $row[1];
                $this->puesto_reviso .=  $row[3];
                $this->puesto_autoriza .= $row[8];


            break;
            case 26:
                $this->fecha_constancia = $row[1];
                # code...
            break;
            case 27:
                $this->fecha_constancia = $row[1];

            break;
            case 28:
            
            $this->fecha_modificacion_registro    .=      $row[1];       # code...



            break;
            case 29:
                $this->fecha_inscripcion_registro    .=      $row[1];       # code...
                $this->nombre_reviso .= $row[3];
            $this->nombre_autoriza .= $row[8];
            break;
            case 30:
                $this->nombre_reviso .= $row[3];
            $this->nombre_autoriza .= $row[8];
                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    ]);                     
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */
        /* Algoritmo 2020 v2 */
        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion = $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:
               
                $this->nombre = $row[0];

            break;
            case 7:

            break;
            case 8:
            break;

            case 9:
                # code...
            break;
            case 10:
                                # code...
            break;
            case 11:

            $this->nombre_apoderado .= $row[1];
            $this->escritura_apoderado .= $row[5];
            $this->telefono .= $row[8];



            break;
            case 12:
                $this->escritura_apoderado .= $row[5];


            # code...
            break;
            case 13:
                $this->nombre_apoderado = $row[1];

                $this->fecha_apoderado = $row[5];
                


            break;
            case 14:
                $this->modificaciones_constitutiva .= $row[3];

                $this->notaria_apoderado .= $row[5];

            


            break;
            case 15:
                $this->escritura_constitutiva .= $row[1];

                


            # code...
            break;
            case 16:
                $this->fecha_constitutiva .= $row[1];
                $this->especialidades .= $row[8];
                if(!$this->modificaciones_constitutiva){
                    $this->modificaciones_constitutiva .= $row[8];
                }




            break;
            case 17:
                $this->notaria_constitutiva .= $row[1];
                break;
            case 18:

            # code...
            break;
            case 19:
            # code...
            break;
            case 20:

                $this->capital .= $row[4];


            # code...
            break;
            case 21:
                $this->shcp_registro .= $row[1];
            # code...
            break;
            case 22:
                $this->imss_registro .= $row[1];
                $this->capital .= $row[4];               
            # code...
            break;
            case 23:
                $this->infonavit_registro .= $row[1];    
            break;
            case 24:      
                $this->fecha_constancia = $row[1];
            break;
            case 25:
    
            break;
            case 26:
                $this->puesto_reviso .=  $row[3];
                $this->puesto_autoriza .= $row[8];
            break;
            case 27:
                if (is_int($row[1])) {
                    $this->fecha_modificacion_registro    .=      $row[1];
                }
                \Log::error( $this->fecha_modificacion_registro );
            break;
            case 28:
                $this->fecha_inscripcion_registro = $row[1];
                $this->nombre_reviso .= $row[3];
                $this->folio = $row[2];
                $this->nombre_autoriza .= $row[8];
            break;
            case 29:
                
            break;
            case 30:
                if(!$this->fecha_modificacion_registro){
                    $this->fecha_modificacion_registro    .=      $row[1]; 
                }
                      
                break;
            case 31:
                if(!$this->fecha_inscripcion_registro){
                    $this->fecha_inscripcion_registro = $row[1];

                }
                $this->nombre_reviso .= $row[3];
                $this->folio = $row[2];
                $this->nombre_autoriza .= $row[8];

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    
                
                ]);
                
                
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */
        /* algoritmo 2020 v3 */
        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion = $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:
               
                $this->nombre = $row[0];

            break;
            case 7:

            break;
            case 8:
            break;

            case 9:
                # code...
            break;
            case 10:
                $this->escritura_apoderado .= $row[5];
                # code...
            break;
            case 11:

            $this->nombre_apoderado .= $row[1];
            $this->telefono .= $row[8];

            $this->fecha_apoderado = $row[5];



            break;
            case 12:
                $this->notaria_apoderado .= $row[5];


            # code...
            break;
            case 13:
                $this->escritura_constitutiva .= $row[1];


                if (!$this->fecha_apoderado) {
                    $this->fecha_apoderado = $row[5];
                }
                


            break;
            case 14:
                $this->fecha_constitutiva .= $row[1];

                $this->modificaciones_constitutiva .= $row[3];

                $this->especialidades .= $row[8];

            


            break;
            case 15:

                
                $this->notaria_constitutiva .= $row[1];


            # code...
            break;
            case 16:
                if(!$this->modificaciones_constitutiva){
                    $this->modificaciones_constitutiva .= $row[8];
                }

            break;
            case 17:
                break;
            case 18:

            # code...
            break;
            case 19:
            # code...
            break;
            case 20:

                $this->imss_registro .= $row[1];
                $this->capital .= $row[4];               


            # code...
            break;
            case 21:
                $this->infonavit_registro .= $row[1];    

                $this->shcp_registro .= $row[1];
                $this->otros_registro .= $row[8];

            # code...
            break;
            case 22:
                $this->email_registro .= $row[1];
            # code...
            break;
            case 23:
                $this->puesto_reviso .=  $row[3];
                $this->puesto_autoriza .= $row[8];
            break;
            case 24:  
                $this->puesto_reviso .=  $row[3];
                $this->puesto_autoriza .= $row[8];    
            break;
            case 25:
                    $this->fecha_constancia = $row[1];
                

            break;
            case 26:
                
            break;
            case 27:
                if (is_int($row[1])) {
                    $this->fecha_modificacion_registro    =      $row[1];
                }
                \Log::error( $this->fecha_modificacion_registro );
            break;
            case 28:
                $this->folio = $row[2];
                if(!$this->fecha_modificacion_registro){
                    $this->fecha_modificacion_registro    =      $row[1]; 
                }
                $this->fecha_inscripcion_registro = $row[1];
                $this->nombre_reviso .= $row[3];
                $this->folio = $row[2];
                $this->nombre_autoriza .= $row[8];
            break;
            case 29:
                $this->folio = $row[2];
                if(!$this->fecha_modificacion_registro){
                    $this->fecha_modificacion_registro    =      $row[1]; 
                }
                $this->fecha_inscripcion_registro = $row[1];
                $this->nombre_reviso .= $row[3];
                $this->folio = $row[2];
                $this->nombre_autoriza .= $row[8];
            break;
            case 30:
                if(!$this->fecha_modificacion_registro){
                    $this->fecha_modificacion_registro    =      $row[1]; 
                }
                      
                break;
            case 31:
                if(!$this->fecha_inscripcion_registro){
                    $this->fecha_inscripcion_registro = $row[1];

                }
                $this->nombre_reviso .= $row[3];
                if (!$this->folio) {
                    $this->folio = $row[2];
                }
                
                $this->nombre_autoriza .= $row[8];

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    
                
                ]);
                
                
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        }  */
        /* alforitmo 2020 v4 */
        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion = $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:
               
                $this->nombre = $row[0];

            break;
            case 7:

            break;
            case 8:
            break;

            case 9:
                # code...
            break;
            case 10:
                # code...
            break;
            case 11:
                $this->escritura_apoderado .= $row[5];

            $this->nombre_apoderado .= $row[1];
            $this->telefono .= $row[8];




            break;
            case 12:
                
                $this->fecha_apoderado = $row[5];

            # code...
            break;
            case 13:
                $this->notaria_constitutiva = $row[5];

            break;
            case 14:
                $this->escritura_apoderado = $row[1];

            break;
            case 15:
                $this->fecha_apoderado = $row[1];
                $this->modificaciones_constitutiva = $row[3];


            # code...
            break;
            case 16:
                $this->notaria_apoderado = $row[1];
                $this->especialidades = $row[8];


            break;
            case 17:

                break;
            case 18:

            # code...
            break;
            case 19:
            # code...
            break;
            case 20:

                $this->shcp_registro = $row[1];
           


            # code...
            break;
            case 21:
                $this->imss_registro = $row[1];
                $this->capital = $row[4];


            # code...
            break;
            case 22:
                $this->infonavit_registro = $row[1];
                $this->otros_registro = $row[8];

            # code...
            break;
            case 23:
                $this->email_registro = $row[1];

            break;
            case 24:  
                $this->puesto_reviso = $row[3];
                $this->puesto_autoriza = $row[8];

            break;
            case 25:
                $this->fecha_constancia = $row[1];

            break;
            case 26:
                
            break;
            case 27:
               
            break;
            case 28:
                $this->modificaciones_constitutiva = $row[1];

            break;
            case 29:
                $this->fecha_constancia = $row[1];
                $this->folio = $row[2];
                $this->nombre_apoderado = $row[3];
                $this->nombre_autoriza = $row[8];

            break;
            case 30:
               
                      
                break;
            case 31:
                

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    
                
                ]);
                
                
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */ 
        /* algoritmo 2021 v1 */
        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion .= $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:
                $this->direccion .= $row[3];

                $this->nombre = $row[0];

            break;
            case 7:
                $this->direccion .= $row[3];

            break;
            case 8:
            break;

            case 9:
                $this->nombre_apoderado .= $row[1];
                $this->escritura_constitutiva.= $row[5];
                $this->telefono .= $row[8];

            break;
            case 10:
                $this->nombre_apoderado .= $row[0];
                $this->fecha_constitutiva .= $row[5];
                $this->telefono .= $row[8];

            break;
            case 11:
                $this->nombre_apoderado .= $row[0];
                $this->notaria_constitutiva .= $row[5];
                $this->telefono .= $row[8];

            break;
            case 12:
                
                $this->escritura_apoderado .= $row[1];
                $this->escritura_apoderado .= $row[2];
                $this->modificaciones_constitutiva .= $row[5];

            # code...
            break;
            case 13:
                $this->fecha_apoderado .= $row[1];

                $this->modificaciones_constitutiva .= $row[3];

            break;
            case 14:
                $this->notaria_apoderado .= $row[1];

                $this->escritura_apoderado = $row[1];
                $this->especialidades = $row[8];


            break;
            case 15:
                
            # code...
            break;
            case 16:
               
            break;
            case 17:

                break;
            case 18:
                $this->shcp_registro = $row[1];

            # code...
            break;
            case 19:
                $this->imss_registro = $row[1];
                $this->capital = $row[4];

            break;
            case 20:

                $this->infonavit_registro = $row[1];



            # code...
            break;
            case 21:
                $this->email_registro = $row[1];

            # code...
            break;
            case 22:
                $this->puesto_reviso = $row[3];
                $this->puesto_autoriza = $row[8];

            # code...
            break;
            case 23:
                $this->fecha_constancia = $row[1];

            break;
            case 24:  
                

            break;
            case 25:

            break;
            case 26:
                $this->fecha_modificacion_registro = $row[1];

            break;
            case 27:
                $this->fecha_inscripcion_registro = $row[1];
                $this->folio = $row[2];
                $this->nombre_reviso = $row[3];
                $this->nombre_autoriza = $row[8];

            break;
            case 28:

            break;
            case 29:
               

            break;
            case 30:
               
                      
                break;
            case 31:
                

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    
                
                ]);
                
                
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */

        /* Algoritmo 2021 v2 */
        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion .= $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:
                $this->direccion .= $row[3];

                $this->nombre = $row[0];

            break;
            case 7:
                $this->direccion .= $row[3];

            break;
            case 8:
            break;

            case 9:
               
            break;
            case 10:

                

            break;
            case 11:
                $this->escritura_constitutiva .= $row[5];

                $this->telefono .= $row[8];

            break;
            case 12:
                $this->nombre_apoderado .= $row[0];

                $this->fecha_constitutiva .= $row[5];
                $this->telefono .= $row[8];


            # code...
            break;
            case 13:
                $this->notaria_constitutiva .= $row[5];

            break;
            case 14:
            
                $this->escritura_apoderado .= $row[1];


            break;
            case 15:
                $this->fecha_apoderado .= $row[1];

            # code...
            break;
            case 16:
                $this->notaria_apoderado .= $row[5];

            break;
            case 17:

                break;
            case 18:
            
            # code...
            break;
            case 19:
                $this->shcp_registro = $row[4];


            break;
            case 20:
                
                $this->imss_registro = $row[1];
                $this->capital = $row[4];

            # code...
            break;
            case 21:
                $this->infonavit_registro = $row[1];
                $this->especialidades = $row[8];

            # code...
            break;
            case 22:
                $this->email_registro = $row[1];


            # code...
            break;
            case 23:
                $this->puesto_reviso = $row[3];
                $this->puesto_autoriza = $row[8];
            break;
            case 24:  
                $this->fecha_constancia = $row[1];

                
            break;
            case 25:

            break;
            case 26:

            break;
            case 27:
                $this->fecha_modificacion_registro = $row[1];

               

            break;
            case 28:
                $this->fecha_inscripcion_registro = $row[1];
                $this->folio = $row[2];
                $this->nombre_reviso = $row[3];
                $this->nombre_autoriza = $row[8];
            break;
            case 29:
               

            break;
            case 30:
               
                      
                break;
            case 31:
                

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    
                
                ]);
                
                
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */

        /* Algoritmo 2021 v3 */

        /* switch ($this->contador) {
            case 1:
                # code...
            break;
            case 2:
                    # code...
            break;
            case 3:
                
            
            break;
            case 4:
                            # code...
            break;
            case 5:
                $this->direccion .= $row[3];
                $this->numero_registro = $row[8];

            break;
            case 6:

                $this->nombre = $row[0];

            break;
            case 7:

            break;
            case 8:
            break;

            case 9:
               
            break;
            case 10:

                

            break;
            case 11:
                $this->escritura_constitutiva .= $row[5];

                $this->telefono .= $row[8];

            break;
            case 12:
                $this->nombre_apoderado .= $row[0];

                $this->fecha_constitutiva .= is_int($row[5]) ? : null ;
                $this->telefono .= $row[8];


            # code...
            break;
            case 13:
                $this->notaria_constitutiva .= $row[5];
                $this->telefono .= $row[8];

            break;
            case 14:
            
                $this->escritura_apoderado .= $row[1];


            break;
            case 15:
                $this->fecha_apoderado .= $row[1];
                $this->modificaciones_constitutiva .= $row[3];

            # code...
            break;
            case 16:
                $this->modificaciones_constitutiva .= $row[3];
                $this->especialidades .= $row[8];

                $this->notaria_apoderado .= $row[5];

            break;
            case 17:

                break;
            case 18:
            
            # code...
            break;
            case 19:
                $this->shcp_registro = $row[4];


            break;
            case 20:
                
                $this->imss_registro = $row[1];
                $this->capital = $row[4];

            # code...
            break;
            case 21:
                $this->infonavit_registro = $row[1];
                $this->especialidades = $row[8];

            # code...
            break;
            case 22:
                $this->email_registro = $row[1];


            # code...
            break;
            case 23:
                $this->puesto_reviso = $row[3];
                $this->puesto_autoriza = $row[8];
            break;
            case 24:  
                $this->puesto_autoriza .= isset($this->puesto_autoriza) ? :null;

                $this->fecha_constancia = $row[1];

                
            break;
            case 25:

            break;
            case 26:

            break;
            case 27:
                $this->fecha_modificacion_registro = $row[1];

               

            break;
            case 28:
                $this->fecha_inscripcion_registro = $row[1];
                $this->folio = $row[2];
                $this->nombre_reviso = $row[3];
                $this->nombre_autoriza = $row[8];
            break;
            case 29:
               

            break;
            case 30:
               
                      
                break;
            case 31:
                

                return  new Newtable([
                    'folio' => (isset($this->folio)) ? $this->folio : "ILEGIBLE",
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=>  ($this->nombre_apoderado) ? : "ILEGIBLE",
                    'escritura_apoderado'=> ($this->escritura_apoderado) ? : "ILEGIBLE",
                    'fecha_apoderado'=> ( $this->fecha_apoderado) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva  ) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",    
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> ( isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : null,
                    'fecha_constancia'=> ($this->fecha_constancia ) ?  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia): "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    'email_registro'  => ($this->email_registro) ? : "ILEGIBLE",
                    'puesto_reviso'  => ($this->puesto_reviso) ? : "ILEGIBLE",
                    'nombre_reviso'  => ($this->nombre_reviso) ? : "ILEGIBLE",
                    'fecha_inscripcion_registro'  => ($this->fecha_inscripcion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_inscripcion_registro): "ILEGIBLE",
                    'fecha_modificacion_registro'  => ($this->fecha_modificacion_registro) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_modificacion_registro) : "ILEGIBLE",
                    'modificaciones_constitutiva'  => ($this->modificaciones_constitutiva) ? : "ILEGIBLE",
                    
                    
                
                ]);
                
                
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            
                break;
        } */

    }
}
