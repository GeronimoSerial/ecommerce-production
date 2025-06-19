-- Script para poblar la base de datos con categorías y productos de ejemplo
-- Ejecutar este script en tu base de datos MySQL

-- Insertar categorías
INSERT INTO categorias (nombre, descripcion, activo) VALUES
('Proteinas', 'Suplementos de proteína para el desarrollo muscular y recuperación', 1),
('Creatinas', 'Suplementos de creatina para mejorar el rendimiento y fuerza', 1),
('Colagenos', 'Suplementos de colágeno para la salud de articulaciones y piel', 1),
('Accesorios', 'Accesorios y equipamiento para entrenamiento', 1);

-- Insertar productos de ejemplo
-- Proteínas
INSERT INTO productos (id_categoria, nombre, descripcion, precio, cantidad, url_imagen, activo) VALUES
(1, 'Whey Protein Isolate', 'Proteína de suero aislada de alta pureza, ideal para recuperación muscular post-entrenamiento', 49999, 25, 'isolated.webp', 1),
(1, 'Whey Protein Concentrate', 'Proteína concentrada de suero con excelente perfil de aminoácidos', 39999, 30, 'micronizada.webp', 1),
(1, 'Caseína Micelar', 'Proteína de liberación lenta perfecta para tomar antes de dormir', 44999, 15, 'caseina.webp', 1),
(1, 'Plant Protein Ultra', 'Blend de proteínas vegetales premium para deportistas veganos', 45999, 20, 'vegan.webp', 1),
(1, 'Mass Gainer Ultra', 'Ganador de masa muscular con extra calorías y carbohidratos', 54999, 12, 'mass_gainer.webp', 1);

-- Creatinas
INSERT INTO productos (id_categoria, nombre, descripcion, precio, cantidad, url_imagen, activo) VALUES
(2, 'Creatina Monohidrato', 'Creatina monohidrato pura para aumentar fuerza y masa muscular', 29999, 40, 'creatina_monohidrato.webp', 1),
(2, 'Creatina HCL', 'Creatina hidrocloruro de rápida absorción y sin retención de agua', 34999, 35, 'creatina_hcl.webp', 1),
(2, 'Creatina Micronizada', 'Creatina micronizada para mejor solubilidad y absorción', 27999, 28, 'creatina_micronizada.webp', 1),
(2, 'Creatina Kre-Alkalyn', 'Creatina con pH optimizado para máxima efectividad', 38999, 22, 'creatina_kre_alkalyn.webp', 1);

-- Colágenos
INSERT INTO productos (id_categoria, nombre, descripcion, precio, cantidad, url_imagen, activo) VALUES
(3, 'Colágeno Hidrolizado', 'Colágeno hidrolizado para la salud de articulaciones y piel', 35999, 45, 'colageno_hidrolizado.webp', 1),
(3, 'Colágeno con Vitamina C', 'Colágeno enriquecido con vitamina C para mejor absorción', 39999, 38, 'colageno_vitamina_c.webp', 1),
(3, 'Colágeno Marino', 'Colágeno de pescado de alta biodisponibilidad', 42999, 25, 'colageno_marino.webp', 1),
(3, 'Colágeno Tipo I y III', 'Blend de colágenos para salud articular y cutánea', 37999, 32, 'colageno_tipo_1_3.webp', 1);

-- Accesorios
INSERT INTO productos (id_categoria, nombre, descripcion, precio, cantidad, url_imagen, activo) VALUES
(4, 'Shaker Pro 600ml', 'Shaker profesional de 600ml con bola mezcladora', 15999, 60, 'shaker_pro.webp', 1),
(4, 'Cinturón de Levantamiento', 'Cinturón de cuero para levantamiento de pesas', 29999, 18, 'cinturon_levantamiento.webp', 1),
(4, 'Guantes de Gimnasio', 'Guantes con protección para palmas y muñecas', 12999, 45, 'guantes_gimnasio.webp', 1),
(4, 'Botella Deportiva 1L', 'Botella de agua deportiva con filtro integrado', 8999, 80, 'botella_deportiva.webp', 1),
(4, 'Bandas de Resistencia', 'Set de bandas elásticas para entrenamiento funcional', 19999, 35, 'bandas_resistencia.webp', 1);

-- Insertar roles de usuario
INSERT INTO roles (nombre, descripcion, activo) VALUES
('Administrador', 'Acceso completo al sistema', 1),
('Cliente', 'Usuario regular del ecommerce', 1);

-- Insertar domicilio de ejemplo
INSERT INTO domicilios (calle, numero, codigo_postal, localidad, provincia, pais, activo) VALUES
('Av. Principal', '123', '5000', 'Córdoba', 'Córdoba', 'Argentina', 1);

-- Insertar persona de ejemplo
INSERT INTO personas (dni, nombre, apellido, id_domicilio, telefono) VALUES
('12345678', 'Admin', 'Sistema', 1, '3511234567');

-- Insertar usuario administrador de ejemplo
-- Password: admin123 (hasheado con password_hash)
INSERT INTO usuarios (id_persona, id_rol, email, password_hash, activo) VALUES
(1, 1, 'admin@fitsyn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1); 