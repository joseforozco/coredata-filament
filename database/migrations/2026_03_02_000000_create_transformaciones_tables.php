<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('transformaciones')) {
            Schema::create('transformaciones', function (Blueprint $t) {
                $t->id();
                $t->foreignId('bodega_id')->constrained('bodegas');
                $t->string('tipo')->default('manufactura'); // manufactura, empaque, otro
                $t->foreignId('formula_transformacion_id')
                    ->nullable()
                    ->constrained('formula_transformaciones')
                    ->nullOnDelete()
                    ->comment('Fórmula predefinida para esta transformación');
                $t->decimal('cantidad_a_producir', 10, 3)
                    ->default(1)
                    ->comment('Cuántos productos finales se desean crear con esta fórmula');
                $t->string('estado')->default('borrador'); // borrador, confirmada, anulada
                $t->dateTime('fecha')->useCurrent();
                $t->text('observaciones')->nullable();
                $t->foreignId('usuario_id')->nullable()->constrained('users');
                $t->timestamps();

                $t->index(['bodega_id', 'fecha'], 'transformaciones_bodega_fecha_idx');
            });
        }

        if (! Schema::hasTable('transformacion_detalles')) {
            Schema::create('transformacion_detalles', function (Blueprint $t) {
                $t->id();
                $t->foreignId('transformacion_id')
                    ->constrained('transformaciones')
                    ->onDelete('cascade');
                $t->enum('tipo_linea', ['insumo', 'producto'])->default('insumo');
                $t->foreignId('producto_id')->constrained('productos');
                $t->decimal('cantidad', 10, 3);
                $t->string('lote')->nullable();
                $t->date('fecha_vencimiento')->nullable();
                $t->decimal('costo_unitario', 10, 2)->nullable();
                $t->timestamps();

                $t->index(['transformacion_id', 'tipo_linea'], 'transformacion_detalles_tipo_idx');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('transformacion_detalles')) {
            Schema::dropIfExists('transformacion_detalles');
        }

        if (Schema::hasTable('transformaciones')) {
            Schema::dropIfExists('transformaciones');
        }
    }
};

