<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrabajadoresSeeder extends Seeder
{
    public function run(): void
    {
        // Cargos
        $cargos = [
            ['nombre' => 'Desarrollador Backend'],
            ['nombre' => 'Desarrollador Frontend'],
            ['nombre' => 'Diseñador UX/UI'],
            ['nombre' => 'Analista de QA'],
            ['nombre' => 'Project Manager'],
            ['nombre' => 'DevOps Engineer'],
            ['nombre' => 'Analista de Datos'],
        ];

        DB::table('cargos')->insert($cargos);

        // Proyectos
        $proyectos = [
            ['nombre' => 'Portal Web Corporativo',   'descripcion' => 'Rediseño del portal web principal de la empresa.'],
            ['nombre' => 'App Móvil de Ventas',      'descripcion' => 'Aplicación móvil para el equipo de ventas externo.'],
            ['nombre' => 'Sistema ERP Interno',      'descripcion' => 'Módulos de gestión interna de recursos empresariales.'],
            ['nombre' => 'Plataforma E-commerce',    'descripcion' => 'Tienda en línea con integración de pasarelas de pago.'],
            ['nombre' => 'Data Warehouse Reporting', 'descripcion' => 'Centralización y análisis de datos operativos.'],
        ];

        DB::table('proyectos')->insert($proyectos);

        // Trabajadores
        $trabajadores = [
            [
                'nombre'      => 'Carlos',
                'apellido'    => 'Ramírez',
                'dni'         => '12345678',
                'email'       => 'c.ramirez@empresa.com',
                'telefono'    => '987654321',
                'cargo_id'    => 1,
                'proyecto_id' => 1,
                'activo'      => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Ana',
                'apellido'    => 'Torres',
                'dni'         => '23456789',
                'email'       => 'a.torres@empresa.com',
                'telefono'    => '976543210',
                'cargo_id'    => 2,
                'proyecto_id' => 1,
                'activo'      => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Luis',
                'apellido'    => 'Mendoza',
                'dni'         => '34567890',
                'email'       => 'l.mendoza@empresa.com',
                'telefono'    => '965432109',
                'cargo_id'    => 5,
                'proyecto_id' => 2,
                'activo'      => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'María',
                'apellido'    => 'García',
                'dni'         => '45678901',
                'email'       => 'm.garcia@empresa.com',
                'telefono'    => '954321098',
                'cargo_id'    => 3,
                'proyecto_id' => 4,
                'activo'      => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Pedro',
                'apellido'    => 'Quispe',
                'dni'         => '56789012',
                'email'       => 'p.quispe@empresa.com',
                'telefono'    => '943210987',
                'cargo_id'    => 4,
                'proyecto_id' => 3,
                'activo'      => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('trabajadores')->insert($trabajadores);
    }
}
