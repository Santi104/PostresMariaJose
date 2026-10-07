<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;


    protected $table = 'ventas';


    protected $fillable = [
        'turno_caja_id',
        'usuario_id',
        'numero',
        'fecha',
        'subtotal',
        'descuento',
        'total',
        'estado',
        'motivo_anulacion',
        'anulada_por',
        'fecha_anulacion'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'fecha_anulacion' => 'datetime',
    ];
}