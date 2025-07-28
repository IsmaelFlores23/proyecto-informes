<x-app-layout>
  <div class="py-4 px-2">
    <div class="flex flex-col md:flex-row gap-4 max-w-7xl mx-auto">
      
      <!-- VISUALIZADOR PDF A LA IZQUIERDA -->
    <div class="w-full md:w-2/3 p-4 bg-white border border-gray-300 rounded-lg shadow flex flex-col">
        <!-- Encabezado -->
        <div class="flex items-center justify-between mb-4">
          <h1 class="text-2xl font-bold text-gray-900">Visualizador PDF</h1>
          
          <a href="{{ route('docente.historial.index', ['alumno_id' => $alumno->id]) }}"
            class="px-4 py-2 rounded-md font-semibold text-gray-900 shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
            style="background-color: #FFC436;">
            📋 Historial revisiones
          </a>

          <!-- Botón Aprobado debajo -->
            <div>
              <button type="button" id="btnAprobado"
                      class="px-4 py-2 rounded-md font-semibold text-white bg-green-600 shadow-md transition-all duration-300 transform hover:scale-105 hover:bg-green-500">
                ✅ Aprobar Informe 
              </button>
            </div>

        </div>




        <script>
       
    </script>

        <!-- Contenedor PDF -->
        <div class="flex-1 bg-gray-100 flex items-center justify-center border rounded overflow-hidden">
          @if (isset($pdfNombre) && $pdfNombre)
            <iframe
              src="{{ route('docente.observacion.pdf', ['nombreArchivo' => $pdfNombre]) }}"
              class="w-full h-full border-none"
              frameborder="0"
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

      <!-- CONTENIDO A LA DERECHA -->
      <div class="w-full md:w-1/3 space-y-4">

        <!-- FORMULARIO -->
        <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
          <h1 class="text-xl font-bold mb-4">
            {{ strtoupper($alumno->name) }} - {{ $alumno->numero_cuenta }}
          </h1>

          <form id="revisionForm" action="{{ route('docente.observacion.store') }}" method="POST" class="mt-4 space-y-4">
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
            
            <!-- Correciones docentes con un contador de caracteres -->
            <div>
              <label for="comentario" class="block mb-2 text-sm font-medium text-gray-900">
                Ingrese Correción
              </label>
              <div class="relative">
                  <textarea id="comentario" name="comentario" rows="3"
                            class="block p-2.5 w-full text-sm border rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Ingrese Corrección..." maxlength="255" oninput="actualizarContador()"></textarea>
                  <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <div id="contador-caracteres">0/255 caracteres</div>
                    <div id="alerta-largo" class="text-red-500 hidden">¡Límite alcanzado!</div>
                  </div>
              </div>



            </div>

            <!-- Botón Pendiente -->
            <div class="border-t pt-4">
              <button type="button" id="btnPendiente"
                      class="w-full px-4 py-3 text-base font-semibold text-white bg-blue-600 rounded-xl shadow-md hover:bg-blue-500 transition duration-200 hover:scale-105 flex items-center justify-center gap-2">
                🔄 Enviar Correcion
              </button>
            </div>

          </form>
        </div>

        <!-- COMENTARIOS -->
        <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
          <h5 class="text-xl font-bold text-gray-900 mb-2">Correciones</h5>
          <p class="text-gray-500 text-sm mb-4">Correciones de todos los docentes</p>

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
                    <p>No hay correciones disponibles</p>
                  </div>
                @endif
            </div>
        </div>  

        <!-- COMENTARIOS POR VERSIÓN -->
        <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
            <h5 class="text-xl font-bold text-gray-900 mb-2">Correcciones por Versión</h5>
            <p class="text-gray-500 text-sm mb-4">Historial de correcciones organizado por versiones</p>

            @if(isset($revisionesPorVersion) && $revisionesPorVersion->count() > 0)
                <div class="space-y-6 max-h-[calc(100vh-300px)] overflow-y-auto">
                    @foreach($revisionesPorVersion as $versionData)
                        <div class="border rounded-lg overflow-hidden">
                            <!-- Encabezado de versión -->
                            <div class="bg-yellow-100 px-4 py-2 border-b">
                                <h4 class="font-semibold text-gray-800">
                                    Versión: {{ $versionData['nombre_archivo'] }}
                                    (v{{ $versionData['version'] }})
                                </h4>
                            </div>
                            
                            <!-- Lista de comentarios -->
                            <div class="divide-y">
                                @foreach($versionData['revisiones'] as $revision)
                                    <div class="p-3 {{ Auth::id() == $revision->id_user ? 'bg-blue-50' : 'bg-white' }}">
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
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-gray-500">
                    <p>No hay correcciones disponibles</p>
                </div>
            @endif
        </div>

        
      </div>
    </div>
  </div>

  <!-- Incluir SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('revisionForm');

    

    // Botón PENDIENTE (queda igual que antes)
    document.getElementById('btnPendiente').addEventListener('click', function () {
      // Validar que el campo comentario no esté vacío
      const comentario = document.getElementById('comentario').value.trim();
       if (comentario === '') {
        Swal.fire({
          title: 'Comentario Obligatorio',
          text: 'Debes agregar un comentario  al informe.',
          icon: 'warning',
          confirmButtonText: 'Entendido'
        });
        return; // Detiene la ejecución aquí
      }




      Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres Enviar Esta Correción?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, Enviar Correción',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          let inputEstado = document.createElement('input');
          inputEstado.type = 'hidden';
          inputEstado.name = 'estado_revision';
          inputEstado.value = 'Pendiente de Aprobación';
          form.appendChild(inputEstado);
          form.submit();
        }
      });
    });

    // Botón APROBADO (un solo listener con la validación)
    document.getElementById('btnAprobado').addEventListener('click', function () {
      const comentario = document.getElementById('comentario').value.trim();

      // Validar primero
      if (comentario === '') {
        Swal.fire({
          title: 'Comentario Obligatorio',
          text: 'Debes agregar un comentario antes de aprobar el informe.',
          icon: 'warning',
          confirmButtonText: 'Entendido'
        });
        return; // Detiene la ejecución aquí
      }

      // Si hay comentario, entonces sí muestra el Swal de confirmación
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres Calificarlo Como Aprobado?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, Calificar Como Aprobado',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          let inputEstado = document.createElement('input');
          inputEstado.type = 'hidden';
          inputEstado.name = 'estado_revision';
          inputEstado.value = 'Aprobado';
          form.appendChild(inputEstado);
          form.submit();
        }
      });
    });
  });
</script>



    <!-- Contador de caracteres en los comentarios hechos por los docentes -->
  <script>
    function actualizarContador() {
      const textarea = document.getElementById('comentario');
      const contador = document.getElementById('contador-caracteres');
      const alerta = document.getElementById('alerta-largo');
      const longitud = textarea.value.length;
      
      contador.textContent = `${longitud}/255 caracteres`;
      
      if (longitud >= 255) {
        alerta.classList.remove('hidden');
        textarea.value = textarea.value.substring(0, 255); // Corta el texto si excede
      } else {
        alerta.classList.add('hidden');
      }
    }

    // Inicializar el contador al cargar la página
    document.addEventListener('DOMContentLoaded', actualizarContador);
  </script>
</x-app-layout>