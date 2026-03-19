<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrabajadorRequest;
use App\Http\Requests\UpdateTrabajadorRequest;
use App\Models\Trabajador;
use Illuminate\Http\JsonResponse;

class TrabajadorController extends Controller
{
    /**
     * GET /api/trabajadores
     * Lista todos los trabajadores con sus relaciones.
     */
    public function index(): JsonResponse
    {
        $trabajadores = Trabajador::with(['cargo', 'proyecto'])
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get()
            ->map(fn (Trabajador $t) => $this->formatTrabajador($t));

        return response()->json([
            'success' => true,
            'data'    => $trabajadores,
        ]);
    }

    /**
     * POST /api/trabajadores
     * Registra un nuevo trabajador.
     */
    public function store(StoreTrabajadorRequest $request): JsonResponse
    {
        $trabajador = Trabajador::create($request->validated());
        $trabajador->load(['cargo', 'proyecto']);

        return response()->json([
            'success' => true,
            'message' => 'Trabajador registrado correctamente.',
            'data'    => $this->formatTrabajador($trabajador),
        ], 201);
    }

    /**
     * GET /api/trabajadores/{trabajador}
     * Retorna el detalle de un trabajador.
     */
    public function show(Trabajador $trabajador): JsonResponse
    {
        $trabajador->load(['cargo', 'proyecto']);

        return response()->json([
            'success' => true,
            'data'    => $this->formatTrabajador($trabajador),
        ]);
    }

    /**
     * PUT /api/trabajadores/{trabajador}
     * Actualiza los datos de un trabajador.
     */
    public function update(UpdateTrabajadorRequest $request, Trabajador $trabajador): JsonResponse
    {
        $trabajador->update($request->validated());
        $trabajador->load(['cargo', 'proyecto']);

        return response()->json([
            'success' => true,
            'message' => 'Trabajador actualizado correctamente.',
            'data'    => $this->formatTrabajador($trabajador),
        ]);
    }

    /**
     * DELETE /api/trabajadores/{trabajador}
     * Desactiva (baja lógica) al trabajador.
     */
    public function destroy(Trabajador $trabajador): JsonResponse
    {
        $trabajador->update(['activo' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Trabajador desactivado correctamente.',
        ]);
    }

    /**
     * PATCH /api/trabajadores/{trabajador}/restaurar
     * Reactiva un trabajador previamente desactivado.
     */
    public function restaurar(Trabajador $trabajador): JsonResponse
    {
        $trabajador->update(['activo' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Trabajador reactivado correctamente.',
        ]);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function formatTrabajador(Trabajador $t): array
    {
        return [
            'id'          => $t->id,
            'nombre'      => $t->nombre,
            'apellido'    => $t->apellido,
            'nombre_completo' => "{$t->apellido}, {$t->nombre}",
            'dni'         => $t->dni,
            'email'       => $t->email,
            'telefono'    => $t->telefono,
            'cargo_id'    => $t->cargo_id,
            'cargo'       => $t->cargo?->nombre,
            'proyecto_id' => $t->proyecto_id,
            'proyecto'    => $t->proyecto?->nombre,
            'activo'      => $t->activo,
            'created_at'  => $t->created_at?->format('d/m/Y H:i'),
            'updated_at'  => $t->updated_at?->format('d/m/Y H:i'),
        ];
    }
}
