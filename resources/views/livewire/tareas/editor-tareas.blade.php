<div class="grid grid-cols-1 md:grid-cols-3 gap-4 object-cover lg:gap-8">
    <div class="col-span-1 flex items-start 
    bg-white dark:bg-black
        rounded-lg p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] 
        ring-1 ring-white/[0.05] transition duration-300 
        hover:text-black/70 
        hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 
        dark:ring-zinc-800 
        dark:hover:text-white/70 
        dark:hover:ring-zinc-700">
        <div class="w-full">
            <div class="flex flex-row mb-2">
                <h5 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{$encabezadoEditor}}</h5>
            </div>
            @if($editando)
            <div class="block mt-2 mr-2 mb-2">
                <label for="esNuevoCliente" class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="" id="esNuevoCliente" class="sr-only peer"
                        wire:click="$toggle('cambiarFotos')" @if ($cambiarFotos) checked @endif>
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
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">¿Cambiar fotos?</span>
                </label>
            </div>
            @endif
            <div>
                @csrf
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
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            {{ old('descripcion') }}
                    </textarea>
                    @error('descripcion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            {{-- @can('edit product') --}}
                @if($editando)
                <div class="grid grid-cols-2 gap-4">
                    <div wire:click="actualizarTarea()" 
                        class="w-full mt-4 px-4 bg-indigo-500 text-white block py-2 rounded-md hover:bg-indigo-600 text-center">Guardar</div>
                    <div wire:click="confirmDeleteProduct()" wire:loading.attr="disabled"
                        class="w-full mt-4 px-4 bg-red-500 text-white block py-2 rounded-md hover:bg-red-600 text-center">Borrar</div>
                </div>
                @else
                <div wire:click="guardarTarea()" class="w-full mt-4 bg-sky-400 text-white dark:text-black block py-2 px-2 rounded-md hover:bg-sky-500 text-center cursor-pointer">Registrar</div>
                @endif
            {{-- @endcan --}}
        </div>
    </div>
    
    <div class="col-span-2 w-full h-full 
     bg-white dark:bg-black
        rounded-lg p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] 
        ring-1 ring-white/[0.05] transition duration-300 
        hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 
        dark:ring-zinc-800 
        dark:hover:ring-zinc-700">
       
        <div class="flex flex-col items-center">
            @if($editando && !$cambiarFotos)
            <!-- Main Image -->
            <div class="w-full md:w-2/3 lg:w-1/2 mb-2">
                @if($files && !blank($files))
                    <img id="mainImage" onclick="subirArchivos(this)" class="w-full rounded-lg" src="{{ $files[0]->temporaryUrl() }}" alt="Main product image">
                @else
                    {{-- <img id="mainImage" onclick="subirArchivos(this)" class="w-full rounded-lg" src="{{ route('images', ['filename' => $product->image_url])}}" alt="Main product image"> --}}
                @endif
            </div>
            @endif
        </div>


        <form wire:submit="agregarAdjuntos" id="uploadForm">
            <div
                x-data="{ uploading: false, progress: 0 }"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                @error('files.*') <span class="error">{{ $message }}</span> @enderror
    
                <input id="imputProductsImages" type="file" wire:model="files" name="files" id="upload{{ $iteration }}" multiple class="hidden">
    
                <!-- Progress Bar -->
                <div x-show="uploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
                <button type="submit" :disabled="uploading" class="hidden">Upload files</button>
            </div>
        </form>

        <div id="adjuntos_secction" class="mt-2">
            <div class="grid grid-cols-1">
                <div class="flex">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Adjuntos</h3>
                    </div>
                    <div onclick="subirArchivos(this)" class="w-8 mt-6 mr-2"><img src="{{ asset('icons8-adjuntar-64.png') }}"</img></div>
                </div>

                <div class=" grid-cols-1 w-full mt-2">
                    @if (!blank($files))
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <tbody>
                                @foreach ($files as $adjunto)
                                    @if(!blank($adjunto))
                                    <tr class="bg-white dark:bg-black">
                                        <th scope="row"
                                            class="py-1 px-6 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $adjunto->getClientOriginalName() }}
                                        </th>
                                        <td class="py-1 text-right">
                                            <div wire:click="quitarAdjunto({{ $loop->index }})" class="w-8">
                                                <img src="{{ asset('icons8-cancel-64.png') }}"/>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function subirArchivos(element) {
        //if (element.src.endsWith("noimage.png")) {
            document.getElementById('imputProductsImages').click();
        //}
    }

    function changeImage(element) {
        if (element.src.endsWith("noimage.png")) {
            document.getElementById('imputProductsImages').click();
        } else {
            document.getElementById('mainImage').src = element.src;
            // Remove the border from all thumbnails
            const thumbnails = document.querySelectorAll('.cursor-pointer');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('border-blue-500');
                thumb.classList.add('border-transparent');
            });
            // Add the border to the clicked thumbnail
            element.classList.remove('border-transparent');
            element.classList.add('border-blue-500');
        }
    }
</script>