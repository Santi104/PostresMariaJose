<?php

namespace App\Livewire;

use Livewire\Component;

class Produccion extends Component
{
    public array $producciones = [
        [
            'producto' => 'Merengón clásico',
            'cantidad' => 120,
            'stock' => 12,
            'precio' => 8000,
        ],
        [
            'producto' => 'Fresas con crema',
            'cantidad' => 20,
            'stock' => 8,
            'precio' => 9000,
        ],
        [
            'producto' => 'Oblea sencilla',
            'cantidad' => 30,
            'stock' => 0,
            'precio' => 5000,
        ],
        [
            'producto' => 'Postre de Milo',
            'cantidad' => 40,
            'stock' => 6,
            'precio' => 9500,
        ],
    ];

    public function aumentar($index)
    {
        $this->producciones[$index]['cantidad']++;
    }

    public function disminuir($index)
    {
        if ($this->producciones[$index]['cantidad'] > 1) {
            $this->producciones[$index]['cantidad']--;
        }
    }

    public function eliminar($index)
    {
        unset($this->producciones[$index]);

        $this->producciones = array_values($this->producciones);
    }

    public function agregarProducto()
    {
        $this->producciones[] = [
            'producto' => 'Nuevo producto',
            'cantidad' => 1,
            'stock' => 0,
            'precio' => 0,
        ];
    }

    public function limpiar()
    {
        $this->producciones = [];
    }

    public function getTotalUnidadesProperty(): int
    {
        return array_sum(
            array_column($this->producciones, 'cantidad')
        );
    }

    public function render()
    {
        return view('livewire.produccion');
    }
}