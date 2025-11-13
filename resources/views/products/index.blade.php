@extends('layouts.app')
@section('title', 'Productos')

@section('content')
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Gestión de productos
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li class="font-medium text-primary">Productos</li>
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
                @include('partials.table.table-products')
                <!-- ====== Table Database End ====== -->
            </div>
            <!-- ====== Table Section End ====== -->
        </div>
        <!-- ===== Main Content End ===== -->
    </main>

@endsection
