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
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ternas as $terna)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            @php
                                $estudiante = $terna->users()->whereHas('role', function($query) {
                                    $query->where('nombre_role', 'alumno');
                                })->first();
                                $docentesTerna = $terna->users()->whereHas('role', function($query) {
                                    $query->where('nombre_role', 'docente');
                                })->get();
                            @endphp

                            <!-- Estudiante -->
                            <td class="px-6 py-4 font-medium">
                                @if($estudiante)
                                    {{ strtoupper($estudiante->name) }} - {{ $estudiante->numero_cuenta }}
                                @else
                                    <span class="text-gray-400">No asignado</span>
                                @endif
                            </td>

                            <!-- Docentes -->
                            @for($i = 0; $i < 4; $i++)
                                <td class="px-6 py-4">
                                    @if(isset($docentesTerna[$i]))
                                        {{ strtoupper($docentesTerna[$i]->name) }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            @endfor

                            <!-- Estado -->
                            <td class="px-6 py-4">
                                @if($terna->estado_terna == 'Pendiente')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pendiente</span>
                                @elseif($terna->estado_terna == 'En Progreso')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">En Progreso</span>
                                @elseif($terna->estado_terna == 'Aprobado')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aprobado</span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 flex space-x-2">
                               <a href="#"
                                    class="text-blue-600 hover:text-blue-800 editar-btn"
                                    data-id="{{ $terna->id }}"
                                    data-estudiante-id="{{ $estudiante?->id }}"
                                    @foreach($docentesTerna as $index => $docente)
                                        data-docente{{ $index + 1 }}-id="{{ $docente->id }}"
                                    @endforeach
                                    data-docente4-id="{{ $docentesTerna[3]->id ?? '' }}"
                                    data-modal-target="add-terna-modal"
                                    data-modal-toggle="add-terna-modal"
                                    title="Editar">✏️
                                </a>


                                <form id="delete-form-{{ $terna->id }}" action="{{ route('AsignarTerna.destroy', $terna->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="confirmDelete({{ $terna->id }})" class="text-red-600 hover:text-red-800" title="Eliminar">🗑️</button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No hay ternas asignadas todavía
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Agregar Terna -->
    <!-- Modal Agregar Terna -->
        <div id="add-terna-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-lg max-h-full">
                <div class="relative bg-white rounded-lg shadow">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">Agregar Terna</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="add-terna-modal">
                            ✖️
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4">
                        <form id="terna-form" class="space-y-4" method="POST" action="{{ route('AsignarTerna.store') }}">
                            @csrf
                            <input type="hidden" name="_method" value="POST" id="form-method">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Filtrar por Facultad -->
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Filtrar por Facultad</label>
                                    <select id="filtrar_facultad" name="filtrar_facultad" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 h-[42px]">
                                        <option value="">Todos</option>
                                        @foreach($facultades as $facultad)
                                            <option value="{{ $facultad->id }}">{{ $facultad->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtrar por Campus -->
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Filtrar por Campus</label>
                                    <select id="filtrar_campus" name="filtrar_campus" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                        <option value="">Todos</option>
                                        @foreach($campus as $camp)
                                            <option value="{{ $camp->id }}">{{ $camp->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Estudiante -->
                                <div id="estudiante-wrapper">
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Estudiante</label>
                                    <select id="estudiante" name="estudiante" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 h-[42px]" required>
                                        <option value="">Selecciona un estudiante</option>
                                        @foreach($alumnos->sortByDesc('created_at') as $estudiante)
                                            <option value="{{ $estudiante->id }}" data-campus="{{ $estudiante->id_campus }}" data-facultad="{{ $estudiante->id_facultad }}">
                                                {{ $estudiante->name }} - {{ $estudiante->numero_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Docente #1 -->
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Docente #1</label>
                                    <select id="docente1" name="docente1" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                        <option value="" disabled selected>Selecciona un Docente</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" data-campus="{{ $docente->id_campus }}" data-facultad="{{ $docente->id_facultad }}">
                                                {{ $docente->name }} - {{ $docente->numero_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Docente #2 -->
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Docente #2</label>
                                    <select id="docente2" name="docente2" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                        <option value="" disabled selected>Selecciona un Docente</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" data-campus="{{ $docente->id_campus }}" data-facultad="{{ $docente->id_facultad }}">
                                                {{ $docente->name }} - {{ $docente->numero_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Docente #3 -->
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Docente #3</label>
                                    <select id="docente3" name="docente3" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                        <option value="" disabled selected>Selecciona un Docente</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" data-campus="{{ $docente->id_campus }}" data-facultad="{{ $docente->id_facultad }}">
                                                {{ $docente->name }} - {{ $docente->numero_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Docente #4 -->
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-900">Docente #4 (Opcional)</label>
                                    <select id="docente4" name="docente4" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                        <option value="" selected>Selecciona un Docente (Opcional)</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" data-campus="{{ $docente->id_campus }}" data-facultad="{{ $docente->id_facultad }}">
                                                {{ $docente->name }} - {{ $docente->numero_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-6">
                                <button type="button" data-modal-hide="add-terna-modal"
                                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-900">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-4 py-2 rounded text-gray-900 shadow-md" style="background-color: #FFC436;">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS & Estilos -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            .select-custom {
                height: 42px;
                padding: 6px 12px;
                border-radius: 0.5rem;
                border-color: rgb(209, 213, 219);
                width: 100%;
                background-color: rgb(249, 250, 251);
                font-size: 0.875rem;
            }
            .select-custom option:disabled {
                color: #999;
                background-color: #f0f0f0;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.select-search').forEach(select => {
                    select.classList.remove('select-search');
                    select.classList.add('select-custom');
                });

                const form = document.getElementById('terna-form');
                const methodInput = document.getElementById('form-method');

                const filtrarCampus = document.getElementById('filtrar_campus');
                const filtrarFacultad = document.getElementById('filtrar_facultad');
                const estudianteSelect = document.getElementById('estudiante');
                const docenteSelects = [
                    document.getElementById('docente1'),
                    document.getElementById('docente2'),
                    document.getElementById('docente3'),
                    document.getElementById('docente4')
                ];

                const estudiantesOriginales = Array.from(estudianteSelect.options);
                const docentesOriginales = docenteSelects.map(select => Array.from(select.options));

                function filtrarUsuarios() {
                    const campusSeleccionado = filtrarCampus.value;
                    const facultadSeleccionada = filtrarFacultad.value;
                    const estudianteSeleccionado = estudianteSelect.value;
                    const docentesSeleccionados = docenteSelects.map(select => select.value);

                    estudianteSelect.innerHTML = '';
                    estudiantesOriginales.forEach(op => {
                        if (
                            (!campusSeleccionado || op.dataset.campus === campusSeleccionado) &&
                            (!facultadSeleccionada || op.dataset.facultad === facultadSeleccionada) || op.value === ''
                        ) {
                            estudianteSelect.appendChild(op.cloneNode(true));
                        }
                    });

                    docenteSelects.forEach((select, idx) => {
                        select.innerHTML = '';
                        docentesOriginales[idx].forEach(op => {
                            if (
                                (!campusSeleccionado || op.dataset.campus === campusSeleccionado) &&
                                (!facultadSeleccionada || op.dataset.facultad === facultadSeleccionada) || op.value === ''
                            ) {
                                select.appendChild(op.cloneNode(true));
                            }
                        });
                    });

                    estudianteSelect.value = estudianteSeleccionado;
                    docenteSelects.forEach((select, i) => select.value = docentesSeleccionados[i]);
                    actualizarOpciones();
                }

                filtrarCampus.addEventListener('change', filtrarUsuarios);
                filtrarFacultad.addEventListener('change', filtrarUsuarios);

                function actualizarOpciones() {
                    let seleccionados = docenteSelects.map(s => s.value).filter(val => val !== "");
                    docenteSelects.forEach(select => {
                        Array.from(select.options).forEach(option => {
                            if (option.value !== "") {
                                option.disabled = seleccionados.includes(option.value) && option.value !== select.value;
                            }
                        });
                    });
                }

                docenteSelects.forEach(select => {
                    select.addEventListener('change', actualizarOpciones);
                });

                document.querySelectorAll('[data-modal-target="add-terna-modal"]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        setTimeout(actualizarOpciones, 100);
                    });
                });

                document.querySelectorAll('.editar-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        const estudianteId = btn.dataset.estudianteId;
                        const docente1 = btn.dataset.docente1Id;
                        const docente2 = btn.dataset.docente2Id;
                        const docente3 = btn.dataset.docente3Id;
                        const docente4 = btn.dataset.docente4Id;

                        form.action = `/AsignarTerna/${id}`;
                        methodInput.value = 'PUT';
                        document.querySelector('#add-terna-modal h3').textContent = 'Editar Terna';
                        form.querySelector('button[type="submit"]').textContent = 'Actualizar';

                        estudianteSelect.value = estudianteId;
                        estudianteSelect.disabled = true;
                        docenteSelects[0].value = docente1 || '';
                        docenteSelects[1].value = docente2 || '';
                        docenteSelects[2].value = docente3 || '';
                        docenteSelects[3].value = docente4 || '';
                        setTimeout(actualizarOpciones, 100);
                    });
                });

                document.querySelectorAll('[data-modal-hide="add-terna-modal"]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        methodInput.value = 'POST';
                        form.action = `{{ route('AsignarTerna.store') }}`;
                        form.reset();
                        estudianteSelect.disabled = false;
                        filtrarCampus.value = '';
                        filtrarFacultad.value = '';
                        filtrarUsuarios();
                    });
                });
            });

            function confirmDelete(ternaId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Deseas eliminar esta terna? Esta acción no se puede deshacer.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${ternaId}`).submit();
                    }
                });
            }
        </script>
    </div>

</x-app-layout>