<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $usuarioId = DB::table('users')->value('id');

        DB::table('proveedores')->insert([
            [
                'id' => 1,
                'nombre' => 'PROVEEDORES VARIOS',
                'documento' => '9999999999',
                'tipo_documento' => 'NIT',
                'telefono' => '999999999',
                'email' => 'no_tiene_correo@correo.com',
                'direccion1' => 'SIN INFORMACION',
                'direccion2' => null,
                'ciudadesId' => 889, // Cúcuta
                'departamentosId' => 54, // Norte de Santander
                'pais' => 'Colombia',
                'activo' => true,
                'dias_pago' => 0,
                'contacto_principal' => null,
                'sitio_web' => null,
                'usuarioId' => $usuarioId, // Asignamos el ID del usuario
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}