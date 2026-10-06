<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public string $modulo = 'dashboard';

    #[On('cambiarModulo')]
    public function cambiarModulo(string $modulo)
    {
        $this->modulo = $modulo;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}