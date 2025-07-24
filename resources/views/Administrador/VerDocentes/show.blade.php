<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex items-start justify-center py-10">
        <div class="w-full md:w-4/5 lg:w-3/4 bg-white rounded-lg shadow p-6">
            <!-- Sección: Información de Usuario -->
            <div class="border border-gray-300 rounded-lg p-6 mb-6 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm"><strong>Nombre:</strong> {{ $docente->name }}</p>
                        <p class="text-sm"><strong>Numero de empleado:</strong> {{ $docente->numero_cuenta }}</p>
                        <p class="text-sm"><strong>Facultad:</strong> {{ $docente->facultad()->first()->nombre ?? 'Sin facultad' }}</p>
                        <p class="text-sm"><strong>Numero de telefono:</strong> {{$docente->telefono}}</p>
                    </div>
                    <div>
                        <p class="text-sm"><strong>Correo electronico:</strong> {{ $docente->email }}</p>
                        <p class="text-sm"><strong>Rol:</strong> Docente</p>
                        <p class="text-sm"><strong>Campus:</strong> {{ $docente->campus()->first()->nombre ?? 'Sin campus' }}</p>
                    </div>
                </div>
            </div>


            <!-- Sección: Última actividad del docente -->
            <div class="flex justify-center mb-6">
                <div class="text-black font-medium rounded-lg text-sm px-5 py-2.5 shadow cursor-default"
                     style="background-color:#FFC436;">
                    Ultima Actividad: 
                    @if($ultimaRevision)
                        {{ $ultimaRevision->created_at->format('d/m/Y h:i a') }}
                    @else
                        Sin actividad registrada
                    @endif
                </div>
            </div>
            <!-- Sección inferior: Ternas -->
            <div class="border border-gray-300 rounded-lg p-6 bg-white">
                <p class="text-sm font-medium mb-4" style="color:#004CBE;">Ternas a las que pertenece:</p>
                
                @if($ternas->count() > 0)
                    <div class="max-h-96 overflow-y-auto pr-2"> <!-- Contenedor con scroll -->
                        @foreach($ternas as $index => $terna)
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 mb-4">
                                <p class="text-sm font-semibold mb-2" style="color:#004CBE;">Terna #{{ $index + 1 }}</p>
                                
                                @php
                                    // Encontrar al alumno en esta terna
                                    $alumno = $terna->users->first(function($user) {
                                        return $user->role->nombre_role === 'alumno';
                                    });
                                    
                                    // Encontrar a los docentes en esta terna
                                    $docentes = $terna->users->filter(function($user) {
                                        return $user->role->nombre_role === 'docente';
                                    });
                                @endphp
                                
                                @if($alumno)
                                    <p class="text-sm mb-4">Alumno: {{ $alumno->name }}</p>
                                @else
                                    <p class="text-sm mb-4">Alumno: No asignado</p>
                                @endif
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($docentes as $docenteIndex => $docenteTerna)
                                        <div class="bg-white p-3 rounded-lg shadow border border-gray-200">
                                            <p class="text-sm font-semibold">Docente #{{ $docenteIndex + 1 }}:</p>
                                            <p class="text-sm">{{ $docenteTerna->name }}</p>
                                        </div>
                                    @endforeach
                                    
                                    @if($docentes->count() === 0)
                                        <div class="bg-white p-3 rounded-lg shadow border border-gray-200">
                                            <p class="text-sm font-semibold">No hay docentes asignados</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <p class="text-sm text-center">Este docente no pertenece a ninguna terna.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
