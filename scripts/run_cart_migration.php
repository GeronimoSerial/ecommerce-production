<?php

/**
 * Script para ejecutar la migración del carrito de compras
 * 
 * Uso: php scripts/run_cart_migration.php
 */

// Definir constantes necesarias
define('FCPATH', __DIR__ . '/../');
define('APPPATH', FCPATH . 'app/');
define('SYSTEMPATH', FCPATH . 'system/');
define('WRITEPATH', FCPATH . 'writable/');
define('ENVIRONMENT', 'development');

// Cargar el autoloader de Composer si existe
if (file_exists(FCPATH . 'vendor/autoload.php')) {
    require_once FCPATH . 'vendor/autoload.php';
}

// Cargar CodeIgniter
require_once SYSTEMPATH . 'bootstrap.php';

echo "=== Ejecutando migración del carrito de compras ===\n";

try {
    // Conectar a la base de datos
    $db = \Config\Database::connect();
    
    // Verificar conexión
    if (!$db->connect(false)) {
        throw new Exception("No se pudo conectar a la base de datos");
    }
    
    echo "✅ Conexión a la base de datos exitosa\n";
    
    // Crear la tabla manualmente
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
    
    $db->query($sql);
    
    echo "✅ Tabla 'carrito_compras' creada exitosamente\n";
    
    // Verificar que la tabla existe
    $tables = $db->listTables();
    
    if (in_array('carrito_compras', $tables)) {
        echo "✅ Verificación: La tabla existe en la base de datos\n";
        
        // Mostrar estructura de la tabla
        $fields = $db->getFieldNames('carrito_compras');
        echo "📋 Campos de la tabla:\n";
        foreach ($fields as $field) {
            echo "   - $field\n";
        }
        
        // Mostrar información de la tabla
        $result = $db->query("SHOW CREATE TABLE carrito_compras")->getRow();
        echo "\n📋 Estructura completa:\n";
        echo $result->{'Create Table'} . "\n";
        
    } else {
        echo "❌ Error: La tabla no se creó correctamente\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error al ejecutar la migración: " . $e->getMessage() . "\n";
    echo "📋 Detalles del error:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Fin del script ===\n"; 