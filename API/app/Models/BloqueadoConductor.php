<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueadoConductor extends Model
{
    use HasFactory;

    protected $table = 'bloqueado_conductors';

    protected $fillable = ['id_conductor', 'id_pasajero'];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor');
    }

    public function pasajero()
    {
        return $this->belongsTo(Pasajero::class, 'id_pasajero');
    }
}
