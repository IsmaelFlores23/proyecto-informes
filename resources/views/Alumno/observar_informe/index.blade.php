<x-app-layout>
   <div class="py-8 px-6">
        <div class="container mx-auto">
            <div class="row">
                {{-- Columna de Observaciones --}}
                <div class="col-md-6 mb-4">
                    {{-- Ejemplo de obserbaciones --}}
                    <div class="bg-white shadow rounded-lg p-4">
                        <h5 class="bg-yellow-500 text-white font-bold inline-block px-4 py-2 rounded mb-3">Observaciones</h5>
                        <p><strong>Fecha:</strong> 7 / 3 / 2025</p>
                        <p><strong>Docente:</strong> Ing. Abraham</p>
                        <p><strong>Observación:</strong> Aplicar Normas APA en la sección 2.</p>
                        <p><strong>Archivo adjunto:</strong> observacion1.pdf</p>
                         
                        ______________________________________________________________________________________


                        <p><strong>Fecha:</strong> 7 / 3 / 2025</p>
                        <p><strong>Docente:</strong> Ing. Abraham</p>
                        <p><strong>Observación:</strong> Aplicar Normas APA en la sección 2.</p>
                        <p><strong>Archivo adjunto:</strong> observacion1.pdf</p>

                        ______________________________________________________________________________________


                        <p><strong>Fecha:</strong> 7 / 3 / 2025</p>
                        <p><strong>Docente:</strong> Ing. Abraham</p>
                        <p><strong>Observación:</strong> Aplicar Normas APA en la sección 2.</p>
                        <p><strong>Archivo adjunto:</strong> observacion1.pdf</p>

                        ______________________________________________________________________________________

                           <p><strong>Fecha:</strong> 7 / 3 / 2025</p>
                        <p><strong>Docente:</strong> Ing. Abraham</p>
                        <p><strong>Observación:</strong> Aplicar Normas APA en la sección 2.</p>
                        <p><strong>Archivo adjunto:</strong> observacion1.pdf</p>

                        ______________________________________________________________________________________

                    </div>
                    
                    {{-- Boton que redirige a la pantalla /subirInforme/Create --}}
                    <div class="mt-4">
                        <a href="/subirInforme/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-full">
                          Subir versión corregida
                        </a>
                    </div>
                </div>

                {{-- Columna de Visualizador PDF --}}
                <div class="col-md-6 mb-4">
                    <div class="bg-white shadow rounded-lg p-4 text-center">
                        <h5 class="text-xl font-semibold mb-2">Visualizador web</h5>
                        <img src="{{ asset('storage/images/pdf-icon.png') }}" alt="PDF" class="mx-auto" style="width: 80px;">
                    </div>

                    {{-- Etiquetas de Estado --}}
                    <div class="text-center mt-6 space-x-3">
                       <span class="bg-red-500 text-white font-semibold px-3 py-1 rounded">Pendiente</span>
                       <span class="bg-yellow-400 text-white font-semibold px-3 py-1 rounded">En Proceso</span>
                       <span class="bg-green-500 text-white font-semibold px-3 py-1 rounded">Finalizado</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>