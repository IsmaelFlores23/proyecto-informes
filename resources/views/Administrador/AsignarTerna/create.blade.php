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
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Nelson Martinez - 1807200500589</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">María Fernández - 1807200500590</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Carlos Méndez - 1807200500591</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Laura Martínez - 1807200500592</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">José Ramírez - 1807200500593</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Sofía González - 1807200500594</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Andrés López - 1807200500595</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Docentes -->
                <div class="relative text-center">
                    <button id="dropdownDocente1Button" data-dropdown-toggle="dropdownDocente1" data-dropdown-placement="bottom"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" type="button">
                        Selecciona el docente #1
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="dropdownDocente1" class="z-10 hidden bg-gray-50 rounded-lg shadow-sm w-[500px]">
                        <ul class="h-[300px] py-2 overflow-y-auto text-gray-700">
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente A</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente B</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente C</a></li>
                        </ul>
                    </div>
                </div>

                <div class="relative text-center">
                    <button id="dropdownDocente2Button" data-dropdown-toggle="dropdownDocente2" data-dropdown-placement="bottom"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" type="button">
                        Selecciona el docente #2
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="dropdownDocente2" class="z-10 hidden bg-gray-50 rounded-lg shadow-sm w-[500px]">
                        <ul class="h-[300px] py-2 overflow-y-auto text-gray-700">
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente A</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente B</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente C</a></li>
                        </ul>
                    </div>
                </div>

                <div class="relative text-center">
                    <button id="dropdownDocente3Button" data-dropdown-toggle="dropdownDocente3" data-dropdown-placement="bottom"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" type="button">
                        Selecciona el docente #3
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="dropdownDocente3" class="z-10 hidden bg-gray-50 rounded-lg shadow-sm w-[500px]">
                        <ul class="h-[300px] py-2 overflow-y-auto text-gray-700">
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente A</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente B</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente C</a></li>
                        </ul>
                    </div>
                </div>

                <div class="relative text-center">
                    <button id="dropdownDocente4Button" data-dropdown-toggle="dropdownDocente4" data-dropdown-placement="bottom"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" type="button">
                        Selecciona el docente #4 (opcional)
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="dropdownDocente4" class="z-10 hidden bg-gray-50 rounded-lg shadow-sm w-[500px]">
                        <ul class="h-[300px] py-2 overflow-y-auto text-gray-700">
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente A</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente B</a></li>
                            <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">Docente C</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Botón Asignar -->
                <div class="mt-6">
                    <button class="text-black bg-[#FFC436] hover:bg-[#e6b130] focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-6 py-2.5">
                        Asignar
                    </button>
                </div>

            </div>
        </div>
    </div>

    
</x-app-layout>
