<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    isDeleteConfirmModal: false, 
    itemToDelete: null,
    isViewDetailsModal: false,
    ventaSeleccionada: null,
    showActionsDropdown: false,
    searchQuery: '',
    showFilterDropdown: false,
    filtroFechaUnica: '',
    filtroMes: '',
    filtroAnio: '',
    filtroEstado: '',
    filtroMetodoPago: '',
    ventas: [
        {
            id: 1,
            numero_ticket: 'B2025-0000001',
            numero_factura: null,
            cliente: 'Juan Martínez',
            cliente_dni: '12345678',
            cliente_telefono: '987654321',
            cliente_direccion: 'Av. Principal 123, Lima',
            fecha: '2025-01-15',
            hora: '14:30:25',
            total: 1245.00,
            subtotal: 1100.00,
            igv: 145.00,
            estado: 'completada',
            metodo_pago: 'Efectivo',
            productos_count: 3,
            vendedor: 'Carlos Pérez',
            observaciones: 'Cliente solicita factura electrónica',
            productos: [
                { nombre: 'Laptop HP 15', codigo: 'LP001', numero_lote: 'LOTE-001', cantidad: 1, precio_unitario: 800.00, subtotal: 800.00 },
                { nombre: 'Mouse Inalámbrico', codigo: 'MS002', numero_lote: 'LOTE-002', cantidad: 2, precio_unitario: 50.00, subtotal: 100.00 },
                { nombre: 'Teclado Mecánico', codigo: 'TC003', numero_lote: 'LOTE-003', cantidad: 1, precio_unitario: 200.00, subtotal: 200.00 }
            ]
        }
    ],
    ventasFiltradas: [],
    init() {
        this.ventasFiltradas = this.ventas;
    },
    filtrarVentas() {
        const query = this.searchQuery.toLowerCase().trim();
        let resultado = this.ventas;
        
        // Filtro por búsqueda
        if (query) {
            resultado = resultado.filter(venta => 
                (venta.numero_ticket && venta.numero_ticket.toLowerCase().includes(query)) ||
                (venta.metodo_pago && venta.metodo_pago.toLowerCase().includes(query)) ||
                (venta.estado && venta.estado.toLowerCase().includes(query))
            );
        }
        
        // Filtro por fecha única (día específico)
        if (this.filtroFechaUnica) {
            resultado = resultado.filter(venta => {
                const fechaVenta = new Date(venta.fecha);
                const fechaFiltro = new Date(this.filtroFechaUnica);
                return fechaVenta.toDateString() === fechaFiltro.toDateString();
            });
        }
        
        // Filtro por mes y año
        if (this.filtroMes && this.filtroAnio) {
            resultado = resultado.filter(venta => {
                const fechaVenta = new Date(venta.fecha);
                const mesVenta = fechaVenta.getMonth() + 1; // getMonth() devuelve 0-11
                const anioVenta = fechaVenta.getFullYear();
                return mesVenta === parseInt(this.filtroMes) && anioVenta === parseInt(this.filtroAnio);
            });
        } else if (this.filtroAnio) {
            // Solo año
            resultado = resultado.filter(venta => {
                const fechaVenta = new Date(venta.fecha);
                return fechaVenta.getFullYear() === parseInt(this.filtroAnio);
            });
        }
        
        // Filtro por estado
        if (this.filtroEstado) {
            resultado = resultado.filter(venta => venta.estado === this.filtroEstado);
        }
        
        // Filtro por método de pago
        if (this.filtroMetodoPago) {
            resultado = resultado.filter(venta => venta.metodo_pago === this.filtroMetodoPago);
        }
        
        this.ventasFiltradas = resultado;
    },
    limpiarFiltros() {
        this.filtroFechaUnica = '';
        this.filtroMes = '';
        this.filtroAnio = '';
        this.filtroEstado = '';
        this.filtroMetodoPago = '';
        this.filtrarVentas();
    },
    tieneFiltrosActivos() {
        return this.filtroFechaUnica || this.filtroMes || this.filtroAnio || this.filtroEstado || this.filtroMetodoPago;
    },
    getAniosDisponibles() {
        const anios = new Set();
        this.ventas.forEach(venta => {
            const fecha = new Date(venta.fecha);
            anios.add(fecha.getFullYear());
        });
        return Array.from(anios).sort((a, b) => b - a);
    },
    getEstadoClass(estado) {
        const estados = {
            'completada': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'pendiente': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'cancelada': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
        };
        return estados[estado] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    },
    getEstadoText(estado) {
        const estados = {
            'completada': 'Completada',
            'pendiente': 'Pendiente',
            'cancelada': 'Cancelada'
        };
        return estados[estado] || estado;
    },
    getEstadoIcon(estado) {
        const iconos = {
            'completada': 'fa-check-circle',
            'pendiente': 'fa-clock',
            'cancelada': 'fa-times-circle'
        };
        return iconos[estado] || 'fa-circle';
    },
    getMetodoPagoIcon(metodo) {
        const iconos = {
            'Efectivo': 'fa-money-bill-wave',
            'Tarjeta': 'fa-credit-card',
            'Transferencia': 'fa-university',
            'Yape': 'fa-mobile-alt',
            'Plin': 'fa-mobile-alt'
        };
        return iconos[metodo] || 'fa-money-bill-wave';
    },
    confirmDelete() {
        this.isDeleteConfirmModal = false;
        setTimeout(() => { this.itemToDelete = null; }, 200);
        showSuccessToast();
    },
    formatearFecha(fecha, hora) {
        const fechaObj = new Date(fecha + 'T' + hora);
        const dia = fechaObj.getDate().toString().padStart(2, '0');
        const mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
        const año = fechaObj.getFullYear();
        return `${dia}/${mes}/${año}`;
    },
    formatearHora(hora) {
        return hora.substring(0, 5);
    },
    generarFactura() {
        if (!this.ventaSeleccionada) return;
        
        // Generar número de factura (ejemplo: F2025-0000001)
        const año = new Date().getFullYear();
        const numeroFactura = `F${año}-${String(this.ventaSeleccionada.id).padStart(7, '0')}`;
        
        // Actualizar la venta seleccionada
        this.ventaSeleccionada.numero_factura = numeroFactura;
        
        // Actualizar en el array de ventas
        const ventaIndex = this.ventas.findIndex(v => v.id === this.ventaSeleccionada.id);
        if (ventaIndex !== -1) {
            this.ventas[ventaIndex].numero_factura = numeroFactura;
        }
        
        // Actualizar en ventas filtradas
        const ventaFiltradaIndex = this.ventasFiltradas.findIndex(v => v.id === this.ventaSeleccionada.id);
        if (ventaFiltradaIndex !== -1) {
            this.ventasFiltradas[ventaFiltradaIndex].numero_factura = numeroFactura;
        }
        
        // Aquí puedes agregar la llamada al backend para guardar la factura
        // Ejemplo: fetch('/sales/' + this.ventaSeleccionada.id + '/invoice', { method: 'POST' })
        
        showSuccessToast('Factura generada correctamente');
    },
    verFactura() {
        if (!this.ventaSeleccionada || !this.ventaSeleccionada.numero_factura) return;
        
        // Aquí puedes abrir un modal o redirigir a la vista de la factura
        // Ejemplo: window.open('/invoices/' + this.ventaSeleccionada.numero_factura, '_blank');
        
        showSuccessToast('Abriendo factura...');
    }
}">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-6 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:flex-1 order-2 md:order-1 mt-4 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar venta</label>
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
                                           @input="filtrarVentas()"
                                           id="simple-search"
                                        class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                        placeholder="Buscar por número de ticket, método de pago o estado...">
                                    <button type="button"
                                        x-show="searchQuery"
                                        @click="searchQuery = ''; filtrarVentas();"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 clear-search-button transition-colors duration-200">
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
                        <div class="hidden md:flex md:flex-row gap-3 flex-shrink-0 order-2">
                            <div class="relative" x-data="{ showFilterDropdown: false }">
                                <button type="button"
                                    @click="showFilterDropdown = !showFilterDropdown"
                                    :class="tieneFiltrosActivos() ? 'bg-blue-50 border-blue-300 text-blue-700 dark:bg-blue-900/20 dark:border-blue-700 dark:text-blue-300' : ''"
                                    x-ref="filterButton"
                                    class="flex items-center justify-center py-2.5 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <i class="fas fa-filter mr-2 text-gray-400"></i>
                                    Filtros
                                    <span x-show="tieneFiltrosActivos()" class="ml-2 px-1.5 py-0.5 text-xs font-semibold bg-blue-600 text-white rounded-full" x-text="[filtroFechaUnica, filtroMes, filtroAnio, filtroEstado, filtroMetodoPago].filter(f => f).length"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showFilterDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                {{-- Dropdown de Filtros Desktop --}}
                                <div x-show="showFilterDropdown"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="showFilterDropdown = false"
                                     x-cloak
                                     style="position: fixed; z-index: 99999;"
                                     x-init="$watch('showFilterDropdown', value => { if (value) { setTimeout(() => { const button = $refs.filterButton; const rect = button.getBoundingClientRect(); $el.style.top = (rect.bottom + 8) + 'px'; $el.style.right = (window.innerWidth - rect.right) + 'px'; }, 10); } })"
                                     class="w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-4 max-h-[600px] overflow-y-auto">
                                    <div class="space-y-4">
                                        <!-- Filtro por Fecha Única (Día específico) -->
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Fecha Específica
                                                </label>
                                                <button x-show="filtroFechaUnica"
                                                        @click="filtroFechaUnica = ''; filtrarVentas();"
                                                        type="button"
                                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <input type="date" 
                                                   x-model="filtroFechaUnica"
                                                   @change="if (filtroFechaUnica) { filtroMes = ''; filtroAnio = ''; } filtrarVentas();"
                                                   class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                        </div>

                                        <!-- Filtro por Año y Mes (en una fila) -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <!-- Filtro por Año -->
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Año
                                                    </label>
                                                    <button x-show="filtroAnio"
                                                            @click="filtroAnio = ''; filtrarVentas();"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <select x-model="filtroAnio"
                                                        @change="if (filtroAnio) { filtroFechaUnica = ''; } filtrarVentas();"
                                                        class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                    <option value="">Todos</option>
                                                    <template x-for="anio in getAniosDisponibles()" :key="anio">
                                                        <option :value="anio" x-text="anio"></option>
                                                    </template>
                                                </select>
                                            </div>

                                            <!-- Filtro por Mes -->
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Mes
                                                    </label>
                                                    <button x-show="filtroMes"
                                                            @click="filtroMes = ''; filtrarVentas();"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <select x-model="filtroMes"
                                                        @change="if (filtroMes) { filtroFechaUnica = ''; } filtrarVentas();"
                                                        class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                    <option value="">Todos</option>
                                                    <option value="1">Enero</option>
                                                    <option value="2">Febrero</option>
                                                    <option value="3">Marzo</option>
                                                    <option value="4">Abril</option>
                                                    <option value="5">Mayo</option>
                                                    <option value="6">Junio</option>
                                                    <option value="7">Julio</option>
                                                    <option value="8">Agosto</option>
                                                    <option value="9">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Filtro por Estado -->
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Estado
                                                </label>
                                                <button x-show="filtroEstado"
                                                        @click="filtroEstado = ''; filtrarVentas();"
                                                        type="button"
                                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <select x-model="filtroEstado"
                                                    @change="filtrarVentas()"
                                                    class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                <option value="">Todos los estados</option>
                                                <option value="completada">Completada</option>
                                                <option value="pendiente">Pendiente</option>
                                                <option value="cancelada">Cancelada</option>
                                            </select>
                                        </div>

                                        <!-- Filtro por Método de Pago -->
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Método de Pago
                                                </label>
                                                <button x-show="filtroMetodoPago"
                                                        @click="filtroMetodoPago = ''; filtrarVentas();"
                                                        type="button"
                                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <select x-model="filtroMetodoPago"
                                                    @change="filtrarVentas()"
                                                    class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                <option value="">Todos los métodos</option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="Tarjeta">Tarjeta</option>
                                                <option value="Transferencia">Transferencia</option>
                                                <option value="Yape">Yape</option>
                                                <option value="Plin">Plin</option>
                                            </select>
                                        </div>

                                        <!-- Botón Limpiar -->
                                        <button x-show="tieneFiltrosActivos()"
                                                @click="limpiarFiltros(); showFilterDropdown = false;" 
                                                type="button"
                                                class="w-full rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                            Limpiar Todos los Filtros
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('sales.create') }}"
                                class="flex items-center justify-center py-2.5 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-plus mr-2 text-gray-400"></i>
                                Nueva Venta
                            </a>
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
                                 class="absolute z-[99999] w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden max-h-[80vh] overflow-y-auto">
                                <div x-data="{ showFilterDropdown: false }" class="border-b border-gray-200 dark:border-gray-700">
                                    <button type="button"
                                       @click="showFilterDropdown = !showFilterDropdown"
                                       :class="tieneFiltrosActivos() ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300'"
                                       class="w-full flex items-center justify-between px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <div class="flex items-center">
                                            <i class="fas fa-filter mr-3 text-gray-400"></i>
                                            Filtros
                                            <span x-show="tieneFiltrosActivos()" class="ml-2 px-1.5 py-0.5 text-xs font-semibold bg-blue-600 text-white rounded-full" x-text="[filtroFechaUnica, filtroMes, filtroAnio, filtroEstado, filtroMetodoPago].filter(f => f).length"></span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showFilterDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    
                                    {{-- Contenido del Dropdown de Filtros Móvil --}}
                                    <div x-show="showFilterDropdown"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 max-h-0"
                                         x-transition:enter-end="opacity-100 max-h-96"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 max-h-96"
                                         x-transition:leave-end="opacity-0 max-h-0"
                                         class="overflow-hidden bg-gray-50 dark:bg-gray-900/50">
                                        <div class="p-4 space-y-4">
                                            <!-- Filtro por Fecha Única (Día específico) -->
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Fecha Específica
                                                    </label>
                                                    <button x-show="filtroFechaUnica"
                                                            @click="filtroFechaUnica = ''; filtrarVentas();"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <input type="date" 
                                                       x-model="filtroFechaUnica"
                                                       @change="if (filtroFechaUnica) { filtroMes = ''; filtroAnio = ''; } filtrarVentas();"
                                                       class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                            </div>

                                            <!-- Filtro por Año y Mes (en una fila) -->
                                            <div class="grid grid-cols-2 gap-3">
                                                <!-- Filtro por Año -->
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            Año
                                                        </label>
                                                        <button x-show="filtroAnio"
                                                                @click="filtroAnio = ''; filtrarVentas();"
                                                                type="button"
                                                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <select x-model="filtroAnio"
                                                            @change="if (filtroAnio) { filtroFechaUnica = ''; } filtrarVentas();"
                                                            class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                        <option value="">Todos</option>
                                                        <template x-for="anio in getAniosDisponibles()" :key="anio">
                                                            <option :value="anio" x-text="anio"></option>
                                                        </template>
                                                    </select>
                                                </div>

                                                <!-- Filtro por Mes -->
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            Mes
                                                        </label>
                                                        <button x-show="filtroMes"
                                                                @click="filtroMes = ''; filtrarVentas();"
                                                                type="button"
                                                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <select x-model="filtroMes"
                                                            @change="if (filtroMes) { filtroFechaUnica = ''; } filtrarVentas();"
                                                            class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                        <option value="">Todos</option>
                                                        <option value="1">Enero</option>
                                                        <option value="2">Febrero</option>
                                                        <option value="3">Marzo</option>
                                                        <option value="4">Abril</option>
                                                        <option value="5">Mayo</option>
                                                        <option value="6">Junio</option>
                                                        <option value="7">Julio</option>
                                                        <option value="8">Agosto</option>
                                                        <option value="9">Septiembre</option>
                                                        <option value="10">Octubre</option>
                                                        <option value="11">Noviembre</option>
                                                        <option value="12">Diciembre</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Filtro por Estado -->
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Estado
                                                    </label>
                                                    <button x-show="filtroEstado"
                                                            @click="filtroEstado = ''; filtrarVentas();"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <select x-model="filtroEstado"
                                                        @change="filtrarVentas()"
                                                        class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                    <option value="">Todos los estados</option>
                                                    <option value="completada">Completada</option>
                                                    <option value="pendiente">Pendiente</option>
                                                    <option value="cancelada">Cancelada</option>
                                                </select>
                                            </div>

                                            <!-- Filtro por Método de Pago -->
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Método de Pago
                                                    </label>
                                                    <button x-show="filtroMetodoPago"
                                                            @click="filtroMetodoPago = ''; filtrarVentas();"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <select x-model="filtroMetodoPago"
                                                        @change="filtrarVentas()"
                                                        class="w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                    <option value="">Todos los métodos</option>
                                                    <option value="Efectivo">Efectivo</option>
                                                    <option value="Tarjeta">Tarjeta</option>
                                                    <option value="Transferencia">Transferencia</option>
                                                    <option value="Yape">Yape</option>
                                                    <option value="Plin">Plin</option>
                                                </select>
                                            </div>

                                            <!-- Botón Limpiar -->
                                            <button x-show="tieneFiltrosActivos()"
                                                    @click="limpiarFiltros(); showFilterDropdown = false;" 
                                                    type="button"
                                                    class="w-full rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                                Limpiar Todos los Filtros
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('sales.create') }}"
                                   @click="showDropdown = false"
                                   class="flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <i class="fas fa-plus mr-3 text-blue-600 dark:text-blue-400"></i>
                                    Nueva Venta
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Ticket</th>
                                    <th scope="col" class="p-4">Fecha</th>
                                    <th scope="col" class="p-4">Artículos</th>
                                    <th scope="col" class="p-4">Total</th>
                                    <th scope="col" class="p-4">Método de Pago</th>
                                    <th scope="col" class="p-4">Estado</th>
                                    <th scope="col" class="p-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="venta in ventasFiltradas" :key="venta.id">
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <span class="text-base font-semibold text-black dark:text-white" x-text="venta.numero_ticket"></span>
                                        </th>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="formatearFecha(venta.fecha, venta.hora)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="venta.productos_count"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-base font-semibold text-gray-900 dark:text-white" x-text="'S/ ' + venta.total.toFixed(2)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <i :class="getMetodoPagoIcon(venta.metodo_pago) + ' text-gray-500 dark:text-gray-400'" class="fas text-sm"></i>
                                                <span class="text-sm text-gray-600 dark:text-gray-400" x-text="venta.metodo_pago"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span :class="getEstadoClass(venta.estado)" 
                                                  class="px-2.5 py-0.5 text-xs font-bold rounded-full flex items-center gap-1.5 inline-flex">
                                                <i :class="'fas ' + getEstadoIcon(venta.estado)" class="text-xs"></i>
                                                <span x-text="getEstadoText(venta.estado)"></span>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center space-x-2">
                                                <button type="button" 
                                                    @click="ventaSeleccionada = venta; isViewDetailsModal = true;"
                                                    title="Ver detalles"
                                                    class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                                <button type="button" 
                                                    title="Imprimir ticket"
                                                    class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                </button>
                                                <button type="button" 
                                                    x-show="!venta.numero_factura"
                                                    @click="ventaSeleccionada = venta; generarFactura();"
                                                    title="Facturar"
                                                    class="flex items-center justify-center text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded text-sm p-2 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
                                                    <i class="fas fa-file-pdf h-4 w-4"></i>
                                                </button>
                                                <button type="button" 
                                                    x-show="venta.numero_factura"
                                                    @click="ventaSeleccionada = venta; verFactura();"
                                                    title="Ver factura"
                                                    class="flex items-center justify-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded text-sm p-2 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">
                                                    <i class="fas fa-file-pdf h-4 w-4"></i>
                                                </button>
                                                <button type="button" 
                                                    x-show="venta.estado !== 'cancelada'"
                                                    @click.stop="itemToDelete = venta; isDeleteConfirmModal = true;"
                                                    title="Cancelar venta"
                                                    class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
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
                                </template>
                                <tr x-show="ventasFiltradas.length === 0" class="border-b dark:border-gray-600">
                                    <td colspan="7" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">No se encontraron ventas</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Vista Móvil --}}
                        <div class="md:hidden space-y-4 px-4 pt-0 pb-4">
                            <template x-for="venta in ventasFiltradas" :key="venta.id">
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-base font-semibold text-gray-900 dark:text-white break-words" x-text="venta.numero_ticket"></span>
                                            </div>
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400" x-text="formatearFecha(venta.fecha, venta.hora) + ' ' + formatearHora(venta.hora)"></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        <span class="font-medium">Artículos:</span> <span x-text="venta.productos_count"></span>
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i :class="getMetodoPagoIcon(venta.metodo_pago) + ' text-gray-400 dark:text-gray-500'" class="fas text-sm flex-shrink-0"></i>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400" x-text="venta.metodo_pago"></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-bold text-gray-900 dark:text-white" x-text="'S/ ' + venta.total.toFixed(2)"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4 flex-shrink-0">
                                            <span :class="getEstadoClass(venta.estado)" 
                                                  class="px-2.5 py-0.5 text-xs font-bold rounded-full flex-shrink-0 flex items-center gap-1.5">
                                                <i :class="'fas ' + getEstadoIcon(venta.estado)" class="text-xs"></i>
                                                <span x-text="getEstadoText(venta.estado)"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <button type="button" 
                                            @click="ventaSeleccionada = venta; isViewDetailsModal = true;"
                                            title="Ver detalles"
                                            class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button type="button" 
                                            title="Imprimir ticket"
                                            class="flex-1 flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </button>
                                        <button type="button" 
                                            x-show="!venta.numero_factura"
                                            @click="ventaSeleccionada = venta; generarFactura();"
                                            title="Facturar"
                                            class="flex-1 flex items-center justify-center text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-purple-500 dark:text-purple-500 dark:hover:text-white dark:hover:bg-purple-600 dark:focus:ring-purple-900">
                                            <i class="fas fa-file-pdf h-4 w-4"></i>
                                        </button>
                                        <button type="button" 
                                            x-show="venta.numero_factura"
                                            @click="ventaSeleccionada = venta; verFactura();"
                                            title="Ver factura"
                                            class="flex-1 flex items-center justify-center text-indigo-700 hover:text-white border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-600 dark:focus:ring-indigo-900">
                                            <i class="fas fa-file-pdf h-4 w-4"></i>
                                        </button>
                                        <button type="button" 
                                            x-show="venta.estado !== 'cancelada'"
                                            @click.stop="itemToDelete = venta; isDeleteConfirmModal = true;"
                                            title="Cancelar venta"
                                            class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <div x-show="ventasFiltradas.length === 0" class="p-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">No se encontraron ventas</p>
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
                            <span class="font-semibold text-gray-900 dark:text-white">6</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-white">6</span>
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
    </div>

    {{-- Modal de Confirmación de Cancelación de Venta --}}
    <div x-show="isDeleteConfirmModal" 
         x-cloak
         class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
        
        <!-- Overlay -->
        <div x-show="isDeleteConfirmModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

        <!-- Modal Desktop - Centrado -->
        <div x-show="isDeleteConfirmModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="hidden md:block no-scrollbar relative w-full max-w-[450px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">

            <!-- Botón cerrar -->
            <button @click="isDeleteConfirmModal = false; setTimeout(() => { itemToDelete = null; }, 200);"
                class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <!-- Título con borde completo -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                    Cancelar Venta
                </h3>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-4 sm:p-6 lg:px-8">
                <!-- Información de la Venta a Cancelar -->
                <div x-show="itemToDelete" class="mb-4 sm:mb-4">
                    <div class="space-y-3 sm:space-y-3">
                        <!-- Número de Ticket -->
                        <div>
                            <p class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-1 break-words"
                                x-text="itemToDelete ? (itemToDelete.numero_ticket || 'Venta') : ''"></p>
                        </div>

                        <!-- Información de la Venta -->
                        <div class="space-y-2.5 sm:space-y-3">
                            <template x-if="itemToDelete && itemToDelete.fecha && itemToDelete.hora">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Fecha:</span>
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="formatearFecha(itemToDelete.fecha, itemToDelete.hora)"></span>
                                </div>
                            </template>

                            <template x-if="itemToDelete && itemToDelete.productos_count">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Artículos:</span>
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="itemToDelete.productos_count"></span>
                                </div>
                            </template>

                            <template x-if="itemToDelete && itemToDelete.total">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Total:</span>
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="'S/ ' + itemToDelete.total.toFixed(2)"></span>
                                </div>
                            </template>

                            <template x-if="itemToDelete && itemToDelete.metodo_pago">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Método de Pago:</span>
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="itemToDelete.metodo_pago"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Mensaje de advertencia -->
                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                ¿Estás seguro de que deseas cancelar esta venta? Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botón de Confirmar -->
                <div class="flex justify-center mt-4 sm:mt-6">
                    <button @click="confirmDelete()" type="button"
                        class="w-full rounded-xl bg-red-600 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                        Confirmar Cancelación
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Móvil - Bottom Sheet estilo Android -->
        <div x-show="isDeleteConfirmModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             @click.stop
             class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col">
            
            <!-- Handle Bar (indicador de arrastre) -->
            <div class="flex justify-center pt-3 pb-2">
                <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
            </div>

            <!-- Header Móvil -->
            <div x-show="isDeleteConfirmModal"
                 x-transition:enter="transition ease-out duration-300 delay-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Cancelar Venta
                    </h3>
                    <button @click="isDeleteConfirmModal = false; setTimeout(() => { itemToDelete = null; }, 200);"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido con scroll Móvil -->
            <div x-show="isDeleteConfirmModal"
                 x-transition:enter="transition ease-out duration-400 delay-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="flex-1 overflow-y-auto px-5 py-4">
                <!-- Información de la Venta a Cancelar Móvil -->
                <div x-show="itemToDelete" class="mb-4">
                    <div class="space-y-3">
                        <!-- Número de Ticket -->
                        <div>
                            <p class="text-lg font-bold text-gray-900 dark:text-white mb-1 break-words"
                                x-text="itemToDelete ? (itemToDelete.numero_ticket || 'Venta') : ''"></p>
                        </div>

                        <!-- Información de la Venta -->
                        <div class="space-y-2.5">
                            <template x-if="itemToDelete && itemToDelete.fecha && itemToDelete.hora">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha:</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="formatearFecha(itemToDelete.fecha, itemToDelete.hora)"></span>
                                </div>
                            </template>

                            <template x-if="itemToDelete && itemToDelete.productos_count">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Artículos:</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="itemToDelete.productos_count"></span>
                                </div>
                            </template>

                            <template x-if="itemToDelete && itemToDelete.total">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total:</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="'S/ ' + itemToDelete.total.toFixed(2)"></span>
                                </div>
                            </template>

                            <template x-if="itemToDelete && itemToDelete.metodo_pago">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Método de Pago:</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white text-right break-words"
                                        x-text="itemToDelete.metodo_pago"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Mensaje de advertencia -->
                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                ¿Estás seguro de que deseas cancelar esta venta? Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con botón fijo Móvil -->
            <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <button @click="confirmDelete()" 
                    type="button"
                    class="w-full flex items-center justify-center rounded-lg bg-red-600 px-6 py-2.5 sm:px-8 sm:py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 transition-colors">
                    Confirmar Cancelación
                </button>
            </div>
        </div>
    </div>
    
    @include('sales.modals.view-sale-details')
</main>


