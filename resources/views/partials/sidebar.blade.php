<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="flex items-center gap-2 pt-4 sidebar-header pb-4 px-6">
        <a href="index.html" class="flex items-center gap-3">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img src="{{ asset('images/logo/logo.ico') }}" width="40" height="40" alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('images/logo/logo.ico') }}" width="40" height="40" alt="Logo" />

            <!-- Texto BUSINESS MANAGER -->
            <span class="text-sm font-bold tracking-widest text-white drop-shadow-sm whitespace-nowrap"
                :class="sidebarToggle ? 'lg:hidden' : ''"
                style="font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, sans-serif;">
                BUSINESS MANAGER
            </span>
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="mt-5 px-4 lg:mt-9 lg:px-6" x-data="{ 
            selected: $persist('Dashboard'),
            turnoOpen: false,
            toggleTurno() {
                this.turnoOpen = !this.turnoOpen;
                this.selected = 'Forms';
            }
        }">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MENU</h3>

                <ul class="mb-6 flex flex-col gap-1.5">
                    <!-- Menu Item Dashboard -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('home') }}" @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') }">
                            <i class="fas fa-tachometer-alt text-lg w-5 flex items-center justify-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <!-- Menu Item Dashboard -->

                    <!-- Menu Item Ventas -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="#" @click.prevent="selected = (selected === 'Forms' ? '':'Forms')"
                            :class="{
                                'bg-graydark dark:bg-meta-4': (selected === 'Forms') || (page === 'formElements' ||
                                    page === 'formLayout' || page === 'sales.create' || page === 'sales' || page === 'sales.close-shift' || page === 'sales.shift-history')
                            }">
                            <i class="fas fa-shopping-cart text-lg w-5 flex items-center justify-center"></i>
                            <span>Ventas</span>

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                :class="{ 'rotate-180': (selected === 'Forms') || (page === 'sales.create' || page === 'sales' || page === 'sales.close-shift' || page === 'sales.shift-history') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill="" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                            :class="(selected === 'Forms') || (page === 'sales.create' || page === 'sales' || page === 'sales.close-shift' || page === 'sales.shift-history') ? 'block' : 'hidden'">
                            <ul class="mb-5.5 mt-4 flex flex-col gap-2.5 pl-8">
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('sales.create') }}" :class="page === 'sales.create' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'sales.create' && '!text-white'">•</span>
                                        <span>Nueva Venta</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('sales') }}" :class="page === 'sales' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'sales' && '!text-white'">•</span>
                                        <span>Historial</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="#" @click.prevent.stop="toggleTurno()"
                                        :class="{
                                            '!text-white': turnoOpen || (page === 'sales.close-shift' || page === 'sales.shift-history')
                                        }">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="turnoOpen || (page === 'sales.close-shift' || page === 'sales.shift-history') && '!text-white'">•</span>
                                        <span>Turnos</span>
                                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current w-4 h-4"
                                            :class="{ 'rotate-180': turnoOpen || (page === 'sales.close-shift' || page === 'sales.shift-history') }" width="16" height="16"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                                fill="" />
                                        </svg>
                                    </a>
                                    <!-- Submenu Turno -->
                                    <div class="translate transform overflow-hidden"
                                        :class="turnoOpen || (page === 'sales.close-shift' || page === 'sales.shift-history') ? 'block' : 'hidden'">
                                        <ul class="mb-2 mt-2 flex flex-col gap-2 pl-8">
                                            <li>
                                                <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                                    href="{{ route('sales.close-shift') }}" :class="page === 'sales.close-shift' && '!text-white'">
                                                    <span class="w-3 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'sales.close-shift' && '!text-white'">◦</span>
                                                    <span>Cierre</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                                    href="{{ route('sales.shift-history') }}" :class="page === 'sales.shift-history' && '!text-white'">
                                                    <span class="w-3 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'sales.shift-history' && '!text-white'">◦</span>
                                                    <span>Historial</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Forms -->

                    <!-- Menu Item Productos -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('products') }}" @click="selected = (selected === 'Products' ? '':'Products')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Products') && (page === 'products') }"
                            :class="page === 'products' && 'bg-graydark'">
                            <i class="fas fa-box text-lg w-5 flex items-center justify-center"></i>
                            <span>Productos</span>
                        </a>
                    </li>
                    <!-- Menu Item Productos -->

                    <!-- Menu Item Clientes -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('customers') }}" @click="selected = (selected === 'Customers' ? '':'Customers')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Customers') && (page === 'customers') }"
                            :class="page === 'customers' && 'bg-graydark'">
                            <i class="fas fa-user-friends text-lg w-5 flex items-center justify-center"></i>
                            <span>Clientes</span>
                        </a>
                    </li>
                    <!-- Menu Item Clientes -->

                    <!-- Menu Item Administrar -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="#" @click.prevent="selected = (selected === 'Administrar' ? '':'Administrar')"
                            :class="{
                                'bg-graydark dark:bg-meta-4': (selected === 'Administrar') || (page === 'reports' ||
                                    page === 'inventario' || page === 'informes')
                            }">
                            <i class="fas fa-tasks text-lg w-5 flex items-center justify-center"></i>
                            <span>Administrar</span>

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                :class="{ 'rotate-180': (selected === 'Administrar') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill="" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                            :class="(selected === 'Administrar') ? 'block' : 'hidden'">
                            <ul class="mb-5.5 mt-4 flex flex-col gap-2.5 pl-8">
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('inventory') }}" :class="page === 'inventario' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'inventario' && '!text-white'">•</span>
                                        <span>Inventario</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('reports') }}" :class="page === 'reports' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'reports' && '!text-white'">•</span>
                                        <span>Reportes</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('informes') }}" :class="page === 'informes' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'informes' && '!text-white'">•</span>
                                        <span>Informes</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Administrar -->

                    <!-- Menu Item Settings -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('settings') }}"
                            :class="{ 'bg-graydark dark:bg-meta-4': page === 'settings' }">
                            <i class="fas fa-cog text-lg w-5 flex items-center justify-center"></i>
                            <span>Configuraciones</span>
                        </a>
                    </li>
                    <!-- Menu Item Settings -->
                </ul>
            </div>

            <!-- Others Group -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">OTROS</h3>

                <ul class="mb-6 flex flex-col gap-1.5">
                    <!-- Menu Item Base de Datos -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('database') }}"
                            :class="{ 'bg-graydark dark:bg-meta-4': page === 'database' }">
                            <i class="fas fa-database text-lg w-5 flex items-center justify-center"></i>
                            <span>Base de Datos</span>
                        </a>
                    </li>
                    <!-- Menu Item Base de Datos -->

                    <!-- Menu Item Ui Elements -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="#" @click.prevent="selected = (selected === 'UiElements' ? '':'UiElements')"
                            :class="{
                                'bg-graydark dark:bg-meta-4': (selected === 'UiElements') || (page === 'alerts' ||
                                    page === 'buttons')
                            }">
                            <svg class="fill-current w-5 h-5 flex-shrink-0" viewBox="0 0 18 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_130_9807)">
                                    <path
                                        d="M15.7501 0.55835H2.2501C1.29385 0.55835 0.506348 1.34585 0.506348 2.3021V7.53335C0.506348 8.4896 1.29385 9.2771 2.2501 9.2771H15.7501C16.7063 9.2771 17.4938 8.4896 17.4938 7.53335V2.3021C17.4938 1.34585 16.7063 0.55835 15.7501 0.55835ZM16.2563 7.53335C16.2563 7.8146 16.0313 8.0396 15.7501 8.0396H2.2501C1.96885 8.0396 1.74385 7.8146 1.74385 7.53335V2.3021C1.74385 2.02085 1.96885 1.79585 2.2501 1.79585H15.7501C16.0313 1.79585 16.2563 2.02085 16.2563 2.3021V7.53335Z"
                                        fill="" />
                                    <path
                                        d="M6.13135 10.9646H2.2501C1.29385 10.9646 0.506348 11.7521 0.506348 12.7083V15.8021C0.506348 16.7583 1.29385 17.5458 2.2501 17.5458H6.13135C7.0876 17.5458 7.8751 16.7583 7.8751 15.8021V12.7083C7.90322 11.7521 7.11572 10.9646 6.13135 10.9646ZM6.6376 15.8021C6.6376 16.0833 6.4126 16.3083 6.13135 16.3083H2.2501C1.96885 16.3083 1.74385 16.0833 1.74385 15.8021V12.7083C1.74385 12.4271 1.96885 12.2021 2.2501 12.2021H6.13135C6.4126 12.2021 6.6376 12.4271 6.6376 12.7083V15.8021Z"
                                        fill="" />
                                    <path
                                        d="M15.75 10.9646H11.8688C10.9125 10.9646 10.125 11.7521 10.125 12.7083V15.8021C10.125 16.7583 10.9125 17.5458 11.8688 17.5458H15.75C16.7063 17.5458 17.4938 16.7583 17.4938 15.8021V12.7083C17.4938 11.7521 16.7063 10.9646 15.75 10.9646ZM16.2562 15.8021C16.2562 16.0833 16.0312 16.3083 15.75 16.3083H11.8688C11.5875 16.3083 11.3625 16.0833 11.3625 15.8021V12.7083C11.3625 12.4271 11.5875 12.2021 11.8688 12.2021H15.75C16.0312 12.2021 16.2562 12.4271 16.2562 12.7083V15.8021Z"
                                        fill="" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_130_9807">
                                        <rect width="18" height="18" fill="white"
                                            transform="translate(0 0.052124)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>UI Elements</span>

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                :class="{ 'rotate-180': (selected === 'UiElements') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill="" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                            :class="(selected === 'UiElements') ? 'block' : 'hidden'">
                            <ul class="mb-3 mt-4 flex flex-col gap-2 pl-8">
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="alerts.html" :class="page === 'alerts' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'alerts' && '!text-white'">•</span>
                                        <span>Alerts</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="buttons.html" :class="page === 'buttons' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'buttons' && '!text-white'">•</span>
                                        <span>Buttons</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Ui Elements -->

                    <!-- Menu Item Auth Pages -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="#" @click.prevent="selected = (selected === 'AuthPages' ? '':'AuthPages')"
                            :class="{
                                'bg-graydark dark:bg-meta-4': (selected === 'AuthPages') || (page === 'register' ||
                                    page === 'login' || page === 'usuarios' || page === 'restablecer-password')
                            }">
                            <i class="fas fa-user-shield text-lg w-5 flex items-center justify-center"></i>
                            <span>Autenticación</span>

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                :class="{ 'rotate-180': (selected === 'AuthPages') || (page === 'usuarios' || page === 'register' || page === 'restablecer-password') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill="" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                            :class="(selected === 'AuthPages') || (page === 'usuarios' || page === 'register' || page === 'restablecer-password') ? 'block' : 'hidden'">
                            <ul class="mb-3 mt-4 flex flex-col gap-2 pl-8">
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('users') }}" :class="page === 'usuarios' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'usuarios' && '!text-white'">•</span>
                                        <span>Usuarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('users.create') }}" :class="page === 'register' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'register' && '!text-white'">•</span>
                                        <span>Registrar</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('users.reset-password') }}" :class="page === 'restablecer-password' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'restablecer-password' && '!text-white'">•</span>
                                        <span>Contraseña</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Auth Pages -->
                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu -->

    </div>
</aside>
