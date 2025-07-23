<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Informe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <form id="informeForm" enctype="multipart/form-data" class="space-y-6">
                <!-- Sección de Subir Archivo -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">Subir</label>
                    <input type="file"
                           name="ruta_informe" 
                           id="file_input" 
                           accept=".pdf,.doc,.docx" 
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('informeForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Evita que el formulario se envíe directamente

            const fileInput = document.getElementById('file_input');
            const descripcion = document.getElementById('descripcion').value.trim();

            const archivoSeleccionado = fileInput.files.length > 0;
            const descripcionValida = descripcion.length > 0;

            if (archivoSeleccionado && descripcionValida) {
                Swal.fire({
                    icon: 'success',
                    title: 'Informe subido correctamente',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    e.target.submit(); // Ahora sí se envía el formulario
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
