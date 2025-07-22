<x-app-layout>
    <div class="py-8 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Observaciones --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-yellow-500 font-bold text-xl mb-4">Observaciones</h2>

                {{-- Aquí pones tus observaciones dinámicas o estáticas --}}
                <p><strong>Fecha:</strong> 7 / 3 / 2025</p>
                <p><strong>Docente:</strong> Ing. Abraham</p>
                <p><strong>Observación:</strong> Aplicar Normas APA en la sección 2.</p>
                <p><strong>Archivo adjunto:</strong> observacion1.pdf</p>

                <hr class="my-4">

                {{-- Puedes repetir o hacer un foreach para observaciones reales --}}
            </div>

            {{-- Visualizador PDF --}}
            <div class="bg-white shadow rounded-lg p-7 flex flex-col items-center">
                {{-- Estado etiquetas --}}
                <div class="mt-6 w-full flex justify-center gap-x-4 flex-wrap">
                    <span class="bg-red-500 text-white font-semibold px-4 py-2 rounded whitespace-nowrap">
                        Correcciones pendientes
                    </span>
                    <span class="bg-yellow-400 text-white font-semibold px-4 py-2 rounded whitespace-nowrap">
                        Sin correcciones pendientes
                    </span>
                    <span class="bg-green-500 text-white font-semibold px-4 py-2 rounded whitespace-nowrap mt-2">
                        Informe aprobado
                    </span>
                </div>

                <h2 class="text-xl font-semibold mb-4">Visualizador PDF</h2>

                @if ($ultimoPdf && $pdfNombre)
                    <iframe
                        src="{{ route('observarInforme.pdf', ['nombreArchivo' => $pdfNombre]) }}"
                        class="w-full h-[600px] rounded border border-gray-300"
                        frameborder="0"
                        scrolling="auto"
                        allowfullscreen>
                    </iframe>
                @else
                    <div class="text-center text-gray-500">
                        <p>No se encontró ningún informe para mostrar.</p>
                        <img src="{{ asset('storage/images/pdf-icon.png') }}" alt="PDF" class="mx-auto mt-4" style="width: 80px;">
                    </div>
                @endif

                {{-- Botón para subir subir informe --}}
                <a href="{{ route('subirInforme.create') }}"
                    class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-full">
                    Subir Informe
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
