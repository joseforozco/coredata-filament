<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepartamentosSeeder::class,
            CiudadesSeeder::class,
            ClientesSeeder::class,
            ProveedoresSeeder::class,
        ]);
    }
}
