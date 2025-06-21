<?php
/**
 * Vista para el sorter/ordenamiento de productos
 * 
 * @var array $filtros Filtros actuales
 * @var string $baseUrl URL base para los enlaces
 */

// Validar que los filtros existan
$filtros = $filtros ?? [];
$baseUrl = $baseUrl ?? current_url();

// Obtener valores actuales
$ordenActual = $filtros['orden'] ?? 'nombre';
$direccionActual = $filtros['direccion'] ?? 'ASC';

// Definir opciones de ordenamiento (solo campos soportados por el modelo)
$opciones = [
    'id_producto' => 'ID',
    'nombre' => 'Nombre',
    'categoria' => 'Categoría',
    'precio' => 'Precio',
    'cantidad' => 'Stock'
];

// Función helper para limpiar URL
function clean_url_for_params($url) {
    if (empty($url)) {
        $url = current_url();
    }
    
    if (strpos($url, '?') !== false) {
        $url = explode('?', $url)[0];
    }
    
    if (!filter_var($url, FILTER_VALIDATE_URL) && !str_starts_with($url, '/')) {
        $url = current_url();
        if (strpos($url, '?') !== false) {
            $url = explode('?', $url)[0];
        }
    }
    
    return $url;
}
?>

<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-sort-down me-1"></i>
        Ordenar por: <?= htmlspecialchars($opciones[$ordenActual] ?? 'Nombre') ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
        <?php foreach ($opciones as $campo => $etiqueta): ?>
            <?php
            // Preparar parámetros para el enlace
            $params = $filtros;
            $params['orden'] = $campo;
            
            // Cambiar dirección si es el mismo campo
            if ($ordenActual === $campo) {
                $params['direccion'] = $direccionActual === 'ASC' ? 'DESC' : 'ASC';
            } else {
                $params['direccion'] = 'ASC';
            }
            
            // Remover página para empezar desde la primera
            unset($params['page']);
            
            // Construir URL
            $cleanUrl = clean_url_for_params($baseUrl);
            $url = $cleanUrl . '?' . http_build_query($params);
            
            // Determinar icono
            $icono = '';
            if ($ordenActual === $campo) {
                $icono = $direccionActual === 'ASC' ? ' ↑' : ' ↓';
            }
            
            // Clase CSS para el item activo
            $claseItem = $ordenActual === $campo ? 'dropdown-item active' : 'dropdown-item';
            ?>
            
            <li>
                <a class="<?= $claseItem ?>" href="<?= htmlspecialchars($url) ?>">
                    <i class="bi bi-<?=
                        $campo === 'id_producto' ? 'hash' :
                        ($campo === 'nombre' ? 'font' :
                        ($campo === 'categoria' ? 'tag' :
                        ($campo === 'precio' ? 'currency-dollar' : 'box')))
                    ?> me-2"></i>
                    <?= htmlspecialchars($etiqueta) ?><?= $icono ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<style>
.dropdown-item.active {
    background-color: #0d6efd;
    color: white;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.active:hover {
    background-color: #0b5ed7;
}
</style>
