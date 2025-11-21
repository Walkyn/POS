<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    isDeleteConfirmModal: false, 
    itemToDelete: null,
    isAddCategoryModal: false,
    isLotesModal: false,
    selectedProduct: null,
    isDeleteLoteModal: false,
    loteToDelete: null,
    showActionsDropdown: false,
    nuevaCategoria: {
        nombre: ''
    },
    confirmDelete() {
        this.isDeleteConfirmModal = false;
        setTimeout(() => { this.itemToDelete = null; }, 200);
        showSuccessToast();
    },
    confirmAddCategory() {
        // Aquí irá la lógica para agregar la categoría (solo diseño por ahora)
        this.isAddCategoryModal = false;
        setTimeout(() => { this.nuevaCategoria = { nombre: '' }; }, 200);
        showSuccessToast();
    },
    openLotesModal(productId) {
        const product = {
            id: productId,
            name: this.getProductName(productId),
            lotes: generateLotes(productId)
        };
        this.selectedProduct = product;
        this.isLotesModal = true;
    },
    getProductName(productId) {
        // Esta función puede ser mejorada para obtener el nombre real del producto
        const productNames = {
            1: 'Laptop Dell Inspiron 15',
            2: 'Mouse Inalámbrico Logitech'
        };
        return productNames[productId] || 'Producto #' + productId;
    },
    eliminarLote(lote) {
        this.loteToDelete = lote;
        this.isDeleteLoteModal = true;
    },
    confirmDeleteLote() {
        const loteId = this.loteToDelete?.id;
        this.isDeleteLoteModal = false;
        setTimeout(() => { this.loteToDelete = null; }, 200);
        showSuccessToast();
        // Aquí puedes actualizar la lista de lotes del producto seleccionado
        if (this.selectedProduct && this.selectedProduct.lotes && loteId) {
            this.selectedProduct.lotes = this.selectedProduct.lotes.filter(l => l.id !== loteId);
        }
    }
}">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-6 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2 lg:w-2/3 order-2 md:order-1 mt-4 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar producto</label>
                                <div class="relative w-full group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400 transition-colors duration-200" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search"
                                        class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                        placeholder="Buscar por nombre, código o categoría...">
                                    <button type="button"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hidden clear-search-button transition-colors duration-200"
                                        onclick="clearSearch()">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Botones Desktop --}}
                        <div class="hidden md:flex md:flex-row gap-3 w-auto order-2">
                            <a href="{{ route('products.create') }}"
                                class="flex-1 flex items-center justify-center py-2.5 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-database mr-2 text-gray-400"></i>
                                Agregar
                            </a>

                            <a href="{{ route('products.lotes') }}"
                                class="flex-1 flex items-center justify-center py-2.5 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Lotes
                            </a>

                            <button @click="isAddCategoryModal = true"
                                type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Categoría
                            </button>
                        </div>

                        {{-- Dropdown Móvil --}}
                        <div class="md:hidden w-full order-1 md:order-2 relative" x-data="{ showDropdown: false }">
                            <button @click="showDropdown = !showDropdown"
                                type="button"
                                class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Opciones
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="showDropdown"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="showDropdown = false"
                                 x-cloak
                                 class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <a href="{{ route('products.create') }}"
                                   @click="showDropdown = false"
                                   class="flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <i class="fas fa-database mr-3 text-blue-600 dark:text-blue-400"></i>
                                    Agregar
                                </a>
                                <a href="{{ route('products.lotes') }}"
                                   @click="showDropdown = false"
                                   class="flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors border-t border-gray-200 dark:border-gray-700">
                                    <svg class="w-4 h-4 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Lotes
                                </a>
                                <button @click="isAddCategoryModal = true; showDropdown = false"
                                    type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors border-t border-gray-200 dark:border-gray-700 text-left">
                                    <svg class="w-4 h-4 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Categoría
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Producto</th>
                                    <th scope="col" class="p-4">Descripción</th>
                                    <th scope="col" class="p-4 min-w-[100px]">Categoría</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Stock</th>
                                    <th scope="col" class="p-4 whitespace-nowrap text-center">Lotes</th>
                                    <th scope="col" class="p-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 product-row" 
                                        data-product-id="1">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12.5 w-15 rounded-md">
                                                <img src="{{ asset('images/product/product-01.png') }}" alt="Product" class="h-full w-full object-cover rounded-md" />
                                            </div>
                                            <div class="flex flex-col flex-1 min-w-0">
                                                <div class="mb-1">
                                                    <span class="text-base font-semibold text-black dark:text-white block">
                                                        Laptop Dell Inspiron 15
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono block">
                                                        1234567890123
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <span class="break-words block">
                                            Laptop Dell Inspiron 15 con procesador Intel Core i5, 8GB RAM, 256GB SSD
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="whitespace-nowrap">Electrónica</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="block">25</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            <button @click.stop="openLotesModal(1)" 
                                                    type="button"
                                                    title="Ver lotes (3)"
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-100 border border-blue-300 rounded-full hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-700 dark:hover:bg-blue-900/50 transition-colors cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                <span>3</span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('products.edit', 1) }}" 
                                               @click.stop
                                               title="Editar"
                                               class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'Laptop Dell Inspiron 15', category: 'Electrónica', stock: '25', lotes: generateLotes(1) }; isDeleteConfirmModal = true;"
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
                                <!-- Producto sin lotes -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 product-row" 
                                        data-product-id="2">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12.5 w-15 rounded-md">
                                                <img src="{{ asset('images/product/product-01.png') }}" alt="Product" class="h-full w-full object-cover rounded-md" />
                                            </div>
                                            <div class="flex flex-col flex-1 min-w-0">
                                                <div class="mb-1">
                                                    <span class="text-base font-semibold text-black dark:text-white block">
                                                        Mouse Inalámbrico Logitech
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono block">
                                                        9876543210987
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <span class="break-words block">
                                            Mouse inalámbrico Logitech con sensor óptico de alta precisión
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="whitespace-nowrap">Accesorios</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="block">50</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-gray-600 bg-gray-100 border border-gray-300 rounded-full dark:bg-gray-800/30 dark:text-gray-400 dark:border-gray-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                0
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('products.edit', 2) }}" 
                                               @click.stop
                                               title="Editar"
                                               class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'Mouse Inalámbrico Logitech', category: 'Accesorios', stock: '50', lotes: [] }; isDeleteConfirmModal = true;"
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
                            </tbody>
                        </table>

                        <div class="md:hidden space-y-4 px-4 pt-0 pb-4">
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
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
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">25</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Lotes</p>
                                        <button @click.stop="openLotesModal(1)" 
                                                type="button"
                                                title="Ver lotes (3)"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-100 border border-blue-300 rounded-full hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-700 dark:hover:bg-blue-900/50 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span>3</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Laptop Dell Inspiron 15 con procesador Intel Core i5, 8GB RAM, 256GB SSD
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('products.edit', 1) }}" 
                                       @click.stop
                                       title="Editar" 
                                       class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <button type="button" title="Eliminar" @click="itemToDelete = { name: 'Laptop Dell Inspiron 15', category: 'Electrónica', stock: '25', lotes: generateLotes(1) }; isDeleteConfirmModal = true;" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Producto sin lotes - Vista móvil -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/product/product-01.png') }}" alt="Product" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                            Mouse Inalámbrico Logitech
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-1">
                                            9876543210987
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Accesorios</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">50</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Lotes</p>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold text-gray-600 bg-gray-100 border border-gray-300 rounded-full dark:bg-gray-800/30 dark:text-gray-400 dark:border-gray-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descripción</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Mouse inalámbrico Logitech con sensor óptico de alta precisión
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('products.edit', 2) }}" 
                                       @click.stop
                                       title="Editar" 
                                       class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <button type="button" title="Eliminar" @click="itemToDelete = { name: 'Mouse Inalámbrico Logitech', category: 'Accesorios', stock: '50', lotes: [] }; isDeleteConfirmModal = true;" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-center md:justify-between items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 text-center md:text-left">
                            Mostrando
                            <span class="font-semibold text-gray-900 dark:text-white">1</span>
                            -
                            <span class="font-semibold text-gray-900 dark:text-white">2</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-white">2</span>
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

        @include('products.modals.delete-product')
        @include('products.modals.add-category')
        @include('products.modals.view-lotes')


    </div>
</main>

<script>
    function generateLotes(productId) {
        const lotes = [];
        for (let i = 1; i <= 3; i++) {
            const numeroLote = 'LOTE-' + String(i).padStart(4, '0');
            const cantidad = Math.floor(Math.random() * 91) + 10;
            const mesesVencimiento = Math.floor(Math.random() * 12) + 1;
            const fechaVencimiento = new Date();
            fechaVencimiento.setMonth(fechaVencimiento.getMonth() + mesesVencimiento);
            const fechaFormateada = String(fechaVencimiento.getDate()).padStart(2, '0') + '/' + 
                                   String(fechaVencimiento.getMonth() + 1).padStart(2, '0') + '/' + 
                                   fechaVencimiento.getFullYear();
            
            lotes.push({
                id: productId * 100 + i,
                numero_lote: numeroLote,
                cantidad: cantidad,
                fecha_vencimiento: fechaFormateada,
                precio_costo: Math.floor(Math.random() * 451) + 50,
                precio_venta: Math.floor(Math.random() * 901) + 100,
                precio_mayoreo: Math.floor(Math.random() * 721) + 80
            });
        }
        return lotes;
    }

    function showSuccessToast() {
                        const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-50';
        toast.innerHTML = '<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span class="sr-only">Check icon</span></div><div class="ms-3 text-sm font-normal">Producto eliminado correctamente.</div><button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.remove()"><span class="sr-only">Close</span><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>';
                    document.body.appendChild(toast);
                        setTimeout(() => {
                        toast.remove();
                    }, 3000);
        }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('simple-search');
        const clearButton = document.querySelector('.clear-search-button');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                if (e.target.value) {
                    if (clearButton) clearButton.classList.remove('hidden');
                } else {
                    if (clearButton) clearButton.classList.add('hidden');
                }
            });
        }
    });


    function clearSearch() {
        const searchInput = document.getElementById('simple-search');
        const clearButton = document.querySelector('.clear-search-button');

        if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
        }

        if (clearButton) clearButton.classList.add('hidden');
    }

    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
    });
    }
</script>
