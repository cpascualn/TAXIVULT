<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'matricula',
        'capacidad',
        'fabricante',
        'modelo',
        'tipo',
        'conductor'
    ];
}
