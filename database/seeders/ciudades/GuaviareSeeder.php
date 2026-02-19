<?php

namespace Database\Seeders\ciudades;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuaviareSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos el ID del departamento
        $departamentoId = DB::table('departamentos')->where('nombre', 'GUAVIARE')->value('id');

        if (!$departamentoId) {
            $this->command->error('No se encontró el departamento "GUAVIARE" en la tabla "departamentos".');
            return;
        }

        $ciudades = [
            'SAN JOSÉ DEL GUAVIARE',
            'CALAMAR',
            'EL RETORNO',
            'MIRAFLORES',
            'PUERTO SANTANDER',
            'LAURELES',
            'CUMARAL',
            'SAN FELIPE',
            'BARRANCA DE UPIA',
            'CABUYARO'
        ];

        foreach ($ciudades as $ciudad) {
            DB::table('ciudades')->insert([
                'nombre' => $ciudad,
                'departamentosId' => $departamentoId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->command->info(count($ciudades) . ' ciudades insertadas en el departamento del Guaviare.');
    }
}
