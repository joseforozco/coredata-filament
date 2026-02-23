<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('documento', 20)->unique();
            $table->enum('tipo_documento', ['CC', 'NIT', 'CE', 'PP'])->default('NIT');
            $table->string('telefono', 30);
            $table->string('email', 100)->unique();
            $table->string('direccion1', 100);
            $table->string('direccion2', 100)->nullable();
            $table->foreignId('ciudadesId')->constrained('ciudades')->onDelete('restrict');
            $table->foreignId('departamentosId')->constrained('departamentos')->onDelete('restrict');
            $table->decimal('saldo', 15, 2)->default(0.00);          // Solo lectura — resultado de movimientos
            $table->string('pais', 100)->default('Colombia');
            $table->boolean('activo')->default(true);
            $table->decimal('limite_credito', 15, 2)->default(0.00); // Agregado desde clientes
            $table->integer('dias_credito')->default(0);             // Agregado desde clientes
            $table->integer('dias_pago')->default(0);
            $table->string('contacto_principal', 100)->nullable();
            $table->string('sitio_web', 255)->nullable();
            $table->timestamps();
            $table->foreignId('usuarioId')->constrained('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};