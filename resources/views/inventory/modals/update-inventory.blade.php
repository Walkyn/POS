<!-- Modal de Confirmación de Actualización de Inventario -->
<div x-show="isUpdateInventoryModal" 
     x-cloak
     @keydown.escape.window="isUpdateInventoryModal = false"
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isUpdateInventoryModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isUpdateInventoryModal = false"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isUpdateInventoryModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block no-scrollbar relative w-full max-w-[400px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">

        <!-- Botón cerrar -->
        <button @click="isUpdateInventoryModal = false"
            class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>

        <!-- Contenido del Modal -->
        <div class="p-6 sm:p-8">
            <!-- Icono -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="text-center mb-6">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">
                    Actualizar Inventario
                </h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">
                    Se actualizará el stock del sistema con el stock físico ingresado. Solo se actualizarán los productos con stock físico mayor o igual a 0. Los productos sin cambios no se modificarán.
                </p>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button @click="isUpdateInventoryModal = false" 
                        type="button"
                        class="flex-1 flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                    Cancelar
                </button>
                <button @click="confirmarActualizacion()" 
                        type="button"
                        class="flex-1 flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet -->
    <div x-show="isUpdateInventoryModal"
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

        <!-- Contenido Móvil -->
        <div x-show="isUpdateInventoryModal"
             x-transition:enter="transition ease-out duration-400 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <!-- Icono -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="text-center mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                    Actualizar Inventario
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Se actualizará el stock del sistema con el stock físico ingresado. Solo se actualizarán los productos con stock físico mayor o igual a 0. Los productos sin cambios no se modificarán.
                </p>
            </div>
        </div>

        <!-- Footer con botones fijos Móvil -->
        <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 space-y-2">
            <button @click="confirmarActualizacion()" 
                    type="button"
                    class="w-full flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                Confirmar
            </button>
            <button @click="isUpdateInventoryModal = false" 
                    type="button"
                    class="w-full flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                Cancelar
            </button>
        </div>
    </div>
</div>

