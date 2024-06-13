<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    use HasFactory;

    protected $fillable = [
        'n_tarjeta',
        'titular_tarjeta',
        'caducidad_tarjeta',
        'cvv_tarjeta'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id');
    }
}
