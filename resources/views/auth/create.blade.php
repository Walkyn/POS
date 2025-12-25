@extends('layouts.app')

@section('content')
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Registrar usuario
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li>
                            <a class="font-medium" href="{{ route('users') }}">Usuarios /</a>
                        </li>
                        <li class="font-medium text-primary">Registrar</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Forms Section Start ====== -->
            <div class="rounded-sm border dark:bg-gray-800 border-stroke bg-white shadow-default dark:border-strokedark"
                x-data="{
                    cliente: {
                        tipo_documento: 'dni',
                        documento: '',
                        nombres: '',
                        apellidos: '',
                        codigo_pais: '+51',
                        telefono: '',
                        direccion: '',
                        distrito: '',
                        provincia: '',
                        razon_social: ''
                    },
                    cambiarTipoDocumento() {
                        // Limpiar campos según el tipo de documento
                        if (this.cliente.tipo_documento === 'dni') {
                            // Si cambia a DNI, limpiar campos de RUC
                            this.cliente.razon_social = '';
                        } else {
                            // Si cambia a RUC, limpiar campos de DNI
                            this.cliente.nombres = '';
                            this.cliente.apellidos = '';
                        }
                        // También limpiar el documento al cambiar
                        this.cliente.documento = '';
                    }
                }">
                <div class="flex flex-wrap items-center">
                    <!-- Sección Izquierda: Logo e Ilustración -->
                    <div class="hidden w-full xl:block xl:w-1/2">
                        <div class="px-26 py-17.5 text-center">
                            <a class="mb-5.5 inline-flex items-center" href="{{ route('home') }}">
                                <!-- Logo para modo oscuro -->
                                <img class="hidden dark:block h-10" src="{{ asset('images/logo/nexos-logo-w.png') }}"
                                    alt="Logo" />
                                <!-- Logo para modo claro -->
                                <img class="dark:hidden h-10" src="{{ asset('images/logo/nexos-logo-w.png') }}"
                                    alt="Logo" />
                            </a>

                            <p class="font-medium 2xl:px-20">
                                Registre nuevos usuarios para administrar el sistema.
                            </p>

                            <span class="mt-15 inline-block">
                                <img src="{{ asset('images/illustration/illustration-03.svg') }}" alt="illustration" />
                            </span>
                        </div>
                    </div>

                    <!-- Sección Derecha: Formulario -->
                    <div class="w-full border-stroke dark:border-strokedark xl:w-1/2 xl:border-l-2">
                        <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
                            <form action="#" method="POST" class="dark:text-white">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Primera fila: Tipo de documento + DNI/RUC, Nombres/Razón Social, Apellidos (DNI) - 2 columnas en md+ -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                Tipo de Documento
                                            </label>
                                            <!-- En móvil: selector arriba, input abajo -->
                                            <div class="flex flex-col md:flex-row gap-0">
                                                <!-- Contenedor unificado -->
                                                <div
                                                    class="flex w-full md:flex-row border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded overflow-hidden focus-within:ring-2 md:focus-within:ring-1 focus-within:ring-blue-500 dark:focus-within:ring-blue-400">
                                                    <!-- Selector de tipo de documento -->
                                                    <select x-model="cliente.tipo_documento"
                                                        @change="cambiarTipoDocumento()"
                                                        style="appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none; box-shadow: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1em 1em;"
                                                        class="w-20 md:w-20 text-sm text-black dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-0 border-r-[0.5px] md:border-r border-gray-300 dark:border-gray-600 px-2 py-2 md:py-2.5 pr-6 focus:outline-none focus:ring-0 focus:border-r-[0.5px] focus:border-gray-300 dark:focus:border-gray-600 cursor-pointer">
                                                        <option value="dni">DNI</option>
                                                        <option value="ruc">RUC</option>
                                                    </select>
                                                    <!-- Campo DNI/RUC -->
                                                    <input type="text" x-model="cliente.documento"
                                                        :maxlength="cliente.tipo_documento === 'ruc' ? '11' : '8'"
                                                        style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                        class="flex-1 text-sm text-gray-500 dark:text-gray-400 font-mono bg-white dark:bg-gray-800 md:bg-transparent border-0 px-3 md:px-2 py-2 md:py-2.5 focus:outline-none placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                        :placeholder="cliente.tipo_documento === 'ruc' ? 'Ingrese RUC' :
                                                            'Ingrese DNI'">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                <span x-show="cliente.tipo_documento === 'dni'">Nombres</span>
                                                <span x-show="cliente.tipo_documento === 'ruc'" x-cloak>Razón Social</span>
                                            </label>
                                            <input type="text" x-model="cliente.nombres"
                                                x-show="cliente.tipo_documento === 'dni'"
                                                style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                class="w-full text-sm font-mono text-black dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                placeholder="Nombres">
                                            <input type="text" x-model="cliente.razon_social"
                                                x-show="cliente.tipo_documento === 'ruc'" x-cloak
                                                style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                class="w-full text-sm font-mono text-black dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                placeholder="Razón Social">
                                        </div>

                                        <div x-show="cliente.tipo_documento === 'dni'">
                                            <label
                                                class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Apellidos</label>
                                            <input type="text" x-model="cliente.apellidos"
                                                style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                class="w-full text-sm font-mono text-black dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                placeholder="Apellidos">
                                        </div>
                                    </div>

                                    <!-- Segunda fila: Teléfono y Dirección - 2 columnas en md+ -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Teléfono</label>
                                            <div
                                                class="flex w-full border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded overflow-hidden focus-within:ring-2 md:focus-within:ring-1 focus-within:ring-blue-500 dark:focus-within:ring-blue-400">
                                                <!-- Selector de código de país -->
                                                <select x-model="cliente.codigo_pais"
                                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none; box-shadow: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1em 1em;"
                                                    class="w-20 md:w-20 text-sm text-black dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-0 border-r-[0.5px] md:border-r border-gray-300 dark:border-gray-600 px-2 py-2 md:py-2.5 pr-6 focus:outline-none focus:ring-0 focus:border-r-[0.5px] focus:border-gray-300 dark:focus:border-gray-600 cursor-pointer">
                                                    <option value="+51">+51</option>
                                                </select>
                                                <!-- Campo de teléfono -->
                                                <input type="tel" x-model="cliente.telefono"
                                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                    class="flex-1 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-0 px-3 md:px-2 py-2 md:py-2.5 focus:outline-none placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                    placeholder="Teléfono">
                                            </div>
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Dirección</label>
                                            <input type="text" x-model="cliente.direccion"
                                                style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                placeholder="Dirección">
                                        </div>
                                    </div>

                                    <!-- Tercera fila: Distrito y Provincia - 2 columnas en md+ -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Distrito</label>
                                            <input type="text" x-model="cliente.distrito"
                                                style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                placeholder="Distrito">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Provincia</label>
                                            <input type="text" x-model="cliente.provincia"
                                                style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                placeholder="Provincia">
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de Acción -->
                                <div class="mt-8 mb-5">
                                    <button type="submit"
                                        class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-3 font-medium text-white transition hover:bg-opacity-90">
                                        Registrar usuario
                                    </button>
                                </div>
                                <div>
                                    <a href="{{ route('users') }}"
                                        class="w-full flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                                        <span>Cancelar</span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ====== Forms Section End ====== -->
        </div>
        <!-- ===== Main Content End ===== -->
    </main>

@endsection
