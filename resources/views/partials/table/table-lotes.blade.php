{{-- Tabla de Lotes --}}
{{-- Muestra la lista de lotes en formato tabla (desktop) y cards (móvil) con funcionalidad de edición inline --}}
<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">Producto</th>
                <th scope="col" class="p-4">N° Lote</th>
                <th scope="col" class="p-4 whitespace-nowrap">P. Costo</th>
                <th scope="col" class="p-4 whitespace-nowrap">P. Venta</th>
                <th scope="col" class="p-4 whitespace-nowrap">P. Mayoreo</th>
                <th scope="col" class="p-4 whitespace-nowrap">Stock</th>
                <th scope="col" class="p-4 whitespace-nowrap">Fecha Vencimiento</th>
                <th scope="col" class="p-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="lote in lotes" :key="lote.id">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" 
                    :class="{ 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500': editingLoteId === lote.id }">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <div class="h-12.5 w-15 rounded-md">
                                <img :src="lote.producto_imagen" :alt="lote.producto_nombre" class="h-full w-full object-cover rounded-md" />
                            </div>
                            <div class="flex flex-col flex-1 min-w-0">
                                <div class="mb-1">
                                    <span class="text-base font-semibold whitespace-nowrap text-black dark:text-white block" x-text="lote.producto_nombre"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono block" x-text="lote.producto_codigo"></span>
                                </div>
                            </div>
                        </div>
                    </th>
                    <td class="px-4 py-3">
                        <span x-show="editingLoteId !== lote.id" class="text-sm font-mono text-gray-900 dark:text-white" x-text="lote.numero_lote"></span>
                        <input x-show="editingLoteId === lote.id" 
                               x-model="lote.numero_lote"
                               type="text"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="N° Lote">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_costo || 0).toFixed(2)"></span>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.precio_costo !== null && lote.precio_costo !== undefined ? lote.precio_costo : ''"
                               @input="lote.precio_costo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0" step="0.01"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0.00">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_venta || 0).toFixed(2)"></span>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.precio_venta !== null && lote.precio_venta !== undefined ? lote.precio_venta : ''"
                               @input="lote.precio_venta = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0" step="0.01"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0.00">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_mayoreo || 0).toFixed(2)"></span>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.precio_mayoreo !== null && lote.precio_mayoreo !== undefined ? lote.precio_mayoreo : ''"
                               @input="lote.precio_mayoreo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0" step="0.01"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0.00">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span x-show="editingLoteId !== lote.id" class="block text-sm text-gray-900 dark:text-white" x-text="lote.cantidad || '-'"></span>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.cantidad !== null && lote.cantidad !== undefined ? lote.cantidad : ''"
                               @input="lote.cantidad = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-600 dark:text-gray-400" x-text="lote.fecha_vencimiento ? new Date(lote.fecha_vencimiento).toLocaleDateString('es-PE') : '-'"></span>
                        <input x-show="editingLoteId === lote.id" 
                               x-model="lote.fecha_vencimiento"
                               type="date"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400">
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center space-x-2">
                            <button type="button" 
                                    title="Editar"
                                    x-show="editingLoteId !== lote.id" 
                                    @click.stop="editarLote(lote)"
                                    class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </button>
                            <button type="button" 
                                    title="Guardar"
                                    x-show="editingLoteId === lote.id" 
                                    @click.stop="guardarLote(lote)"
                                    class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="button" 
                                    title="Eliminar"
                                    @click.stop="eliminarLote(lote)"
                                    class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>

    {{-- Vista Móvil --}}
    <div class="md:hidden space-y-4 px-4 pt-0 pb-4">
        <template x-for="lote in lotes" :key="lote.id">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm"
                 :class="{ 'border-blue-500 dark:border-blue-400 border-2': editingLoteId === lote.id }">
                <div class="flex items-start gap-4 mb-4">
                    <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden">
                        <img :src="lote.producto_imagen" :alt="lote.producto_nombre" class="h-full w-full object-cover" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1" x-text="lote.producto_nombre"></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-1" x-text="lote.producto_codigo"></p>
                        <div x-show="editingLoteId !== lote.id">
                            <p class="text-xs font-mono text-blue-600 dark:text-blue-400 font-semibold" x-text="lote.numero_lote"></p>
                        </div>
                        <input x-show="editingLoteId === lote.id" 
                               x-model="lote.numero_lote"
                               type="text"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="N° Lote">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Costo</p>
                        <div x-show="editingLoteId !== lote.id">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_costo || 0).toFixed(2)"></p>
                        </div>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.precio_costo !== null && lote.precio_costo !== undefined ? lote.precio_costo : ''"
                               @input="lote.precio_costo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0" step="0.01"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0.00">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Venta</p>
                        <div x-show="editingLoteId !== lote.id">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_venta || 0).toFixed(2)"></p>
                        </div>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.precio_venta !== null && lote.precio_venta !== undefined ? lote.precio_venta : ''"
                               @input="lote.precio_venta = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0" step="0.01"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0.00">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Mayoreo</p>
                        <div x-show="editingLoteId !== lote.id">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(lote.precio_mayoreo || 0).toFixed(2)"></p>
                        </div>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.precio_mayoreo !== null && lote.precio_mayoreo !== undefined ? lote.precio_mayoreo : ''"
                               @input="lote.precio_mayoreo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0" step="0.01"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0.00">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                        <div x-show="editingLoteId !== lote.id">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.cantidad || '-'"></p>
                        </div>
                        <input x-show="editingLoteId === lote.id" 
                               :value="lote.cantidad !== null && lote.cantidad !== undefined ? lote.cantidad : ''"
                               @input="lote.cantidad = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                               type="number" min="0"
                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                               placeholder="0">
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                    <div x-show="editingLoteId !== lote.id">
                        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="lote.fecha_vencimiento ? new Date(lote.fecha_vencimiento).toLocaleDateString('es-PE') : '-'"></p>
                    </div>
                    <input x-show="editingLoteId === lote.id" 
                           x-model="lote.fecha_vencimiento"
                           type="date"
                           style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                           class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                </div>
                <div class="flex gap-2">
                    <button type="button" 
                            x-show="editingLoteId !== lote.id"
                            @click.stop="editarLote(lote)"
                            title="Editar"
                            class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                    </button>
                    <button type="button" 
                            x-show="editingLoteId === lote.id"
                            @click.stop="guardarLote(lote)"
                            title="Guardar"
                            class="flex-1 flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" 
                            @click.stop="eliminarLote(lote)"
                            title="Eliminar"
                            class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

