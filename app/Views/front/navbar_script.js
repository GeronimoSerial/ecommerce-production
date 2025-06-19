function toggleSearch() {
  const overlay = document.getElementById("searchOverlay");
  const searchInput = document.getElementById("searchInput");

  if (overlay.style.display === "none") {
    overlay.style.display = "flex";
    setTimeout(() => {
      searchInput.focus();
    }, 300);
    document.body.style.overflow = "hidden";
  } else {
    overlay.style.display = "none";
    document.body.style.overflow = "auto";
  }
}

function abrirCarrito() {
  console.log("Abriendo carrito...");
  mostrarNotificacion("Carrito en desarrollo", "info");
}

function mostrarNotificacion(mensaje, tipo) {
  const toast = document.createElement("div");
  toast.className = "position-fixed top-0 end-0 p-3";
  toast.style.zIndex = "1060";

  const bgClass =
    tipo === "success"
      ? "bg-success"
      : tipo === "info"
      ? "bg-info"
      : "bg-warning";

  toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header ${bgClass} text-white">
                <strong class="me-auto">Notificación</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${mensaje}
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

document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    const overlay = document.getElementById("searchOverlay");
    if (overlay.style.display !== "none") {
      toggleSearch();
    }
  }
});

function actualizarContadorCarrito(cantidad) {
  const contador = document.getElementById("cart-count");
  contador.textContent = cantidad;

  if (cantidad > 0) {
    contador.style.display = "block";
  } else {
    contador.style.display = "none";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  actualizarContadorCarrito(0);
});

function setSearchTerm(term) {
  const searchInput = document.getElementById("searchInput");
  searchInput.value = term;
  searchInput.focus();

  // Opcional: Mostrar una pequeña notificación
  // mostrarNotificacion(`Búsqueda configurada: "${term}"`, 'info');
}

// Función para manejar la búsqueda cuando se presiona Enter
function handleSearchSubmit(event) {
  const searchInput = document.getElementById("searchInput");
  const searchTerm = searchInput.value.trim();

  if (searchTerm) {
    // Construir la URL de búsqueda de manera segura
    const searchUrl =
      "<?= site_url(' / productos / buscar') ?>" +
      "?q=" +
      encodeURIComponent(searchTerm);
    window.location.href = searchUrl;
  }
}

// Agregar event listener para Enter en el campo de búsqueda
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("keypress", function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        handleSearchSubmit(event);
      }
    });
  }

  actualizarContadorCarrito(0);
});
