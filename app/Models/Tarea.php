<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    // Propiedades
    protected $fillable = ['title', 'description', 'completada'];
}
