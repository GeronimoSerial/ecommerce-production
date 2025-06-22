<?php
/**
 * Plantilla de paginación
 * 
 * @var array $paginacion Datos de paginación
 * @var array $filtros Filtros actuales
 * @var string $baseUrl URL base para la paginación
 */

// No mostrar nada si solo hay una página
if ($paginacion['totalPaginas'] <= 1) {
    return;
}

// Limpiar la URL base para evitar problemas de concatenación
$baseUrl = clean_url_for_params($baseUrl ?? '');

// Construir parámetros de filtros para URLs
$queryParams = [];
foreach ($filtros as $key => $value) {
    if ($value !== null && $value !== '') {
        $queryParams[$key] = $value;
    }
}

$paginaActual = $paginacion['paginaActual'];
$totalPaginas = $paginacion['totalPaginas'];
?>

<nav aria-label="Navegación de páginas">
    <ul class="pagination justify-content-center">
        <?php // Botón Anterior ?>
        <?php if ($paginaActual > 1): ?>
            <?php 
            $prevParams = $queryParams;
            $prevParams['page'] = $paginaActual - 1;
            $prevUrl = $baseUrl . '?' . http_build_query($prevParams);
            ?>
            <li class="page-item">
                <a class="page-link" href="<?= $prevUrl ?>">Anterior</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Anterior</span>
            </li>
        <?php endif; ?>

        <?php
        // Calcular rango de páginas a mostrar
        $rango = 2; // Páginas a mostrar antes y después de la actual
        $inicio = max(1, $paginaActual - $rango);
        $fin = min($totalPaginas, $paginaActual + $rango);
        ?>

        <?php // Mostrar primera página si no está en el rango ?>
        <?php if ($inicio > 1): ?>
            <?php
            $params = $queryParams;
            $params['page'] = 1;
            $url = $baseUrl . '?' . http_build_query($params);
            ?>
            <li class="page-item">
                <a class="page-link" href="<?= $url ?>">1</a>
            </li>

            <?php if ($inicio > 2): ?>
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            <?php endif; ?>
        <?php endif; ?>


        <?php // Mostrar páginas en el rango ?>
        <?php for ($i = $inicio; $i <= $fin; $i++): ?>
            <?php
            $params = $queryParams;
            $params['page'] = $i;
            $url = $baseUrl . '?' . http_build_query($params);
            ?>
            <?php if ($i == $paginaActual): ?>
                <li class="page-item active">
                    <span class="page-link"><?= $i ?></span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $url ?>"><?= $i ?></a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php // Mostrar última página si no está en el rango ?>
        <?php if ($fin < $totalPaginas): ?>
            <?php if ($fin < $totalPaginas - 1): ?>
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            <?php endif; ?>

            <?php
            $params = $queryParams;
            $params['page'] = $totalPaginas;
            $url = $baseUrl . '?' . http_build_query($params);
            ?>
            <li class="page-item">
                <a class="page-link" href="<?= $url ?>"><?= $totalPaginas ?></a>
            </li>
        <?php endif; ?>

        <?php // Botón Siguiente ?>
        <?php if ($paginaActual < $totalPaginas): ?>
            <?php
            $nextParams = $queryParams;
            $nextParams['page'] = $paginaActual + 1;
            $nextUrl = $baseUrl . '?' . http_build_query($nextParams);
            ?>
            <li class="page-item">
                <a class="page-link" href="<?= $nextUrl ?>">Siguiente</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Siguiente</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>