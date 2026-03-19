<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\JsonResponse;

class ProyectoController extends Controller
{
    /**
     * GET /api/proyectos
     * Retorna la lista de proyectos para poblar selects en el frontend.
     */
    public function index(): JsonResponse
    {
        $proyectos = Proyecto::orderBy('nombre')->get(['id', 'nombre']);

        return response()->json([
            'success' => true,
            'data'    => $proyectos,
        ]);
    }
}
