<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: historico_precios
 *
 * Correcciones vs original ('historicoPrecios'):
 *   - Nombre: historicoPrecios → historico_precios  (snake_case)
 *   - inventarioId → producto_id  (apunta a productos, no a inventarios)
 *   - usuarioId    → usuario_id   (snake_case)
 *   - precioCompra → precio_compra (snake_case)
 *   - precioVenta  → precio_venta  (snake_case)
 *   - fechaCambio  → fecha_cambio  (snake_case)
 *   - decimal: (10,2) → (15,2)
 *   - Agregado: motivo  (por qué se cambió el precio)
 *   - down() corregido al nombre real de la tabla
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_precios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->onDelete('cascade');
            $table->decimal('precio_compra', 15, 2);
            $table->decimal('precio_venta', 15, 2);
            $table->string('motivo', 150)->nullable();
            $table->foreignId('usuario_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamp('fecha_cambio')->useCurrent();
            $table->timestamps();

            $table->index('producto_id',  'histprecio_producto_idx');
            $table->index('fecha_cambio', 'histprecio_fecha_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_precios');
    }
};
