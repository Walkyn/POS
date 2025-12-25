<!-- Modal de Confirmación de Eliminación de Copia de Seguridad -->
<div x-show="isDeleteConfirmModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay - Mismo para móvil y desktop con animación uniforme -->
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

        <!-- close btn -->
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
                Confirmar Eliminación
            </h3>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-4 sm:p-6 lg:p-8">

            <!-- Información del Backup a Eliminar -->
            <div x-show="itemToDelete" class="mb-4 sm:mb-4">
                <div class="space-y-3 sm:space-y-3">
                    <!-- Nombre del Archivo -->
                    <div>
                        <p class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-1 break-words"
                            x-text="itemToDelete ? (itemToDelete.name || 'Copia de Seguridad') : ''"></p>
                    </div>

                    <!-- Información adicional -->
                    <div class="space-y-2.5 sm:space-y-3">
                        <!-- Tipo de Backup -->
                        <template x-if="itemToDelete && itemToDelete.type">
                            <div class="flex items-center justify-between">
                                <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Tipo:</span>
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full"
                                      :class="itemToDelete.type === 'MySQL' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'">
                                    <i :class="itemToDelete.type === 'MySQL' ? 'fas fa-database' : 'fas fa-file-excel'"></i>
                                    <span x-text="itemToDelete.type"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Mensaje de advertencia -->
            <div class="mb-4 sm:mb-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Esta acción no se puede deshacer. La copia de seguridad será eliminada permanentemente.
                </p>
            </div>

            <!-- Botón de Confirmar -->
            <div class="flex justify-center mt-4 sm:mt-6">
                <button @click="confirmDelete()" type="button"
                    class="w-full rounded-xl bg-red-600 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                    Confirmar
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
                    Confirmar Eliminación
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
            <!-- Información del Backup a Eliminar Móvil -->
            <div x-show="itemToDelete" class="mb-4">
                <div class="space-y-3">
                    <!-- Nombre del Archivo -->
                    <div>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mb-1 break-words"
                            x-text="itemToDelete ? (itemToDelete.name || 'Copia de Seguridad') : ''"></p>
                    </div>

                    <!-- Información adicional -->
                    <div class="space-y-2.5">
                        <!-- Tipo de Backup -->
                        <template x-if="itemToDelete && itemToDelete.type">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo:</span>
                                <span class="inline-flex items-center gap-2 px-2.5 py-1 text-xs font-semibold rounded-full"
                                      :class="itemToDelete.type === 'MySQL' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'">
                                    <i :class="itemToDelete.type === 'MySQL' ? 'fas fa-database' : 'fas fa-file-excel'"></i>
                                    <span x-text="itemToDelete.type"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Mensaje de advertencia -->
            <div class="mb-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Esta acción no se puede deshacer. La copia de seguridad será eliminada permanentemente.
                </p>
            </div>
        </div>

        <!-- Footer con botón fijo Móvil -->
        <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <button @click="confirmDelete()" 
                type="button"
                class="w-full flex items-center justify-center rounded-lg bg-red-600 px-6 py-2.5 sm:px-8 sm:py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 transition-colors">
                Confirmar
            </button>
        </div>
    </div>
</div>

