@extends('layouts.app')
@section('title', 'Configuración')

@section('content')
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Configuración
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li class="font-medium text-primary">Configuración</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Settings Section Start ====== -->
            <div x-data="{ activeTab: 'cajeros' }">
                <!-- Contenido Principal -->
                <div>
                    <!-- Administración de Cajeros -->
                    <div x-show="activeTab === 'cajeros'" 
                         x-data="{ 
                            isDeleteConfirmModal: false, 
                            itemToDelete: null,
                            getAvatarUrl(name) {
                                const seed = name.replace(/\s+/g, '');
                                return `https://api.dicebear.com/7.x/lorelei/svg?seed=${seed}&backgroundColor=b6e3f4,c0aede,d1d4f9,ffd5dc,ffdfbf`;
                            }
                         }"
                         class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                        <div class="border-b border-gray-200 dark:border-gray-700 px-4 md:px-4 py-3 md:py-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h3 class="text-base md:text-xl font-semibold text-black dark:text-white">
                                        Administración de Cajeros
                      </h3>
                                </div>
                                <!-- Navegación Desktop -->
                                <nav class="hidden md:flex flex-wrap gap-2 overflow-x-auto scrollbar-hide p-1" role="tablist">
                                    <button
                                        @click="activeTab = 'cajeros'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 whitespace-nowrap">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        <span>Cajeros</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'tickets'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-receipt mr-2"></i>
                                        <span>Tickets</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'logo'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-image mr-2"></i>
                                        <span>Logo</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'sistema'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span>Sistema</span>
                                    </button>
                                </nav>
                                <!-- Dropdown Móvil -->
                                <div class="md:hidden w-full relative" x-data="{ showNavDropdown: false }">
                                    <button @click="showNavDropdown = !showNavDropdown"
                                        type="button"
                                        class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <span class="flex items-center">
                                            <i class="fas fa-user-tie mr-2 text-gray-400"></i>
                                            Administración de Cajeros
                                        </span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showNavDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="showNavDropdown"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showNavDropdown = false"
                                         x-cloak
                                         class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        <button type="button"
                                            @click="activeTab = 'cajeros'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                                            <i class="fas fa-user-tie mr-3"></i>
                                            Administración de Cajeros
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'tickets'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-receipt mr-3"></i>
                                            Personalización de Tickets
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'logo'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-image mr-3"></i>
                                            Logo de la Empresa
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'sistema'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-info-circle mr-3"></i>
                                            Información de Sistema
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 md:gap-4 p-4">
                            <div class="w-full md:flex-1">
                                <form class="flex items-center" id="searchForm">
                                    <label for="simple-search" class="sr-only">Buscar cajero</label>
                                    <div class="relative w-full group">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                    </div>
                                        <input type="text" id="simple-search"
                                            class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                            placeholder="Buscar por nombre o rol...">
                                        <button type="button"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hidden clear-search-button"
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

                            <button type="button"
                                class="flex items-center justify-center py-2.5 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 w-full md:w-auto">
                                <i class="fas fa-user-plus mr-2 text-gray-400"></i>
                                Agregar
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">Cajero</th>
                                        <th scope="col" class="p-4">Rol</th>
                                        <th scope="col" class="p-4">Estado</th>
                                        <th scope="col" class="p-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                                <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                                    <img :src="getAvatarUrl('Juan Pérez')" alt="Juan Pérez" class="h-full w-full object-cover" />
                                                </div>
                                                <div class="flex flex-col flex-1 min-w-0">
                                                    <div class="mb-1">
                                                        <span class="text-base font-semibold text-black dark:text-white block">
                                                            Juan Pérez
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                                            juan.perez@example.com
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="block text-sm text-gray-600 dark:text-gray-400">Cajero Principal</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full flex items-center text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100">
                                                <i class="fas fa-check-circle mr-1.5"></i>
                                                Activo
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center space-x-2">
                                                <a href="#" 
                                                   title="Editar"
                                                   class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </a>
                                                <button type="button" 
                                                    @click.stop="itemToDelete = { name: 'Juan Pérez', role: 'Cajero Principal', email: 'juan.perez@example.com' }; isDeleteConfirmModal = true;"
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
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                                <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                                    <img :src="getAvatarUrl('María García')" alt="María García" class="h-full w-full object-cover" />
                                                </div>
                                                <div class="flex flex-col flex-1 min-w-0">
                                                    <div class="mb-1">
                                                        <span class="text-base font-semibold text-black dark:text-white block">
                                                            María García
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                                            maria.garcia@example.com
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="block text-sm text-gray-600 dark:text-gray-400">Cajero</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full flex items-center text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100">
                                                <i class="fas fa-check-circle mr-1.5"></i>
                                                Activo
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center space-x-2">
                                                <a href="#" 
                                                   title="Editar"
                                                   class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </a>
                                                <button type="button" 
                                                    @click.stop="itemToDelete = { name: 'María García', role: 'Cajero', email: 'maria.garcia@example.com' }; isDeleteConfirmModal = true;"
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
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                                <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                                    <img :src="getAvatarUrl('Carlos López')" alt="Carlos López" class="h-full w-full object-cover" />
                                                </div>
                                                <div class="flex flex-col flex-1 min-w-0">
                                                    <div class="mb-1">
                                                        <span class="text-base font-semibold text-black dark:text-white block">
                                                            Carlos López
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                                            carlos.lopez@example.com
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="block text-sm text-gray-600 dark:text-gray-400">Cajero</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full flex items-center text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100">
                                                <i class="fas fa-times-circle mr-1.5"></i>
                                                Inactivo
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center space-x-2">
                                                <a href="#" 
                                                   title="Editar"
                                                   class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </a>
                                                <button type="button" 
                                                    @click.stop="itemToDelete = { name: 'Carlos López', role: 'Cajero', email: 'carlos.lopez@example.com' }; isDeleteConfirmModal = true;"
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

                            <div class="md:hidden space-y-3 px-4 pb-4">
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                                    <div class="p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="h-12 w-12 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                                <img :src="getAvatarUrl('Juan Pérez')" alt="Juan Pérez" class="h-full w-full object-cover" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    Juan Pérez
                                                </h3>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    juan.perez@example.com
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mb-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rol</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Cajero Principal</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Estado</p>
                                                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full flex items-center text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100">
                                                    <i class="fas fa-check-circle mr-1.5"></i>
                                                    Activo
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <a href="#" 
                                               title="Editar" 
                                               class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                title="Eliminar" 
                                                @click="itemToDelete = { name: 'Juan Pérez', role: 'Cajero Principal', email: 'juan.perez@example.com' }; isDeleteConfirmModal = true;"
                                                class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                                    <div class="p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="h-12 w-12 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                                <img :src="getAvatarUrl('María García')" alt="María García" class="h-full w-full object-cover" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    María García
                                                </h3>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    maria.garcia@example.com
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mb-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rol</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Cajero</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Estado</p>
                                                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full flex items-center text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100">
                                                    <i class="fas fa-check-circle mr-1.5"></i>
                                                    Activo
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <a href="#" 
                                               title="Editar" 
                                               class="flex transition-all items-center justify-center px-2 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-1 focus:ring-blue-300 focus:ring-offset-1 dark:text-blue-200 dark:bg-blue-900 dark:border-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-600">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                title="Eliminar" 
                                                @click="itemToDelete = { name: 'María García', role: 'Cajero', email: 'maria.garcia@example.com' }; isDeleteConfirmModal = true;"
                                                class="flex transition-all items-center justify-center px-2 py-1.5 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 focus:outline-none focus:ring-1 focus:ring-red-300 focus:ring-offset-1 dark:text-red-200 dark:bg-red-900 dark:border-red-700 dark:hover:bg-red-800 dark:focus:ring-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                                    <div class="p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="h-12 w-12 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                                <img :src="getAvatarUrl('Carlos López')" alt="Carlos López" class="h-full w-full object-cover" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    Carlos López
                                                </h3>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    carlos.lopez@example.com
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mb-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rol</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Cajero</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Estado</p>
                                                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full flex items-center text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100">
                                                    <i class="fas fa-times-circle mr-1.5"></i>
                                                    Inactivo
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <a href="#" 
                                               title="Editar" 
                                               class="flex transition-all items-center justify-center px-2 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-1 focus:ring-blue-300 focus:ring-offset-1 dark:text-blue-200 dark:bg-blue-900 dark:border-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-600">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                title="Eliminar" 
                                                @click="itemToDelete = { name: 'Carlos López', role: 'Cajero', email: 'carlos.lopez@example.com' }; isDeleteConfirmModal = true;"
                                                class="flex transition-all items-center justify-center px-2 py-1.5 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 focus:outline-none focus:ring-1 focus:ring-red-300 focus:ring-offset-1 dark:text-red-200 dark:bg-red-900 dark:border-red-700 dark:hover:bg-red-800 dark:focus:ring-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                          </div>
                          </div>
                        </div>

                    <!-- Personalización de Tickets -->
                    <div x-show="activeTab === 'tickets'" 
                         class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                        <div class="border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 py-3 md:py-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h3 class="text-base md:text-xl font-semibold text-black dark:text-white">
                                        Personalización de Tickets
                                    </h3>
                                </div>
                                <!-- Navegación Desktop -->
                                <nav class="hidden md:flex flex-wrap gap-2 overflow-x-auto scrollbar-hide p-1" role="tablist">
                                    <button
                                        @click="activeTab = 'cajeros'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        <span>Cajeros</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'tickets'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 whitespace-nowrap">
                                        <i class="fas fa-receipt mr-2"></i>
                                        <span>Tickets</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'logo'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-image mr-2"></i>
                                        <span>Logo</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'sistema'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span>Sistema</span>
                                    </button>
                                </nav>
                                <!-- Dropdown Móvil -->
                                <div class="md:hidden w-full relative" x-data="{ showNavDropdown: false }">
                                    <button @click="showNavDropdown = !showNavDropdown"
                                        type="button"
                                        class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <span class="flex items-center">
                                            <i class="fas fa-receipt mr-2 text-gray-400"></i>
                                            Personalización de Tickets
                                        </span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showNavDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="showNavDropdown"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showNavDropdown = false"
                                         x-cloak
                                         class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        <button type="button"
                                            @click="activeTab = 'cajeros'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-user-tie mr-3"></i>
                                            Administración de Cajeros
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'tickets'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                                            <i class="fas fa-receipt mr-3"></i>
                                            Personalización de Tickets
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'logo'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-image mr-3"></i>
                                            Logo de la Empresa
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'sistema'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-info-circle mr-3"></i>
                                            Información de Sistema
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 md:p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Formulario -->
                                <div>
                                    <form class="space-y-4 md:space-y-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                Nombre de la empresa
                                            </label>
                                            <input
                                                type="text"
                                                value="Business Manager"
                                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                Eslogan de la empresa
                                            </label>
                                            <input
                                                type="text"
                                                value="Optimiza Controla Prospera"
                                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                Ruc
                                            </label>
                          <input
                            type="text"
                                                value="2000000001"
                                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                            <div>
                                                <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                    Dirección
                                                </label>
                                                <input
                                                    type="text"
                                                    value="Lima-Peru"
                                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                    Telefono
                                                </label>
                                                <input
                                                    type="text"
                                                    value="900 000 000"
                                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                Agradecimiento
                                            </label>
                                            <div class="flex gap-2">
                                                <input
                                                    type="text"
                                                    value="¡Gracias por su preferencia!"
                                                    class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                                                <button type="button"
                                                    class="flex items-center justify-center w-12 h-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                                                    <i class="fas fa-user text-gray-600 dark:text-gray-400"></i>
                                                </button>
                                            </div>
                          </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-black dark:text-white mb-2">
                                                Sitio web
                                            </label>
                                            <input
                                                type="text"
                                                value=""
                                                placeholder="Ingrese la URL del sitio web"
                                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 md:px-4 py-2.5 md:py-3 text-sm font-medium text-black dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-700 focus-visible:outline-none">
                        </div>

                                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <button type="button" class="flex items-center justify-center py-2.5 px-4 md:px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 w-full sm:w-auto">
                                                Cancelar
                          </button>
                                            <button type="submit" class="flex items-center justify-center py-2.5 px-4 md:px-6 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900 w-full sm:w-auto">
                                                Guardar Cambios
                          </button>
                        </div>
                      </form>
                    </div>

                                <!-- Vista Previa del Ticket -->
                                <div class="lg:sticky lg:top-6 lg:h-fit">
                                    <div class="bg-white dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-700 rounded-lg p-4 md:p-6 shadow-lg">
                                        <h4 class="text-base md:text-lg font-semibold text-black dark:text-white mb-4 text-center">
                                            Vista Previa del Ticket
                                        </h4>
                                        <div class="bg-white text-black mx-auto overflow-x-auto border-2 border-dashed border-gray-400 rounded-lg p-3 md:p-4" style="width: 80mm; max-width: 100%; font-family: 'Roboto', sans-serif; font-size: 11px; line-height: 1.4;">
                                            <style>
                                                .ticket-preview {
                                                    padding: 5mm;
                                                }
                                                .ticket-preview .header {
                                                    text-align: center;
                                                    margin-bottom: 10px;
                                                }
                                                .ticket-preview .header h2 {
                                                    margin: 0;
                                                    font-size: 12px;
                                                }
                                                .ticket-preview .divider {
                                                    border-top: 1px dashed #000;
                                                    margin: 5px 0;
                                                }
                                                .ticket-preview .info-section {
                                                    margin-bottom: 10px;
                                                }
                                                .ticket-preview .info-section p {
                                                    margin: 2px 0;
                                                }
                                                .ticket-preview .info-section strong {
                                                    display: inline-block;
                                                    min-width: 25mm;
                                                    font-weight: bold;
                                                }
                                                .ticket-preview .items-table {
                                                    width: 100%;
                                                    border-collapse: separate;
                                                    border-spacing: 0;
                                                    margin-bottom: 0px;
                                                    border-radius: 4px;
                                                    overflow: hidden;
                                                }
                                                .ticket-preview .items-table th,
                                                .ticket-preview .items-table td {
                                                    padding: 4px 2px;
                                                    text-align: left;
                                                    word-break: break-word;
                                                    font-size: 11px;
                                                }
                                                .ticket-preview .items-table th {
                                                    font-weight: 600;
                                                    font-size: 10px;
                                                    background-color: #111827;
                                                    color: #fff;
                                                    text-transform: uppercase;
                                                    letter-spacing: 0.05em;
                                                    padding: 6px 2px;
                                                }
                                                .ticket-preview .items-table td {
                                                    background-color: #fff;
                                                }
                                                .ticket-preview .items-table th:nth-child(1),
                                                .ticket-preview .items-table td:nth-child(1) {
                                                    width: 5%;
                                                    padding-left: 4px;
                                                }
                                                .ticket-preview .items-table th:nth-child(2),
                                                .ticket-preview .items-table td:nth-child(2) {
                                                    width: 50%;
                                                    padding-left: 4px;
                                                }
                                                .ticket-preview .items-table th:nth-child(3),
                                                .ticket-preview .items-table td:nth-child(3) {
                                                    width: 20%;
                                                    text-align: center;
                                                }
                                                .ticket-preview .items-table th:nth-child(4),
                                                .ticket-preview .items-table td:nth-child(4) {
                                                    width: 25%;
                                                    text-align: right;
                                                    padding-right: 4px;
                                                }
                                                .ticket-preview .totals {
                                                    text-align: right;
                                                    margin-top: 0px;
                                                }
                                                .ticket-preview .totals p {
                                                    margin: 2px 0;
                                                }
                                                .ticket-preview .totals strong {
                                                    display: inline-block;
                                                    min-width: 20mm;
                                                    font-weight: bold;
                                                }
                                                .ticket-preview .footer {
                                                    text-align: center;
                                                    margin-top: 15px;
                                                    font-size: 10px;
                                                }
                                                .ticket-preview .glosa {
                                                    margin-top: 10px;
                                                    font-size: 10px;
                                                }
                                                .ticket-preview .glosa p {
                                                    margin: 0;
                                                }
                                                .ticket-preview .qr-code {
                                                    text-align: center;
                                                    margin-top: 15px;
                                                    margin-bottom: 15px;
                                                }
                                                .ticket-preview .qr-code img {
                                                    display: block;
                                                    margin: 0 auto;
                                                    max-width: 40mm;
                                                    height: auto;
                                                }
                                            </style>
                                            <div class="ticket-preview">
                                                <div class="header">
                                                    <h2>Business Manager</h2>
                                                    <div class="divider"></div>
                                                    <p style="font-size: 11px; font-weight: bold;">TICKET DE VENTA</p>
                                                    <div class="divider"></div>
                                                </div>

                                                <div class="info-section">
                                                    <p><strong>N° Boleta:</strong> B2025-00023</p>
                                                    <p><strong>Fecha:</strong> 29/11/2025 16:29</p>
                                                    <p><strong>Tipo de Pago:</strong> Efectivo</p>
                                                    <p><strong>Estado:</strong> Emitido</p>
                                                </div>

                                                <div class="divider"></div>

                                                <div class="info-section">
                                                    <p><strong>Cliente:</strong> Sergio Cisneros</p>
                                                    <p><strong>DNI:</strong> 12345678</p>
                                                    <p><strong>Teléfono:</strong> +51929560341</p>
                                                    <p><strong>Dirección:</strong> S/N</p>
                                                </div>

                                                <p style="text-align:center; margin-bottom: 5px; font-weight: bold;">PRODUCTOS</p>

                                                <table class="items-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th style="text-align: center;">Cant</th>
                                                            <th style="text-align: right;">Precio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Paracetamol 500mg</td>
                                                            <td style="text-align: center;">2</td>
                                                            <td style="text-align: right;">S/. 15.50</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Ibuprofeno 400mg</td>
                                                            <td style="text-align: center;">1</td>
                                                            <td style="text-align: right;">S/. 12.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div style="border-top: 1.5px solid #000;"></div>

                                                <div class="totals">
                                                    <p style="font-size: 12px; padding-right: 4px; font-weight: bold;">Total: S/. 27.50</p>
                                                </div>

                                                <div class="glosa">
                                                    <p style="font-weight: bold;">Glosa:</p>
                                                    <p>Sin notas adicionales.</p>
                                                </div>

                                                <div class="qr-code">
                                                    <div style="width: 40mm; height: 40mm; margin: 0 auto; background-color: #f3f4f6; border: 1px solid #d1d5db; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-qrcode" style="font-size: 30px; color: #6b7280;"></i>
                                                    </div>
                                                </div>

                                                <div class="footer">
                                                    <p>Lima-Peru</p>
                                                    <p>Tel: 900 000 000 | RUC: 2000000001</p>
                                                    <p>Documento generado el {{ date('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                  </div>
                </div>
                    </div>

                    <!-- Logo -->
                    <div x-show="activeTab === 'logo'" 
                         class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                        <div class="border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 py-3 md:py-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h3 class="text-base md:text-xl font-semibold text-black dark:text-white">
                                        Logo de la Empresa
                                    </h3>
                          </div>
                                <!-- Navegación Desktop -->
                                <nav class="hidden md:flex flex-wrap gap-2 overflow-x-auto scrollbar-hide p-1" role="tablist">
                                    <button
                                        @click="activeTab = 'cajeros'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        <span>Cajeros</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'tickets'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-receipt mr-2"></i>
                                        <span>Tickets</span>
                                    </button>
                              <button
                                        @click="activeTab = 'logo'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 whitespace-nowrap">
                                        <i class="fas fa-image mr-2"></i>
                                        <span>Logo</span>
                              </button>
                              <button
                                        @click="activeTab = 'sistema'"
                                        type="button"
                                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span>Sistema</span>
                              </button>
                                </nav>
                                <!-- Dropdown Móvil -->
                                <div class="md:hidden w-full relative" x-data="{ showNavDropdown: false }">
                                    <button @click="showNavDropdown = !showNavDropdown"
                                        type="button"
                                        class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <span class="flex items-center">
                                            <i class="fas fa-image mr-2 text-gray-400"></i>
                                            Logo de la Empresa
                            </span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showNavDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="showNavDropdown"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showNavDropdown = false"
                                         x-cloak
                                         class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        <button type="button"
                                            @click="activeTab = 'cajeros'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-user-tie mr-3"></i>
                                            Administración de Cajeros
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'tickets'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-receipt mr-3"></i>
                                            Personalización de Tickets
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'logo'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                                            <i class="fas fa-image mr-3"></i>
                                            Logo de la Empresa
                                        </button>
                                        <button type="button"
                                            @click="activeTab = 'sistema'; showNavDropdown = false"
                                            class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-info-circle mr-3"></i>
                                            Información de Sistema
                                        </button>
                                    </div>
                                </div>
                          </div>
                        </div>
                        <div class="p-4 md:p-6">
                            <div class="space-y-4 md:space-y-6">
                                <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">
                                    <div class="h-32 w-32 md:h-40 md:w-40 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center bg-gray-50 dark:bg-gray-800/50 flex-shrink-0 mx-auto md:mx-0">
                                        <div class="text-center">
                                            <i class="fas fa-image text-3xl md:text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Sin logo</p>
                                        </div>
                                    </div>
                                    <div class="flex-1 w-full">
                                        <label class="block text-sm font-semibold text-black dark:text-white mb-3">
                                            Subir Logo
                                        </label>
                                        <div class="relative">
                          <input
                            type="file"
                            accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div class="flex items-center justify-center px-4 md:px-6 py-3 md:py-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10">
                                                <div class="text-center">
                                                    <i class="fas fa-cloud-upload-alt text-xl md:text-2xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Haz clic para seleccionar o arrastra aquí</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        Formatos: PNG, JPG, SVG • Tamaño máximo: 2MB
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 md:px-6 text-sm font-medium text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 w-full sm:w-auto">
                                        <i class="fas fa-trash text-sm"></i>
                                        Eliminar Logo
                                    </button>
                                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 md:px-6 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900 w-full sm:w-auto">
                                        <i class="fas fa-save text-sm"></i>
                                        Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Sistema -->
                    <div x-show="activeTab === 'sistema'" 
                         class="space-y-4 md:space-y-6">
                        <!-- Header con navegación -->
                        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                            <div class="border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 py-3 md:py-4">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <h3 class="text-base md:text-xl font-semibold text-black dark:text-white">
                                            Información de Sistema
                                        </h3>
                                    </div>
                                    <!-- Navegación Desktop -->
                                    <nav class="hidden md:flex flex-wrap gap-2 overflow-x-auto scrollbar-hide p-1" role="tablist">
                                        <button
                                            @click="activeTab = 'cajeros'"
                                            type="button"
                                            class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                            <i class="fas fa-user-tie mr-2"></i>
                                            <span>Cajeros</span>
                                        </button>
                                        <button
                                            @click="activeTab = 'tickets'"
                                            type="button"
                                            class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                            <i class="fas fa-receipt mr-2"></i>
                                            <span>Tickets</span>
                                        </button>
                                        <button
                                            @click="activeTab = 'logo'"
                                            type="button"
                                            class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 whitespace-nowrap">
                                            <i class="fas fa-image mr-2"></i>
                                            <span>Logo</span>
                                        </button>
                                        <button
                                            @click="activeTab = 'sistema'"
                                            type="button"
                                            class="flex items-center justify-center py-2.5 px-5 text-sm font-medium focus:outline-none focus-visible:outline-2 focus-visible:outline-blue-500 focus-visible:outline-offset-2 rounded-lg border-2 bg-blue-600 text-white border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 whitespace-nowrap">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <span>Sistema</span>
                                        </button>
                                    </nav>
                                    <!-- Dropdown Móvil -->
                                    <div class="md:hidden w-full relative" x-data="{ showNavDropdown: false }">
                                        <button @click="showNavDropdown = !showNavDropdown"
                                            type="button"
                                            class="w-full flex items-center justify-between py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                            <span class="flex items-center">
                                                <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                                Información de Sistema
                                            </span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showNavDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                              </svg>
                                        </button>
                                        <div x-show="showNavDropdown"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             @click.away="showNavDropdown = false"
                                             x-cloak
                                             class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                            <button type="button"
                                                @click="activeTab = 'cajeros'; showNavDropdown = false"
                                                class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-tie mr-3"></i>
                                                Administración de Cajeros
                                            </button>
                                            <button type="button"
                                                @click="activeTab = 'tickets'; showNavDropdown = false"
                                                class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <i class="fas fa-receipt mr-3"></i>
                                                Personalización de Tickets
                                            </button>
                                            <button type="button"
                                                @click="activeTab = 'logo'; showNavDropdown = false"
                                                class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <i class="fas fa-image mr-3"></i>
                                                Logo de la Empresa
                                            </button>
                                            <button type="button"
                                                @click="activeTab = 'sistema'; showNavDropdown = false"
                                                class="w-full flex items-center px-4 py-3 text-sm border-t border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                                                <i class="fas fa-info-circle mr-3"></i>
                                                Información de Sistema
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contenedor para Dispositivo y Licencia -->
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                            <!-- Dispositivo -->
                            <div class="flex-1 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                                <div class="border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 py-3 md:py-4">
                                    <div class="flex items-center gap-2 md:gap-3">
                                        <div class="h-8 w-8 md:h-10 md:w-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-desktop text-primary text-sm md:text-base"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-base md:text-xl font-semibold text-black dark:text-white">
                                                Información del Dispositivo
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Detalles del dispositivo y sistema
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 md:p-6">
                                    <div class="grid grid-cols-1 gap-3 md:gap-4">
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Nombre del Dispositivo</p>
                                            <p class="text-base font-semibold text-black dark:text-white">POS-001</p>
                                        </div>
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">ID del Dispositivo</p>
                                            <p class="text-base font-semibold text-black dark:text-white font-mono">DEV-2024-001</p>
                                        </div>
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Versión del Sistema</p>
                                            <p class="text-base font-semibold text-black dark:text-white">v1.0.0</p>
                                        </div>
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Última Actualización</p>
                                            <p class="text-base font-semibold text-black dark:text-white">15/01/2025</p>
                                        </div>
                                    </div>
                              </div>
                            </div>

                            <!-- Licencia -->
                            <div class="flex-1 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                                <div class="border-b border-gray-200 dark:border-gray-700 px-4 md:px-6 py-3 md:py-4">
                                    <div class="flex items-center gap-2 md:gap-3">
                                        <div class="h-8 w-8 md:h-10 md:w-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-key text-green-600 dark:text-green-400 text-sm md:text-base"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-base md:text-xl font-semibold text-black dark:text-white">
                                                Información de Licencia
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Estado y detalles de tu licencia
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 md:p-6">
                                    <div class="grid grid-cols-1 gap-3 md:gap-4">
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Estado de Licencia</p>
                                            <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <i class="fas fa-check-circle mr-1.5 text-sm"></i>
                                                Activa
                                            </span>
                                        </div>
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Tipo de Licencia</p>
                                            <p class="text-base font-semibold text-black dark:text-white">Premium</p>
                                        </div>
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Fecha de Expiración</p>
                                            <p class="text-base font-semibold text-black dark:text-white">15/01/2026</p>
                                        </div>
                                        <div class="p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Número de Licencia</p>
                                            <p class="text-sm font-semibold text-black dark:text-white font-mono">LIC-2024-XXXX-XXXX</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- ====== Settings Section End ====== -->
        </div>
        <!-- ===== Main Content End ===== -->
    </main>

@endsection

