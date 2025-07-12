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
                                        <a href="#" class="text-blue-600 hover:text-blue-800 editar" data-id="{{ $campus->id }}">✏️</a>
                                        <a href="#" class="text-red-600 hover:text-red-800 borrar" data-id="{{ $campus->id }}">🗑️</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL Agregar Campus -->
    <div id="add-campus-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full overflow-y-auto h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-600 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Campus
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                        data-modal-hide="add-campus-modal">
                        ✖️
                    </button>
                </div>
                <!-- Body -->
                <div class="p-4">
                    <form class="space-y-4" action="{{ route('campus.store') }}" method="POST">
                        @csrf
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Código</label>
                            <input type="text" placeholder="CAMP001" name="codigo_campus"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" placeholder="San Isidro" name="nombre"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>
                        {{-- <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Ubicación</label>
                            <input type="text" placeholder="Tegucigalpa"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div> --}}
                        <div class="flex justify-end space-x-2 pt-2">
                            <button type="button" data-modal-hide="add-campus-modal"
                                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-900">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 rounded text-gray-900 shadow-md"
                                style="background-color: #FFC436;">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
