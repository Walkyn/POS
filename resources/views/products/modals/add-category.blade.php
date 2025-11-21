<!-- Modal Agregar Categoría -->
<div x-show="isAddCategoryModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay - Mismo para móvil y desktop con animación uniforme -->
    <div x-show="isAddCategoryModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>
    
    <!-- Modal Desktop - Centrado -->
    <div x-show="isAddCategoryModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="hidden md:block no-scrollbar relative w-full max-w-[450px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">
        <!-- Botón cerrar Desktop -->
        <button @click="isAddCategoryModal = false; setTimeout(() => { nuevaCategoria = { nombre: '' }; }, 200);"
            class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>

        <!-- Contenido del Modal Desktop -->
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Icono y Título -->
            <div class="mb-4 sm:mb-6 flex items-start gap-3 sm:gap-4">
                <div
                    class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                </div>
                <div class="flex-1 pt-3">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                        Agregar Categoría
                    </h3>
                </div>
            </div>

            <!-- Formulario -->
            <div class="mb-4 sm:mb-6">
                <!-- Campo Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre de la Categoría <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           x-model="nuevaCategoria.nombre"
                           placeholder="Ej: Bebidas, Snacks, Lácteos..."
                           class="w-full px-4 py-2.5 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 dark:placeholder:text-gray-500">
                </div>
            </div>

            <!-- Botón de Confirmar -->
            <div class="flex justify-center mt-4 sm:mt-6">
                <button @click="confirmAddCategory()" 
                    type="button"
                    class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 sm:px-8 sm:py-3 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet estilo Android -->
    <div x-show="isAddCategoryModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col">
        
        <!-- Handle Bar (indicador de arrastre) -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Header Móvil -->
        <div class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Nueva Categoría
                </h3>
                <button @click="isAddCategoryModal = false; setTimeout(() => { nuevaCategoria = { nombre: '' }; }, 200);"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido con scroll Móvil -->
        <div class="flex-1 overflow-y-auto px-5 py-6">
            <!-- Campo Nombre Móvil -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       x-model="nuevaCategoria.nombre"
                       placeholder="Ej: Bebidas, Snacks, Lácteos..."
                       class="w-full px-4 py-2.5 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 dark:placeholder:text-gray-500">
            </div>
        </div>

        <!-- Footer con botón fijo Móvil -->
        <div class="px-5 pt-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <button @click="confirmAddCategory()" 
                type="button"
                class="w-full flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 sm:px-8 sm:py-3 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                Confirmar
            </button>
        </div>
    </div>
</div>

