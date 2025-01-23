<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    protected $fillable = ['archivo', 'tarea_id', 'nombre'];
}
