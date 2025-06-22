<?php

/**
 * Helper de utilidades para manejo de imágenes
 * Solo funciones de utilidad, sin generación de HTML
 */

if (!function_exists('getSafeImageUrl')) {
    /**
     * Genera una URL segura para una imagen
     * Verifica que la imagen existe antes de retornar la URL
     * 
     * @param string $imagePath Ruta de la imagen
     * @param string $defaultImage Imagen por defecto si no existe
     * @return string URL segura de la imagen
     */
    function getSafeImageUrl($imagePath, $defaultImage = 'default-product.webp')
    {
        if (empty($imagePath)) {
            return base_url('images/' . $defaultImage);
        }
        
        $fullPath = FCPATH . 'public/images/' . $imagePath;
        if (!file_exists($fullPath)) {
            return base_url('images/' . $defaultImage);
        }
        
        return base_url('images/' . $imagePath);
    }
}

if (!function_exists('getBannerUrl')) {
    /**
     * Genera una URL segura para banners de categorías
     * 
     * @param string $categoryName Nombre de la categoría
     * @return string URL del banner
     */
    function getBannerUrl($categoryName)
    {
        $bannerMap = [
            'proteinas' => 'protein_wallpaper.webp',
            'creatinas' => 'gym_wallpaper.webp',
            'colagenos' => 'header-background.webp',
            'accesorios' => 'gym_wallpaper.webp'
        ];

        $categoryKey = strtolower($categoryName);
        $bannerImage = $bannerMap[$categoryKey] ?? 'header-background.webp';

        return base_url('images/banners/' . $bannerImage);
    }
} 