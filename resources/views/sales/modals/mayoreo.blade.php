<!-- Modal de Selección de Precio Mayoreo -->
<div x-show="isMayoreoModal" 
     x-cloak
     @keydown.window="manejarTecladoMayoreo($event)"
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isMayoreoModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isMayoreoModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         tabindex="-1"
         x-init="$watch('isMayoreoModal', value => { if (value) { $nextTick(() => $el.focus()); } })"
         class="hidden md:block no-scrollbar relative w-full max-w-[500px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4 outline-none">

        <!-- Botón cerrar -->
        <button @click="isMayoreoModal = false; setTimeout(() => { productoMayoreo = null; }, 200);"
            class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>

        <!-- Título -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Precio Mayoreo
            </h3>
        </div>

        <!-- Contenido del Modal -->
        <div x-ref="mayoreoModalContent"
             class="p-4 sm:p-6 lg:p-8"
             @keydown.arrow-down.prevent.stop="if (selectedPriceIndex < 1) { selectedPriceIndex = 1; }"
             @keydown.arrow-up.prevent.stop="if (selectedPriceIndex > 0) { selectedPriceIndex = 0; }"
             @keydown.enter.prevent.stop="seleccionarPrecioConEnter()"
             tabindex="0">
            <!-- Información del Producto -->
            <div x-show="productoMayoreo" class="mb-6">
                <div class="space-y-4">
                    <!-- Nombre del Producto -->
                    <div>
                        <p class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-1 break-words"
                            x-text="productoMayoreo ? productoMayoreo.nombre : ''"></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-mono"
                            x-text="productoMayoreo ? productoMayoreo.codigo : ''"></p>
                    </div>

                    <!-- Selección de Precio -->
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona el tipo de precio:</p>
                        
                        <!-- Precio Normal -->
                        <button 
                            @click="cambiarPrecioMayoreo(productoMayoreo, false)"
                            @mouseenter="selectedPriceIndex = 0"
                            :class="selectedPriceIndex === 0 ? 'ring-2 ring-blue-500 border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600'"
                            class="w-full p-4 rounded-lg border-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all"
                            data-price-index="0">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Precio Normal</span>
                                    <span class="text-xl font-bold text-gray-900 dark:text-white mt-1"
                                        x-text="productoMayoreo ? 'S/ ' + productoMayoreo.precio.toFixed(2) : ''"></span>
                                </div>
                                <div x-show="selectedPriceIndex === 0" class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-500">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>

                        <!-- Precio Mayoreo -->
                        <button 
                            @click="cambiarPrecioMayoreo(productoMayoreo, true)"
                            @mouseenter="selectedPriceIndex = 1"
                            :class="selectedPriceIndex === 1 ? 'ring-2 ring-green-500 border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600'"
                            class="w-full p-4 rounded-lg border-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all"
                            data-price-index="1">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Precio Mayoreo</span>
                                    <span class="text-xl font-bold text-green-600 dark:text-green-400 mt-1"
                                        x-text="productoMayoreo ? 'S/ ' + productoMayoreo.precio_mayoreo.toFixed(2) : ''"></span>
                                </div>
                                <div x-show="selectedPriceIndex === 1" class="flex items-center justify-center w-6 h-6 rounded-full bg-green-500">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet -->
    <div x-show="isMayoreoModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         tabindex="-1"
         x-init="$watch('isMayoreoModal', value => { if (value) { $nextTick(() => $el.focus()); } })"
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col outline-none">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Header Móvil -->
        <div x-show="isMayoreoModal"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Precio Mayoreo
                </h3>
                <button @click="isMayoreoModal = false; setTimeout(() => { productoMayoreo = null; }, 200);"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido con scroll Móvil -->
        <div x-ref="mayoreoModalContentMobile"
             x-show="isMayoreoModal"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @keydown.arrow-down.prevent.stop="if (selectedPriceIndex < 1) { selectedPriceIndex = 1; }"
             @keydown.arrow-up.prevent.stop="if (selectedPriceIndex > 0) { selectedPriceIndex = 0; }"
             @keydown.enter.prevent.stop="seleccionarPrecioConEnter()"
             tabindex="0"
             class="flex-1 overflow-y-auto px-5 py-4">
            <!-- Información del Producto Móvil -->
            <div x-show="productoMayoreo" class="mb-4">
                <div class="space-y-4">
                    <!-- Nombre del Producto -->
                    <div>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mb-1 break-words"
                            x-text="productoMayoreo ? productoMayoreo.nombre : ''"></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-mono"
                            x-text="productoMayoreo ? productoMayoreo.codigo : ''"></p>
                    </div>

                    <!-- Selección de Precio -->
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona el tipo de precio:</p>
                        
                        <!-- Precio Normal -->
                        <button 
                            @click="cambiarPrecioMayoreo(productoMayoreo, false)"
                            @mouseenter="selectedPriceIndex = 0"
                            :class="selectedPriceIndex === 0 ? 'ring-2 ring-blue-500 border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600'"
                            class="w-full p-3 rounded-lg border-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all"
                            data-price-index="0">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col items-start">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Precio Normal</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white mt-1"
                                        x-text="productoMayoreo ? 'S/ ' + productoMayoreo.precio.toFixed(2) : ''"></span>
                                </div>
                                <div x-show="selectedPriceIndex === 0" class="flex items-center justify-center w-5 h-5 rounded-full bg-blue-500">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>

                        <!-- Precio Mayoreo -->
                        <button 
                            @click="cambiarPrecioMayoreo(productoMayoreo, true)"
                            @mouseenter="selectedPriceIndex = 1"
                            :class="selectedPriceIndex === 1 ? 'ring-2 ring-green-500 border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600'"
                            class="w-full p-3 rounded-lg border-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all"
                            data-price-index="1">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col items-start">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Precio Mayoreo</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400 mt-1"
                                        x-text="productoMayoreo ? 'S/ ' + productoMayoreo.precio_mayoreo.toFixed(2) : ''"></span>
                                </div>
                                <div x-show="selectedPriceIndex === 1" class="flex items-center justify-center w-5 h-5 rounded-full bg-green-500">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

