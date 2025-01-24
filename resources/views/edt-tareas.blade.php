<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                @if(!empty($id))
                    <livewire:tareas.editor-tareas id="{{$id}}"/>
                @else
                    <livewire:tareas.editor-tareas id=""/>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
