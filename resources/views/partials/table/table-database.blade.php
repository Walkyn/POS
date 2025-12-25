<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    isDeleteConfirmModal: false, 
    itemToDelete: null,
    isBackupModal: false,
    isRestoreModal: false,
    isRestoreDbModal: false,
    confirmDelete() {
        this.isDeleteConfirmModal = false;
        setTimeout(() => { this.itemToDelete = null; }, 200);
        showSuccessToast('Copia de seguridad eliminada correctamente.');
    }
}">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-0 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2 lg:w-2/3 order-2 md:order-1 mt-4 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar copia de seguridad</label>
                                <div class="relative w-full group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400 transition-colors duration-200" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search"
                                        class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                        placeholder="Buscar por nombre de archivo o tipo...">
                                    <button type="button"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hidden clear-search-button transition-colors duration-200"
                                        onclick="clearSearch()">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Botones Desktop --}}
                        <div class="hidden md:flex md:flex-row gap-3 w-auto order-2">
                            <button type="button"
                                @click="isBackupModal = true"
                                class="flex-1 flex items-center justify-center py-2.5 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-database mr-2 text-gray-400"></i>
                                Backup
                            </button>

                            <button type="button"
                                @click="isRestoreModal = true"
                                class="flex-1 flex items-center justify-center py-2.5 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-undo mr-2 text-gray-400"></i>
                                Restaurar
                            </button>
                        </div>

                        {{-- Dropdown Móvil --}}
                        <div class="md:hidden w-full order-1 md:order-2 relative" x-data="{ showDropdown: false }">
                            <button @click="showDropdown = !showDropdown"
                                type="button"
                                class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <i class="fas fa-plus mr-2 text-gray-400"></i>
                                    Crear Backup
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="showDropdown"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="showDropdown = false"
                                 x-cloak
                                 class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <button type="button"
                                   @click="isBackupModal = true; showDropdown = false"
                                   class="w-full flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-left">
                                    <i class="fas fa-database mr-3 text-blue-600 dark:text-blue-400"></i>
                                    Backup
                                </button>
                                <button type="button"
                                   @click="isRestoreModal = true; showDropdown = false"
                                   class="w-full flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors border-t border-gray-200 dark:border-gray-700 text-left">
                                    <i class="fas fa-undo mr-3 text-blue-600 dark:text-blue-400"></i>
                                    Restaurar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Tipo</th>
                                    <th scope="col" class="p-4">Nombre del Archivo</th>
                                    <th scope="col" class="p-4">Fecha de Creación</th>
                                    <th scope="col" class="p-4 whitespace-nowrap">Tamaño</th>
                                    <th scope="col" class="p-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Backup MySQL -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            <i class="fas fa-database"></i>
                                            MySQL
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-file-archive text-gray-400"></i>
                                            <span class="text-sm">backup_pos_2025-01-15_14-30-25.sql</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">15/01/2025 14:30</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">2.45 MB</span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="#" 
                                               @click.stop
                                               title="Descargar"
                                               class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 00-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'backup_pos_2025-01-15_14-30-25.sql', type: 'MySQL' }; isDeleteConfirmModal = true;"
                                                title="Eliminar"
                                                class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Backup Excel -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <i class="fas fa-file-excel"></i>
                                            Excel
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-file-excel text-gray-400"></i>
                                            <span class="text-sm">export_productos_2025-01-15_10-15-42.xlsx</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">15/01/2025 10:15</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">856 KB</span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="#" 
                                               @click.stop
                                               title="Descargar"
                                               class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 00-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'export_productos_2025-01-15_10-15-42.xlsx', type: 'Excel' }; isDeleteConfirmModal = true;"
                                                title="Eliminar"
                                                class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Backup MySQL 2 -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            <i class="fas fa-database"></i>
                                            MySQL
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-file-archive text-gray-400"></i>
                                            <span class="text-sm">backup_pos_2025-01-14_18-45-10.sql</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">14/01/2025 18:45</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">2.38 MB</span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="#" 
                                               @click.stop
                                               title="Descargar"
                                               class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 00-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'backup_pos_2025-01-14_18-45-10.sql', type: 'MySQL' }; isDeleteConfirmModal = true;"
                                                title="Eliminar"
                                                class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Backup Excel 2 -->
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <i class="fas fa-file-excel"></i>
                                            Excel
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-file-excel text-gray-400"></i>
                                            <span class="text-sm">export_clientes_2025-01-13_16-20-33.xlsx</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">13/01/2025 16:20</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">1.12 MB</span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="#" 
                                               @click.stop
                                               title="Descargar"
                                               class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 00-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'export_clientes_2025-01-13_16-20-33.xlsx', type: 'Excel' }; isDeleteConfirmModal = true;"
                                                title="Eliminar"
                                                class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Vista Móvil --}}
                        <div class="md:hidden space-y-4 px-4 pt-0 pb-4">
                            <!-- Backup MySQL -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center gap-2 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                <i class="fas fa-database"></i>
                                                MySQL
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                            backup_pos_2025-01-15_14-30-25.sql
                                        </h3>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">15/01/2025 14:30</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tamaño</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">2.45 MB</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="#" 
                                       @click.stop
                                       title="Descargar" 
                                       class="flex-1 flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                                        <i class="fas fa-download mr-2"></i>
                                        Descargar
                                    </a>
                                    <button type="button" 
                                        title="Eliminar" 
                                        @click="itemToDelete = { name: 'backup_pos_2025-01-15_14-30-25.sql', type: 'MySQL' }; isDeleteConfirmModal = true;" 
                                        class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <i class="fas fa-trash mr-2"></i>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                            <!-- Backup Excel -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center gap-2 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <i class="fas fa-file-excel"></i>
                                                Excel
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                            export_productos_2025-01-15_10-15-42.xlsx
                                        </h3>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">15/01/2025 10:15</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tamaño</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">856 KB</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="#" 
                                       @click.stop
                                       title="Descargar" 
                                       class="flex-1 flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                                        <i class="fas fa-download mr-2"></i>
                                        Descargar
                                    </a>
                                    <button type="button" 
                                        title="Eliminar" 
                                        @click="itemToDelete = { name: 'export_productos_2025-01-15_10-15-42.xlsx', type: 'Excel' }; isDeleteConfirmModal = true;" 
                                        class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <i class="fas fa-trash mr-2"></i>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                            <!-- Backup MySQL 2 -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center gap-2 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                <i class="fas fa-database"></i>
                                                MySQL
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                            backup_pos_2025-01-14_18-45-10.sql
                                        </h3>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">14/01/2025 18:45</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tamaño</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">2.38 MB</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="#" 
                                       @click.stop
                                       title="Descargar" 
                                       class="flex-1 flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                                        <i class="fas fa-download mr-2"></i>
                                        Descargar
                                    </a>
                                    <button type="button" 
                                        title="Eliminar" 
                                        @click="itemToDelete = { name: 'backup_pos_2025-01-14_18-45-10.sql', type: 'MySQL' }; isDeleteConfirmModal = true;" 
                                        class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <i class="fas fa-trash mr-2"></i>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-center md:justify-between items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 text-center md:text-left">
                            Mostrando
                            <span class="font-semibold text-gray-900 dark:text-white">1</span>
                            -
                            <span class="font-semibold text-gray-900 dark:text-white">4</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-white">4</span>
                        </span>

                        <ul class="inline-flex items-stretch -space-x-px justify-center">
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white opacity-50 cursor-not-allowed">
                                    <span class="sr-only">Previous</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white bg-blue-50 text-blue-600 border-blue-300">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white opacity-50 cursor-not-allowed">
                                    <span class="sr-only">Next</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>

        {{-- Modal de Confirmación de Eliminación --}}
        @include('database.modals.delete-backup')

        {{-- Modal de Backup --}}
        @include('database.modals.backup-modal')

        {{-- Modal de Restaurar --}}
        @include('database.modals.restore-modal')

        {{-- Modal de Conexión Base de Datos --}}
        @include('database.modals.restore-db-modal')

    </div>
</main>

<script>
    function showSuccessToast(message = 'Operación realizada correctamente.') {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-50';
        toast.innerHTML = '<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span class="sr-only">Check icon</span></div><div class="ms-3 text-sm font-normal">' + message + '</div><button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.remove()"><span class="sr-only">Close</span><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('simple-search');
        const clearButton = document.querySelector('.clear-search-button');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                if (e.target.value) {
                    if (clearButton) clearButton.classList.remove('hidden');
                } else {
                    if (clearButton) clearButton.classList.add('hidden');
                }
            });
        }
    });

    function clearSearch() {
        const searchInput = document.getElementById('simple-search');
        const clearButton = document.querySelector('.clear-search-button');

        if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
        }

        if (clearButton) clearButton.classList.add('hidden');
    }

    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }
</script>
