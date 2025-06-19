<?php

/**
 * Script de debug para verificar paginación
 * Verifica que la paginación funcione correctamente en categorías
 */

require_once __DIR__ . '/../system/bootstrap.php';

use App\Models\ProductoModel;
use App\Models\CategoriaModel;

echo "=== DEBUG PAGINACIÓN ===\n\n";

// Instanciar modelos
$productoModel = new ProductoModel();
$categoriaModel = new CategoriaModel();

// Obtener todas las categorías
$categorias = $categoriaModel->findAll();

echo "Categorías disponibles:\n";
foreach ($categorias as $cat) {
    echo "- {$cat['nombre']} (ID: {$cat['id_categoria']})\n";
}
echo "\n";

// Probar cada categoría
foreach ($categorias as $categoria) {
    echo "=== CATEGORÍA: {$categoria['nombre']} ===\n";
    
    // Contar productos totales en esta categoría
    $totalProductos = $productoModel
        ->where("id_categoria", $categoria["id_categoria"])
        ->where("activo", 1)
        ->countAllResults();
    
    echo "Total productos en categoría: {$totalProductos}\n";
    
    if ($totalProductos > 0) {
        // Probar paginación
        $productosPorPagina = 6;
        $totalPaginas = ceil($totalProductos / $productosPorPagina);
        
        echo "Productos por página: {$productosPorPagina}\n";
        echo "Total páginas: {$totalPaginas}\n\n";
        
        // Probar cada página
        for ($pagina = 1; $pagina <= min(3, $totalPaginas); $pagina++) {
            $offset = ($pagina - 1) * $productosPorPagina;
            
            // Builder para productos paginados
            $productosBuilder = $productoModel
                ->where("id_categoria", $categoria["id_categoria"])
                ->where("activo", 1)
                ->orderBy('nombre', 'ASC');
            
            $productos = $productosBuilder->limit($productosPorPagina, $offset)->findAll();
            
            echo "Página {$pagina}: " . count($productos) . " productos\n";
            
            // Mostrar algunos productos de ejemplo
            foreach (array_slice($productos, 0, 2) as $producto) {
                echo "  - {$producto['nombre']} (ID: {$producto['id_producto']})\n";
            }
            
            if (count($productos) > 2) {
                echo "  ... y " . (count($productos) - 2) . " más\n";
            }
            echo "\n";
        }
        
        // Verificar que no hay duplicados entre páginas
        echo "Verificando duplicados entre páginas...\n";
        $todosLosIds = [];
        for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
            $offset = ($pagina - 1) * $productosPorPagina;
            
            $productosBuilder = $productoModel
                ->where("id_categoria", $categoria["id_categoria"])
                ->where("activo", 1)
                ->orderBy('nombre', 'ASC');
            
            $productos = $productosBuilder->limit($productosPorPagina, $offset)->findAll();
            
            foreach ($productos as $producto) {
                $todosLosIds[] = $producto['id_producto'];
            }
        }
        
        $idsUnicos = array_unique($todosLosIds);
        $duplicados = count($todosLosIds) - count($idsUnicos);
        
        if ($duplicados > 0) {
            echo "❌ ERROR: Se encontraron {$duplicados} productos duplicados\n";
        } else {
            echo "✅ OK: No hay productos duplicados\n";
        }
        
        if (count($idsUnicos) !== $totalProductos) {
            echo "❌ ERROR: Se esperaban {$totalProductos} productos únicos, se encontraron " . count($idsUnicos) . "\n";
        } else {
            echo "✅ OK: Número correcto de productos únicos\n";
        }
        
    } else {
        echo "No hay productos en esta categoría\n";
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
}

echo "=== FIN DEBUG ===\n"; 