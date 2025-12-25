<!-- Modal de Conexión Base de Datos -->
<div x-show="isRestoreDbModal" 
     x-cloak
     class="fixed inset-0 z-[10000] md:flex md:items-center md:justify-center pointer-events-none">
    
    <!-- Modal Desktop - Centrado -->
    <div x-show="isRestoreDbModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop
         class="hidden md:block no-scrollbar relative w-full max-w-[600px] overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl dark:bg-gray-900 mx-4 pointer-events-auto">

        <!-- Header -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 sm:pb-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Restaurar Base de Datos
            </h3>
            <button @click="isRestoreDbModal = false"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-4 sm:p-6 lg:p-8">
            <form x-data="{ 
                selectedFile: null,
                fileName: 'Sin archivos seleccionados',
                dbHost: '',
                dbPort: '3306',
                dbName: '',
                dbUser: '',
                dbPassword: '',
                showPassword: false,
                selectFile() {
                    const input = document.getElementById('backup-file-input');
                    if (input) {
                        input.click();
                    }
                },
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.selectedFile = file;
                        this.fileName = file.name;
                    }
                }
            }">
                <!-- Seleccionar archivo de respaldo -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Seleccionar archivo de respaldo (.sql)
                    </label>
                    <div class="relative">
                        <input type="file"
                            id="backup-file-input"
                            accept=".sql"
                            @change="handleFileSelect($event)"
                            class="hidden">
                        <div class="flex items-center bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 dark:focus-within:ring-blue-400 focus-within:border-blue-500 dark:focus-within:border-blue-400 transition-all">
                            <input type="text"
                                :value="fileName"
                                readonly
                                class="flex-1 text-sm text-gray-500 dark:text-gray-400 bg-transparent px-3 py-2.5 focus:outline-none cursor-pointer border-0"
                                @click="selectFile()">
                            <button type="button"
                                @click="selectFile()"
                                class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors flex items-center gap-2 border-0 rounded-r-lg">
                                <i class="fas fa-folder-open text-xs"></i>
                                <span>Buscar</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Datos de conexión -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Datos de conexión
                    </h4>
                    
                    <div class="space-y-4">
                        <!-- Fila 1: Host y Puerto -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Host -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-server mr-2 text-gray-400"></i>
                                    Host
                                </label>
                                <input type="text"
                                    x-model="dbHost"
                                    autocomplete="url"
                                    placeholder="www.ztx.es"
                                    class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                            </div>

                            <!-- Puerto -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-network-wired mr-2 text-gray-400"></i>
                                    Puerto
                                </label>
                                <input type="text"
                                    x-model="dbPort"
                                    autocomplete="off"
                                    placeholder="3306"
                                    class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                            </div>
                        </div>

                        <!-- Fila 2: Base de Datos y Usuario -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Base de Datos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-database mr-2 text-gray-400"></i>
                                    Base de Datos
                                </label>
                                <input type="text"
                                    x-model="dbName"
                                    autocomplete="off"
                                    placeholder="ztx_bm"
                                    class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                            </div>

                            <!-- Usuario -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Usuario
                                </label>
                                <input type="text"
                                    x-model="dbUser"
                                    autocomplete="username"
                                    placeholder="ztx_admin"
                                    class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-key mr-2 text-gray-400"></i>
                                Contraseña
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'"
                                    x-model="dbPassword"
                                    autocomplete="current-password"
                                    placeholder="Ingrese la contraseña"
                                    class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                                <button type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-3 justify-end">
                    <button type="button"
                        @click="isRestoreDbModal = false"
                        class="px-4 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                        Restaurar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Móvil - Bottom Sheet estilo Android -->
    <div x-show="isRestoreDbModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         @click.stop
         class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white dark:bg-gray-900 rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col pointer-events-auto">
        
        <!-- Handle Bar -->
        <div class="flex justify-center pt-3 pb-2 py-4">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full cursor-pointer" @click.stop="isRestoreDbModal = false"></div>
        </div>

        <!-- Header Móvil -->
        <div class="px-5 pt-2 pb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Restaurar Base de Datos
                </h3>
            </div>
        </div>

        <!-- Contenido con scroll Móvil -->
        <div class="flex-1 overflow-y-auto px-5 py-4" @click.stop>
            <form x-data="{ 
                selectedFile: null,
                fileName: 'Sin archivos seleccionados',
                dbHost: '',
                dbPort: '3306',
                dbName: '',
                dbUser: '',
                dbPassword: '',
                showPassword: false,
                selectFile() {
                    const input = document.getElementById('backup-file-input-mobile');
                    if (input) {
                        input.click();
                    }
                },
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.selectedFile = file;
                        this.fileName = file.name;
                    }
                }
            }">
                <!-- Seleccionar archivo de respaldo -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Seleccionar archivo de respaldo (.sql)
                    </label>
                    <div class="relative">
                        <input type="file"
                            id="backup-file-input-mobile"
                            accept=".sql"
                            @change="handleFileSelect($event)"
                            class="hidden">
                        <div class="flex items-center bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 dark:focus-within:ring-blue-400 focus-within:border-blue-500 dark:focus-within:border-blue-400 transition-all">
                            <input type="text"
                                :value="fileName"
                                readonly
                                class="flex-1 text-sm text-gray-500 dark:text-gray-400 bg-transparent px-3 py-2.5 focus:outline-none cursor-pointer border-0"
                                @click="selectFile()">
                            <button type="button"
                                @click="selectFile()"
                                class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors flex items-center gap-2 border-0 rounded-r-lg">
                                <i class="fas fa-folder-open text-xs"></i>
                                <span>Buscar</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Datos de conexión -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Datos de conexión
                    </h4>
                    
                    <div class="space-y-4">
                        <!-- Host -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-server mr-2 text-gray-400"></i>
                                Host
                            </label>
                            <input type="text"
                                x-model="dbHost"
                                autocomplete="url"
                                placeholder="www.ztx.es"
                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                        </div>

                        <!-- Puerto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-network-wired mr-2 text-gray-400"></i>
                                Puerto
                            </label>
                            <input type="text"
                                x-model="dbPort"
                                autocomplete="off"
                                placeholder="3306"
                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                        </div>

                        <!-- Base de Datos -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-database mr-2 text-gray-400"></i>
                                Base de Datos
                            </label>
                            <input type="text"
                                x-model="dbName"
                                autocomplete="off"
                                placeholder="ztx_bm"
                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                        </div>

                        <!-- Usuario -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-2 text-gray-400"></i>
                                Usuario
                            </label>
                            <input type="text"
                                x-model="dbUser"
                                autocomplete="username"
                                placeholder="ztx_admin"
                                class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-key mr-2 text-gray-400"></i>
                                Contraseña
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'"
                                    x-model="dbPassword"
                                    autocomplete="current-password"
                                    placeholder="Ingrese la contraseña"
                                    class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60">
                                <button type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex flex-col gap-3">
                    <button type="submit"
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                        Restaurar
                    </button>
                    <button type="button"
                        @click="isRestoreDbModal = false"
                        class="w-full px-4 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

