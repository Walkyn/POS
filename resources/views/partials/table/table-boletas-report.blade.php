<main class="h-full pb-16 overflow-y-auto" 
    @limpiar-filtros.window="filtroPeriodo = 'hoy'; mesSeleccionado = ''; anioSeleccionado = new Date().getFullYear(); usuarioSeleccionado = ''; filtrarInventario();"
    @exportar-reporte.window="exportarReporte()"
    @seleccionar-periodo.window="seleccionarPeriodo($event.detail.periodo); filtrarInventario()"
    @cambiar-anio.window="anioSeleccionado = parseInt($event.detail.anio); if (mesSeleccionado) { seleccionarPeriodo('mes'); } filtrarInventario()"
    @cambiar-mes.window="mesSeleccionado = $event.detail.mes ? parseInt($event.detail.mes) : ''; if (mesSeleccionado) { seleccionarPeriodo('mes'); } filtrarInventario()"
    @cambiar-usuario.window="usuarioSeleccionado = $event.detail.usuario; filtrarInventario()"
    x-data="{ 
    searchQuery: '',
    activeTab: 'boletas',
    isTicketsPage: window.location.pathname.includes('/reports/tickets'),
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
    fechaSeleccionada: '',
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
        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                      'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        const dia = date.getDate();
        const mes = meses[date.getMonth()];
        const anio = date.getFullYear();
        const hora = date.getHours().toString().padStart(2, '0');
        const minutos = date.getMinutes().toString().padStart(2, '0');
        return `${dia} de ${mes} del ${anio}, ${hora}:${minutos}`;
    },
    formatearFecha(fecha) {
        if (!fecha) return 'N/A';
        const date = new Date(fecha);
        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                      'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        const dia = date.getDate();
        const mes = meses[date.getMonth()];
        const anio = date.getFullYear();
        return `${dia} de ${mes} del ${anio}`;
    },
    formatearHora(hora) {
        if (!hora) return 'N/A';
        const date = new Date(hora);
        const horas = date.getHours().toString().padStart(2, '0');
        const minutos = date.getMinutes().toString().padStart(2, '0');
        return `${horas}:${minutos}`;
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
    get inventario() {
        const hoy = new Date();
        const fechaHoy = hoy.toISOString().split('T')[0];
        const horaHoy = hoy.toTimeString().split(' ')[0];
        
        return [
            {
                id: 1,
                numero_boleta: 'B001',
                cliente: 'Juan Pérez',
                subtotal: 1200.00,
                descuento: 50.00,
                total: 1150.00,
                ganancia: 200.00,
                fecha: fechaHoy,
                hora: fechaHoy + ' ' + horaHoy
            },
            {
                id: 2,
                numero_boleta: 'B002',
                cliente: 'María García',
                subtotal: 850.50,
                descuento: 0.00,
                total: 850.50,
                ganancia: 150.00,
                fecha: fechaHoy,
                hora: fechaHoy + ' ' + horaHoy
            },
            {
                id: 3,
                numero_boleta: 'B003',
                cliente: 'Carlos López',
                subtotal: 2500.00,
                descuento: 100.00,
                total: 2400.00,
                ganancia: 450.00,
                fecha: fechaHoy,
                hora: fechaHoy + ' ' + horaHoy
            },
            {
                id: 4,
                numero_boleta: 'B004',
                cliente: 'Ana Martínez',
                subtotal: 450.75,
                descuento: 25.00,
                total: 425.75,
                ganancia: 80.00,
                fecha: fechaHoy,
                hora: fechaHoy + ' ' + horaHoy
            },
            {
                id: 5,
                numero_boleta: 'B005',
                cliente: 'Pedro Sánchez',
                subtotal: 1800.00,
                descuento: 0.00,
                total: 1800.00,
                ganancia: 320.00,
                fecha: '2025-01-14',
                hora: '2025-01-14 09:20:00'
            },
            {
                id: 6,
                numero_boleta: 'B006',
                cliente: 'Laura Rodríguez',
                subtotal: 3200.00,
                descuento: 150.00,
                total: 3050.00,
                ganancia: 580.00,
                fecha: '2025-01-13',
                hora: '2025-01-13 15:45:00'
            }
        ];
    },
    inventarioFiltrado: [],
    init() {
        // Filtrar por defecto para mostrar boletas del día actual
        this.filtrarInventario();
    },
    filtrarInventario() {
        const query = this.searchQuery.toLowerCase().trim();
        let filtrados = this.inventario;
        
        // Obtener fecha actual
        const hoy = new Date();
        const fechaHoy = hoy.toISOString().split('T')[0]; // Formato YYYY-MM-DD
        
        // Filtrar por fecha seleccionada
        if (this.fechaSeleccionada && this.fechaSeleccionada !== '') {
            filtrados = filtrados.filter(item => {
                const fechaItem = item.fecha;
                return fechaItem === this.fechaSeleccionada;
            });
        } else if (!this.mesSeleccionado && !this.usuarioSeleccionado && !this.anioSeleccionado || this.anioSeleccionado === new Date().getFullYear()) {
            // Por defecto, mostrar boletas del día actual si no hay otros filtros
            filtrados = filtrados.filter(item => {
                const fechaItem = item.fecha;
                return fechaItem === fechaHoy;
            });
        }
        
        // Filtrar por año (si está seleccionado y no hay fecha específica)
        if (this.anioSeleccionado && !this.fechaSeleccionada) {
            filtrados = filtrados.filter(item => {
                const fechaItem = new Date(item.fecha);
                return fechaItem.getFullYear() === this.anioSeleccionado;
            });
        }
        
        // Filtrar por mes (si está seleccionado y no hay fecha específica)
        if (this.mesSeleccionado && this.mesSeleccionado !== '' && !this.fechaSeleccionada) {
            filtrados = filtrados.filter(item => {
                const fechaItem = new Date(item.fecha);
                return fechaItem.getMonth() + 1 === parseInt(this.mesSeleccionado);
            });
        }
        
        // Filtrar por usuario (si está seleccionado)
        // Nota: Por ahora solo visual, cuando se implemente el backend se filtrará realmente por usuario
        if (this.usuarioSeleccionado && this.usuarioSeleccionado !== '') {
            // Aquí se filtraría por usuario cuando se implemente en el backend
        }
        
        // Filtrar por búsqueda
        if (query) {
            filtrados = filtrados.filter(item => 
                (item.numero_boleta && item.numero_boleta.toLowerCase().includes(query)) ||
                (item.cliente && item.cliente.toLowerCase().includes(query))
            );
        }
        
        this.inventarioFiltrado = filtrados;
    },
    get totalSubtotal() {
        return this.inventarioFiltrado.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0);
    },
    get totalDescuento() {
        return this.inventarioFiltrado.reduce((sum, item) => sum + (parseFloat(item.descuento) || 0), 0);
    },
    get totalTotal() {
        return this.inventarioFiltrado.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);
    },
    get totalGanancia() {
        return this.inventarioFiltrado.reduce((sum, item) => sum + (parseFloat(item.ganancia) || 0), 0);
    },
    formatearNumero(numero) {
        return numero.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
}" x-init="filtrarInventario()">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-4 p-4 relative z-10 overflow-visible">
                        {{-- Buscador --}}
                        <div class="w-full md:w-1/2 lg:w-2/3 order-1 md:order-1 mt-2 md:mt-0">
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

                        {{-- Botón de Exportar --}}
                        <div class="w-full md:w-auto order-2 md:order-2">
                            <button @click="exportarExcel()"
                                type="button"
                                class="w-full md:w-auto flex items-center justify-center py-2.5 px-4 md:px-6 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                <i class="fas fa-file-excel mr-2"></i>
                                Exportar
                            </button>
                        </div>

                        {{-- Botón de Filtros --}}
                        <div class="w-full md:w-auto order-3 md:order-3 relative z-50 overflow-visible" x-data="{ 
                            filterOpen: false,
                            cerrarTodasLasSecciones() {
                                setTimeout(() => {
                                    const accordionButtons = document.querySelectorAll('#filterDropdownReportsTable [data-accordion-target]');
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
                            <button id="filterDropdownButtonReportsTable"
                                @click="filterOpen = !filterOpen; if (filterOpen) cerrarTodasLasSecciones();"
                                type="button"
                                class="w-full md:w-auto flex items-center justify-between py-2.5 px-4 md:px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <i class="fas fa-filter mr-2 text-gray-400"></i>
                                    Filtrar
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': filterOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown de Filtros --}}
                            <div id="filterDropdownReportsTable"
                                x-show="filterOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                @click.away="filterOpen = false"
                                x-cloak
                                class="absolute z-50 w-full md:w-80 mt-2 right-0 md:right-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <h6 class="text-sm font-medium text-gray-900 dark:text-white">Filtrar</h6>
                                    <button type="button" id="limpiar-filtros-table"
                                        @click="filtroPeriodo = 'hoy'; mesSeleccionado = ''; anioSeleccionado = new Date().getFullYear(); usuarioSeleccionado = ''; fechaSeleccionada = ''; filtrarInventario(); filterOpen = false;"
                                        class="text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        Limpiar
                                    </button>
                                </div>

                                <div id="accordion-flush-reports-table" data-accordion="collapse" data-active-classes="text-black dark:text-white"
                                    data-inactive-classes="text-gray-500 dark:text-gray-400">
                                    {{-- Seleccionar Fecha --}}
                                    <h2 id="fecha-heading-table">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#fecha-body-table" aria-expanded="false" aria-controls="fecha-body-table">
                                            <span>Seleccionar Fecha</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="fecha-body-table" class="hidden" aria-labelledby="fecha-heading-table" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <div>
                                                <label for="fecha_filtro_table"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fecha</label>
                                                <input type="date" 
                                                    id="fecha_filtro_table"
                                                    x-model="fechaSeleccionada"
                                                    @change="filtrarInventario()"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Mes --}}
                                    <h2 id="mes-heading-table">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#mes-body-table" aria-expanded="false"
                                            aria-controls="mes-body-table">
                                            <span>Mes</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="mes-body-table" class="hidden" aria-labelledby="mes-heading-table" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="anio_filtro_table"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Año</label>
                                                    <select id="anio_filtro_table" x-model="anioSeleccionado" @change="seleccionarPeriodo('mes'); filtrarInventario();"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-3">
                                                        <template x-for="anio in anios" :key="anio">
                                                            <option :value="anio" x-text="anio"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="mes_filtro_table"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mes</label>
                                                    <select id="mes_filtro_table" x-model="mesSeleccionado" @change="seleccionarPeriodo('mes'); filtrarInventario();"
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
                                    <h2 id="usuario-heading-table">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-3 px-4 text-sm font-medium text-left text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-accordion-target="#usuario-body-table" aria-expanded="false"
                                            aria-controls="usuario-body-table">
                                            <span>Usuario</span>
                                            <svg aria-hidden="true" data-accordion-icon="" class="w-5 h-5 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="usuario-body-table" class="hidden" aria-labelledby="usuario-heading-table" aria-expanded="false">
                                        <div class="py-3 px-4 font-light border-b border-gray-200 dark:border-gray-700">
                                            <ul class="space-y-2">
                                                <template x-for="usuario in usuarios" :key="usuario.id">
                                                    <li class="flex items-center">
                                                        <input :id="'usuario-table-' + usuario.id" type="radio" x-model="usuarioSeleccionado" :value="usuario.id"
                                                            @change="filtrarInventario()"
                                                            class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                        <label :for="'usuario-table-' + usuario.id"
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
                        <div class="hidden md:flex md:flex-row gap-3 w-auto order-4">
                            <a href="{{ route('reports') }}"
                                :class="!isTicketsPage 
                                    ? 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700' 
                                    : 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Ventas
                            </a>

                            <a href="{{ route('reports.tickets') }}"
                                :class="isTicketsPage 
                                    ? 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700' 
                                    : 'flex items-center justify-center py-2.5 px-6 text-sm font-medium focus:outline-none rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                <i class="fas fa-receipt mr-2"></i>
                                Boletas
                            </a>
                        </div>

                        {{-- Botones Móvil --}}
                        <div class="md:hidden w-full order-4 flex flex-col gap-2">
                            {{-- Dropdown Móvil Ventas/Boletas --}}
                            <div class="relative" x-data="{ showDropdown: false }">
                                <button @click="showDropdown = !showDropdown"
                                    type="button"
                                    class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <span class="flex items-center">
                                        <i class="fas fa-tasks mr-2 text-gray-400"></i>
                                        <span x-text="isTicketsPage ? 'Boletas' : 'Ventas'"></span>
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
                                    <a href="{{ route('reports') }}"
                                        :class="!isTicketsPage ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                        class="w-full flex items-center px-4 py-3 text-sm">
                                        <i class="fas fa-shopping-cart w-5 text-center mr-3"></i>
                                        Ventas
                                    </a>
                                    <a href="{{ route('reports.tickets') }}"
                                        :class="isTicketsPage ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                        class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700">
                                        <i class="fas fa-receipt w-5 text-center mr-3"></i>
                                        Boletas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Cards de Totales --}}
                    <div class="px-3 py-3 md:px-6 md:py-4 border-b border-gray-200 dark:border-gray-700">
                        {{-- Vista Desktop --}}
                        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-6">
                            <!-- Card Subtotal -->
                            <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-4 py-3 shadow-sm dark:border-strokedark">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5">Subtotal</p>
                                <h4 class="text-2xl font-bold text-black dark:text-white font-numbers">
                                    S/ <span x-text="formatearNumero(totalSubtotal)"></span>
                                </h4>
                            </div>
                            <!-- Card End -->

                            <!-- Card Descuento -->
                            <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-4 py-3 shadow-sm dark:border-strokedark">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5">Descuento</p>
                                <h4 class="text-2xl font-bold text-red-600 dark:text-red-400 font-numbers">
                                    S/ <span x-text="formatearNumero(totalDescuento)"></span>
                                </h4>
                            </div>
                            <!-- Card End -->

                            <!-- Card Total -->
                            <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-4 py-3 shadow-sm dark:border-strokedark">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5">Total</p>
                                <h4 class="text-2xl font-bold text-black dark:text-white font-numbers">
                                    S/ <span x-text="formatearNumero(totalTotal)"></span>
                                </h4>
                            </div>
                            <!-- Card End -->

                            <!-- Card Ganancia -->
                            <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-4 py-3 shadow-sm dark:border-strokedark">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5">Ganancia</p>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chart-line text-green-500 text-lg"></i>
                                    <h4 class="text-2xl font-bold text-green-600 dark:text-green-400 font-numbers">
                                        S/ <span x-text="formatearNumero(totalGanancia)"></span>
                                    </h4>
                                </div>
                            </div>
                            <!-- Card End -->
                        </div>
                        
                        {{-- Vista Móvil (App Nativa) --}}
                        <div class="md:hidden">
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Card Subtotal -->
                                <div class="rounded-xl border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-2.5 shadow-sm dark:border-strokedark">
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Subtotal</p>
                                    <h4 class="text-lg font-bold text-black dark:text-white font-numbers">
                                        S/ <span x-text="formatearNumero(totalSubtotal)"></span>
                                    </h4>
                                </div>
                                <!-- Card End -->

                                <!-- Card Descuento -->
                                <div class="rounded-xl border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-2.5 shadow-sm dark:border-strokedark">
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Descuento</p>
                                    <h4 class="text-lg font-bold text-red-600 dark:text-red-400 font-numbers">
                                        S/ <span x-text="formatearNumero(totalDescuento)"></span>
                                    </h4>
                                </div>
                                <!-- Card End -->

                                <!-- Card Total -->
                                <div class="rounded-xl border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-2.5 shadow-sm dark:border-strokedark">
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Total</p>
                                    <h4 class="text-lg font-bold text-black dark:text-white font-numbers">
                                        S/ <span x-text="formatearNumero(totalTotal)"></span>
                                    </h4>
                                </div>
                                <!-- Card End -->

                                <!-- Card Ganancia -->
                                <div class="rounded-xl border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-2.5 shadow-sm dark:border-strokedark">
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Ganancia</p>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-chart-line text-green-500 text-sm"></i>
                                        <h4 class="text-lg font-bold text-green-600 dark:text-green-400 font-numbers">
                                            S/ <span x-text="formatearNumero(totalGanancia)"></span>
                                        </h4>
                                    </div>
                                </div>
                                <!-- Card End -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        {{-- Tabla Desktop --}}
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4 whitespace-nowrap">Nº Boleta</th>
                                    <th scope="col" class="p-4">Cliente</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Subtotal</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Descuento</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Total</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Ganancia</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Fecha</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in inventarioFiltrado" :key="item.id">
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <span class="text-base font-semibold text-black dark:text-white" x-text="item.numero_boleta || 'N/A'"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-900 dark:text-white" x-text="item.cliente || 'Cliente General'"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + (item.subtotal || 0).toFixed(2)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + (item.descuento || 0).toFixed(2)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + (item.total || 0).toFixed(2)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold text-green-600 dark:text-green-400 font-numbers" x-text="'S/ ' + (item.ganancia || 0).toFixed(2)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="formatearFecha(item.fecha)"></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="formatearHora(item.hora)"></span>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="inventarioFiltrado.length === 0">
                                    <tr>
                                        <td colspan="8" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-receipt text-3xl mb-2 opacity-50"></i>
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
                                    {{-- Header con Nº Boleta y Total --}}
                                    <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 dark:bg-blue-900/30">
                                                <i class="fas fa-receipt text-base text-blue-600 dark:text-blue-400"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Boleta #<span x-text="item.numero_boleta || 'N/A'"></span></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="item.cliente || 'Cliente General'"></p>
                                            </div>
                                        </div>
                                        <div class="text-right ml-3">
                                            <p class="text-sm font-bold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + ((item.total || 0).toFixed(2))"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Información principal --}}
                                    <div class="px-4 py-3">
                                        {{-- Grid de información --}}
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Subtotal</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + ((item.subtotal || 0).toFixed(2))"></p>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Descuento</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="'S/ ' + ((item.descuento || 0).toFixed(2))"></p>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Ganancia</p>
                                                <p class="text-sm font-semibold text-green-600 dark:text-green-400 font-numbers" x-text="'S/ ' + ((item.ganancia || 0).toFixed(2))"></p>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="formatearFecha(item.fecha)"></p>
                                            </div>
                                            <div class="col-span-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Hora</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="formatearHora(item.hora)"></p>
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

