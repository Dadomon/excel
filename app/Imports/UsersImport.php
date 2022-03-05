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
        dump($this->contador);
        dump($row);
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
                $this->direccion .= $row[3];
                
            break;
            case 12:
                $this->nombre_apoderado .= $row[1];
                $this->escritura_apoderado .= $row[5];
                $this->telefono .= $row[8];

                # code...
            break;
            case 13:
                $this->fecha_apoderado .= $row[5];
                # code...
            break;
            case 14:
                $this->notaria_apoderado .= $row[5];
                # code...
            break;
            case 15:
                $this->escritura_constitutiva .= $row[1];
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
                $this->especialidades .= $row[8];
                $this->shcp_registro .= $row[1];

                # code...
            break;
            case 22:
                $this->imss_registro .= $row[1];
                # code...
            break;
            case 23:
                $this->infonavit_registro .= $row[1];
                $this->capital .= $row[5];

                # code...
            break;
            case 24:
                                                                                                            # code...
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
                    'folio' => $this->folio,
                    'nombre'=> $this->nombre,
                    'direccion'=> $this->direccion,
                    'numero_registro'=> $this->numero_registro,
                    'nombre_apoderado'=> $this->nombre_apoderado,
                    'escritura_apoderado'=> $this->escritura_apoderado,
                    'fecha_apoderado'=> date("Y-m-d",$this->fecha_apoderado),
                    'notaria_apoderado' => $this->notaria_apoderado,
                    'escritura_constitutiva'=> $this->escritura_constitutiva,
                    'fecha_constitutiva'=> date("Y-m-d",$this->fecha_constitutiva),
                    'notaria_constitutiva'=> $this->notaria_constitutiva,
                    'shcp_registro'=> $this->shcp_registro,
                    'imss_registro'=> $this->imss_registro,
                    'infonavit_registro'=> $this->infonavit_registro,
                    'otros_registro'=> $this->otros_registro,
                    'capital'=> $this->capital,
                    'fecha_constancia'=> date("Y-m-d", $this->fecha_constancia),
                    'invitaciones_restringidas'=> $this->invitaciones_restringidas,
                    'puesto_autoriza'=> $this->puesto_autoriza,
                    'nombre_autoriza'=> $this->nombre_autoriza,
                    'telefono'=> $this->telefono,
                    'especialidades'  => $this->especialidades,
                    ]);                          # code...
            break;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            default:
            \Log::error('Sin opcion');
                break;
        }
        
    }
}
