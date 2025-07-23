<x-app-layout>
    <div class="py-8 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Observaciones --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-yellow-500 font-bold text-xl mb-4">Observaciones</h2>
                @if(isset($revisiones) && $revisiones->count() > 0)
             <div class="flex flex-wrap gap-4">
            @foreach($revisiones as $revision)
            <div class="w-[300px] p-3 border rounded-lg {{ Auth::id() == $revision->id_user ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
            <div class="flex justify-between items-start">
             <div>
            <p class="font-semibold text-sm">{{ $revision->user->name }}</p>
            <p class="text-xs text-gray-500">{{ $revision->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <span class="text-xs px-2 py-1 rounded-full
            @if($revision->estado_revision == 'Aprobado') bg-green-100 text-green-800
            @elseif($revision->estado_revision == 'Pendiente de Aprobación') bg-blue-100 text-blue-800
            @else bg-yellow-100 text-yellow-800 @endif">
            {{ $revision->estado_revision }}
            </span>
            </div>
            <p class="mt-2 text-sm">{{ $revision->comentario }}</p>
            <p class="text-xs text-gray-500 mt-1">Página: {{ $revision->numero_pagina }}</p>
            </div>
            @endforeach
            </div>
            @else
            <div class="text-center py-4 text-gray-500">
            <p>No hay comentarios disponibles</p>
            </div>
            @endif
                {{-- Puedes repetir o hacer un foreach para observaciones reales --}}
            </div>

            {{-- Visualizador PDF --}}
            <div class="bg-white shadow rounded-lg p-7 flex flex-col items-center">
                {{-- Estado etiquetas --}}
                <div class="mt-6 w-full flex justify-center gap-x-4 flex-wrap">
                    @if($estadoInforme == 'pendiente')
                    <span class="bg-red-500 text-white font-semibold px-4 py-2 rounded whitespace-nowrap">
                        Correcciones pendientes
                    </span>
                     @elseif($estadoInforme == 'corregido')
                    <span class="bg-yellow-400 text-white font-semibold px-4 py-2 rounded whitespace-nowrap">
                        Sin correcciones pendientes
                    </span>
                    @elseif($estadoInforme == 'aprobado')
                    <span class="bg-green-500 text-white font-semibold px-4 py-2 rounded whitespace-nowrap mt-2">
                        Informe aprobado
                    </span>
                     @endif
                </div>

                <h2 class="text-xl font-semibold mb-4">Visualizador PDF</h2>

                @if ($ultimoPdf && $pdfNombre)
                    <iframe
                        src="{{ route('observarInforme.pdf', ['nombreArchivo' => $pdfNombre]) }}"
                        class="w-full h-[600px] rounded border border-gray-300"
                        frameborder="0"
                        scrolling="auto"
                        allowfullscreen>
                    </iframe>
                @else
                    <div class="text-center text-gray-500">
                        <p>No se encontró ningún informe para mostrar.</p>
                        <img src="{{ asset('storage/images/pdf-icon.png') }}" alt="PDF" class="mx-auto mt-4" style="width: 80px;">
                    </div>
                @endif

                {{-- Botón para subir subir informe --}}
                <a href="{{ route('subirInforme.create') }}"
                    class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-full">
                    Subir Informe
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
