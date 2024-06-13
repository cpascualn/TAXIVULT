<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'hora_ini1', 'hora_fin1', 'hora_ini2', 'hora_fin2', 'tarifa_dia', 'tarifa_minuto'];
}
