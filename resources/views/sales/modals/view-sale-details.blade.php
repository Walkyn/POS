<!-- Modal de Detalles de Venta -->
<div x-show="isViewDetailsModal && ventaSeleccionada" 
     x-cloak
     class="fixed inset-0 z-[9999] flex items-center justify-center">
    
    <!-- Overlay -->
    <div x-show="isViewDetailsModal && ventaSeleccionada"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isViewDetailsModal = false; setTimeout(() => { ventaSeleccionada = null; }, 200);"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isViewDetailsModal && ventaSeleccionada"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:flex relative w-full max-w-3xl mx-4 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden flex-col max-h-[92vh]">

        <!-- Header -->
        <div class="flex-shrink-0 px-8 py-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-start justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <i class="fas fa-receipt text-gray-600 dark:text-gray-400 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Boleta de Venta</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="ventaSeleccionada && ventaSeleccionada.numero_ticket ? ventaSeleccionada.numero_ticket : 'N/A'"></p>
                        </div>
                    </div>
                </div>
                <button @click="isViewDetailsModal = false; setTimeout(() => { ventaSeleccionada = null; }, 200);" 
                        class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-gray-600 dark:text-gray-400"></i>
                </button>
            </div>

            <div class="grid grid-cols-4 gap-4 mt-6">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha y Hora</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? formatearFecha(ventaSeleccionada.fecha, ventaSeleccionada.hora) + ' ' + formatearHora(ventaSeleccionada.hora) : ''"></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cajero</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? (ventaSeleccionada.vendedor || 'N/A') : 'N/A'"></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Método de Pago</p>
                    <div class="flex items-center gap-2">
                        <i :class="ventaSeleccionada ? getMetodoPagoIcon(ventaSeleccionada.metodo_pago) + ' text-gray-600 dark:text-gray-400' : ''" class="fas text-sm"></i>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? ventaSeleccionada.metodo_pago : ''"></p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Estado</p>
                    <span :class="ventaSeleccionada ? getEstadoClass(ventaSeleccionada.estado) : ''" 
                          class="px-2.5 py-1 text-xs font-bold rounded-md inline-flex items-center gap-1.5">
                        <i :class="ventaSeleccionada ? 'fas ' + getEstadoIcon(ventaSeleccionada.estado) : ''" class="text-xs"></i>
                        <span x-text="ventaSeleccionada ? getEstadoText(ventaSeleccionada.estado) : ''"></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto min-h-0">
            <div class="p-8 space-y-6">
                
                <!-- Cliente -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Información del Cliente</h3>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Nombre</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? (ventaSeleccionada.cliente || 'Público General') : 'Público General'"></p>
                        </div>
                        <div x-show="ventaSeleccionada && ventaSeleccionada.cliente_dni">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">DNI/RUC</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? ventaSeleccionada.cliente_dni : ''"></p>
                        </div>
                        <div x-show="ventaSeleccionada && ventaSeleccionada.cliente_telefono">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Teléfono</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? ventaSeleccionada.cliente_telefono : ''"></p>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-boxes text-gray-500 dark:text-gray-400"></i>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Productos</h3>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-800/80">
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-3.5 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Código</th>
                                        <th class="text-left py-3.5 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Producto</th>
                                        <th class="text-left py-3.5 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Lote</th>
                                        <th class="text-center py-3.5 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Cantidad</th>
                                        <th class="text-right py-3.5 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Importe</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-for="(producto, index) in (ventaSeleccionada && ventaSeleccionada.productos ? ventaSeleccionada.productos : [])" :key="index">
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                            <td class="py-3.5 px-4 text-xs font-mono text-gray-600 dark:text-gray-400" x-text="producto.codigo || producto.codigo_barras || 'N/A'"></td>
                                            <td class="py-3.5 px-4 text-sm font-medium text-gray-900 dark:text-white" x-text="producto.nombre"></td>
                                            <td class="py-3.5 px-4 text-left text-xs text-gray-600 dark:text-gray-400" x-text="producto.numero_lote || producto.lote || 'N/A'"></td>
                                            <td class="py-3.5 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white" x-text="producto.cantidad"></td>
                                            <td class="py-3.5 px-4 text-right text-sm font-bold text-gray-900 dark:text-white" x-text="'S/ ' + producto.subtotal.toFixed(2)"></td>
                                        </tr>
                                    </template>
                                    <template x-if="!ventaSeleccionada || !ventaSeleccionada.productos || ventaSeleccionada.productos.length === 0">
                                        <tr>
                                            <td colspan="5" class="py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-box-open text-3xl mb-2 opacity-50"></i>
                                                <p>No hay productos registrados</p>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800/50 rounded-lg p-4 border border-blue-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-calculator text-xs text-blue-600 dark:text-blue-400"></i>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Resumen</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center pb-2 border-b border-blue-200 dark:border-gray-700">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? 'S/ ' + (ventaSeleccionada.subtotal || 0).toFixed(2) : 'S/ 0.00'"></span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-blue-200 dark:border-gray-700">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Descuento</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">S/ 0.00</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400" x-text="ventaSeleccionada ? 'S/ ' + ventaSeleccionada.total.toFixed(2) : 'S/ 0.00'"></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="flex-shrink-0 px-8 py-5 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex gap-3">
                <button @click="isViewDetailsModal = false; setTimeout(() => { ventaSeleccionada = null; }, 200);" 
                        type="button"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cerrar
                </button>
                <div class="flex-1"></div>
                <button x-show="ventaSeleccionada && !ventaSeleccionada.numero_factura"
                        @click="generarFactura()"
                        type="button"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 shadow-sm transition-colors">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Generar Factura
                </button>
                <button x-show="ventaSeleccionada && ventaSeleccionada.numero_factura"
                        @click="verFactura()"
                        type="button"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 shadow-sm transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Factura
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Móvil -->
    <div x-show="isViewDetailsModal && ventaSeleccionada"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed inset-x-0 bottom-0 bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[90vh] flex flex-col">
        
        <!-- Handle -->
        <div class="flex-shrink-0 flex justify-center pt-3 pb-2">
            <div class="w-12 h-1.5 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Header Móvil -->
        <div class="flex-shrink-0 px-5 py-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-receipt text-gray-600 dark:text-gray-400 text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Boleta</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate" x-text="ventaSeleccionada && ventaSeleccionada.numero_ticket ? ventaSeleccionada.numero_ticket : 'N/A'"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha</p>
                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate" x-text="ventaSeleccionada ? formatearFecha(ventaSeleccionada.fecha, ventaSeleccionada.hora) : ''"></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Hora</p>
                    <p class="text-xs font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? formatearHora(ventaSeleccionada.hora) : ''"></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cajero</p>
                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate" x-text="ventaSeleccionada ? (ventaSeleccionada.vendedor || 'N/A') : 'N/A'"></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pago</p>
                    <div class="flex items-center gap-1.5">
                        <i :class="ventaSeleccionada ? getMetodoPagoIcon(ventaSeleccionada.metodo_pago) + ' text-gray-600 dark:text-gray-400' : ''" class="fas text-xs"></i>
                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate" x-text="ventaSeleccionada ? ventaSeleccionada.metodo_pago : ''"></p>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <span :class="ventaSeleccionada ? getEstadoClass(ventaSeleccionada.estado) : ''" 
                      class="px-3 py-1.5 text-xs font-bold rounded-lg inline-flex items-center gap-1.5">
                    <i :class="ventaSeleccionada ? 'fas ' + getEstadoIcon(ventaSeleccionada.estado) : ''" class="text-xs"></i>
                    <span x-text="ventaSeleccionada ? getEstadoText(ventaSeleccionada.estado) : ''"></span>
                </span>
            </div>
        </div>

        <!-- Content Móvil -->
        <div class="flex-1 overflow-y-auto min-h-0 px-5 py-4">
            <div class="space-y-4">
                
                <!-- Cliente -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-user text-xs text-gray-500 dark:text-gray-400"></i>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Cliente</h3>
                    </div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2" x-text="ventaSeleccionada ? (ventaSeleccionada.cliente || 'Público General') : 'Público General'"></p>
                    <div class="flex gap-3 flex-wrap">
                        <div x-show="ventaSeleccionada && ventaSeleccionada.cliente_dni" class="text-xs">
                            <span class="text-gray-500 dark:text-gray-400">DNI: </span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? ventaSeleccionada.cliente_dni : ''"></span>
                        </div>
                        <div x-show="ventaSeleccionada && ventaSeleccionada.cliente_telefono" class="text-xs">
                            <span class="text-gray-500 dark:text-gray-400">Tel: </span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? ventaSeleccionada.cliente_telefono : ''"></span>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-boxes text-xs text-gray-500 dark:text-gray-400"></i>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Productos</h3>
                    </div>
                    <div class="space-y-2.5">
                        <template x-for="(producto, index) in (ventaSeleccionada && ventaSeleccionada.productos ? ventaSeleccionada.productos : [])" :key="index">
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start gap-3 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1" x-text="producto.codigo || producto.codigo_barras || 'N/A'"></p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1" x-text="producto.nombre"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="'Lote: ' + (producto.numero_lote || producto.lote || 'N/A')"></p>
                                    </div>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400 flex-shrink-0" x-text="'S/ ' + producto.subtotal.toFixed(2)"></p>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <div class="text-xs">
                                        <span class="text-gray-500 dark:text-gray-400">Cantidad: </span>
                                        <span class="font-bold text-gray-900 dark:text-white" x-text="producto.cantidad"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!ventaSeleccionada || !ventaSeleccionada.productos || ventaSeleccionada.productos.length === 0">
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <i class="fas fa-box-open text-2xl mb-2 opacity-50"></i>
                                <p class="text-sm">No hay productos</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800/50 rounded-lg p-4 border border-blue-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-calculator text-xs text-blue-600 dark:text-blue-400"></i>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Resumen</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white" x-text="ventaSeleccionada ? 'S/ ' + (ventaSeleccionada.subtotal || 0).toFixed(2) : 'S/ 0.00'"></span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-blue-200 dark:border-gray-700">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Descuento</span>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">S/ 0.00</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400" x-text="ventaSeleccionada ? 'S/ ' + ventaSeleccionada.total.toFixed(2) : 'S/ 0.00'"></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer Móvil -->
        <div class="flex-shrink-0 px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex gap-2.5">
                <button @click="isViewDetailsModal = false; setTimeout(() => { ventaSeleccionada = null; }, 200);" 
                        type="button"
                        class="px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-700 bg-white dark:bg-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600">
                    <i class="fas fa-times mr-1.5"></i>
                    Cerrar
                </button>
                <button x-show="ventaSeleccionada && !ventaSeleccionada.numero_factura"
                        @click="generarFactura()"
                        type="button"
                        class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-blue-600 dark:bg-blue-600">
                    <i class="fas fa-file-invoice mr-1.5"></i>
                    Facturar
                </button>
                <button x-show="ventaSeleccionada && ventaSeleccionada.numero_factura"
                        @click="verFactura()"
                        type="button"
                        class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-blue-600 dark:bg-blue-600">
                    <i class="fas fa-eye mr-1.5"></i>
                    Ver Factura
                </button>
            </div>
        </div>
    </div>
</div>