{{-- Modal de Confirmación de Cierre de Turno --}}
<div x-show="isModalConfirmacionOpen" 
     x-cloak
     @keydown.escape.window="cerrarModalConfirmacion()"
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isModalConfirmacionOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="cerrarModalConfirmacion()"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isModalConfirmacionOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:flex relative w-full max-w-2xl mx-4 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden flex-col">
        <div class="flex flex-col">
            <!-- Header -->
            <div class="flex-shrink-0 px-8 py-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i class="fas fa-check-circle text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Confirmar Cierre de Turno</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">¿Está seguro de registrar el cierre de turno?</p>
                            </div>
                        </div>
                    </div>
                    <button @click="cerrarModalConfirmacion()" 
                            class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                        <i class="fas fa-times text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto min-h-0">
                <div class="p-8 space-y-6">
                    <!-- Resumen de Información -->
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-4">
                            Resumen del Cierre
                        </h4>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total en caja</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white font-numbers">S/ 0.00</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Efectivo Final</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white font-numbers">S/ 0.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Advertencia -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Advertencia</p>
                                <p class="text-xs text-yellow-700 dark:text-yellow-400 mt-1">Una vez registrado el cierre, no podrá modificarlo. Asegúrese de que todos los datos sean correctos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex-shrink-0 px-8 py-5 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <button @click="imprimirCierre()" 
                            type="button"
                            class="flex w-full sm:w-auto items-center justify-center gap-2 text-white bg-gray-700 hover:bg-gray-800 border border-gray-700 hover:border-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-gray-600 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-900">
                        <i class="fas fa-print"></i>
                        <span>Imprimir</span>
                    </button>
                    <button @click="registrarCierre()" 
                            type="button"
                            class="flex w-full sm:w-auto items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 border border-blue-700 hover:border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700 dark:hover:border-blue-700 dark:focus:ring-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Registrar Cierre</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Móvil -->
    <div x-show="isModalConfirmacionOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed inset-x-0 bottom-0 bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[90vh] flex flex-col">
        <div class="flex flex-col h-full">
            <!-- Handle -->
            <div class="flex-shrink-0 flex justify-center pt-3 pb-2">
                <div class="w-12 h-1.5 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
            </div>

            <!-- Header Móvil -->
            <div class="flex-shrink-0 px-5 py-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Confirmar Cierre</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">¿Registrar el cierre de turno?</p>
                    </div>
                </div>
            </div>

            <!-- Content Móvil -->
            <div class="flex-1 overflow-y-auto min-h-0 px-5 py-4">
                <div class="space-y-4">
                    <!-- Resumen -->
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                        <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-3">
                            Resumen
                        </h4>
                        
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total en caja</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white font-numbers">S/ 0.00</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Efectivo Final</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white font-numbers">S/ 0.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Advertencia -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xs mt-0.5"></i>
                            <p class="text-xs text-yellow-700 dark:text-yellow-400">Una vez registrado, no podrá modificarlo.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Móvil -->
            <div class="flex-shrink-0 px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 space-y-2">
                <button @click="imprimirCierre()" 
                        type="button"
                        class="flex w-full items-center justify-center gap-2 text-white bg-gray-700 hover:bg-gray-800 border border-gray-700 hover:border-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-gray-600 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-900">
                    <i class="fas fa-print"></i>
                    <span>Imprimir</span>
                </button>
                <button @click="registrarCierre()" 
                        type="button"
                        class="flex w-full items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 border border-blue-700 hover:border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700 dark:hover:border-blue-700 dark:focus:ring-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Registrar Cierre</span>
                </button>
            </div>
        </div>
    </div>
</div>

