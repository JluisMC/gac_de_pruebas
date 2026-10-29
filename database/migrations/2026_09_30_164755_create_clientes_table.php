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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_id')->constrained('cuentas')->onDelete('cascade');
            $table->string('numero_cliente')->unique();
            $table->string('nombre_cliente');
            $table->string('identificacion'); // Cédula / Pasaporte / RUC
            $table->string('tipo_persona')->nullable(); // Natural / Jurídica
            $table->string('categoria')->nullable();
            $table->string('ciclo_facturacion')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->decimal('saldo', 10, 2)->default(0.00);
            $table->string('tarjeta_credito')->nullable();
            $table->date('vencimiento_tarjeta')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
