/**
 * Funcionalidades del Navbar
 * Maneja la búsqueda, carrito y navegación
 */
console.log("Navbar script loaded");

class NavbarManager {
  constructor() {
    this.searchOverlay = document.getElementById("searchOverlay");
    this.searchInput = document.getElementById("searchInput");
    this.cartCount = document.getElementById("cart-count");
    this.init();
  }

  init() {
    console.log("Initializing NavbarManager");
    console.log("Search overlay element:", this.searchOverlay);
    console.log("Search input element:", this.searchInput);
    console.log("Cart count element:", this.cartCount);

    // Asegurarse de que el overlay esté oculto inicialmente
    if (this.searchOverlay) {
      console.log("Hiding search overlay");
      this.searchOverlay.style.display = "none";
    } else {
      console.error("Search overlay element not found!");
    }

    // Inicializar el badge del carrito completamente oculto
    if (this.cartCount) {
      console.log("Cart badge found, initializing...");
      this.cartCount.textContent = "0";
      this.cartCount.style.display = "none";
      this.cartCount.classList.add("hidden");
      this.cartCount.classList.remove("visible");
      console.log("Cart badge initialized as completely hidden");
      console.log("Cart badge classes:", this.cartCount.className);
      console.log("Cart badge display:", this.cartCount.style.display);
    } else {
      console.error("Cart count element not found!");
    }

    this.setupEventListeners();
    this.loadCartCount();
    this.setupSearchSuggestions();

    console.log("NavbarManager initialization complete");
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
    console.log("toggleSearch called");
    if (!this.searchOverlay) {
      console.error("Search overlay element not found!");
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
    console.log("Opening search overlay");
    if (this.searchOverlay) {
      this.searchOverlay.style.display = "flex";
      document.body.classList.add("search-active");

      setTimeout(() => {
        if (this.searchInput) {
          this.searchInput.focus();
        } else {
          console.error("Search input element not found!");
        }
      }, 100);

      document.body.style.overflow = "hidden";
    } else {
      console.error("Search overlay element not found!");
    }
  }

  closeSearch() {
    console.log("Closing search overlay");
    if (this.searchOverlay) {
      this.searchOverlay.style.display = "none";
      document.body.classList.remove("search-active");
    } else {
      console.error("Search overlay element not found!");
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
    console.log("Buscando:", query);
  }

  async loadCartCount() {
    try {
      // Obtener el conteo del carrito sin establecer un valor inicial
      const count = await this.getCartCount();
      this.updateCartCount(count);
    } catch (error) {
      console.error("Error cargando carrito:", error);
      // Solo actualizar si hay error, pero sin establecer valor inicial
      this.updateCartCount(0);
    }
  }

  async getCartCount() {
    // Simular petición al servidor
    return new Promise((resolve) => {
      setTimeout(() => {
        // Aquí se obtendría el valor real del carrito
        // Por ahora retornamos 0, pero esto debería ser una petición AJAX real
        resolve(0);
      }, 100);
    });
  }

  updateCartCount(count) {
    if (this.cartCount) {
      console.log("Updating cart count to:", count);
      console.log("Current cart badge text:", this.cartCount.textContent);
      console.log("Current cart badge classes:", this.cartCount.className);
      console.log("Current cart badge display:", this.cartCount.style.display);

      // Solo actualizar si el valor es diferente para evitar flash
      if (this.cartCount.textContent !== count.toString()) {
        console.log("Value changed, updating...");
        this.cartCount.textContent = count;

        if (count > 0) {
          console.log("Showing cart badge");
          this.cartCount.classList.remove("hidden");
          this.cartCount.classList.add("visible");
          console.log("After showing - classes:", this.cartCount.className);
        } else {
          console.log("Hiding cart badge");
          this.cartCount.classList.remove("visible");
          this.cartCount.classList.add("hidden");
          console.log("After hiding - classes:", this.cartCount.className);
        }
      } else {
        console.log("Value unchanged, skipping update");
      }
    } else {
      console.error("Cart count element not found!");
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
    this.showNotification("Carrito en desarrollo", "info");
  }
}

// Inicializar cuando el DOM esté listo
console.log("DOMContentLoaded event fired");

document.addEventListener("DOMContentLoaded", function () {
  console.log("Initializing navbar...");

  try {
    // Hacer las funciones disponibles globalmente
    window.navbarManager = new NavbarManager();

    // Funciones globales para compatibilidad con HTML antiguo
    window.toggleSearch = () => {
      console.log("toggleSearch called");
      window.navbarManager.toggleSearch();
    };

    window.abrirCarrito = () => {
      console.log("abrirCarrito called");
      window.navbarManager.openCart();
    };

    window.mostrarNotificacion = (mensaje, tipo) => {
      console.log("mostrarNotificacion called with:", { mensaje, tipo });
      window.navbarManager.showNotification(mensaje, tipo);
    };

    window.setSearchTerm = (term) => {
      console.log("setSearchTerm called with:", term);
      window.navbarManager.setSearchTerm(term);
    };

    console.log("Global functions registered");

    // Inicializar tooltips de Bootstrap
    try {
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      console.log("Found", tooltipTriggerList.length, "tooltips to initialize");

      tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        try {
          new bootstrap.Tooltip(tooltipTriggerEl);
        } catch (err) {
          console.error("Error initializing tooltip:", err);
        }
      });
    } catch (err) {
      console.error("Error initializing tooltips:", err);
    }

    console.log("Navbar initialization complete");
  } catch (error) {
    console.error("Error initializing NavbarManager:", error);
  }
});

// Also try to initialize if the script is loaded after DOMContentLoaded
if (
  document.readyState === "complete" ||
  document.readyState === "interactive"
) {
  console.log("Document already loaded, initializing navbar directly");
  const event = new Event("DOMContentLoaded");
  document.dispatchEvent(event);
}
