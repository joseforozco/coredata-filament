<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('tabla', 50);
            $table->enum('operacion', ['INSERT', 'UPDATE', 'DELETE']);
            $table->unsignedBigInteger('registroId');
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->timestamp('fecha_operacion')->useCurrent();
            $table->timestamps();
            
            
            // Índices
            $table->index('tabla');
            $table->index('operacion');
            $table->index('registroid');
            $table->index('fecha_operacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};