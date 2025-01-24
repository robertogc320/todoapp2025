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
            $id = Auth::id();
            if (!blank($this->search)) {
                $this->tareas = DB::table('tareas', 't')
                    ->select("t.id as id")
                    ->whereRaw("t.user_id = {$id}")
                    ->whereRaw("t.titulo like '%{$this->search}%'")
                    //->where('p.completada', '=', Product::TIPO_NEON)
                    //->pluck("p.id", "id")
                    ->get();
            } else {
                $builder = Tarea::whereRaw('id > 0')->when($this->completada, function (Builder $query, string $completada) {
                    $query->where('completada', $completada);
                });
                if ($this->fechaIni && $this->fechaFin) {
                    $builder = $builder->whereDate('fecha', '>=', $this->fechaIni)->whereDate('fecha', '<=', $this->fechaFin)->orderBy('fecha');
                }
                else if ($this->fechaIni && !$this->fechaFin) {
                    $builder = $builder->whereDate('fecha', '=', $this->fechaIni)->orderBy('fecha');
                }

                $this->tareas = $builder->get();

                // $this->tareas = DB::table('tareas', 't')
                //     ->whereRaw("t.user_id = {$id}")
                //     ->whereRaw("t.id > 0")
                //     //->where('p.completada', '=', Product::TIPO_NEON)
                //     //->pluck("p.id", "id")
                //     ->get();
            }
        } catch (Exception $e) {
            dd($e);
        }

        $data = (object) [
            'completada' => $this->completada,
        ];

        return view('livewire.tareas.administrador-tareas', compact('data'));
    }
}
