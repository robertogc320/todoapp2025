<div class="grid grid-cols-1 md:grid-cols-3 gap-4 object-cover lg:gap-8">

    {{-- PROPIEDADES DE LA TAREA --}}
    <div class="col-span-1 flex items-start 
    bg-white dark:bg-black
        rounded-lg p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)]  
        hover:text-black/70 
         lg:pb-10 
        dark:hover:text-white/70">
        <div class="w-full">
            <div class="flex flex-row mb-2">
                <h5 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{$encabezadoEditor}}</h5>
            </div>
            @if($editando)
            <div class="block mt-2 mr-2 mb-2">
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
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">¿Completada?</span>
                </label>
            </div>
            @endif
            <div>
                <div>
                    <x-label for="titulo" class="block text-sm font-medium text-gray-700">Nombre:</x-label>
                    <x-input type="text" name="name" id="name"
                        wire:model="titulo" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="{{ old('titulo') }}"/>
                    @error('titulo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</x-label>
                    <textarea name="descripcion" id="descripcion"
                        wire:model="descripcion"
                        value="{{ old('descripcion') }}" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">                    
                    </textarea>
                    @error('descripcion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label value="Fecha"/>
                    <x-input type="date" wire:model="fecha" class="w-full"/>
                </div>
            </div>
            
            {{-- @can('edit product') --}}
                @if($editando)
                <div class="grid grid-cols-2 gap-4">
                    <div wire:click="actualizarTarea()" 
                        class="w-full mt-4 px-4 bg-indigo-500 text-white block py-2 rounded-md hover:bg-indigo-600 text-center">Guardar</div>
                    <div wire:click="borrarTarea()" wire:loading.attr="disabled"
                        class="w-full mt-4 px-4 bg-red-500 text-white block py-2 rounded-md hover:bg-red-600 text-center">Borrar</div>
                </div>
                @else
                <div wire:click="guardarTarea()" class="w-full mt-4 bg-sky-400 text-white dark:text-black block py-2 px-2 rounded-md hover:bg-sky-500 text-center cursor-pointer">Registrar</div>
                @endif
            {{-- @endcan --}}
        </div>
    </div>
    
    {{-- ARCHIVOS ADJUNTOS --}}
    <div class="col-span-2 w-full h-full 
     bg-white dark:bg-black
        rounded-lg p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] 
        
         lg:pb-10 
        dark:ring-zinc-800 ">

        {{-- EL UPLOAD OCULTO PARA MEJOR DISEÑO --}}
        <form wire:submit="agregarAdjuntos" id="uploadForm">
            @csrf
            <div
                x-data="{ uploading: false, progress: 0 }"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                @error('files.*') <span class="error">{{ $message }}</span> @enderror
    
                <input id="imputTareasFiles" type="file" wire:model="files" name="files" id="upload{{ $iteration }}" multiple class="hidden"
                        accept=".jpg,.pdf,.jpeg">
    
                <!-- Progress Bar -->
                <div x-show="uploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
                <button type="submit" :disabled="uploading" class="hidden">Upload files</button>
            </div>
        </form>

        {{-- LISTADO --}}
        <div id="adjuntos_secction" class="mt-2">
            <div class="grid grid-cols-1">
                <div class="flex flex-row gap-2 ">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Adjuntar Imagenes y/o Pdf´s</h3>
                    </div>
                    <div onclick="subirArchivos(this)" class="w-8 mr-2 cursor-pointer"><img src="{{ asset('icons8-adjuntar-64.png') }}"</img></div>
                </div>

                <div class=" grid-cols-1 w-full mt-2">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <tbody>
                            {{--  NUEVOS ARCHIVOS ADJUNTOS --}}
                            @if (!blank($files))
                                @foreach ($files as $adjuntoFile)
                                    @if(!blank($adjuntoFile))
                                    <tr class="bg-white dark:bg-black">
                                        <td scope="row"
                                            class="py-1 px-6 text-sm font-normal whitespace-nowrap dark:text-white">
                                            <div class="flex items-center space-x-4 mt-2">
                                                <div class="relative">
                                                    {{--  ES IMAGEN --}}
                                                    @if(str_ends_with($adjuntoFile->getClientOriginalName(), '.jpg'))
                                                    <img src="{{ $adjuntoFile->temporaryUrl() }}"
                                                        alt="{{$adjuntoFile->getClientOriginalName()}}" class="w-20 h-20 rounded-lg p-1">
                                                    {{--  ES PDF --}}
                                                    @else
                                                        <img src="{{ asset('icons8-pdf-64.png') }}"
                                                            alt="Archivo pdf" class="w-20 h-20 rounded-lg p-1">
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-sm dark:text-white/70 font-medium">{{ $adjuntoFile->getClientOriginalName() }}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-1 text-right">
                                            <div wire:click="quitarAdjuntoNuevo('{{ $loop->index }}')" class="w-8">
                                                <img src="{{ asset('icons8-cancel-64.png') }}"/>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif

                            {{--  ARCHIVOS ADJUNTOS ACTUALES --}}
                            @foreach ($conservedfiles as $adjuntoOld)
                                @if($adjuntoOld && !blank($adjuntoOld))
                                <tr class="bg-white dark:bg-black">
                                    <td scope="row"
                                        class="py-1 px-6 text-sm font-normal whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4 mt-2">
                                            <div class="relative">
                                                {{--  ES IMAGEN --}}
                                                @if(str_ends_with($adjuntoOld->archivo, '.jpg'))
                                                <img src="{{ route('images', ['filename' => $adjuntoOld->archivo]) }}"
                                                    alt="{{$adjuntoOld->nombre}}" class="w-20 h-20 rounded-lg p-1">
                                                {{--  ES PDF --}}
                                                @else
                                                    <img src="{{ asset('icons8-pdf-64.png') }}"
                                                        alt="Archivo pdf" class="w-20 h-20 rounded-lg p-1">
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-sm dark:text-white/70 font-medium">{{ $adjuntoOld->nombre }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-1 text-right">
                                        <div wire:click="quitarAdjuntoActual('{{ $adjuntoOld->nombre}}')" class="w-8">
                                            <img src="{{ asset('icons8-cancel-64.png') }}"/>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            @foreach ($removedfiles as $adjuntoRemoved)
                                @if(!blank($adjuntoRemoved))
                                <tr class="bg-white dark:bg-black">
                                    <td scope="row"
                                        wire:click="regresarAdjuntoActual('{{ $adjuntoRemoved->nombre}}')"
                                        class="py-1 px-6 text-sm font-normal whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4 mt-2">
                                            <div class="relative">
                                                {{--  ES IMAGEN --}}
                                                @if(str_ends_with($adjuntoRemoved->archivo, '.jpg'))
                                                <img src="{{ route('images', ['filename' => $adjuntoRemoved->archivo]) }}"
                                                    alt="{{$adjuntoRemoved->nombre}}" class="w-20 h-20 rounded-lg p-1">
                                                {{--  ES PDF --}}
                                                @else
                                                    <img src="{{ asset('icons8-pdf-64.png') }}"
                                                        alt="Archivo pdf" class="w-20 h-20 rounded-lg p-1">
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="py-1 px-6 text-sm font-normal text-red-600 line-through whitespace-nowrap dark:text-white cursor-pointer">{{ $adjuntoRemoved->nombre }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function subirArchivos(element) {
        document.getElementById('imputTareasFiles').click();
    }
</script>