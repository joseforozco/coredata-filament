<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: compras
 *
 * Correcciones vs original:
 *   - proveedorId → proveedor_id  (snake_case)
 *   - Agregado: numero
 *   - Agregado: usuario_id        (quién registró la compra)
 *   - Agregado: bodega_id         (a qué bodega ingresa la mercancía)
 *   - total: desglosado en subtotal + descuento + impuestos + total
 *   - decimal(15,2)
 *   - estado_pago ampliado: agrega 'parcial' y 'anulada'
 *   - Agregado: observaciones
 *   - Índices para consultas frecuentes
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();
            $table->enum('estado', ['borrador', 'confirmada', 'pagada', 'anulada'])
                  ->default('borrador')
                  ->comment('Ciclo de vida del documento');
            $table->timestamp('confirmada_en')
                  ->nullable()
                  ->comment('Fecha en que se confirmó la compra');
            $table->foreignId('proveedor_id')
                  ->constrained('proveedores')
                  ->onDelete('restrict');
            $table->foreignId('bodega_id')
                  ->constrained('bodegas')
                  ->onDelete('restrict');
            $table->foreignId('usuario_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamp('fecha')->useCurrent();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('impuestos', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('total_confirmado', 15, 2)
                  ->nullable()
                  ->comment('Total capturado en el momento de la confirmación');
            $table->decimal('impuestos_confirmados', 15, 2)
                  ->nullable()
                  ->comment('Impuestos capturados en el momento de la confirmación');
            $table->json('snapshot_confirmacion')
                  ->nullable()
                  ->comment('Snapshot JSON de datos financieros al confirmar');
            $table->decimal('saldo_pendiente', 15, 2)->default(0);
            $table->enum('estado_pago', ['pagado', 'pendiente', 'parcial', 'anulada'])
                  ->default('pendiente');
            $table->date('fecha_vencimiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('fecha',                            'compras_fecha_idx');
            $table->index('estado',                           'compras_estado_idx');
            $table->index(['proveedor_id', 'estado_pago'],   'compras_proveedor_estado_idx');
            $table->index('usuario_id',                      'compras_usuario_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
