{{-- Modal Validación Lote --}}
{{-- Muestra un mensaje de advertencia cuando se intenta guardar un lote sin cantidad válida --}}
<div x-show="isValidationLoteModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    {{-- Overlay --}}
    <div x-show="isValidationLoteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-200"></div>

    {{-- Modal Desktop --}}
    <div x-show="isValidationLoteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block no-scrollbar relative w-full max-w-[450px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">
        <button @click="isValidationLoteModal = false; setTimeout(() => { loteToValidate = null; }, 200);"
            class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-4 sm:mb-6 flex items-start gap-3 sm:gap-4">
                <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1 pt-3">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                        Validación Requerida
                    </h3>
                </div>
            </div>

            <div class="mb-4 sm:mb-6">
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">
                    Por favor ingresa una <strong class="text-gray-900 dark:text-white">cantidad válida</strong> mayor a cero y un <strong class="text-gray-900 dark:text-white">precio de venta válido</strong> mayor a cero para poder guardar el lote.
                </p>
            </div>

            <div x-show="loteToValidate" class="mb-4 sm:mb-4">
                <div class="space-y-3 sm:space-y-3">
                    <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 sm:p-3">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                <span class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                <span class="text-sm sm:text-base font-bold text-gray-900 dark:text-white font-mono break-all"
                                    x-text="loteToValidate ? (loteToValidate.numero_lote || 'Lote sin número') : ''"></span>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold text-red-600 dark:text-red-400">Cantidad:</span>
                                <span class="ml-1" x-text="loteToValidate ? (loteToValidate.cantidad !== null && loteToValidate.cantidad !== undefined ? loteToValidate.cantidad : 'No definida') : 'No definida'"></span>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold text-red-600 dark:text-red-400">Precio Venta:</span>
                                <span class="ml-1" x-text="loteToValidate ? (loteToValidate.precio_venta !== null && loteToValidate.precio_venta !== undefined ? '$' + parseFloat(loteToValidate.precio_venta || 0).toFixed(2) : 'No definido') : 'No definido'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:mt-6">
                <button @click="isValidationLoteModal = false; setTimeout(() => { loteToValidate = null; }, 200);" type="button"
                    class="w-full rounded-xl bg-yellow-600 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-sm font-semibold text-white shadow-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 transition-colors">
                    Entendido
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Móvil - Bottom Sheet estilo Android --}}
    <div x-show="isValidationLoteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col">
        
        {{-- Handle Bar --}}
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        {{-- Header Móvil --}}
        <div x-show="isValidationLoteModal"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Validación Requerida
                </h3>
                <button @click="isValidationLoteModal = false; setTimeout(() => { loteToValidate = null; }, 200);"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Contenido con scroll Móvil --}}
        <div x-show="isValidationLoteModal"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Por favor ingresa una <strong class="text-gray-900 dark:text-white">cantidad válida</strong> mayor a cero y un <strong class="text-gray-900 dark:text-white">precio de venta válido</strong> mayor a cero para poder guardar el lote.
                </p>
            </div>

            <div x-show="loteToValidate" class="mb-4">
                <div class="space-y-3">
                    <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white font-mono break-all"
                                    x-text="loteToValidate ? (loteToValidate.numero_lote || 'Lote sin número') : ''"></span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                <span class="font-semibold text-red-600 dark:text-red-400">Cantidad:</span>
                                <span class="ml-1" x-text="loteToValidate ? (loteToValidate.cantidad !== null && loteToValidate.cantidad !== undefined ? loteToValidate.cantidad : 'No definida') : 'No definida'"></span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                <span class="font-semibold text-red-600 dark:text-red-400">Precio Venta:</span>
                                <span class="ml-1" x-text="loteToValidate ? (loteToValidate.precio_venta !== null && loteToValidate.precio_venta !== undefined ? '$' + parseFloat(loteToValidate.precio_venta || 0).toFixed(2) : 'No definido') : 'No definido'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer con botón fijo Móvil --}}
        <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 flex-shrink-0">
            <button @click="isValidationLoteModal = false; setTimeout(() => { loteToValidate = null; }, 200);" 
                type="button"
                class="w-full flex items-center justify-center rounded-lg bg-yellow-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg hover:bg-yellow-700 focus:outline-none focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-900 transition-colors">
                Entendido
            </button>
        </div>
    </div>
</div>

