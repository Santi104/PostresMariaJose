<?php

namespace App\Livewire;

use Livewire\Component;

class Productos extends Component
{
    public string $busqueda = '';

    public string $categoria = 'Todas las categorías';

    public array $productos = [
        [
            'nombre' => 'Merengón clásico',
            'sku' => 'SKU-MER-CLA',
            'categoria' => 'Postres',
            'precio' => 8000,
            'stock' => 12,
            'minimo' => 10,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Merengón de frutos rojos',
            'sku' => 'SKU-MER-FRU',
            'categoria' => 'Postres',
            'precio' => 10500,
            'stock' => 3,
            'minimo' => 6,
            'estado' => 'Bajo stock',
        ],

        [
            'nombre' => 'Fresas con crema',
            'sku' => 'SKU-FRE-CRE',
            'categoria' => 'Postres',
            'precio' => 9000,
            'stock' => 8,
            'minimo' => 6,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Postre de Milo',
            'sku' => 'SKU-MIL',
            'categoria' => 'Postres',
            'precio' => 9500,
            'stock' => 6,
            'minimo' => 5,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Oblea sencilla',
            'sku' => 'SKU-OBL-SEN',
            'categoria' => 'Postres',
            'precio' => 5000,
            'stock' => 0,
            'minimo' => 10,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Oblea especial',
            'sku' => 'SKU-OBL-ESP',
            'categoria' => 'Postres',
            'precio' => 7500,
            'stock' => 2,
            'minimo' => 6,
            'estado' => 'Bajo stock',
        ],

        [
            'nombre' => 'Torta de zanahoria · porción',
            'sku' => 'SKU-TOR-ZAN',
            'categoria' => 'Tortas',
            'precio' => 7500,
            'stock' => 9,
            'minimo' => 4,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Torta tres leches · porción',
            'sku' => 'SKU-TOR-TRE',
            'categoria' => 'Tortas',
            'precio' => 8500,
            'stock' => 4,
            'minimo' => 6,
            'estado' => 'Bajo stock',
        ],

        [
            'nombre' => 'Torta de chocolate · porción',
            'sku' => 'SKU-TOR-CHO',
            'categoria' => 'Tortas',
            'precio' => 8000,
            'stock' => 7,
            'minimo' => 4,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Torta entera de maracuyá',
            'sku' => 'SKU-TOR-MAR',
            'categoria' => 'Tortas',
            'precio' => 95000,
            'stock' => 0,
            'minimo' => 1,
            'estado' => 'Agotado',
        ],

        [
            'nombre' => 'Agua botella 600 ml',
            'sku' => 'SKU-AGU',
            'categoria' => 'Bebidas',
            'precio' => 2500,
            'stock' => 48,
            'minimo' => 24,
            'estado' => 'Disponible',
        ],

        [
            'nombre' => 'Gaseosa personal',
            'sku' => 'SKU-GAS',
            'categoria' => 'Bebidas',
            'precio' => 4000,
            'stock' => 30,
            'minimo' => 12,
            'estado' => 'Disponible',
        ],
    ];

    public function getProductosFiltradosProperty(): array
    {
        return array_values(
            array_filter($this->productos, function ($producto) {

                $coincideCategoria =
                    $this->categoria === 'Todas las categorías'
                    || $producto['categoria'] === $this->categoria;

                $coincideBusqueda =
                    $this->busqueda === ''
                    || str_contains(
                        strtolower($producto['nombre']),
                        strtolower($this->busqueda)
                    )
                    || str_contains(
                        strtolower($producto['sku']),
                        strtolower($this->busqueda)
                    );

                return $coincideCategoria && $coincideBusqueda;
            })
        );
    }

    public function render()
    {
        return view('livewire.productos');
    }
}