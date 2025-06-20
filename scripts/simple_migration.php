<?php

/**
 * Script simple para crear la tabla del carrito de compras
 * 
 * Uso: php scripts/simple_migration.php
 */

echo "=== Creando tabla del carrito de compras ===\n";

// Configuración de la base de datos (ajustar según tu configuración)
$host = 'localhost';
$dbname = 'tienda';    // Nombre de la base de datos del proyecto
$username = 'root';    // Cambiar por tu usuario de MySQL
$password = '';        // Cambiar por tu contraseña de MySQL

try {
    // Conectar a MySQL usando mysqli en lugar de PDO
    $mysqli = new mysqli($host, $username, $password, $dbname);
    
    // Verificar conexión
    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }
    
    echo "✅ Conexión a la base de datos exitosa\n";
    
    // SQL para crear la tabla
    $sql = "
    CREATE TABLE IF NOT EXISTS `carrito_compras` (
        `id_carrito` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `id_usuario` int(11) unsigned NOT NULL,
        `id_producto` int(11) unsigned NOT NULL,
        `cantidad` int(11) NOT NULL DEFAULT 1,
        `precio_unitario` decimal(10,2) NOT NULL,
        `fecha_agregado` datetime NOT NULL,
        PRIMARY KEY (`id_carrito`),
        UNIQUE KEY `usuario_producto` (`id_usuario`,`id_producto`),
        KEY `id_usuario` (`id_usuario`),
        KEY `id_producto` (`id_producto`),
        CONSTRAINT `carrito_compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `carrito_compras_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    // Ejecutar el SQL
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Tabla 'carrito_compras' creada exitosamente\n";
    } else {
        throw new Exception("Error al crear la tabla: " . $mysqli->error);
    }
    
    // Verificar que la tabla existe
    $result = $mysqli->query("SHOW TABLES LIKE 'carrito_compras'");
    if ($result->num_rows > 0) {
        echo "✅ Verificación: La tabla existe en la base de datos\n";
        
        // Mostrar estructura de la tabla
        $result = $mysqli->query("DESCRIBE carrito_compras");
        echo "📋 Campos de la tabla:\n";
        while ($row = $result->fetch_assoc()) {
            echo "   - {$row['Field']} ({$row['Type']}) - {$row['Null']} - {$row['Key']}\n";
        }
        
    } else {
        echo "❌ Error: La tabla no se creó correctamente\n";
    }
    
    // Cerrar conexión
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n📋 Verifica que:\n";
    echo "   1. El servidor MySQL esté ejecutándose\n";
    echo "   2. La base de datos '$dbname' exista\n";
    echo "   3. El usuario '$username' tenga permisos\n";
    echo "   4. Las credenciales sean correctas\n";
}

echo "\n=== Fin del script ===\n"; 