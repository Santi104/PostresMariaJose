<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Login;
use App\Livewire\Dashboard;
use App\Livewire\CreateUser;
use App\Livewire\Productos;
use App\Livewire\Ventas;
use App\Livewire\Inventario;
use App\Livewire\Produccion;

Route::get('/login', Login::class)->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {

    // Inicio
    Route::get('/', Dashboard::class)->name('inicio');

    Route::get('/ventas', Ventas::class)->name('ventas');

    Route::get('/inventario', Inventario::class)->name('inventario');

    Route::get('/produccion', Produccion::class)->name('produccion');

    // Productos
    Route::get('/productos', Productos::class)->name('productos');

    // Crear usuario
    Route::get('/usuarios/crear', CreateUser::class)
        ->name('usuarios.crear');

});
