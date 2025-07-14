<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">

        <!-- Botón Agregar Campus -->
        <div class="flex justify-center mb-6">
            <button
                data-modal-target="add-campus-modal"
                data-modal-toggle="add-campus-modal"
                class="px-6 py-2 rounded-md font-semibold text-gray-900 shadow-md"
                style="background-color: #FFC436;">
                Agregar Campus
            </button>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table id="campus-table" class="min-w-full text-gray-800 bg-gray-200">
                <thead class="text-xs uppercase text-white" style="background-color: #004CBE;">
                    <tr>
                        <th class="px-6 py-3">Código</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($campuses as $campus)
                            <tr>
                                <td class="px-6 py-4">{{ $campus->codigo_campus }}</td>
                                <td class="px-6 py-4 font-medium">{{ $campus->nombre }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('campus.edit', $campus->id) }}" class="text-blue-600 hover:text-blue-800">✏️</a>

                                        <form id="delete-form-{{ $campus->id }}" action="{{ route('campus.destroy', $campus->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete({{ $campus->id }}, '{{ $campus->nombre }}')" class="text-red-600 hover:text-red-800">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(campusId, campusNombre) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Deseas eliminar el campus "${campusNombre}"? Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${campusId}`).submit();
                }
            });
        }
    </script>


    <!-- MODAL Agregar Campus -->
    <div id="add-campus-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 {{ isset($editando) ? '' : 'hidden' }}">
            <div class="relative w-full max-w-md">
                <div class="bg-white rounded-lg shadow-lg">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-600 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ isset($editando) ? 'Editar Campus' : 'Agregar Campus' }}
                    </h3>
                    <a href="{{ route('campus.index') }}" class="text-gray-500 hover:text-gray-800">✖️</a>
                </div>
                <!-- Body -->
                <div class="p-4">
                     <form class="space-y-4" action="{{ isset($editando) ? route('campus.update', $editando->id) : route('campus.store') }}" method="POST">
                        @csrf
                        @if(isset($editando))
                            @method('PUT')
                        @endif
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Código</label>
                            <input type="text" placeholder="CAMP001" name="codigo_campus"
                                value="{{ old('codigo_campus', $editando->codigo_campus ?? '') }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" placeholder="San Isidro" name="nombre"
                                value="{{ old('nombre', $editando->nombre ?? '') }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>
                        {{-- <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Ubicación</label>
                            <input type="text" placeholder="Tegucigalpa"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div> --}}

                        <!-- Botones -->
                        <div class="flex justify-end space-x-2 pt-2">
                             <a href="{{ route('campus.index') }}"
                               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-900">Cancelar</a>
                            <button type="submit"
                                class="px-4 py-2 rounded text-gray-900 shadow-md"
                                style="background-color: #FFC436;">
                                {{ isset($editando) ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
