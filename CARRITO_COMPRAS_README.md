# 🛒 Sistema de Carrito de Compras - Ecommerce

## 📋 Descripción

Sistema completo de carrito de compras para la aplicación ecommerce, que incluye:

- **Carrito anónimo**: Los productos se guardan en sesión para usuarios no logueados
- **Carrito persistente**: Los productos se guardan en base de datos para usuarios logueados
- **Transferencia automática**: Al loguearse, el carrito de sesión se transfiere a la base de datos
- **Checkout completo**: Proceso de finalización de compra con validaciones
- **Gestión de stock**: Descuento automático del inventario al confirmar compra

## 🚀 Características Principales

### ✅ Carrito de Compras

- Agregar productos con cantidad personalizable
- Actualizar cantidades en tiempo real
- Eliminar productos individuales
- Vaciar carrito completo
- Cálculo automático de subtotales e impuestos
- Validación de stock disponible

### ✅ Gestión de Usuarios

- Carrito anónimo (sesión) para usuarios no logueados
- Carrito persistente (base de datos) para usuarios logueados
- Transferencia automática al loguearse
- Redirección inteligente después del login

### ✅ Checkout

- Resumen detallado de la compra
- Cálculo de impuestos (21%)
- Formulario de pago simulado
- Validaciones de stock antes de procesar
- Descuento automático del inventario
- Confirmación de compra exitosa

## 📁 Estructura de Archivos

```
app/
├── Controllers/
│   ├── CartController.php          # Controlador principal del carrito
│   └── CheckoutController.php      # Controlador del checkout
├── Models/
│   └── CartModel.php               # Modelo del carrito
├── Helpers/
│   └── cart_helper.php             # Funciones helper del carrito
├── Views/
│   └── pages/
│       ├── cart.php                # Vista del carrito
│       └── checkout.php            # Vista del checkout
├── Database/
│   └── Migrations/
│       └── 2024-01-01-000001_CreateCartTable.php
└── Config/
    ├── Routes.php                  # Rutas del carrito
    └── Autoload.php                # Configuración de helpers
```

## 🛠️ Instalación

### 1. Ejecutar la Migración

```bash
# Desde la raíz del proyecto
php scripts/run_cart_migration.php
```

### 2. Verificar Configuración

Asegúrate de que el helper del carrito esté registrado en `app/Config/Autoload.php`:

```php
public $helpers = [
    'url',
    'image',
    'pagination',
    'cart'  // ← Agregar esta línea
];
```

### 3. Verificar Rutas

Las rutas ya están configuradas en `app/Config/Routes.php`:

```php
// Rutas del carrito
$routes->get('/cart', 'CartController::index');
$routes->post('/cart/add', 'CartController::add');
$routes->post('/cart/updateQuantity', 'CartController::updateQuantity');
$routes->post('/cart/remove', 'CartController::remove');
$routes->post('/cart/clear', 'CartController::clear');
$routes->get('/cart/checkout', 'CartController::checkout');

// Rutas del checkout
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/confirm', 'CheckoutController::confirm');
```

## 📊 Estructura de la Base de Datos

### Tabla: `carrito_compras`

| Campo             | Tipo          | Descripción                           |
| ----------------- | ------------- | ------------------------------------- |
| `id_carrito`      | INT (PK)      | ID único del item del carrito         |
| `id_usuario`      | INT (FK)      | ID del usuario propietario            |
| `id_producto`     | INT (FK)      | ID del producto                       |
| `cantidad`        | INT           | Cantidad del producto                 |
| `precio_unitario` | DECIMAL(10,2) | Precio unitario al momento de agregar |
| `fecha_agregado`  | DATETIME      | Fecha y hora de agregado              |

**Índices:**

- `id_carrito` (PRIMARY KEY)
- `id_usuario` + `id_producto` (UNIQUE)
- `id_usuario` (FOREIGN KEY)
- `id_producto` (FOREIGN KEY)

## 🔧 Funcionalidades

### Carrito Anónimo (Sesión)

```php
// Agregar producto al carrito de sesión
add_to_session_cart($productoId, $cantidad, $precio, $nombre, $imagen);

// Obtener carrito de sesión
$cart = get_session_cart();

// Actualizar cantidad
update_session_cart_quantity($productoId, $cantidad);

// Eliminar producto
remove_from_session_cart($productoId);

// Vaciar carrito
clear_session_cart();
```

### Carrito Persistente (Base de Datos)

```php
// Agregar producto al carrito de BD
$cartModel->addToCart($usuarioId, $productoId, $cantidad, $precio);

// Obtener carrito del usuario
$cartItems = $cartModel->getCartByUser($usuarioId);

// Actualizar cantidad
$cartModel->updateQuantity($carritoId, $cantidad);

// Eliminar producto
$cartModel->removeFromCart($carritoId);

// Vaciar carrito
$cartModel->clearCart($usuarioId);
```

### Cálculos

```php
// Calcular subtotal
$subtotal = calculate_subtotal($items);

// Calcular impuestos (21%)
$tax = calculate_tax($subtotal);

// Calcular total
$total = calculate_total($subtotal);

// Formatear moneda
$formatted = format_currency($amount);
```

## 🎯 Flujo de Usuario

### 1. Usuario No Logueado

1. Agrega productos → Se guardan en sesión
2. Va al carrito → Ve productos de sesión
3. Presiona "Finalizar Compra" → Redirige a `/login`
4. Se loguea → Carrito de sesión se transfiere a BD
5. Redirige automáticamente a `/checkout`

### 2. Usuario Logueado

1. Agrega productos → Se guardan directamente en BD
2. Va al carrito → Ve productos de BD
3. Presiona "Finalizar Compra" → Va a `/checkout`
4. Completa checkout → Se procesa la compra
5. Se descuenta stock y se vacía carrito

## 🔒 Validaciones

### Stock

- No permite agregar más productos que el stock disponible
- Verifica stock antes de procesar checkout
- Muestra advertencias de stock bajo

### Precios

- No permite precios negativos
- Valida que el precio sea numérico
- Guarda precio al momento de agregar al carrito

### Cantidades

- Cantidad mínima: 1
- Cantidad máxima: stock disponible
- Solo números enteros positivos

## 🎨 Interfaz de Usuario

### Carrito (`/cart`)

- Lista de productos con imágenes
- Controles de cantidad (+/-)
- Subtotal por producto
- Resumen total con impuestos
- Botones de acción (eliminar, vaciar)
- Redirección inteligente según estado de login

### Checkout (`/checkout`)

- Información del cliente
- Detalle de productos
- Formulario de pago simulado
- Resumen de compra
- Confirmación final

## 🚨 Manejo de Errores

### Errores Comunes

- **Stock insuficiente**: Muestra mensaje específico
- **Producto no encontrado**: Redirige con error
- **Usuario no autenticado**: Redirige a login
- **Carrito vacío**: Muestra mensaje informativo

### Validaciones AJAX

- Respuestas JSON para operaciones asíncronas
- Mensajes de éxito/error en tiempo real
- Actualización automática de contadores

## 🔧 Personalización

### Cambiar Tasa de Impuestos

En `app/Helpers/cart_helper.php`:

```php
function calculate_tax($subtotal, $taxRate = 0.21) // Cambiar 0.21 por tu tasa
```

### Cambiar Moneda

En `app/Helpers/cart_helper.php`:

```php
function format_currency($amount, $currency = '$') // Cambiar '$' por tu símbolo
```

### Agregar Campos Adicionales

En la migración `CreateCartTable.php`:

```php
'campo_extra' => [
    'type' => 'VARCHAR',
    'constraint' => 255,
    'null' => true,
],
```

## 📝 Notas Importantes

1. **Transacciones**: El checkout usa transacciones de BD para garantizar consistencia
2. **Sesiones**: El carrito anónimo se pierde al cerrar el navegador
3. **Precios**: Se guardan al momento de agregar para evitar cambios posteriores
4. **Stock**: Se verifica en múltiples puntos para evitar overselling
5. **Seguridad**: Todas las operaciones están validadas y sanitizadas

## 🐛 Solución de Problemas

### Error: "Tabla no existe"

```bash
php scripts/run_cart_migration.php
```

### Error: "Helper no encontrado"

Verificar que `cart` esté en `app/Config/Autoload.php`

### Error: "Rutas no funcionan"

Verificar que las rutas estén en `app/Config/Routes.php`

### Error: "AJAX no responde"

Verificar que jQuery esté cargado en las vistas

## 📞 Soporte

Para reportar bugs o solicitar nuevas funcionalidades, crear un issue en el repositorio del proyecto.

---

**Desarrollado con ❤️ para el ecommerce**
