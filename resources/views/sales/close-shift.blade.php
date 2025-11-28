@extends('layouts.app')
@section('title', 'Cierre de Turno')

@section('content')
    <main x-data="{
        isModalConfirmacionOpen: false,
        abrirModalConfirmacion() {
            this.isModalConfirmacionOpen = true;
        },
        cerrarModalConfirmacion() {
            this.isModalConfirmacionOpen = false;
        },
        imprimirCierre() {
            window.print();
        },
        registrarCierre() {
            // Cerrar el modal primero
            this.cerrarModalConfirmacion();
            // Registrar el cierre
            document.getElementById('formCierreTurno').submit();
        }
    }">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Cierre de Turno
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li>
                            <a class="font-medium" href="{{ route('sales') }}">Ventas /</a>
                        </li>
                        <li class="font-medium text-primary">Cierre de Turno</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Cierre de Turno Section Start ====== -->
            <div class="flex flex-col gap-6">
                <!-- Tipos de Pago -->
                <div class="rounded-lg md:rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-4 py-3 dark:border-strokedark">
                        <h3 class="text-base md:text-lg font-semibold text-black dark:text-white">
                            Total pagos recibidos
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <!-- Efectivo -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-money-bill-wave text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Efectivo</p>
                                    <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                </div>
                            </div>

                            <!-- Tarjeta -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-credit-card text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Tarjeta</p>
                                    <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                </div>
                            </div>

                            <!-- Yape -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-mobile-alt text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Yape</p>
                                    <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                </div>
                            </div>

                            <!-- Plin -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-wallet text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Plin</p>
                                    <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de Información -->
                <div class="rounded-lg md:rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-4 py-3 dark:border-strokedark">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shopping-cart text-primary dark:text-white"></i>
                            <h3 class="text-base md:text-lg font-semibold text-black dark:text-white">
                                Panel de Información
                            </h3>
                        </div>
                    </div>
                    <div class="p-4 md:p-6">
                        <!-- Tarjetas de Información -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                            <!-- Total de Venta -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-shopping-cart text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Total de venta</p>
                                    <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                </div>
                            </div>

                            <!-- Fondo Caja -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-wallet text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Fondo caja</p>
                                    <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                </div>
                            </div>

                            <!-- Entradas -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-arrow-down text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Entradas</p>
                                    <p class="text-base md:text-lg font-bold text-green-600 dark:text-green-400 font-numbers">S/ 0.00</p>
                                </div>
                            </div>

                            <!-- Salidas -->
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                    <i class="fas fa-arrow-up text-primary dark:text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Salidas</p>
                                    <p class="text-base md:text-lg font-bold text-red-600 dark:text-red-400 font-numbers">S/ 0.00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario de Registro -->
                        <form id="formCierreTurno" class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <!-- Dinero en Caja y Efectivo Final -->
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <!-- Dinero en Caja -->
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                        <i class="fas fa-cash-register text-primary dark:text-white text-sm"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Dinero en caja</p>
                                        <p class="text-base md:text-lg font-bold text-black dark:text-white font-numbers">S/ 0.00</p>
                                    </div>
                                </div>

                                <!-- Efectivo Final -->
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-stroke dark:border-strokedark bg-gray-50 dark:bg-gray-800/50 h-full">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 flex-shrink-0">
                                        <i class="fas fa-money-bill-wave text-primary dark:text-white text-sm"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Efectivo Final</p>
                                        <input type="number" 
                                               step="0.01" 
                                               placeholder="0.00"
                                               value="0.00"
                                               name="efectivo_final"
                                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-base md:text-lg font-bold text-black dark:text-white font-numbers bg-transparent border-0 p-0 focus:outline-none focus:ring-0 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end pt-2">
                                <button type="button"
                                        @click="abrirModalConfirmacion()"
                                        class="flex w-full sm:w-auto items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 border border-blue-700 hover:border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700 dark:hover:border-blue-700 dark:focus:ring-blue-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Registrar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- ====== Cierre de Turno Section End ====== -->
        </div>

        {{-- Modal de Confirmación --}}
        @include('sales.modals.confirm-close-shift')
    </main>

@endsection

