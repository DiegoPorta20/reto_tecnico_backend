<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectosSeeder extends Seeder
{
    public function run(): void
    {
        $proyectos = [
            ['nombre' => 'Portal Web Corporativo',   'descripcion' => 'Rediseño del portal web principal de la empresa.'],
            ['nombre' => 'App Móvil de Ventas',      'descripcion' => 'Aplicación móvil para el equipo de ventas externo.'],
            ['nombre' => 'Sistema ERP Interno',      'descripcion' => 'Módulos de gestión interna de recursos empresariales.'],
            ['nombre' => 'Plataforma E-commerce',    'descripcion' => 'Tienda en línea con integración de pasarelas de pago.'],
            ['nombre' => 'Data Warehouse Reporting', 'descripcion' => 'Centralización y análisis de datos operativos.'],
        ];

        // insertOrIgnore evita duplicados si el seeder se ejecuta más de una vez
        foreach ($proyectos as $proyecto) {
            DB::table('proyectos')->insertOrIgnore([
                'nombre'      => $proyecto['nombre'],
                'descripcion' => $proyecto['descripcion'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
