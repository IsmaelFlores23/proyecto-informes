<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Datos del estudiante -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h4 class="bg-yellow-500 text-white font-bold inline-block px-4 py-2 rounded mb-3">Datos del estudiante</h4>
                <p>Nombre completo: <strong>{{ strtoupper(Auth::user()->name) }}</strong></p>
                <p>Número de cuenta:<strong> {{ Auth::user()->numero_cuenta }}</strong></p>
                <p>Correo institucional:<strong> {{ Auth::user()->email }} </strong></p>
                <p>Teléfono:<strong>{{ Auth::user()->telefono }}</strong></p>
                <p>Campus asignado:<strong>{{ Auth::user()->campus->nombre}}</strong></p>
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
                                <th class="px-4 py-2">Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($docentes as $docente)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ strtoupper($docente->name) }}</td>
                                    <td class="px-4 py-2">{{ $docente->email }}</td>
                                    

                                   
                                       @php
                                            $estados_revision = [
                                                'Informe Cargado' => 'bg-yellow-100 text-yellow-800',
                                                'Pendiente de Aprobación' => 'bg-blue-100 text-blue-800',
                                                'Aprobado' => 'bg-green-100 text-green-800',
                                                
                                            ];
                                            $estado = $docente->estado_revision;
                                            $clasesEstado = $estados_revision[$estado] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                    <td class="px-6 py-4">
                                        <span class="{{ $clasesEstado }} text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $estado ?? 'Sin estado' }}
                                        </span>
                                    </td><!-- Esto hay que hacerlo dinamico tambien, asi que esto queda faltante -->
                                   
                                   
                                   
                                    <td class="px-4 py-2">{{ $docente->ultima_actividad ? $docente->ultima_actividad->format('d/m/Y H:i:s') : 'Sin actividad' }}</td><!-- formato de fecha y hora dinamico -->
                                    <td class="px-4 py-2 text-blue-600 underline cursor-pointer">Ver</td>
                                </tr>
                            @empty
                                <tr class="border-t">
                                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">No se han asignado docentes a tu terna</td>
                                </tr>
                            @endforelse
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