<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Botón Agregar Facultad -->
        <div class="flex justify-center mb-6">
            <button
                data-modal-target="add-facultad-modal"
                data-modal-toggle="add-facultad-modal"
                class="px-6 py-2 rounded-md font-semibold text-gray-900 shadow-md"
                style="background-color: #FFC436;">
                Agregar Facultad
            </button>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table id="facultades-table" class="min-w-full text-gray-800 bg-gray-200">
                <thead class="text-xs uppercase text-white" style="background-color: #004CBE;">
                    <tr>
                        <th class="px-6 py-3">Código Facultad</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facultades as $facultad)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $facultad->codigo_facultad }}</td>
                            <td class="px-6 py-4 font-medium">{{ $facultad->nombre }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('facultad.edit', $facultad->id) }}" class="text-blue-600 hover:text-blue-800">✏️</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- MODAL Agregar/Editar Facultad -->
    <div id="add-facultad-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 {{ isset($editando) ? '' : 'hidden' }}">
        <div class="relative w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-300 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ isset($editando) ? 'Editar Facultad' : 'Agregar Facultad' }}
                    </h3>
                    <a href="{{ route('facultad.index') }}" class="text-gray-500 hover:text-gray-800">✖️</a>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <form class="space-y-4" action="{{ isset($editando) ? route('facultad.update', $editando->id) : route('facultad.store') }}" method="POST">
                        @csrf
                        @if(isset($editando))
                            @method('PUT')
                        @endif
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900">Código Facultad</label>
                            <input type="text" placeholder="FA001" name="codigo_facultad"
                                value="{{ old('codigo', $editando->codigo ?? '') }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900">Nombre</label>
                            <input type="text" placeholder="Ingeniería" name="nombre"
                                value="{{ old('nombre', $editando->nombre ?? '') }}"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5" required>
                        </div>
                        <!-- Botones -->
                        <div class="flex justify-end space-x-2 pt-4">
                            <a href="{{ route('facultad.index') }}"
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
