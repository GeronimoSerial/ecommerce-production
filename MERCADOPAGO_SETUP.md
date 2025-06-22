# Configuración de MercadoPago Checkout Pro

Este documento explica cómo configurar y usar la integración de MercadoPago Checkout Pro en el sistema de e-commerce.

## Requisitos Previos

1. **Cuenta de MercadoPago**: Necesitas una cuenta de MercadoPago (puede ser de prueba o producción)
2. **PHP 7.4+**: El sistema requiere PHP 7.4 o superior
3. **Composer**: Para instalar las dependencias

## Instalación

### 1. Instalar Dependencias

```bash
composer install
```

Esto instalará automáticamente el SDK de MercadoPago (`mercadopago/dx-php`).

### 2. Ejecutar Migración

```bash
php spark migrate
```

Esto creará la tabla `pagos` en la base de datos.

### 3. Configurar Credenciales

Edita el archivo `app/Config/MercadoPago.php` y actualiza las siguientes credenciales:

#### Para Pruebas (Sandbox)
```php
public $accessToken = 'TEST-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
public $publicKey = 'TEST-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
```

#### Para Producción
```php
public $accessToken = 'APP-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
public $publicKey = 'APP-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
```

### 4. Configurar Webhook (Opcional)

Para recibir notificaciones automáticas de MercadoPago, configura el webhook en tu panel de MercadoPago:

- **URL del Webhook**: `https://tudominio.com/mercadopago/webhook`
- **Eventos**: Selecciona "payment" para recibir notificaciones de pagos

## Estructura de Archivos

```
app/
├── Config/
│   └── MercadoPago.php              # Configuración de MercadoPago
├── Controllers/
│   └── MercadoPagoController.php    # Controlador principal
├── Models/
│   └── PagoModel.php                # Modelo para la tabla de pagos
├── Database/
│   └── Migrations/
│       └── 2024-01-01-000001_CreatePagosTable.php
└── Views/
    └── back/compras/
        └── checkout.php             # Vista modificada con botón de MP
```

## Funcionalidades Implementadas

### 1. Creación de Preferencias de Pago
- **Ruta**: `GET /mercadopago/create`
- **Función**: Crea una preferencia de pago y redirige al checkout de MercadoPago
- **Validaciones**: Stock disponible, usuario autenticado, carrito no vacío

### 2. Webhook para Notificaciones
- **Ruta**: `POST /mercadopago/webhook`
- **Función**: Recibe notificaciones automáticas de MercadoPago
- **Procesamiento**: Actualiza el estado del pago y procesa la factura si es aprobado

### 3. Páginas de Retorno
- **Éxito**: `GET /mercadopago/success`
- **Fallo**: `GET /mercadopago/failure`
- **Pendiente**: `GET /mercadopago/pending`

### 4. Historial de Pagos
- **Ruta**: `GET /mercadopago/history`
- **Función**: Obtiene el historial de pagos del usuario autenticado

## Flujo de Pago

1. **Usuario en Checkout**: El usuario ve el botón "Pagar con MercadoPago"
2. **Crear Preferencia**: Al hacer clic, se crea una preferencia de pago
3. **Redirección**: El usuario es redirigido al checkout de MercadoPago
4. **Pago**: El usuario completa el pago en MercadoPago
5. **Notificación**: MercadoPago envía una notificación al webhook
6. **Procesamiento**: El sistema procesa el pago y actualiza la factura
7. **Retorno**: El usuario es redirigido de vuelta al sitio

## Estados de Pago

- **pending**: Pago pendiente de confirmación
- **approved**: Pago aprobado
- **rejected**: Pago rechazado
- **cancelled**: Pago cancelado
- **in_process**: Pago en proceso
- **refunded**: Pago reembolsado

## Configuración Avanzada

### Moneda
```php
public $currency = 'ARS'; // Pesos Argentinos
```

### URLs de Retorno
```php
public $backUrls = [
    'success' => 'mercadopago/success',
    'failure' => 'mercadopago/failure',
    'pending' => 'mercadopago/pending'
];
```

### Expiración de Preferencias
```php
public $expirationHours = 1; // 1 hora
```

### Cuotas
```php
public $installments = [
    'enabled' => true,
    'max' => 12
];
```

## Pruebas

### Tarjetas de Prueba

Para probar el sistema, usa estas tarjetas de prueba de MercadoPago:

#### Tarjetas Aprobadas
- **Visa**: 4509 9535 6623 3704
- **Mastercard**: 5031 4332 1540 6351
- **American Express**: 3711 8030 3257 522

#### Tarjetas Rechazadas
- **Visa**: 4000 0000 0000 0002
- **Mastercard**: 5031 1111 1111 6351

### Datos de Prueba
- **CVV**: Cualquier número de 3 dígitos
- **Fecha de Vencimiento**: Cualquier fecha futura
- **Nombre**: Cualquier nombre

## Logs y Debugging

Los logs se guardan en:
- **Errores**: `writable/logs/log-YYYY-MM-DD.php`
- **Información**: Busca mensajes con "MercadoPago" en los logs

### Ejemplo de Log
```
[2024-01-01 10:00:00] INFO - Webhook MercadoPago: Pago 123456789 actualizado a estado approved
```

## Seguridad

### Validaciones Implementadas
- Verificación de stock antes del pago
- Validación de usuario autenticado
- Verificación de datos del carrito
- Transacciones de base de datos para consistencia

### Recomendaciones
- Usa HTTPS en producción
- Configura correctamente el webhook
- Monitorea los logs regularmente
- Valida las notificaciones del webhook

## Troubleshooting

### Error: "Access Token inválido"
- Verifica que las credenciales estén correctas
- Asegúrate de usar credenciales de prueba para desarrollo

### Error: "Webhook no recibido"
- Verifica que la URL del webhook sea accesible
- Confirma que el webhook esté configurado en MercadoPago

### Error: "Preferencia no creada"
- Verifica la conexión a internet
- Revisa los logs para más detalles
- Confirma que los datos del carrito sean válidos

## Soporte

Para obtener ayuda:
1. Revisa los logs del sistema
2. Consulta la documentación de MercadoPago
3. Verifica la configuración del webhook
4. Contacta al equipo de desarrollo

## Changelog

### v1.0.0 (2024-01-01)
- Implementación inicial de MercadoPago Checkout Pro
- Integración con el sistema de carrito existente
- Webhook para notificaciones automáticas
- Páginas de retorno (éxito, fallo, pendiente)
- Historial de pagos
- Configuración flexible 