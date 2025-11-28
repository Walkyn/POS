@extends('layouts.app')
@section('title', 'Historial de Cierres de Turno')

@section('content')
    <main class="h-full pb-16 overflow-y-auto" x-data="{
        searchQuery: '',
        fechaSeleccionada: '',
        isModalOpen: false,
        cierreSeleccionado: null,
        cierres: [{
            id: 1,
            fecha: '2025-01-15 18:30:00',
            usuario: 'Carlos Pérez',
            totalVentas: 1245.00,
            totalEnCaja: 1745.00,
            tickets: 12,
            efectivoInicial: 500.00,
            efectivoFinal: 1745.00,
            diferencia: 1245.00
        }],
        cierresFiltrados: [],
        filtrarCierres() {
            let filtrados = this.cierres;
    
            // Filtrar por fecha específica
            if (this.fechaSeleccionada) {
                const fechaSeleccionada = new Date(this.fechaSeleccionada);
                const inicioDia = new Date(fechaSeleccionada);
                inicioDia.setHours(0, 0, 0, 0);
                const finDia = new Date(fechaSeleccionada);
                finDia.setHours(23, 59, 59, 999);
                
                filtrados = filtrados.filter(item => {
                    const fechaItem = new Date(item.fecha);
                    return fechaItem >= inicioDia && fechaItem <= finDia;
                });
            }
    
            // Filtrar por búsqueda
            const query = this.searchQuery.toLowerCase().trim();
            if (query) {
                filtrados = filtrados.filter(item =>
                    item.usuario.toLowerCase().includes(query) ||
                    item.fecha.toLowerCase().includes(query) ||
                    item.totalVentas.toString().includes(query) ||
                    item.tickets.toString().includes(query)
                );
            }
    
            this.cierresFiltrados = filtrados;
        },
        formatearFecha(fecha) {
            const date = new Date(fecha);
            return date.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        formatearMoneda(monto) {
            return new Intl.NumberFormat('es-PE', {
                style: 'currency',
                currency: 'PEN',
                minimumFractionDigits: 2
            }).format(monto);
        },
        abrirModal(cierre) {
            this.cierreSeleccionado = cierre;
            this.isModalOpen = true;
        },
        cerrarModal() {
            this.isModalOpen = false;
            this.cierreSeleccionado = null;
        }
    }" x-init="cierresFiltrados = cierres;
    filtrarCierres()">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Historial de Turnos
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li>
                            <a class="font-medium" href="{{ route('sales') }}">Ventas /</a>
                        </li>
                        <li>
                            <a class="font-medium" href="{{ route('sales.close-shift') }}">Turno /</a>
                        </li>
                        <li class="font-medium text-primary">Historial</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Table Section Start ====== -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table Database Start ====== -->
                <div>
                    <section class="dark:bg-gray-900 antialiased relative z-10">
                        <div class="max-w-screen-2xl relative z-10">
                            <div
                                class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-visible z-10">
                                <div
                                    class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-4 px-4 pt-4 pb-2 md:p-4">
                                    {{-- Buscador --}}
                                    <div class="w-full md:w-1/2 lg:w-2/3 order-2 md:order-1 mt-2 md:mt-0">
                                        <form class="flex items-center" id="searchForm">
                                            <label for="simple-search" class="sr-only">Buscar cierres</label>
                                            <div class="relative w-full group">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors duration-200">
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 search-icon group-focus-within:text-primary-600 dark:group-focus-within:text-primary-400 transition-colors duration-200"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                <input type="text" x-model="searchQuery" @input="filtrarCierres()"
                                                    class="w-full pl-12 pr-10 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                    placeholder="Buscar por usuario, fecha, total o tickets...">
                                                <button type="button" x-show="searchQuery"
                                                    @click="searchQuery = ''; filtrarCierres();"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Selector de Fecha --}}
                                    <div class="w-full md:w-auto order-1 md:order-2">
                                        <div class="relative">
                                            <input
                                                type="text"
                                                x-model="fechaSeleccionada"
                                                @change="filtrarCierres()"
                                                class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-sm"
                                                placeholder="mm/dd/yyyy"
                                                data-class="flatpickr-right"
                                            />
                                            <button type="button" x-show="fechaSeleccionada"
                                                @click="fechaSeleccionada = ''; filtrarCierres();"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                {{-- Tabla Desktop --}}
                                <div class="overflow-x-auto overflow-y-visible">
                                    <table
                                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 hidden md:table">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-4 py-3">Fecha</th>
                                                <th scope="col" class="px-4 py-3">Usuario</th>
                                                <th scope="col" class="px-4 py-3">Total Ventas</th>
                                                <th scope="col" class="px-4 py-3">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="cierre in cierresFiltrados" :key="cierre.id">
                                                <tr
                                                    class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="px-4 py-3">
                                                        <span class="text-sm text-gray-600 dark:text-gray-400"
                                                            x-text="formatearFecha(cierre.fecha)"></span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="text-sm font-medium text-gray-900 dark:text-white"
                                                            x-text="cierre.usuario"></span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span
                                                            class="text-sm font-semibold text-gray-900 dark:text-white font-numbers"
                                                            x-text="formatearMoneda(cierre.totalVentas)"></span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <button type="button" @click.stop="abrirModal(cierre)"
                                                            class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Cards Móvil --}}
                                <div class="md:hidden space-y-3 px-4 pb-4 pt-0">
                                    <template x-for="cierre in cierresFiltrados" :key="cierre.id">
                                        <div
                                            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                            <div class="px-4 pt-4 pb-3 flex items-center justify-between">
                                                <div class="flex items-center gap-3 flex-1">
                                                    <div
                                                        class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 dark:bg-blue-900/30">
                                                        <i
                                                            class="fas fa-calendar-check text-base text-blue-600 dark:text-blue-400"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"
                                                            x-text="cierre.usuario"></p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"
                                                            x-text="formatearFecha(cierre.fecha)"></p>
                                                    </div>
                                                </div>
                                                <div class="text-right mr-3">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Ventas
                                                    </p>
                                                    <p class="text-base font-semibold text-gray-900 dark:text-white font-numbers"
                                                        x-text="formatearMoneda(cierre.totalVentas)"></p>
                                                </div>
                                                <button type="button" @click="abrirModal(cierre)"
                                                    class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- Mensaje cuando no hay datos --}}
                                <div x-show="cierresFiltrados.length === 0" x-cloak
                                    class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-history text-3xl mb-2 opacity-50"></i>
                                    <p class="text-sm">No hay cierres de turno registrados</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- ====== Table Database End ====== -->
            </div>
            <!-- ====== Table Section End ====== -->
        </div>

        {{-- Modal de Detalles --}}
        @include('sales.modals.detail-shift')
    </main>

@endsection
