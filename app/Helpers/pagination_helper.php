<?php

/**
 * Helper para generar paginación HTML
 */

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
