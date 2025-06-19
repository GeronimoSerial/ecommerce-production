<?php
/**
 * Script para probar el controlador a través de HTTP
 * Simula una petición web real al controlador
 */

echo "=== PRUEBA CONTROLADOR WEB ===\n\n";

// URL del controlador
$url = 'http://localhost/ecommerce/categoria/proteinas';

echo "🌐 Haciendo petición a: $url\n\n";

// Hacer petición HTTP
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3',
            'Cache-Control: no-cache'
        ]
    ]
]);

$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo "❌ Error al hacer la petición HTTP\n";
    exit(1);
}

// Obtener headers de respuesta
$headers = $http_response_header ?? [];

echo "📡 Headers de respuesta:\n";
foreach ($headers as $header) {
    echo "  $header\n";
}
echo "\n";

// Buscar información específica en la respuesta HTML
echo "🔍 Analizando respuesta HTML...\n";

// Buscar el texto "Mostrando X-Y de Z productos"
if (preg_match('/Mostrando (\d+)-(\d+) de (\d+) productos/', $response, $matches)) {
    $inicio = $matches[1];
    $fin = $matches[2];
    $total = $matches[3];
    $productosEnPagina = $fin - $inicio + 1;
    
    echo "✅ Encontrado texto de paginación:\n";
    echo "  - Inicio: $inicio\n";
    echo "  - Fin: $fin\n";
    echo "  - Total: $total\n";
    echo "  - Productos en página: $productosEnPagina\n";
    
    if ($productosEnPagina == 6) {
        echo "✅ CORRECTO: Se muestran 6 productos por página\n";
    } else {
        echo "❌ ERROR: Se muestran $productosEnPagina productos, se esperaban 6\n";
    }
} else {
    echo "❌ No se encontró el texto de paginación en la respuesta\n";
}

// Buscar productos específicos de la categoría Proteinas
$productosProteinas = [
    'Caseína Micelar',
    'Mass Gainer Ultra',
    'Proteína de Arroz',
    'Proteína de Cáñamo',
    'Proteína de Carne',
    'Proteína de Guisante'
];

echo "\n🔍 Verificando productos de la categoría Proteinas:\n";
$productosEncontrados = 0;
foreach ($productosProteinas as $producto) {
    if (strpos($response, $producto) !== false) {
        echo "  ✅ $producto\n";
        $productosEncontrados++;
    } else {
        echo "  ❌ $producto (no encontrado)\n";
    }
}

echo "\nProductos encontrados: $productosEncontrados de " . count($productosProteinas) . "\n";

// Buscar productos de otras categorías (no deberían aparecer)
$productosOtrasCategorias = [
    'Creatina Monohidrato',
    'Colágeno Bovino',
    'Auriculares Inalámbricos'
];

echo "\n🔍 Verificando que NO aparezcan productos de otras categorías:\n";
$productosIncorrectos = 0;
foreach ($productosOtrasCategorias as $producto) {
    if (strpos($response, $producto) !== false) {
        echo "  ❌ $producto (no debería aparecer)\n";
        $productosIncorrectos++;
    } else {
        echo "  ✅ $producto (correctamente ausente)\n";
    }
}

if ($productosIncorrectos > 0) {
    echo "\n❌ ERROR: Se encontraron productos de otras categorías\n";
} else {
    echo "\n✅ CORRECTO: Solo aparecen productos de la categoría Proteinas\n";
}

// Buscar información de debug en la respuesta
if (strpos($response, 'debug') !== false || strpos($response, 'error') !== false) {
    echo "\n⚠️  ADVERTENCIA: Se encontraron palabras de debug/error en la respuesta\n";
}

echo "\n=== RESUMEN ===\n";
echo "URL probada: $url\n";
echo "Tamaño de respuesta: " . strlen($response) . " bytes\n";

if (strpos($response, 'Mostrando 1-6 de 12 productos') !== false) {
    echo "✅ PAGINACIÓN CORRECTA: Se muestran 6 productos por página\n";
} else {
    echo "❌ PAGINACIÓN INCORRECTA: No se muestran 6 productos por página\n";
}

if ($productosIncorrectos == 0) {
    echo "✅ FILTRADO CORRECTO: Solo productos de la categoría correcta\n";
} else {
    echo "❌ FILTRADO INCORRECTO: Aparecen productos de otras categorías\n";
}

echo "\n✅ Prueba completada.\n"; 