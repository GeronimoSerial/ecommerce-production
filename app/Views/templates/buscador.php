<?php 
/**
 * Formulario de búsqueda y filtros
 * 
 * @var array $filtros Filtros actuales
 * @var array $categorias Lista de categorías (opcional)
 * @var array $stats Estadísticas de precios (opcional)
 * @var string $baseUrl URL base para el formulario
 */
?>

<form method="GET" action="<?= $baseUrl ?? '' ?>" class="filter-form">
    <!-- Búsqueda -->
    <div class="mb-3">
        <!-- <label for="busqueda" class="form-label"></label> -->
        <input 
            type="text" 
            class="form-control" 
            id="q" 
            name="q" 
            value="<?= htmlspecialchars($filtros['q'] ?? '') ?>" 
            placeholder="Buscar productos..."
        >
    </div>
    <!-- Botones -->
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>