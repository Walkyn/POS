<main class="h-full pb-16 overflow-y-auto" 
      x-data="{ 
    productosTicket: [],
    codigoBarras: '',
    clienteNombre: '',
    isPaymentModal: false,
    isDeleteItemModal: false,
    isClearTicketModal: false,
    isMayoreoModal: false,
    isSearchModal: false,
    isSearchCustomerModal: false,
    isAlertModal: false,
    alertMessage: '',
    itemToDelete: null,
    productoMayoreo: null,
    selectedPriceIndex: 0, // 0 = Precio Normal, 1 = Precio Mayoreo
    productoSeleccionado: null,
    searchQuery: '',
    selectedIndex: -1,
    customerSearchQuery: '',
    selectedCustomerIndex: -1,
    clientesDisponibles: [
        {
            id: 1,
            nombre: 'Juan Martínez',
            dni: '12345678',
            telefono: '+51 987 654 321',
            direccion: 'Av. Principal 123',
            distrito: 'Lima',
            provincia: 'Lima'
        },
        {
            id: 2,
            nombre: 'María López',
            dni: '87654321',
            telefono: '+51 987 123 456',
            direccion: 'Calle Los Olivos 456',
            distrito: 'Yanahuara',
            provincia: 'Arequipa'
        },
        {
            id: 3,
            nombre: 'Carlos Rodríguez',
            dni: '11223344',
            telefono: '+51 987 555 789',
            direccion: 'Jr. San Martín 789',
            distrito: 'Miraflores',
            provincia: 'Lima'
        }
    ],
    clientesFiltrados: [],
    productosDisponibles: [
        {
            id: 1,
            nombre: 'Laptop Dell Inspiron 15',
            codigo: '1234567890123',
            categoria: 'Electrónica',
            descripcion: 'Laptop de 15 pulgadas con procesador Intel Core i7, 16GB RAM, 512GB SSD',
            stock: 25,
            precio: 1200.00,
            precio_mayoreo: 1000.00,
            numero_lote: 'LOTE-0001',
            fecha_vencimiento: '2024-12-31',
            imagen: '{{ asset('images/product/product-01.png') }}'
        },
        {
            id: 2,
            nombre: 'Mouse Inalámbrico Logitech',
            codigo: '9876543210987',
            categoria: 'Accesorios',
            descripcion: 'Mouse inalámbrico ergonómico con sensor óptico de alta precisión',
            stock: 50,
            precio: 45.00,
            precio_mayoreo: 38.00,
            numero_lote: 'LOTE-0002',
            fecha_vencimiento: '2025-03-15',
            imagen: '{{ asset('images/product/product-01.png') }}'
        },
        {
            id: 3,
            nombre: 'Teclado Mecánico RGB',
            codigo: '5555555555555',
            categoria: 'Accesorios',
            descripcion: 'Teclado mecánico con switches Cherry MX, retroiluminación RGB personalizable',
            stock: 30,
            precio: 150.00,
            precio_mayoreo: 120.00,
            numero_lote: 'LOTE-0003',
            fecha_vencimiento: '2025-06-20',
            imagen: '{{ asset('images/product/product-01.png') }}'
        },
        {
            id: 4,
            nombre: 'Monitor LG 24 pulgadas',
            codigo: '1111111111111',
            categoria: 'Electrónica',
            descripcion: 'Monitor Full HD de 24 pulgadas con tecnología IPS y tiempo de respuesta de 1ms',
            stock: 15,
            precio: 350.00,
            precio_mayoreo: 300.00,
            numero_lote: 'LOTE-0004',
            fecha_vencimiento: '2025-08-10',
            imagen: '{{ asset('images/product/product-01.png') }}'
        },
        {
            id: 5,
            nombre: 'Auriculares Sony WH-1000XM4',
            codigo: '2222222222222',
            categoria: 'Audio',
            descripcion: 'Auriculares inalámbricos con cancelación de ruido activa y batería de 30 horas',
            stock: 20,
            precio: 450.00,
            precio_mayoreo: 380.00,
            numero_lote: 'LOTE-0005',
            fecha_vencimiento: '2025-09-30',
            imagen: '{{ asset('images/product/product-01.png') }}'
        }
    ],
    productosFiltrados: [],
    tipoPago: 'efectivo',
    montoRecibido: '',
    descuento: '',
    montoRecibidoModificadoManual: false,
    init() {
        // Cargar ticket desde localStorage
        this.cargarTicketDesdeStorage();
        
        // Prevenir F10 y F11 (pantalla completa) y asignar funcionalidades
        document.addEventListener('keydown', (e) => {
            if (e.key === 'F10') {
                e.preventDefault();
                this.abrirModalBusqueda();
            }
            if (e.key === 'F11') {
                e.preventDefault();
                if (this.productosTicket.length > 0) {
                    this.abrirModalMayoreo();
                }
            }
        });
        
        // Inicializar productos filtrados con todos los productos
        if (this.productosDisponibles && Array.isArray(this.productosDisponibles)) {
            this.productosFiltrados = [...this.productosDisponibles];
        } else {
            this.productosFiltrados = [];
        }
        
        // Inicializar clientes filtrados con todos los clientes
        if (this.clientesDisponibles && Array.isArray(this.clientesDisponibles)) {
            this.clientesFiltrados = [...this.clientesDisponibles];
        } else {
            this.clientesFiltrados = [];
        }
        
        // Guardar ticket en localStorage cuando cambie
        this.$watch('productosTicket', () => {
            this.guardarTicketEnStorage();
            // Si hay descuento y el monto recibido no fue modificado manualmente, actualizarlo al total
            if (this.descuento && parseFloat(this.descuento) > 0 && !this.montoRecibidoModificadoManual) {
                this.$nextTick(() => {
                    this.montoRecibido = this.total;
                });
            }
        });
        this.$watch('clienteNombre', () => {
            this.guardarTicketEnStorage();
        });
        this.$watch('descuento', () => {
            this.guardarTicketEnStorage();
            // Si hay descuento y el monto recibido no fue modificado manualmente, actualizarlo al total
            if (this.descuento && parseFloat(this.descuento) > 0 && !this.montoRecibidoModificadoManual) {
                this.$nextTick(() => {
                    this.montoRecibido = this.total;
                });
            }
        });
        
        // Enfocar el input de código de barras después de la inicialización (solo desktop)
        this.enfocarInputCodigoBarras();
        
        // Volver a enfocar cuando se cierren los modales (solo desktop)
        this.$watch('isSearchModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        this.$watch('isSearchCustomerModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        this.$watch('isPaymentModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        this.$watch('isMayoreoModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        this.$watch('isDeleteItemModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        this.$watch('isClearTicketModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        this.$watch('isAlertModal', (isOpen) => {
            if (!isOpen) {
                setTimeout(() => {
                    this.enfocarInputCodigoBarras();
                }, 300);
            }
        });
        
        // Listener global de clic para mantener el foco en el input (solo desktop)
        if (window.innerWidth >= 768) {
            document.addEventListener('click', (e) => {
                // Solo si no hay modales abiertos
                if (!this.isSearchModal && !this.isSearchCustomerModal && !this.isPaymentModal && 
                    !this.isMayoreoModal && !this.isDeleteItemModal && !this.isClearTicketModal && !this.isAlertModal) {
                    // Si el clic no fue en un botón, input, o dentro de un modal
                    if (!e.target.closest('button') && !e.target.closest('input') && 
                        !e.target.closest('textarea') && !e.target.closest('.modal-content') &&
                        !e.target.closest('[x-show]') && e.target !== this.$refs.codigoBarrasInput) {
                        setTimeout(() => {
                            this.enfocarInputCodigoBarras();
                        }, 50);
                    }
                }
            });
        }
    },
    guardarTicketEnStorage() {
        const ticketData = {
            productosTicket: this.productosTicket,
            clienteNombre: this.clienteNombre,
            descuento: this.descuento
        };
        localStorage.setItem('pos_ticket', JSON.stringify(ticketData));
    },
    cargarTicketDesdeStorage() {
        try {
            const savedData = localStorage.getItem('pos_ticket');
            if (savedData) {
                const ticketData = JSON.parse(savedData);
                if (ticketData.productosTicket && Array.isArray(ticketData.productosTicket)) {
                    this.productosTicket = ticketData.productosTicket;
                }
                if (ticketData.clienteNombre) {
                    this.clienteNombre = ticketData.clienteNombre;
                }
                if (ticketData.descuento !== undefined) {
                    this.descuento = ticketData.descuento;
                }
            }
        } catch (error) {
            console.error('Error al cargar ticket desde localStorage:', error);
        }
    },
    limpiarTicketStorage() {
        localStorage.removeItem('pos_ticket');
    },
    agregarProducto(codigo) {
        // Simulación: agregar producto al ticket
        const producto = {
            id: Date.now(),
            codigo: codigo || '1234567890123',
            nombre: 'Laptop Dell Inspiron 15',
            precio: 1200.00,
            precio_mayoreo: 1000.00, // Precio mayoreo (más bajo)
            precio_actual: 1200.00, // Precio que se está usando actualmente
            es_mayoreo: false, // Indica si está usando precio mayoreo
            cantidad: 1,
            stock: 25,
            subtotal: 1200.00
        };
        this.productosTicket.push(producto);
        this.codigoBarras = '';
        // Volver a enfocar el input después de agregar (solo desktop)
        this.enfocarInputCodigoBarras();
    },
    eliminarProducto(id) {
        const producto = this.productosTicket.find(p => p.id === id);
        if (producto) {
            this.itemToDelete = producto;
            this.isDeleteItemModal = true;
        }
    },
    confirmDeleteItem() {
        if (this.itemToDelete) {
            this.productosTicket = this.productosTicket.filter(p => p.id !== this.itemToDelete.id);
            this.isDeleteItemModal = false;
            setTimeout(() => {
                this.itemToDelete = null;
            }, 200);
        }
    },
    abrirModalLimpiar() {
        if (this.productosTicket.length > 0) {
            this.isClearTicketModal = true;
        }
    },
    confirmClearTicket() {
        this.productosTicket = [];
        this.clienteNombre = '';
        this.descuento = '';
        this.limpiarTicketStorage();
        this.isClearTicketModal = false;
    },
    actualizarCantidad(producto, cantidad) {
        if (cantidad > 0) {
            producto.cantidad = cantidad;
            producto.subtotal = producto.precio_actual * cantidad;
        }
    },
    seleccionarProducto(producto) {
        // Si el producto ya está seleccionado, deseleccionarlo
        if (this.productoSeleccionado && this.productoSeleccionado.id === producto.id) {
            this.productoSeleccionado = null;
        } else {
            this.productoSeleccionado = producto;
            // Cerrar el modal de alerta si está abierto
            if (this.isAlertModal) {
                this.isAlertModal = false;
            }
        }
    },
    mostrarAlerta(mensaje) {
        this.alertMessage = mensaje;
        this.isAlertModal = true;
    },
    abrirModalMayoreo() {
        if (this.productosTicket.length === 0) {
            this.mostrarAlerta('No hay productos en el ticket');
            return;
        }
        if (!this.productoSeleccionado) {
            this.mostrarAlerta('Por favor, selecciona un producto');
            return;
        }
        this.productoMayoreo = this.productoSeleccionado;
        this.selectedPriceIndex = this.productoSeleccionado && this.productoSeleccionado.es_mayoreo ? 1 : 0;
        this.isMayoreoModal = true;
        // Enfocar el contenedor del modal para que los eventos de teclado funcionen
        this.$nextTick(() => {
            const contenido = this.$refs.mayoreoModalContent || this.$refs.mayoreoModalContentMobile;
            if (contenido) {
                contenido.focus();
            }
        });
    },
    seleccionarPrecioConEnter() {
        if (this.productoMayoreo) {
            const usarMayoreo = this.selectedPriceIndex === 1;
            this.cambiarPrecioMayoreo(this.productoMayoreo, usarMayoreo);
        }
    },
    manejarTecladoMayoreo(event) {
        if (!this.isMayoreoModal) return;
        
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            if (this.selectedPriceIndex < 1) {
                this.selectedPriceIndex = 1;
            }
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            if (this.selectedPriceIndex > 0) {
                this.selectedPriceIndex = 0;
            }
        } else if (event.key === 'Enter') {
            event.preventDefault();
            this.seleccionarPrecioConEnter();
        } else if (event.key === 'Escape') {
            this.isMayoreoModal = false;
            setTimeout(() => {
                this.productoMayoreo = null;
                this.selectedPriceIndex = 0;
            }, 200);
        }
    },
    cambiarPrecioMayoreo(producto, usarMayoreo) {
        if (usarMayoreo) {
            producto.precio_actual = producto.precio_mayoreo;
            producto.es_mayoreo = true;
        } else {
            producto.precio_actual = producto.precio;
            producto.es_mayoreo = false;
        }
        producto.subtotal = producto.precio_actual * producto.cantidad;
        this.isMayoreoModal = false;
        setTimeout(() => {
            this.productoMayoreo = null;
            this.selectedPriceIndex = 0;
        }, 200);
    },
    abrirModalBusqueda() {
        this.searchQuery = '';
        this.selectedIndex = -1;
        // Asegurar que productosFiltrados tenga todos los productos disponibles
        if (this.productosDisponibles && Array.isArray(this.productosDisponibles) && this.productosDisponibles.length > 0) {
            this.productosFiltrados = [...this.productosDisponibles];
        } else {
            this.productosFiltrados = [];
        }
        this.isSearchModal = true;
        // Enfocar el input después de que el modal se abra
        this.$nextTick(() => {
            const inputDesktop = this.$refs?.searchInputDesktop;
            const inputMobile = this.$refs?.searchInputMobile;
            const input = inputDesktop || inputMobile;
            if (input) {
                input.focus();
            }
        });
    },
    filtrarProductos() {
        if (!this.productosDisponibles || !Array.isArray(this.productosDisponibles)) {
            this.productosFiltrados = [];
            this.selectedIndex = -1;
            return;
        }
        if (!this.searchQuery || this.searchQuery.trim() === '') {
            this.productosFiltrados = [...this.productosDisponibles];
            this.selectedIndex = -1;
            return;
        }
        const query = this.searchQuery.toLowerCase().trim();
        this.productosFiltrados = this.productosDisponibles.filter(producto => 
            (producto.nombre && producto.nombre.toLowerCase().includes(query)) ||
            (producto.codigo && producto.codigo.toLowerCase().includes(query)) ||
            (producto.codigo_barras && producto.codigo_barras.toLowerCase().includes(query)) ||
            (producto.numero_lote && producto.numero_lote.toLowerCase().includes(query)) ||
            (producto.categoria && producto.categoria.toLowerCase().includes(query))
        );
        this.selectedIndex = -1;
    },
    scrollToSelected() {
        this.$nextTick(() => {
            if (this.selectedIndex >= 0) {
                const selectedRow = document.querySelector('[data-product-index=\'' + this.selectedIndex + '\']');
                if (selectedRow) {
                    selectedRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }
        });
    },
    agregarProductoDesdeBusqueda(producto) {
        // Verificar si el producto ya está en el ticket
        const productoExistente = this.productosTicket.find(p => p.id === producto.id);
        
        if (productoExistente) {
            // Si ya existe, aumentar la cantidad
            if (productoExistente.cantidad < productoExistente.stock) {
                productoExistente.cantidad++;
                productoExistente.subtotal = productoExistente.precio_actual * productoExistente.cantidad;
            }
        } else {
            // Si no existe, agregarlo al ticket
            this.productosTicket.push({
                id: producto.id,
                nombre: producto.nombre,
                codigo: producto.codigo,
                precio: producto.precio,
                precio_mayoreo: producto.precio_mayoreo || producto.precio,
                precio_actual: producto.precio,
                cantidad: 1,
                stock: producto.stock,
                subtotal: producto.precio,
                es_mayoreo: false
            });
        }
        
        // Cerrar el modal
        this.isSearchModal = false;
        this.selectedIndex = -1;
        setTimeout(() => {
            this.searchQuery = '';
        }, 200);
    },
    get subtotal() {
        return this.productosTicket.reduce((sum, p) => sum + p.subtotal, 0).toFixed(2);
    },
    get total() {
        const subtotal = parseFloat(this.subtotal) || 0;
        const descuento = parseFloat(this.descuento) || 0;
        return (subtotal - descuento).toFixed(2);
    },
    get cambio() {
        if (this.tipoPago === 'efectivo' && this.montoRecibido) {
            const recibido = parseFloat(this.montoRecibido) || 0;
            const total = parseFloat(this.total) || 0;
            return (recibido - total).toFixed(2);
        }
        return '0.00';
    },
    procesarCodigoBarras() {
        if (this.codigoBarras.trim()) {
            this.agregarProducto(this.codigoBarras.trim());
            // Volver a enfocar el input después de procesar (solo desktop)
            this.enfocarInputCodigoBarras();
        }
    },
    abrirModalCobro() {
        if (this.productosTicket.length > 0) {
            // Siempre establecer monto recibido al total cuando se abre el modal
            this.montoRecibido = this.total;
            this.montoRecibidoModificadoManual = false;
            this.isPaymentModal = true;
        }
    },
    confirmarCobro() {
        // Aquí irá la lógica para procesar el pago
        this.isPaymentModal = false;
        setTimeout(() => {
            this.productosTicket = [];
            this.clienteNombre = '';
            this.montoRecibido = '';
            this.descuento = '';
            this.tipoPago = 'efectivo';
            this.montoRecibidoModificadoManual = false;
            this.limpiarTicketStorage();
        }, 200);
        // showSuccessToast();
    },
    abrirModalBusquedaCliente() {
        this.customerSearchQuery = '';
        this.selectedCustomerIndex = -1;
        // Asegurar que clientesFiltrados tenga todos los clientes disponibles
        if (this.clientesDisponibles && Array.isArray(this.clientesDisponibles) && this.clientesDisponibles.length > 0) {
            this.clientesFiltrados = [...this.clientesDisponibles];
        } else {
            this.clientesFiltrados = [];
        }
        this.isSearchCustomerModal = true;
        // Enfocar el input después de que el modal se abra
        this.$nextTick(() => {
            const inputDesktop = this.$refs?.searchCustomerInputDesktop;
            const inputMobile = this.$refs?.searchCustomerInputMobile;
            const input = inputDesktop || inputMobile;
            if (input) {
                input.focus();
            }
        });
    },
    filtrarClientes() {
        if (!this.clientesDisponibles || !Array.isArray(this.clientesDisponibles)) {
            this.clientesFiltrados = [];
            this.selectedCustomerIndex = -1;
            return;
        }
        if (!this.customerSearchQuery || this.customerSearchQuery.trim() === '') {
            this.clientesFiltrados = [...this.clientesDisponibles];
            this.selectedCustomerIndex = -1;
            return;
        }
        const query = this.customerSearchQuery.toLowerCase().trim();
        this.clientesFiltrados = this.clientesDisponibles.filter(cliente => 
            (cliente.nombre && cliente.nombre.toLowerCase().includes(query)) ||
            (cliente.dni && cliente.dni.toLowerCase().includes(query)) ||
            (cliente.telefono && cliente.telefono.toLowerCase().includes(query))
        );
        this.selectedCustomerIndex = -1;
    },
    scrollToSelectedCustomer() {
        this.$nextTick(() => {
            if (this.selectedCustomerIndex >= 0) {
                const selectedRow = document.querySelector('[data-customer-index=\'' + this.selectedCustomerIndex + '\']');
                if (selectedRow) {
                    selectedRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }
        });
    },
    seleccionarCliente(cliente) {
        this.clienteNombre = cliente.nombre;
        this.isSearchCustomerModal = false;
        this.selectedCustomerIndex = -1;
        setTimeout(() => {
            this.customerSearchQuery = '';
        }, 200);
    },
    getCustomerAvatarUrl(name) {
        const seed = name.replace(/\s+/g, '');
        return `https://api.dicebear.com/7.x/lorelei/svg?seed=${seed}&backgroundColor=b6e3f4,c0aede,d1d4f9,ffd5dc,ffdfbf`;
    },
    isDesktop() {
        return window.innerWidth >= 768; // md breakpoint de Tailwind
    },
    enfocarInputCodigoBarras() {
        if (this.isDesktop()) {
            this.$nextTick(() => {
                this.$refs.codigoBarrasInput?.focus();
            });
        }
    }
}">
    <div>
        <section class="dark:bg-gray-900 antialiased">
            <div class="max-w-screen-2xl mx-auto">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-none rounded-lg overflow-hidden">
                    <!-- Información del cliente -->
                    <div class="px-3 py-2 sm:px-4 sm:py-3 dark:bg-blue-900/30 border-b border-blue-200 dark:border-blue-700">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 flex-1 min-w-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="sm:text-sm font-medium text-blue-900 dark:text-blue-100">Cliente:</span>
                                <span class="sm:text-sm font-semibold text-blue-700 dark:text-blue-300 truncate" x-text="clienteNombre || 'Público General'"></span>
                            </div>
                            <button 
                                type="button"
                                @click="abrirModalBusquedaCliente()"
                                class="flex items-center justify-center p-2.5 sm:px-4 sm:py-2.5 sm:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 flex-shrink-0 sm:min-w-[140px]">
                                <svg class="w-5 h-5 sm:mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="hidden sm:inline">Seleccionar</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Campo de código de barras -->
                    <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700">
                        <form @submit.prevent="procesarCodigoBarras()" class="space-y-3 sm:space-y-0 sm:flex sm:items-center sm:gap-3">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 sm:pl-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    x-ref="codigoBarrasInput"
                                    x-model="codigoBarras"
                                    @keyup.enter="procesarCodigoBarras()"
                                    @focusout="if (window.innerWidth >= 768 && !isSearchModal && !isSearchCustomerModal && !isPaymentModal && !isMayoreoModal && !isDeleteItemModal && !isClearTicketModal && !isAlertModal) { setTimeout(() => { const target = $event.relatedTarget; if (!target || (!target.closest('button') && !target.closest('input') && target !== $refs.codigoBarrasInput)) { $refs.codigoBarrasInput?.focus(); } }, 50); }"
                                    class="w-full pl-10 sm:pl-12 pr-12 sm:pr-4 py-2.5 sm:py-3 text-sm sm:text-sm font-mono text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 placeholder:text-gray-400 placeholder:opacity-60 dark:placeholder:text-gray-500 dark:placeholder:opacity-60"
                                    placeholder="Escanear código..."
                                    autofocus>
                                <button
                                    type="button"
                                    @click="procesarCodigoBarras()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 sm:hidden text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 sm:gap-2 sm:flex-shrink-0 sm:flex-wrap">
                                <button 
                                    type="button"
                                    @click="abrirModalBusqueda()"
                                    class="flex items-center justify-center p-2.5 sm:px-4 sm:py-3 sm:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 sm:min-w-[140px]">
                                    <svg class="w-5 h-5 sm:mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Buscar</span>
                                    <span class="hidden sm:inline ml-2 text-xs text-gray-500 dark:text-gray-400">F10</span>
                                </button>
                                <button 
                                    type="button"
                                    @click="abrirModalMayoreo()"
                                    :disabled="productosTicket.length === 0"
                                    :class="productosTicket.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                                    class="flex items-center justify-center p-2.5 sm:px-4 sm:py-3 sm:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed sm:min-w-[140px]">
                                    <svg class="w-5 h-5 sm:mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Mayoreo</span>
                                    <span class="hidden sm:inline ml-2 text-xs text-gray-500 dark:text-gray-400">F11</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabla tipo ticket - Desktop -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <div :class="productosTicket.length > 5 ? 'max-h-[400px] overflow-y-auto' : ''">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 w-10 bg-gray-50 dark:bg-gray-700">Acción</th>
                                            <th scope="col" class="px-4 py-3 min-w-[120px] bg-gray-50 dark:bg-gray-700">Producto</th>
                                            <th scope="col" class="px-4 py-3 text-center bg-gray-50 dark:bg-gray-700">Cant.</th>
                                            <th scope="col" class="px-4 py-3 text-right bg-gray-50 dark:bg-gray-700">Precio Unit.</th>
                                            <th scope="col" class="px-4 py-3 text-right bg-gray-50 dark:bg-gray-700">Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <template x-if="productosTicket.length === 0">
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <p class="text-sm">No hay productos en el ticket</p>
                                                <p class="text-xs mt-1">Escanea o ingresa un código de barras para comenzar</p>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <template x-for="producto in productosTicket" :key="producto.id">
                                    <tr 
                                        @click="seleccionarProducto(producto)"
                                        :class="productoSeleccionado && productoSeleccionado.id === producto.id ? 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-l-blue-500' : 'hover:bg-gray-50 dark:hover:bg-gray-700'"
                                        class="border-b dark:border-gray-600 cursor-pointer transition-colors">
                                        <td class="px-2 py-3">
                                            <div class="flex items-center justify-center">
                                                <button 
                                                    @click.stop="eliminarProducto(producto.id)"
                                                    type="button"
                                                    title="Eliminar"
                                                    class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="producto.nombre"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 font-mono" x-text="producto.codigo"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center">
                                                <input 
                                                    type="number" 
                                                    :value="producto.cantidad"
                                                    @input.stop="actualizarCantidad(producto, parseInt($event.target.value) || 1)"
                                                    @click.stop
                                                    :max="producto.stock"
                                                    min="1"
                                                    class="w-20 text-center text-sm font-medium text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex flex-col items-end">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="'S/ ' + producto.precio_actual.toFixed(2)"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'S/ ' + producto.subtotal.toFixed(2)"></span>
                                        </td>
                                    </tr>
                                </template>
                                    </tbody>
                                    <tfoot x-show="productosTicket.length > 0" class="bg-gray-50 dark:bg-gray-700 sticky bottom-0">
                                        <tr>
                                            <td colspan="4" class="px-4 py-4 text-right font-bold text-base text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">
                                                SUBTOTAL:
                                            </td>
                                            <td class="px-4 py-4 text-right bg-gray-50 dark:bg-gray-700">
                                                <span class="text-lg font-bold text-gray-900 dark:text-white" x-text="'S/ ' + subtotal"></span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Vista móvil - Tarjetas -->
                    <div class="md:hidden space-y-4 px-4 pt-0 pb-4">
                        <template x-if="productosTicket.length === 0">
                            <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm">No hay productos en el ticket</p>
                                    <p class="text-xs mt-1">Escanea o ingresa un código de barras para comenzar</p>
                                </div>
                            </div>
                        </template>
                        <template x-for="producto in productosTicket" :key="producto.id">
                            <div 
                                @click="seleccionarProducto(producto)"
                                :class="productoSeleccionado && productoSeleccionado.id === producto.id ? 'bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-500' : 'border border-gray-200 dark:border-gray-700'"
                                class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm cursor-pointer transition-all">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1" x-text="producto.nombre"></h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mb-2" x-text="producto.codigo"></p>
                                    </div>
                                    <button 
                                        @click="eliminarProducto(producto.id)"
                                        type="button"
                                        title="Eliminar"
                                        class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm p-2 flex-shrink-0 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div class="flex flex-col">
                                        <label class="text-xs text-gray-500 dark:text-gray-400 mb-1.5 font-medium">Cantidad</label>
                                        <input 
                                            type="number" 
                                            :value="producto.cantidad"
                                            @input.stop="actualizarCantidad(producto, parseInt($event.target.value) || 1)"
                                            @click.stop
                                            :max="producto.stock"
                                            min="1"
                                            class="w-full text-center text-sm font-semibold text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="text-xs text-gray-500 dark:text-gray-400 mb-1.5 font-medium">Precio Unit.</label>
                                        <div class="w-full text-center text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2">
                                            <div class="flex flex-col items-center">
                                                <span x-text="'S/ ' + producto.precio_actual.toFixed(2)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3 -mx-4 px-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Importe:</span>
                                        <span class="text-base font-bold text-gray-900 dark:text-white" x-text="'S/ ' + producto.subtotal.toFixed(2)"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Subtotal móvil -->
                        <div x-show="productosTicket.length > 0" class="bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-bold text-gray-900 dark:text-white">SUBTOTAL:</span>
                                <span class="text-lg font-bold text-gray-900 dark:text-white" x-text="'S/ ' + subtotal"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="p-3 sm:p-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <button 
                            type="button"
                            @click="abrirModalLimpiar()"
                            :disabled="productosTicket.length === 0"
                            :class="productosTicket.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                            class="w-full sm:flex-1 flex items-center justify-center px-6 py-2.5 sm:py-2.5 text-sm sm:text-sm font-semibold sm:font-medium text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Limpiar Ticket
                        </button>
                        <button 
                            type="button"
                            @click="abrirModalCobro()"
                            :disabled="productosTicket.length === 0"
                            :class="productosTicket.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                            class="w-full sm:flex-1 flex items-center justify-center px-6 py-2.5 sm:py-2.5 text-sm sm:text-sm font-semibold sm:font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Cobrar
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    @include('sales.modals.payment')
    @include('sales.modals.delete-ticket-item')
    @include('sales.modals.clear-ticket')
    @include('sales.modals.mayoreo')
    @include('sales.modals.search-product')
    @include('sales.modals.search-customer')
    @include('sales.modals.alert')
</main>

