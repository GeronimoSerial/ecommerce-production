# 🗄️ Configuración de Base de Datos - FitSyn Ecommerce

## 📋 Requisitos Previos

- MySQL 5.7+ o MariaDB 10.2+
- PHP 7.4+
- Servidor web (Apache/Nginx)

## 🚀 Pasos para Configurar la Base de Datos

### 1. Crear la Base de Datos

```sql
CREATE DATABASE ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecommerce;
```

### 2. Crear las Tablas

Ejecuta el contenido del archivo `bd.txt` en tu base de datos MySQL:

```bash
# Opción 1: Desde línea de comandos
mysql -u root -p ecommerce < bd.txt

# Opción 2: Desde phpMyAdmin
# Copia y pega el contenido de bd.txt en la pestaña SQL
```

### 3. Poblar con Datos de Ejemplo

#### Opción A: Script PHP (Recomendado)

1. **Actualiza las credenciales** en `insert_data.php`:

   ```php
   $host = 'localhost';
   $dbname = 'ecommerce'; // Tu nombre de base de datos
   $username = 'root';    // Tu usuario MySQL
   $password = '';        // Tu contraseña MySQL
   ```

2. **Ejecuta el script**:

   ```bash
   # Desde línea de comandos
   php insert_data.php

   # O desde el navegador
   http://localhost/ecommerce/insert_data.php
   ```

#### Opción B: SQL Directo

Ejecuta el contenido del archivo `database_seed.sql` en tu base de datos.

### 4. Verificar la Instalación

Después de ejecutar el script, deberías ver:

```
🌱 Conectado a la base de datos. Poblando con datos de ejemplo...
📂 Insertando categorías...
✅ Categorías insertadas
📦 Insertando productos...
✅ Productos insertados
👥 Insertando roles...
✅ Roles insertados
👤 Insertando usuario administrador...
✅ Usuario administrador insertado

🎉 ¡Base de datos poblada exitosamente!
📧 Usuario admin: admin@fitsyn.com
🔑 Contraseña: admin123
```

## 🌐 URLs Disponibles

Una vez configurada la base de datos, podrás acceder a:

- **Categorías:**

  - http://localhost/ecommerce/categoria/proteinas
  - http://localhost/ecommerce/categoria/creatinas
  - http://localhost/ecommerce/categoria/colagenos
  - http://localhost/ecommerce/categoria/accesorios

- **Búsqueda:**

  - http://localhost/ecommerce/productos/buscar

- **Detalles de Producto:**
  - http://localhost/ecommerce/producto/1
  - http://localhost/ecommerce/producto/2
  - etc.

## 🔧 Solución de Problemas

### Error: "Table doesn't exist"

- Asegúrate de haber ejecutado el script `bd.txt` completo
- Verifica que estés en la base de datos correcta

### Error: "Access denied"

- Verifica las credenciales de MySQL en `insert_data.php`
- Asegúrate de que el usuario tenga permisos de escritura

### Error: "Connection failed"

- Verifica que MySQL esté ejecutándose
- Comprueba el host y puerto de conexión

### Error 404 en las URLs

- Verifica que las categorías existan en la base de datos
- Comprueba que los productos estén marcados como activos (`activo = 1`)

## 📊 Datos Insertados

### Categorías (4)

- **Proteinas** - Suplementos de proteína
- **Creatinas** - Suplementos de creatina
- **Colagenos** - Suplementos de colágeno
- **Accesorios** - Equipamiento de entrenamiento

### Productos (18)

- **5 Proteínas** (Whey Isolate, Concentrate, Caseína, Vegana, Mass Gainer)
- **4 Creatinas** (Monohidrato, HCL, Micronizada, Kre-Alkalyn)
- **4 Colágenos** (Hidrolizado, con Vitamina C, Marino, Tipo I y III)
- **5 Accesorios** (Shaker, Cinturón, Guantes, Botella, Bandas)

### Usuario Administrador

- **Email:** admin@fitsyn.com
- **Contraseña:** admin123
- **Rol:** Administrador

## 🗑️ Limpiar Base de Datos (Opcional)

Si necesitas empezar de nuevo:

```sql
-- Eliminar datos existentes
DELETE FROM detallesfactura;
DELETE FROM productos;
DELETE FROM categorias;
DELETE FROM usuarios;
DELETE FROM personas;
DELETE FROM domicilios;
DELETE FROM roles;

-- Reiniciar auto-increment
ALTER TABLE detallesfactura AUTO_INCREMENT = 1;
ALTER TABLE productos AUTO_INCREMENT = 1;
ALTER TABLE categorias AUTO_INCREMENT = 1;
ALTER TABLE usuarios AUTO_INCREMENT = 1;
ALTER TABLE personas AUTO_INCREMENT = 1;
ALTER TABLE domicilios AUTO_INCREMENT = 1;
ALTER TABLE roles AUTO_INCREMENT = 1;
```

## ✅ Verificación Final

Para verificar que todo funciona correctamente:

1. Accede a http://localhost/ecommerce/
2. Haz clic en "PRODUCTOS" en el navbar
3. Selecciona cualquier categoría
4. Deberías ver los productos listados
5. Haz clic en "Buscar Productos" para probar la búsqueda

¡Si todo funciona, tu ecommerce está listo! 🎉
