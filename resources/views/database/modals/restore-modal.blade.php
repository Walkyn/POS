<!-- Modal de Restaurar -->
<div x-show="isRestoreModal" 
     x-cloak
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isRestoreModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"
         @click="if (!isRestoreDbModal) { isRestoreModal = false; }"></div>

    <!-- Modal Desktop - Centrado -->
    <div x-show="isRestoreModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block no-scrollbar relative w-full max-w-[500px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4">

        <!-- Header -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 sm:pb-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Restaurar Copia de Seguridad
            </h3>
            <button @click="isRestoreModal = false"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-4 sm:p-6 lg:p-8" x-data="{ 
            excelFile: null,
            excelFileName: null,
            isImporting: false,
            selectExcelFile() {
                const input = document.getElementById('excel-file-input');
                if (input) {
                    input.click();
                }
            },
            handleExcelFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.excelFile = file;
                    this.excelFileName = file.name;
                }
            },
            importExcel() {
                if (this.excelFile && !this.isImporting) {
                    this.isImporting = true;
                    // Aquí se puede agregar la lógica para importar el archivo Excel
                    console.log('Importando archivo:', this.excelFileName);
                    // TODO: Implementar la lógica de importación
                    // Simular proceso de importación (remover esto cuando se implemente la lógica real)
                    setTimeout(() => {
                        this.isImporting = false;
                        // Aquí se puede agregar lógica de éxito/error
                    }, 3000);
                }
            }
        }">
            <input type="file"
                id="excel-file-input"
                accept=".xlsx,.xls"
                @change="handleExcelFileSelect($event)"
                class="hidden">
            <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                <!-- Sección Base de Datos -->
                <li class="mb-10 ms-8">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                        <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z" />
                        </svg>
                    </span>
                    <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                        Base de Datos
                    </h3>
                    <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">
                        Última restauración: <span id="ultima-restauracion-fecha">Sin restauraciones</span>
                    </time>
                    <button type="button"
                        @click="isRestoreDbModal = true"
                        class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <i class="fas fa-database me-1.5"></i>
                        Seleccionar
                    </button>
                </li>

                <!-- Sección Importar Excel -->
                <li class="mb-4 ms-8">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                        <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z" />
                        </svg>
                    </span>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                        Importar archivo Excel
                    </h3>
                    <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">
                        Última importación: <span id="ultima-importacion-fecha">Sin importaciones</span>
                    </time>
                    <div class="flex items-center bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 dark:focus-within:ring-blue-400 focus-within:border-blue-500 dark:focus-within:border-blue-400 transition-all">
                        <button type="button"
                            @click="excelFile ? importExcel() : selectExcelFile()"
                            :disabled="isImporting"
                            class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors flex items-center gap-2 border-0 rounded-l-lg disabled:opacity-75 disabled:cursor-not-allowed">
                            <template x-if="isImporting">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <template x-if="!isImporting">
                                <i class="fa fa-file-excel w-3 h-3" aria-hidden="true"></i>
                            </template>
                            <span x-text="isImporting ? 'Importando...' : (excelFile ? 'Importar' : 'Seleccionar')"></span>
                        </button>
                        <div class="h-full w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="flex-1 px-3 py-2.5 min-h-[42px] flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" @click="selectExcelFile()">
                            <span x-show="!excelFileName" class="text-sm text-gray-400 dark:text-gray-500">Sin archivo seleccionado</span>
                            <div x-show="excelFileName" x-cloak class="flex items-center gap-2 w-full">
                                <i class="fa fa-file-excel text-green-600 dark:text-green-400 text-sm"></i>
                                <span class="text-sm text-gray-900 dark:text-white font-medium truncate" x-text="excelFileName"></span>
                            </div>
                        </div>
                        <div class="h-full w-px bg-gray-300 dark:bg-gray-600"></div>
                        <button type="button"
                            @click="selectExcelFile()"
                            class="px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center border-0 rounded-r-lg">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </div>
                    <!-- Botón Ver Plantilla Excel -->
                    <div class="mt-4">
                        <button type="button"
                            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            <i class="fas fa-eye"></i>
                            Ver plantilla Excel
                        </button>
                    </div>
                </li>
            </ol>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet estilo Android -->
    <div x-show="isRestoreModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2 py-4">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full cursor-pointer" @click.stop="isRestoreModal = false"></div>
        </div>

        <!-- Header Móvil -->
        <div x-show="isRestoreModal"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Restaurar Copia de Seguridad
                </h3>
            </div>
        </div>

        <!-- Contenido con scroll Móvil -->
        <div x-show="isRestoreModal"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @click.stop
             class="flex-1 overflow-y-auto px-5 py-4"
             x-data="{ 
                excelFile: null,
                excelFileName: null,
                isImporting: false,
                selectExcelFile() {
                    const input = document.getElementById('excel-file-input-mobile');
                    if (input) {
                        input.click();
                    }
                },
                handleExcelFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.excelFile = file;
                        this.excelFileName = file.name;
                    }
                },
                importExcel() {
                    if (this.excelFile && !this.isImporting) {
                        this.isImporting = true;
                        // Aquí se puede agregar la lógica para importar el archivo Excel
                        console.log('Importando archivo:', this.excelFileName);
                        // TODO: Implementar la lógica de importación
                        // Simular proceso de importación (remover esto cuando se implemente la lógica real)
                        setTimeout(() => {
                            this.isImporting = false;
                            // Aquí se puede agregar lógica de éxito/error
                        }, 3000);
                    }
                }
             }">
            <input type="file"
                id="excel-file-input-mobile"
                accept=".xlsx,.xls"
                @change="handleExcelFileSelect($event)"
                class="hidden">
            <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4">
                <!-- Sección Base de Datos -->
                <li class="mb-10 ms-8">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                        <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z" />
                        </svg>
                    </span>
                    <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                        Base de Datos
                    </h3>
                    <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">
                        Última restauración: <span id="ultima-restauracion-fecha-mobile">Sin restauraciones</span>
                    </time>
                    <button type="button"
                        @click="isRestoreDbModal = true"
                        class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <i class="fas fa-database me-1.5"></i>
                        Seleccionar
                    </button>
                </li>

                <!-- Sección Importar Excel -->
                <li class="mb-4 ms-8">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                        <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z" />
                        </svg>
                    </span>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                        Importar archivo Excel
                    </h3>
                    <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">
                        Última importación: <span id="ultima-importacion-fecha-mobile">Sin importaciones</span>
                    </time>
                    <div class="flex items-center bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 dark:focus-within:ring-blue-400 focus-within:border-blue-500 dark:focus-within:border-blue-400 transition-all">
                        <button type="button"
                            @click="excelFile ? importExcel() : selectExcelFile()"
                            :disabled="isImporting"
                            class="px-3 py-2 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors flex items-center gap-1.5 border-0 rounded-l-lg disabled:opacity-75 disabled:cursor-not-allowed flex-shrink-0">
                            <template x-if="isImporting">
                                <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <template x-if="!isImporting">
                                <i class="fa fa-file-excel w-3 h-3" aria-hidden="true"></i>
                            </template>
                            <span class="whitespace-nowrap" x-text="isImporting ? 'Importando...' : (excelFile ? 'Importar' : 'Seleccionar')"></span>
                        </button>
                        <div class="h-full w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="flex-1 px-2 py-2 min-h-[36px] flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors overflow-hidden" @click="selectExcelFile()">
                            <span x-show="!excelFileName" class="text-xs text-gray-400 dark:text-gray-500 truncate">Sin archivo seleccionado</span>
                            <div x-show="excelFileName" x-cloak class="flex items-center gap-1.5 w-full min-w-0">
                                <i class="fa fa-file-excel text-green-600 dark:text-green-400 text-xs flex-shrink-0"></i>
                                <span class="text-xs text-gray-900 dark:text-white font-medium truncate" x-text="excelFileName"></span>
                            </div>
                        </div>
                        <div class="h-full w-px bg-gray-300 dark:bg-gray-600"></div>
                        <button type="button"
                            @click="selectExcelFile()"
                            class="px-2 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center border-0 rounded-r-lg flex-shrink-0">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </div>
                    <!-- Botón Ver Plantilla Excel -->
                    <div class="mt-4">
                        <button type="button"
                            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            <i class="fas fa-eye"></i>
                            Ver plantilla Excel
                        </button>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>

