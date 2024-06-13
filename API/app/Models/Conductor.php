<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'licencia_taxista',
        'titular_tarjeta',
        'iban_tarjeta',
        'tiempo_espera',
        'lati_espera',
        'estado',
        'coche',
        'horario'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'coche', 'matricula');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
