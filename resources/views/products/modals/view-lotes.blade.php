<!-- Modal de Visualización de Lotes de Producto -->
<div x-show="isLotesModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isLotesModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isLotesModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="hidden md:block no-scrollbar relative w-full max-w-4xl overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4 max-h-[90vh] flex flex-col">

        <!-- Header -->
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-3 sm:gap-4 flex-1">
                    <div class="flex-1 pt-1">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1" x-text="selectedProduct ? selectedProduct.name : 'Gestión de Lotes'">
                            Gestión de Lotes
                        </h3>
                    </div>
                </div>
                <button @click="isLotesModal = false; setTimeout(() => { selectedProduct = null; }, 200);"
                    class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors flex-shrink-0">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido con scroll -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6">
            <div class="lotes-container">
                <div class="md:px-0 md:pt-0">
                    <!-- Tabla Desktop -->
                    <div class="hidden md:block overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm bg-white dark:bg-gray-800">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-5 py-4 font-semibold">Nº Lote</th>
                                        <th scope="col" class="px-5 py-4 font-semibold">P. Costo</th>
                                        <th scope="col" class="px-5 py-4 font-semibold">P. Venta</th>
                                        <th scope="col" class="px-5 py-4 font-semibold">P. Mayoreo</th>
                                        <th scope="col" class="px-5 py-4 font-semibold">Stock</th>
                                        <th scope="col" class="px-5 py-4 font-semibold">Fecha Vencimiento</th>
                                        <th scope="col" class="px-5 py-4 font-semibold text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="lotes-tbody-modal" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-if="selectedProduct && selectedProduct.lotes && selectedProduct.lotes.length > 0">
                                        <template x-for="(lote, index) in selectedProduct.lotes" :key="index">
                                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                                <td class="px-5 py-4 font-medium text-gray-900 dark:text-white">
                                                    <span class="inline-flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                        <span x-text="lote.numero_lote || 'LOTE-' + String(index + 1).padStart(4, '0')"></span>
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 text-gray-700 dark:text-gray-300 font-medium" x-text="'$' + parseFloat(lote.precio_costo || 0).toFixed(2)"></td>
                                                <td class="px-5 py-4 text-gray-700 dark:text-gray-300 font-medium" x-text="'$' + parseFloat(lote.precio_venta || 0).toFixed(2)"></td>
                                                <td class="px-5 py-4 text-gray-700 dark:text-gray-300 font-medium" x-text="'$' + parseFloat(lote.precio_mayoreo || 0).toFixed(2)"></td>
                                                <td class="px-5 py-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" x-text="lote.cantidad || 0"></span>
                                                </td>
                                                <td class="px-5 py-4 text-gray-600 dark:text-gray-400" x-text="lote.fecha_vencimiento || 'N/A'"></td>
                                                <td class="px-5 py-4 text-center">
                                                    <button type="button" 
                                                            title="Eliminar Lote"
                                                            @click="eliminarLote(lote)"
                                                            class="inline-flex items-center justify-center text-red-600 hover:text-white border border-red-300 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-200 font-medium rounded-lg text-sm p-2 transition-all duration-150 dark:border-red-700 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                    <template x-if="!selectedProduct || !selectedProduct.lotes || selectedProduct.lotes.length === 0">
                                        <tr>
                                            <td colspan="7" class="px-5 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center py-8 px-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                    </svg>
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 text-center">No hay lotes registrados</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 text-center px-2">Este producto no tiene lotes asociados</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Vista Móvil -->
                    <div class="md:hidden space-y-3">
                        <template x-if="selectedProduct && selectedProduct.lotes && selectedProduct.lotes.length > 0">
                            <template x-for="(lote, index) in selectedProduct.lotes" :key="index">
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="mb-3">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2" x-text="lote.numero_lote || 'LOTE-' + String(index + 1).padStart(4, '0')"></h4>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 mb-3">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Costo</p>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_costo || 0).toFixed(2)"></span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Venta</p>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_venta || 0).toFixed(2)"></span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Mayoreo</p>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_mayoreo || 0).toFixed(2)"></span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.cantidad || 0"></span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.fecha_vencimiento || 'N/A'"></span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" 
                                                title="Eliminar Lote"
                                                @click="eliminarLote(lote)"
                                                class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <template x-if="!selectedProduct || !selectedProduct.lotes || selectedProduct.lotes.length === 0">
                            <div class="flex flex-col items-center justify-center py-6 px-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 text-center">No hay lotes registrados</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 text-center px-2">Este producto no tiene lotes asociados</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet -->
    <div x-show="isLotesModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Header Móvil -->
        <div x-show="isLotesModal"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white" x-text="selectedProduct ? selectedProduct.name : 'Gestión de Lotes'">Gestión de Lotes</h3>
                </div>
                <button @click="isLotesModal = false; setTimeout(() => { selectedProduct = null; }, 200);"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors ml-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido con scroll Móvil -->
        <div x-show="isLotesModal"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <div class="space-y-3">
                <template x-if="selectedProduct && selectedProduct.lotes && selectedProduct.lotes.length > 0">
                    <template x-for="(lote, index) in selectedProduct.lotes" :key="index">
                        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-all duration-300"
                             :style="`animation: fadeInUp 0.4s ease-out ${(index * 0.05) + 0.4}s both;`">
                            <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span x-text="lote.numero_lote || 'LOTE-' + String(index + 1).padStart(4, '0')"></span>
                                </h4>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Costo</p>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_costo || 0).toFixed(2)"></span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Venta</p>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_venta || 0).toFixed(2)"></span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Mayoreo</p>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_mayoreo || 0).toFixed(2)"></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" x-text="lote.cantidad || 0"></span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.fecha_vencimiento || 'N/A'"></span>
                                </div>
                            </div>
                            <div class="flex gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" 
                                        title="Eliminar Lote"
                                        @click="eliminarLote(lote)"
                                        class="flex-1 flex items-center justify-center gap-2 text-red-600 hover:text-white border border-red-300 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-200 font-medium rounded-lg text-sm p-2 transition-all duration-150 dark:border-red-700 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </template>
                <template x-if="!selectedProduct || !selectedProduct.lotes || selectedProduct.lotes.length === 0">
                    <div class="flex flex-col items-center justify-center py-8 px-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 text-center">No hay lotes registrados</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 text-center px-2">Este producto no tiene lotes asociados</p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación de Lote -->
    <div x-show="isDeleteLoteModal" 
         x-cloak
         class="fixed inset-0 z-[10000] md:flex md:items-center md:justify-center">
        
        <!-- Overlay -->
        <div x-show="isDeleteLoteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

        <!-- Modal Desktop -->
        <div x-show="isDeleteLoteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="hidden md:block no-scrollbar relative w-full max-w-[450px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">
            <button @click="isDeleteLoteModal = false; setTimeout(() => { loteToDelete = null; }, 200);"
                class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-4 sm:p-6 lg:p-8">
                <div class="mb-4 sm:mb-6 flex items-start gap-3 sm:gap-4">
                    <div
                        class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 pt-3">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                            Confirmar Eliminación de Lote
                        </h3>
                    </div>
                </div>

                <div x-show="loteToDelete" class="mb-4 sm:mb-4">
                    <div class="space-y-3 sm:space-y-3">
                        <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 sm:p-3">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0 space-y-1.5">
                                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                        <span class="text-sm sm:text-base font-bold text-gray-900 dark:text-white font-mono break-all"
                                            x-text="loteToDelete ? (loteToDelete.numero_lote || 'Lote sin número') : ''"></span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                                        <div class="flex items-center gap-1 sm:gap-1.5">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Cantidad:</span>
                                            <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" 
                                                x-text="loteToDelete ? (loteToDelete.cantidad || '0') : '0'"></span>
                                        </div>
                                        <div class="flex items-center gap-1 sm:gap-1.5">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Vence:</span>
                                            <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white break-words" 
                                                x-text="loteToDelete ? (loteToDelete.fecha_vencimiento || 'N/A') : 'N/A'"></span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1.5 sm:gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <template x-if="loteToDelete && loteToDelete.precio_costo !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Costo</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_costo || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                        <template x-if="loteToDelete && loteToDelete.precio_venta !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Venta</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_venta || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                        <template x-if="loteToDelete && loteToDelete.precio_mayoreo !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Mayoreo</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_mayoreo || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4 sm:mt-6">
                    <button @click="confirmDeleteLote()" type="button"
                        class="w-full rounded-xl bg-red-600 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                        Confirmar Eliminación
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Móvil - Bottom Sheet estilo Android -->
        <div x-show="isDeleteLoteModal"
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
            <div x-show="isDeleteLoteModal"
                 x-transition:enter="transition ease-out duration-300 delay-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Confirmar Eliminación de Lote
                    </h3>
                    <button @click="isDeleteLoteModal = false; setTimeout(() => { loteToDelete = null; }, 200);"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido con scroll Móvil -->
            <div x-show="isDeleteLoteModal"
                 x-transition:enter="transition ease-out duration-400 delay-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="flex-1 overflow-y-auto px-5 py-4">
                <div x-show="loteToDelete" class="mb-4">
                    <div class="space-y-3">
                        <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0 space-y-1.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white font-mono break-all"
                                            x-text="loteToDelete ? (loteToDelete.numero_lote || 'Lote sin número') : ''"></span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Cantidad:</span>
                                            <span class="text-xs font-semibold text-gray-900 dark:text-white" 
                                                x-text="loteToDelete ? (loteToDelete.cantidad || '0') : '0'"></span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Vence:</span>
                                            <span class="text-xs font-semibold text-gray-900 dark:text-white break-words" 
                                                x-text="loteToDelete ? (loteToDelete.fecha_vencimiento || 'N/A') : 'N/A'"></span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <template x-if="loteToDelete && loteToDelete.precio_costo !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Costo</span>
                                                <span class="text-xs font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_costo || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                        <template x-if="loteToDelete && loteToDelete.precio_venta !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Venta</span>
                                                <span class="text-xs font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_venta || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                        <template x-if="loteToDelete && loteToDelete.precio_mayoreo !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Mayoreo</span>
                                                <span class="text-xs font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_mayoreo || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con botón fijo Móvil -->
            <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 flex-shrink-0">
                <button @click="confirmDeleteLote()" 
                    type="button"
                    class="w-full flex items-center justify-center rounded-lg bg-red-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 transition-colors">
                    Confirmar Eliminación
                </button>
            </div>
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

