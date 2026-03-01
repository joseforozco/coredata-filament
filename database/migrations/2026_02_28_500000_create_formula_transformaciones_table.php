<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('formula_transformaciones')) {
            Schema::create('formula_transformaciones', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 150)->unique();
                $table->text('descripcion')->nullable();
                $table->enum('tipo', ['manufactura', 'empaque', 'combo'])->default('manufactura');
                $table->string('producto_final_nombre', 255);
                $table->decimal('cantidad_producto_final', 10, 3)->default(1);
                $table->boolean('activo')->default(true);
                $table->foreignId('usuario_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->timestamps();

                $table->index('activo', 'formula_transformaciones_activo_idx');
                $table->index('tipo', 'formula_transformaciones_tipo_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('formula_transformaciones');
    }
};
