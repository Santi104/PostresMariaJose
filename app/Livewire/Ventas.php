<?php

namespace App\Livewire;

use Livewire\Component;

class Ventas extends Component
{
    public string $busqueda = '';

    public string $categoria = 'Todos';

    public array $productos = [
        [
            'nombre' => 'Merengón clásico',
            'categoria' => 'Postres',
            'precio' => 8000,
            'estado' => 'Disponible',
            'imagen' => 'foto merengón',
        ],
        [
            'nombre' => 'Merengón de frutos rojos',
            'categoria' => 'Postres',
            'precio' => 10500,
            'estado' => 'Bajo stock',
            'imagen' => 'foto merengón frutos',
        ],
        [
            'nombre' => 'Fresas con crema',
            'categoria' => 'Postres',
            'precio' => 9000,
            'estado' => 'Disponible',
            'imagen' => 'foto fresas',
        ],
        [
            'nombre' => 'Postre de Milo',
            'categoria' => 'Postres',
            'precio' => 9500,
            'estado' => 'Disponible',
            'imagen' => 'foto postre milo',
        ],
        [
            'nombre' => 'Oblea sencilla',
            'categoria' => 'Postres',
            'precio' => 5000,
            'estado' => 'Disponible',
            'imagen' => 'foto oblea',
        ],
        [
            'nombre' => 'Oblea especial',
            'categoria' => 'Postres',
            'precio' => 7500,
            'estado' => 'Bajo stock',
            'imagen' => 'foto oblea especial',
        ],
        [
            'nombre' => 'Torta de zanahoria · porción',
            'categoria' => 'Tortas',
            'precio' => 7500,
            'estado' => 'Disponible',
            'imagen' => 'foto torta',
        ],
        [
            'nombre' => 'Torta tres leches · porción',
            'categoria' => 'Tortas',
            'precio' => 8500,
            'estado' => 'Bajo stock',
            'imagen' => 'foto torta',
        ],
        [
            'nombre' => 'Torta de chocolate · porción',
            'categoria' => 'Tortas',
            'precio' => 8000,
            'estado' => 'Disponible',
            'imagen' => 'foto torta',
        ],
        [
            'nombre' => 'Agua botella 600 ml',
            'categoria' => 'Bebidas',
            'precio' => 2500,
            'estado' => 'Disponible',
            'imagen' => 'foto agua',
        ],
        [
            'nombre' => 'Gaseosa personal',
            'categoria' => 'Bebidas',
            'precio' => 4000,
            'estado' => 'Disponible',
            'imagen' => 'foto gaseosa',
        ],
    ];

    public array $carrito = [
        [
            'nombre' => 'Merengón clásico',
            'precio' => 8000,
            'cantidad' => 4,
        ],
        [
            'nombre' => 'Agua botella 600 ml',
            'precio' => 2500,
            'cantidad' => 3,
        ],
        [
            'nombre' => 'Oblea sencilla',
            'precio' => 5000,
            'cantidad' => 1,
        ],
    ];

    public function getProductosFiltradosProperty(): array
    {
        return array_values(
            array_filter($this->productos, function ($producto) {

                $categoria = $this->categoria === 'Todos'
                    || $producto['categoria'] === $this->categoria;

                $busqueda = $this->busqueda === ''
                    || str_contains(
                        strtolower($producto['nombre']),
                        strtolower($this->busqueda)
                    );

                return $categoria && $busqueda;
            })
        );
    }

    public function agregarAlCarrito($nombre)
    {
        foreach ($this->carrito as &$item) {

            if ($item['nombre'] === $nombre) {
                $item['cantidad']++;
                return;
            }
        }

        foreach ($this->productos as $producto) {

            if ($producto['nombre'] === $nombre) {

                $this->carrito[] = [
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => 1,
                ];

                return;
            }
        }
    }

    public function aumentar($index)
    {
        $this->carrito[$index]['cantidad']++;
    }

    public function disminuir($index)
    {
        if ($this->carrito[$index]['cantidad'] > 1) {
            $this->carrito[$index]['cantidad']--;
        } else {
            unset($this->carrito[$index]);
            $this->carrito = array_values($this->carrito);
        }
    }

    public function quitar($index)
    {
        unset($this->carrito[$index]);

        $this->carrito = array_values($this->carrito);
    }

    public function vaciar()
    {
        $this->carrito = [];
    }

    public function getTotalProperty(): int
    {
        return array_reduce(
            $this->carrito,
            fn ($total, $item) =>
                $total + ($item['precio'] * $item['cantidad']),
            0
        );
    }

    public function getUnidadesProperty(): int
    {
        return array_reduce(
            $this->carrito,
            fn ($total, $item) =>
                $total + $item['cantidad'],
            0
        );
    }

    public function render()
    {
        return view('livewire.ventas');
    }
}