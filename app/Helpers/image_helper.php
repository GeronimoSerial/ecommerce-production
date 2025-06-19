<?php

/**
 * Helper para manejo seguro de imágenes
 * Evita loops infinitos y maneja errores de manera elegante
 */

if (!function_exists('safe_image_url')) {
    /**
     * Genera una URL segura para una imagen
     * Verifica que la imagen existe antes de retornar la URL
     * 
     * @param string $imagePath Ruta de la imagen
     * @param string $defaultImage Imagen por defecto si no existe
     * @param string $basePath Directorio base de imágenes
     * @return string URL segura de la imagen
     */
    function safe_image_url($imagePath, $defaultImage = 'default-product.webp', $basePath = 'public/images/') {
        // Si no hay imagen, usar la por defecto
        if (empty($imagePath)) {
            return base_url($basePath . $defaultImage);
        }
        
        // Verificar si la imagen existe físicamente
        $fullPath = FCPATH . $basePath . $imagePath;
        if (!file_exists($fullPath)) {
            return base_url($basePath . $defaultImage);
        }
        
        // Retornar la URL de la imagen original
        return base_url($basePath . $imagePath);
    }
}

if (!function_exists('safe_banner_url')) {
    /**
     * Genera una URL segura para banners de categorías
     * 
     * @param string $categoryName Nombre de la categoría
     * @return string URL del banner
     */
    function safe_banner_url($categoryName) {
        $bannerMap = [
            'proteinas' => 'protein_wallpaper.webp',
            'creatinas' => 'gym_wallpaper.webp',
            'colagenos' => 'header-background.webp',
            'accesorios' => 'gym_wallpaper.webp'
        ];
        
        $categoryKey = strtolower($categoryName);
        $bannerImage = $bannerMap[$categoryKey] ?? 'header-background.webp';
        
        return base_url('public/images/banners/' . $bannerImage);
    }
}

if (!function_exists('image_placeholder_html')) {
    /**
     * Genera HTML para un placeholder de imagen
     * 
     * @param string $size Tamaño del placeholder (small, medium, large)
     * @return string HTML del placeholder
     */
    function image_placeholder_html($size = 'small') {
        $sizes = [
            'small' => 'width: 90px; height: 90px;',
            'medium' => 'width: 200px; height: 200px;',
            'large' => 'width: 100%; height: 300px;'
        ];
        
        $style = $sizes[$size] ?? $sizes['small'];
        
        return '<div class="product-placeholder" style="display: none; ' . $style . ' background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="bi bi-image text-muted fs-4"></i>
                </div>';
    }
}

if (!function_exists('safe_product_image')) {
    /**
     * Genera HTML completo para una imagen de producto segura
     * 
     * @param array $producto Datos del producto
     * @param string $size Tamaño del placeholder
     * @param string $cssClass Clases CSS adicionales
     * @return string HTML completo de la imagen
     */
    function safe_product_image($producto, $size = 'small', $cssClass = 'product-img mx-auto') {
        $imageUrl = safe_image_url($producto['url_imagen'] ?? '');
        $placeholder = image_placeholder_html($size);
        
        return '<img src="' . $imageUrl . '" 
                     alt="' . htmlspecialchars($producto['nombre'] ?? 'Producto') . '" 
                     class="' . $cssClass . '"
                     onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'block\';">
                ' . $placeholder;
    }
} 