<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: pago_proveedores
 *
 * Correcciones vs original:
 *   - Nombre: pago_proveedors → pago_proveedores  (error de ortografía en el original)
 *   - La tabla original estaba COMPLETAMENTE VACÍA (solo id + timestamps)
 *   - Implementación completa del módulo de cuentas por pagar
 *
 * Registra cada pago realizado a un proveedor contra una orden de compra.
 * Estructura simétrica a pago_clientes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pago_proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();
            $table->foreignId('proveedor_id')
                  ->constrained('proveedores')
                  ->onDelete('restrict');
            $table->foreignId('compra_id')
                  ->nullable()
                  ->constrained('compras')
                  ->onDelete('restrict')
                  ->comment('Nullable para permitir anticipos sin compra asociada');
            $table->foreignId('forma_pago_id')
                  ->constrained('formas_pago')
                  ->onDelete('restrict');
            $table->foreignId('banco_id')
                  ->nullable()
                  ->constrained('bancos')
                  ->onDelete('set null');
            $table->foreignId('usuario_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamp('fecha')->useCurrent();
            $table->decimal('monto', 15, 2);
            $table->string('referencia', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('proveedor_id', 'pagopro_proveedor_idx');
            $table->index('compra_id',    'pagopro_compra_idx');
            $table->index('fecha',        'pagopro_fecha_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago_proveedores');
    }
};
