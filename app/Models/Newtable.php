<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newtable extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [

        'folio',
        'nombre',
        'direccion',
        'numero_registro',
        'nombre_apoderado',
        'escritura_apoderado',
        'fecha_apoderado',
        'notaria_apoderado',
        'escritura_constitutiva',
        'fecha_constitutiva',
        'notaria_constitutiva',
        'shcp_registro',
        'imss_registro',
        'infonavit_registro',
        'otros_registro',
        'capital',
        'fecha_constancia',
        'invitaciones_restringidas',
        'puesto_autoriza',
        'nombre_autoriza',
        'telefono',
        'especialidades'
    ];
    
}
