<?php

/**
 * Helper de utilidades para manejo de imágenes
 * Solo funciones de utilidad, sin generación de HTML
 */

if (!function_exists('get_product_image_url')) {
    /**
     * Obtiene la URL correcta de una imagen de producto
     * @param string $imageName Nombre del archivo de imagen
     * @return string URL completa de la imagen
     */
    function get_product_image_url($imageName)
    {
        if (!$imageName) {
            return base_url('images/default-product.webp');
        }

        // Si la imagen empieza con 'producto_', está en la carpeta productos
        if (strpos($imageName, 'producto_') === 0) {
            $imagePath = FCPATH . 'images/productos/' . $imageName;
            if (file_exists($imagePath)) {
                return base_url('images/productos/' . $imageName);
            } else {
                // Log del error para debugging
                log_message('error', "Imagen de producto no encontrada: $imageName en $imagePath");
                return base_url('images/default-product.webp');
            }
        }

        // Si no empieza con 'producto_', buscar en la carpeta principal de imágenes
        $imagePath = FCPATH . 'images/' . $imageName;
        if (file_exists($imagePath)) {
            return base_url('images/' . $imageName);
        } else {
            // Log del error para debugging
            log_message('error', "Imagen no encontrada: $imageName en $imagePath");
            return base_url('images/default-product.webp');
        }
    }
}

if (!function_exists('getSafeImageUrl')) {
    /**
     * Función existente para compatibilidad
     * @param string $imageName Nombre del archivo de imagen
     * @return string URL completa de la imagen
     */
    function getSafeImageUrl($imageName)
    {
        return get_product_image_url($imageName);
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

if (!function_exists('cleanup_missing_images')) {
    /**
     * Limpia las referencias de imágenes que no existen en la base de datos
     * @return array Array con información de la limpieza
     */
    function cleanup_missing_images()
    {
        $db = \Config\Database::connect();
        $productoModel = new \App\Models\ProductoModel();
        
        $productos = $productoModel->findAll();
        $cleaned = 0;
        $errors = [];
        
        foreach ($productos as $producto) {
            $imageName = $producto['url_imagen'];
            
            if (!$imageName || $imageName === 'default-product.webp') {
                continue;
            }
            
            $imageExists = false;
            
            // Verificar si la imagen existe
            if (strpos($imageName, 'producto_') === 0) {
                $imagePath = FCPATH . 'images/productos/' . $imageName;
            } else {
                $imagePath = FCPATH . 'images/' . $imageName;
            }
            
            if (!file_exists($imagePath)) {
                // Actualizar el producto para usar imagen por defecto
                $productoModel->update($producto['id_producto'], [
                    'url_imagen' => 'default-product.webp'
                ]);
                $cleaned++;
                $errors[] = "Producto ID {$producto['id_producto']}: Imagen '$imageName' no encontrada, actualizada a imagen por defecto";
            }
        }
        
        return [
            'cleaned' => $cleaned,
            'errors' => $errors
        ];
    }
} 