-- Script SQL para crear la tabla del carrito de compras
-- Ejecutar este script en tu base de datos MySQL

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

-- Verificar que la tabla se creó correctamente
SHOW CREATE TABLE carrito_compras;

-- Mostrar la estructura de la tabla
DESCRIBE carrito_compras; 