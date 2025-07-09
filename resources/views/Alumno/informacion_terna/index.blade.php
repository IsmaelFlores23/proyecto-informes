<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Datos del estudiante -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h4 class="bg-yellow-500 text-white font-bold inline-block px-4 py-2 rounded mb-3">Datos del estudiante</h4>
                <p>Nombre completo: <strong>Marthin</strong></p>
                <p>Número de empleado / ID institucional: ____________</p>
                <p>Correo institucional: ____________</p>
                <p>Teléfono: ____________</p>
                <p>Campus asignado: ____________</p>
            </div>

            <!-- Terna evaluadora -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black-700 mb-4">Terna evaluadora</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-sm text-left text-black-700">
                        <thead class="bg-gray-200 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2">Nombre del Docente</th>
                                <th class="px-4 py-2">Correo Institucional</th>
                                <th class="px-4 py-2">Estado de Revisión</th>
                                <th class="px-4 py-2">Última actividad</th>
                                <th class="px-4 py-2">Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="px-4 py-2">Dra. Ana López</td>
                                <td class="px-4 py-2">ana.lopez@uni.edu</td>
                                <td class="px-4 py-2">Sin correcciones pendientes</td>
                                <td class="px-4 py-2">12/06/2025</td>
                                <td class="px-4 py-2 text-blue-600 underline cursor-pointer">Ver</td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2">Mtro. Juan Pérez</td>
                                <td class="px-4 py-2">juan.perez@uni.edu</td>
                                <td class="px-4 py-2">Sin correcciones pendientes</td>
                                <td class="px-4 py-2">10/06/2025</td>
                                <td class="px-4 py-2 text-blue-600 underline cursor-pointer">Ver</td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2">Ing. Karla Díaz</td>
                                <td class="px-4 py-2">karla.diaz@uni.edu</td>
                                <td class="px-4 py-2">Correcciones pendientes</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">—</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Historial -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black-700 mb-2">Historial de versiones y revisiones:</h4>
                <p class="text-blue-600 underline cursor-pointer">📄 Ver historial de revisiones</p>
            </div>

            <!-- Comunicación -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black-700 mb-2">Comunicación con la terna</h4>
                <p class="text-blue-600 underline cursor-pointer">✉️ Enviar mensaje a la terna</p>
            </div>

        </div>
    </div>
</x-app-layout>