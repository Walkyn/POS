@extends('layouts.app')
@section('title', 'Crear Producto')

@section('content')
<div x-data="{
    producto: {
        id: null,
        codigo: '',
        nombre: '',
        descripcion: '',
        categoria: '',
        precio: '',
        precio_costo: '',
        precio_venta: '',
        precio_mayoreo: '',
        fecha_vencimiento: '',
        stock: '',
        imagen: null,
        tiene_lotes: false
    },
    lotes: [],
    showCategoriaDropdown: false,
    categorias: ['Electrónica', 'Accesorios', 'Software', 'Hardware', 'Periféricos', 'Componentes'],
    categoriasSeleccionadas: [],
    init() {
        this.categoriasSeleccionadas = [];
    },
    toggleCategoriaDropdown() {
        this.showCategoriaDropdown = !this.showCategoriaDropdown;
    },
    toggleCategoria(categoria) {
        this.categoriasSeleccionadas = [categoria];
        this.producto.categoria = categoria;
        this.showCategoriaDropdown = false;
    },
    cambiarImagen(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona un archivo de imagen válido');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.producto.imagen = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    editingLoteId: null,
    agregarLote() {
            const nuevoId = this.lotes.length > 0 ? Math.max(...this.lotes.map(l => l.id)) + 1 : 1;
            this.lotes.push({
                id: nuevoId,
            numero_lote: this.producto.codigo || '',
            cantidad: null,
            fecha_vencimiento: '',
            precio_costo: null,
            precio_venta: null,
            precio_mayoreo: null
        });
        this.editingLoteId = nuevoId;
    },
    editarLote(lote) {
            this.editingLoteId = lote.id;
    },
    guardarLote(lote) {
        if (lote.cantidad === null || lote.cantidad === undefined || lote.cantidad <= 0) {
            this.loteToValidate = lote;
            this.isValidationLoteModal = true;
            return;
        }
        if (lote.precio_venta === null || lote.precio_venta === undefined || lote.precio_venta <= 0) {
            this.loteToValidate = lote;
            this.isValidationLoteModal = true;
            return;
        }
        this.editingLoteId = null;
        // Siempre agregar una nueva fila vacía después de guardar
        this.agregarLote();
    },
    isDeleteLoteModal: false,
    loteToDelete: null,
    isValidationLoteModal: false,
    loteToValidate: null,
    eliminarLote(lote) {
        // En create, todos los lotes son nuevos (no guardados en DB)
        this.loteToDelete = { ...lote, existe_en_db: false };
        this.isDeleteLoteModal = true;
    },
    confirmDeleteLote() {
        if (this.loteToDelete) {
            this.lotes = this.lotes.filter(l => l.id !== this.loteToDelete.id);
            this.isDeleteLoteModal = false;
            setTimeout(() => { this.loteToDelete = null; }, 200);
            
            // Si no quedan lotes, desmarcar checkbox y cerrar sección
            if (this.lotes.length === 0) {
                this.producto.tiene_lotes = false;
                this.editingLoteId = null;
            } else {
                // Si hay lotes pero ninguno está en edición, agregar una fila vacía para poder agregar más
                const hayLoteEnEdicion = this.lotes.some(l => this.editingLoteId === l.id);
                if (!hayLoteEnEdicion) {
                    this.agregarLote();
                }
            }
        }
    },
    crearProducto() {
        const datosProducto = {
            ...this.producto,
            precio: this.producto.precio_venta || this.producto.precio
        };
        
        let lotesData = [];
        if (this.producto.tiene_lotes) {
            lotesData = this.lotes.map(lote => ({
                numero_lote: lote.numero_lote,
                cantidad: lote.cantidad,
                fecha_vencimiento: lote.fecha_vencimiento || null,
                precio_costo: lote.precio_costo || null,
                precio_venta: lote.precio_venta || null,
                precio_mayoreo: lote.precio_mayoreo || null
            }));
        }
        
        showSuccessToast();
    }
}" 
@click.away="showCategoriaDropdown = false">
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Registrar Producto
                </h2>
                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="{{ route('home') }}">Inicio /</a>
                        </li>
                        <li>
                            <a class="font-medium" href="{{ route('products') }}">Productos /</a>
                        </li>
                        <li class="font-medium text-primary">Registrar</li>
                    </ol>
                </nav>
            </div>

            @include('partials.alerts')

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <!-- Información del Producto -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información del Nuevo Producto</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="font-medium text-gray-900 dark:text-white">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Producto</label>
                                <div class="flex flex-row items-center gap-4">
                                    <div class="h-20 w-20 rounded-md flex-shrink-0 relative group cursor-pointer bg-gray-50 dark:bg-gray-700/50">
                                        <img x-show="producto.imagen" 
                                             :src="producto.imagen" 
                                             :alt="producto.nombre || 'Imagen del producto'" 
                                             class="h-full w-full object-cover rounded-md" />
                                        <div x-show="!producto.imagen" class="h-full w-full flex flex-col items-center justify-center rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-md transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="file" 
                                               @change="cambiarImagen($event)" 
                                               accept="image/*" 
                                               class="hidden" 
                                               id="imagen-producto" 
                                               x-ref="imagenInput">
                                        <div @click="document.getElementById('imagen-producto').click()" class="absolute inset-0 cursor-pointer z-20"></div>
                                    </div>
                                    <div class="flex flex-col flex-1 min-w-0 h-20 justify-center">
                                        <div class="mb-1 md:mb-2">
                                            <input type="text" 
                                                   x-model="producto.codigo"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-500 dark:text-gray-400 font-mono bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-1.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                   placeholder="Código del producto">
                                        </div>
                                        <div>
                                            <input type="text" 
                                                   x-model="producto.nombre"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm font-mono text-black dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-1.5 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"    
                                                   placeholder="Nombre del producto">
                                        </div>
                                    </div>
                                </div>
                                
                                <div x-show="!producto.tiene_lotes" 
                                     x-cloak
                                     class="hidden md:grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Precio Costo</label>
                                        <input type="number" 
                                               x-model="producto.precio_costo"
                                               step="0.01"
                                               min="0"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                               placeholder="0.00">
                                        </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Precio Venta</label>
                                        <input type="number" 
                                               x-model="producto.precio_venta"
                                               step="0.01"
                                               min="0"
                                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                               placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Descripción</label>
                                <textarea x-model="producto.descripcion"
                                          rows="3"
                                          style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                          class="w-full text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 resize-none break-words block placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                          placeholder="Descripción del producto"></textarea>
                                
                                <div x-show="!producto.tiene_lotes" 
                                     x-cloak
                                     class="hidden md:grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Precio Mayoreo</label>
                                        <input type="number" 
                                               x-model="producto.precio_mayoreo"
                                               step="0.01"
                                               min="0"
                                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                               placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Stock</label>
                                        <input type="number" 
                                               x-model="producto.stock"
                                               min="0"
                                               style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                               placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Precios Móvil -->
                        <div x-show="!producto.tiene_lotes" 
                             x-cloak
                             class="md:hidden grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Precio Costo</label>
                                <input type="number" 
                                       x-model="producto.precio_costo"
                                       step="0.01"
                                       min="0"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                       class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Precio Venta</label>
                                <input type="number" 
                                       x-model="producto.precio_venta"
                                       step="0.01"
                                       min="0"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                       class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0.00">
                            </div>
                        </div>
                        
                        <div x-show="!producto.tiene_lotes" 
                             x-cloak
                             class="md:hidden grid grid-cols-2 gap-3 mt-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Precio Mayoreo</label>
                                <input type="number" 
                                       x-model="producto.precio_mayoreo"
                                       step="0.01"
                                       min="0"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                       class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Stock</label>
                                <input type="number" 
                                       x-model="producto.stock"
                                       min="0"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                       class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0">
                            </div>
                        </div>
                        
                        <!-- Categoría y Fecha Vencimiento Móvil -->
                        <div class="md:hidden grid grid-cols-1 gap-3 mt-4">
                            <div class="relative">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Categoría</label>
                                <button @click="showCategoriaDropdown = true"
                                        class="w-full text-left text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 resize-none cursor-pointer block break-words flex items-center justify-between">
                                    <span x-text="producto.categoria || 'Seleccionar categoría'"></span>
                                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div x-show="!producto.tiene_lotes" 
                                 x-cloak>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Fecha Vencimiento
                                </label>
                                <input type="date" 
                                       x-model="producto.fecha_vencimiento"
                                           style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                       class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                            </div>
                                </div>
                                
                        <div class="hidden md:grid grid-cols-2 gap-4 md:mt-4">
                            <div class="relative">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Categoría</label>
                                <div class="relative">
                                    <button @click.stop="toggleCategoriaDropdown()"
                                            class="w-full text-left text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 resize-none cursor-pointer block break-words">
                                        <span x-text="producto.categoria || 'Seleccionar categoría'"></span>
                                        <svg class="absolute right-2 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="showCategoriaDropdown" 
                                         @click.stop
                                         x-cloak
                                         class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-3">
                                        <div class="space-y-1 max-h-32 overflow-y-auto">
                                            <template x-for="categoria in categorias" :key="categoria">
                                                <button @click.stop="toggleCategoria(categoria)"
                                                        class="w-full text-left flex items-center space-x-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded"
                                                        :class="{ 'bg-blue-50 dark:bg-blue-900/20': producto.categoria === categoria }">
                                                    <input type="radio" 
                                                           :value="categoria"
                                                           :checked="producto.categoria === categoria"
                                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                           readonly>
                                                    <span class="text-sm text-gray-900 dark:text-white" x-text="categoria"></span>
                                                </button>
                                            </template>
                                </div>
                                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                                            <button @click.stop="showCategoriaDropdown = false" 
                                                    class="flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-1.5 px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                                                <span>Cerrar</span>
                                            </button>
                            </div>
                        </div>
                    </div>
                </div>

                            <div x-show="!producto.tiene_lotes" 
                                 x-cloak>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Fecha Vencimiento
                                </label>
                                <input type="date" 
                                       x-model="producto.fecha_vencimiento"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                       class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 md:bg-transparent border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg md:rounded px-3 md:px-2 py-2 md:py-2 focus:outline-none focus:ring-2 md:focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400">
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Checkbox Lotes y Botones de Acción -->
                    <div class="border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   x-model="producto.tiene_lotes"
                                   @change="if (producto.tiene_lotes) { if (lotes.length === 0) { agregarLote(); } } else { lotes = []; loteToDelete = null; isDeleteLoteModal = false; editingLoteId = null; }"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">
                                Este producto tiene lotes
                            </span>
                        </label>
                        <div x-show="!producto.tiene_lotes" 
                             x-cloak
                             class="flex flex-row gap-3 w-full md:w-auto md:min-w-[200px] md:justify-end">
                            <a href="{{ route('products') }}" 
                                class="flex-1 md:flex-none flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                                <span>Cancelar</span>
                            </a>
                            <button @click="crearProducto()"
                                    class="flex-1 md:flex-none flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 border border-blue-700 hover:border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700 dark:hover:border-blue-700 dark:focus:ring-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Guardar</span>
                            </button>
                        </div>
                        <div x-show="producto.tiene_lotes" 
                             class="hidden md:flex space-x-4"
                             style="min-width: 200px; visibility: hidden; pointer-events: none;">
                            <a href="{{ route('products') }}" 
                                class="flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                                <span>Cancelar</span>
                            </a>
                            <button @click="crearProducto()"
                                class="flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 border border-blue-700 hover:border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 px-6 text-center dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700 dark:hover:border-blue-700 dark:focus:ring-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                                <span>Guardar</span>
                        </button>
                        </div>
                    </div>
                    </div>

                <!-- Sección de Lotes -->
                <div x-show="producto.tiene_lotes" 
                         x-cloak
                     class="border-gray-200 dark:border-gray-700">
                    <!-- Vista Móvil Lotes -->
                    <div class="md:hidden space-y-4">
                        <template x-for="lote in lotes" :key="lote.id">
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">N° Lote</p>
                                    <div x-show="editingLoteId !== lote.id" class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.numero_lote || '-'"></div>
                                    <input x-show="editingLoteId === lote.id"
                                           x-model="lote.numero_lote"
                                           type="text"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                           class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                           placeholder="N° Lote">
                            </div>
                                
                                <div class="grid grid-cols-3 gap-3 mb-4">
                            <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Costo</p>
                                        <div x-show="editingLoteId !== lote.id" class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.precio_costo !== null && lote.precio_costo !== undefined ? parseFloat(lote.precio_costo).toFixed(2) : '-'"></div>
                                        <input x-show="editingLoteId === lote.id"
                                               :value="lote.precio_costo !== null && lote.precio_costo !== undefined ? lote.precio_costo : ''"
                                               @input="lote.precio_costo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                               type="number" 
                                               min="0" 
                                       step="0.01"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0.00">
                            </div>
                            <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Venta</p>
                                        <div x-show="editingLoteId !== lote.id" class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.precio_venta !== null && lote.precio_venta !== undefined ? parseFloat(lote.precio_venta).toFixed(2) : '-'"></div>
                                        <input x-show="editingLoteId === lote.id"
                                               :value="lote.precio_venta !== null && lote.precio_venta !== undefined ? lote.precio_venta : ''"
                                               @input="lote.precio_venta = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                               type="number" 
                                               min="0" 
                                       step="0.01"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0.00">
                            </div>
                            <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">P. Mayoreo</p>
                                        <div x-show="editingLoteId !== lote.id" class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.precio_mayoreo !== null && lote.precio_mayoreo !== undefined ? parseFloat(lote.precio_mayoreo).toFixed(2) : '-'"></div>
                                        <input x-show="editingLoteId === lote.id"
                                               :value="lote.precio_mayoreo !== null && lote.precio_mayoreo !== undefined ? lote.precio_mayoreo : ''"
                                               @input="lote.precio_mayoreo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                               type="number" 
                                               min="0" 
                                       step="0.01"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0.00">
                            </div>
                        </div>
                                
                                <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock</p>
                                        <div x-show="editingLoteId !== lote.id" class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.cantidad !== null && lote.cantidad !== undefined ? lote.cantidad : '-'"></div>
                                        <input x-show="editingLoteId === lote.id"
                                               :value="lote.cantidad !== null && lote.cantidad !== undefined ? lote.cantidad : ''"
                                               @input="lote.cantidad = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                               type="number" 
                                       min="0"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                       placeholder="0">
                            </div>
                            <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Fecha Vencimiento</p>
                                        <div x-show="editingLoteId !== lote.id" class="text-sm font-semibold text-gray-900 dark:text-white" x-text="lote.fecha_vencimiento ? new Date(lote.fecha_vencimiento).toLocaleDateString('es-PE') : '-'"></div>
                                        <input x-show="editingLoteId === lote.id"
                                               x-model="lote.fecha_vencimiento"
                                               type="date"
                                       style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                               class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                    </div>
                            </div>
                                
                                <div class="flex gap-2">
                                    <button type="button" 
                                            title="Guardar"
                                            x-show="editingLoteId === lote.id"
                                            @click.stop="guardarLote(lote)"
                                            class="flex-1 flex items-center justify-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm p-2 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        
                                    </button>
                                    <button type="button" 
                                            title="Editar"
                                            x-show="editingLoteId !== lote.id"
                                            @click.stop="editarLote(lote)"
                                            class="flex-1 flex items-center justify-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    
                            </button>
                                    <button type="button" 
                                            title="Eliminar"
                                            @click.stop="eliminarLote(lote)"
                                            class="flex-1 flex items-center justify-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                        
                            </button>
                        </div>
                            </div>
                        </template>
                    </div>

                    <!-- Vista Desktop Lotes -->
                    <div class="hidden md:block overflow-x-auto pt-3">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 pl-2 pr-2">N° LOTE</th>
                                    <th scope="col" class="py-3 px-2">P. COSTO</th>
                                    <th scope="col" class="py-3 px-2">P. VENTA</th>
                                    <th scope="col" class="py-3 px-2">P. MAYOREO</th>
                                    <th scope="col" class="py-3 px-2">STOCK</th>
                                    <th scope="col" class="py-3 px-2">FECHA VENCIMIENTO</th>
                                    <th scope="col" class="py-3 px-2">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="lote in lotes" :key="lote.id">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" 
                                        :class="{ 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500': editingLoteId === lote.id }">
                                        <td class="py-3 pl-2 pr-2">
                                            <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="lote.numero_lote || '-'"></span>
                                            <input x-show="editingLoteId === lote.id" 
                                                   x-model="lote.numero_lote"
                                                   type="text"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                   placeholder="N° Lote">
                                        </td>
                                        <td class="py-3 px-2">
                                            <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="lote.precio_costo !== null && lote.precio_costo !== undefined ? parseFloat(lote.precio_costo).toFixed(2) : '-'"></span>
                                            <input x-show="editingLoteId === lote.id" 
                                                   :value="lote.precio_costo !== null && lote.precio_costo !== undefined ? lote.precio_costo : ''"
                                                   @input="lote.precio_costo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                                   type="number" 
                                                   min="0" 
                                                   step="0.01"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                   placeholder="0.00">
                                        </td>
                                        <td class="py-3 px-2">
                                            <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="lote.precio_venta !== null && lote.precio_venta !== undefined ? parseFloat(lote.precio_venta).toFixed(2) : '-'"></span>
                                            <input x-show="editingLoteId === lote.id" 
                                                   :value="lote.precio_venta !== null && lote.precio_venta !== undefined ? lote.precio_venta : ''"
                                                   @input="lote.precio_venta = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                                   type="number" 
                                                   min="0" 
                                                   step="0.01"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                   placeholder="0.00">
                                        </td>
                                        <td class="py-3 px-2">
                                            <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="lote.precio_mayoreo !== null && lote.precio_mayoreo !== undefined ? parseFloat(lote.precio_mayoreo).toFixed(2) : '-'"></span>
                                            <input x-show="editingLoteId === lote.id" 
                                                   :value="lote.precio_mayoreo !== null && lote.precio_mayoreo !== undefined ? lote.precio_mayoreo : ''"
                                                   @input="lote.precio_mayoreo = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                                   type="number" 
                                                   min="0" 
                                                   step="0.01"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                   placeholder="0.00">
                                        </td>
                                        <td class="py-3 px-2">
                                            <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="lote.cantidad !== null && lote.cantidad !== undefined ? lote.cantidad : '-'"></span>
                                            <input x-show="editingLoteId === lote.id" 
                                                   :value="lote.cantidad !== null && lote.cantidad !== undefined ? lote.cantidad : ''"
                                                   @input="lote.cantidad = $event.target.value === '' ? null : parseFloat($event.target.value) || 0"
                                                   type="number" 
                                                   min="0"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                                   placeholder="0">
                                        </td>
                                        <td class="py-3 px-2">
                                            <span x-show="editingLoteId !== lote.id" class="text-sm text-gray-900 dark:text-white" x-text="lote.fecha_vencimiento ? new Date(lote.fecha_vencimiento).toLocaleDateString('es-PE') : '-'"></span>
                                            <input x-show="editingLoteId === lote.id" 
                                                   x-model="lote.fecha_vencimiento"
                                                   type="date"
                                                   style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;"
                                                   class="w-full text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-[0.5px] border-gray-300 dark:border-gray-600 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-400">
                                        </td>
                                        <td class="py-3 px-2">
                                            <div class="flex items-center space-x-2">
                                                <button type="button" 
                                                        title="Editar"
                                                        x-show="editingLoteId !== lote.id"
                                                        @click.stop="editarLote(lote)"
                                                        class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm p-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </button>
                                                <button type="button" 
                                                        title="Guardar"
                                                        x-show="editingLoteId === lote.id"
                                                        @click.stop="guardarLote(lote)"
                                                        class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded text-sm p-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                                <button type="button" 
                                                        title="Eliminar"
                                                        @click.stop="eliminarLote(lote)"
                                                        class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
        </div>

        <!-- Botones de Acción cuando hay Lotes -->
        <div x-show="producto.tiene_lotes" class="mt-6 md:p-0">
                    <div class="flex gap-2 md:justify-end md:space-x-4">
                        <a href="{{ route('products') }}" 
                            class="flex-1 md:flex-none flex items-center justify-center text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm p-2.5 md:py-2.5 md:px-6 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900">
                            <span>Cancelar</span>
                        </a>
                        <button @click="crearProducto()"
                                class="flex-1 md:flex-none flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 border border-blue-700 hover:border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 md:py-2.5 md:px-6 text-center dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700 dark:hover:border-blue-700 dark:focus:ring-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            <span>Guardar</span>
                        </button>
                                    </div>
                                </div>
                                    </div>
                                </div>
    </main>

    {{-- Modales --}}
    @include('products.modals.select-category')
    @include('products.modals.validation-lote')
    @include('products.modals.delete-lote')
@endsection

<script>
    function showSuccessToast() {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-[99999]';
        toast.innerHTML = '<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span class="sr-only">Check icon</span></div><div class="ms-3 text-sm font-normal">Producto creado correctamente.</div><button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.remove()"><span class="sr-only">Close</span><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

