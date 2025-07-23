<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Revisiones') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
        @if(isset($alumno))
            <!-- Información del alumno -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Alumno: {{ $alumno->name }}</h3>
                <p>Número de cuenta: <strong>{{ $alumno->numero_cuenta }}</strong></p>
                <p>Correo: {{ $alumno->email }}</p>
            </div>
            
            @if($revisionesPorArchivo->count() > 0)
                <!-- Historial de revisiones agrupadas por archivo -->
                @foreach($revisionesPorArchivo as $nombreArchivo => $revisiones)
                    <div class="mb-8 border-b pb-6">
                        <div class="mb-4">
                            <h4 class="text-md font-semibold bg-yellow-100 px-3 py-1 rounded-full inline-block">
                                Versión: {{ $nombreArchivo }}
                                @php
                                    $partes = explode('_', $nombreArchivo);
                                    $version = isset($partes[1]) ? str_replace('.pdf', '', $partes[1]) : '?';
                                @endphp
                                (v{{ $version }})
                            </h4>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Fecha</th>
                                        <th scope="col" class="px-6 py-3">Docente</th>
                                        <th scope="col" class="px-6 py-3">Comentario</th>
                                        <th scope="col" class="px-6 py-3">Página</th>
                                        <th scope="col" class="px-6 py-3">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($revisiones as $revision)
                                        <tr class="bg-white border-b">
                                            <td class="px-6 py-4">{{ $revision->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 font-medium">{{ $revision->user->name }}</td>
                                            <td class="px-6 py-4">{{ $revision->comentario }}</td>
                                            <td class="px-6 py-4">{{ $revision->numero_pagina }}</td>
                                            <td class="px-6 py-4">
                                                <span class="text-xs px-2 py-1 rounded-full
                                                    @if($revision->estado_revision == 'Aprobado') bg-green-100 text-green-800
                                                    @elseif($revision->estado_revision == 'Pendiente de Aprobación') bg-blue-100 text-blue-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ $revision->estado_revision }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No hay revisiones registradas para este alumno.</p>
                </div>
            @endif
        @else
            <div class="text-center py-8 text-gray-500">
                <p>Seleccione un alumno para ver su historial de revisiones.</p>
            </div>
        @endif
        
        <!-- Botón para volver -->
        <div class="mt-6 flex justify-center">
            <a href="{{ route('docente.alumnos.index') }}" 
               class="px-6 py-2 bg-yellow-400 text-white font-semibold rounded-full hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                Volver a la lista de alumnos
            </a>
        </div>
    </div>
</x-app-layout>