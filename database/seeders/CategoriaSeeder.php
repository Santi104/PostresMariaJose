<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Postres',
            'Merengones',
            'Obleas',
            'Bebidas',
            'Tortas',
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate([
                'nombre' => $nombre,
            ], [
                'activo' => true,
            ]);
        }
    }
}
