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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cuenta');
            $table->string('nombre_cuenta');
            $table->string('responsable_cuenta')->nullable();
            $table->string('identificacion')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->string('tipo_cuenta')->nullable();
            $table->string('categoria')->nullable();
            $table->string('vendedor')->nullable();
            $table->text('otros')->nullable();

            // Campos de Dirección de Facturación y Cobranza
            $table->string('provincia')->nullable();
            $table->string('distrito')->nullable();
            $table->string('corregimiento')->nullable();
            $table->string('calle')->nullable();
            $table->string('casa_apto')->nullable();
            $table->string('estafeta')->nullable();
            $table->string('casilla')->nullable();
            $table->string('email')->nullable(); // <-- FALTABA ESTA COLUMNA

            // Campos de Información de Recaudación
            $table->decimal('saldo', 10, 2)->default(0);
            $table->decimal('castigo_contable', 10, 2)->default(0);
            $table->date('fecha_ultimo_pago')->nullable();
            $table->decimal('monto_ultimo_pago', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
