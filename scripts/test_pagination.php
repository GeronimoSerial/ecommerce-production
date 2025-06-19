<?php

/**
 * Script para probar la paginación
 * Verifica que los productos se muestren correctamente por página
 */

// Configuración de base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tienda';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔗 Conectado a la base de datos: $database\n\n";
    
    // Obtener estadísticas generales
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM productos WHERE activo = 1");
    $totalProductos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "📊 Estadísticas generales:\n";
    echo "  - Total de productos activos: $totalProductos\n";
    echo "  - Productos por página: 6\n";
    echo "  - Total de páginas: " . ceil($totalProductos / 6) . "\n\n";
    
    // Probar paginación por categorías
    $stmt = $pdo->query("SELECT id_categoria, nombre FROM categorias WHERE activo = 1 LIMIT 4");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($categorias as $categoria) {
        echo "📋 Probando categoría: {$categoria['nombre']}\n";
        
        // Contar productos en esta categoría
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM productos WHERE id_categoria = ? AND activo = 1");
        $stmt->execute([$categoria['id_categoria']]);
        $totalEnCategoria = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo "  - Total en categoría: $totalEnCategoria\n";
        echo "  - Páginas necesarias: " . ceil($totalEnCategoria / 6) . "\n";
        
        // Mostrar productos de la primera página
        $stmt = $pdo->prepare("SELECT nombre, precio FROM productos WHERE id_categoria = ? AND activo = 1 ORDER BY nombre LIMIT 6");
        $stmt->execute([$categoria['id_categoria']]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "  - Productos en página 1:\n";
        foreach ($productos as $producto) {
            echo "    • {$producto['nombre']} - $" . number_format($producto['precio'], 0, ',', '.') . "\n";
        }
        echo "\n";
    }
    
    // Probar búsqueda
    echo "🔍 Probando búsqueda:\n";
    $busqueda = 'whey';
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM productos WHERE (nombre LIKE ? OR descripcion LIKE ?) AND activo = 1");
    $stmt->execute(["%$busqueda%", "%$busqueda%"]);
    $totalBusqueda = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "  - Búsqueda: '$busqueda'\n";
    echo "  - Resultados encontrados: $totalBusqueda\n";
    echo "  - Páginas necesarias: " . ceil($totalBusqueda / 6) . "\n";
    
    if ($totalBusqueda > 0) {
        $stmt = $pdo->prepare("SELECT nombre, precio FROM productos WHERE (nombre LIKE ? OR descripcion LIKE ?) AND activo = 1 ORDER BY nombre LIMIT 6");
        $stmt->execute(["%$busqueda%", "%$busqueda%"]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "  - Primeros 6 resultados:\n";
        foreach ($resultados as $resultado) {
            echo "    • {$resultado['nombre']} - $" . number_format($resultado['precio'], 0, ',', '.') . "\n";
        }
    }
    
    echo "\n✅ Prueba de paginación completada.\n";
    echo "🎯 Ahora puedes probar en el navegador:\n";
    echo "   - http://localhost/ecommerce/categoria/proteinas\n";
    echo "   - http://localhost/ecommerce/categoria/proteinas?page=2\n";
    echo "   - http://localhost/ecommerce/buscar?q=whey\n";
    
} catch (PDOException $e) {
    echo "❌ Error de base de datos: " . $e->getMessage() . "\n";
    exit(1);
} 