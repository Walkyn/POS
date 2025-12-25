<div x-data="{
    fechaSeleccionada: '',
    init() {
        this.filtrarDatos();
        // Escuchar evento de cambio de fecha desde el panel principal
        window.addEventListener('cambiar-fecha-informes', (e) => {
            this.fechaSeleccionada = e.detail.fecha;
            this.filtrarDatos();
        });
    },
    entradasEfectivo: [
        {
            id: 1,
            descripcion: 'Venta de productos',
            monto: 500.00,
            usuario: 'Juan Pérez',
            fecha: '2025-01-15',
            hora: '14:30:00'
        },
        {
            id: 2,
            descripcion: 'Pago de cliente',
            monto: 300.00,
            usuario: 'María García',
            fecha: '2025-01-15',
            hora: '16:45:00'
        },
        {
            id: 3,
            descripcion: 'Depósito adicional',
            monto: 400.00,
            usuario: 'Carlos López',
            fecha: '2025-01-15',
            hora: '18:20:00'
        }
    ],
    salidasEfectivo: [
        {
            id: 1,
            descripcion: 'Compra de materiales',
            monto: 200.00,
            usuario: 'Juan Pérez',
            fecha: '2025-01-15',
            hora: '10:15:00'
        },
        {
            id: 2,
            descripcion: 'Pago a proveedor',
            monto: 100.00,
            usuario: 'María García',
            fecha: '2025-01-15',
            hora: '12:30:00'
        }
    ],
    entradasFiltradas: [],
    salidasFiltradas: [],
    filtrarDatos() {
        const hoy = new Date().toISOString().split('T')[0];
        const fechaFiltro = this.fechaSeleccionada || hoy;
        
        this.entradasFiltradas = this.entradasEfectivo.filter(item => item.fecha === fechaFiltro);
        this.salidasFiltradas = this.salidasEfectivo.filter(item => item.fecha === fechaFiltro);
    },
    get totalEntradas() {
        return this.entradasFiltradas.reduce((sum, item) => sum + (item.monto || 0), 0);
    },
    get totalSalidas() {
        return this.salidasFiltradas.reduce((sum, item) => sum + (item.monto || 0), 0);
    },
    formatearNumero(numero) {
        return numero.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
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
    }
}" x-init="filtrarDatos()">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        {{-- Tabla Salidas de Efectivo --}}
        <div class="rounded-lg md:rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="border-b border-stroke px-3 md:px-4 py-2.5 md:py-3 dark:border-strokedark">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-arrow-down text-gray-500 dark:text-gray-400 text-sm md:text-base"></i>
                        <h3 class="text-sm md:text-base lg:text-lg font-semibold text-black dark:text-white">
                            Salidas de Efectivo
                        </h3>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="date" 
                            x-model="fechaSeleccionada"
                            @change="filtrarDatos()"
                            @cambiar-fecha-informes.window="fechaSeleccionada = $event.detail.fecha; filtrarDatos()"
                            class="w-full sm:w-auto h-10 text-xs md:text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-2 md:px-3">
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                {{-- Tabla Desktop --}}
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Descripción</th>
                            <th scope="col" class="px-4 py-3">Monto</th>
                            <th scope="col" class="px-4 py-3">Usuario</th>
                            <th scope="col" class="px-4 py-3">Fecha</th>
                            <th scope="col" class="px-4 py-3">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in salidasFiltradas" :key="item.id">
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white" x-text="item.descripcion"></td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-red-600 dark:text-red-400 font-numbers" x-text="'S/ ' + formatearNumero(item.monto)"></span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400" x-text="item.usuario"></td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400" x-text="formatearFecha(item.fecha)"></td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400" x-text="item.hora"></td>
                            </tr>
                        </template>
                        <template x-if="salidasFiltradas.length === 0">
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                                    <p>No se encontraron registros</p>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="4" class="px-4 py-3 font-semibold text-gray-900 dark:text-white text-right">Total:</td>
                            <td class="px-4 py-3">
                                <span class="font-bold text-red-600 dark:text-red-400 font-numbers" x-text="'S/ ' + formatearNumero(totalSalidas)"></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Vista Móvil --}}
                <div class="md:hidden px-3 py-2 space-y-2.5">
                    <template x-for="(item, index) in salidasFiltradas" :key="item.id">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-red-100 dark:border-red-900/30 overflow-hidden">
                            <div class="px-3 pt-3 pb-2.5 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-2.5 flex-1 min-w-0">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center bg-red-100 dark:bg-red-900/30 flex-shrink-0">
                                        <i class="fas fa-arrow-down text-sm text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate" x-text="item.descripcion"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="item.usuario"></p>
                                    </div>
                                </div>
                                <div class="text-right ml-2 flex-shrink-0">
                                    <p class="text-xs font-bold text-red-600 dark:text-red-400 font-numbers whitespace-nowrap" x-text="'S/ ' + formatearNumero(item.monto)"></p>
                                </div>
                            </div>
                            <div class="px-3 py-2.5">
                                <div class="grid grid-cols-2 gap-2.5 text-xs">
                                    <div class="flex flex-col">
                                        <p class="text-gray-500 dark:text-gray-400 mb-0.5 text-xs">Fecha</p>
                                        <p class="font-medium text-gray-900 dark:text-white text-xs" x-text="formatearFecha(item.fecha)"></p>
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-gray-500 dark:text-gray-400 mb-0.5 text-xs">Hora</p>
                                        <p class="font-medium text-gray-900 dark:text-white text-xs" x-text="item.hora"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="salidasFiltradas.length === 0">
                        <div class="py-12 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <i class="fas fa-inbox text-xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">No se encontraron registros</p>
                        </div>
                    </template>
                    <div class="pt-2.5 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">Total:</span>
                            <span class="text-sm font-bold text-red-600 dark:text-red-400 font-numbers" x-text="'S/ ' + formatearNumero(totalSalidas)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla Entradas de Efectivo --}}
        <div class="rounded-lg md:rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="border-b border-stroke px-3 md:px-4 py-2.5 md:py-3 dark:border-strokedark">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-arrow-up text-gray-500 dark:text-gray-400 text-sm md:text-base"></i>
                        <h3 class="text-base md:text-base lg:text-lg font-semibold text-black dark:text-white">
                            Entradas de Efectivo
                        </h3>
                    </div>
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <input type="date" 
                            x-model="fechaSeleccionada"
                            @change="filtrarDatos()"
                            @cambiar-fecha-informes.window="fechaSeleccionada = $event.detail.fecha; filtrarDatos()"
                            class="w-full md:w-auto h-10 text-xs md:text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 px-2 md:px-3">
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                {{-- Tabla Desktop --}}
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Descripción</th>
                            <th scope="col" class="px-4 py-3">Monto</th>
                            <th scope="col" class="px-4 py-3">Usuario</th>
                            <th scope="col" class="px-4 py-3">Fecha</th>
                            <th scope="col" class="px-4 py-3">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in entradasFiltradas" :key="item.id">
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white" x-text="item.descripcion"></td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-teal-600 dark:text-teal-400 font-numbers" x-text="'S/ ' + formatearNumero(item.monto)"></span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400" x-text="item.usuario"></td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400" x-text="formatearFecha(item.fecha)"></td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400" x-text="item.hora"></td>
                            </tr>
                        </template>
                        <template x-if="entradasFiltradas.length === 0">
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                                    <p>No se encontraron registros</p>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="4" class="px-4 py-3 font-semibold text-gray-900 dark:text-white text-right">Total:</td>
                            <td class="px-4 py-3">
                                <span class="font-bold text-teal-600 dark:text-teal-400 font-numbers" x-text="'S/ ' + formatearNumero(totalEntradas)"></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Vista Móvil --}}
                <div class="md:hidden px-3 py-2 space-y-2.5">
                    <template x-for="(item, index) in entradasFiltradas" :key="item.id">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-teal-100 dark:border-teal-900/30 overflow-hidden">
                            <div class="px-3 pt-3 pb-2.5 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-2.5 flex-1 min-w-0">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center bg-teal-100 dark:bg-teal-900/30 flex-shrink-0">
                                        <i class="fas fa-arrow-up text-sm text-teal-600 dark:text-teal-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate" x-text="item.descripcion"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="item.usuario"></p>
                                    </div>
                                </div>
                                <div class="text-right ml-2 flex-shrink-0">
                                    <p class="text-xs font-bold text-teal-600 dark:text-teal-400 font-numbers whitespace-nowrap" x-text="'S/ ' + formatearNumero(item.monto)"></p>
                                </div>
                            </div>
                            <div class="px-3 py-2.5">
                                <div class="grid grid-cols-2 gap-2.5 text-xs">
                                    <div class="flex flex-col">
                                        <p class="text-gray-500 dark:text-gray-400 mb-0.5 text-xs">Fecha</p>
                                        <p class="font-medium text-gray-900 dark:text-white text-xs" x-text="formatearFecha(item.fecha)"></p>
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-gray-500 dark:text-gray-400 mb-0.5 text-xs">Hora</p>
                                        <p class="font-medium text-gray-900 dark:text-white text-xs" x-text="item.hora"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="entradasFiltradas.length === 0">
                        <div class="py-12 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <i class="fas fa-inbox text-xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">No se encontraron registros</p>
                        </div>
                    </template>
                    <div class="pt-2.5 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">Total:</span>
                            <span class="text-sm font-bold text-teal-600 dark:text-teal-400 font-numbers" x-text="'S/ ' + formatearNumero(totalEntradas)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
