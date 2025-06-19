<?php

/**
 * Helper para generar paginación HTML
 */

if (!function_exists('generate_pagination')) {
    /**
     * Genera HTML de paginación
     * 
     * @param array $paginacion Datos de paginación
     * @param array $filtros Filtros actuales para mantener en URLs
     * @param string $baseUrl URL base para la paginación
     * @return string HTML de paginación
     */
    function generate_pagination($paginacion, $filtros = [], $baseUrl = '')
    {
        $paginaActual = $paginacion['paginaActual'];
        $totalPaginas = $paginacion['totalPaginas'];

        if ($totalPaginas <= 1) {
            return '';
        }

        // Limpiar la URL base para evitar problemas de concatenación
        $baseUrl = clean_url_for_params($baseUrl);

        // Construir parámetros de filtros para URLs
        $queryParams = [];
        foreach ($filtros as $key => $value) {
            if ($value !== null && $value !== '') {
                $queryParams[$key] = $value;
            }
        }

        $html = '<nav aria-label="Navegación de páginas">';
        $html .= '<ul class="pagination justify-content-center">';

        // Botón Anterior
        if ($paginaActual > 1) {
            $prevParams = $queryParams;
            $prevParams['page'] = $paginaActual - 1;
            $prevUrl = $baseUrl . '?' . http_build_query($prevParams);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . $prevUrl . '">Anterior</a>';
            $html .= '</li>';
        } else {
            $html .= '<li class="page-item disabled">';
            $html .= '<span class="page-link">Anterior</span>';
            $html .= '</li>';
        }

        // Calcular rango de páginas a mostrar
        $rango = 2; // Páginas a mostrar antes y después de la actual
        $inicio = max(1, $paginaActual - $rango);
        $fin = min($totalPaginas, $paginaActual + $rango);

        // Mostrar primera página si no está en el rango
        if ($inicio > 1) {
            $params = $queryParams;
            $params['page'] = 1;
            $url = $baseUrl . '?' . http_build_query($params);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . $url . '">1</a>';
            $html .= '</li>';

            if ($inicio > 2) {
                $html .= '<li class="page-item disabled">';
                $html .= '<span class="page-link">...</span>';
                $html .= '</li>';
            }
        }

        // Mostrar páginas en el rango
        for ($i = $inicio; $i <= $fin; $i++) {
            $params = $queryParams;
            $params['page'] = $i;
            $url = $baseUrl . '?' . http_build_query($params);

            if ($i == $paginaActual) {
                $html .= '<li class="page-item active">';
                $html .= '<span class="page-link">' . $i . '</span>';
                $html .= '</li>';
            } else {
                $html .= '<li class="page-item">';
                $html .= '<a class="page-link" href="' . $url . '">' . $i . '</a>';
                $html .= '</li>';
            }
        }

        // Mostrar última página si no está en el rango
        if ($fin < $totalPaginas) {
            if ($fin < $totalPaginas - 1) {
                $html .= '<li class="page-item disabled">';
                $html .= '<span class="page-link">...</span>';
                $html .= '</li>';
            }

            $params = $queryParams;
            $params['page'] = $totalPaginas;
            $url = $baseUrl . '?' . http_build_query($params);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . $url . '">' . $totalPaginas . '</a>';
            $html .= '</li>';
        }

        // Botón Siguiente
        if ($paginaActual < $totalPaginas) {
            $nextParams = $queryParams;
            $nextParams['page'] = $paginaActual + 1;
            $nextUrl = $baseUrl . '?' . http_build_query($nextParams);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . $nextUrl . '">Siguiente</a>';
            $html .= '</li>';
        } else {
            $html .= '<li class="page-item disabled">';
            $html .= '<span class="page-link">Siguiente</span>';
            $html .= '</li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }
}

if (!function_exists('clean_url_for_params')) {
    /**
     * Limpia una URL para evitar problemas de concatenación de parámetros
     * 
     * @param string $url URL a limpiar
     * @return string URL limpia sin parámetros
     */
    function clean_url_for_params($url)
    {
        // Si la URL está vacía, usar la URL actual
        if (empty($url)) {
            $url = current_url();
        }
        
        // Si la URL ya tiene parámetros, extraer solo la ruta
        if (strpos($url, '?') !== false) {
            $url = explode('?', $url)[0];
        }
        
        // Si la URL no es válida, usar la URL actual
        if (!filter_var($url, FILTER_VALIDATE_URL) && !str_starts_with($url, '/')) {
            $url = current_url();
            if (strpos($url, '?') !== false) {
                $url = explode('?', $url)[0];
            }
        }
        
        return $url;
    }
}

if (!function_exists('generate_sort_links')) {
    /**
     * Genera enlaces de ordenamiento
     * 
     * @param array $filtros Filtros actuales
     * @param string $baseUrl URL base
     * @return string HTML de enlaces de ordenamiento
     */
    function generate_sort_links($filtros, $baseUrl = '')
    {
        $ordenActual = $filtros['orden'] ?? 'nombre';
        $direccionActual = $filtros['direccion'] ?? 'ASC';

        $opciones = [
            'nombre' => 'Nombre',
            'precio' => 'Precio',
            'cantidad' => 'Cantidad',
            'cantidad_vendidos' => 'Vendidos'
        ];

        $html = '<div class="dropdown">';
        $html .= '<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
        $html .= 'Ordenar por: ' . ($opciones[$ordenActual] ?? 'Nombre');
        $html .= '</button>';
        $html .= '<ul class="dropdown-menu" aria-labelledby="sortDropdown">';

        foreach ($opciones as $campo => $etiqueta) {
            $params = $filtros;
            $params['orden'] = $campo;

            if ($ordenActual === $campo) {
                $params['direccion'] = $direccionActual === 'ASC' ? 'DESC' : 'ASC';
            } else {
                $params['direccion'] = 'ASC';
            }

            unset($params['page']);

            // ===== SOLUCIÓN MEJORADA =====
            // Usar la función helper para limpiar la URL
            $cleanUrl = clean_url_for_params($baseUrl);
            
            // Construir la URL final con los parámetros
            $url = $cleanUrl . '?' . http_build_query($params);
            // ===========================

            $icono = '';
            if ($ordenActual === $campo) {
                $icono = $direccionActual === 'ASC' ? ' ↑' : ' ↓';
            }

            $html .= '<li><a class="dropdown-item" href="' . $url . '">' . $etiqueta . $icono . '</a></li>';
        }

        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('generate_filter_form')) {
    /**
     * Genera formulario de filtros
     * 
     * @param array $filtros Filtros actuales
     * @param array $categorias Lista de categorías (para búsqueda)
     * @param array $stats Estadísticas de precios
     * @param string $baseUrl URL base
     * @return string HTML del formulario de filtros
     */
    function generate_filter_form($filtros, $categorias = [], $stats = [], $baseUrl = '')
    {
        $html = '<form method="GET" action="' . $baseUrl . '" class="filter-form">';

        // Búsqueda
        $html .= '<div class="mb-3">';
        $html .= '<label for="busqueda" class="form-label">Buscar</label>';
        $html .= '<input type="text" class="form-control" id="busqueda" name="busqueda" value="' . htmlspecialchars($filtros['busqueda'] ?? '') . '" placeholder="Buscar productos...">';
        $html .= '</div>';

        // Categoría (solo para búsqueda general)
        if (!empty($categorias)) {
            $html .= '<div class="mb-3">';
            $html .= '<label for="categoria" class="form-label">Categoría</label>';
            $html .= '<select class="form-select" id="categoria" name="categoria">';
            $html .= '<option value="">Todas las categorías</option>';

            foreach ($categorias as $categoria) {
                $selected = ($filtros['categoriaId'] ?? '') == $categoria['id_categoria'] ? 'selected' : '';
                $html .= '<option value="' . $categoria['id_categoria'] . '" ' . $selected . '>' . $categoria['nombre'] . '</option>';
            }

            $html .= '</select>';
            $html .= '</div>';
        }

        // Rango de precios
        if (!empty($stats)) {
            $precioMin = $stats['precioMinimo'] ?? 0;
            $precioMax = $stats['precioMaximo'] ?? 100000;

            $html .= '<div class="mb-3">';
            $html .= '<label class="form-label">Rango de Precio</label>';
            $html .= '<div class="row">';
            $html .= '<div class="col-6">';
            $html .= '<input type="number" class="form-control" name="precio_min" value="' . htmlspecialchars($filtros['precioMin'] ?? '') . '" placeholder="Mín" min="' . $precioMin . '" max="' . $precioMax . '">';
            $html .= '</div>';
            $html .= '<div class="col-6">';
            $html .= '<input type="number" class="form-control" name="precio_max" value="' . htmlspecialchars($filtros['precioMax'] ?? '') . '" placeholder="Máx" min="' . $precioMin . '" max="' . $precioMax . '">';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<small class="text-muted">Rango: $' . number_format($precioMin, 0, ',', '.') . ' - $' . number_format($precioMax, 0, ',', '.') . '</small>';
            $html .= '</div>';
        }

        // Botones
        $html .= '<div class="d-grid gap-2">';
        $html .= '<button type="submit" class="btn btn-primary">Aplicar Filtros</button>';

        // Botón limpiar filtros
        $html .= '<a href="' . $baseUrl . '" class="btn btn-outline-secondary">Limpiar Filtros</a>';
        $html .= '</div>';

        $html .= '</form>';

        return $html;
    }
}