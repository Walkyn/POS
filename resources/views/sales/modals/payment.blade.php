<!-- Modal de Cobro -->
<div x-show="isPaymentModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <div x-show="isPaymentModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px]"></div>

    <!-- Desktop Modal -->
    <div x-show="isPaymentModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block relative w-full max-w-[520px] rounded-2xl bg-white shadow-2xl dark:bg-gray-900 mx-4">

        <button @click="isPaymentModal = false"
            class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 transition-all duration-200">
            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="px-6 pt-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Procesar Pago</h3>
        </div>

        <div class="p-6 max-h-[calc(100vh-200px)] overflow-y-auto">
            
            <!-- Cliente -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Cliente:</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="clienteNombre || 'Cliente General'"></span>
                </div>
            </div>

            <!-- Resumen Financiero -->
            <div class="mb-6 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                    <span class="font-semibold text-gray-900 dark:text-white" x-text="'S/ ' + subtotal"></span>
                </div>
                
                <div class="flex items-center justify-between gap-4">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Descuento</label>
                    <input 
                        type="number"
                        x-model="descuento"
                        @focus="if (descuento == '0' || descuento == 0 || descuento == '0.00') { descuento = ''; }"
                        step="0.01"
                        min="0"
                        :max="subtotal"
                        class="w-32 px-3 py-2 text-sm text-right text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0.00">
                </div>

                <div class="pt-3 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-500" x-text="'S/ ' + total"></span>
                    </div>
                </div>
            </div>

            <!-- Método de Pago -->
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">Método de Pago</label>
                
                <div class="grid grid-cols-4 gap-2">
                    <button @click="tipoPago = 'efectivo'" 
                            :class="tipoPago === 'efectivo' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="px-3 py-2.5 text-xs font-medium rounded-lg transition-all duration-200">
                        Efectivo
                    </button>
                    <button @click="tipoPago = 'tarjeta'" 
                            :class="tipoPago === 'tarjeta' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="px-3 py-2.5 text-xs font-medium rounded-lg transition-all duration-200">
                        Tarjeta
                    </button>
                    <button @click="tipoPago = 'yape'" 
                            :class="tipoPago === 'yape' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="px-3 py-2.5 text-xs font-medium rounded-lg transition-all duration-200">
                        Yape
                    </button>
                    <button @click="tipoPago = 'plin'" 
                            :class="tipoPago === 'plin' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="px-3 py-2.5 text-xs font-medium rounded-lg transition-all duration-200">
                        Plin
                    </button>
                </div>

                <div x-show="tipoPago === 'efectivo'" x-transition class="pt-2">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Monto Recibido</label>
                            <input 
                                type="number"
                                x-model="montoRecibido"
                                @input="montoRecibidoModificadoManual = true"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-3 text-lg font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cambio</label>
                            <div class="w-full px-4 py-3 text-lg font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg" x-text="'S/ ' + cambio"></div>
                        </div>
                    </div>

                    <div x-show="montoRecibido && parseFloat(montoRecibido) < parseFloat(total)" class="mt-2 px-4 py-2.5 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Monto insuficiente
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 rounded-b-2xl">
            <button 
                @click="confirmarCobro()" 
                type="button"
                :disabled="tipoPago === 'efectivo' && (!montoRecibido || parseFloat(montoRecibido) < parseFloat(total))"
                class="w-full flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Confirmar Pago
            </button>
        </div>
    </div>

    <!-- Mobile Bottom Sheet -->
    <div x-show="isPaymentModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[92vh] flex flex-col">
        
        <div class="flex justify-center pt-2 pb-1">
            <div class="w-12 h-1.5 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <div class="px-5 pb-3 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Procesar Pago</h3>
                </div>
                <button @click="isPaymentModal = false"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-5">
            
            <!-- Cliente -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 dark:text-gray-400">Cliente:</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="clienteNombre || 'Cliente General'"></span>
                </div>
            </div>

            <div class="mb-5 space-y-2.5">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                    <span class="font-semibold text-gray-900 dark:text-white" x-text="'S/ ' + subtotal"></span>
                </div>
                
                <div class="flex items-center justify-between gap-3">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Descuento</label>
                    <input 
                        type="number"
                        x-model="descuento"
                        @focus="if (descuento == '0' || descuento == 0 || descuento == '0.00') { descuento = ''; }"
                        step="0.01"
                        min="0"
                        :max="subtotal"
                        class="w-28 px-3 py-2 text-sm text-right text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="0.00">
                </div>

                <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-bold text-gray-900 dark:text-white">Total</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-500" x-text="'S/ ' + total"></span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">Método de Pago</label>
                
                <div class="grid grid-cols-4 gap-2">
                    <button @click="tipoPago = 'efectivo'" 
                            :class="tipoPago === 'efectivo' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'"
                            class="px-2 py-3 text-xs font-medium rounded-lg transition-all duration-200">
                        Efectivo
                    </button>
                    <button @click="tipoPago = 'tarjeta'" 
                            :class="tipoPago === 'tarjeta' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'"
                            class="px-2 py-3 text-xs font-medium rounded-lg transition-all duration-200">
                        Tarjeta
                    </button>
                    <button @click="tipoPago = 'yape'" 
                            :class="tipoPago === 'yape' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'"
                            class="px-2 py-3 text-xs font-medium rounded-lg transition-all duration-200">
                        Yape
                    </button>
                    <button @click="tipoPago = 'plin'" 
                            :class="tipoPago === 'plin' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'"
                            class="px-2 py-3 text-xs font-medium rounded-lg transition-all duration-200">
                        Plin
                    </button>
                </div>

                <div x-show="tipoPago === 'efectivo'" x-transition class="pt-2">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Monto Recibido</label>
                            <input 
                                type="number"
                                x-model="montoRecibido"
                                @input="montoRecibidoModificadoManual = true"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2 text-lg font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cambio</label>
                            <div class="w-full px-4 py-2 text-lg font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg" x-text="'S/ ' + cambio"></div>
                        </div>
                    </div>

                    <div x-show="montoRecibido && parseFloat(montoRecibido) < parseFloat(total)" class="mt-2 px-3 py-2.5 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Monto insuficiente
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
            <button 
                @click="confirmarCobro()" 
                type="button"
                :disabled="tipoPago === 'efectivo' && (!montoRecibido || parseFloat(montoRecibido) < parseFloat(total))"
                class="w-full flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Confirmar Pago
            </button>
        </div>
    </div>
</div>