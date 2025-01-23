<div class="pt-2">
    {{-- FILTRO DE BUSQUEDA --}}
    <div class="flex flex-row mt-2 mb-4 gap-4 pl-2 ">
        <div class="block">
            <x-input wire:model="search" class="outline-none col-span-3" type="text" />
        </div>
        <button wire:click="buscar" class="w-8"><img src="search.png" title="Dé clic para buscar"></img></button>
    </div>

    <div class="w-full grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1 gap-5 pl-5 sm:pl-2">
        @foreach ($tareas as $tarea)
        <div class="col-span-1 bg-white shadow-lg hover:shadow-gray-600/60
                    transition ease-in-out delay-10 hover:-translate-y-8 hover:scale-108 duration-300
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

                <div class="flex flex-row gap-2">
                    <div>
                        <h5 class="text-xl font-semibold tracking-tigh text-black dark:text-gray-100">{{ $tarea->titulo }}</h5>
                    </div>
                    <div onclick="subirArchivos(this)" class="w-8 mr-2 cursor-pointer">
                        <a href="{{ route('edt-tareas', ['id' => $tarea->id]) }}">
                            <img src="{{ asset('icons8-edit-64.png') }}"</img>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col overflow-auto max-h-60 text-black">
                    <p class="mb-3 text-xs font-normal line-clamp-5  text-clip overflow-hidden">{{ $tarea->descripcion }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

