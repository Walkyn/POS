{{-- Vista de lotes para un producto --}}
<div class="lotes-container bg-gray-50 dark:bg-gray-900">
    <div class="md:px-4 md:py-4">

        {{-- Tabla de lotes - Vista Escritorio --}}
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nº Lote</th>
                        <th scope="col" class="px-4 py-3">Cantidad</th>
                        <th scope="col" class="px-4 py-3">Fecha Vencimiento</th>
                        <th scope="col" class="px-4 py-3">Precio Costo</th>
                        <th scope="col" class="px-4 py-3">Precio Venta</th>
                        <th scope="col" class="px-4 py-3">Precio Mayoreo</th>
                        <th scope="col" class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody id="lotes-tbody-{{ $productId ?? '' }}">
                    {{-- Los lotes se cargarán aquí dinámicamente --}}
                    @if(isset($lotes) && count($lotes) > 0)
                        @foreach($lotes as $lote)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $lote->numero_lote ?? 'LOTE-' . str_pad($loop->iteration, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $lote->cantidad ?? rand(10, 100) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $lote->fecha_vencimiento ?? now()->addMonths(rand(1, 12))->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lote->precio_costo ?? rand(50, 500), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lote->precio_venta ?? rand(100, 1000), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format($lote->precio_mayoreo ?? rand(80, 800), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <button type="button" title="Editar Lote"
                                            class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button type="button" title="Eliminar Lote"
                                            class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Datos de ejemplo cuando no hay lotes --}}
                        @for($i = 1; $i <= 3; $i++)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    LOTE-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ rand(10, 100) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ now()->addMonths(rand(1, 12))->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format(rand(50, 500), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format(rand(100, 1000), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    ${{ number_format(rand(80, 800), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <button type="button" title="Editar Lote"
                                            class="flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button type="button" title="Eliminar Lote"
                                            class="flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Vista móvil - Cards de lotes --}}
        <div class="md:hidden space-y-3">
            @if(isset($lotes) && count($lotes) > 0)
                @foreach($lotes as $lote)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                        <div class="mb-3">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $lote->numero_lote ?? 'LOTE-' . str_pad($loop->iteration, 4, '0', STR_PAD_LEFT) }}
                            </h4>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cantidad</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $lote->cantidad ?? rand(10, 100) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $lote->fecha_vencimiento ?? now()->addMonths(rand(1, 12))->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio Costo</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lote->precio_costo ?? rand(50, 500), 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio Venta</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lote->precio_venta ?? rand(100, 1000), 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio Mayoreo</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($lote->precio_mayoreo ?? rand(80, 800), 2) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" title="Editar Lote" class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </button>
                            <button type="button" title="Eliminar Lote" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Datos de ejemplo cuando no hay lotes --}}
                @for($i = 1; $i <= 3; $i++)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                        <div class="mb-3">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">
                                LOTE-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                            </h4>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cantidad</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ rand(10, 100) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ now()->addMonths(rand(1, 12))->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio Costo</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format(rand(50, 500), 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio Venta</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format(rand(100, 1000), 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Precio Mayoreo</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format(rand(80, 800), 2) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" title="Editar Lote" class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </button>
                            <button type="button" title="Eliminar Lote" class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
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
</div>

