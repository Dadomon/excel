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
    public function model(array $row)
    {   
        $this->contador ++;
        switch ($this->contador) {
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
                    'fecha_apoderado'=> ($this->fecha_apoderado )? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_apoderado) : "ILEGIBLE",
                    'notaria_apoderado' => ($this->notaria_apoderado) ? : "ILEGIBLE",
                    'escritura_constitutiva'=> ($this->escritura_constitutiva) ? : "ILEGIBLE",
                    'fecha_constitutiva'=> ($this->fecha_constitutiva) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constitutiva) : "ILEGIBLE",
                    'notaria_constitutiva'=> ($this->notaria_constitutiva) ? : "ILEGIBLE",
                    'shcp_registro'=> ($this->shcp_registro) ? : "ILEGIBLE",
                    'imss_registro'=> ($this->imss_registro) ? : "ILEGIBLE",
                    'infonavit_registro'=> ($this->infonavit_registro) ? : "ILEGIBLE",
                    'otras_especialidades'=> (isset($this->otros_registro) || empty($this->otros_registro)) ? $this->otros_registro : "ILEGIBLE" ,
                    'capital'=> ($this->capital) ? : "ILEGIBLE",
                    'fecha_constancia'=> ($this->fecha_constancia) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->fecha_constancia) : "ILEGIBLE",
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> ($this->puesto_autoriza) ? : "ILEGIBLE",
                    'nombre_autoriza'=> ($this->nombre_autoriza) ? : "ILEGIBLE",
                    'telefono'=> ($this->telefono) ? : "ILEGIBLE",
                    'especialidades'  => ($this->especialidades) ? : "ILEGIBLE",
                    ]);                          # code...
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            \Log::error('Sin opcion');
                break;
        }
        
    }
}
