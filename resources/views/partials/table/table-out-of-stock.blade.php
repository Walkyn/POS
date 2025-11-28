<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    searchQuery: '',
    fechaInicio: '',
    fechaFin: '',
    stockMinimo: '',
    categoriasSeleccionadas: [],
    categorias: [
        { id: 1, nombre: 'Electrónica' },
        { id: 2, nombre: 'Accesorios' },
        { id: 3, nombre: 'Computadoras' },
        { id: 4, nombre: 'Periféricos' }
    ],
    productos: [
        {
            id: 1,
            codigo: 'LP001',
            nombre: 'Laptop Dell Inspiron 15',
            categoria: 'Electrónica',
            lote: 'LOTE-001',
            stock_actual: 0,
            stock_minimo: 10,
            precio_costo: 800.00,
            ultimo_movimiento: '2025-01-15',
            dias_agotado: 5
        },
        {
            id: 2,
            codigo: 'MS002',
            nombre: 'Mouse Inalámbrico Logitech',
            categoria: 'Accesorios',
            lote: 'LOTE-002',
            stock_actual: 0,
            stock_minimo: 20,
            precio_costo: 25.50,
            ultimo_movimiento: '2025-01-10',
            dias_agotado: 10
        },
        {
            id: 3,
            codigo: 'KB003',
            nombre: 'Teclado Mecánico RGB',
            categoria: 'Periféricos',
            lote: 'LOTE-003',
            stock_actual: 0,
            stock_minimo: 15,
            precio_costo: 120.00,
            ultimo_movimiento: '2025-01-12',
            dias_agotado: 8
        },
        {
            id: 4,
            codigo: 'HD004',
            nombre: 'Disco Duro SSD 1TB',
            categoria: 'Computadoras',
            lote: 'LOTE-004',
            stock_actual: 0,
            stock_minimo: 5,
            precio_costo: 150.00,
            ultimo_movimiento: '2025-01-08',
            dias_agotado: 12
        },
        {
            id: 5,
            codigo: 'MN005',
            nombre: 'Monitor LG 27 pulgadas',
            categoria: 'Electrónica',
            lote: 'LOTE-005',
            stock_actual: 0,
            stock_minimo: 8,
            precio_costo: 300.00,
            ultimo_movimiento: '2025-01-05',
            dias_agotado: 15
        }
    ],
    productosFiltrados: [],
    isExportingExcel: false,
    exportProgress: 0,
    init() {
        this.filtrarProductos();
    },
    filtrarProductos() {
        const query = this.searchQuery.toLowerCase().trim();
        let filtrados = this.productos;
        
        // Filtrar por stock mínimo
        if (this.stockMinimo && this.stockMinimo !== '') {
            const stockMin = parseInt(this.stockMinimo);
            if (!isNaN(stockMin)) {
                filtrados = filtrados.filter(item => item.stock_minimo <= stockMin);
            }
        }
        
        // Filtrar por categoría
        if (this.categoriasSeleccionadas.length > 0) {
            const categoriasNombres = this.categorias
                .filter(c => this.categoriasSeleccionadas.includes(c.id))
                .map(c => c.nombre);
            filtrados = filtrados.filter(item => categoriasNombres.includes(item.categoria));
        }
        
        // Filtrar por fecha de último movimiento
        if (this.fechaInicio) {
            filtrados = filtrados.filter(item => new Date(item.ultimo_movimiento) >= new Date(this.fechaInicio));
        }
        if (this.fechaFin) {
            filtrados = filtrados.filter(item => new Date(item.ultimo_movimiento) <= new Date(this.fechaFin));
        }
        
        // Filtrar por búsqueda
        if (query) {
            filtrados = filtrados.filter(item => 
                item.nombre.toLowerCase().includes(query) ||
                item.codigo.toLowerCase().includes(query) ||
                (item.lote && item.lote.toLowerCase().includes(query)) ||
                item.categoria.toLowerCase().includes(query)
            );
        }
        
        this.productosFiltrados = filtrados;
    },
    formatearFecha(fecha) {
        return new Date(fecha).toLocaleDateString('es-ES', { 
            day: '2-digit', 
            month: '2-digit', 
            year: 'numeric' 
        });
    },
    getDiasAgotadoColor(dias) {
        if (dias <= 7) return 'text-yellow-600 dark:text-yellow-400';
        if (dias <= 15) return 'text-orange-600 dark:text-orange-400';
        return 'text-red-600 dark:text-red-400';
    },
    exportarExcel() {
        // Resetear progreso
        this.exportProgress = 0;
        // Mostrar modal de loading
        this.isExportingExcel = true;
        
        // Simular exportación con progreso (aquí iría la llamada real al backend)
        let progress = 0;
        const interval = setInterval(() => {
            progress += 2;
            this.exportProgress = progress;
            if (progress >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    this.isExportingExcel = false;
                    this.exportProgress = 0;
                    // Aquí se descargaría el archivo Excel
                    console.log('Exportar a Excel');
                }, 300);
            }
        }, 40);
    }
}" x-init="filtrarProductos()">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-4 p-4">
                        {{-- Buscador --}}
                        <div class="w-full md:w-1/2 lg:w-2/3 order-2 md:order-1 mt-2 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar productos</label>
                                <div class="relative w-full group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400 transition-colors duration-200" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                        x-model="searchQuery"
                                        @input="filtrarProductos()"
                                        class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                        placeholder="Buscar por nombre, código o categoría...">
                                    <button type="button"
                                        x-show="searchQuery"
                                        @click="searchQuery = ''; filtrarProductos();"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Botón de Filtros --}}
                        <div class="w-full md:w-auto order-1 md:order-2 relative" x-data="{ 
                            filterOpen: false,
                            cerrarTodasLasSecciones() {
                                setTimeout(() => {
                                    const accordionButtons = document.querySelectorAll('#filterDropdown [data-accordion-target]');
                                    accordionButtons.forEach(btn => {
                                        const target = btn.getAttribute('data-accordion-target');
                                        const body = document.querySelector(target);
                                        if (body && !body.classList.contains('hidden')) {
                                            body.classList.add('hidden');
                                            btn.setAttribute('aria-expanded', 'false');
                                            const icon = btn.querySelector('[data-accordion-icon]');
                                            if (icon) icon.classList.remove('rotate-180');
                                        }
                                    });
                                }, 50);
                            }
                        }">
                            <button id="filterDropdownButton"
                                @click="filterOpen = !filterOpen; if (filterOpen) cerrarTodasLasSecciones();"
                                type="button"
                                class="w-full md:w-auto flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-filter mr-2"></i>
                                Filtrar
                                <svg class="ml-2 w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': filterOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown de Filtros --}}
                            <div id="filterDropdown"
                                x-show="filterOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                @click.away="filterOpen = false"
                                x-cloak
                                class="absolute z-50 w-full md:w-80 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <h6 class="text-sm font-medium text-gray-900 dark:text-white">Filtros</h6>
                                    <button type="button" id="limpiar-filtros"
                                        @click="fechaInicio = ''; fechaFin = ''; stockMinimo = ''; categoriasSeleccionadas = []; filtrarProductos();"
                                        class="text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        Limpiar
                                    </button>
                                </div>

                                <div id="accordion-flush" data-accordion="collapse" data-active-classes="text-black dark:text-white"
                                    data-inactive-classes="text-gray-500 dark:text-gray-400">
                                    {{-- Stock Mínimo --}}
                                    <h2 id="stock-minimo-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#stock-minimo-body" aria-expanded="false" aria-controls="stock-minimo-body">
                                            <span>Stock Mínimo</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="stock-minimo-body" class="hidden" aria-labelledby="stock-minimo-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <div>
                                                <label for="stock_minimo"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Mínimo</label>
                                                <input type="number" id="stock_minimo" name="stock_minimo" x-model="stockMinimo" @input="filtrarProductos()" min="0"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3"
                                                    placeholder="Ej: 5, 10, 20...">
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mostrar productos con stock mínimo menor o igual al valor ingresado</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Fecha de Último Movimiento --}}
                                    <h2 id="fecha-movimiento-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#fecha-movimiento-body" aria-expanded="false" aria-controls="fecha-movimiento-body">
                                            <span>Fecha de Último Movimiento</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="fecha-movimiento-body" class="hidden" aria-labelledby="fecha-movimiento-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="fecha_movimiento_inicio"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Inicio</label>
                                                    <input type="date" id="fecha_movimiento_inicio" name="fecha_movimiento_inicio" x-model="fechaInicio" @change="filtrarProductos()"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                </div>
                                                <div>
                                                    <label for="fecha_movimiento_fin"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Fin</label>
                                                    <input type="date" id="fecha_movimiento_fin" name="fecha_movimiento_fin" x-model="fechaFin" @change="filtrarProductos()"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Categoría --}}
                                    <h2 id="categoria-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#categoria-body" aria-expanded="false"
                                            aria-controls="categoria-body">
                                            <span>Categoría</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="categoria-body" class="hidden" aria-labelledby="categoria-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <ul class="space-y-2">
                                                <template x-for="categoria in categorias" :key="categoria.id">
                                                    <li class="flex items-center">
                                                        <input :id="'categoria-' + categoria.id" type="checkbox" x-model="categoriasSeleccionadas" :value="categoria.id" @change="filtrarProductos()"
                                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                        <label :for="'categoria-' + categoria.id"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100" x-text="categoria.nombre"></label>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones Desktop --}}
                        <div class="hidden md:flex md:flex-row gap-3 w-auto order-3">
                            <a href="{{ route('inventory') }}"
                                type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-boxes mr-2"></i>
                                Stock
                            </a>

                            <a href="{{ route('inventory.movements') }}"
                                type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-exchange-alt mr-2"></i>
                                Movimientos
                            </a>

                            <a href="{{ route('inventory.expired') }}"
                                type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-calendar-times mr-2"></i>
                                Vencidos
                            </a>

                            <button type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Agotados
                            </button>
                        </div>

                        {{-- Dropdown Móvil --}}
                        <div class="md:hidden w-full order-1 md:order-2 relative" x-data="{ showDropdown: false }">
                            <button @click="showDropdown = !showDropdown"
                                type="button"
                                class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2 text-gray-400"></i>
                                    Agotados
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
                                <a href="{{ route('inventory') }}"
                                    type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-boxes mr-3"></i>
                                    Stock
                                </a>
                                <a href="{{ route('inventory.movements') }}"
                                    type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-exchange-alt mr-3"></i>
                                    Movimientos
                                </a>
                                <a href="{{ route('inventory.expired') }}"
                                    type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-calendar-times mr-3"></i>
                                    Vencidos
                                </a>
                                <button type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                                    <i class="fas fa-exclamation-triangle mr-3"></i>
                                    Agotados
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        {{-- Tabla Desktop --}}
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Producto</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Lote</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Stock</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Último Movimiento</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Días Agotado</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(producto, index) in productosFiltrados" :key="producto.id">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-900 dark:text-white" x-text="producto.nombre"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="producto.codigo"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap" x-text="producto.lote || 'N/A'"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white" x-text="producto.stock_minimo"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="formatearFecha(producto.ultimo_movimiento)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span :class="'text-sm font-semibold ' + getDiasAgotadoColor(producto.dias_agotado)" x-text="producto.dias_agotado + ' días'"></span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <button type="button"
                                                @click.stop="exportarExcel()"
                                                title="Exportar a Excel"
                                                class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                <i class="fas fa-file-excel h-4 w-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="productosFiltrados.length === 0">
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-exclamation-triangle text-3xl mb-2 opacity-50"></i>
                                            <p>No se encontraron productos agotados</p>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        {{-- Vista Móvil --}}
                        <div class="md:hidden px-3 space-y-3 pb-4">
                            <template x-for="(producto, index) in productosFiltrados" :key="producto.id">
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                    {{-- Header con días agotado --}}
                                    <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div :class="'w-10 h-10 rounded-full flex items-center justify-center ' + (producto.dias_agotado <= 7 ? 'bg-yellow-100 dark:bg-yellow-900/30' : producto.dias_agotado <= 15 ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-red-100 dark:bg-red-900/30')">
                                                <i :class="'fas fa-exclamation-triangle text-base ' + getDiasAgotadoColor(producto.dias_agotado)"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="producto.nombre"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="producto.codigo"></p>
                                            </div>
                                        </div>
                                        <div class="text-right ml-3">
                                            <span :class="'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ' + (producto.dias_agotado <= 7 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : producto.dias_agotado <= 15 ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400')" x-text="producto.dias_agotado + ' días'"></span>
                                        </div>
                                    </div>
                                    
                                    {{-- Información principal --}}
                                    <div class="px-4 py-3">
                                        {{-- Grid de información --}}
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Lote</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="producto.lote || 'N/A'"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="producto.stock_minimo"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Último Movimiento</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="formatearFecha(producto.ultimo_movimiento)"></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Botón de acción --}}
                                    <div class="px-4 pb-4 pt-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                        <button type="button"
                                            @click.stop="exportarExcel()"
                                            title="Exportar a Excel"
                                            class="w-full flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                                            <i class="fas fa-file-excel h-4 w-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <template x-if="productosFiltrados.length === 0">
                                <div class="py-16 text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-2xl text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No se encontraron productos agotados</p>
                                </div>
                            </template>
                        </div>
                    </div>
                    {{-- Paginación --}}
                    <nav class="sticky bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg md:shadow-none md:relative md:bg-transparent dark:md:bg-transparent">
                        <div class="flex flex-col md:flex-row justify-center md:justify-between items-center md:space-y-0 px-4 py-3 md:p-4">
                            <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-2 md:mb-0 text-center md:text-left">
                                Mostrando <span class="font-semibold text-gray-900 dark:text-white" x-text="productosFiltrados.length"></span> de <span class="font-semibold text-gray-900 dark:text-white" x-text="productos.length"></span>
                            </div>
                            <div class="flex items-center justify-center space-x-3 w-full md:w-auto">
                                <button type="button"
                                    class="flex-1 md:flex-none px-4 py-2.5 md:px-3 md:py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl md:rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 active:bg-gray-200 dark:active:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                    disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button"
                                    class="flex-1 md:flex-none px-4 py-2.5 md:px-3 md:py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl md:rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 active:bg-gray-200 dark:active:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                    disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
    </div>
    
    {{-- Modal de Carga - Exportación a Excel --}}
    @include('inventory.modals.export-loading')
</main>

