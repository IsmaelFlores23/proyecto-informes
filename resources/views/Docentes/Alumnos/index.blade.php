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
                    <tr>
                        <td class="px-6 py-4">202220010123</td>
                        <td class="px-6 py-4 font-medium">JUAN PÉREZ</td>
                        <td class="px-6 py-4">juan.perez@ejemplo.com</td>
                        <td class="px-6 py-4">Ingeniería</td>
                        <td class="px-6 py-4 flex space-x-4">
                            <a href="#" class="text-yellow-600 hover:text-yellow-800" title="Ver perfil">👁️</a>
                            <a href="#" class="text-blue-700 hover:text-blue-900" title="Trabajar con el alumno">📃</a>
                            <a href="#" class="text-blue-700 hover:text-blue-900" title="Historial de revisiones">🕑</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">202320050456</td>
                        <td class="px-6 py-4 font-medium">MARÍA GARCÍA</td>
                        <td class="px-6 py-4">maria.garcia@ejemplo.com</td>
                        <td class="px-6 py-4">Ciencias Jurídicas</td>
                        <td class="px-6 py-4 flex space-x-4">
                           <a href="#" class="text-yellow-600 hover:text-yellow-800" title="Ver perfil">👁️</a>
                            <a href="#" class="text-blue-700 hover:text-blue-900" title="Trabajar con el alumno">📃</a>
                            <a href="#" class="text-blue-700 hover:text-blue-900" title="Historial de revisiones">🕑</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">202210030789</td>
                        <td class="px-6 py-4 font-medium">CARLOS MEJÍA</td>
                        <td class="px-6 py-4">carlos.mejia@ejemplo.com</td>
                        <td class="px-6 py-4">Administración</td>
                        <td class="px-6 py-4 flex space-x-4">
                           <a href="#" class="text-yellow-600 hover:text-yellow-800" title="Ver perfil">👁️</a>
                            <a href="#" class="text-blue-700 hover:text-blue-900" title="Trabajar con el alumno">📃</a>
                            <a href="#" class="text-blue-700 hover:text-blue-900" title="Historial de revisiones">🕑</a>
                        </td>
                    </tr>
                    <!-- Puedes seguir agregando más filas manualmente -->
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
