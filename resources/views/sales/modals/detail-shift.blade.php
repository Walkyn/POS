{{-- Modal de Detalles del Cierre de Turno --}}
<div x-show="isModalOpen && cierreSeleccionado" 
     x-cloak
     @keydown.escape.window="cerrarModal()"
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isModalOpen && cierreSeleccionado"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="cerrarModal()"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isModalOpen && cierreSeleccionado"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:flex relative w-full max-w-3xl mx-4 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden flex-col max-h-[92vh]">
        <template x-if="cierreSeleccionado">
            <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="flex-shrink-0 px-8 py-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    <i class="fas fa-calendar-check text-gray-600 dark:text-gray-400 text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cierre de Turno</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="formatearFecha(cierreSeleccionado.fecha)"></p>
                                </div>
                            </div>
                        </div>
                        <button @click="cerrarModal()" 
                                class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-gray-600 dark:text-gray-400"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mt-6">
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Usuario</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="cierreSeleccionado.usuario"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Ventas</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.totalVentas)"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tickets</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="cierreSeleccionado.tickets"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fondo caja</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.efectivoInicial)"></p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto min-h-0">
                    <div class="p-8 space-y-6">
                        
                        <!-- Información de Efectivo -->
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-money-bill-wave text-gray-500 dark:text-gray-400"></i>
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Información de Efectivo</h3>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total en Caja</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.totalEnCaja)"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Efectivo Final</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.efectivoFinal)"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Diferencia</p>
                                    <p class="text-sm font-bold text-green-600 dark:text-green-400 font-numbers" x-text="formatearMoneda(cierreSeleccionado.diferencia)"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="flex-shrink-0 px-8 py-5 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <button @click="cerrarModal()" 
                                type="button"
                                class="px-6 py-2.5 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Modal Móvil -->
    <div x-show="isModalOpen && cierreSeleccionado"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed inset-x-0 bottom-0 bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[90vh] flex flex-col">
        <template x-if="cierreSeleccionado">
            <div class="flex flex-col h-full">
                <!-- Handle -->
                <div class="flex-shrink-0 flex justify-center pt-3 pb-2">
                    <div class="w-12 h-1.5 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                </div>

                <!-- Header Móvil -->
                <div class="flex-shrink-0 px-5 py-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-check text-gray-600 dark:text-gray-400 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cierre de Turno</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate" x-text="formatearFecha(cierreSeleccionado.fecha)"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Usuario</p>
                            <p class="text-xs font-semibold text-gray-900 dark:text-white truncate" x-text="cierreSeleccionado.usuario"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tickets</p>
                            <p class="text-xs font-semibold text-gray-900 dark:text-white" x-text="cierreSeleccionado.tickets"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Ventas</p>
                            <p class="text-xs font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.totalVentas)"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fondo caja</p>
                            <p class="text-xs font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.efectivoInicial)"></p>
                        </div>
                    </div>
                </div>

                <!-- Content Móvil -->
                <div class="flex-1 overflow-y-auto min-h-0 px-5 py-4">
                    <div class="space-y-4">
                        
                        <!-- Información de Efectivo -->
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-money-bill-wave text-xs text-gray-500 dark:text-gray-400"></i>
                                <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Efectivo</h3>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total en Caja</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.totalEnCaja)"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Efectivo Final</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white font-numbers" x-text="formatearMoneda(cierreSeleccionado.efectivoFinal)"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Diferencia</p>
                                    <p class="text-sm font-bold text-green-600 dark:text-green-400 font-numbers" x-text="formatearMoneda(cierreSeleccionado.diferencia)"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer Móvil -->
                <div class="flex-shrink-0 px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    <button @click="cerrarModal()" 
                            type="button"
                            class="w-full px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-700 bg-white dark:bg-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600">
                        <i class="fas fa-times mr-1.5"></i>
                        Cerrar
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

