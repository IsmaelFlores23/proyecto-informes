<x-app-layout>

    <div class="max-w-6xl mx-auto mt-10">

        <!-- Botón Agregar Administradores -->
        <div class="flex justify-center mb-6">
            <button
                data-modal-target="add-user-modal"
                data-modal-toggle="add-user-modal"
                class="px-6 py-2 rounded-md font-semibold text-gray-900 shadow-md"
                style="background-color: #FFC436;">
                Agregar Docentes
            </button>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table id="search-table" class="min-w-full text-gray-800 bg-gray-200">
                <thead style="background-color: #004CBE;" class="text-xs uppercase text-white">
                    <tr>
                        <th class="px-6 py-3">N° Cuenta</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Email</th>
                        {{-- <th class="px-6 py-3">Contraseña</th>
                        <th class="px-6 py-3">Rol</th> --}}
                        <th class="px-6 py-3">Facultad</th>
                        {{-- <th class="px-6 py-3">Campus</th> --}}
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse($docentes as $docente)
                        <tr>
                            <td class="px-6 py-4">{{ $docente->numero_cuenta }}</td>
                            <td class="px-6 py-4 font-medium">{{ $docente->name }}</td>
                            <td class="px-6 py-4">{{ $docente->email }}</td>
                            {{-- <td class="px-6 py-4">••••••••</td>  --}}
                            {{-- <td class="px-6 py-4">{{ $docente->role()->first()->nombre_role ?? 'Sin rol' }}</td> --}}
                            <td class="px-6 py-4">{{ $docente->facultad()->first()->nombre ?? 'Sin facultad' }}</td>
                            {{-- <td class="px-6 py-4">{{ $docente->campus()->first()->nombre ?? 'Sin campus' }}</td> --}}
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('docentes.show', $docente->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Ver usuario">👁️</a>
                                <a href="{{ route('GestionarDocentes.edit', $docente->id) }}" class="text-blue-600 hover:text-blue-800" title="Editar">✏️</a>

                                
                                <form id="delete-form-{{ $docente->id }}" action="{{ route('GestionarDocentes.destroy', $docente->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="confirmDelete({{ $docente->id }}, '{{ $docente->name }}')" class="text-red-600 hover:text-red-800" title="Eliminar">🗑️</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                No hay docentes registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="add-user-modal" tabindex="-1" aria-hidden="true" 
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 
                justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ isset($editando) ? 'Editar Docente' : 'Agregar Docente' }}
                    </h3>
                    <button type="button" 
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 
                           rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="add-user-modal">
                        ✖️
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4">
                    <form class="space-y-4" action="{{ isset($editando) ? route('GestionarDocentes.update', $editando->id) : route('GestionarDocentes.store') }}" method="POST">
                        @csrf
                        @if(isset($editando))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">N° Cuenta</label>
                                <input name="numero_cuenta" placeholder="1807200400380 (sin guiones)" type="text" 
                                     value="{{ old('numero_cuenta', $editando->numero_cuenta?? '') }}"
                                     class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Nombre</label>
                                <input name="name" placeholder="Ingrese Nombre Completo" type="text" 
                                     value="{{ old('name', $editando->name ?? '') }}"
                                     class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Email</label>
                                <input name="email" placeholder="ejemplo@unicah.edu" type="email" 
                                     value="{{ old('email', $editando->email ?? '') }}"
                                     class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Contraseña</label>
                                <input name="password" placeholder="Mínimo 6 Caracteres" type="password" 
                                     value="{{ old('password', $editando->password ?? '') }}"
                                     class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                            <!-- Removí el campo role porque se asigna automáticamente como 'docente' -->
                            <!-- Sección del formulario donde están los selectores -->
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Facultad</label>
                                <select name="id_facultad" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">Seleccione una Facultad</option>
                                    @foreach($facultades as $facultad)
                                        <option value="{{ $facultad->id }}"{{ (isset($editando) && $editando->id_facultad == $facultad->id) ? 'selected' : '' }}>{{ $facultad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Campus</label>
                                <select name="id_campus" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">Seleccione un Campus</option>
                                    @foreach($campus as $camp)
                                        <option value="{{ $camp->id }}"{{ (isset($editando) && $editando->id_campus == $camp->id) ? 'selected' : '' }}>{{ $camp->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4">
                            <!-- Botones de Acción -->
                            <div class="flex space-x-3">
                                <button type="button" data-modal-hide="add-user-modal"
                                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-900">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-4 py-2 rounded text-gray-900 shadow-md" style="background-color: #FFC436;">
                                     {{ isset($editando) ? 'Actualizar' : 'Guardar' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Margen al buscador de DataTables -->
    <style>
        div.dataTables_filter {
            margin-bottom: 1rem; 
        }
    </style>

    
   <script>
    function confirmDelete(docenteId, docenteNombre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar el docente "${docenteNombre}"? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${docenteId}`).submit();
            }
        });
    }
    </script>
    @if(isset($editando) && request()->is('GestionarDocentes/*/edit'))
        <script>
            window.addEventListener('load', function () {
                const modal = document.getElementById('add-user-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });
        </script>
    @endif


    

</x-app-layout>
