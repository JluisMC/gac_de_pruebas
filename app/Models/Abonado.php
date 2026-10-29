<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonado extends Model
{
    use HasFactory;

    protected $table = 'abonados';

    protected $fillable = [
        'cliente_id',
        'cuenta_id',
        'situacion',
        'numero_abonado',
        'numero_celular',
        'codigo_usuario',
        'numero_venta',
        'producto',
        'plan_tarifario',
        'tipo_plan',
        'tecnologia',
        'tipo_simcard',
        'fecha_alta',
        'fin_contrato',
        'fecha_expiracion',
        'fecha_baja',
        'simcard',
        'imei',
        'modelo_equipo',
        'recordatorio',
        'promocion',
        'precio_regular',
        'precio_venta',
        'monto_subsidio',
        'asegurado',
        'siniestro',
        'fecha_cambio_equipo',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function estaExpirado(): bool
    {
        if (!$this->fecha_expiracion) {
            return false;
        }

        return \Carbon\Carbon::parse($this->fecha_expiracion)->isPast();
    }
}
