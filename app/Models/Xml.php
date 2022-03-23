<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xml extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'uuid',
        'sellosat',
        'fechatimbrado',
        'sellocfd',
        'nocertificadosat',
        'rfcprovcertif',
        'folio',
        'fecha',
        'sello',
        'formapago',
        'nocertificado',
        'certificado',
        'subtotal',
        'descuento',
        'moneda',
        'total',
        'tipodecomprobante',
        'metodopago',
        'lugarexpedicion',
        'nomina_emisor_registropatronal',
        'nomina_emisor_origenrecurso',
        'nomina_fechapago',
        'nomina_fechainicialpago',
        'nomina_fechafinalpago',
        'nomina_numdiaspagados',
        'nomina_totalpercepciones',
        'nomina_totaldeducciones',
        'nomina_totalotrospagos',
        'nomina_receptor_curp',
        'nomina_receptor_numseguridadsocial',
        'nomina_receptor_fechainiciorellaboral',
        'nomina_receptor_antiguedad',
        'nomina_receptor_tipocontrato',
        'nomina_receptor_tiporegimen',
        'nomina_receptor_numempleado',
        'nomina_receptor_departamento',
        'nomina_receptor_puesto',
        'nomina_receptor_riesgopuesto',
        'nomina_receptor_periodicidadpago',
        'nomina_receptor_salariodiariointegrado',
        'nomina_receptor_claveentfed',
        'conceptos_claveprodserv',
        'conceptos_cantidad',
        'conceptos_claveunidad',
        'conceptos_descripcion',
        'conceptos_valorunitario',
        'conceptos_importe',
        'conceptos_descuento',
        'emisor_rfc',
        'emisor_nombre',
        'emisor_regimenfiscal',
        'receptor_rfc',
        'receptor_nombre',
        'receptor_usocfdi',
        'nomina_percepciones_totalsueldos',
        'nomina_percepciones_totalgravado',
        'nomina_percepciones_totalexento',
        'nomina_deducciones_totalotrasdeducciones',
        'nomina_deducciones_totalimpuestosretenidos',
    ];
}

