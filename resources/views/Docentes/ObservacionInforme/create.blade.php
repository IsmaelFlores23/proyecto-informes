<x-app-layout>
   
   <div class="py-4 px-2">
  <div class="flex flex-col md:flex-row gap-4 max-w-7xl mx-auto">
    
    <!-- VISUALIZADOR PDF A LA IZQUIERDA (AHORA MÁS GRANDE) -->
    <div class="w-full md:w-2/3 p-4 bg-white border border-gray-300 rounded-lg shadow">
      <h1 class="mb-2 text-2xl font-bold text-gray-900">Visualizador PDF</h1>
      <div class="w-full aspect-auto bg-gray-100 flex items-center justify-center border rounded">
        <!-- aquí se incrusta el iframe del PDF -->
        @if (isset($pdfNombre) && $pdfNombre)
            <iframe
                src="{{ route('docente.observacion.pdf', ['nombreArchivo' => $pdfNombre]) }}"
                class="w-full h-[700px] rounded border border-gray-300"
                frameborder="0"
                scrolling="auto"
                allowfullscreen>
            </iframe>
        @else
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-5 text-center">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">No hay informe disponible</h5>
                    <p class="mb-3 font-normal text-gray-700">El alumno no ha subido ningún informe.</p>
                </div>
            </div>
        @endif
      </div>
    </div>

    <!-- CONTENIDO A LA DERECHA (AHORA MÁS PEQUEÑO) -->
    <div class="w-full md:w-1/3 space-y-4">

      <!-- FORMULARIO -->
      <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">
          {{ $alumno->name }} - {{ $alumno->numero_cuenta }}
        </h1>

        <form action="{{ route('docente.observacion.store') }}" method="POST" class="mt-4 space-y-4">
          @csrf
          <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
          <input type="hidden" name="nombre_archivo" value="{{ $pdfNombre }}">
          
          <div>
            <label for="numero_pagina" class="block mb-2 text-sm font-medium text-gray-900">
              Número de página
            </label>
            <input type="number" id="numero_pagina" name="numero_pagina" min="1" value="1" 
                   class="block p-2.5 w-full text-sm border rounded focus:ring-blue-500 focus:border-blue-500">
          </div>
          
          <div>
            <label for="comentario" class="block mb-2 text-sm font-medium text-gray-900">
              Ingrese un comentario
            </label>
            <textarea id="comentario" name="comentario" rows="3" class="block p-2.5 w-full text-sm border rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="Ingrese un comentario..."></textarea>
          </div>
          
          <div class="flex justify-end gap-2 border-t pt-2">
            <button type="submit" name="estado_revision" value="Pendiente de Aprobación" class="px-4 py-2 text-xs text-white bg-blue-500 rounded hover:bg-blue-400 focus:ring-4 focus:ring-blue-300">
              Pendiente
            </button>
            <button type="submit" name="estado_revision" value="Aprobado" class="px-4 py-2 text-xs text-white bg-green-500 rounded hover:bg-green-400 focus:ring-4 focus:ring-green-300">
              Aprobado
            </button>
          </div>
        </form>
      </div>

      <!-- COMENTARIOS -->
      <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
        <h5 class="text-xl font-bold text-gray-900 mb-2">Comentarios</h5>
        <p class="text-gray-500 text-sm mb-4">Comentarios de todos los docentes</p>
        
        <!-- Lista de comentarios -->
        <div class="space-y-3 max-h-96 overflow-y-auto">
          @if(isset($revisiones) && $revisiones->count() > 0)
            @foreach($revisiones as $revision)
              <div class="p-3 border rounded-lg {{ Auth::id() == $revision->id_user ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
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
          @else
            <div class="text-center py-4 text-gray-500">
              <p>No hay comentarios disponibles</p>
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>

</x-app-layout>