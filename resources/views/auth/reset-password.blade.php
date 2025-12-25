@extends('layouts.app')
@section('title', 'Restablecer contraseña')

@section('content')
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Restablecer contraseña
                </h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li class="font-medium text-primary">Restablecer contraseña</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Alerts Start ====== -->
            @include('partials.alerts')
            <!-- ====== Alerts End ====== -->

            <!-- ====== Form Section Start ====== -->
            <div class="flex flex-col gap-10">
                <!-- ====== Form Reset Password Start ====== -->
                <div class="rounded-sm border dark:bg-gray-800 border-stroke bg-white shadow-default dark:border-strokedark">
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
                                Restablezca su contraseña de forma segura para acceder a su cuenta.
                            </p>

                            <span class="mt-15 inline-block">
                                <img src="{{ asset('images/illustration/illustration-03.svg') }}" alt="illustration" />
                            </span>
                        </div>
                    </div>

                    <!-- Sección Derecha: Formulario -->
                    <div class="w-full border-stroke dark:border-strokedark xl:w-1/2 xl:border-l-2">
                        <div class="w-full p-4 sm:p-12.5 xl:p-17.5" x-data="{
                            email: '',
                            password: '',
                            confirmPassword: '',
                            showPassword: false,
                            showConfirmPassword: false,
                            userFound: false,
                            user: null,
                            passwordStrength: 0,
                            passwordStrengthText: '',
                            passwordStrengthColor: '',
                            minLength: false,
                            passwordsMatch: false,
                            checkPasswordStrength() {
                                const pass = this.password;
                                
                                if (pass.length >= 8) {
                                    this.minLength = true;
                                } else {
                                    this.minLength = false;
                                }
                                
                                // Calcular fortaleza basada solo en longitud
                                if (pass.length < 8) {
                                    this.passwordStrength = 0;
                                    this.passwordStrengthText = '';
                                    this.passwordStrengthColor = '';
                                } else if (pass.length >= 8 && pass.length < 12) {
                                    this.passwordStrength = 33;
                                    this.passwordStrengthText = 'Débil';
                                    this.passwordStrengthColor = 'bg-red-500';
                                } else if (pass.length >= 12 && pass.length < 16) {
                                    this.passwordStrength = 66;
                                    this.passwordStrengthText = 'Media';
                                    this.passwordStrengthColor = 'bg-yellow-500';
                                } else {
                                    this.passwordStrength = 100;
                                    this.passwordStrengthText = 'Fuerte';
                                    this.passwordStrengthColor = 'bg-green-500';
                                }
                                
                                // Verificar si las contraseñas coinciden
                                this.checkPasswordsMatch();
                            },
                            checkPasswordsMatch() {
                                if (this.confirmPassword.length > 0) {
                                    this.passwordsMatch = this.password === this.confirmPassword;
                                } else {
                                    this.passwordsMatch = false;
                                }
                            },
                            searchUser() {
                                // Simulación de búsqueda - solo diseño
                                if (this.email) {
                                    this.userFound = true;
                                    this.user = {
                                        name: 'Carlos Ramírez',
                                        email: this.email,
                                        role: 'Administrador',
                                        dni: '12345678'
                                    };
                                }
                            }
                        }">
                            <form @submit.prevent="searchUser()" class="dark:text-white">
                                @csrf
                                <!-- Título -->
                                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                    Restablecer Contraseña
                                </h2>
                                
                                <!-- Texto descriptivo -->
                                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6">
                                    Ingrese su correo electrónico para buscar su cuenta y poder configurar el cambio de contraseña.
                                </p>

                                <!-- Campo de Email -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Correo electrónico
                                    </label>
                                    <div class="relative">
                                        <input type="email" 
                                            x-model="email"
                                            autocomplete="email"
                                            placeholder="Ingrese su correo electrónico"
                                            class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón de Verificar correo -->
                                <div class="mb-6">
                                    <button type="submit"
                                        class="w-full cursor-pointer rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-base font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Verificar correo
                                    </button>
                                </div>

                                <!-- Perfil del Usuario -->
                                <div x-show="userFound" x-cloak class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg">
                                            <span x-text="user ? user.name.charAt(0) : ''"></span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="user ? user.name : ''"></h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="user ? user.email : ''"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                DNI: <span x-text="user ? user.dni : ''"></span> • 
                                                <span x-text="user ? user.role : ''"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos de Contraseña (solo se muestran si se encontró el usuario) -->
                                <div x-show="userFound" x-cloak>
                                    <!-- Campo de Contraseña -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Contraseña
                                        </label>
                                        <div class="relative">
                                            <input :type="showPassword ? 'text' : 'password'" 
                                                x-model="password"
                                                @input="checkPasswordStrength()"
                                                autocomplete="new-password"
                                                placeholder="Ingrese su nueva contraseña"
                                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] rounded-lg px-3 py-2.5 pr-10 focus:outline-none placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                :class="password.length > 0 ? (minLength ? 'border-green-500 dark:border-green-500' : 'border-red-500 dark:border-red-500') : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400'">
                                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg x-show="!showPassword" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <svg x-show="showPassword" x-cloak class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Indicador de Fortaleza de Contraseña -->
                                        <div x-show="password.length > 0" x-cloak class="mt-3">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Fortaleza de la contraseña:</span>
                                                <span class="text-xs font-semibold" 
                                                    :class="{
                                                        'text-red-500': passwordStrength > 0 && passwordStrength <= 33,
                                                        'text-yellow-500': passwordStrength > 33 && passwordStrength <= 66,
                                                        'text-green-500': passwordStrength > 66
                                                    }"
                                                    x-text="passwordStrengthText"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="h-2 rounded-full transition-all duration-300"
                                                    :class="passwordStrengthColor"
                                                    :style="'width: ' + passwordStrength + '%'"></div>
                                            </div>
                                            
                                            <!-- Requisito de Contraseña -->
                                            <div class="mt-3">
                                                <div class="flex items-center gap-2 text-xs">
                                                    <svg class="w-4 h-4" :class="minLength ? 'text-green-500' : 'text-gray-400'" fill="currentColor" viewBox="0 0 20 20">
                                                        <path :fill-rule="minLength ? 'evenodd' : ''" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" :clip-rule="minLength ? 'evenodd' : ''"></path>
                                                    </svg>
                                                    <span :class="minLength ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">Mínimo 8 caracteres</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campo de Confirmar Contraseña -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Confirmar Contraseña
                                        </label>
                                        <div class="relative">
                                            <input :type="showConfirmPassword ? 'text' : 'password'" 
                                                x-model="confirmPassword"
                                                @input="checkPasswordsMatch()"
                                                autocomplete="new-password"
                                                placeholder="Confirme su nueva contraseña"
                                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] rounded-lg px-3 py-2.5 pr-10 focus:outline-none placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                :class="confirmPassword.length > 0 ? (passwordsMatch ? 'border-green-500 dark:border-green-500' : 'border-red-500 dark:border-red-500') : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400'">
                                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg x-show="!showConfirmPassword" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <svg x-show="showConfirmPassword" x-cloak class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Mensaje de validación -->
                                        <div x-show="confirmPassword.length > 0" x-cloak class="mt-2">
                                            <div class="flex items-center gap-2 text-xs" :class="passwordsMatch ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path x-show="passwordsMatch" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    <path x-show="!passwordsMatch" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span x-text="passwordsMatch ? 'Las contraseñas coinciden' : 'Las contraseñas no coinciden'"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón de Actualizar contraseña -->
                                    <div class="mb-4">
                                        <button type="button"
                                            class="w-full cursor-pointer rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-base font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Actualizar contraseña
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                <!-- ====== Form Reset Password End ====== -->
            </div>
            <!-- ====== Form Section End ====== -->
        </div>
        <!-- ===== Main Content End ===== -->
    </main>

@endsection
