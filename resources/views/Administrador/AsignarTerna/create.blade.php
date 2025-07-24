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
    <div id="add-terna-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Agregar Terna
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                           rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
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
                            <!-- Estudiante -->

                            {{-- Filtrar por Facultad --}}
                            <div>
                                <label for="estudiante" class="block mb-1 text-sm font-medium text-gray-900">Filtrar por Facultad</label>
                                <select id="filtrar_facultad" name="filtrar_facultad" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 h-[42px]">
                                    <option value="">Todos</option>
                                    @foreach($facultades as $facultad)
                                        <option value="{{ $facultad->id }}">{{ $facultad->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filtrar por Campus --}}
                            <div>
                                <label for="estudiante" class="block mb-1 text-sm font-medium text-gray-900">Filtrar por Campus</label>
                                <select id="filtrar_campus" name="filtrar_campus" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                    <option value="">Todos</option>
                                    @foreach($campus as $camp)
                                        <option value="{{ $camp->id }}">{{ $camp->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="estudiante" class="block mb-1 text-sm font-medium text-gray-900">Estudiante</label>
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
                                <label for="docente1" class="block mb-1 text-sm font-medium text-gray-900">Docente #1</label>
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
                                <label for="docente2" class="block mb-1 text-sm font-medium text-gray-900">Docente #2</label>
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
                                <label for="docente3" class="block mb-1 text-sm font-medium text-gray-900">Docente #3</label>
                                <select id="docente3" name="docente3" class="select-search bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="" disabled selected>Selecciona un Docente</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" data-campus="{{ $docente->id_campus }}" data-facultad="{{ $docente->id_facultad }}">
                                            {{ $docente->name }} - {{ $docente->numero_cuenta }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Docente #4 (opcional) -->
                            <div>
                                <label for="docente4" class="block mb-1 text-sm font-medium text-gray-900">Docente #4 (Opcional)</label>
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

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Estilos personalizados para Select2 -->
    <style>
        /* Estilo para los contenedores de Select2 */
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            padding: 6px 4px !important;
            border-radius: 0.5rem !important;
            border-color: rgb(209, 213, 219) !important;
        }
        
        /* Estilo para el texto dentro del select */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
        }
        
        /* Estilo para la flecha desplegable */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        
        /* Estilo para el dropdown */
        .select2-dropdown {
            border-radius: 0.5rem !important;
            border-color: rgb(209, 213, 219) !important;
        }
        
        /* Estilo para las opciones al hacer hover */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #004CBE !important;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cargar Select2 después de que jQuery esté disponible
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
        script.onload = function() {
            // Inicializar Select2 después de que se cargue
            $('.select-search').select2({
                width: '100%',
                placeholder: "Busca un nombre...",
                allowClear: true,
                height: '42px',
                dropdownCssClass: "select2-dropdown-rounded"
            });
            
            // Asegurarse de que el placeholder funcione correctamente para el select de estudiante
            $('#estudiante').on('select2:unselecting', function() {
                $(this).data('unselecting', true);
            }).on('select2:opening', function(e) {
                if ($(this).data('unselecting')) {
                    $(this).removeData('unselecting');
                    e.preventDefault();
                }
            });
            
            // Aplicar la función de actualizar opciones después de inicializar Select2
            actualizarOpciones();
        };
        document.head.appendChild(script);
        
        const form = document.getElementById('terna-form');
        const methodInput = document.getElementById('form-method');

        // Filtrado por Campus y Facultad
        const filtrarCampus = document.getElementById('filtrar_campus');
        const filtrarFacultad = document.getElementById('filtrar_facultad');
        const estudianteSelect = document.getElementById('estudiante');
        const docenteSelects = [
            document.getElementById('docente1'),
            document.getElementById('docente2'),
            document.getElementById('docente3'),
            document.getElementById('docente4')
        ];

        // Guardar las opciones originales para poder restaurarlas
        const estudiantesOriginales = Array.from(estudianteSelect.options);
        const docentesOriginales = [];
        
        // Guardar las opciones originales de cada selector de docentes
        docenteSelects.forEach(select => {
            docentesOriginales.push(Array.from(select.options));
        });

        // Función para filtrar los selectores
        function filtrarUsuarios() {
            const campusSeleccionado = filtrarCampus.value;
            const facultadSeleccionada = filtrarFacultad.value;

            console.log('Filtrando por Campus:', campusSeleccionado, 'Facultad:', facultadSeleccionada);

            // Restaurar opciones originales antes de filtrar
            // Para estudiantes
            while (estudianteSelect.options.length > 0) {
                estudianteSelect.remove(0);
            }
            
            estudiantesOriginales.forEach(opcion => {
                const debeIncluir = (campusSeleccionado === '' || opcion.dataset.campus === campusSeleccionado) && 
                                    (facultadSeleccionada === '' || opcion.dataset.facultad === facultadSeleccionada);
                
                if (debeIncluir || opcion.value === '') {
                    estudianteSelect.add(opcion.cloneNode(true));
                }
            });

            // Para docentes
            docenteSelects.forEach((docenteSelect, index) => {
                while (docenteSelect.options.length > 0) {
                    docenteSelect.remove(0);
                }
                
                docentesOriginales[index].forEach(opcion => {
                    const debeIncluir = (campusSeleccionado === '' || opcion.dataset.campus === campusSeleccionado) && 
                                        (facultadSeleccionada === '' || opcion.dataset.facultad === facultadSeleccionada);
                    
                    if (debeIncluir || opcion.value === '') {
                        docenteSelect.add(opcion.cloneNode(true));
                    }
                });
            });

            // Reinicializar Select2 después de modificar las opciones
            $(estudianteSelect).val('').trigger('change');
            docenteSelects.forEach(select => {
                $(select).val('').trigger('change');
            });
        }

        // Eventos para los filtros - usar 'change' en lugar de 'click' para detectar cambios en los selectores
        $(filtrarCampus).on('change', filtrarUsuarios);
        $(filtrarFacultad).on('change', filtrarUsuarios);

        // Función para evitar seleccionar el mismo docente en diferentes selectores
        function actualizarOpciones() {
            const docenteSelects = [
                document.getElementById('docente1'),
                document.getElementById('docente2'),
                document.getElementById('docente3'),
                document.getElementById('docente4')
            ];
            
            // Obtener los valores seleccionados actualmente
            let seleccionados = docenteSelects
                .map(s => s.value)
                .filter(val => val !== "");
            
            console.log('Docentes seleccionados:', seleccionados);
            
            // Para cada selector de docente
            docenteSelects.forEach(select => {
                // Primero, mostrar todas las opciones
                Array.from(select.options).forEach(option => {
                    if (option.value === "") return; // No ocultar la opción de placeholder
                    
                    // Ocultar la opción si está seleccionada en otro selector
                    const estaSeleccionadaEnOtro = seleccionados.includes(option.value) && option.value !== select.value;
                    
                    // En Select2 necesitamos manipular tanto el elemento original como el generado por Select2
                    option.disabled = estaSeleccionadaEnOtro;
                });
            });
            
            // Refrescar todos los Select2 para que reflejen los cambios
            docenteSelects.forEach(select => {
                $(select).select2('destroy');
                $(select).select2({
                    width: '100%',
                    placeholder: "Busca un nombre...",
                    allowClear: true,
                    height: '42px',
                    dropdownCssClass: "select2-dropdown-rounded"
                });
            });
        }

        // Agregar eventos de cambio a los selectores de docentes usando el evento de Select2
        docenteSelects.forEach(select => {
            $(select).on('select2:select select2:unselect', function() {
                setTimeout(actualizarOpciones, 0); // Usar setTimeout para asegurar que se ejecute después de que Select2 actualice su estado
            });
        });

        // También ejecutar actualizarOpciones cuando se abra el modal
        $('[data-modal-target="add-terna-modal"]').on('click', function() {
            setTimeout(actualizarOpciones, 100); // Dar tiempo para que el modal se abra y Select2 se inicialice
        });

        // Ejecutar actualizarOpciones después de cargar datos en modo edición
        document.querySelectorAll('.editar-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const estudianteId = btn.dataset.estudianteId;
                const docente1 = btn.dataset.docente1Id;
                const docente2 = btn.dataset.docente2Id;
                const docente3 = btn.dataset.docente3Id;
                const docente4 = btn.dataset.docente4Id;

                // Cambiar a modo editar
                form.action = `/AsignarTerna/${id}`;
                methodInput.value = 'PUT';
                
                // Cambiar el título del modal a "Editar Terna"
                document.querySelector('#add-terna-modal h3').textContent = 'Editar Terna';
                
                // Cambiar el texto del botón a "Actualizar"
                document.querySelector('#terna-form button[type="submit"]').textContent = 'Actualizar';

                // Rellenar los campos
                $('#estudiante').val(estudianteId).trigger('change');
                $('#docente1').val(docente1).trigger('change');
                $('#docente2').val(docente2).trigger('change');
                $('#docente3').val(docente3).trigger('change');
                $('#docente4').val(docente4).trigger('change');
                
                // Ejecutar después de un breve retraso para asegurar que Select2 haya actualizado su estado
                setTimeout(actualizarOpciones, 100);
            });
        });

        // Resetear al cerrar el modal (vuelve a modo crear)
        document.querySelectorAll('[data-modal-hide="add-terna-modal"]').forEach(btn => {
            btn.addEventListener('click', () => {
                methodInput.value = 'POST';
                form.action = `{{ route('AsignarTerna.store') }}`;
                form.reset();
                $('.select-search').val(null).trigger('change');
                
                // Resetear filtros
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


</x-app-layout>