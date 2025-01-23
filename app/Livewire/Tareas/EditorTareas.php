<?php

namespace App\Livewire\Tareas;

use App\Models\Tarea;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditorTareas extends Component
{
    use WithFileUploads;

    public $open = false;
    public $modo = 1; // 1 nuevo, 2 editando, 3 mostrando, 4 eliminando

    // propiedades
    public $editando;
    public $id; // id
    public $tarea; //la tarea en edicion 
    public $cambiarFotos = false;
    public $titulo;
    public $descripcion;
    public $activo;

    #[Validate('image|max:1024')] // Tamaño maximo de archivos 1MB Max
    public $files = [];
    public $iteration = 0;

    // edit
    public $original;

    // eventos con admin panel
    // protected $listeners = [
    //     'editarClienteEvent' => 'editarClienteEventListener',
    //     'nuevoClienteEvent' => 'nuevoClienteEventListener',
    //     'eliminarClienteEvent' => 'eliminarClienteEventListener'
    // ];
    
    // reglas de validacion
    protected $rules = [
        'titulo' => 'required|max:150',
        'descripcion' => 'required|max:250',
    ];

    public function mount($id = 0)
    {
        // nueva tarea
        if (!isset($id) or $id == "0") {
            $this->fill([
                'titulo' => "",
                'descripcion' => "",
            ]);
        } else { // editando, cargamos la info de la tarea
            $this->editando = true;
            $this->tarea = Tarea::findOrFail($id);
            $this->titulo = $this->tarea->titulo;
            $this->descripcion = $this->product->descripcion;
        }
    }

    public function render()
    {
        return view('livewire.tareas.editor-tareas');
    }

    protected function limpiar() {
        $this->reset([
            'titulo',
            'description',
        ]);
        $this->tarea = null;
        $this->files = null;
        $this->iteration++;
    }

    public function guardar() {
        $mensajeError = "";

        if (blank($this->titulo) or blank($this->description)) {
            if (blank($this->titulo)) {
                $mensajeError = "{$mensajeError}" . (($mensajeError) ? "; " : "") . "Agregue un titulo";
            }
            if (blank($this->description)) {
                $mensajeError = "{$mensajeError}" . (($mensajeError) ? "; " : "") . "Agregue una descripción";
            }
            $mensajeError = "{$mensajeError}.";

            $this->dispatch('errorLivewireAlertEvent', $mensajeError);
            $this->validate();
            return;
        }

        // archivos agregados
        $pathsFiles = [];
        foreach ($this->files as $photo) {
            $ruta = Storage::putFile('/tareas/images', $photo);
            $pathsFiles[] = str_replace("tareas/images/", "", $ruta);
        }

        $tarea = Tarea::create([
            'titulo' => $this->name,
            'descripcion' => $this->descripcion,
            'completada' => $this->price,

            // 'image_url' => $pathsFiles[0],
            // 'image1_url' => $pathsFiles[1],
            // 'image2_url' => $pathsFiles[2],
            // 'image3_url' => $pathsFiles[3],
        ]);

        //$tarea->categories()->sync(array_keys($this->categoriesSelected));

        /*$data = (object) [  
            'name' => $this->name,
        ];
        dd($data);*/

        // Reseteamos el Upload Form
        $this->files = null;
        $this->iteration++;

        //redirigimos al resumen de actividades
        //redirect(route('tareas'));
        $this->dispatch('successLivewireAlertEvent', 'Tarea Guardada!');
    }
}
