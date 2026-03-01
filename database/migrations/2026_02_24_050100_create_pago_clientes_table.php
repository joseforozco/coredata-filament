<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: pago_clientes
 *
 * Correcciones vs original:
 *   - La tabla original estaba COMPLETAMENTE VACÍA (solo id + timestamps)
 *   - Implementación completa del módulo de cartera / cuentas por cobrar
 *
 * Registra cada pago recibido de un cliente contra una o varias ventas.
 *
 * Una venta puede tener múltiples pagos parciales.
 * Un pago puede aplicarse a múltiples ventas (abono general).
 *
 * Para simplificar: cada registro de pago_clientes se asocia a UNA venta.
 * Si el pago cubre varias ventas, se crean varios registros.
 *
 * numero: consecutivo del recibo de caja
 * monto: valor recibido en este pago
 * banco_id: nullable — solo aplica si la forma_pago requiere banco
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pago_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onDelete('restrict');
            $table->foreignId('venta_id')
                  ->nullable()
                  ->constrained('ventas')
                  ->onDelete('restrict')
                  ->comment('Nullable para permitir pagos anticipados sin venta asociada');
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

            $table->index('cliente_id',  'pagocli_cliente_idx');
            $table->index('venta_id',    'pagocli_venta_idx');
            $table->index('fecha',       'pagocli_fecha_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago_clientes');
    }
};
