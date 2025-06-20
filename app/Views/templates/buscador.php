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
        <label for="busqueda" class="form-label">Buscar</label>
        <input 
            type="text" 
            class="form-control" 
            id="q" 
            name="q" 
            value="<?= htmlspecialchars($filtros['q'] ?? '') ?>" 
            placeholder="Buscar productos..."
        >
    </div>

    <?php if (!empty($categorias)): ?>
        <!-- Categoría (solo para búsqueda general) -->
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select class="form-select" id="categoria" name="categoria">
                <option value="">Todas las categorías</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option 
                        value="<?= $categoria['id_categoria'] ?>" 
                        <?= ($filtros['categoria'] ?? '') == $categoria['id_categoria'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($categoria['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <?php if (!empty($stats)): 
        $precioMin = $stats['precioMinimo'] ?? 0;
        $precioMax = $stats['precioMaximo'] ?? 100000;
        ?>
        <!-- Rango de precios -->
        <div class="mb-3">
            <label class="form-label">Rango de Precio</label>
            <div class="row">
                <div class="col-6">
                    <input 
                        type="number" 
                        class="form-control" 
                        name="precio_min" 
                        value="<?= htmlspecialchars($filtros['precio_min'] ?? '') ?>" 
                        placeholder="Mín" 
                        min="<?= $precioMin ?>" 
                        max="<?= $precioMax ?>"
                    >
                </div>
                <div class="col-6">
                    <input 
                        type="number" 
                        class="form-control" 
                        name="precio_max" 
                        value="<?= htmlspecialchars($filtros['precio_max'] ?? '') ?>" 
                        placeholder="Máx" 
                        min="<?= $precioMin ?>" 
                        max="<?= $precioMax ?>"
                    >
                </div>
            </div>
            <small class="text-muted">
                Rango: $<?= number_format($precioMin, 0, ',', '.') ?> - $<?= number_format($precioMax, 0, ',', '.') ?>
            </small>
        </div>
    <?php endif; ?>

    <!-- Botones -->
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        <a href="<?= $baseUrl ?>" class="btn btn-outline-secondary">Limpiar Filtros</a>
    </div>
</form>