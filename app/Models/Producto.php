<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'precio_venta',
        'costo_unitario',
        'stock_minimo',
        'imagen',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio_venta' => 'decimal:2',
            'costo_unitario' => 'decimal:2',
            'stock_actual' => 'integer',
            'stock_minimo' => 'integer',
            'activo' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
