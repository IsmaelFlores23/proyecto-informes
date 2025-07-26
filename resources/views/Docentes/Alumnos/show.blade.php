<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex items-start justify-center py-10">
        <div class="w-full md:w-4/5 lg:w-3/4 bg-white rounded-lg shadow p-6">
            <!-- Sección: Información de Usuario -->
            <div class="border border-gray-300 rounded-lg p-6 mb-6 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm"><strong>Nombre: </strong>{{strtoupper($alumno->name) }}</p>
                        <p class="text-sm"><strong>Numero de cuenta:</strong> {{$alumno->numero_cuenta}}</p>
                        <p class="text-sm"><strong>Facultad:</strong> {{$alumno->facultad()->first()->nombre ?? 'Sin facultad'}}</p>
                    </div>
                    <div>
                        <p class="text-sm"><strong>Correo electronico:</strong> {{$alumno->email}}</p>
                        <p class="text-sm"><strong>Teléfono:</strong> {{$alumno->telefono ?? 'No disponible'}}</p>
                        <p class="text-sm"><strong>Campus:</strong> {{$alumno->campus()->first()->nombre ?? 'Sin campus'}}</p>
                    </div>
                </div>
            </div>

            <!-- Sección: Acciones rápidas -->
            <div class="flex justify-center space-x-4 mb-6">
                <a href="{{ route('docente.observacion.create', ['alumno_id' => $alumno->id]) }}" 
                   class="text-white font-medium rounded-lg text-sm px-5 py-2.5 shadow"
                   style="background-color:#004CBE;">
                    Revisar informe
                </a>
                <a href="{{ route('docente.historial.index', ['alumno_id' => $alumno->id]) }}" 
                   class="text-black font-medium rounded-lg text-sm px-5 py-2.5 shadow"
                   style="background-color:#FFC436;">
                    Ver historial
                </a>
            </div>

            <!-- Sección: Terna -->
            <div class="border border-gray-300 rounded-lg p-6 bg-white mb-10">
                <p class="text-sm font-medium mb-4" style="color:#004CBE;">Terna:</p>
                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                    @if($ternaAlumno)
                        <p class="text-sm font-semibold mb-2" style="color:#004CBE;">Estado: {{ $ternaAlumno->estado_terna }}</p>
                        
                        <!-- Estado de aprobación del informe -->
                        @if(isset($ultimoInforme))
                            <div class="mb-4 p-3 rounded-lg {{ $todosAprobaron ? 'bg-green-50 border border-green-200' : 'bg-yellow-50 border border-yellow-200' }}">
                                <h4 class="font-semibold mb-2">
                                    @if($todosAprobaron)
                                        <span class="text-green-600">✓ Informe aprobado por todos los docentes</span>
                                    @else
                                        <span class="text-yellow-600">⚠ Informe pendiente de aprobación</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600 mb-2">Estado de aprobación por docente:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                    @foreach($estadosAprobacion as $estado)
                                        <div class="p-2 rounded-lg border {{ $estado['docente']->id == Auth::id() ? 'border-blue-300' : 'border-gray-200' }}">
                                            <p class="text-sm font-semibold">{{ $estado['docente']->name }}</p>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-block w-2 h-2 rounded-full mr-1
                                                    @if($estado['estado'] == 'Aprobado') bg-green-500
                                                    @elseif($estado['estado'] == 'Pendiente de Aprobación') bg-blue-500
                                                    @elseif($estado['estado'] == 'Informe Cargado') bg-yellow-500
                                                    @else bg-gray-500 @endif">
                                                </span>
                                                <span class="text-xs
                                                    @if($estado['estado'] == 'Aprobado') text-green-600
                                                    @elseif($estado['estado'] == 'Pendiente de Aprobación') text-blue-600
                                                    @elseif($estado['estado'] == 'Informe Cargado') text-yellow-600
                                                    @else text-gray-600 @endif">
                                                    {{ $estado['estado'] }}
                                                </span>
                                            </div>
                                            @if($estado['fecha'])
                                                <p class="text-xs text-gray-500 mt-1">{{ $estado['fecha']->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- Eliminamos la sección duplicada de docentes ya que ahora están dentro de las tarjetas de estado -->
                        @if(count($docentes) == 0)
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500">No hay docentes asignados a esta terna</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <p class="text-sm text-gray-500">Este alumno no tiene una terna asignada</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sección inferior: Informe PDF -->
            <div class="border border-gray-300 rounded-lg p-6 bg-white">
                <p class="text-sm font-medium mb-4" style="color:#004CBE;">Ultimo informe subido:</p>
                <div class="flex justify-center">
                    @if(isset($ultimoInforme))
                        <div class="border border-gray-300 rounded-lg p-6 flex flex-col items-center bg-gray-50 w-full">
                            <p class="text-lg font-semibold mb-2" style="color:#004CBE;">Visualizador web</p>
                            <p class="text-gray-600 mb-2">{{ basename($ultimoInforme) }}</p>
                            <iframe
                                src="{{ route('docente.observacion.pdf', ['nombreArchivo' => basename($ultimoInforme)]) }}"
                                class="w-full h-[600px] rounded border border-gray-300"
                                frameborder="0"
                                scrolling="auto"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <div class="border border-gray-300 rounded-lg p-6 flex flex-col items-center bg-gray-50">
                            <p class="text-lg font-semibold mb-2" style="color:#004CBE;">Sin informes</p>
                            <svg class="w-16 h-16" fill="none" stroke="#004CBE" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="mt-2 text-gray-600">El alumno no ha subido ningún informe</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Botón para volver -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('docente.alumnos.index') }}" 
                   class="px-6 py-2 bg-gray-400 text-white font-semibold rounded-full hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    Volver a la lista de alumnos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>