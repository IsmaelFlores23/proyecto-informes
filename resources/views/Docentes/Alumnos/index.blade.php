<x-app-layout>

    <div class="max-w-6xl mx-auto mt-10">

        <!-- Tabla -->
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table id="search-table" class="min-w-full text-gray-800 bg-gray-200">
                <thead style="background-color: #004CBE;" class="text-xs uppercase text-white">
                    <tr>
                        <th class="px-6 py-3">N° Cuenta</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Facultad</th>
                        <th class="px-6 py-3">Acciones</th> 
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($alumnos as $alumno)
                        <tr>
                            <td class="px-6 py-4">{{ $alumno->numero_cuenta }}</td>
                            <td class="px-6 py-4 font-medium">{{ $alumno->name }}</td>
                            <td class="px-6 py-4">{{ $alumno->email }}</td>
                            <td class="px-6 py-4">{{ $alumno->facultad ? $alumno->facultad->nombre : 'No asignada' }}</td>
                            <td class="px-6 py-4 flex space-x-4">
                                <a href="{{ route('alumnos.show', $alumno->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Ver perfil">👁️</a>
                                <a href="{{ route('docente.observacion.create', ['alumno_id' => $alumno->id]) }}" class="text-blue-700 hover:text-blue-900" title="Trabajar con el alumno">📃</a>
                                <a href="{{ route('docente.historial.index', ['alumno_id' => $alumno->id]) }}" class="text-blue-700 hover:text-blue-900" title="Historial de revisiones">🕑</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No tienes alumnos asignados actualmente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Margen al buscador de DataTables -->
    <style>
        div.dataTables_filter {
            margin-bottom: 1rem; 
        }
    </style>

</x-app-layout>
