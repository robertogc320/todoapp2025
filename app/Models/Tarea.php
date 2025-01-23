<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    // Propiedades
    protected $fillable = ['titulo', 'descripcion', 'completada'];
    
    // muchos Adjuntos (images o pdfs)
    public function adjuntos()
    {
        return $this->hasMany(Adjunto::class);
    }
}
