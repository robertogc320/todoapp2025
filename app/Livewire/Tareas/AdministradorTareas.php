<?php

namespace App\Livewire\Tareas;

use App\Models\Tarea;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class AdministradorTareas extends Component
{
    /// filtros
    public $search;
    public $fechaIni;
    public $fechaFin;
    public $completada = false;
    public $tareas = [];

    public function mount()
    {
        $this->fill([
            'search' => '',
            'tareas' => [],
        ]);
    }

    public function buscar()
    {
        $this->render();
    }

    public function render()
    {
        try {
            $id = Auth::id();

            // contruimos la consulta a base de los filtros
            $builder = Tarea::whereRaw('id > 0')->when($this->completada, function (Builder $query, string $completada) {
                $query->where('completada', $completada);
            })
            ->when($this->search, function (Builder $query, string $search) {
                $query->where('titulo', 'like', '%' . $this->search . '%');
            });

            // rango de fechas
            if ($this->fechaIni && $this->fechaFin) {
                $builder = $builder->whereDate('fecha', '>=', $this->fechaIni)->whereDate('fecha', '<=', $this->fechaFin)->orderBy('fecha');
            } // solo fecha inicial
            else if ($this->fechaIni && !$this->fechaFin) {
                $builder = $builder->whereDate('fecha', '=', $this->fechaIni)->orderBy('fecha');
            }

            $this->tareas = $builder->get();
        } catch (Exception $e) {
        }

        return view('livewire.tareas.administrador-tareas');
    }
}
