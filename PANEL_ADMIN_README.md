# Panel de Administración - FitSyn E-commerce

## Descripción General

El Panel de Administración es una interfaz completa para gestionar todos los aspectos del sistema de e-commerce FitSyn. Está diseñado exclusivamente para usuarios con rol de administrador (perfil_id = 1).

## Características Principales

### 🎯 Funcionalidades Implementadas

1. **Gestión de Usuarios**

   - Lista completa de usuarios registrados
   - Crear nuevos usuarios
   - Editar información de usuarios existentes
   - Eliminar usuarios
   - Asignar roles (Administrador/Usuario)
   - Estadísticas de usuarios por rol

2. **Control de Inventario**

   - Lista completa de productos
   - Agregar nuevos productos
   - Editar productos existentes
   - Eliminar productos
   - Control de stock
   - Alertas de stock bajo
   - Categorización de productos

3. **Reportes y Estadísticas**
   - Dashboard con métricas principales
   - Estadísticas de usuarios por mes
   - Distribución de productos por categoría
   - Alertas de stock bajo
   - Valor total del inventario

## Estructura del Sistema

### Controladores

- **AdminController.php**: Controlador principal del panel de administración
  - `index()`: Dashboard principal
  - `usuarios()`: Gestión de usuarios
  - `crearUsuario()`: Crear nuevo usuario
  - `editarUsuario($id)`: Editar usuario existente
  - `eliminarUsuario($id)`: Eliminar usuario
  - `inventario()`: Control de inventario
  - `crearProducto()`: Crear nuevo producto
  - `editarProducto($id)`: Editar producto existente
  - `eliminarProducto($id)`: Eliminar producto
  - `reportes()`: Reportes y estadísticas

### Modelos Actualizados

- **UsuarioModel.php**: Gestión de usuarios

  - `getAllUsersWithPersonas()`: Obtener usuarios con información de roles
  - `getUsersByRole($roleId)`: Filtrar usuarios por rol
  - `getActiveUsers()`: Obtener usuarios activos

- **ProductoModel.php**: Gestión de productos
  - `getAllProductsWithCategories()`: Obtener productos con categorías
  - `getProductsByCategory($categoryId)`: Filtrar por categoría
  - `getLowStockProducts($threshold)`: Productos con stock bajo

### Vistas

#### Dashboard Principal

- `back/admin/dashboard.php`: Vista principal del panel

#### Gestión de Usuarios

- `back/admin/usuarios/index.php`: Lista de usuarios
- `back/admin/usuarios/crear.php`: Formulario de creación
- `back/admin/usuarios/editar.php`: Formulario de edición

#### Control de Inventario

- `back/admin/inventario/index.php`: Lista de productos
- `back/admin/inventario/crear.php`: Formulario de creación
- `back/admin/inventario/editar.php`: Formulario de edición

#### Reportes

- `back/admin/reportes/index.php`: Reportes y estadísticas

### Rutas

```php
// Dashboard principal
GET /admin

// Gestión de Usuarios
GET /admin/usuarios
GET /admin/usuarios/crear
POST /admin/usuarios/crear
GET /admin/usuarios/editar/{id}
POST /admin/usuarios/editar/{id}
GET /admin/usuarios/eliminar/{id}

// Control de Inventario
GET /admin/inventario
GET /admin/inventario/crear
POST /admin/inventario/crear
GET /admin/inventario/editar/{id}
POST /admin/inventario/editar/{id}
GET /admin/inventario/eliminar/{id}

// Reportes y Estadísticas
GET /admin/reportes
```

## Seguridad

### Control de Acceso

- Todas las rutas del panel verifican que el usuario esté logueado
- Verificación de rol de administrador (perfil_id = 1)
- Redirección automática al login si no tiene permisos

### Validaciones

- Validación de formularios en el servidor
- Sanitización de datos de entrada
- Protección CSRF en todos los formularios
- Validación de tipos de datos y rangos

## Características de la Interfaz

### Diseño Responsivo

- Interfaz adaptativa para dispositivos móviles
- Diseño dark mode consistente
- Iconografía Bootstrap Icons
- Animaciones y transiciones suaves

### Experiencia de Usuario

- Navegación intuitiva
- Mensajes de confirmación
- Alertas de éxito y error
- Formularios con validación en tiempo real
- Tablas con ordenamiento y filtros

### Estadísticas Visuales

- Tarjetas de métricas principales
- Gráficos de barras para distribuciones
- Indicadores de estado con colores
- Progreso visual para comparaciones

## Instalación y Configuración

### Requisitos

- PHP 7.4 o superior
- CodeIgniter 4
- Base de datos MySQL/MariaDB
- Bootstrap 5.3.2
- Bootstrap Icons 1.11.1

### Configuración de Base de Datos

Asegúrate de que las tablas tengan la estructura correcta:

```sql
-- Tabla usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    perfil_id INT DEFAULT 2,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla productos
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    id_categoria INT,
    imagen VARCHAR(255),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla categorias
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);
```

### Archivos CSS

- `public/css/admin.css`: Estilos específicos del panel

## Uso del Sistema

### Acceso al Panel

1. Inicia sesión con una cuenta de administrador
2. Ve al panel de usuario
3. Haz clic en "Panel de Administración"

### Gestión de Usuarios

1. Navega a "Usuarios" en el menú
2. Usa "Crear Usuario" para agregar nuevos usuarios
3. Usa los botones de acción para editar o eliminar

### Control de Inventario

1. Navega a "Inventario" en el menú
2. Usa "Agregar Producto" para nuevos productos
3. Gestiona stock y categorías
4. Monitorea alertas de stock bajo

### Reportes

1. Navega a "Reportes" para ver estadísticas
2. Analiza métricas de usuarios y productos
3. Revisa distribuciones por categorías

## Mantenimiento

### Logs y Monitoreo

- Los errores se registran en los logs de CodeIgniter
- Mensajes flash para feedback del usuario
- Validaciones en tiempo real

### Backup y Seguridad

- Realiza backups regulares de la base de datos
- Mantén actualizadas las dependencias
- Revisa logs de acceso regularmente

## Personalización

### Temas y Colores

- Modifica `public/css/admin.css` para cambiar estilos
- Los colores principales están en variables CSS
- Soporte para temas personalizados

### Funcionalidades Adicionales

- El sistema está diseñado para ser extensible
- Agrega nuevos módulos siguiendo la estructura existente
- Mantén la consistencia en el diseño

## Soporte

Para soporte técnico o preguntas sobre el panel de administración:

- Revisa la documentación de CodeIgniter 4
- Consulta los logs de error
- Verifica la configuración de la base de datos

---

**Desarrollado por Geronimo Serial**
_Panel de Administración - FitSyn E-commerce_
