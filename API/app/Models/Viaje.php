<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_conductor',
        'id_pasajero',
        'lati_ini',
        'longi_ini',
        'lati_fin',
        'longi_fin',
        'fecha_ini',
        'fecha_fin',
        'metodo_pago',
        'cancelado',
        'fecha_cancelacion',
        'distancia',
        'duracion_min',
        'precio_total'
    ];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor');
    }

    public function pasajero()
    {
        return $this->belongsTo(Pasajero::class, 'id_pasajero');
    }
}
