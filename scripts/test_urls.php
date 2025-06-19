<?php
/**
 * Script de prueba para verificar URLs
 * Ejecutar desde la línea de comandos: php scripts/test_urls.php
 */

// Simular diferentes rutas actuales
$testPaths = [
    '/',
    '/categoria/proteinas',
    '/categoria/creatinas',
    '/productos/buscar',
    '/productos/buscar?q=test',
    '/admin/inventario'
];

echo "=== PRUEBA DE GENERACIÓN DE URLS ===\n\n";

foreach ($testPaths as $path) {
    echo "Ruta actual: $path\n";
    
    // Simular site_url() con diferentes rutas
    $baseURL = 'http://localhost/ecommerce/';
    
    // Test 1: site_url('productos/buscar')
    $url1 = $baseURL . 'productos/buscar';
    echo "  site_url('productos/buscar'): $url1\n";
    
    // Test 2: site_url('/productos/buscar')
    $url2 = $baseURL . 'productos/buscar';
    echo "  site_url('/productos/buscar'): $url2\n";
    
    // Test 3: base_url('productos/buscar')
    $url3 = $baseURL . 'productos/buscar';
    echo "  base_url('productos/buscar'): $url3\n";
    
    echo "\n";
}

echo "=== RECOMENDACIÓN ===\n";
echo "Usar site_url('/productos/buscar') para evitar concatenación\n";
echo "El slash inicial asegura que se construya desde la raíz del sitio\n"; 