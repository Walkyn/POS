<main class="h-full pb-16 overflow-y-auto">
    <div>

        <!-- Start block -->
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/4">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar producto</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-auto">
                                        <!-- Icono de lupa (visible por defecto) -->
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 search-icon" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <!-- Icono X (inicialmente oculto) -->
                                        <button type="button"
                                            class="w-5 h-5 text-red-500 hover:text-red-700 hidden clear-search-button"
                                            onclick="clearSearch()">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="text" id="simple-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Buscar producto...">
                                </div>
                            </form>
                        </div>

                        <!-- Botones -->
                        <div class="flex flex-row justify-end space-x-3 md:space-x-3 w-full md:w-auto">
                            <button data-modal-target="modal-backup" data-modal-toggle="modal-backup" type="button"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-database mr-2 text-gray-400"></i>
                                Agregar
                            </button>

                            <button data-modal-target="modal-restore" data-modal-toggle="modal-restore"
                                type="button"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-upload mr-2 text-gray-400"></i>
                                Editar
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <!-- Tabla para desktop -->
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Producto</th>
                                    <th scope="col" class="p-4">Descripción</th>
                                    <th scope="col" class="p-4">Categoría</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Precio</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Stock</th>
                                    <th scope="col" class="p-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Producto 1 -->
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 product-row cursor-pointer" data-product-id="1" onclick="toggleLotes(1, event)">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12.5 w-15 rounded-md">
                                                <img src="{{ asset('images/product/product-01.png') }}" alt="Product" class="h-full w-full object-cover rounded-md" />
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-base font-semibold text-black dark:text-white">
                                                    Laptop Dell Inspiron 15
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">
                                                    1234567890123
                                                </p>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <p class="break-words">Laptop Dell Inspiron 15 con procesador Intel Core i5, 8GB RAM, 256GB SSD</p>
                                    </td>
                                    <td class="px-4 py-3">Electrónica</td>
                                    <td class="px-4 py-3 whitespace-nowrap">$899.99</td>
                                    <td class="px-4 py-3 whitespace-nowrap">25</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <button type="button" title="Editar"
                                                class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </button>
                                            <button type="button" data-modal-target="delete-modal"
                                                data-modal-toggle="delete-modal"
                                                class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Fila expandible para lotes del Producto 1 -->
                                <tr id="lotes-row-1" class="hidden">
                                    <td colspan="6" class="p-0">
                                        @include('products.ver-lotes', ['productId' => 1])
                                    </td>
                                </tr>
                                <!-- Producto 2 -->
                                 <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 product-row cursor-pointer" data-product-id="2" onclick="toggleLotes(2, event)">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12.5 w-15 rounded-md">
                                                <img src="{{ asset('images/product/product-02.png') }}" alt="Product" class="h-full w-full object-cover rounded-md" />
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-base font-semibold text-black dark:text-white">
                                                    Mouse Inalámbrico Logitech
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">
                                                    2345678901234
                                                </p>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <p class="break-words">Mouse inalámbrico ergonómico con sensor óptico de alta precisión, batería recargable</p>
                                    </td>
                                    <td class="px-4 py-3">Accesorios</td>
                                    <td class="px-4 py-3 whitespace-nowrap">$29.99</td>
                                    <td class="px-4 py-3 whitespace-nowrap">150</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <button type="button" title="Editar"
                                                class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </button>
                                            <button type="button" data-modal-target="delete-modal"
                                                data-modal-toggle="delete-modal"
                                                class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            </div>
                                        </td>
                                </tr>
                                <!-- Fila expandible para lotes del Producto 2 -->
                                <tr id="lotes-row-2" class="hidden">
                                    <td colspan="6" class="p-0">
                                        @include('products.ver-lotes', ['productId' => 2])
                                    </td>
                                </tr>
                                <!-- Producto 3 -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 product-row cursor-pointer" data-product-id="3" onclick="toggleLotes(3, event)">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12.5 w-15 rounded-md">
                                                <img src="{{ asset('images/product/product-03.png') }}" alt="Product" class="h-full w-full object-cover rounded-md" />
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-base font-semibold text-black dark:text-white">
                                                    Teclado Mecánico RGB
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">
                                                    3456789012345
                                                </p>
                                            </div>
                                        </div>
                                        </th>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <p class="break-words">Teclado mecánico con switches RGB, retroiluminación personalizable, diseño compacto</p>
                                        </td>
                                    <td class="px-4 py-3">Accesorios</td>
                                    <td class="px-4 py-3 whitespace-nowrap">$79.99</td>
                                    <td class="px-4 py-3 whitespace-nowrap">8</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center space-x-4">
                                            <button type="button" title="Editar"
                                                class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </button>
                                            <button type="button" title="Eliminar" data-modal-target="delete-modal"
                                                    data-modal-toggle="delete-modal"
                                                class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <!-- Fila expandible para lotes del Producto 3 -->
                                <tr id="lotes-row-3" class="hidden">
                                    <td colspan="6" class="p-0">
                                        @include('products.ver-lotes', ['productId' => 3])
                                    </td>
                                </tr>
                                <!-- Producto 4 -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 product-row cursor-pointer" data-product-id="4" onclick="toggleLotes(4, event)">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12.5 w-15 rounded-md">
                                                <img src="{{ asset('images/product/product-04.png') }}" alt="Product" class="h-full w-full object-cover rounded-md" />
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-base font-semibold text-black dark:text-white">
                                                    Monitor Samsung 27"
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">
                                                    4567890123456
                                                </p>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <p class="break-words">Monitor LED 27 pulgadas Full HD, resolución 1920x1080, tiempo de respuesta 5ms</p>
                                    </td>
                                    <td class="px-4 py-3">Electrónica</td>
                                    <td class="px-4 py-3 whitespace-nowrap">$349.99</td>
                                    <td class="px-4 py-3 whitespace-nowrap">0</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <button type="button" title="Editar"
                                                class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </button>
                                            <button type="button" data-modal-target="delete-modal"
                                                data-modal-toggle="delete-modal"
                                                class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        </td>
                                    </tr>
                                <!-- Fila expandible para lotes del Producto 4 -->
                                <tr id="lotes-row-4" class="hidden">
                                    <td colspan="6" class="p-0">
                                        @include('products.ver-lotes', ['productId' => 4])
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Vista móvil - Cards -->
                        <div class="md:hidden space-y-4 p-4">
                            <!-- Producto 1 - Móvil -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm cursor-pointer" onclick="toggleLotes(1, event)">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/product/product-01.png') }}" alt="Product" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                            Laptop Dell Inspiron 15
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-1">
                                            1234567890123
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Electrónica</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">$899.99</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">25</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Laptop Dell Inspiron 15 con procesador Intel Core i5, 8GB RAM, 256GB SSD
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" title="Editar" class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <button type="button" title="Eliminar" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Lotes del Producto 1 - Móvil -->
                            <div id="lotes-mobile-1" class="hidden bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mt-2">
                                @include('products.ver-lotes', ['productId' => 1])
                            </div>

                            <!-- Producto 2 - Móvil -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm cursor-pointer" onclick="toggleLotes(2, event)">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/product/product-02.png') }}" alt="Product" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                            Mouse Inalámbrico Logitech
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-1">
                                            2345678901234
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Accesorios</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">$29.99</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">150</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Mouse inalámbrico ergonómico con sensor óptico de alta precisión, batería recargable
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" title="Editar" class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <button type="button" title="Eliminar" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Lotes del Producto 2 - Móvil -->
                            <div id="lotes-mobile-2" class="hidden bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mt-2">
                                @include('products.ver-lotes', ['productId' => 2])
                            </div>

                            <!-- Producto 3 - Móvil -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm cursor-pointer" onclick="toggleLotes(3, event)">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/product/product-03.png') }}" alt="Product" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                            Teclado Mecánico RGB
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-1">
                                            3456789012345
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Accesorios</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">$79.99</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">8</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Teclado mecánico con switches RGB, retroiluminación personalizable, diseño compacto
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" title="Editar" class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <button type="button" title="Eliminar" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Lotes del Producto 3 - Móvil -->
                            <div id="lotes-mobile-3" class="hidden bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mt-2">
                                @include('products.ver-lotes', ['productId' => 3])
                            </div>

                            <!-- Producto 4 - Móvil -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm cursor-pointer" onclick="toggleLotes(4, event)">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/product/product-04.png') }}" alt="Product" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                            Monitor Samsung 27"
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-1">
                                            4567890123456
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Electrónica</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">$349.99</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">0</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Monitor LED 27 pulgadas Full HD, resolución 1920x1080, tiempo de respuesta 5ms
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" title="Editar" class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <button type="button" title="Eliminar" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Lotes del Producto 4 - Móvil -->
                            <div id="lotes-mobile-4" class="hidden bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mt-2">
                                @include('products.ver-lotes', ['productId' => 4])
                            </div>
                        </div>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-center md:justify-between items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 text-center md:text-left">
                            Mostrando
                            <span class="font-semibold text-gray-900 dark:text-white">1</span>
                            -
                            <span class="font-semibold text-gray-900 dark:text-white">4</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-white">4</span>
                        </span>

                        <ul class="inline-flex items-stretch -space-x-px justify-center">
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white opacity-50 cursor-not-allowed">
                                    <span class="sr-only">Previous</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white bg-blue-50 text-blue-600 border-blue-300">
                                    1
                                    </a>
                                </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white opacity-50 cursor-not-allowed">
                                    <span class="sr-only">Next</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>

        <!-- Delete Modal -->
        <div id="delete-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full h-auto max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-hide="delete-modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                        <div class="p-6 text-center">
                            <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                                fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Está seguro que
                                desea
                            eliminar este producto?</h3>
                            <button id="confirm-delete" type="button"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Sí, eliminar
                            </button>
                            <button type="button" data-modal-hide="delete-modal"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Modal Backup -->
        <div id="modal-backup" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="modal-backup">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                    <div class="p-6">
                        <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                            Agregar Producto
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Aquí irá el formulario para agregar un nuevo producto.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Restore/Editar -->
        <div id="modal-restore" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="modal-restore">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                        </button>
                    <div class="p-6">
                        <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                            Editar Producto
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Aquí irá el formulario para editar el producto seleccionado.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el modal de eliminación
        const deleteModalElement = document.getElementById('delete-modal');
        if (deleteModalElement) {
            const deleteModal = new Modal(deleteModalElement);

            // Manejar el botón de confirmación de eliminación
            const confirmDeleteBtn = document.getElementById('confirm-delete');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    // Aquí solo se muestra el diseño, no hay conexión con la base de datos
                    deleteModal.hide();
                    
                    // Mostrar mensaje de éxito (solo visual)
                        const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-50';
                        toast.innerHTML = `
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal">Producto eliminado correctamente.</div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.remove()">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    `;
                    document.body.appendChild(toast);
                    
                    // Eliminar el toast después de 3 segundos
                        setTimeout(() => {
                        toast.remove();
                    }, 3000);
                });
            }
        }

        // Manejar la búsqueda (solo visual, sin conexión a BD)
        const searchInput = document.getElementById('simple-search');
        const clearButton = document.querySelector('.clear-search-button');
        const searchIcon = document.querySelector('.search-icon');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                if (e.target.value) {
                    // Mostrar X y ocultar lupa
                    if (clearButton) clearButton.classList.remove('hidden');
                    if (searchIcon) searchIcon.classList.add('hidden');
                } else {
                    // Mostrar lupa y ocultar X
                    if (clearButton) clearButton.classList.add('hidden');
                    if (searchIcon) searchIcon.classList.remove('hidden');
                }
            });
        }
    });

    // Función para expandir/colapsar los lotes de un producto
    function toggleLotes(productId, event) {
        // Prevenir que se active si se hace clic en los botones de acciones
        if (event.target.closest('button') || event.target.closest('svg') || event.target.closest('path')) {
            return;
        }

        // Manejar lotes en la tabla de escritorio
        const lotesRow = document.getElementById('lotes-row-' + productId);
        // Manejar lotes en la vista móvil
        const lotesMobile = document.getElementById('lotes-mobile-' + productId);

        // Determinar si está oculto (verificar cualquiera de los dos)
        const isHidden = lotesRow ? lotesRow.classList.contains('hidden') : (lotesMobile ? lotesMobile.classList.contains('hidden') : true);

        // Toggle de la clase hidden para escritorio
        if (lotesRow) {
            lotesRow.classList.toggle('hidden');
        }

        // Toggle de la clase hidden para móvil
        if (lotesMobile) {
            lotesMobile.classList.toggle('hidden');
        }

        // Cerrar otros lotes abiertos cuando se abre uno nuevo
        if (isHidden) {
            // Cerrar lotes de escritorio
            document.querySelectorAll('[id^="lotes-row-"]').forEach(row => {
                if (row.id !== 'lotes-row-' + productId) {
                    row.classList.add('hidden');
                }
            });
            // Cerrar lotes móviles
            document.querySelectorAll('[id^="lotes-mobile-"]').forEach(mobile => {
                if (mobile.id !== 'lotes-mobile-' + productId) {
                    mobile.classList.add('hidden');
                }
            });
        }
    }

    function clearSearch() {
        const searchInput = document.getElementById('simple-search');
        const clearButton = document.querySelector('.clear-search-button');
        const searchIcon = document.querySelector('.search-icon');

        if (searchInput) {
        searchInput.value = '';
        }

        if (clearButton) clearButton.classList.add('hidden');
        if (searchIcon) searchIcon.classList.remove('hidden');
    }

    // Prevenir envío del formulario
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
    });
    }
</script>
