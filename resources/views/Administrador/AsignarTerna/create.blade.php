<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">

        <!-- Botón Agregar Terna -->
        <div class="flex justify-center mb-6">
            <button
                data-modal-target="add-terna-modal"
                data-modal-toggle="add-terna-modal"
                class="px-6 py-2 rounded-md font-semibold text-gray-900 shadow-md"
                style="background-color: #FFC436;">
                Agregar Terna
            </button>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table id="search-table" class="min-w-full text-gray-800 bg-gray-200">
                <thead style="background-color: #004CBE;" class="text-xs uppercase text-white">
                    <tr>
                        <th class="px-6 py-3">Estudiante</th>
                        <th class="px-6 py-3">Docente #1</th>
                        <th class="px-6 py-3">Docente #2</th>
                        <th class="px-6 py-3">Docente #3</th>
                        <th class="px-6 py-3">Docente #4 (opcional)</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white">
                        <td class="px-6 py-4 font-medium">Juan Pérez - 1807200400</td>
                        <td class="px-6 py-4">Profesor A</td>
                        <td class="px-6 py-4">Profesor B</td>
                        <td class="px-6 py-4">Profesor C</td>
                        <td class="px-6 py-4">Profesor D</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-800" title="Editar">✏️</a>
                            <a href="#" class="text-red-600 hover:text-red-800" title="Eliminar">🗑️</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Agregar Terna -->
    <div id="add-terna-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50
               justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 border-b rounded-t
                           dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Terna
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                               rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center
                               dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-terna-modal">
                        ✖️
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4">
                    <form class="space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estudiante -->
                            <div>
                                <label for="estudiante"
                                    class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Estudiante</label>
                                <select id="estudiante" name="estudiante"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5
                                           dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" disabled selected>Selecciona un estudiante</option>
                                    <option value="1807200400">Juan Pérez - 1807200400</option>
                                    <option value="1807200401">María López - 1807200401</option>
                                    <option value="1807200402">Carlos Gómez - 1807200402</option>
                                </select>
                            </div>

                            <!-- Docente #1 -->
                            <div>
                                <label for="docente1"
                                    class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Docente
                                    #1</label>
                                <select id="docente1" name="docente1"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5
                                           dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" disabled selected>Selecciona el docente #1</option>
                                    <option value="prof_a">Profesor A</option>
                                    <option value="prof_b">Profesor B</option>
                                    <option value="prof_c">Profesor C</option>
                                </select>
                            </div>

                            <!-- Docente #2 -->
                            <div>
                                <label for="docente2"
                                    class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Docente
                                    #2</label>
                                <select id="docente2" name="docente2"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5
                                           dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" disabled selected>Selecciona el docente #2</option>
                                    <option value="prof_a">Profesor A</option>
                                    <option value="prof_b">Profesor B</option>
                                    <option value="prof_c">Profesor C</option>
                                </select>
                            </div>

                            <!-- Docente #3 -->
                            <div>
                                <label for="docente3"
                                    class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Docente
                                    #3</label>
                                <select id="docente3" name="docente3"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5
                                           dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" disabled selected>Selecciona el docente #3</option>
                                    <option value="prof_a">Profesor A</option>
                                    <option value="prof_b">Profesor B</option>
                                    <option value="prof_c">Profesor C</option>
                                </select>
                            </div>

                            <!-- Docente #4 (opcional) -->
                            <div>
                                <label for="docente4"
                                    class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Docente #4
                                    (opcional)</label>
                                <select id="docente4" name="docente4"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5
                                           dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" selected>Selecciona el docente #4 (opcional)</option>
                                    <option value="prof_a">Profesor A</option>
                                    <option value="prof_b">Profesor B</option>
                                    <option value="prof_c">Profesor C</option>
                                </select>
                            </div>
                        </div>

                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-6">
                            <button type="button" data-modal-hide="add-terna-modal"
                                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-900">
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 rounded text-gray-900 shadow-md"
                                style="background-color: #FFC436;">
                                Guardar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        div.dataTables_filter {
            margin-bottom: 1rem;
        }
    </style>
</x-app-layout>
