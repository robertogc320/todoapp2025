<?php

namespace App\Livewire\Tareas;

use App\Models\Tarea;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdministradorTareas extends Component
{
    public $search;
    public $tareas = [];

    public function mount()
    {
        $this->fill([
            'search' => '',
            'tareasIds' => [],
        ]);
    }

    public function buscar()
    {
        $this->render();
    }

    public function render()
    {
        try {
            if (!blank($this->search)) {
                $this->tareas = DB::table('tareas', 't')
                    ->select("t.id as id")
                    ->whereRaw("t.titulo like '%{$this->search}%'")
                    //->where('p.completada', '=', Product::TIPO_NEON)
                    //->pluck("p.id", "id")
                    ->get();
            } else {
                $this->tareas = DB::table('tareas', 't')
                    ->whereRaw("t.id > 0")
                    //->where('p.completada', '=', Product::TIPO_NEON)
                    //->pluck("p.id", "id")
                    ->get();
            }
        } catch (Exception $e) {
            dd($e);
        }

        $data = (object) [
            'tareas' => $this->tareas,
        ];

        return view('livewire.tareas.administrador-tareas', compact('data'));
    }
}
