<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * NumeracionesSeeder
 *
 * Crea un registro de numeración por cada tipo de documento para el año actual.
 * El consecutivo_actual inicia en 0 — el primer documento generado será el 1.
 *
 * Prefijos por defecto (el usuario los puede modificar desde el panel):
 *   FA → Factura de venta
 *   CO → Compra / Orden de compra
 *   CT → Cotización
 *   RE → Remisión
 *   PC → Pago cliente (recibo de caja)
 *   PP → Pago proveedor (comprobante de egreso)
 *
 * El rango hasta 9999999 es suficiente para cualquier empresa Pyme.
 * Para resolver DIAN se ajusta consecutivo_desde y consecutivo_hasta
 * con los valores de la resolución de facturación.
 */
class NumeracionesSeeder extends Seeder
{
    public function run(): void
    {
        $now  = Carbon::now();
        $anno = (int) date('Y');

        $numeraciones = [
            ['tipo_documento' => 'venta',            'prefijo' => 'FA', 'descripcion' => 'Factura de venta'],
            ['tipo_documento' => 'compra',            'prefijo' => 'CO', 'descripcion' => 'Orden de compra'],
            ['tipo_documento' => 'cotizacion',        'prefijo' => 'CT', 'descripcion' => 'Cotización'],
            ['tipo_documento' => 'remision',          'prefijo' => 'RE', 'descripcion' => 'Remisión'],
            ['tipo_documento' => 'pago_cliente',      'prefijo' => 'PC', 'descripcion' => 'Recibo de caja'],
            ['tipo_documento' => 'pago_proveedor',    'prefijo' => 'PP', 'descripcion' => 'Comprobante de egreso'],
        ];

        foreach ($numeraciones as $num) {
            $existe = DB::table('numeraciones')
                ->where('tipo_documento', $num['tipo_documento'])
                ->where('anno', $anno)
                ->exists();

            if (! $existe) {
                DB::table('numeraciones')->insert([
                    'tipo_documento'       => $num['tipo_documento'],
                    'prefijo'              => $num['prefijo'],
                    'consecutivo_desde'    => 1,
                    'consecutivo_hasta'    => 9999999,
                    'consecutivo_actual'   => 0,
                    'anno'                 => $anno,
                    'activo'               => true,
                    'created_at'           => $now,
                    'updated_at'           => $now,
                ]);
            }
        }
    }
}
