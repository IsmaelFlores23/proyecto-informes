<x-app-layout>
   
   <div class="py-4 px-2">
  <div class="flex flex-col md:flex-row gap-4 max-w-7xl mx-auto">
    
    <!-- VISUALIZADOR PDF A LA IZQUIERDA -->
    <div class="w-full md:w-1/3 p-4 bg-white border border-gray-300 rounded-lg shadow">
      <h1 class="mb-2 text-2xl font-bold text-gray-900">Visualizador PDF</h1>
      <div class="w-full aspect-video bg-gray-100 flex items-center justify-center border rounded">
        <!-- aquí incrustas el iframe del PDF -->
        

        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ligth:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" />
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ligth:text-white">Noteworthy technology acquisitions 2021</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700 ligth:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
                <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>
        </div>

      </div>
    </div>

    <!-- CONTENIDO A LA DERECHA -->
    <div class="w-full md:w-2/3 space-y-4">

      <!-- FORMULARIO -->
      <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">
          {{ Auth::user()->name }} - {{ Auth::user()->numero_cuenta }}
        </h1>

        <div class="flex items-center justify-start px-3 py-2 border-t border-gray-200 space-x-4"> 
          <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center">
            Tipo de comentario
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Específico</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">General</a>
              </li>
            </ul>
          </div>
        </div>

        <form class="mt-4 space-y-4">
          <div>
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">
              Ingrese un comentario
            </label>
            <textarea id="message" rows="4" class="block p-2.5 w-full text-sm border rounded focus:ring-blue-500 focus:border-blue-500"
              placeholder="Ingrese un comentario..."></textarea>
          </div>
          <div class="flex justify-end gap-2 border-t pt-2">
            <button type="submit" class="px-4 py-2 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300">
              Comentar
            </button>
            <button type="submit" class="px-4 py-2 text-xs text-white bg-green-500 rounded hover:bg-green-400 focus:ring-4 focus:ring-green-300">
              Aprobado
            </button>
            <button type="submit" class="px-4 py-2 text-xs text-white bg-red-600 rounded hover:bg-red-500 focus:ring-4 focus:ring-red-300">
              Rechazado
            </button>
          </div>
        </form>
      </div>

      <!-- COMENTARIOS -->
      <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
        <h5 class="text-2xl font-bold text-gray-900 mb-2">Comentarios</h5>
        <p class="text-gray-500">Comentarios hechos por {{ Auth::user()->name }}</p>
        <!-- aquí puedes listar los comentarios -->
      </div>

    </div>
  </div>
</div>



    

</x-app-layout>