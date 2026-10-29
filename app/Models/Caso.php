<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'casos';

    protected $fillable = [
        'user_id',
        'cuenta_id',
        'abonado_id',
        'no_solicitud',
        'origen',
        'tipo_id',
        'categoria_id',
        'tipologia_id',
        'descripcion_cliente',
        'comentario_ejecutivo',
        'accion',
        'solucion',
        'lleva_ajuste',
        'n_credito',
        'monto',
        'tipo_cierre',
        'estado',
        'provincia_id',
        'ubicacion',
        'coordenadas',
        'fecha_inconveniente',
        'estado_cbs',
        'registro_sgsn',
        // Nuevos campos de venta:
        'tipo_venta',
        'motivo_visita',
    ];

    protected $casts = [
        'tipo_cierre' => 'array', // Parsea automáticamente los checkboxes a array/json
        'monto' => 'decimal:2',
    ];

    // --- RELACIONES ELOQUENT ---

    /**
     * Relación con el Abonado
     */
    public function abonado()
    {
        return $this->belongsTo(Abonado::class, 'abonado_id');
    }

    /**
     * Relación con la Cuenta
     */
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }

    /**
     * Relación con la Tipología
     */
    public function tipologia()
    {
        return $this->belongsTo(Tipologia::class, 'tipologia_id');
    }

    /**
     * Relación con el Usuario creador
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el Tipo (Nivel 1)
     */
    public function tipo()
    {
        return $this->belongsTo(Tipologia::class, 'tipo_id');
    }

    /**
     * Relación con la Categoría (Nivel 2)
     */
    public function categoria()
    {
        return $this->belongsTo(Tipologia::class, 'categoria_id');
    }
}
