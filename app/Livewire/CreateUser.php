<?php

namespace App\Livewire;

use App\Models\Usuario;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CreateUser extends Component
{
    public $nombre = '';
    public $usuario = '';
    public $correo = '';
    public $password = '';
    public $password_confirmation = '';
    public $activo = true;

    public $exito = false;

    public function guardar()
    {
        $datos = $this->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'usuario' => ['required', 'string', 'max:50', Rule::unique('usuarios', 'usuario')],
            'correo' => ['required', 'email', 'max:150', Rule::unique('usuarios', 'correo')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'activo' => ['boolean'],
        ], [
            'nombre.required' => 'Ingrese el nombre completo.',
            'usuario.required' => 'Ingrese un usuario.',
            'usuario.unique' => 'Ese usuario ya está en uso.',
            'correo.required' => 'Ingrese un correo.',
            'correo.email' => 'Ingrese un correo válido.',
            'correo.unique' => 'Ese correo ya está registrado.',
            'password.required' => 'Ingrese una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        Usuario::create([
            'nombre' => $datos['nombre'],
            'usuario' => $datos['usuario'],
            'correo' => $datos['correo'],
            'password' => $datos['password'],
            'activo' => $datos['activo'],
        ]);

        $this->reset(['nombre', 'usuario', 'correo', 'password', 'password_confirmation', 'activo']);
        $this->activo = true;
        $this->exito = true;
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}