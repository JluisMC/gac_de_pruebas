<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipologia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'nivel',
        'parent_id',
        'accion',
        'solucion',
        'clasificacion',
        'tipo_cierre',
        'activo',
    ];

    /**
     * Obtener el elemento padre (Nivel superior).
     */
    public function padre()
    {
        return $this->belongsTo(Tipologia::class, 'parent_id');
    }

    /**
     * Obtener las sub-opciones o elementos hijos (Nivel inferior).
     */
    public function hijos()
    {
        return $this->hasMany(Tipologia::class, 'parent_id')->where('activo', true);
    }
}
