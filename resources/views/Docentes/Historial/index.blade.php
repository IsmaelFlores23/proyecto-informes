<x-app-layout>

 <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Historial de Revisiones') }}
       </h2>
   </x-slot>



     <div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
        <div class="py-12">
            <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 light:bg-gray-700 light:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    fecha de revision 
                                </th>
                                <th scope="col" class="px-6 py-3">
                                   Revisor
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Comentarios
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Estado/Resultado
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white">
                                    2025-07-01
                                </th>
                                <td class="px-6 py-4">
                                    Jonatan Moncada
                                </td>
                                <td class="px-6 py-4">
                                    Comentario sobre el informe de Carlos.
                                </td>
                                <td class="px-6 py-4">
                                    Aprobado
                                </td>
                            </tr>
                            <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white">
                                    2025-07-02
                                </th>
                                <td class="px-6 py-4">
                                    Mario Escobar
                                </td>
                                <td class="px-6 py-4">
                                    Comentario sobre el informe de Carlos.
                                </td>
                                <td class="px-6 py-4">
                                    Rechazado
                                </td>
                            </tr>
                            <tr class="bg-white light:bg-gray-800">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white">
                                    2025-07-03
                                </th>
                                <td class="px-6 py-4">
                                    Abraham Sikaffy
                                </td>
                                <td class="px-6 py-4">
                                    Comentario sobre el informe de Carlos.
                                </td>
                                <td class="px-6 py-4">
                                    Aprobado
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
     </div>

</x-app-layout>