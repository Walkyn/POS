<!-- Modal de Confirmación de Limpiar Ticket -->
<div x-show="isClearTicketModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isClearTicketModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isClearTicketModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block no-scrollbar relative w-full max-w-[450px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">

        <!-- Botón cerrar -->
        <button @click="isClearTicketModal = false"
            class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>

        <!-- Título -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Limpiar Ticket
            </h3>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Información -->
            <div class="mb-4 sm:mb-4">
                <div class="space-y-3 sm:space-y-3">
                    <p class="text-base sm:text-lg text-gray-700 dark:text-gray-300">
                        ¿Estás seguro de limpiar el ticket?
                    </p>
                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                        Se eliminarán todos los productos del ticket. Esta acción no se puede deshacer.
                    </p>
                    
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Total de productos:</span>
                            <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white"
                                x-text="productosTicket.length"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Subtotal:</span>
                            <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white"
                                x-text="'S/ ' + subtotal"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de Confirmar -->
            <div class="flex justify-center mt-4 sm:mt-6">
                <button @click="confirmClearTicket()" type="button"
                    class="w-full rounded-xl bg-red-600 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                    Limpiar Ticket
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet -->
    <div x-show="isClearTicketModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Header Móvil -->
        <div x-show="isClearTicketModal"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Limpiar Ticket
                </h3>
                <button @click="isClearTicketModal = false"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido con scroll Móvil -->
        <div x-show="isClearTicketModal"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <!-- Información Móvil -->
            <div class="mb-4">
                <div class="space-y-3">
                    <p class="text-base text-gray-700 dark:text-gray-300">
                        ¿Estás seguro de que deseas limpiar todo el ticket?
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Se eliminarán todos los productos del ticket. Esta acción no se puede deshacer.
                    </p>
                    
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de productos:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white"
                                x-text="productosTicket.length"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base font-bold text-gray-900 dark:text-white">Subtotal:</span>
                            <span class="text-base font-bold text-gray-900 dark:text-white"
                                x-text="'S/ ' + subtotal"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer con botón fijo Móvil -->
        <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <button @click="confirmClearTicket()" 
                type="button"
                class="w-full flex items-center justify-center rounded-lg bg-red-600 px-6 py-2.5 sm:px-8 sm:py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 transition-colors">
                Limpiar Ticket
            </button>
        </div>
    </div>
</div>

