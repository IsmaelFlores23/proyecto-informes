<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Informe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <form method="POST" action="{{ route('subirInforme.store') }}" enctype="multipart/form-data" class="space-y-6" id="informeForm">
                @csrf
                <!-- Sección de Subir Archivo -->
                <div>
                    <div class="flex items-center mb-4">
                        <label class="block text-lg font-semibold text-gray-900">Subir</label>
                        <div class="ml-3 bg-red-200 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                            Solo se aceptan archivos PDF
                        </div>
                    </div>
                    
                    <input type="file"
                           name="ruta_informe" 
                           id="file_input" 
                           accept=".pdf" 
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    
                    <p class="mt-2 text-sm text-gray-500">El archivo debe estar en formato PDF y no exceder los 50MB.</p>
                </div>

                <!-- Sección de Descripción -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">Descripción</label>
                    <textarea name="descripcion"
                              id="descripcion"
                              rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Ingrese una descripción del informe..."></textarea>
                </div>

                <!-- Botones de Acción -->
                <div class="flex space-x-4 pt-4">
                    <button type="submit" 
                            class="px-8 py-2 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        SUBIR
                    </button>

                    <a href="{{ route('observarInforme.index') }}" 
                     class="px-8 py-2 bg-yellow-400 text-white font-semibold rounded-full hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                     Volver al visualizador
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para SweetAlert2 -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script>
        document.getElementById('informeForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Evita que el formulario se envíe directamente
    
            const fileInput = document.getElementById('file_input');
            const descripcion = document.getElementById('descripcion').value.trim();
    
            const archivoSeleccionado = fileInput.files.length > 0;
            const descripcionValida = descripcion.length > 0;
            
            // Validar que el archivo sea PDF
            let archivoPdf = true;
            if (archivoSeleccionado) {
                const archivo = fileInput.files[0];
                const extension = archivo.name.split('.').pop().toLowerCase();
                archivoPdf = extension === 'pdf';
            }
    
            if (archivoSeleccionado && descripcionValida && archivoPdf) {
                // Enviar el formulario directamente sin mostrar la alerta de éxito
                e.target.submit();
            } else if (!archivoPdf) {
                Swal.fire({
                    icon: 'error',
                    title: 'Formato de archivo no válido',
                    text: 'Solo se permiten archivos en formato PDF',
                    confirmButtonColor: '#FFC436'
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Hay campos obligatorios que están vacíos',
                    text: 'Completalos para continuar',
                    confirmButtonColor: '#FFC436'
                });
            }
        });
    </script>

</x-app-layout>
