<x-app-layout>

    <div class="flex justify-center mt-10">
        <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
            <div class="flex flex-col items-center space-y-8">

                <!-- Estudiante -->
                <div class="relative text-center">
                    <button id="dropdownUsersButton" data-dropdown-toggle="dropdownUsers" data-dropdown-placement="bottom"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" type="button">
                        Selecciona un estudiante
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>

                    <div id="dropdownUsers" class="z-10 hidden bg-gray-50 rounded-lg shadow-sm w-[500px]">
                        <ul class="h-[400px] py-2 overflow-y-auto text-gray-700">
                            @foreach ($alumnos as $alumno)
                                <li>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100" data-id="{{ $alumno->id }}" data-name="{{ $alumno->name }}">
                                        {{ $alumno->name }} - {{ $alumno->numero_cuenta ?? 'No ID' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Docentes -->
                @for ($i = 1; $i <= 4; $i++)
                    <div class="relative text-center">
                        <button id="dropdownDocente{{ $i }}Button" data-dropdown-toggle="dropdownDocente{{ $i }}" data-dropdown-placement="bottom"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" type="button">
                            Selecciona el docente #{{ $i }}{{ $i == 4 ? ' (opcional)' : '' }}
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div id="dropdownDocente{{ $i }}" class="z-10 hidden bg-gray-50 rounded-lg shadow-sm w-[500px]">
                            <ul class="h-[300px] py-2 overflow-y-auto text-gray-700 docente-list" data-dropdown="{{ $i }}">
                                @foreach ($docentes as $docente)
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 docente-item" data-id="{{ $docente->id }}" data-name="{{ $docente->name }}" data-dropdown="{{ $i }}">
                                            {{ $docente->name }} - {{ $docente->numero_cuenta ?? 'No ID' }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endfor

                <!-- Botón Asignar -->
                <div class="mt-6">
                    <button class="text-black bg-[#FFC436] hover:bg-[#e6b130] focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-6 py-2.5">
                        Asignar
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script>
        // Variables para guardar las selecciones de docentes
        const selectedDocentes = {};

        document.querySelectorAll('.docente-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const dropdownNum = this.getAttribute('data-dropdown');

                // Guardar la selección
                selectedDocentes[dropdownNum] = {id, name};

                // Actualizar texto del botón
                const button = document.getElementById('dropdownDocente' + dropdownNum + 'Button');
                button.innerHTML = name + ` <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>`;

                // Ocultar dropdown
                const dropdown = document.getElementById('dropdownDocente' + dropdownNum);
                dropdown.classList.add('hidden');

                // Actualizar listas para quitar docentes ya seleccionados
                updateDocentesLists();
            });
        });

        function updateDocentesLists() {
            // Obtener IDs de docentes ya seleccionados
            const selectedIds = Object.values(selectedDocentes).map(d => d.id);

            document.querySelectorAll('.docente-list').forEach(list => {
                const dropdownNum = list.getAttribute('data-dropdown');

                list.querySelectorAll('.docente-item').forEach(item => {
                    const id = item.getAttribute('data-id');

                    // Mostrar solo si no está seleccionado y no es el seleccionado actual
                    if (!selectedIds.includes(id) || selectedDocentes[dropdownNum]?.id === id) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Guardar seleccion de alumno
        document.querySelectorAll('#dropdownUsers a').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();

                const name = this.getAttribute('data-name');
                const button = document.getElementById('dropdownUsersButton');

                button.innerHTML = name + ` <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>`;

                // Ocultar el dropdown
                document.getElementById('dropdownUsers').classList.add('hidden');
            });
        });
    </script>

</x-app-layout>
