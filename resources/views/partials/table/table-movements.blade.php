<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    searchQuery: '',
    tipoFiltro: 'todos',
    fechaInicio: '',
    fechaFin: '',
    tiposSeleccionados: [],
    usuariosSeleccionados: [],
    usuarios: [
        { id: 1, name: 'Juan Pérez' },
        { id: 2, name: 'María García' },
        { id: 3, name: 'Carlos Rodríguez' },
        { id: 4, name: 'Ana Martínez' },
        { id: 5, name: 'Luis Sánchez' }
    ],
    showFilterDropdown: false,
    movimientos: [
        {
            id: 1,
            fecha: '2025-01-20',
            hora: '14:30:25',
            tipo: 'entrada',
            producto_codigo: 'LP001',
            producto_nombre: 'Laptop Dell Inspiron 15',
            lote: 'LOTE-001',
            cantidad: 10,
            usuario: 'Juan Pérez',
            referencia: 'COMP-2025-001',
            observaciones: 'Compra a proveedor TechStore'
        },
        {
            id: 2,
            fecha: '2025-01-20',
            hora: '15:15:10',
            tipo: 'salida',
            producto_codigo: 'MS002',
            producto_nombre: 'Mouse Inalámbrico Logitech',
            lote: 'LOTE-002',
            cantidad: -5,
            usuario: 'María García',
            referencia: 'VENT-2025-045',
            observaciones: 'Venta al cliente'
        },
        {
            id: 3,
            fecha: '2025-01-19',
            hora: '10:20:00',
            tipo: 'ajuste',
            producto_codigo: 'KB003',
            producto_nombre: 'Teclado Mecánico RGB',
            lote: 'LOTE-003',
            cantidad: 2,
            usuario: 'Carlos Rodríguez',
            referencia: 'AJT-2025-012',
            observaciones: 'Modificación: Stock ajustado de 15 a 17 unidades. Precio de costo actualizado de $45.00 a $47.50'
        },
        {
            id: 4,
            fecha: '2025-01-18',
            hora: '09:10:15',
            tipo: 'entrada',
            producto_codigo: 'MN005',
            producto_nombre: 'Monitor LG 27 pulgadas',
            lote: 'LOTE-005',
            cantidad: 15,
            usuario: 'Luis Sánchez',
            referencia: 'COMP-2025-002',
            observaciones: 'Compra a proveedor Digital Solutions'
        }
    ],
    movimientosFiltrados: [],
    isExportingExcel: false,
    exportProgress: 0,
    init() {
        this.filtrarMovimientos();
    },
    filtrarMovimientos() {
        const query = this.searchQuery.toLowerCase().trim();
        let filtrados = this.movimientos;
        
        // Filtrar por tipo de movimiento (checkboxes)
        if (this.tiposSeleccionados.length > 0) {
            filtrados = filtrados.filter(item => this.tiposSeleccionados.includes(item.tipo));
        }
        
        // Filtrar por fecha
        if (this.fechaInicio) {
            filtrados = filtrados.filter(item => new Date(item.fecha) >= new Date(this.fechaInicio));
        }
        if (this.fechaFin) {
            filtrados = filtrados.filter(item => new Date(item.fecha) <= new Date(this.fechaFin));
        }
        
        // Filtrar por usuario
        if (this.usuariosSeleccionados.length > 0) {
            const usuariosNombres = this.usuarios
                .filter(u => this.usuariosSeleccionados.includes(u.id))
                .map(u => u.name);
            filtrados = filtrados.filter(item => usuariosNombres.includes(item.usuario));
        }
        
        // Filtrar por búsqueda
        if (query) {
            filtrados = filtrados.filter(item => 
                item.producto_nombre.toLowerCase().includes(query) ||
                item.producto_codigo.toLowerCase().includes(query) ||
                (item.lote && item.lote.toLowerCase().includes(query)) ||
                item.referencia.toLowerCase().includes(query) ||
                item.usuario.toLowerCase().includes(query)
            );
        }
        
        // Ordenar por fecha y hora (más reciente primero)
        filtrados.sort((a, b) => {
            const fechaA = new Date(a.fecha + ' ' + a.hora);
            const fechaB = new Date(b.fecha + ' ' + b.hora);
            return fechaB - fechaA;
        });
        
        this.movimientosFiltrados = filtrados;
    },
    getTipoColor(tipo) {
        const colores = {
            entrada: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            salida: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            ajuste: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
        };
        return colores[tipo] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
    },
    getTipoLabel(tipo) {
        const labels = {
            entrada: 'Entrada',
            salida: 'Salida',
            ajuste: 'Modificación'
        };
        return labels[tipo] || tipo;
    },
    getTipoIcon(tipo) {
        const icons = {
            entrada: 'fa-arrow-down',
            salida: 'fa-arrow-up',
            ajuste: 'fa-edit'
        };
        return icons[tipo] || 'fa-circle';
    },
    formatearFecha(fecha) {
        return new Date(fecha).toLocaleDateString('es-ES', { 
            day: '2-digit', 
            month: '2-digit', 
            year: 'numeric' 
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
    }
}" x-init="filtrarMovimientos()">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-4 p-4">
                        {{-- Buscador --}}
                        <div class="w-full md:w-1/2 lg:w-2/3 order-2 md:order-1 mt-2 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar movimientos</label>
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
                                        @input="filtrarMovimientos()"
                                        class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                        placeholder="Buscar por producto, código, lote, referencia o usuario...">
                                    <button type="button"
                                        x-show="searchQuery"
                                        @click="searchQuery = ''; filtrarMovimientos();"
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
                                class="w-full md:w-auto flex items-center justify-between py-2.5 px-4 md:px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <i class="fas fa-cog mr-2 text-gray-400"></i>
                                    Opciones
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': filterOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <h6 class="text-sm font-medium text-gray-900 dark:text-white">Opciones</h6>
                                    <button type="button" id="limpiar-filtros"
                                        @click="fechaInicio = ''; fechaFin = ''; tiposSeleccionados = []; usuariosSeleccionados = []; filtrarMovimientos();"
                                        class="text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        Limpiar
                                    </button>
                                </div>

                                <div id="accordion-flush" data-accordion="collapse" data-active-classes="text-black dark:text-white"
                                    data-inactive-classes="text-gray-500 dark:text-gray-400">
                                    {{-- Acciones --}}
                                    <h2 id="acciones-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#acciones-body" aria-expanded="false"
                                            aria-controls="acciones-body">
                                            <span>Acciones</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="acciones-body" class="hidden" aria-labelledby="acciones-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <button type="button"
                                                @click="exportarExcel(); filterOpen = false"
                                                class="w-full flex items-center justify-center py-2.5 px-4 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                <i class="fas fa-file-excel mr-2"></i>
                                                Exportar
                                            </button>
                                        </div>
                                    </div>
                                    {{-- Fecha --}}
                                    <h2 id="fecha-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#fecha-body" aria-expanded="false" aria-controls="fecha-body">
                                            <span>Fecha</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="fecha-body" class="hidden" aria-labelledby="fecha-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="fecha_inicio"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Inicio</label>
                                                    <input type="date" id="fecha_inicio" name="fecha_inicio" x-model="fechaInicio" @change="filtrarMovimientos()"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                </div>
                                                <div>
                                                    <label for="fecha_fin"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Fin</label>
                                                    <input type="date" id="fecha_fin" name="fecha_fin" x-model="fechaFin" @change="filtrarMovimientos()"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tipo de Movimiento --}}
                                    <h2 id="tipo-movimiento-heading">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#tipo-movimiento-body" aria-expanded="false"
                                            aria-controls="tipo-movimiento-body">
                                            <span>Tipo de Movimiento</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="tipo-movimiento-body" class="hidden" aria-labelledby="tipo-movimiento-heading" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <ul class="space-y-2">
                                                <li class="flex items-center">
                                                    <input id="tipo-entrada" type="checkbox" x-model="tiposSeleccionados" value="entrada" @change="filtrarMovimientos()"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="tipo-entrada"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Entrada</label>
                                                </li>
                                                <li class="flex items-center">
                                                    <input id="tipo-salida" type="checkbox" x-model="tiposSeleccionados" value="salida" @change="filtrarMovimientos()"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="tipo-salida"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Salida</label>
                                                </li>
                                                <li class="flex items-center">
                                                    <input id="tipo-ajuste" type="checkbox" x-model="tiposSeleccionados" value="ajuste" @change="filtrarMovimientos()"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="tipo-ajuste"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Modificación</label>
                                                </li>
                                            </ul>
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
                                                        <input :id="'usuario-' + usuario.id" type="checkbox" x-model="usuariosSeleccionados" :value="usuario.id" @change="filtrarMovimientos()"
                                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                        <label :for="'usuario-' + usuario.id"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100" x-text="usuario.name"></label>
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

                            <button type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700">
                                <i class="fas fa-exchange-alt mr-2"></i>
                                Movimientos
                            </button>

                            <a href="{{ route('inventory.expired') }}"
                                type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-calendar-times mr-2"></i>
                                Vencidos
                            </a>

                            <a href="{{ route('inventory.out-of-stock') }}"
                                type="button"
                                class="flex-1 flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Agotados
                            </a>
                        </div>

                        {{-- Dropdown Móvil --}}
                        <div class="md:hidden w-full order-1 md:order-2 relative" x-data="{ showDropdown: false }">
                            <button @click="showDropdown = !showDropdown"
                                type="button"
                                class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <i class="fas fa-exchange-alt mr-2 text-gray-400"></i>
                                    Movimientos
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
                                <button type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                                    <i class="fas fa-exchange-alt mr-3"></i>
                                    Movimientos
                                </button>
                                <a href="{{ route('inventory.expired') }}"
                                    type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-calendar-times mr-3"></i>
                                    Vencidos
                                </a>
                                <a href="{{ route('inventory.out-of-stock') }}"
                                    type="button"
                                    class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-exclamation-triangle mr-3"></i>
                                    Agotados
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        {{-- Tabla Desktop --}}
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4 whitespace-nowrap">Fecha/Hora</th>
                                    <th scope="col" class="p-4">Tipo</th>
                                    <th scope="col" class="p-4">Producto</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Lote</th>
                                    <th scope="col" class="p-4 text-center">Cantidad</th>
                                    <th scope="col" class="p-4">Usuario</th>
                                    <th scope="col" class="p-4">Referencia</th>
                                    <th scope="col" class="p-4">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(movimiento, index) in movimientosFiltrados" :key="movimiento.id">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="formatearFecha(movimiento.fecha)"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="movimiento.hora"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span :class="'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' + getTipoColor(movimiento.tipo)">
                                                <i :class="'fas ' + getTipoIcon(movimiento.tipo) + ' mr-1'"></i>
                                                <span x-text="getTipoLabel(movimiento.tipo)"></span>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-900 dark:text-white whitespace-nowrap" x-text="movimiento.producto_nombre"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="movimiento.producto_codigo"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap" x-text="movimiento.lote || 'N/A'"></span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span :class="movimiento.cantidad > 0 ? 'text-green-600 dark:text-green-400 font-semibold' : movimiento.cantidad < 0 ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-600 dark:text-gray-400 font-semibold'" 
                                                  x-text="movimiento.cantidad > 0 ? '+' + movimiento.cantidad : movimiento.cantidad === 0 ? '0' : movimiento.cantidad"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="movimiento.usuario"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap" x-text="movimiento.referencia"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="movimiento.observaciones"></span>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="movimientosFiltrados.length === 0">
                                    <tr>
                                        <td colspan="8" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-exchange-alt text-3xl mb-2 opacity-50"></i>
                                            <p>No se encontraron movimientos</p>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        {{-- Vista Móvil --}}
                        <div class="md:hidden px-3 space-y-3 pb-4">
                            <template x-for="(movimiento, index) in movimientosFiltrados" :key="movimiento.id">
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                    {{-- Header con tipo y fecha --}}
                                    <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div :class="'w-10 h-10 rounded-full flex items-center justify-center ' + (movimiento.tipo === 'entrada' ? 'bg-green-100 dark:bg-green-900/30' : movimiento.tipo === 'salida' ? 'bg-red-100 dark:bg-red-900/30' : 'bg-yellow-100 dark:bg-yellow-900/30')">
                                                <i :class="'fas ' + getTipoIcon(movimiento.tipo) + ' text-base ' + (movimiento.tipo === 'entrada' ? 'text-green-600 dark:text-green-400' : movimiento.tipo === 'salida' ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400')"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="getTipoLabel(movimiento.tipo)"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatearFecha(movimiento.fecha) + ' ' + movimiento.hora"></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p :class="'text-lg font-bold ' + (movimiento.cantidad > 0 ? 'text-green-600 dark:text-green-400' : movimiento.cantidad < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400')" 
                                               x-text="movimiento.cantidad > 0 ? '+' + movimiento.cantidad : movimiento.cantidad === 0 ? '0' : movimiento.cantidad"></p>
                                        </div>
                                    </div>
                                    
                                    {{-- Información del producto --}}
                                    <div class="px-4 py-3">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1" x-text="movimiento.producto_nombre"></h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3" x-text="movimiento.producto_codigo"></p>
                                        
                                        {{-- Grid de información --}}
                                        <div class="grid grid-cols-2 gap-3 mt-3">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Lote</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="movimiento.lote || 'N/A'"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Usuario</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="movimiento.usuario"></p>
                                            </div>
                                            <div class="col-span-2">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Referencia</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="movimiento.referencia"></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Descripción --}}
                                    <div class="px-4 pb-4 pt-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Descripción</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed" x-text="movimiento.observaciones"></p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="movimientosFiltrados.length === 0">
                                <div class="py-16 text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                        <i class="fas fa-exchange-alt text-2xl text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No se encontraron movimientos</p>
                                </div>
                            </template>
                        </div>
                    </div>
                    {{-- Paginación --}}
                    <nav class="sticky bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg md:shadow-none md:relative md:bg-transparent dark:md:bg-transparent">
                        <div class="flex flex-col md:flex-row justify-center md:justify-between items-center md:space-y-0 px-4 py-3 md:p-4">
                            <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-2 md:mb-0 text-center md:text-left">
                                Mostrando <span class="font-semibold text-gray-900 dark:text-white" x-text="movimientosFiltrados.length"></span> de <span class="font-semibold text-gray-900 dark:text-white" x-text="movimientos.length"></span>
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

