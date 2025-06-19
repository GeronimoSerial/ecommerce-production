<?php

/**
 * Script para poblar la base de datos con productos de ejemplo
 * Para probar la paginación y filtrado
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
    
    // Obtener categorías existentes
    $stmt = $pdo->query("SELECT id_categoria, nombre FROM categorias WHERE activo = 1");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($categorias)) {
        echo "❌ No se encontraron categorías activas. Ejecuta primero populate_database.php\n";
        exit(1);
    }
    
    echo "📋 Categorías encontradas:\n";
    foreach ($categorias as $cat) {
        echo "  - {$cat['nombre']} (ID: {$cat['id_categoria']})\n";
    }
    echo "\n";
    
    // Productos de ejemplo por categoría
    $productos = [
        'proteinas' => [
            ['nombre' => 'Whey Protein Gold Standard', 'descripcion' => 'Proteína de suero premium con 24g de proteína por porción', 'precio' => 89999, 'cantidad' => 15, 'url_imagen' => 'isolated.webp'],
            ['nombre' => 'Whey Protein Isolate', 'descripcion' => 'Proteína aislada de alta pureza, baja en carbohidratos', 'precio' => 99999, 'cantidad' => 12, 'url_imagen' => 'isolated.webp'],
            ['nombre' => 'Caseína Micelar', 'descripcion' => 'Proteína de liberación lenta para la noche', 'precio' => 79999, 'cantidad' => 8, 'url_imagen' => 'caseina.webp'],
            ['nombre' => 'Proteína Vegana Blend', 'descripcion' => 'Mezcla de proteínas vegetales premium', 'precio' => 69999, 'cantidad' => 10, 'url_imagen' => 'vegan.webp'],
            ['nombre' => 'Mass Gainer Ultra', 'descripcion' => 'Ganador de masa con extra calorías y proteínas', 'precio' => 109999, 'cantidad' => 6, 'url_imagen' => 'mass_gainer.webp'],
            ['nombre' => 'Whey Protein Concentrate', 'descripcion' => 'Proteína concentrada de suero de leche', 'precio' => 59999, 'cantidad' => 20, 'url_imagen' => 'micronizada.webp'],
            ['nombre' => 'Proteína Hidrolizada', 'descripcion' => 'Proteína pre-digerida para absorción rápida', 'precio' => 119999, 'cantidad' => 5, 'url_imagen' => 'isolated.webp'],
            ['nombre' => 'Proteína de Huevo', 'descripcion' => 'Proteína de clara de huevo en polvo', 'precio' => 49999, 'cantidad' => 14, 'url_imagen' => 'vegan.webp'],
            ['nombre' => 'Proteína de Carne', 'descripcion' => 'Proteína de res hidrolizada', 'precio' => 89999, 'cantidad' => 7, 'url_imagen' => 'caseina.webp'],
            ['nombre' => 'Proteína de Guisante', 'descripcion' => 'Proteína vegetal de guisante orgánico', 'precio' => 54999, 'cantidad' => 11, 'url_imagen' => 'vegan.webp'],
            ['nombre' => 'Proteína de Arroz', 'descripcion' => 'Proteína de arroz integral', 'precio' => 44999, 'cantidad' => 9, 'url_imagen' => 'vegan.webp'],
            ['nombre' => 'Proteína de Cáñamo', 'descripcion' => 'Proteína de semillas de cáñamo', 'precio' => 64999, 'cantidad' => 6, 'url_imagen' => 'vegan.webp']
        ],
        'creatinas' => [
            ['nombre' => 'Creatina Monohidrato', 'descripcion' => 'Creatina pura micronizada para fuerza y potencia', 'precio' => 29999, 'cantidad' => 25, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina HCL', 'descripcion' => 'Creatina hidrocloruro, mejor absorción', 'precio' => 39999, 'cantidad' => 18, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Etil Éster', 'descripcion' => 'Creatina de absorción mejorada', 'precio' => 44999, 'cantidad' => 12, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Malato', 'descripcion' => 'Creatina con ácido málico', 'precio' => 34999, 'cantidad' => 15, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Citrato', 'descripcion' => 'Creatina con ácido cítrico', 'precio' => 37999, 'cantidad' => 10, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Magnesio Quelado', 'descripcion' => 'Creatina con magnesio para mejor absorción', 'precio' => 42999, 'cantidad' => 8, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Kre-Alkalyn', 'descripcion' => 'Creatina tamponada de pH', 'precio' => 49999, 'cantidad' => 6, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Nitrato', 'descripcion' => 'Creatina con nitratos para vasodilatación', 'precio' => 46999, 'cantidad' => 9, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Fosfato', 'descripcion' => 'Creatina con fosfato para energía', 'precio' => 39999, 'cantidad' => 11, 'url_imagen' => 'creatina.webp'],
            ['nombre' => 'Creatina Piruvato', 'descripcion' => 'Creatina con piruvato para resistencia', 'precio' => 44999, 'cantidad' => 7, 'url_imagen' => 'creatina.webp']
        ],
        'colagenos' => [
            ['nombre' => 'Colágeno Hidrolizado', 'descripcion' => 'Colágeno tipo I y III hidrolizado', 'precio' => 39999, 'cantidad' => 20, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno Marino', 'descripcion' => 'Colágeno de pescado de aguas profundas', 'precio' => 44999, 'cantidad' => 16, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno Bovino', 'descripcion' => 'Colágeno de res tipo I y III', 'precio' => 34999, 'cantidad' => 18, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con Vitamina C', 'descripcion' => 'Colágeno hidrolizado con vitamina C', 'precio' => 42999, 'cantidad' => 14, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con Ácido Hialurónico', 'descripcion' => 'Colágeno con ácido hialurónico', 'precio' => 47999, 'cantidad' => 12, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con Magnesio', 'descripcion' => 'Colágeno con magnesio para articulaciones', 'precio' => 39999, 'cantidad' => 15, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con Glucosamina', 'descripcion' => 'Colágeno con glucosamina y condroitina', 'precio' => 49999, 'cantidad' => 10, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con MSM', 'descripcion' => 'Colágeno con metilsulfonilmetano', 'precio' => 44999, 'cantidad' => 11, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con Biotina', 'descripcion' => 'Colágeno con biotina para cabello y uñas', 'precio' => 42999, 'cantidad' => 13, 'url_imagen' => 'colageno.webp'],
            ['nombre' => 'Colágeno con Zinc', 'descripcion' => 'Colágeno con zinc para la piel', 'precio' => 39999, 'cantidad' => 16, 'url_imagen' => 'colageno.webp']
        ],
        'accesorios' => [
            ['nombre' => 'Shaker Profesional', 'descripcion' => 'Shaker de 600ml con bola mezcladora', 'precio' => 15999, 'cantidad' => 30, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Cinturón de Levantamiento', 'descripcion' => 'Cinturón de cuero para powerlifting', 'precio' => 89999, 'cantidad' => 12, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Guantes de Gimnasio', 'descripcion' => 'Guantes con protección para callos', 'precio' => 29999, 'cantidad' => 25, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Botella de Agua 1L', 'descripcion' => 'Botella deportiva con pico', 'precio' => 19999, 'cantidad' => 40, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Toalla de Microfibra', 'descripcion' => 'Toalla deportiva absorbente', 'precio' => 12999, 'cantidad' => 35, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Bandas de Resistencia', 'descripcion' => 'Set de 5 bandas de diferentes resistencias', 'precio' => 24999, 'cantidad' => 20, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Rodillo de Espuma', 'descripcion' => 'Rodillo para masaje muscular', 'precio' => 18999, 'cantidad' => 18, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Mochila Deportiva', 'descripcion' => 'Mochila con compartimento para zapatos', 'precio' => 59999, 'cantidad' => 15, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Reloj Deportivo', 'descripcion' => 'Reloj con monitor de frecuencia cardíaca', 'precio' => 199999, 'cantidad' => 8, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Auriculares Inalámbricos', 'descripcion' => 'Auriculares deportivos resistentes al sudor', 'precio' => 89999, 'cantidad' => 12, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Cinta de Muñeca', 'descripcion' => 'Cinta de soporte para muñecas', 'precio' => 9999, 'cantidad' => 45, 'url_imagen' => 'accesorios.webp'],
            ['nombre' => 'Calcetines Deportivos', 'descripcion' => 'Pack de 3 pares de calcetines técnicos', 'precio' => 15999, 'cantidad' => 30, 'url_imagen' => 'accesorios.webp']
        ]
    ];
    
    // Limpiar productos existentes
    echo "🧹 Limpiando productos existentes...\n";
    $pdo->exec("DELETE FROM productos");
    $pdo->exec("ALTER TABLE productos AUTO_INCREMENT = 1");
    echo "✓ Productos eliminados\n\n";
    
    // Insertar productos
    $stmt = $pdo->prepare("INSERT INTO productos (id_categoria, nombre, descripcion, precio, cantidad, url_imagen, activo) VALUES (?, ?, ?, ?, ?, ?, 1)");
    
    $totalProductos = 0;
    
    foreach ($categorias as $categoria) {
        $categoriaNombre = strtolower($categoria['nombre']);
        $idCategoria = $categoria['id_categoria'];
        
        if (isset($productos[$categoriaNombre])) {
            echo "📦 Insertando productos de {$categoria['nombre']}...\n";
            
            foreach ($productos[$categoriaNombre] as $producto) {
                $stmt->execute([
                    $idCategoria,
                    $producto['nombre'],
                    $producto['descripcion'],
                    $producto['precio'],
                    $producto['cantidad'],
                    $producto['url_imagen']
                ]);
                $totalProductos++;
                echo "  ✓ {$producto['nombre']}\n";
            }
            echo "\n";
        }
    }
    
    echo "✅ ¡Población completada!\n";
    echo "📊 Total de productos insertados: $totalProductos\n";
    echo "🎯 Ahora puedes probar la paginación y filtrado en:\n";
    echo "   - Categorías: /categoria/proteinas, /categoria/creatinas, etc.\n";
    echo "   - Búsqueda: /buscar\n";
    
} catch (PDOException $e) {
    echo "❌ Error de base de datos: " . $e->getMessage() . "\n";
    exit(1);
} 