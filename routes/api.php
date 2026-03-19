<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TrabajadorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Módulo Trabajadores
|--------------------------------------------------------------------------
|
| Prefix: /api
|
*/

// Recursos de apoyo (para poblar selects)
Route::get('/cargos',    [CargoController::class,    'index']);
Route::get('/proyectos', [ProyectoController::class, 'index']);

// CRUD Trabajadores
Route::apiResource('trabajadores', TrabajadorController::class);

// Reactivar un trabajador desactivado
Route::patch('/trabajadores/{trabajador}/restaurar', [TrabajadorController::class, 'restaurar']);
