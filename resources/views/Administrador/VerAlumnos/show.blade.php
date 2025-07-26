<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex items-start justify-center py-10">
        <div class="w-full md:w-4/5 lg:w-3/4 bg-white rounded-lg shadow p-6">
            <!-- Sección: Información de Usuario -->
            <div class="border border-gray-300 rounded-lg p-6 mb-6 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        {{-- {{$alumno->name}} la variable $alumno viene de la funucion Show del controlador Almnouser. Se manda a llamar los datos como estan los campos en la BD --}}
                        <p class="text-sm"><strong>Nombre:</strong> {{$alumno->name}}</p>
                        <p class="text-sm"><strong>Numero de cuenta:</strong> {{$alumno->numero_cuenta}}</p>
                        <p class="text-sm"><strong>Facultad:</strong> {{$alumno->facultad()->first()->nombre ?? 'Sin facultad'}}</p>
                        <p class="text-sm"><strong>Numero de telefono:</strong> {{$alumno->telefono}}</p>
                    </div>
                    <div>
                        <p class="text-sm"><strong>Correo electronico:</strong> {{$alumno->email}}</p>
                        <p class="text-sm"><strong>Rol:</strong> Alumno</p>
                        <p class="text-sm"><strong>Campus:</strong> {{$alumno->campus()->first()->nombre ?? 'Sin campus'}}</p>
                    </div>
                </div>
            </div>

            <!-- Sección: Última actividad -->
            <div class="flex justify-center mb-6">
                <button class="text-black font-medium rounded-lg text-sm px-5 py-2.5 shadow"
                        style="background-color:#FFC436;">
                    Ultima actividad: 
                    @if(isset($fechaUltimoInforme))
                        {{ $fechaUltimoInforme->format('d/m/Y h:i a') }}
                    @else
                        Sin actividad registrada
                    @endif
                </button>
            </div>

            <!-- Sección: Terna -->
            <div class="border border-gray-300 rounded-lg p-6 bg-white mb-10">
                <p class="text-sm font-medium mb-4" style="color:#004CBE;">Terna:</p>
                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                    @if($terna)
                        <p class="text-sm font-semibold mb-2" style="color:#004CBE;">Estado: {{ $terna->estado_terna }}</p>
                        
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
                                        <div class="p-2 rounded-lg border border-gray-200">
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
            
            <!-- Sección: Visor de PDF -->
            <div class="border border-gray-300 rounded-lg p-6 bg-white">
                <p class="text-sm font-medium mb-4" style="color:#004CBE;">Último informe subido:</p>
                
                @if(isset($ultimoInforme))
                    <div class="w-full h-[600px] border border-gray-300 rounded-lg overflow-hidden">
                        <iframe src="{{ route('admin.observarInforme.pdf', ['nombreArchivo' => basename($ultimoInforme)]) }}" 
                                class="w-full h-full" frameborder="0"></iframe>
                    </div>
                @else
                    <div class="text-center py-10 border border-gray-300 rounded-lg">
                        <p class="text-gray-500">No hay informes disponibles para este alumno</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
