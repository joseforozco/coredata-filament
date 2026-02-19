<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Obtenemos el ID del usuario Admin (primer usuario creado en UserSeeder)
        $usuarioId = DB::table('users')->value('id');


        DB::table('clientes')->insert([
            [
                'id' => 1,
                'nombre' => 'CLIENTES VARIOS',
                'documento' => '999999999',
                'tipo_documento' => 'CC',
                'telefono' => '9999999999',
                'email' => 'no_tiene_correo@correo.com',
                'direccion1' => 'SIN INFORMACION',
                'direccion2' => null,
                'ciudadesId' => 889, // Cúcuta
                'departamentosId' => 54, // Norte de Santander
                'pais' => 'Colombia',
                'activo' => true,
                'limite_credito' => 0.00,
                'dias_credito' => 0,
                'contacto_principal' => null,
                'usuarioId' => $usuarioId, // Asignamos el ID del usuario
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
