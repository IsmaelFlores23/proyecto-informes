<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex items-start justify-center py-10">
        <div class="w-full md:w-4/5 lg:w-3/4 bg-white rounded-lg shadow p-6">
            <!-- Sección: Información de Usuario -->
            <div class="border border-gray-300 rounded-lg p-6 mb-6 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm"><strong>Nombre:</strong> Nelson Emilio Martinez Rodriguez</p>
                        <p class="text-sm"><strong>Numero de cuenta:</strong> 1807200500589</p>
                        <p class="text-sm"><strong>Facultad:</strong> Ingenieria en ciencias de la computacion</p>
                    </div>
                    <div>
                        <p class="text-sm"><strong>Correo electronico:</strong> Nemartinez2003@gmail.com</p>
                        <p class="text-sm"><strong>Rol:</strong> Estudiante</p>
                        <p class="text-sm"><strong>Campus:</strong> San Isidro</p>
                    </div>
                </div>
            </div>

            <!-- Sección: Última conexión -->
            <div class="flex justify-center mb-6">
                <button class="text-black font-medium rounded-lg text-sm px-5 py-2.5 shadow"
                        style="background-color:#FFC436;">
                    Ultima conexion: 07/07/2025 11:25 pm
                </button>
            </div>

            <!-- Sección inferior: Informe PDF -->
            <div class="border border-gray-300 rounded-lg p-6 bg-white">
                <p class="text-sm font-medium mb-4" style="color:#004CBE;">Ultimo informe subido:</p>
                <div class="flex justify-center">
                    <div class="border border-gray-300 rounded-lg p-6 flex flex-col items-center bg-gray-50">
                        <p class="text-lg font-semibold mb-2" style="color:#004CBE;">Visualizador web</p>
                        <svg class="w-16 h-16" fill="none" stroke="#004CBE" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="mt-2 text-gray-600">PDF</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
