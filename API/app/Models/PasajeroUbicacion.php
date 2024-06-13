<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasajeroUbicacion extends Model
{
    use HasFactory;

    protected $table = 'pasajero_ubicacions';

    protected $fillable = ['id_ubicacion', 'id_pasajero'];

    public function ubicacion()
    {
        return $this->belongsTo(UbicacionFav::class, 'id_ubicacion');
    }

    public function pasajero()
    {
        return $this->belongsTo(Pasajero::class, 'id_pasajero');
    }
}
