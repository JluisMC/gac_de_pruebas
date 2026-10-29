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
        Schema::create('abonados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('cuenta_id')->constrained('cuentas')->onDelete('cascade');
            $table->string('situacion')->nullable();

            // Identificación de Línea
            $table->string('numero_abonado')->unique();
            $table->string('numero_celular');
            $table->string('codigo_usuario')->nullable();
            $table->string('numero_venta')->nullable(); // <-- AGREGAR ESTA LÍNEA

            // Plan y Red
            $table->string('producto')->nullable();
            $table->string('plan_tarifario')->nullable();
            $table->string('tipo_plan')->nullable(); // 2G/3G/4G
            $table->string('tecnologia')->nullable(); // GSM, LTE
            $table->string('tipo_simcard')->nullable();

            // Fechas de Contrato
            $table->date('fecha_alta')->nullable();
            $table->date('fin_contrato')->nullable();
            $table->date('fecha_expiracion')->nullable();
            $table->date('fecha_baja')->nullable();

            // Datos del Equipo (SIM / IMEI)
            $table->string('simcard')->nullable();
            $table->string('imei')->nullable();
            $table->string('modelo_equipo')->nullable();

            // Observaciones y Promociones
            $table->text('recordatorio')->nullable();
            $table->string('promocion')->nullable();
            $table->timestamps();

            //Campos faltantes para contrato equipo
            $table->decimal('precio_regular', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->decimal('monto_subsidio', 10, 2)->nullable();
            $table->string('asegurado')->nullable();
            $table->string('siniestro')->nullable();
            $table->date('fecha_cambio_equipo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonados');
    }
};
