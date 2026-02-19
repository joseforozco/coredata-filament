<?php

namespace Database\Seeders\ciudades;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BogotaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos el ID del departamento "BOGOTÁ, D.C."
        $departamentoId = DB::table('departamentos')->where('nombre', 'BOGOTÁ, D.C.')->value('id');

        DB::table('ciudades')->insert([
            [
                'nombre' => 'BOGOTÁ',
                'departamentosId' => $departamentoId,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        $this->command->info('Se insertó la ciudad BOGOTÁ.');
    }
}
