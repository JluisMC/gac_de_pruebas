<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('casos', function (Blueprint $table) {
            $table->string('tipo_venta')->nullable()->after('registro_sgsn');
            $table->string('motivo_visita')->nullable()->after('tipo_venta');
        });
    }

    public function down(): void
    {
        Schema::table('casos', function (Blueprint $table) {
            $table->dropColumn(['tipo_venta', 'motivo_visita']);
        });
    }
};
