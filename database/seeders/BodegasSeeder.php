<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * BodegasSeeder
 *
 * Crea la bodega principal por defecto (id=1).
 * Todo sistema necesita al menos una bodega para poder registrar
 * movimientos de inventario, ventas y compras.
 *
 * Los valores de ciudad y departamento apuntan a Cúcuta / Norte de Santander
 * (IDs DANE oficiales del coredata) — ajustar según ubicación real.
 *
 * usuario_id: toma el primer usuario registrado (el administrador creado
 * por el script en el Paso 13).
 */
class BodegasSeeder extends Seeder
{
    public function run(): void
    {
        $now       = Carbon::now();
        $usuarioId = DB::table('users')->value('id');

        $existe = DB::table('bodegas')->where('id', 1)->exists();

        if (! $existe) {
            DB::table('bodegas')->insert([
                'id'             => 1,
                'nombre'         => 'BODEGA PRINCIPAL',
                'descripcion'    => 'Bodega principal de la empresa',
                'direccion1'     => 'SIN INFORMACION',
                'direccion2'     => null,
                'departamento_id'=> 54,     // Norte de Santander (DANE)
                'ciudad_id'      => 889,    // Cúcuta
                'activo'         => true,
                'usuario_id'     => $usuarioId,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}
