@extends('layouts.app')
@section('title', 'Productos')

@section('content')
    <script>
        // Actualizar la variable page cuando se carga la página
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const body = document.querySelector('body');
                if (body && body.__x && body.__x.$data) {
                    body.__x.$data.page = 'products';
                }
            }, 100);
        });
    </script>

    <!-- ===== Main Content Start ===== -->
    <main x-init="$el.closest('body').__x.$data.page = 'products'">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Productos
                </h2>
            </div>
            <!-- Breadcrumb End -->

            <!-- Product Content Start -->
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="p-6">
                    <p class="text-body text-black dark:text-white">
                        Aquí puedes gestionar tus productos.
                    </p>
                </div>
            </div>
            <!-- Product Content End -->
        </div>
    </main>
    <!-- ===== Main Content End ===== -->

@endsection

