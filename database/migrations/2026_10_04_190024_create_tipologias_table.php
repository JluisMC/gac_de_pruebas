<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipologias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre de la opción
            $table->integer('nivel')->default(1); // 1 (Rojo), 2 (Azul), 3 (Amarillo)

            // Relación auto-referenciada para la jerarquía en cascada
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('tipologias')
                ->onDelete('cascade');

            // Campos adicionales del nivel 3 (Cuadro Guindo)
            $table->string('accion')->nullable();
            $table->string('solucion')->nullable();
            $table->string('clasificacion')->nullable();
            $table->string('tipo_cierre')->nullable();

            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipologias');
    }
};
