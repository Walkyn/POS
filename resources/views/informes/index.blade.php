@extends('layouts.app')
@section('title', 'Informes')

@section('content')
    <main class="overflow-x-hidden">
        <div class="mx-auto max-w-screen-2xl p-3 md:p-4 lg:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Informes
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li class="font-medium text-primary">Informes</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Panel de Información y Filtros Start ====== -->
            <div class="mb-4 md:mb-6 rounded-lg md:rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark overflow-hidden" x-data="{
                fechaSeleccionada: '',
                exportarPDF() {
                    console.log('Exportar a PDF');
                    // Aquí iría la lógica para exportar a PDF
                },
                filtrarPorFecha() {
                    // Disparar evento para que las tablas filtren por fecha
                    window.dispatchEvent(new CustomEvent('cambiar-fecha-informes', { 
                        detail: { fecha: this.fechaSeleccionada } 
                    }));
                }
            }">
                <div class="border-b border-stroke px-3 md:px-4 py-3 dark:border-strokedark">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 md:gap-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-chart-line text-primary dark:text-white text-base md:text-lg"></i>
                            <h3 class="text-sm md:text-base lg:text-lg font-semibold text-black dark:text-white">
                                Panel de Información
                            </h3>
                        </div>
                        
                        {{-- Botones de Acción --}}
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 w-full md:w-auto">
                            {{-- Botón Exportar PDF --}}
                            <button type="button"
                                @click="exportarPDF()"
                                class="flex items-center justify-center h-10 md:h-10 py-2.5 px-4 text-xs sm:text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                <i class="fas fa-file-pdf mr-2 text-xs sm:text-sm"></i>
                                <span class="whitespace-nowrap">Exportar PDF</span>
                            </button>

                            {{-- Selector de Fecha --}}
                            <div class="relative w-full sm:w-auto">
                                <input type="date" 
                                    x-model="fechaSeleccionada"
                                    @change="filtrarPorFecha()"
                                    class="w-full sm:w-auto h-10 md:h-10 py-2.5 px-3 md:px-4 text-xs sm:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 md:p-4 lg:p-6" x-data="{
                    get totalIngresos() {
                        return (this.totalVentas || 0) + (this.entradaEfectivo || 0) + (this.fondoCaja || 0);
                    },
                    get totalVentas() {
                        return 5000.00; // Ejemplo
                    },
                    get entradaEfectivo() {
                        return 1200.00; // Ejemplo
                    },
                    get fondoCaja() {
                        return 500.00; // Ejemplo
                    },
                    get gananciaDia() {
                        return 850.00; // Ejemplo
                    },
                    get totalEnCaja() {
                        return (this.fondoCaja || 0) + (this.totalVentas || 0) + (this.entradas || 0) - (this.salidas || 0);
                    },
                    get entradas() {
                        return 1200.00; // Ejemplo
                    },
                    get salidas() {
                        return 300.00; // Ejemplo
                    },
                    formatearNumero(numero) {
                        return numero.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    }
                }">
                    {{-- Métricas --}}
                    <div class="grid grid-cols-1 gap-3 md:gap-4 lg:gap-6 md:grid-cols-3">
                        <!-- Card Ingresos Totales -->
                        <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-3 md:px-4 md:py-4 shadow-sm dark:border-strokedark">
                            <div class="mb-2">
                                <p class="text-sm md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5 md:mb-2">Ingresos Totales</p>
                                <h4 class="text-xl md:text-2xl font-bold text-black dark:text-white font-numbers">
                                    S/ <span x-text="formatearNumero(totalIngresos)"></span>
                                </h4>
                            </div>
                            <div class="pt-2 md:pt-3 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-1.5 md:mb-2">
                                    <i class="fas fa-chart-bar text-blue-500 text-xs md:text-sm"></i>
                                    <p class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400">Ingresos</p>
                                </div>
                                <div class="space-y-1 md:space-y-1.5 text-xs md:text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Total de ventas</span>
                                        <span class="font-semibold text-gray-900 dark:text-white font-numbers">S/ <span x-text="formatearNumero(totalVentas)"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Entrada de efectivo</span>
                                        <span class="font-semibold text-gray-900 dark:text-white font-numbers">S/ <span x-text="formatearNumero(entradaEfectivo)"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Fondo de caja</span>
                                        <span class="font-semibold text-gray-900 dark:text-white font-numbers">S/ <span x-text="formatearNumero(fondoCaja)"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card End -->

                        <!-- Card Ventas Totales -->
                        <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-3 md:px-4 md:py-4 shadow-sm dark:border-strokedark">
                            <div class="mb-2">
                                <p class="text-sm md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5 md:mb-2">Ventas Totales</p>
                                <h4 class="text-xl md:text-2xl font-bold text-black dark:text-white font-numbers">
                                    S/ <span x-text="formatearNumero(totalVentas)"></span>
                                </h4>
                            </div>
                            <div class="pt-2 md:pt-3 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-1.5 md:mb-2">
                                    <i class="fas fa-shopping-cart text-green-500 text-xs md:text-sm"></i>
                                    <p class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400">Ventas</p>
                                </div>
                                <div class="space-y-1 md:space-y-1.5 text-xs md:text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Total de ventas</span>
                                        <span class="font-semibold text-gray-900 dark:text-white font-numbers">S/ <span x-text="formatearNumero(totalVentas)"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Ganancia del día</span>
                                        <span class="font-semibold text-green-600 dark:text-green-400 font-numbers">S/ <span x-text="formatearNumero(gananciaDia)"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card End -->

                        <!-- Card Total en Caja -->
                        <div class="rounded-lg border border-stroke bg-gray-50 dark:bg-gray-800/50 px-3 py-3 md:px-4 md:py-4 shadow-sm dark:border-strokedark">
                            <div class="mb-2">
                                <p class="text-sm md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1.5 md:mb-2">Total en Caja</p>
                                <h4 class="text-xl md:text-2xl font-bold text-black dark:text-white font-numbers">
                                    S/ <span x-text="formatearNumero(totalEnCaja)"></span>
                                </h4>
                            </div>
                            <div class="pt-2 md:pt-3 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-1.5 md:mb-2">
                                    <i class="fas fa-money-bill-wave text-teal-500 text-xs md:text-sm"></i>
                                    <p class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400">Dinero en caja</p>
                                </div>
                                <div class="space-y-1 md:space-y-1.5 text-xs md:text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Fondo de caja</span>
                                        <span class="font-semibold text-gray-900 dark:text-white font-numbers">S/ <span x-text="formatearNumero(fondoCaja)"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Ventas totales</span>
                                        <span class="font-semibold text-gray-900 dark:text-white font-numbers">S/ <span x-text="formatearNumero(totalVentas)"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Entradas</span>
                                        <span class="font-semibold text-green-600 dark:text-green-400 font-numbers">S/ <span x-text="formatearNumero(entradas)"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Salidas</span>
                                        <span class="font-semibold text-red-600 dark:text-red-400 font-numbers">S/ <span x-text="formatearNumero(salidas)"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card End -->
                    </div>
                </div>
            </div>
            <!-- ====== Panel de Información y Filtros End ====== -->

            <!-- ====== Table Section Start ====== -->
            <div class="flex flex-col gap-4 md:gap-6 lg:gap-10">
                <!-- ====== Table Database Start ====== -->
                @include('partials.table.table-informes')
                <!-- ====== Table Database End ====== -->
            </div>
            <!-- ====== Table Section End ====== -->
        </div>
        <!-- ===== Main Content End ===== -->
    </main>

@endsection
