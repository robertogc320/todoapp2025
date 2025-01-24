<?php

namespace App\Livewire\Tareas;

use App\Models\Adjunto;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditorTareas extends Component
{
    use WithFileUploads;

    // propiedades
    public $editando;
    public $tarea; //la tarea en edicion
    public $completada = false;
    public $encabezadoEditor;

    public $fecha;
    #[Validate('required', message: 'Ingrese un nombre')]
    public $titulo;
    #[Validate('required', message: 'Ingrese la descripción')]
    public $descripcion;

    #[Validate('image|max:1024')] // Tamaño maximo de archivos 1MB Max
    public $files = [];
    public $conservedfiles = [];
    public $removedfiles = [];
    public $iteration = 0; // para el upload

    public function mount($id)
    {
        // nueva tarea
        if (!isset($id) or $id =="") {
            $this->fill([
                'titulo' => "",
                'encabezadoEditor' => "Nueva Tarea",
                'descripcion' => "",
                'adjuntoNombre' => "",
            ]);
        } else { // editando, cargamos la info de la tarea
            $this->editando = true;
            $this->encabezadoEditor = "Editar Tarea";
            $this->tarea = Tarea::with('adjuntos')->findOrFail($id);
            $this->titulo = $this->tarea->titulo;
            $this->descripcion = $this->tarea->descripcion;
            $this->completada = $this->tarea->completada;
            $this->fecha = $this->tarea->fecha;

            foreach ($this->tarea->adjuntos as $adjunto) {
                $this->conservedfiles[] = $adjunto;
            }
        }
    }

    public function render()
    {
        return view('livewire.tareas.editor-tareas');
    }

    protected function limpiar() {
        $this->reset([
            'titulo',
            'descripcion',
        ]);
        $this->tarea = null;
        $this->files = null;
        $this->iteration++;
    }

    public function quitarAdjuntoActual($nombre) {
        $index = 0;
        foreach ($this->conservedfiles as $adjunto) {
            if ($adjunto && $adjunto->nombre===$nombre) {
                $this->removedfiles[] = $this->conservedfiles[$index];
                $this->conservedfiles[$index] = null;
                break;
            }
            $index++;
        }
    }

    public function quitarAdjuntoNuevo($index) {
        $this->files[$index] = null;
    }

    public function regresarAdjuntoActual($nombre) {
        $index = 0;
        foreach ($this->removedfiles as $adjunto) {
            if ($adjunto && $adjunto->nombre===$nombre) {
                $this->conservedfiles[] = $this->removedfiles[$index];
                $this->removedfiles[$index] = null;
                break;
            }
            $index++;
        }
    }

    public function agregarAdjuntos()
    {
        // Reset Upload Form
        $this->files = null;
        $this->iteration++;
    }

    public function guardarTarea() {
        $mensajeError = "";

        if (blank($this->titulo) or blank($this->descripcion)) {
            if (blank($this->titulo)) {
                $mensajeError = "{$mensajeError}" . (($mensajeError) ? "; " : "") . "Agregue un titulo";
            }
            if (blank($this->descripcion)) {
                $mensajeError = "{$mensajeError}" . (($mensajeError) ? "; " : "") . "Agregue una descripción";
            }
            $mensajeError = "{$mensajeError}.";

            $this->validate();
            return;
        }

        $tarea = Tarea::create([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'completada' => $this->completada,
            'fecha' => $this->fecha,
            'user_id' => Auth::id(),
        ]);

        // adjuntos agregados
        foreach ($this->files as $photo) {
            // movemos el archivo a la ruta
            $ruta = Storage::putFile('/tareas/archivos', $photo);
            $filename = str_replace("tareas/archivos/", "", $ruta);
            
            $adjunto = Adjunto::create([
                'tarea_id' => $tarea->id,
                'nombre' => $photo->getClientOriginalName(),//$filename,
                'archivo' => $filename,
            ]);
        }

        // Reseteamos el Upload Form
        $this->files = null;
        $this->iteration++;

        //redirigimos al resumen de actividades
        $this->limpiar();
        redirect(route('dashboard'));
    }

    public function borrarTarea()
    {
        $mensajeError = "";

        //borramos la imagenes anteriores
        $tarea = Tarea::find($this->tarea->id);
        foreach ($tarea->adjuntos as $adjunto) {
            Storage::delete('/tareas/archivos/' . $adjunto->archivo);    
        }

        // eliminamos
        Tarea::where('id', $this->tarea->id)->delete();

        // Reset Upload Form
        $this->files = null;
        $this->iteration++;

        $this->limpiar();
        redirect(route('dashboard'));
    }

    public function actualizarTarea()
    {
        $mensajeError = "";

        if (blank($this->titulo) or blank($this->descripcion)) {
            if (blank($this->titulo)) {
                $mensajeError = "{$mensajeError}" . (($mensajeError) ? "; " : "") . "Agregue un titulo";
            }
            if (blank($this->descripcion)) {
                $mensajeError = "{$mensajeError}" . (($mensajeError) ? "; " : "") . "Agregue una descripción";
            }
            $mensajeError = "{$mensajeError}.";

            $this->dispatch('errorLivewireAlertEvent', $mensajeError);
            $this->validate();
            return;
        }

        // actualizamos titulo y descripcion
        $tarea = Tarea::find($this->tarea->id);
        $tarea->titulo = $this->titulo;
        $tarea->descripcion = $this->descripcion;
        $tarea->completada = $this->completada;
        $tarea->fecha = $this->fecha;
        $tarea->save();

        // adjuntos nuevos, agregamos el archivo
        foreach ($this->files as $photo) {
            // movemos el archivo a la ruta
            $ruta = Storage::putFile('/tareas/archivos', $photo);
            $filename = str_replace("tareas/archivos/", "", $ruta);
            
            $adjunto = Adjunto::create([
                'tarea_id' => $tarea->id,
                'nombre' => $photo->getClientOriginalName(),//$filename,
                'archivo' => $filename,
            ]);
        }

        // adjuntos eliminados, eliminamos los archivos
        foreach ($this->removedfiles as $adjunto) {
            Storage::delete('/tareas/archivos/' . $adjunto->archivo);
            Adjunto::where('id', $adjunto->id)->delete();
        }

        // Reseteamos el Upload Form
        $this->files = null;
        $this->iteration++;

        //redirigimos al resumen de actividades
        $this->limpiar();
        redirect(route('dashboard'));
    }

}
