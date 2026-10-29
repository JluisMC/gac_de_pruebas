<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'cuenta_id',
        'numero_cliente',
        'nombre_cliente',
        'identificacion',
        'tipo_persona',
        'categoria',
        'ciclo_facturacion',
        'telefono_contacto',
        'saldo',
        'tarjeta_credito',
        'vencimiento_tarjeta',
        'fecha_alta',
        'fecha_baja',
    ];

    // El cliente pertenece a una cuenta
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    // Un cliente tiene muchos abonados
    public function abonados()
    {
        return $this->hasMany(Abonado::class);
    }
}
