<main class="h-full pb-16 overflow-y-auto" x-data="{ 
    isDeleteConfirmModal: false, 
    itemToDelete: null,
    showActionsDropdown: false,
    confirmDelete() {
        this.isDeleteConfirmModal = false;
        setTimeout(() => { this.itemToDelete = null; }, 200);
        showSuccessToast();
    },
    getAvatarUrl(name) {
        const gender = this.detectGender(name);
        const seed = name.replace(/\s+/g, '');
        // Usando Lorelei que tiene un estilo más profesional y moderno
        // Alternativa: usar 'personas' para más realismo
        return `https://api.dicebear.com/7.x/lorelei/svg?seed=${seed}&backgroundColor=b6e3f4,c0aede,d1d4f9,ffd5dc,ffdfbf`;
    },
    detectGender(name) {
        const femaleNames = ['maria', 'maría', 'ana', 'laura', 'carmen', 'sofia', 'sofía', 'elena', 'patricia', 'gabriela', 'isabel', 'rosa', 'diana', 'natalia', 'andrea', 'paula', 'monica', 'mónica', 'claudia', 'lucia', 'lucía', 'sara', 'elena', 'beatriz', 'teresa', 'julia', 'irene', 'cristina', 'marta', 'silvia', 'angela', 'ángela', 'veronica', 'verónica', 'raquel', 'noemi', 'noemí', 'eva', 'ines', 'inés', 'pilar', 'mercedes', 'dolores', 'concepcion', 'concepción', 'josefa', 'francisca', 'antonia', 'dolores', 'carmen', 'dolores'];
        const firstName = name.toLowerCase().split(' ')[0];
        // Si termina en 'a' o está en la lista de nombres de mujer, es mujer
        if (firstName.endsWith('a') && !firstName.endsWith('ia') && !firstName.endsWith('ua') || femaleNames.includes(firstName)) {
            return 'female';
        }
        return 'male';
    }
}">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-4 p-4 md:p-4 pt-0 md:pt-4">
                        <div class="w-full md:flex-1 order-2 md:order-1 mt-4 md:mt-0">
                            <form class="flex items-center" id="searchForm">
                                <label for="simple-search" class="sr-only">Buscar usuario</label>
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
                                        placeholder="Buscar por nombre, documento o teléfono...">
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
                        <div class="hidden md:flex md:flex-row gap-3 flex-shrink-0 order-2">
                            <a href="{{ route('users.create') }}"
                                class="flex items-center justify-center py-2.5 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-user-plus mr-2 text-gray-400"></i>
                                Agregar
                            </a>
                            <button type="button"
                                class="flex items-center justify-center py-2.5 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                </svg>
                                Exportar
                            </button>
                            <button type="button"
                                class="flex items-center justify-center py-2.5 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 15h4v6h6v-6h4l-7-7-7 7zM5 2v2h14V2H5z"/>
                                </svg>
                                Importar
                            </button>
                        </div>

                        {{-- Dropdown Móvil --}}
                        <div class="md:hidden w-full order-1 md:order-2 relative" x-data="{ showDropdown: false }">
                            <button @click="showDropdown = !showDropdown"
                                type="button"
                                class="w-full flex items-center justify-between pt-2 pb-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Opciones
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
                                <a href="{{ route('users.create') }}"
                                   @click="showDropdown = false"
                                   class="flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <i class="fas fa-user-plus mr-3 text-blue-600 dark:text-blue-400"></i>
                                    Agregar
                                </a>
                                <button type="button"
                                   @click="showDropdown = false"
                                   class="w-full flex items-center px-4 py-3 text-sm text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                    </svg>
                                    Exportar
                                </button>
                                <button type="button"
                                   @click="showDropdown = false"
                                   class="w-full flex items-center px-4 py-3 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 15h4v6h6v-6h4l-7-7-7 7zM5 2v2h14V2H5z"/>
                                    </svg>
                                    Importar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Usuario</th>
                                    <th scope="col" class="p-4">Email</th>
                                    <th scope="col" class="p-4">Rol</th>
                                    <th scope="col" class="p-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 user-row" 
                                        data-user-id="1">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                                <img :src="getAvatarUrl('Carlos Ramírez')" alt="Carlos Ramírez" class="h-full w-full object-cover" />
                                            </div>
                                            <div class="flex flex-col flex-1 min-w-0">
                                                <div class="mb-1">
                                                    <span class="text-base font-semibold text-black dark:text-white block">
                                                        Carlos Ramírez
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                                        DNI: 12345678
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="block text-sm text-gray-600 dark:text-gray-400">carlos.ramirez@sistema.com</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Administrador
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('users.edit', 1) }}" 
                                               title="Editar"
                                               class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'Carlos Ramírez', email: 'carlos.ramirez@sistema.com', rol: 'Administrador' }; isDeleteConfirmModal = true;"
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
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 user-row" 
                                        data-user-id="2">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                                <img :src="getAvatarUrl('María González')" alt="María González" class="h-full w-full object-cover" />
                                            </div>
                                            <div class="flex flex-col flex-1 min-w-0">
                                                <div class="mb-1">
                                                    <span class="text-base font-semibold text-black dark:text-white block">
                                                        María González
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                                        DNI: 87654321
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="block text-sm text-gray-600 dark:text-gray-400">maria.gonzalez@sistema.com</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Vendedor
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('users.edit', 2) }}" 
                                               title="Editar"
                                               class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'María González', email: 'maria.gonzalez@sistema.com', rol: 'Vendedor' }; isDeleteConfirmModal = true;"
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
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 user-row" 
                                        data-user-id="3">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                            <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                                <img :src="getAvatarUrl('Pedro Sánchez')" alt="Pedro Sánchez" class="h-full w-full object-cover" />
                                            </div>
                                            <div class="flex flex-col flex-1 min-w-0">
                                                <div class="mb-1">
                                                    <span class="text-base font-semibold text-black dark:text-white block">
                                                        Pedro Sánchez
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                                        DNI: 11223344
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="block text-sm text-gray-600 dark:text-gray-400">pedro.sanchez@sistema.com</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Supervisor
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('users.edit', 3) }}" 
                                               title="Editar"
                                               class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                @click.stop="itemToDelete = { name: 'Pedro Sánchez', email: 'pedro.sanchez@sistema.com', rol: 'Supervisor' }; isDeleteConfirmModal = true;"
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

                        <div class="md:hidden space-y-4 px-4 pt-0 pb-4">
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                        <img :src="getAvatarUrl('Carlos Ramírez')" alt="Carlos Ramírez" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            Carlos Ramírez
                                        </h3>
                                        <p class="text-base text-gray-500 dark:text-gray-400 mb-1">
                                            DNI: 12345678
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Email</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">carlos.ramirez@sistema.com</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Rol</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Administrador
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('users.edit', 1) }}" 
                                       title="Editar" 
                                       class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-2 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <button type="button" title="Eliminar" @click="itemToDelete = { name: 'Carlos Ramírez', email: 'carlos.ramirez@sistema.com', rol: 'Administrador' }; isDeleteConfirmModal = true;" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-base px-2 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                        <img :src="getAvatarUrl('María González')" alt="María González" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            María González
                                        </h3>
                                        <p class="text-base text-gray-500 dark:text-gray-400 mb-1">
                                            DNI: 87654321
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Email</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">maria.gonzalez@sistema.com</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Rol</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Vendedor
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('users.edit', 2) }}" 
                                       title="Editar" 
                                       class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-2 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <button type="button" title="Eliminar" @click="itemToDelete = { name: 'María González', email: 'maria.gonzalez@sistema.com', rol: 'Vendedor' }; isDeleteConfirmModal = true;" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-base px-2 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                        <img :src="getAvatarUrl('Pedro Sánchez')" alt="Pedro Sánchez" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            Pedro Sánchez
                                        </h3>
                                        <p class="text-base text-gray-500 dark:text-gray-400 mb-1">
                                            DNI: 11223344
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Email</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">pedro.sanchez@sistema.com</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Rol</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Supervisor
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('users.edit', 3) }}" 
                                       title="Editar" 
                                       class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-2 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <button type="button" title="Eliminar" @click="itemToDelete = { name: 'Pedro Sánchez', email: 'pedro.sanchez@sistema.com', rol: 'Supervisor' }; isDeleteConfirmModal = true;" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-base px-2 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
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
                            <span class="font-semibold text-gray-900 dark:text-white">3</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-white">3</span>
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

        @include('auth.modals.delete-user')

    </div>
</main>

<script>
    function showSuccessToast() {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-50';
        toast.innerHTML = '<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span class="sr-only">Check icon</span></div><div class="ms-3 text-sm font-normal">Usuario eliminado correctamente.</div><button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.remove()"><span class="sr-only">Close</span><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>';
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
