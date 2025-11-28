@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Gestión de reportes
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li class="font-medium text-primary">Reportes</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Metrics Cards Start ====== -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-6 mb-6">
                <!-- Card Costo del Inventario -->
                <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Costo del inventario</p>
                        <h4 class="text-2xl font-bold text-black dark:text-white font-numbers">
                            S/ 116,475.97
                        </h4>
                    </div>
                </div>
                <!-- Card End -->

                <!-- Card Productos en Inventario -->
                <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Productos en Inventario</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-boxes text-teal-500 text-lg"></i>
                            <h4 class="text-2xl font-bold text-teal-600 dark:text-teal-400 font-numbers">
                                696,800
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Card End -->

                <!-- Card Costo Total de Venta -->
                <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Costo total de venta</p>
                        <h4 class="text-2xl font-bold text-black dark:text-white font-numbers">
                            S/ 18,912,914.71
                        </h4>
                    </div>
                </div>
                <!-- Card End -->
            </div>
            <!-- ====== Metrics Cards End ====== -->

            <!-- ====== Table Section Start ====== -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table Database Start ====== -->
                @include('partials.table.table-inventory')
                <!-- ====== Table Database End ====== -->
            </div>
            <!-- ====== Table Section End ====== -->
        </div>
        <!-- ===== Main Content End ===== -->
    </main>

@endsection
