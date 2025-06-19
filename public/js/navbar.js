/**
 * Funcionalidades del Navbar
 * Maneja la búsqueda, carrito y navegación
 */

class NavbarManager {
    constructor() {
        this.searchOverlay = document.getElementById('searchOverlay');
        this.searchInput = document.getElementById('searchInput');
        this.cartCount = document.getElementById('cart-count');
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadCartCount();
        this.setupSearchSuggestions();
    }

    setupEventListeners() {
        // Cerrar búsqueda con ESC
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                this.closeSearch();
            }
        });

        // Cerrar búsqueda al hacer clic fuera
        if (this.searchOverlay) {
            this.searchOverlay.addEventListener('click', (event) => {
                if (event.target === this.searchOverlay) {
                    this.closeSearch();
                }
            });
        }

        // Auto-completado de búsqueda
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (event) => {
                this.handleSearchInput(event.target.value);
            });
        }
    }

    toggleSearch() {
        if (!this.searchOverlay) return;

        if (this.searchOverlay.style.display === 'none') {
            this.openSearch();
        } else {
            this.closeSearch();
        }
    }

    openSearch() {
        this.searchOverlay.style.display = 'flex';
        setTimeout(() => {
            if (this.searchInput) {
                this.searchInput.focus();
            }
        }, 300);
        document.body.style.overflow = 'hidden';
    }

    closeSearch() {
        if (this.searchOverlay) {
            this.searchOverlay.style.display = 'none';
        }
        document.body.style.overflow = 'auto';
    }

    handleSearchInput(query) {
        // Aquí se podría implementar búsqueda en tiempo real
        if (query.length > 2) {
            // Mostrar sugerencias dinámicas
            this.showSearchSuggestions(query);
        }
    }

    showSearchSuggestions(query) {
        // Implementar sugerencias dinámicas basadas en la consulta
        console.log('Buscando:', query);
    }

    async loadCartCount() {
        try {
            // Aquí se haría una petición AJAX para obtener el conteo del carrito
            // Por ahora usamos un valor de ejemplo
            const count = await this.getCartCount();
            this.updateCartCount(count);
        } catch (error) {
            console.error('Error cargando carrito:', error);
            this.updateCartCount(0);
        }
    }

    async getCartCount() {
        // Simular petición al servidor
        return new Promise((resolve) => {
            setTimeout(() => {
                // Aquí se obtendría el valor real del carrito
                resolve(0);
            }, 100);
        });
    }

    updateCartCount(count) {
        if (this.cartCount) {
            this.cartCount.textContent = count;
            this.cartCount.style.display = count > 0 ? 'block' : 'none';
        }
    }

    setupSearchSuggestions() {
        // Configurar sugerencias de búsqueda populares
        const suggestions = [
            { text: 'Whey Protein', url: 'productos/buscar?q=whey' },
            { text: 'Creatina', url: 'productos/buscar?q=creatina' },
            { text: 'Colágeno', url: 'productos/buscar?q=colageno' },
            { text: 'Shaker', url: 'productos/buscar?q=shaker' },
            { text: 'Proteína Vegana', url: 'productos/buscar?q=proteina+vegana' }
        ];

        // Hacer las sugerencias clickeables
        suggestions.forEach(suggestion => {
            const element = document.querySelector(`[href*="${suggestion.url}"]`);
            if (element) {
                element.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = baseUrl + suggestion.url;
                });
            }
        });
    }

    showNotification(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
        toast.style.zIndex = '1060';
        
        const bgClass = this.getNotificationClass(type);
        
        toast.innerHTML = `
            <div class="toast show" role="alert">
                <div class="toast-header ${bgClass} text-white">
                    <strong class="me-auto">Notificación</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 3000);
    }

    getNotificationClass(type) {
        switch (type) {
            case 'success': return 'bg-success';
            case 'error': return 'bg-danger';
            case 'warning': return 'bg-warning';
            default: return 'bg-info';
        }
    }

    openCart() {
        // Implementar apertura del carrito
        this.showNotification('Carrito en desarrollo', 'info');
    }
}

// Funciones globales para compatibilidad
function toggleSearch() {
    if (window.navbarManager) {
        window.navbarManager.toggleSearch();
    }
}

function abrirCarrito() {
    if (window.navbarManager) {
        window.navbarManager.openCart();
    }
}

function mostrarNotificacion(mensaje, tipo) {
    if (window.navbarManager) {
        window.navbarManager.showNotification(mensaje, tipo);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.navbarManager = new NavbarManager();
    
    // Variable global para baseUrl
    window.baseUrl = document.querySelector('base')?.href || '';
});

// Mejoras para el dropdown de productos
document.addEventListener('DOMContentLoaded', function() {
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    
    dropdownItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.2)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });
});

// Mejoras para la navegación móvil
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        // Cerrar menú móvil al hacer clic en un enlace
        const navLinks = navbarCollapse.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    }
}); 