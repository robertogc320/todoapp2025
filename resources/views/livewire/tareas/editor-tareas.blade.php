<div class="grid grid-cols-1 md:grid-cols-3 gap-4 object-cover lg:gap-8">
    
    <div class="col-span-2 w-full h-full 
     dark:bg-black
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
                    <img id="mainImage" onclick="subirArchivos(this)" class="w-full rounded-lg" src="{{ route('images', ['filename' => $product->image_url])}}" alt="Main product image">
                @endif
            </div>
            <div class="flex space-x-3">
                <!-- <img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500" src="/images/love.jpg" alt="Thumbnail 1"> -->
                <div id="imagePreview"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500" src="{{ route('images', ['filename' => $product->image_url])}}" alt="Thumbnail 2"></div>
                <div id="imagePreviewFoto1"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500" src="{{ route('images', ['filename' => $product->image1_url])}}" alt="Thumbnail 2"></div>
                <div id="imagePreviewFoto2"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500" src="{{ route('images', ['filename' => $product->image2_url])}}" alt="Thumbnail 2"></div>
                <div id="imagePreviewFoto3"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500" src="{{ route('images', ['filename' => $product->image3_url])}}" alt="Thumbnail 2"></div>
            </div>
            @else
            <!-- Main Image -->
            <div class="w-full md:w-2/3 lg:w-1/2 mb-2">
                @if($files && !blank($files))
                    <img id="mainImage" onclick="subirArchivos(this)" class="w-full rounded-lg" src="{{ $files[0]->temporaryUrl() }}" alt="Main product image">
                @else
                    <img id="mainImage" onclick="subirArchivos(this)" class="w-full rounded-lg" src="/noimage.png" alt="Main product image">
                @endif
            </div>
            <div class="flex space-x-3">
                <!-- <img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500" src="/images/love.jpg" alt="Thumbnail 1"> -->
                @if($files && count($files)>0)
                <div id="imagePreview"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="{{ $files[0]->temporaryUrl() }}" alt="Thumbnail 2"></div>
                @else
                    <div id="imagePreview"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="/noimage.png" alt="Thumbnail 2"></div>
                @endif
                
                @if($files && count($files)>1)
                <div id="imagePreviewFoto1"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="{{ $files[1]->temporaryUrl() }}" alt="Thumbnail 2"></div>
                @else
                    <div id="imagePreviewFoto1"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="/noimage.png" alt="Thumbnail 2"></div>
                @endif

                @if($files && count($files)>2)
                <div id="imagePreviewFoto2"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="{{ $files[2]->temporaryUrl() }}" alt="Thumbnail 2"></div>
                @else
                    <div id="imagePreviewFoto2"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="/noimage.png" alt="Thumbnail 2"></div>
                @endif

                @if($files && count($files)>3)
                <div id="imagePreviewFoto3"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="{{ $files[3]->temporaryUrl() }}" alt="Thumbnail 2"></div>
                @else
                    <div id="imagePreviewFoto3"><img onclick="changeImage(this)" class="w-20 h-20 rounded-lg cursor-pointer border-2 border-transparent" src="/noimage.png" alt="Thumbnail 2"></div>
                @endif
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1">
            <div class="col-span-1">
                <div class="flex flex-row mt-2 mb-4 gap-2">
                    <div class="block">
                        <x-label for="cats" class="block text-sm font-medium text-gray-700">Categorías:</x-label>
                        <x-input wire:model="search" class=""
                            name="cats" id="cats"
                            type="text" />
                    </div>
                    <div wire:click="buscar" class="w-8 pt-6"><img src="{{ asset('search.png') }}"></img></div>
                    <div class="inline-flex items-center py-2.5 text-md font-medium text-center text-white pt-6" wire:click="mostrarSeleccionadas">
                        <span class="inline-flex items-center justify-center w-6 h-6 ms-2 text-xs font-semibold text-blue-800 bg-sky-400 rounded-full">
                            {{count($categoriesSelected)}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <div class="flex flex-wrap overflow-auto max-h-60 p-5">
                    @if (count($categories))
                        @foreach ($categories as $c)
                            @if($c->checked)
                            <label class="flex items-center m-1">
                                <span class="bg-sky-400 neon-category-switch" wire:click="toggleCategorySelected({{$c->id}})">
                                        {{ $c->name}}
                                    </span>
                            </label>
                            @else
                            <label class="flex items-center m-1">
                                <span class="bg-gray-200 dark:bg-zinc-900 dark:text-white/70 neon-category-switch" wire:click="toggleCategorySelected({{$c->id}})">
                                    {{ $c->name}}
                                </span>
                            </label>
                            @endif
                        @endforeach
                    @else
                    @endif
                </div>
            </div>
        </div>


        <form wire:submit="save" id="uploadForm">
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
    </div> 
    
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
                <h5 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{$title}}</h5>
            </div>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
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
                    <x-label for="name" class="block text-sm font-medium text-gray-700">Nombre:</x-label>
                    <x-input type="text" name="name" id="name"
                        wire:model="name" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="{{ old('name') }}"/>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="description" class="block text-sm font-medium text-gray-700">Descripción:</x-label>
                    <textarea name="description" id="description"
                        wire:model="description" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            {{ old('description') }}
                    </textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="hidden">
                    <label for="image_url" class="block text-sm font-medium text-gray-700">Portada:</label>
                    <input type="text" name="image_url" id="image_url"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="{{ old('image_url') }}">
                    @error('image_url')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="hidden">
                    <label for="image1_url" class="block text-sm font-medium text-gray-700">Foto 1:</label>
                    <input type="text" name="image1_url" id="image1_url"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="{{ old('image1_url') }}">
                    @error('image1_url')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="hidden">
                    <label for="image2_url" class="block text-sm font-medium text-gray-700">Foto 2:</label>
                    <input type="text" name="image2_url" id="image2_url"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="{{ old('image2_url') }}">
                    @error('image2_url')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="hidden">
                    <label for="image3_url" class="block text-sm font-medium text-gray-700">Foto 3:</label>
                    <input type="text" name="image3_url" id="image3_url"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="{{ old('image3_url') }}">
                    @error('image3_url')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="price" class="block text-sm font-medium text-gray-700">Precio:</x-label>
                    <x-input wire:model="price" type="number" min="1" pattern="[0-9]+([\.,][0-9]+)?" id="price" name="price"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                        value="{{ old('price') }}"/>
                    @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div id="measures" class="mt-2">
                    <div class="grid grid-cols-1">
                        <div class="grid-cols-1 flex flex-row">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Medidas</h3>
                        </div>
                        
                        <div class="grid-cols-1 mt-2 flex flex-row gap-4">
                            <div>
                                <x-label class="block text-sm font-medium text-gray-700">Descripción:</x-label>
                                <x-input type="text" 
                                    wire:model.defer="medida_description" 
                                    class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            </div>
                            <div>
                                <x-label class="block text-sm font-medium text-gray-700">$ Extra:</x-label>
                                <x-input type="number"
                                    wire:model.defer="medida_extra_price" 
                                    class="mt-1 p-2 border border-gray-300 rounded-md w-20" step="0.01"/>
                            </div>
                            <div wire:click="agregarMedida" class="w-8 mt-6 mr-2"><img src="{{ asset('add.png') }}"</img></div>
                            
                        </div>

                        <div class=" grid-cols-1 w-full mt-2">
                            @if (!blank($medidas))
                                <table class="w-full text-sm text-left text-gray-500 ">
                                    <tbody>
                                        @foreach ($medidas as $med)
                                            <tr class="bg-white dark:bg-black">
                                                <th scope="row"
                                                    class="py-1 px-6 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $med->description }}
                                                </th>
                                                <th scope="row"
                                                    class="py-1 px-6 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                    ${{ $med->extra_price }}
                                                </th>
                                                <td class="py-1 text-right">
                                                    <div wire:click="quitarMedida({{ $med->index }})" class="w-8">
                                                        <img src="{{ asset('icons8-cancel-64.png') }}"/>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                
                <div class="hidden">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating:</label>
                    <input type="number" name="rating" id="rating"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="5" min="1" max="5">
                    @error('rating')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="hidden">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Type:</label>
                    <input type="number" name="type" id="type"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        value="1" min="1" max="5">
                    @error('type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            @can('edit product')
                @if($editando)
                <div class="grid grid-cols-2 gap-4">
                    <div wire:click="updateProduct()" 
                        class="w-full mt-4 px-4 bg-indigo-500 text-white block py-2 rounded-md hover:bg-indigo-600 text-center">Guardar</div>
                    <div wire:click="confirmDeleteProduct()" wire:loading.attr="disabled"
                        class="w-full mt-4 px-4 bg-red-500 text-white block py-2 rounded-md hover:bg-red-600 text-center">Borrar</div>
                </div>
                @else
                <div wire:click="saveProduct()" class="w-full mt-4 bg-sky-400 text-white dark:text-black block py-2 px-2 rounded-md hover:bg-sky-500 text-center cursor-pointer">Registrar</div>
                @endif
            @endcan
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