<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            ['nombre' => 'Desarrollador Backend'],
            ['nombre' => 'Desarrollador Frontend'],
            ['nombre' => 'Diseñador UX/UI'],
            ['nombre' => 'Analista de QA'],
            ['nombre' => 'Project Manager'],
            ['nombre' => 'DevOps Engineer'],
            ['nombre' => 'Analista de Datos'],
        ];

        // insertOrIgnore evita duplicados si el seeder se ejecuta más de una vez
        foreach ($cargos as $cargo) {
            DB::table('cargos')->insertOrIgnore([
                'nombre'     => $cargo['nombre'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
