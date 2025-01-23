<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});
Route::get('images/{filename}', function ($filename) {
    $pathfilename = '/tareas/archivos/'.$filename;
    // Verificar si el archivo existe en el disco 'uploads'
    if (Storage::exists($pathfilename)) {
        // Devolver la imagen con el tipo de contenido adecuado
        $file = Storage::get($pathfilename);
        $type = Storage::mimeType($pathfilename);
        return response($file, 200)->header('Content-Type', $type);
    } else {
        // Manejar caso cuando la imagen no existe
        abort(404);
    }
})->name('images');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/edt-tareas/{id?}', function ($id=null) {
        return view('edt-tareas', ['id' => $id]);
    })->name('edt-tareas');
});
