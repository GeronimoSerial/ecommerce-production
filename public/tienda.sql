-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-06-2025 a las 07:40:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compras`
--

CREATE TABLE `carrito_compras` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `fecha_agregado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla para el carrito de compras';

--
-- Volcado de datos para la tabla `carrito_compras`
--

INSERT INTO `carrito_compras` (`id_carrito`, `id_usuario`, `id_producto`, `cantidad`, `precio_unitario`, `fecha_agregado`) VALUES
(54, 6, 100, 4, 64999.00, '2025-06-21 04:34:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` bigint(20) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `activo`) VALUES
(9, 'Proteinas', 'Suplementos de proteína para el desarrollo muscular y recuperación', 1),
(10, 'Creatinas', 'Suplementos de creatina para mejorar el rendimiento y fuerza', 1),
(11, 'Colagenos', 'Suplementos de colágeno para la salud de articulaciones y piel', 1),
(12, 'Accesorios', 'Accesorios y equipamiento para entrenamiento', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id_contacto` int(11) NOT NULL,
  `id_usuario` bigint(20) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `respondido` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_respuesta` datetime DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  `id_admin_responde` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id_contacto`, `id_usuario`, `nombre`, `email`, `asunto`, `mensaje`, `fecha_envio`, `leido`, `respondido`, `fecha_respuesta`, `respuesta`, `id_admin_responde`) VALUES
(1, 7, 'Pedro Picapiedra', 'pedropicapiedra@gmail.com', 'Testeo', 'testeooooooooo', '2025-06-21 02:23:35', 1, 1, '2025-06-21 02:31:00', 'Muchas gracias por probar el sistema de contacto', 6),
(2, 7, 'Pedro Picapiedra', 'pedropicapiedra@gmail.com', 'Nuevo mensajew', 'Nuevmo meansdjandaksjdnaskdnasd', '2025-06-21 02:33:05', 1, 0, NULL, NULL, NULL),
(3, 7, 'Pedro Picapiedra', 'pedropicapiedra@gmail.com', 'sin ver', 'Este es un mensaje sin verse\r\n', '2025-06-21 03:30:55', 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_factura`
--

CREATE TABLE `detalles_factura` (
  `id_detalle_factura` bigint(20) NOT NULL,
  `id_factura` bigint(20) DEFAULT NULL,
  `id_producto` bigint(20) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_factura`
--

INSERT INTO `detalles_factura` (`id_detalle_factura`, `id_factura`, `id_producto`, `cantidad`, `descuento`, `subtotal`) VALUES
(1, 1, 130, 1, 0.00, 89999.00),
(2, 2, 89, 1, 0.00, 89999.00),
(3, 3, 93, 1, 0.00, 109999.00),
(4, 4, 93, 3, 0.00, 329997.00),
(5, 5, 91, 3, 0.00, 239997.00),
(6, 6, 112, 16, 0.00, 719984.00),
(7, 6, 99, 1, 0.00, 44999.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilios`
--

CREATE TABLE `domicilios` (
  `id_domicilio` bigint(20) NOT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `domicilios`
--

INSERT INTO `domicilios` (`id_domicilio`, `calle`, `numero`, `codigo_postal`, `localidad`, `provincia`, `pais`, `activo`) VALUES
(4, 'Mendoza 1007', '1', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1),
(5, 'Mendoza 1007', '1', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1),
(6, 'Berutti 2267', '1', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1),
(9, 'Por definir', '0', '0000', 'Por definir', 'Por definir', 'Por definir', 1),
(10, 'LucasR', '2025', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1),
(11, 'Mendoza 1007', '1', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1),
(12, 'Mendoza 1007', '1', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1),
(13, 'Gobernador Lopez', '195', 'W3402', 'Corrientes', 'Corrientes', 'Argentina', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` bigint(20) NOT NULL,
  `id_usuario` bigint(20) DEFAULT NULL,
  `importe_total` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `fecha_factura` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `id_usuario`, `importe_total`, `descuento`, `activo`, `fecha_factura`) VALUES
(1, 6, 108898.79, 0.00, 1, '2025-06-21 01:28:15'),
(2, 7, 108898.79, 0.00, 1, '2025-06-21 01:35:55'),
(3, 6, 133098.79, 0.00, 1, '2025-06-21 01:41:12'),
(4, 6, 399296.37, 0.00, 1, '2025-06-21 01:48:01'),
(5, 6, 290396.37, 0.00, 1, '2025-06-21 01:49:33'),
(6, 6, 925629.43, 0.00, 1, '2025-06-21 01:56:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` bigint(20) NOT NULL,
  `dni` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `id_domicilio` bigint(20) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `dni`, `nombre`, `apellido`, `id_domicilio`, `telefono`) VALUES
(4, NULL, 'Geronimo', 'Serial', 4, '03794376025'),
(5, NULL, 'Geronimo', 'Serial', 5, '03794376025'),
(6, '12345678', 'Juan', 'Perez', 6, '3794376025'),
(9, NULL, 'Pedro', 'Picapiedra', 9, '0000000000'),
(10, NULL, 'asdasd', 'asdasd', NULL, NULL),
(11, '10908773', 'Lucas ', 'Rodriguez', 10, '1090877354'),
(12, '10908773', 'Geronimo', 'Serial', 11, '0379437602'),
(13, '12312312', 'Geronimo', 'Serial', 12, '0379437602'),
(14, '23232342', 'María', 'Blanchet', 13, '0377760955');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` bigint(20) NOT NULL,
  `id_categoria` bigint(20) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `url_imagen` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `cantidad_vendidos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre`, `descripcion`, `precio`, `cantidad`, `url_imagen`, `activo`, `cantidad_vendidos`) VALUES
(89, 9, 'Whey Protein Gold Standard', 'Proteína de suero premium con 24g de proteína por porción', 89999.00, 8, 'isolated.webp', 1, 9),
(90, 9, 'Whey Protein Isolate', 'Proteína aislada de alta pureza, baja en carbohidratos', 99999.00, 12, 'isolated.webp', 1, 7),
(91, 9, 'Caseína Micelar', 'Proteína de liberación lenta para la noche', 79999.00, 0, 'caseina.webp', 1, 14),
(92, 9, 'Proteína Vegana Blend', 'Mezcla de proteínas vegetales premium', 69999.00, 10, 'vegan.webp', 1, 0),
(93, 9, 'Mass Gainer Ultra', 'Ganador de masa con extra calorías y proteínas', 109999.00, 0, 'mass_gainer.webp', 1, 12),
(94, 9, 'Whey Protein Concentrate', 'Proteína concentrada de suero de leche', 59999.00, 20, 'micronizada.webp', 1, 0),
(96, 9, 'Proteína de Huevo', 'Proteína de clara de huevo en polvo', 49999.00, 14, 'vegan.webp', 1, 0),
(97, 9, 'Proteína de Carne', 'Proteína de res hidrolizada', 89999.00, 7, 'caseina.webp', 1, 0),
(98, 9, 'Proteína de Guisante', 'Proteína vegetal de guisante orgánico', 54999.00, 11, 'vegan.webp', 1, 0),
(99, 9, 'Proteína de Arroz', 'Proteína de arroz integral', 44999.00, 8, 'vegan.webp', 1, 1),
(100, 9, 'Proteína de Cáñamo', 'Proteína de semillas de cáñamo', 64999.00, 6, 'vegan.webp', 1, 0),
(101, 10, 'Creatina Monohidrato', 'Creatina pura micronizada para fuerza y potencia', 29999.00, 25, 'creatina.webp', 1, 0),
(102, 10, 'Creatina HCL', 'Creatina hidrocloruro, mejor absorción', 39999.00, 18, 'creatina.webp', 1, 0),
(103, 10, 'Creatina Etil Éster', 'Creatina de absorción mejorada', 44999.00, 12, 'creatina.webp', 1, 0),
(104, 10, 'Creatina Malato', 'Creatina con ácido málico', 34999.00, 15, 'creatina.webp', 1, 0),
(105, 10, 'Creatina Citrato', 'Creatina con ácido cítrico', 37999.00, 10, 'creatina.webp', 1, 0),
(106, 10, 'Creatina Magnesio Quelado', 'Creatina con magnesio para mejor absorción', 42999.00, 8, 'creatina.webp', 1, 0),
(107, 10, 'Creatina Kre-Alkalyn', 'Creatina tamponada de pH', 49999.00, 6, 'creatina.webp', 1, 0),
(108, 10, 'Creatina Nitrato', 'Creatina con nitratos para vasodilatación', 46999.00, 9, 'creatina.webp', 1, 0),
(109, 10, 'Creatina Fosfato', 'Creatina con fosfato para energía', 39999.00, 11, 'creatina.webp', 1, 0),
(110, 10, 'Creatina Piruvato', 'Creatina con piruvato para resistencia', 44999.00, 7, 'creatina.webp', 1, 0),
(111, 11, 'Colágeno Hidrolizado', 'Colágeno tipo I y III hidrolizado', 39999.00, 20, 'colageno.webp', 1, 0),
(112, 11, 'Colágeno Marino', 'Colágeno de pescado de aguas profundas', 44999.00, 0, 'colageno.webp', 1, 26),
(113, 11, 'Colágeno Bovino', 'Colágeno de res tipo I y III', 34999.00, 18, 'colageno.webp', 1, 0),
(114, 11, 'Colágeno con Vitamina C', 'Colágeno hidrolizado con vitamina C', 42999.00, 14, 'colageno.webp', 1, 0),
(115, 11, 'Colágeno con Ácido Hialurónico', 'Colágeno con ácido hialurónico', 47999.00, 12, 'colageno.webp', 1, 0),
(116, 11, 'Colágeno con Magnesio', 'Colágeno con magnesio para articulaciones', 39999.00, 15, 'colageno.webp', 1, 0),
(117, 11, 'Colágeno con Glucosamina', 'Colágeno con glucosamina y condroitina', 49999.00, 10, 'colageno.webp', 1, 6),
(118, 11, 'Colágeno con MSM', 'Colágeno con metilsulfonilmetano', 44999.00, 11, 'colageno.webp', 1, 0),
(119, 11, 'Colágeno con Biotina', 'Colágeno con biotina para cabello y uñas', 42999.00, 13, 'colageno.webp', 1, 0),
(120, 11, 'Colágeno con Zinc', 'Colágeno con zinc para la piel', 39999.00, 16, 'colageno.webp', 1, 0),
(121, 12, 'Shaker Profesional', 'Shaker de 600ml con bola mezcladora', 15999.00, 20, 'accesorios.webp', 1, 10),
(122, 12, 'Cinturón de Levantamiento', 'Cinturón de cuero para powerlifting', 89999.00, 12, 'accesorios.webp', 1, 0),
(123, 12, 'Guantes de Gimnasio', 'Guantes con protección para callos', 29999.00, 25, 'accesorios.webp', 1, 0),
(124, 12, 'Botella de Agua 1L', 'Botella deportiva con pico', 19999.00, 38, 'accesorios.webp', 1, 2),
(125, 12, 'Toalla de Microfibra', 'Toalla deportiva absorbente', 12999.00, 35, 'accesorios.webp', 1, 0),
(126, 12, 'Bandas de Resistencia', 'Set de 5 bandas de diferentes resistencias', 24999.00, 19, 'accesorios.webp', 1, 2),
(127, 12, 'Rodillo de Espuma', 'Rodillo para masaje muscular', 18999.00, 3, 'accesorios.webp', 1, 0),
(128, 12, 'Mochila Deportiva', 'Mochila con compartimento para zapatos', 59999.00, 15, 'accesorios.webp', 1, 0),
(129, 12, 'Reloj Deportivo', 'Reloj con monitor de frecuencia cardíaca', 199999.00, 20, 'accesorios.webp', 1, 0),
(130, 12, 'Auriculares Inalámbricos', 'Auriculares deportivos resistentes al sudor', 89999.00, 72, 'accesorios.webp', 1, 93),
(131, 12, 'Cinta de Muñeca', 'Cinta de soporte para muñecas', 9999.00, 45, 'accesorios.webp', 1, 0),
(132, 12, 'Calcetines Deportivos', 'Pack de 3 pares de calcetines técnicos', 15999.00, 30, 'accesorios.webp', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` bigint(20) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Administrador', 'Rol con acceso total al sistema', 1),
(2, 'Usuario', 'Rol por defecto para usuarios registrados', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) NOT NULL,
  `id_persona` bigint(20) DEFAULT NULL,
  `id_rol` bigint(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `id_rol`, `email`, `password_hash`, `activo`) VALUES
(6, 6, 1, 'usuarioprueba@gmail.com', '$2y$10$glxpfSApaW3B1QM0R40vXOnYB1frSpR50Jdp2vk0R53w1lv4n3t.q', 1),
(7, 9, 2, 'pedropicapiedra@gmail.com', '$2y$10$N3IXFrCMBfpuKnRGtirNvuZ6OANnzQi311MM6WnJ5W4jDmdewgjBi', 1),
(9, 11, 2, 'lucasr@gmail.com', '$2y$10$NKDCb6dH7occMGKuJCD97edgumdoAL4TaQeSrEYK2Xh2eORSjPOcG', 1),
(12, 14, 2, 'mariaesmilse_15@hotmail.com', '$2y$10$cz9eJBVZgJ4vlevg4c6UXu5cW7.R84Ea9Yf9u9QIoHqUysEnAKxhG', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD PRIMARY KEY (`id_carrito`),
  ADD UNIQUE KEY `usuario_producto_unico` (`id_usuario`,`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `fecha_envio` (`fecha_envio`),
  ADD KEY `leido` (`leido`),
  ADD KEY `contactos_ibfk_2` (`id_admin_responde`);

--
-- Indices de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD PRIMARY KEY (`id_detalle_factura`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `domicilios`
--
ALTER TABLE `domicilios`
  ADD PRIMARY KEY (`id_domicilio`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `id_domicilio` (`id_domicilio`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  MODIFY `id_detalle_factura` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `domicilios`
--
ALTER TABLE `domicilios`
  MODIFY `id_domicilio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `contactos_ibfk_2` FOREIGN KEY (`id_admin_responde`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD CONSTRAINT `detalles_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id_factura`),
  ADD CONSTRAINT `detalles_factura_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_domicilio`) REFERENCES `domicilios` (`id_domicilio`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
