<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: numeraciones  (NUEVA — no existía en el original)
 *
 * Controla los consecutivos de cada tipo de documento por año.
 * Indispensable para el contexto colombiano (DIAN).
 *
 * tipo_documento: venta, compra, cotizacion, remision, pago_cliente, pago_proveedor
 * prefijo: FA, CO, RE, CT, PC, PP  (configurable por empresa)
 * consecutivo_actual: se incrementa con cada documento creado
 * consecutivo_desde / hasta: rango autorizado (resolución DIAN para facturas)
 * anno: permite reiniciar consecutivos cada año fiscal
 *
 * Uso en código:
 *   $num = Numeracion::where('tipo_documento', 'venta')->lockForUpdate()->first();
 *   $numero = $num->prefijo . str_pad($num->consecutivo_actual + 1, 6, '0', STR_PAD_LEFT);
 *   $num->increment('consecutivo_actual');
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('numeraciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_documento', [
                'venta', 'compra', 'cotizacion', 'remision',
                'pago_cliente', 'pago_proveedor'
            ]);
            $table->string('prefijo', 10)->default('');
            $table->unsignedInteger('consecutivo_desde')->default(1);
            $table->unsignedInteger('consecutivo_hasta')->default(9999999);
            $table->unsignedInteger('consecutivo_actual')->default(0);
            $table->unsignedSmallInteger('anno');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Un solo registro activo por tipo de documento por año
            $table->unique(['tipo_documento', 'anno'], 'numeraciones_tipo_anno_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('numeraciones');
    }
};
