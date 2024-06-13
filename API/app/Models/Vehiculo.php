<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    protected $fillable = [
        'matricula',
        'capacidad',
        'fabricante',
        'modelo',
        'tipo',
        'imagen',
        'conductor'
    ];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class);
    }
}
