<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Informe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Diseno responsive 60% para pantallas grandes. Movil 100%, Tablet 80% --}}
        {{-- <div class="w-full md:w-4/5 lg:w-3/5 xl:w-3/5 mx-auto px-6"> --}}
        {{-- 
        w-1/2   = 50%
        w-3/5   = 60% 
        w-2/3   = 66.67%
        w-3/4   = 75%
        w-4/5   = 80% --}}


        <div class="max-w-4xl mx-auto px-6">
            <form method="POST" action="{{ route('subirInforme.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Sección de Subir Archivo -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">Subir</label>
                    <input type="file"
                           name="ruta_informe" 
                           id="file_input" 
                           accept=".pdf,.doc,.docx" 
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                </div>

                <!-- Sección de Descripción -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">Descripcion</label>
                    <textarea name="descripcion"
                              rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Ingrese una descripción del informe..."></textarea>
                </div>

                <!-- Botones de Acción -->
                <div class="flex space-x-4 pt-4">

                    <button type="submit" 
                            class="px-8 py-2 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        SUBIR
                    </button>


                    <a href="{{ route('observarInforme.index') }}" 
                        class="px-8 py-2 bg-red-600 text-white font-semibold rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            CANCELAR
                    </a>

                </div>
            </form>
        </div>
    </div>


    
</x-app-layout>