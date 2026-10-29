<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('casos', function (Blueprint $table) {
            $table->unsignedBigInteger('provincia_id')->nullable()->after('estado');
            $table->text('ubicacion')->nullable()->after('provincia_id');
            $table->text('coordenadas')->nullable()->after('ubicacion');
            $table->date('fecha_inconveniente')->nullable()->after('coordenadas');
            $table->string('estado_cbs')->nullable()->after('fecha_inconveniente');
            $table->string('registro_sgsn')->nullable()->after('estado_cbs');
        });
    }

    public function down(): void
    {
        Schema::table('casos', function (Blueprint $table) {
            $table->dropColumn([
                'provincia_id',
                'ubicacion',
                'coordenadas',
                'fecha_inconveniente',
                'estado_cbs',
                'registro_sgsn'
            ]);
        });
    }
};
