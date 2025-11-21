<!-- Modal de Confirmación de Eliminación de Producto -->
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

            <!-- Información del Item a Eliminar -->
            <div x-show="itemToDelete" class="mb-4 sm:mb-4">
                <div class="space-y-3 sm:space-y-3">
                    <!-- Nombre/Título del Item -->
                    <div>
                        <p class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-1 break-words"
                            x-text="itemToDelete ? (itemToDelete.numero_lote ? (itemToDelete.producto_nombre || 'Producto') : (itemToDelete.name || itemToDelete.title || itemToDelete.nombre || 'Elemento')) : ''"></p>
                    </div>

                    <!-- Información adicional dinámica -->
                    <div class="space-y-2.5 sm:space-y-3">
                        <!-- Información de Lote (cuando se elimina un lote) -->
                        <template x-if="itemToDelete && itemToDelete.numero_lote">
                            <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 sm:p-3">
                                <div class="space-y-1.5">
                                        <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                            <span class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                            <span class="text-sm sm:text-base font-bold text-gray-900 dark:text-white font-mono break-all" x-text="itemToDelete.numero_lote || 'Lote sin número'"></span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                                            <div class="flex items-center gap-1 sm:gap-1.5">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Cantidad:</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" x-text="itemToDelete.cantidad || '0'"></span>
                                            </div>
                                            <div class="flex items-center gap-1 sm:gap-1.5">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Vence:</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white break-words" x-text="itemToDelete.fecha_vencimiento ? new Date(itemToDelete.fecha_vencimiento).toLocaleDateString('es-PE') : 'N/A'"></span>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-1.5 sm:gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                            <template x-if="itemToDelete && itemToDelete.precio_costo !== undefined">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">P. Costo</span>
                                                    <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(itemToDelete.precio_costo || 0).toFixed(2)"></span>
                                                </div>
                                            </template>
                                            <template x-if="itemToDelete && itemToDelete.precio_venta !== undefined">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">P. Venta</span>
                                                    <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(itemToDelete.precio_venta || 0).toFixed(2)"></span>
                                                </div>
                                            </template>
                                            <template x-if="itemToDelete && itemToDelete.precio_mayoreo !== undefined">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">P. Mayoreo</span>
                                                    <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(itemToDelete.precio_mayoreo || 0).toFixed(2)"></span>
                                                </div>
                                            </template>
                                        </div>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Campos dinámicos basados en el tipo de item -->
                        <template x-if="itemToDelete && itemToDelete.category && !itemToDelete.numero_lote">
                            <div class="flex items-center justify-between">
                                <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Categoría:</span>
                                <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white text-right break-words"
                                    x-text="itemToDelete.category"></span>
                            </div>
                        </template>
                        
                        <template x-if="itemToDelete && itemToDelete.stock !== undefined">
                            <div class="flex items-center justify-between">
                                <span class="text-sm sm:text-base font-medium text-gray-500 dark:text-gray-400">Stock:</span>
                                <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white text-right"
                                    x-text="itemToDelete.stock"></span>
                            </div>
                        </template>

                        <template x-if="itemToDelete && itemToDelete.email">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-0">
                                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white break-all sm:text-right"
                                    x-text="itemToDelete.email"></span>
                            </div>
                        </template>

                        <template x-if="itemToDelete && itemToDelete.telefono">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-0">
                                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono:</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white sm:text-right break-words"
                                    x-text="itemToDelete.telefono"></span>
                            </div>
                        </template>

                        <template x-if="itemToDelete && itemToDelete.description">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-1 sm:gap-0">
                                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Descripción:</span>
                                <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 sm:text-right sm:max-w-[60%] break-words"
                                    x-text="itemToDelete.description"></span>
                            </div>
                        </template>

                        <!-- Campos personalizados adicionales -->
                        <template x-if="itemToDelete && itemToDelete.fields">
                            <template x-for="(value, key) in itemToDelete.fields" :key="key">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400" x-text="key + ':'"></span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="value"></span>
                                </div>
                            </template>
                        </template>
                    </div>

                    <!-- Sección de Lotes (solo para productos, no para lotes individuales) -->
                    <div x-show="itemToDelete && !itemToDelete.numero_lote" class="border-t border-gray-200 dark:border-gray-700 pt-2
                     sm:pt-2 mt-3 sm:mt-2">
                        <div class="flex items-center justify-between mb-3 sm:mb-3">
                            <h4 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white flex items-center gap-1.5 sm:gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="hidden sm:inline">Lotes Registrados</span>
                                <span class="sm:hidden">Lotes</span>
                            </h4>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full"
                                x-text="itemToDelete && itemToDelete.lotes && Array.isArray(itemToDelete.lotes) ? itemToDelete.lotes.length + ' ' : '0 '"></span>
                        </div>
                        <div class="space-y-2 sm:space-y-2.5 max-h-48 sm:max-h-56 overflow-y-auto custom-scrollbar pr-1">
                            <template x-if="itemToDelete && itemToDelete.lotes && Array.isArray(itemToDelete.lotes) && itemToDelete.lotes.length > 0">
                                <div class="space-y-2 sm:space-y-2.5">
                                    <template x-for="(lote, index) in itemToDelete.lotes" :key="index">
                                        <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 sm:p-3 hover:shadow-md transition-all duration-200">
                                            <div class="space-y-1.5">
                                                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                                        <span class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                                        <span class="text-sm sm:text-base font-bold text-gray-900 dark:text-white font-mono break-all"
                                                            x-text="lote.numero || 'LOTE-' + String(index + 1).padStart(4, '0')"></span>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                                                        <div class="flex items-center gap-1 sm:gap-1.5">
                                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                            </svg>
                                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Cantidad:</span>
                                                            <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.cantidad || '0'"></span>
                                                        </div>
                                                        <div class="flex items-center gap-1 sm:gap-1.5">
                                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Vence:</span>
                                                            <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white break-words" x-text="lote.fecha_vencimiento || 'N/A'"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="itemToDelete && (!itemToDelete.lotes || !Array.isArray(itemToDelete.lotes) || itemToDelete.lotes.length === 0)">
                                <div class="flex flex-col items-center justify-center py-6 sm:py-8 px-3 sm:px-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 text-center">No hay lotes registrados</p>
                                    <p class="text-[10px] sm:text-xs text-gray-400 dark:text-gray-500 mt-1 text-center px-2">Este producto no tiene lotes asociados</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
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
            <!-- Información del Item a Eliminar Móvil -->
            <div x-show="itemToDelete" class="mb-4">
                <div class="space-y-3">
                    <!-- Nombre/Título del Item -->
                    <div>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mb-1 break-words"
                            x-text="itemToDelete ? (itemToDelete.numero_lote ? (itemToDelete.producto_nombre || 'Producto') : (itemToDelete.name || itemToDelete.title || itemToDelete.nombre || 'Elemento')) : ''"></p>
                    </div>

                    <!-- Información adicional dinámica -->
                    <div class="space-y-2.5">
                        <!-- Información de Lote (cuando se elimina un lote) -->
                        <template x-if="itemToDelete && itemToDelete.numero_lote">
                            <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                                <div class="space-y-1.5">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                            <span class="text-sm font-bold text-gray-900 dark:text-white font-mono break-all" x-text="itemToDelete.numero_lote || 'Lote sin número'"></span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Cantidad:</span>
                                                <span class="text-xs font-semibold text-gray-900 dark:text-white" x-text="itemToDelete.cantidad || '0'"></span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Vence:</span>
                                                <span class="text-xs font-semibold text-gray-900 dark:text-white break-words" x-text="itemToDelete.fecha_vencimiento ? new Date(itemToDelete.fecha_vencimiento).toLocaleDateString('es-PE') : 'N/A'"></span>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                            <template x-if="itemToDelete && itemToDelete.precio_costo !== undefined">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">P. Costo</span>
                                                    <span class="text-xs font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(itemToDelete.precio_costo || 0).toFixed(2)"></span>
                                                </div>
                                            </template>
                                            <template x-if="itemToDelete && itemToDelete.precio_venta !== undefined">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">P. Venta</span>
                                                    <span class="text-xs font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(itemToDelete.precio_venta || 0).toFixed(2)"></span>
                                                </div>
                                            </template>
                                            <template x-if="itemToDelete && itemToDelete.precio_mayoreo !== undefined">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">P. Mayoreo</span>
                                                    <span class="text-xs font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(itemToDelete.precio_mayoreo || 0).toFixed(2)"></span>
                                                </div>
                                            </template>
                                        </div>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Campos dinámicos basados en el tipo de item -->
                        <template x-if="itemToDelete && itemToDelete.category && !itemToDelete.numero_lote">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Categoría:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white text-right break-words"
                                    x-text="itemToDelete.category"></span>
                            </div>
                        </template>
                        
                        <template x-if="itemToDelete && itemToDelete.stock !== undefined">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white text-right"
                                    x-text="itemToDelete.stock"></span>
                            </div>
                        </template>

                        <template x-if="itemToDelete && itemToDelete.email">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                <span class="text-xs font-semibold text-gray-900 dark:text-white break-all"
                                    x-text="itemToDelete.email"></span>
                            </div>
                        </template>

                        <template x-if="itemToDelete && itemToDelete.telefono">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Teléfono:</span>
                                <span class="text-xs font-semibold text-gray-900 dark:text-white break-words"
                                    x-text="itemToDelete.telefono"></span>
                            </div>
                        </template>

                        <template x-if="itemToDelete && itemToDelete.description">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Descripción:</span>
                                <span class="text-xs text-gray-700 dark:text-gray-300 break-words"
                                    x-text="itemToDelete.description"></span>
                            </div>
                        </template>

                        <!-- Campos personalizados adicionales -->
                        <template x-if="itemToDelete && itemToDelete.fields">
                            <template x-for="(value, key) in itemToDelete.fields" :key="key">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400" x-text="key + ':'"></span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="value"></span>
                                </div>
                            </template>
                        </template>
                    </div>

                    <!-- Sección de Lotes (solo para productos, no para lotes individuales) -->
                    <div x-show="itemToDelete && !itemToDelete.numero_lote" class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-3">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>Lotes</span>
                            </h4>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full"
                                x-text="itemToDelete && itemToDelete.lotes && Array.isArray(itemToDelete.lotes) ? itemToDelete.lotes.length + ' ' : '0 '"></span>
                        </div>
                        <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar pr-1">
                            <template x-if="itemToDelete && itemToDelete.lotes && Array.isArray(itemToDelete.lotes) && itemToDelete.lotes.length > 0">
                                <div class="space-y-2">
                                    <template x-for="(lote, index) in itemToDelete.lotes" :key="index">
                                        <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 transition-all duration-300"
                                             :style="`animation: fadeInUp 0.4s ease-out ${(index * 0.05) + 0.4}s both;`">
                                            <div class="space-y-1.5">
                                                    <div class="flex items-center gap-1.5 flex-wrap">
                                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                                        <span class="text-sm font-bold text-gray-900 dark:text-white font-mono break-all"
                                                            x-text="lote.numero || 'LOTE-' + String(index + 1).padStart(4, '0')"></span>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-1.5">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                            </svg>
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">Cantidad:</span>
                                                            <span class="text-xs font-semibold text-gray-900 dark:text-white" x-text="lote.cantidad || '0'"></span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">Vence:</span>
                                                            <span class="text-xs font-semibold text-gray-900 dark:text-white break-words" x-text="lote.fecha_vencimiento || 'N/A'"></span>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="itemToDelete && (!itemToDelete.lotes || !Array.isArray(itemToDelete.lotes) || itemToDelete.lotes.length === 0)">
                                <div class="flex flex-col items-center justify-center py-6 px-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 text-center">No hay lotes registrados</p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 text-center px-2">Este producto no tiene lotes asociados</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
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

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

