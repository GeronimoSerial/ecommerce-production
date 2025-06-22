<?php

/**
 * Script para verificar y crear imágenes necesarias
 * Evita loops infinitos de imágenes
 */

// Definir constantes
define('IMAGES_PATH', __DIR__ . '/../public/images/');
define('BANNERS_PATH', IMAGES_PATH . 'banners/');

// Función para crear imagen placeholder
function createPlaceholderImage($path, $width = 300, $height = 200, $text = 'Imagen no disponible') {
    // Crear imagen usando GD
    $image = imagecreate($width, $height);
    
    // Colores
    $bgColor = imagecolorallocate($image, 248, 249, 250); // #f8f9fa
    $textColor = imagecolorallocate($image, 108, 117, 125); // #6c757d
    
    // Rellenar fondo
    imagefill($image, 0, 0, $bgColor);
    
    // Agregar texto
    $fontSize = 5;
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textHeight = imagefontheight($fontSize);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($image, $fontSize, $x, $y, $text, $textColor);
    
    // Guardar imagen
    imagewebp($image, $path);
    imagedestroy($image);
    
    echo "✓ Creada imagen placeholder: $path\n";
}

// Función para verificar y crear directorios
function ensureDirectoryExists($path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        echo "✓ Creado directorio: $path\n";
    }
}

// Función para verificar y crear imagen
function ensureImageExists($path, $width = 300, $height = 200, $text = 'Imagen no disponible') {
    if (!file_exists($path)) {
        createPlaceholderImage($path, $width, $height, $text);
    } else {
        echo "✓ Imagen ya existe: $path\n";
    }
}

echo "🔍 Verificando imágenes necesarias...\n\n";

// Verificar directorios
ensureDirectoryExists(IMAGES_PATH);
ensureDirectoryExists(BANNERS_PATH);

// Verificar imágenes de productos
ensureImageExists(IMAGES_PATH . 'default-product.webp', 300, 300, 'Producto');

// Verificar banners de categorías
$banners = [
    'protein_wallpaper.webp' => ['width' => 800, 'height' => 400, 'text' => 'Proteínas'],
    'gym_wallpaper.webp' => ['width' => 800, 'height' => 400, 'text' => 'Gimnasio'],
    'header-background.webp' => ['width' => 800, 'height' => 400, 'text' => 'Fitness'],
    'default-category-banner.webp' => ['width' => 800, 'height' => 400, 'text' => 'Categoría']
];

foreach ($banners as $banner => $config) {
    ensureImageExists(
        BANNERS_PATH . $banner, 
        $config['width'], 
        $config['height'], 
        $config['text']
    );
}

// Verificar imágenes de productos específicos
$productImages = [
    'caseina.webp' => ['width' => 300, 'height' => 300, 'text' => 'Caseína'],
    'colageno.webp' => ['width' => 300, 'height' => 300, 'text' => 'Colágeno'],
    'accesorios.webp' => ['width' => 300, 'height' => 300, 'text' => 'Accesorios']
];

foreach ($productImages as $image => $config) {
    ensureImageExists(
        IMAGES_PATH . $image, 
        $config['width'], 
        $config['height'], 
        $config['text']
    );
}

echo "\n✅ Verificación completada. Todas las imágenes necesarias están disponibles.\n";
echo "💡 Si ves imágenes placeholder, reemplázalas con imágenes reales en producción.\n"; 