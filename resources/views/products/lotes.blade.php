<div class="lotes-container bg-gray-50 dark:bg-gray-900" x-data="{
    isDeleteLoteModal: false,
    loteToDelete: null,
    eliminarLote(lote) {
        this.loteToDelete = lote;
        this.isDeleteLoteModal = true;
    },
    confirmDeleteLote() {
        this.isDeleteLoteModal = false;
        this.loteToDelete = null;
        showSuccessToast();
    }
}">
    <div class="md:px-0 md:pt-0">
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nº Lote</th>
                        <th scope="col" class="px-4 py-3">Cantidad</th>
                        <th scope="col" class="px-4 py-3">Fecha Vencimiento</th>
                        <th scope="col" class="px-4 py-3">P. Costo</th>
                        <th scope="col" class="px-4 py-3">P. Venta</th>
                        <th scope="col" class="px-4 py-3">P. Mayoreo</th>
                        <th scope="col" class="px-4 py-3">Acción</th>
                    </tr>
                </thead>
                <tbody id="lotes-tbody-{{ $productId ?? '' }}">
                    @if(isset($lotes) && count($lotes) > 0)
                        @foreach($lotes as $lote)
                            @php
                                $loteId = $lote->id ?? $loop->iteration;
                                $loteNumero = $lote->numero_lote ?? 'LOTE-' . str_pad($loop->iteration, 4, '0', STR_PAD_LEFT);
                                $loteCantidad = $lote->cantidad ?? rand(10, 100);
                                $loteFechaFormatted = $lote->fecha_vencimiento ?? now()->addMonths(rand(1, 12))->format('d/m/Y');
                                $lotePrecioCosto = $lote->precio_costo ?? rand(50, 500);
                                $lotePrecioVenta = $lote->precio_venta ?? rand(100, 1000);
                                $lotePrecioMayoreo = $lote->precio_mayoreo ?? rand(80, 800);
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $loteNumero }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $loteCantidad }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $loteFechaFormatted }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lotePrecioCosto, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lotePrecioVenta, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lotePrecioMayoreo, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <button type="button" 
                                            title="Eliminar Lote"
                                            @click.stop="eliminarLote({id: {{ $loteId }}, numero_lote: '{{ $loteNumero }}', cantidad: {{ $loteCantidad }}, fecha_vencimiento: '{{ $loteFechaFormatted }}', precio_costo: {{ $lotePrecioCosto }}, precio_venta: {{ $lotePrecioVenta }}, precio_mayoreo: {{ $lotePrecioMayoreo }}})"
                                            class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @for($i = 1; $i <= 3; $i++)
                            @php
                                $loteId = $i;
                                $loteNumero = 'LOTE-' . str_pad($i, 4, '0', STR_PAD_LEFT);
                                $loteCantidad = rand(10, 100);
                                $loteFechaFormatted = now()->addMonths(rand(1, 12))->format('d/m/Y');
                                $lotePrecioCosto = rand(50, 500);
                                $lotePrecioVenta = rand(100, 1000);
                                $lotePrecioMayoreo = rand(80, 800);
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $loteNumero }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $loteCantidad }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $loteFechaFormatted }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lotePrecioCosto, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lotePrecioVenta, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lotePrecioMayoreo, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <button type="button" 
                                            title="Eliminar Lote"
                                            @click.stop="eliminarLote({id: {{ $loteId }}, numero_lote: '{{ $loteNumero }}', cantidad: {{ $loteCantidad }}, fecha_vencimiento: '{{ $loteFechaFormatted }}', precio_costo: {{ $lotePrecioCosto }}, precio_venta: {{ $lotePrecioVenta }}, precio_mayoreo: {{ $lotePrecioMayoreo }}})"
                                            class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        <div class="md:hidden space-y-3">
            @if(isset($lotes) && count($lotes) > 0)
                @foreach($lotes as $lote)
                    @php
                        $loteId = $lote->id ?? $loop->iteration;
                        $loteNumero = $lote->numero_lote ?? 'LOTE-' . str_pad($loop->iteration, 4, '0', STR_PAD_LEFT);
                        $loteCantidad = $lote->cantidad ?? rand(10, 100);
                        $loteFechaFormatted = $lote->fecha_vencimiento ?? now()->addMonths(rand(1, 12))->format('d/m/Y');
                        $lotePrecioCosto = $lote->precio_costo ?? rand(50, 500);
                        $lotePrecioVenta = $lote->precio_venta ?? rand(100, 1000);
                        $lotePrecioMayoreo = $lote->precio_mayoreo ?? rand(80, 800);
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                        <div class="mb-3">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">{{ $loteNumero }}</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cantidad</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $loteCantidad }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $loteFechaFormatted }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Costo</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lotePrecioCosto, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Venta</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lotePrecioVenta, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Mayoreo</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lotePrecioMayoreo, 2) }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" 
                                    title="Eliminar Lote"
                                    @click.stop="eliminarLote({id: {{ $loteId }}, numero_lote: '{{ $loteNumero }}', cantidad: {{ $loteCantidad }}, fecha_vencimiento: '{{ $loteFechaFormatted }}', precio_costo: {{ $lotePrecioCosto }}, precio_venta: {{ $lotePrecioVenta }}, precio_mayoreo: {{ $lotePrecioMayoreo }}})"
                                    class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                @for($i = 1; $i <= 3; $i++)
                    @php
                        $loteId = $i;
                        $loteNumero = 'LOTE-' . str_pad($i, 4, '0', STR_PAD_LEFT);
                        $loteCantidad = rand(10, 100);
                        $loteFechaFormatted = now()->addMonths(rand(1, 12))->format('d/m/Y');
                        $lotePrecioCosto = rand(50, 500);
                        $lotePrecioVenta = rand(100, 1000);
                        $lotePrecioMayoreo = rand(80, 800);
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                        <div class="mb-3">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">{{ $loteNumero }}</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cantidad</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $loteCantidad }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $loteFechaFormatted }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Costo</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lotePrecioCosto, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Venta</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lotePrecioVenta, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Mayoreo</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lotePrecioMayoreo, 2) }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" 
                                    title="Eliminar Lote"
                                    @click.stop="eliminarLote({id: {{ $loteId }}, numero_lote: '{{ $loteNumero }}', cantidad: {{ $loteCantidad }}, fecha_vencimiento: '{{ $loteFechaFormatted }}', precio_costo: {{ $lotePrecioCosto }}, precio_venta: {{ $lotePrecioVenta }}, precio_mayoreo: {{ $lotePrecioMayoreo }}})"
                                    class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>

    <div x-show="isDeleteLoteModal" x-cloak
        class="fixed inset-0 flex items-center justify-center p-3 sm:p-5 overflow-y-auto z-[9999]">
        <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>
        <div class="no-scrollbar relative w-full max-w-[450px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900">
            <button @click="isDeleteLoteModal = false; loteToDelete = null;"
                class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="p-4 sm:p-6 lg:p-8">
                <div class="mb-4 sm:mb-6 flex items-start gap-3 sm:gap-4">
                    <div
                        class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 pt-3">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                            Confirmar Eliminación de Lote
                        </h3>
                    </div>
                </div>

                <div x-show="loteToDelete" class="mb-4 sm:mb-4">
                    <div class="space-y-3 sm:space-y-3">
                        <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 sm:p-3">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0 space-y-1.5">
                                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lote</span>
                                        <span class="text-sm sm:text-base font-bold text-gray-900 dark:text-white font-mono break-all"
                                            x-text="loteToDelete ? (loteToDelete.numero_lote || 'Lote sin número') : ''"></span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                                        <div class="flex items-center gap-1 sm:gap-1.5">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Cantidad:</span>
                                            <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white" 
                                                x-text="loteToDelete ? (loteToDelete.cantidad || '0') : '0'"></span>
                                        </div>
                                        <div class="flex items-center gap-1 sm:gap-1.5">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Vence:</span>
                                            <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white break-words" 
                                                x-text="loteToDelete ? (loteToDelete.fecha_vencimiento || 'N/A') : 'N/A'"></span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1.5 sm:gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <template x-if="loteToDelete && loteToDelete.precio_costo !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Costo</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_costo || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                        <template x-if="loteToDelete && loteToDelete.precio_venta !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Venta</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_venta || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                        <template x-if="loteToDelete && loteToDelete.precio_mayoreo !== undefined">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Precio Mayoreo</span>
                                                <span class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white"
                                                    x-text="'$' + parseFloat(loteToDelete.precio_mayoreo || 0).toFixed(2)"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4 sm:mt-6">
                    <button @click="confirmDeleteLote()" type="button"
                        class="w-full rounded-xl bg-red-600 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-sm font-semibold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                        Confirmar Eliminación
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
