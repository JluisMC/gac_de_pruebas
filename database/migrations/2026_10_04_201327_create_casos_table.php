<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Ejecutivo que atiende
            $table->foreignId('cuenta_id')->nullable()->constrained();
            $table->foreignId('abonado_id')->nullable()->constrained();
            $table->string('no_solicitud')->unique();
            $table->string('origen')->default('Call Center');

            // --- NIVELES DE TIPOLOGÍA (Apuntando correctamente a 'tipologias') ---
            $table->foreignId('tipo_id')->nullable()->constrained('tipologias');
            $table->foreignId('categoria_id')->nullable()->constrained('tipologias');
            $table->foreignId('tipologia_id')->nullable()->constrained('tipologias');

            // --- TEXTOS ---
            $table->text('descripcion_cliente');
            $table->text('comentario_ejecutivo');
            $table->string('accion')->nullable();
            $table->text('solucion')->nullable();

            // --- CLASIFICACIÓN / AJUSTE ---
            $table->enum('lleva_ajuste', ['SI', 'NO', 'NO_APLICA'])->default('NO_APLICA');
            $table->string('n_credito')->nullable();
            $table->decimal('monto', 10, 2)->nullable();

            // --- TIPOS DE CIERRE ---
            $table->json('tipo_cierre')->nullable();

            $table->string('estado')->default('Abierto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};
