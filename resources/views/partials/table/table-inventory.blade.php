<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    searchQuery: '',
    activeTab: 'ventas',
    stockMinimo: '',
    stockMaximo: '',
    diferenciaMinima: '',
    diferenciaMaxima: '',
    categoriasSeleccionadas: [],
    filterDropdownOpen: false,
    isUpdateInventoryModal: false,
    isExportingExcel: false,
    exportProgress: 0,
    filtroPeriodo: 'hoy',
    mesSeleccionado: '',
    anioSeleccionado: new Date().getFullYear(),
    usuarioSeleccionado: '',
    showMesDropdown: false,
    showUsuarioDropdown: false,
    usuarios: [
        { id: 1, nombre: 'Juan Pérez' },
        { id: 2, nombre: 'María García' },
        { id: 3, nombre: 'Carlos López' },
        { id: 4, nombre: 'Ana Martínez' }
    ],
    meses: [
        { valor: 1, nombre: 'Enero' },
        { valor: 2, nombre: 'Febrero' },
        { valor: 3, nombre: 'Marzo' },
        { valor: 4, nombre: 'Abril' },
        { valor: 5, nombre: 'Mayo' },
        { valor: 6, nombre: 'Junio' },
        { valor: 7, nombre: 'Julio' },
        { valor: 8, nombre: 'Agosto' },
        { valor: 9, nombre: 'Septiembre' },
        { valor: 10, nombre: 'Octubre' },
        { valor: 11, nombre: 'Noviembre' },
        { valor: 12, nombre: 'Diciembre' }
    ],
    anios: Array.from({length: 5}, (_, i) => new Date().getFullYear() - i),
    categorias: [
        { id: 1, nombre: 'Electrónica' },
        { id: 2, nombre: 'Accesorios' },
        { id: 3, nombre: 'Computadoras' },
        { id: 4, nombre: 'Periféricos' }
    ],
    seleccionarPeriodo(periodo) {
        this.filtroPeriodo = periodo;
        if (periodo === 'mes') {
            this.showMesDropdown = true;
        } else {
            this.showMesDropdown = false;
            this.mesSeleccionado = '';
        }
    },
    exportarReporte() {
        this.exportarExcel();
    },
    formatearFechaHora(fechaHora) {
        if (!fechaHora) return 'N/A';
        const date = new Date(fechaHora);
        return date.toLocaleString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
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
    },
    actualizarInventario() {
        // Abrir modal de confirmación siempre
        console.log('actualizarInventario llamado');
        console.log('isUpdateInventoryModal antes:', this.isUpdateInventoryModal);
        this.isUpdateInventoryModal = true;
        console.log('isUpdateInventoryModal después:', this.isUpdateInventoryModal);
        // Forzar actualización
        this.$nextTick(() => {
            console.log('Después de nextTick:', this.isUpdateInventoryModal);
        });
    },
    confirmarActualizacion() {
        // Filtrar solo los productos con stock físico >= 0 y que tengan cambios
        const cambios = this.inventarioFiltrado.filter(item => 
            item.stock_fisico !== item.stock_actual && item.stock_fisico >= 0
        );
        
        if (cambios.length === 0) {
            this.isUpdateInventoryModal = false;
            return;
        }
        
        // Cerrar modal
        this.isUpdateInventoryModal = false;
        
        // Aquí iría la llamada al backend para actualizar
        console.log('Actualizar inventario:', cambios);
        // TODO: Llamar al endpoint del backend para actualizar el stock
    },
    inventario: [
        {
            id: 1,
            codigo: 'LP001',
            nombre: 'Laptop Dell Inspiron 15',
            categoria: 'Electrónica',
            lote: 'LOTE-001',
            precio: 1200.00,
            cantidad: 2,
            fecha_hora: '2025-01-15 14:30:00'
        },
        {
            id: 2,
            codigo: 'MS002',
            nombre: 'Mouse Inalámbrico Logitech',
            categoria: 'Accesorios',
            lote: 'LOTE-002',
            precio: 35.50,
            cantidad: 5,
            fecha_hora: '2025-01-15 16:45:00'
        }
    ],
    inventarioFiltrado: [],
    init() {
        this.inventarioFiltrado = this.inventario;
    },
    filtrarInventario() {
        const query = this.searchQuery.toLowerCase().trim();
        let filtrados = this.inventario;
        
        // Filtrar por rango de stock
        if (this.stockMinimo && this.stockMinimo !== '') {
            const stockMin = parseInt(this.stockMinimo);
            if (!isNaN(stockMin)) {
                filtrados = filtrados.filter(item => item.stock_actual >= stockMin);
            }
        }
        if (this.stockMaximo && this.stockMaximo !== '') {
            const stockMax = parseInt(this.stockMaximo);
            if (!isNaN(stockMax)) {
                filtrados = filtrados.filter(item => item.stock_actual <= stockMax);
            }
        }
        
        // Filtrar por rango de diferencia
        if (this.diferenciaMinima && this.diferenciaMinima !== '') {
            const diffMin = parseInt(this.diferenciaMinima);
            if (!isNaN(diffMin)) {
                filtrados = filtrados.filter(item => {
                    const diferencia = item.stock_fisico - item.stock_actual;
                    return diferencia >= diffMin;
                });
            }
        }
        if (this.diferenciaMaxima && this.diferenciaMaxima !== '') {
            const diffMax = parseInt(this.diferenciaMaxima);
            if (!isNaN(diffMax)) {
                filtrados = filtrados.filter(item => {
                    const diferencia = item.stock_fisico - item.stock_actual;
                    return diferencia <= diffMax;
                });
            }
        }
        
        // Filtrar por categoría
        if (this.categoriasSeleccionadas.length > 0) {
            const categoriasNombres = this.categorias
                .filter(c => this.categoriasSeleccionadas.includes(c.id))
                .map(c => c.nombre);
            filtrados = filtrados.filter(item => categoriasNombres.includes(item.categoria));
        }
        
        // Filtrar por búsqueda
        if (query) {
            filtrados = filtrados.filter(item => 
                item.nombre.toLowerCase().includes(query) ||
                item.codigo.toLowerCase().includes(query) ||
                (item.lote && item.lote.toLowerCase().includes(query))
            );
        }
        
        this.inventarioFiltrado = filtrados;
    }
}" x-init="filtrarInventario()">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-4 p-4">
                        {{-- Buscador --}}
                        <div class="w-full md:w-1/2 lg:w-2/3 order-2 md:order-1 mt-2 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar en inventario</label>
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
                                        @input="filtrarInventario()"
                                        class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                        placeholder="Buscar por nombre, código o lote...">
                                    <button type="button"
                                        x-show="searchQuery"
                                        @click="searchQuery = ''; filtrarInventario();"
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
                                        @click="filtroPeriodo = 'hoy'; mesSeleccionado = ''; anioSeleccionado = new Date().getFullYear(); usuarioSeleccionado = ''; filtrarInventario();"
                                        class="text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        Limpiar
                                    </button>
                                </div>

                                <div id="accordion-flush" data-accordion="collapse" data-active-classes="text-black dark:text-white"
                                    data-inactive-classes="text-gray-500 dark:text-gray-400">
                                    {{-- Hoy --}}
                                    <h2 id="hoy-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#hoy-body" aria-expanded="false" aria-controls="hoy-body">
                                            <span>Hoy</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="hoy-body" class="hidden" aria-labelledby="hoy-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <button type="button"
                                                @click="seleccionarPeriodo('hoy')"
                                                :class="filtroPeriodo === 'hoy' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'"
                                                class="w-full py-2 px-4 text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                                                Filtrar por hoy
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Mes --}}
                                    <h2 id="mes-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#mes-body" aria-expanded="false"
                                            aria-controls="mes-body">
                                            <span>Mes</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="mes-body" class="hidden" aria-labelledby="mes-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="anio_filtro"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Año</label>
                                                    <select id="anio_filtro" x-model="anioSeleccionado" @change="seleccionarPeriodo('mes')"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                        <template x-for="anio in anios" :key="anio">
                                                            <option :value="anio" x-text="anio"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="mes_filtro"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mes</label>
                                                    <select id="mes_filtro" x-model="mesSeleccionado" @change="seleccionarPeriodo('mes')"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                        <option value="">Seleccione mes</option>
                                                        <template x-for="mes in meses" :key="mes.valor">
                                                            <option :value="mes.valor" x-text="mes.nombre"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Usuario --}}
                                    <h2 id="usuario-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#usuario-body" aria-expanded="false"
                                            aria-controls="usuario-body">
                                            <span>Usuario</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="usuario-body" class="hidden" aria-labelledby="usuario-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <ul class="space-y-2">
                                                <template x-for="usuario in usuarios" :key="usuario.id">
                                                    <li class="flex items-center">
                                                        <input :id="'usuario-' + usuario.id" type="radio" x-model="usuarioSeleccionado" :value="usuario.id"
                                                            class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                        <label :for="'usuario-' + usuario.id"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100" x-text="usuario.nombre"></label>
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
                            <button @click="activeTab = 'ventas'"
                                type="button"
                                :class="activeTab === 'ventas' 
                                    ? 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700' 
                                    : 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Ventas
                            </button>

                            <button @click="activeTab = 'boletas'"
                                type="button"
                                :class="activeTab === 'boletas' 
                                    ? 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700' 
                                    : 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                <i class="fas fa-receipt mr-2"></i>
                                Boletas
                            </button>

                            {{-- Botón Exportar --}}
                            <button type="button"
                                @click="exportarReporte()"
                                class="flex items-center justify-center gap-2 py-2.5 px-6 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                </svg>
                                <span>Exportar</span>
                            </button>
                        </div>

                        {{-- Dropdown Móvil --}}
                        <div class="md:hidden w-full order-1 md:order-2 relative" x-data="{ showDropdown: false }">
                            <button @click="showDropdown = !showDropdown"
                                type="button"
                                class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <i class="fas fa-tasks mr-2 text-gray-400"></i>
                                    <span x-text="activeTab === 'ventas' ? 'Ventas' : 'Boletas'"></span>
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
                                <button @click="activeTab = 'ventas'; showDropdown = false"
                                    type="button"
                                    :class="activeTab === 'ventas' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                    class="w-full flex items-center px-4 py-3 text-sm">
                                    <i class="fas fa-shopping-cart mr-3"></i>
                                    Ventas
                                </button>
                                <button @click="activeTab = 'boletas'; showDropdown = false"
                                    type="button"
                                    :class="activeTab === 'boletas' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700">
                                    <i class="fas fa-receipt mr-3"></i>
                                    Boletas
                                </button>
                                <button type="button"
                                    @click="exportarReporte(); showDropdown = false"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-green-700 dark:text-green-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                    </svg>
                                    Exportar
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
                                    <th scope="col" class="p-4">Lote</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Precio</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Cantidad</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Importe</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in inventarioFiltrado" :key="item.id">
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col">
                                                <div class="mb-1">
                                                    <span class="text-base font-semibold text-black dark:text-white block" x-text="item.nombre"></span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono block" x-text="item.codigo"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="item.lote || 'N/A'"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + (item.precio || 0).toFixed(2)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white" x-text="item.cantidad || 0"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + ((item.precio || 0) * (item.cantidad || 0)).toFixed(2)"></span>
                                        </td>
                                                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="formatearFechaHora(item.fecha_hora)"></span>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="inventarioFiltrado.length === 0">
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-box-open text-3xl mb-2 opacity-50"></i>
                                            <p>No se encontraron registros</p>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        {{-- Vista Móvil --}}
                        <div class="md:hidden px-3 space-y-3 pb-4">
                            <template x-for="(item, index) in inventarioFiltrado" :key="item.id">
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                    {{-- Header con producto --}}
                                    <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 dark:bg-blue-900/30">
                                                <i class="fas fa-shopping-cart text-base text-blue-600 dark:text-blue-400"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="item.nombre"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="item.codigo"></p>
                                            </div>
                                        </div>
                                        <div class="text-right ml-3">
                                            <p class="text-sm font-bold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + (((item.precio || 0) * (item.cantidad || 0)).toFixed(2))"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Importe</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Información principal --}}
                                    <div class="px-4 py-3">
                                        {{-- Grid de información --}}
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Lote</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="item.lote || 'N/A'"></p>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + ((item.precio || 0).toFixed(2))"></p>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cantidad</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="item.cantidad || 0"></p>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Importe</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + (((item.precio || 0) * (item.cantidad || 0)).toFixed(2))"></p>
                                            </div>
                                            <div class="col-span-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha y Hora</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="formatearFechaHora(item.fecha_hora)"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="inventarioFiltrado.length === 0">
                                <div class="py-16 text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                        <i class="fas fa-receipt text-2xl text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No se encontraron registros</p>
                                </div>
                            </template>
                        </div>
                    </div>
                    <nav class="sticky bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg md:shadow-none md:relative md:bg-transparent dark:md:bg-transparent"
                        aria-label="Table navigation">
                        <div class="flex flex-col md:flex-row justify-center md:justify-between items-center md:space-y-0 px-4 py-3 md:p-4">
                            <span class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-2 md:mb-0 text-center md:text-left">
                                Mostrando
                                <span class="font-semibold text-gray-900 dark:text-white" x-text="inventarioFiltrado.length > 0 ? 1 : 0"></span>
                                -
                                <span class="font-semibold text-gray-900 dark:text-white" x-text="inventarioFiltrado.length"></span>
                                de
                                <span class="font-semibold text-gray-900 dark:text-white" x-text="inventarioFiltrado.length"></span>
                            </span>

                            <div class="flex items-center justify-center space-x-3 w-full md:w-auto">
                                <button type="button"
                                    class="flex-1 md:flex-none px-4 py-2.5 md:px-3 md:py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl md:rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 active:bg-gray-200 dark:active:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                    disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <span class="hidden md:inline-flex items-center justify-center text-sm py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 dark:bg-blue-900 dark:border-blue-700 dark:text-blue-300">
                                    1
                                </span>
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
    
    {{-- Modal de Actualización de Inventario --}}
    @include('inventory.modals.update-inventory')
    
    {{-- Modal de Carga - Exportación a Excel --}}
    @include('inventory.modals.export-loading')
</main>

