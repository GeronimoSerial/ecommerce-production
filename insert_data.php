<?php
/**
 * Script para insertar datos de ejemplo en la base de datos
 * Ejecutar desde el navegador o línea de comandos
 */

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'ecommerce'; // Cambiar por el nombre de tu base de datos
$username = 'root'; // Cambiar por tu usuario de MySQL
$password = ''; // Cambiar por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🌱 Conectado a la base de datos. Poblando con datos de ejemplo...\n";
    
    // Insertar categorías
    echo "📂 Insertando categorías...\n";
    $categorias = [
        ['nombre' => 'Proteinas', 'descripcion' => 'Suplementos de proteína para el desarrollo muscular y recuperación', 'activo' => 1],
        ['nombre' => 'Creatinas', 'descripcion' => 'Suplementos de creatina para mejorar el rendimiento y fuerza', 'activo' => 1],
        ['nombre' => 'Colagenos', 'descripcion' => 'Suplementos de colágeno para la salud de articulaciones y piel', 'activo' => 1],
        ['nombre' => 'Accesorios', 'descripcion' => 'Accesorios y equipamiento para entrenamiento', 'activo' => 1]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO categorias (nombre, descripcion, activo) VALUES (?, ?, ?)");
    foreach ($categorias as $categoria) {
        $stmt->execute($categoria);
    }
    echo "✅ Categorías insertadas\n";
    
    // Insertar productos
    echo "📦 Insertando productos...\n";
    $productos = [
        // Proteínas
        [1, 'Whey Protein Isolate', 'Proteína de suero aislada de alta pureza, ideal para recuperación muscular post-entrenamiento', 49999, 25, 'isolated.webp', 1],
        [1, 'Whey Protein Concentrate', 'Proteína concentrada de suero con excelente perfil de aminoácidos', 39999, 30, 'micronizada.webp', 1],
        [1, 'Caseína Micelar', 'Proteína de liberación lenta perfecta para tomar antes de dormir', 44999, 15, 'caseina.webp', 1],
        [1, 'Plant Protein Ultra', 'Blend de proteínas vegetales premium para deportistas veganos', 45999, 20, 'vegan.webp', 1],
        [1, 'Mass Gainer Ultra', 'Ganador de masa muscular con extra calorías y carbohidratos', 54999, 12, 'mass_gainer.webp', 1],
        
        // Creatinas
        [2, 'Creatina Monohidrato', 'Creatina monohidrato pura para aumentar fuerza y masa muscular', 29999, 40, 'creatina_monohidrato.webp', 1],
        [2, 'Creatina HCL', 'Creatina hidrocloruro de rápida absorción y sin retención de agua', 34999, 35, 'creatina_hcl.webp', 1],
        [2, 'Creatina Micronizada', 'Creatina micronizada para mejor solubilidad y absorción', 27999, 28, 'creatina_micronizada.webp', 1],
        [2, 'Creatina Kre-Alkalyn', 'Creatina con pH optimizado para máxima efectividad', 38999, 22, 'creatina_kre_alkalyn.webp', 1],
        
        // Colágenos
        [3, 'Colágeno Hidrolizado', 'Colágeno hidrolizado para la salud de articulaciones y piel', 35999, 45, 'colageno_hidrolizado.webp', 1],
        [3, 'Colágeno con Vitamina C', 'Colágeno enriquecido con vitamina C para mejor absorción', 39999, 38, 'colageno_vitamina_c.webp', 1],
        [3, 'Colágeno Marino', 'Colágeno de pescado de alta biodisponibilidad', 42999, 25, 'colageno_marino.webp', 1],
        [3, 'Colágeno Tipo I y III', 'Blend de colágenos para salud articular y cutánea', 37999, 32, 'colageno_tipo_1_3.webp', 1],
        
        // Accesorios
        [4, 'Shaker Pro 600ml', 'Shaker profesional de 600ml con bola mezcladora', 15999, 60, 'shaker_pro.webp', 1],
        [4, 'Cinturón de Levantamiento', 'Cinturón de cuero para levantamiento de pesas', 29999, 18, 'cinturon_levantamiento.webp', 1],
        [4, 'Guantes de Gimnasio', 'Guantes con protección para palmas y muñecas', 12999, 45, 'guantes_gimnasio.webp', 1],
        [4, 'Botella Deportiva 1L', 'Botella de agua deportiva con filtro integrado', 8999, 80, 'botella_deportiva.webp', 1],
        [4, 'Bandas de Resistencia', 'Set de bandas elásticas para entrenamiento funcional', 19999, 35, 'bandas_resistencia.webp', 1]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO productos (id_categoria, nombre, descripcion, precio, cantidad, url_imagen, activo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($productos as $producto) {
        $stmt->execute($producto);
    }
    echo "✅ Productos insertados\n";
    
    // Insertar roles
    echo "👥 Insertando roles...\n";
    $roles = [
        ['nombre' => 'Administrador', 'descripcion' => 'Acceso completo al sistema', 'activo' => 1],
        ['nombre' => 'Cliente', 'descripcion' => 'Usuario regular del ecommerce', 'activo' => 1]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO roles (nombre, descripcion, activo) VALUES (?, ?, ?)");
    foreach ($roles as $rol) {
        $stmt->execute($rol);
    }
    echo "✅ Roles insertados\n";
    
    // Insertar usuario administrador
    echo "👤 Insertando usuario administrador...\n";
    
    // Insertar domicilio
    $stmt = $pdo->prepare("INSERT INTO domicilios (calle, numero, codigo_postal, localidad, provincia, pais, activo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Av. Principal', '123', '5000', 'Córdoba', 'Córdoba', 'Argentina', 1]);
    $domicilioId = $pdo->lastInsertId();
    
    // Insertar persona
    $stmt = $pdo->prepare("INSERT INTO personas (dni, nombre, apellido, id_domicilio, telefono) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['12345678', 'Admin', 'Sistema', $domicilioId, '3511234567']);
    $personaId = $pdo->lastInsertId();
    
    // Insertar usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (id_persona, id_rol, email, password_hash, activo) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$personaId, 1, 'admin@fitsyn.com', password_hash('admin123', PASSWORD_DEFAULT), 1]);
    
    echo "✅ Usuario administrador insertado\n";
    
    echo "\n🎉 ¡Base de datos poblada exitosamente!\n";
    echo "📧 Usuario admin: admin@fitsyn.com\n";
    echo "🔑 Contraseña: admin123\n";
    echo "\n🌐 Ahora puedes acceder a:\n";
    echo "- http://localhost/ecommerce/categoria/proteinas\n";
    echo "- http://localhost/ecommerce/categoria/creatinas\n";
    echo "- http://localhost/ecommerce/categoria/colagenos\n";
    echo "- http://localhost/ecommerce/categoria/accesorios\n";
    echo "- http://localhost/ecommerce/productos/buscar\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Asegúrate de:\n";
    echo "1. Tener MySQL/MariaDB ejecutándose\n";
    echo "2. Haber creado la base de datos 'ecommerce'\n";
    echo "3. Haber ejecutado el script bd.txt para crear las tablas\n";
    echo "4. Actualizar las credenciales de conexión en este archivo\n";
}
?> 