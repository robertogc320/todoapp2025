<div class="pt-2">
    {{-- FILTRO DE BUSQUEDA --}}
    <div class="flex flex-col md:flex-row mt-2 mb-4 gap-4 pl-2">
        <div class="block mt-6 mr-4 ">
            <label for="completada" class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox" value="" id="completada" class="sr-only peer"
                    wire:click="$toggle('completada')" @if ($completada) checked @endif>
                <div
                    class="w-11 h-6 bg-gray-200 rounded-full 
                        peer 
                        peer-focus:ring-4 
                        peer-focus:ring-indigo-500 
                        dark:peer-focus:ring-indigo-500 
                        dark:bg-gray-700 
                        peer-checked:after:translate-x-full 
                        peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                        dark:border-gray-600 
                        peer-checked:bg-sky-400">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">¿Mostrar solo la completadas?</span>
            </label>
        </div>
        <div>
            <x-label for="fechaIni" class="block text-sm font-medium text-gray-700">Fecha Inicial</x-label>
            <x-input wire:model="fechaIni" type="date" name="fechaIni" wire:keydown.enter="buscar" class="bg-white"/>
        </div>
        <div>
            <x-label for="fechaFin" class="block text-sm font-medium text-gray-700">Fecha Final</x-label>
            <x-input wire:model="fechaFin" type="date" name="fechaFin" wire:keydown.enter="buscar" class="bg-white"/>
        </div>
        <button wire:click="buscar" class="w-8 mt-2"><img src="search.png" title="Dé clic para buscar"></img></button>
    </div>

    <div class="w-full grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1 gap-10  pl-5 sm:pl-2">
        @foreach ($tareas as $tarea)
        <div class="col-span-1 bg-white dark:bg-gray-800 shadow-lg hover:shadow-gray-600/60
                    transition ease-in-out delay-10 hover:-translate-y-1 hover:scale-108 duration-300
                    max-w-[390px] hover:ring-black/90 rounded-b-lg"
                    >
            <div>
                @if($tarea->completada)
                    <img class="h-48  w-full object-cover rounded-t-lg" 
                    {{-- src="{{ route('images', ['filename' => $product->image_url])}}" --}}
                    src="{{ asset('tareaok.png') }}"
                    />
                @else
                <img class="h-48  w-full object-cover rounded-t-lg" 
                    {{-- src="{{ route('images', ['filename' => $product->image_url])}}" --}}
                    src="{{ asset('tarea-not.png') }}"
                    />
                @endif
            </div>
            <div class="px-5 pb-5 mt-2">

                <div class="flex flex-row justify-between gap-2">
                    <div>
                        <h5 class="text-xl font-semibold tracking-tigh text-black dark:text-gray-100">{{ $tarea->titulo }}</h5>
                    </div>
                    <div onclick="subirArchivos(this)" class="w-8 mr-2 cursor-pointer">
                        <a href="{{ route('edt-tareas', ['id' => $tarea->id]) }}">
                            <img src="{{ asset('icons8-edit-64.png') }}"</img>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col overflow-auto max-h-60 text-black dark:text-gray-100">
                    <p class="mb-3 text-xs font-normal line-clamp-5  text-clip overflow-hidden">{{$tarea->fecha}}.- {{ $tarea->descripcion }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

