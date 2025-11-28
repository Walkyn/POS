<!-- Modal de Búsqueda de Clientes -->
<div x-show="isSearchCustomerModal" 
     x-cloak
     @keydown.escape.window="isSearchCustomerModal = false; setTimeout(() => { customerSearchQuery = ''; clientesFiltrados = []; selectedCustomerIndex = -1; }, 200);"
     class="fixed inset-0 z-[9999] md:flex md:items-center md:justify-center">
    
    <!-- Overlay -->
    <div x-show="isSearchCustomerModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] transition-all duration-300"></div>

    <!-- Modal Desktop -->
    <div x-show="isSearchCustomerModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         @mousedown="if ($event.target === $el || ($event.target.tagName !== 'BUTTON' && $event.target.tagName !== 'INPUT' && !$event.target.closest('button') && !$event.target.closest('input'))) { setTimeout(() => $refs.searchCustomerInputDesktop?.focus(), 0); }"
         class="hidden md:block no-scrollbar relative w-full max-w-4xl max-h-[90vh] overflow-hidden rounded-xl bg-white shadow-2xl dark:bg-gray-900 mx-4 flex flex-col modal-content">

        <!-- Botón cerrar -->
        <button @click="isSearchCustomerModal = false; setTimeout(() => { customerSearchQuery = ''; clientesFiltrados = []; }, 200);"
            class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>

        <!-- Título -->
        <div class="px-4 sm:px-4 lg:px-4 pt-4 sm:pt-4 pb-4 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Seleccionar Cliente
            </h3>
        </div>

        <!-- Buscador -->
        <div class="px-4 sm:px-4 lg:px-4 pt-4 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="relative w-full group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors duration-200">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400 transition-colors duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                       x-ref="searchCustomerInputDesktop"
                       x-model="customerSearchQuery"
                       @input="filtrarClientes(); selectedCustomerIndex = -1;"
                       @keydown.arrow-down.prevent.stop="if (clientesFiltrados && clientesFiltrados.length > 0) { selectedCustomerIndex = selectedCustomerIndex < clientesFiltrados.length - 1 ? selectedCustomerIndex + 1 : clientesFiltrados.length - 1; scrollToSelectedCustomer(); }"
                       @keydown.arrow-up.prevent.stop="if (clientesFiltrados && clientesFiltrados.length > 0) { selectedCustomerIndex = selectedCustomerIndex > 0 ? selectedCustomerIndex - 1 : 0; scrollToSelectedCustomer(); }"
                       @keydown.enter.prevent.stop="if (selectedCustomerIndex >= 0 && clientesFiltrados && clientesFiltrados[selectedCustomerIndex]) { seleccionarCliente(clientesFiltrados[selectedCustomerIndex]); } else if (clientesFiltrados && clientesFiltrados.length === 1) { seleccionarCliente(clientesFiltrados[0]); }"
                       @focusout="setTimeout(() => { if (isSearchCustomerModal && (!$event.relatedTarget || (!$event.relatedTarget.closest('button') && $event.relatedTarget !== $refs.searchCustomerInputDesktop))) { $refs.searchCustomerInputDesktop?.focus(); } }, 150)"
                       autofocus
                       class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                       placeholder="Buscar por nombre, DNI o teléfono...">
                <button type="button"
                    x-show="customerSearchQuery"
                    @click="customerSearchQuery = ''; filtrarClientes();"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido del Modal - Tabla Desktop -->
        <div class="flex-1 overflow-y-auto">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0">
                        <tr>
                            <th scope="col" class="p-4">Cliente</th>
                            <th scope="col" class="p-4">DNI/RUC</th>
                            <th scope="col" class="p-4">Teléfono</th>
                            <th scope="col" class="p-4">Dirección</th>
                            <th scope="col" class="p-4">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="clientesFiltrados.length === 0">
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-sm">No se encontraron clientes</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-for="(cliente, index) in clientesFiltrados" :key="cliente.id">
                            <tr :class="selectedCustomerIndex === index ? 'bg-blue-50 dark:bg-blue-900/20 border-b dark:border-gray-700' : 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                @mouseenter="selectedCustomerIndex = index"
                                :data-customer-index="index"
                                class="transition-colors">
                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                        <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-700">
                                            <img :src="getCustomerAvatarUrl(cliente.nombre)" :alt="cliente.nombre" class="h-full w-full object-cover" />
                                        </div>
                                        <div class="flex flex-col flex-1 min-w-0">
                                            <div class="mb-1">
                                                <span class="text-base font-semibold whitespace-nowrap text-black dark:text-white block" x-text="cliente.nombre"></span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm font-mono text-gray-900 dark:text-white" x-text="cliente.dni || '-'"></span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 dark:text-white" x-text="cliente.telefono || '-'"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white" x-text="cliente.direccion || '-'"></span>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <button type="button" 
                                            @click="seleccionarCliente(cliente)"
                                            class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Móvil -->
    <div x-show="isSearchCustomerModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col modal-content">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        <!-- Header móvil -->
        <div x-show="isSearchCustomerModal"
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Seleccionar Cliente</h3>
                </div>
                <button @click="isSearchCustomerModal = false; setTimeout(() => { customerSearchQuery = ''; clientesFiltrados = []; }, 200);"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors ml-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Buscador móvil -->
        <div class="px-5 pt-3 pb-3 border-b border-gray-200 dark:border-gray-700">
            <div class="relative w-full group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none transition-colors duration-200">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400 transition-colors duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                       x-ref="searchCustomerInputMobile"
                       x-model="customerSearchQuery"
                       @input="filtrarClientes(); selectedCustomerIndex = -1;"
                       @keydown.arrow-down.prevent.stop="if (clientesFiltrados && clientesFiltrados.length > 0) { selectedCustomerIndex = selectedCustomerIndex < clientesFiltrados.length - 1 ? selectedCustomerIndex + 1 : clientesFiltrados.length - 1; scrollToSelectedCustomer(); }"
                       @keydown.arrow-up.prevent.stop="if (clientesFiltrados && clientesFiltrados.length > 0) { selectedCustomerIndex = selectedCustomerIndex > 0 ? selectedCustomerIndex - 1 : 0; scrollToSelectedCustomer(); }"
                       @keydown.enter.prevent.stop="if (selectedCustomerIndex >= 0 && clientesFiltrados && clientesFiltrados[selectedCustomerIndex]) { seleccionarCliente(clientesFiltrados[selectedCustomerIndex]); } else if (clientesFiltrados && clientesFiltrados.length === 1) { seleccionarCliente(clientesFiltrados[0]); }"
                       autofocus
                       class="w-full pl-10 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                       placeholder="Buscar por nombre, DNI o teléfono...">
                <button type="button"
                    x-show="customerSearchQuery"
                    @click="customerSearchQuery = ''; filtrarClientes();"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenido móvil - Cards -->
        <div x-show="isSearchCustomerModal"
             x-transition:enter="transition ease-out duration-400 delay-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="flex-1 overflow-y-auto px-5 py-4">
            <template x-if="clientesFiltrados.length === 0">
                <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">No se encontraron clientes</p>
                    </div>
                </div>
            </template>
            <div class="space-y-3">
                <template x-for="(cliente, index) in clientesFiltrados" :key="cliente.id">
                    <div :class="selectedCustomerIndex === index ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-700' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700'"
                         @mouseenter="selectedCustomerIndex = index"
                         :data-customer-index="index"
                         class="rounded-xl border p-4 shadow-sm hover:shadow-md transition-all duration-300"
                         :style="`animation: fadeInUp 0.4s ease-out ${(index * 0.05) + 0.4}s both;`">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="h-16 w-16 flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                <img :src="getCustomerAvatarUrl(cliente.nombre)" :alt="cliente.nombre" class="h-full w-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2" x-text="cliente.nombre"></h3>
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">DNI/RUC:</span> 
                                        <span class="font-mono text-gray-900 dark:text-white" x-text="cliente.dni || '-'"></span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">Teléfono:</span> 
                                        <span class="text-gray-900 dark:text-white" x-text="cliente.telefono || '-'"></span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">Dirección:</span> 
                                        <span class="text-gray-900 dark:text-white" x-text="cliente.direccion || '-'"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button" 
                                @click="seleccionarCliente(cliente)"
                                class="w-full flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Seleccionar Cliente
                        </button>
                    </div>
                </template>
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

