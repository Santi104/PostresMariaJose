<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Empleado',
            'usuario' => 'empleado',
            'password' => Hash::make('123456'),
            'activo' => true,
        ]);
    }
}