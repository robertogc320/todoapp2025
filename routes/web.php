<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// ruta para acceder a las images y archivos que se adjuntan
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

// solo los usuarios logueados tendran acceso, al dashboard y la creacion de tares
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // dashboard, incluye al commponente Livwewire Administrador de Tareas
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    //Para ir a editor de tareas, para una nueva o editar alguna, el parameto "id"
    Route::get('/edt-tareas/{id?}', function ($id=null) {
        return view('edt-tareas', ['id' => $id]);
    })->name('edt-tareas');
});

// si tratan de ingresar a cualquier otra ruta, redireccionamos al login
Route::fallback(function () {
    return redirect()->route('login');
});