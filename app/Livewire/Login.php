<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Login extends Component
{
    public $usuario = '';
    public $password = '';
    public $recordar = false;

    public function login()
    {
        $credenciales = $this->validate([
            'usuario' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'usuario.required' => 'Ingrese su usuario.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        if (
            Auth::attempt(
                [
                    'usuario' => $credenciales['usuario'],
                    'password' => $credenciales['password'],
                    'activo' => true,
                ],
                $this->recordar
            )
        ) {
            session()->regenerate();

            return redirect()->intended(route('inicio'));
        }

        $this->addError(
            'usuario',
            'El usuario o la contraseña son incorrectos.'
        );
    }

    public function render()
    {
        return view('livewire.login');
    }
}