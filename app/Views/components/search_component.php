<?php
$placeholder = isset($placeholder) ? $placeholder : 'Buscar productos...';
?>
<div class="search-container mb-4">
    <form action="<?= base_url('productos/buscar') ?>" method="GET" class="position-relative">
        <div class="input-group">
            <input type="text" 
                   name="q" 
                   class="form-control form-control-lg" 
                   placeholder="<?= $placeholder ?? 'Buscar productos...' ?>"
                   value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                   autocomplete="off"
                   id="searchInput">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
        
        <!-- Filtros rápidos -->
        <div class="quick-filters mt-3">
            <div class="d-flex flex-wrap gap-2">
                <span class="text-muted small me-2">Filtros rápidos:</span>
                <a href="<?= base_url('productos/buscar?q=whey') ?>" 
                   class="badge bg-outline-primary text-decoration-none">Whey</a>
                <a href="<?= base_url('productos/buscar?q=creatina') ?>" 
                   class="badge bg-outline-primary text-decoration-none">Creatina</a>
                <a href="<?= base_url('productos/buscar?q=colageno') ?>" 
                   class="badge bg-outline-primary text-decoration-none">Colágeno</a>
                <a href="<?= base_url('productos/buscar?q=shaker') ?>" 
                   class="badge bg-outline-primary text-decoration-none">Shaker</a>
                <a href="<?= base_url('productos/buscar?q=proteina+vegana') ?>" 
                   class="badge bg-outline-primary text-decoration-none">Vegana</a>
            </div>
        </div>
    </form>
</div>

<style>
.search-container .form-control {
    border: 2px solid #e9ecef;
    border-radius: 50px 0 0 50px;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-container .form-control:focus {
    border-color: var(--pink);
    box-shadow: 0 0 0 0.2rem rgba(229, 52, 91, 0.25);
}

.search-container .btn {
    border-radius: 0 50px 50px 0;
    padding: 0.75rem 1.5rem;
    border: 2px solid var(--pink);
    background-color: var(--pink);
    transition: all 0.3s ease;
}

.search-container .btn:hover {
    background-color: #d63384;
    border-color: #d63384;
    transform: translateY(-1px);
}

.quick-filters .badge {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    border: 1px solid var(--pink);
    color: var(--pink);
    background-color: transparent;
    transition: all 0.3s ease;
}

.quick-filters .badge:hover {
    background-color: var(--pink);
    color: white;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .search-container .form-control {
        font-size: 0.9rem;
        padding: 0.6rem 1rem;
    }
    
    .search-container .btn {
        padding: 0.6rem 1rem;
    }
    
    .quick-filters .badge {
        font-size: 0.7rem;
        padding: 0.4rem 0.8rem;
    }
}
</style>
