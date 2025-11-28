<!-- Modal de Carga - Exportación a Excel -->
<div x-show="isExportingExcel" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isExportingExcel"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isExportingExcel"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block no-scrollbar relative w-full max-w-[400px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">

        <!-- Contenido del Modal -->
        <div class="p-6 sm:p-8">
            <!-- Icono -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30">
                    <i class="fas fa-file-excel text-2xl text-green-600 dark:text-green-400"></i>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="text-center mb-6">
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-4">
                    Por favor, espere mientras se genera el archivo...
                </p>
                
                <!-- Barra de Progreso -->
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                    <div class="bg-green-600 h-2.5 rounded-full transition-all duration-300 ease-out dark:bg-green-500"
                         :style="'width: ' + (exportProgress || 0) + '%'">
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" x-text="(exportProgress || 0) + '%'"></p>
            </div>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet -->
    <div x-show="isExportingExcel"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[50vh] flex flex-col">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Contenido Móvil -->
        <div x-show="isExportingExcel"
             x-transition:enter="transition ease-out duration-400 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <!-- Icono -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30">
                    <i class="fas fa-file-excel text-2xl text-green-600 dark:text-green-400"></i>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="text-center mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Por favor, espere mientras se genera el archivo...
                </p>
                
                <!-- Barra de Progreso -->
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                    <div class="bg-green-600 h-2.5 rounded-full transition-all duration-300 ease-out dark:bg-green-500"
                         :style="'width: ' + (exportProgress || 0) + '%'">
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" x-text="(exportProgress || 0) + '%'"></p>
            </div>
        </div>
    </div>
</div>

