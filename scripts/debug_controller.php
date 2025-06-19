<?php
/**
 * Script para debuggear el controlador de productos
 * Simula exactamente la lógica del controlador
 */

// Configuración de base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tienda';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== DEBUG CONTROLADOR PRODUCTOS ===\n\n";

    // Simular parámetros del controlador
    $productosPorPagina = 6;
    $pagina = 1; // Primera página
    $orden = 'nombre';
    $direccion = 'ASC';
    $precioMin = null;
    $precioMax = null;
    $busqueda = null;

    // Simular búsqueda de categoría "proteinas"
    $slug = 'proteinas';
    
    echo "🔍 Buscando categoría: '$slug'\n";
    
    $stmt = $pdo->prepare("SELECT id_categoria, nombre FROM categorias WHERE LOWER(nombre) = ? AND activo = 1");
    $stmt->execute([strtolower($slug)]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$categoria) {
        echo "❌ Categoría no encontrada\n";
        exit(1);
    }
    
    echo "✅ Categoría encontrada: {$categoria['nombre']} (ID: {$categoria['id_categoria']})\n\n";

    // Simular builder para conteo (como en el controlador)
    echo "📊 CONSTRUYENDO QUERY DE CONTEO:\n";
    $countQuery = "SELECT COUNT(*) as total FROM productos WHERE id_categoria = ? AND activo = 1";
    $countParams = [$categoria['id_categoria']];
    
    if ($busqueda) {
        $countQuery .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
        $countParams[] = "%$busqueda%";
        $countParams[] = "%$busqueda%";
    }
    if ($precioMin !== null && $precioMin !== '') {
        $countQuery .= " AND precio >= ?";
        $countParams[] = $precioMin;
    }
    if ($precioMax !== null && $precioMax !== '') {
        $countQuery .= " AND precio <= ?";
        $countParams[] = $precioMax;
    }
    
    echo "Query: $countQuery\n";
    echo "Parámetros: " . implode(', ', $countParams) . "\n";
    
    $stmt = $pdo->prepare($countQuery);
    $stmt->execute($countParams);
    $totalProductos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "Total productos: $totalProductos\n\n";

    // Simular builder para productos (como en el controlador)
    echo "📦 CONSTRUYENDO QUERY DE PRODUCTOS:\n";
    $productosQuery = "SELECT * FROM productos WHERE id_categoria = ? AND activo = 1";
    $productosParams = [$categoria['id_categoria']];
    
    if ($busqueda) {
        $productosQuery .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
        $productosParams[] = "%$busqueda%";
        $productosParams[] = "%$busqueda%";
    }
    if ($precioMin !== null && $precioMin !== '') {
        $productosQuery .= " AND precio >= ?";
        $productosParams[] = $precioMin;
    }
    if ($precioMax !== null && $precioMax !== '') {
        $productosQuery .= " AND precio <= ?";
        $productosParams[] = $precioMax;
    }
    
    // Agregar ordenamiento
    $productosQuery .= " ORDER BY $orden $direccion";
    
    // Agregar límite y offset
    $offset = ($pagina - 1) * $productosPorPagina;
    $productosQuery .= " LIMIT $productosPorPagina OFFSET $offset";
    
    echo "Query: $productosQuery\n";
    echo "Parámetros: " . implode(', ', $productosParams) . "\n";
    echo "Límite: $productosPorPagina, Offset: $offset\n\n";
    
    $stmt = $pdo->prepare($productosQuery);
    $stmt->execute($productosParams);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📋 PRODUCTOS OBTENIDOS:\n";
    echo "Cantidad de productos: " . count($productos) . "\n";
    echo "Productos por página configurado: $productosPorPagina\n";
    
    if (count($productos) !== $productosPorPagina) {
        echo "⚠️  ADVERTENCIA: La cantidad de productos no coincide con la configuración\n";
    }
    
    echo "\nProductos:\n";
    foreach ($productos as $producto) {
        echo "- {$producto['nombre']} (ID: {$producto['id_producto']}, Categoría: {$producto['id_categoria']})\n";
    }
    
    // Calcular información de paginación
    $totalPaginas = ceil($totalProductos / $productosPorPagina);
    $paginaActual = max(1, min($pagina, $totalPaginas));
    
    echo "\n📄 INFORMACIÓN DE PAGINACIÓN:\n";
    echo "Página actual: $paginaActual\n";
    echo "Total páginas: $totalPaginas\n";
    echo "Productos por página: $productosPorPagina\n";
    echo "Total productos: $totalProductos\n";
    
    // Calcular rango mostrado
    $inicioProductos = ($paginaActual - 1) * $productosPorPagina + 1;
    $finProductos = $inicioProductos + count($productos) - 1;
    
    echo "Rango mostrado: $inicioProductos-$finProductos de $totalProductos productos\n";
    
    // Verificar que todos los productos son de la categoría correcta
    echo "\n🔍 VERIFICANDO CATEGORÍAS:\n";
    $productosCorrectos = 0;
    foreach ($productos as $producto) {
        if ($producto['id_categoria'] == $categoria['id_categoria']) {
            $productosCorrectos++;
        } else {
            echo "❌ ERROR: Producto {$producto['nombre']} pertenece a categoría {$producto['id_categoria']}, no a {$categoria['id_categoria']}\n";
        }
    }
    
    if ($productosCorrectos == count($productos)) {
        echo "✅ Todos los productos son de la categoría correcta\n";
    }
    
    echo "\n=== RESUMEN ===\n";
    echo "Configuración esperada: $productosPorPagina productos por página\n";
    echo "Productos obtenidos: " . count($productos) . "\n";
    echo "¿Coincide?: " . (count($productos) == $productosPorPagina ? "✅ SÍ" : "❌ NO") . "\n";
    
    if (count($productos) != $productosPorPagina) {
        echo "\n🔧 POSIBLES CAUSAS:\n";
        echo "1. Cache del navegador\n";
        echo "2. Cache de PHP/CodeIgniter\n";
        echo "3. El controlador no se actualizó correctamente\n";
        echo "4. Hay algún middleware o filtro que está modificando la consulta\n";
    }
    
    echo "\n✅ Debug completado.\n";
    
} catch (PDOException $e) {
    echo "❌ Error de base de datos: " . $e->getMessage() . "\n";
    exit(1);
} 