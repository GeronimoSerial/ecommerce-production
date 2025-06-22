/**
 * Funcionalidades del Navbar
 * Maneja la búsqueda, carrito y navegación
 */

class NavbarManager {
  constructor() {
    this.searchOverlay = document.getElementById("searchOverlay");
    this.searchInput = document.getElementById("searchInput");
    this.cartCount = document.getElementById("cart-count");
    this.init();
  }

  init() {
    // Asegurarse de que el overlay esté oculto inicialmente
    if (this.searchOverlay) {
      this.searchOverlay.style.display = "none";
    }

    // Inicializar el badge del carrito completamente oculto
    if (this.cartCount) {
      this.cartCount.textContent = "0";
      // No establecer display: none, dejar que el CSS maneje la visibilidad
      this.cartCount.classList.add("hidden");
      this.cartCount.classList.remove("visible");
    }

    this.setupEventListeners();
    this.loadCartCount();
    this.setupSearchSuggestions();
  }

  setupEventListeners() {
    // Cerrar búsqueda con ESC
    document.addEventListener("keydown", (event) => {
      if (
        event.key === "Escape" &&
        this.searchOverlay &&
        this.searchOverlay.style.display === "flex"
      ) {
        this.toggleSearch();
      }
    });

    // Cerrar búsqueda al hacer clic fuera
    if (this.searchOverlay) {
      this.searchOverlay.addEventListener("click", (event) => {
        if (event.target === this.searchOverlay) {
          this.toggleSearch();
        }
      });
    }
  }

  toggleSearch() {
    if (!this.searchOverlay) {
      return;
    }

    if (
      this.searchOverlay.style.display === "none" ||
      !this.searchOverlay.style.display
    ) {
      this.openSearch();
    } else {
      this.closeSearch();
    }
  }

  openSearch() {
    if (this.searchOverlay) {
      this.searchOverlay.style.display = "flex";
      document.body.classList.add("search-active");

      setTimeout(() => {
        if (this.searchInput) {
          this.searchInput.focus();
        }
      }, 100);

      document.body.style.overflow = "hidden";
    }
  }

  closeSearch() {
    if (this.searchOverlay) {
      this.searchOverlay.style.display = "none";
      document.body.classList.remove("search-active");
    }
    document.body.style.overflow = "auto";
  }

  // handleSearchSubmit() {
  //   if (!this.searchInput) return;

  //   const searchTerm = this.searchInput.value.trim();
  //   if (searchTerm) {
  //     // Usar la ruta base de PHP para asegurar que incluya 'ecommerce/'
  //     const baseUrl = '<?= base_url() ?>';
  //     const searchUrl = `${baseUrl}productos/buscar?q=${encodeURIComponent(searchTerm)}`;
  //     window.location.href = searchUrl;
  //   }
  // }

  setSearchTerm(term) {
    if (this.searchInput) {
      this.searchInput.value = term;
      this.searchInput.focus();
    }
  }

  showSearchSuggestions(query) {
    // Implementar sugerencias dinámicas basadas en la consulta
  }

  async loadCartCount() {
    try {
      // Obtener el conteo del carrito sin establecer un valor inicial
      const count = await this.getCartCount();
      this.updateCartCount(count);
    } catch (error) {
      // Solo actualizar si hay error, pero sin establecer valor inicial
      this.updateCartCount(0);
    }
  }

  async getCartCount() {
    try {
      // Obtener la URL base del proyecto
      const baseUrl = window.location.origin;
      const response = await fetch(`${baseUrl}/cart/count`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      return data.count || 0;
    } catch (error) {
      return 0;
    }
  }

  updateCartCount(count) {
    if (this.cartCount) {
      // Solo actualizar si el valor es diferente para evitar flash
      if (this.cartCount.textContent !== count.toString()) {
        this.cartCount.textContent = count;

        if (count > 0) {
          this.cartCount.classList.remove("hidden");
          this.cartCount.classList.add("visible");
        } else {
          this.cartCount.classList.remove("visible");
          this.cartCount.classList.add("hidden");
        }
      }
    }
  }

  setupSearchSuggestions() {
    // Hacer las sugerencias clickeables
    const suggestions = document.querySelectorAll('[onclick^="setSearchTerm"]');
    suggestions.forEach((button) => {
      button.addEventListener("click", (e) => {
        const match = button.getAttribute("onclick").match(/'([^']+)'/);
        if (match && match[1]) {
          this.setSearchTerm(match[1]);
        }
      });
    });
  }

  showNotification(message, type = "info") {
    const toast = document.createElement("div");
    toast.className = "position-fixed top-0 end-0 p-3";
    toast.style.zIndex = "1060";
    toast.style.minWidth = "300px";

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
      case "success":
        return "bg-success";
      case "error":
        return "bg-danger";
      case "warning":
        return "bg-warning";
      default:
        return "bg-info";
    }
  }

  openCart() {
    // Usar la URL correcta del carrito
    window.location.href = window.location.origin + '/cart';
  }
}

// Inicializar cuando el DOM esté listo

document.addEventListener("DOMContentLoaded", function () {
  try {
    // Hacer las funciones disponibles globalmente
    window.navbarManager = new NavbarManager();

    // Funciones globales para compatibilidad con HTML antiguo
    window.toggleSearch = () => {
      window.navbarManager.toggleSearch();
    };

    window.abrirCarrito = () => {
      window.navbarManager.openCart();
    };

    window.mostrarNotificacion = (mensaje, tipo) => {
      window.navbarManager.showNotification(mensaje, tipo);
    };

    window.setSearchTerm = (term) => {
      window.navbarManager.setSearchTerm(term);
    };

    // Función global para actualizar el contador del carrito
    window.actualizarContadorCarrito = (count) => {
      if (window.navbarManager) {
        window.navbarManager.updateCartCount(count);
      }
    };

    // Inicializar tooltips de Bootstrap
    try {
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );

      tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        try {
          new bootstrap.Tooltip(tooltipTriggerEl);
        } catch (err) {
          // Silenciar errores de tooltip
        }
      });
    } catch (err) {
      // Silenciar errores de tooltips
    }
  } catch (error) {
    // Silenciar errores de inicialización
  }
});

// Also try to initialize if the script is loaded after DOMContentLoaded
if (
  document.readyState === "complete" ||
  document.readyState === "interactive"
) {
  const event = new Event("DOMContentLoaded");
  document.dispatchEvent(event);
}
