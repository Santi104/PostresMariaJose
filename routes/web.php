<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Login;
use App\Livewire\Dashboard;
use App\Livewire\CreateUser;

Route::get('/login', Login::class)
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/', Dashboard::class)
    ->middleware('auth')
    ->name('inicio');

Route::get('/usuarios/crear', CreateUser::class)
    ->middleware('auth')
    ->name('usuarios.crear');