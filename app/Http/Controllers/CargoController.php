<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\JsonResponse;

class CargoController extends Controller
{
    /**
     * GET /api/cargos
     * Retorna la lista de cargos para poblar selects en el frontend.
     */
    public function index(): JsonResponse
    {
        $cargos = Cargo::orderBy('nombre')->get(['id', 'nombre']);

        return response()->json([
            'success' => true,
            'data'    => $cargos,
        ]);
    }
}
