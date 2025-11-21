{{-- Modal Seleccionar Categoría - Solo Móvil --}}
{{-- Permite seleccionar una categoría desde un bottom sheet en dispositivos móviles --}}
<div x-show="showCategoriaDropdown" 
     x-cloak
     class="md:hidden fixed inset-0 z-[9999]">
    
    {{-- Overlay --}}
    <div x-show="showCategoriaDropdown"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="showCategoriaDropdown = false"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    {{-- Modal Móvil - Bottom Sheet estilo Android --}}
    <div x-show="showCategoriaDropdown"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[70vh] flex flex-col">
        
        {{-- Handle Bar --}}
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        {{-- Header Móvil --}}
        <div x-show="showCategoriaDropdown"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Seleccionar Categoría
                </h3>
                <button @click="showCategoriaDropdown = false"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Contenido con scroll Móvil --}}
        <div x-show="showCategoriaDropdown"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <div class="space-y-2">
                <template x-for="categoria in categorias" :key="categoria">
                    <button @click="toggleCategoria(categoria)"
                            class="w-full text-left flex items-center space-x-3 p-3 rounded-lg cursor-pointer transition-colors"
                            :class="producto.categoria === categoria 
                                ? 'bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-500 dark:border-blue-400' 
                                : 'bg-gray-50 dark:bg-gray-800/50 border-2 border-transparent hover:bg-gray-100 dark:hover:bg-gray-700'">
                        <div class="flex-shrink-0">
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                                 :class="producto.categoria === categoria 
                                     ? 'border-blue-500 dark:border-blue-400 bg-blue-500 dark:bg-blue-400' 
                                     : 'border-gray-300 dark:border-gray-600'">
                                <svg x-show="producto.categoria === categoria" 
                                     class="w-3 h-3 text-white" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white flex-1" x-text="categoria"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>

