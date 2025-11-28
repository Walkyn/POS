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
                                        <span>Turno</span>
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
                                        <ul class="mb-2 mt-2 flex flex-col gap-2 pl-6">
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
                                        href="informes.html" :class="page === 'informes' && '!text-white'">
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
                            href="settings.html" @click="selected = (selected === 'Settings' ? '':'Settings')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Settings') && (page === 'settings') }"
                            :class="page === 'settings' && 'bg-graydark'">
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
                    <!-- Menu Item Chart -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="chart.html" @click="selected = (selected === 'Chart' ? '':'Chart')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Chart') && (page === 'Chart') }">
                            <svg class="fill-current w-5 h-5 flex-shrink-0" viewBox="0 0 18 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_130_9801)">
                                    <path
                                        d="M10.8563 0.55835C10.5188 0.55835 10.2095 0.8396 10.2095 1.20522V6.83022C10.2095 7.16773 10.4907 7.4771 10.8563 7.4771H16.8751C17.0438 7.4771 17.2126 7.39272 17.3251 7.28022C17.4376 7.1396 17.4938 6.97085 17.4938 6.8021C17.2688 3.28647 14.3438 0.55835 10.8563 0.55835ZM11.4751 6.15522V1.8521C13.8095 2.13335 15.6938 3.8771 16.1438 6.18335H11.4751V6.15522Z"
                                        fill="" />
                                    <path
                                        d="M15.3845 8.7427H9.1126V2.69582C9.1126 2.35832 8.83135 2.07707 8.49385 2.07707C8.40947 2.07707 8.3251 2.07707 8.24072 2.07707C3.96572 2.04895 0.506348 5.53645 0.506348 9.81145C0.506348 14.0864 3.99385 17.5739 8.26885 17.5739C12.5438 17.5739 16.0313 14.0864 16.0313 9.81145C16.0313 9.6427 16.0313 9.47395 16.0032 9.33332C16.0032 8.99582 15.722 8.7427 15.3845 8.7427ZM8.26885 16.3083C4.66885 16.3083 1.77197 13.4114 1.77197 9.81145C1.77197 6.3802 4.47197 3.53957 7.8751 3.3427V9.36145C7.8751 9.69895 8.15635 10.0083 8.52197 10.0083H14.7938C14.6813 13.4958 11.7845 16.3083 8.26885 16.3083Z"
                                        fill="" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_130_9801">
                                        <rect width="18" height="18" fill="white"
                                            transform="translate(0 0.052124)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>Chart</span>
                        </a>
                    </li>
                    <!-- Menu Item Chart -->

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
                                    page === 'login')
                            }">
                            <svg class="fill-current w-5 h-5 flex-shrink-0" viewBox="0 0 18 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_130_9814)">
                                    <path
                                        d="M12.7127 0.55835H9.53457C8.80332 0.55835 8.18457 1.1771 8.18457 1.90835V3.84897C8.18457 4.18647 8.46582 4.46772 8.80332 4.46772C9.14082 4.46772 9.45019 4.18647 9.45019 3.84897V1.88022C9.45019 1.82397 9.47832 1.79585 9.53457 1.79585H12.7127C13.3877 1.79585 13.9221 2.33022 13.9221 3.00522V15.0709C13.9221 15.7459 13.3877 16.2802 12.7127 16.2802H9.53457C9.47832 16.2802 9.45019 16.2521 9.45019 16.1959V14.2552C9.45019 13.9177 9.16894 13.6365 8.80332 13.6365C8.43769 13.6365 8.18457 13.9177 8.18457 14.2552V16.1959C8.18457 16.9271 8.80332 17.5459 9.53457 17.5459H12.7127C14.0908 17.5459 15.1877 16.4209 15.1877 15.0709V3.03335C15.1877 1.65522 14.0627 0.55835 12.7127 0.55835Z"
                                        fill="" />
                                    <path
                                        d="M10.4346 8.60205L7.62207 5.7333C7.36895 5.48018 6.97519 5.48018 6.72207 5.7333C6.46895 5.98643 6.46895 6.38018 6.72207 6.6333L8.46582 8.40518H3.45957C3.12207 8.40518 2.84082 8.68643 2.84082 9.02393C2.84082 9.36143 3.12207 9.64268 3.45957 9.64268H8.49395L6.72207 11.4427C6.46895 11.6958 6.46895 12.0896 6.72207 12.3427C6.83457 12.4552 7.00332 12.5114 7.17207 12.5114C7.34082 12.5114 7.50957 12.4552 7.62207 12.3145L10.4346 9.4458C10.6877 9.24893 10.6877 8.85518 10.4346 8.60205Z"
                                        fill="" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_130_9814">
                                        <rect width="18" height="18" fill="white"
                                            transform="translate(0 0.052124)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>Authentication</span>

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                :class="{ 'rotate-180': (selected === 'AuthPages') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill="" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                            :class="(selected === 'AuthPages') ? 'block' : 'hidden'">
                            <ul class="mb-3 mt-4 flex flex-col gap-2 pl-8">
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="signin.html" :class="page === 'signin' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'signin' && '!text-white'">•</span>
                                        <span>Sign In</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-1 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="signup.html" :class="page === 'signup' && '!text-white'">
                                        <span class="w-5 flex items-center justify-center text-bodydark2 group-hover:text-white" :class="page === 'signup' && '!text-white'">•</span>
                                        <span>Sign Up</span>
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
