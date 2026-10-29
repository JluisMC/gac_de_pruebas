<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    protected $table = 'cuentas';

    protected $fillable = [
        'numero_cuenta',
        'nombre_cuenta',
        'responsable_cuenta',
        'identificacion',
        'fecha_alta',
        'tipo_cuenta',
        'categoria',
        'vendedor',
        'provincia',
        'distrito',
        'corregimiento',
        'calle',
        'casa_apto',
        'estafeta',
        'casilla',
        'castigo_contable',
        'fecha_ultimo_pago',
        'monto_ultimo_pago',
        'otros',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function abonados()
    {
        return $this->hasMany(Abonado::class);
    }
}
