# Ecommerce Suplementos Deportivos

Este proyecto es una plataforma de administración para un sistema de ecommerce, desarrollada en PHP. Permite gestionar productos, usuarios, pedidos y pagos, integrando funcionalidades avanzadas como pasarela de pago con MercadoPago.

## Características principales

- Gestión de productos, usuarios y pedidos
- Integración con MercadoPago para pagos online
- Panel de administración
- Arquitectura modular y escalable
- Soporte para múltiples métodos de pago

## Requisitos

- PHP >= 7.4
- Composer
- Servidor web (Apache, Nginx, etc.)
- Base de datos MySQL/MariaDB

## Instalación

1. Clona el repositorio:
   ```bash
   git clone <https://github.com/GeronimoSerial/ecommerce>
   cd admin_ecommerce
   ```
2. Instala las dependencias con Composer:
   ```bash
   composer install
   ```
3. Configura la base de datos en `app/Config/Database.php`.
4. Importa el archivo `public/tienda.sql` en tu gestor de base de datos.
5. Configura el entorno y los permisos de la carpeta `writable/`.

## Estructura del proyecto

- `app/` - Código fuente principal (controladores, modelos, vistas, configuración)
- `public/` - DocumentRoot para el servidor web
- `system/` - Núcleo del framework
- `vendor/` - Dependencias instaladas por Composer
- `tests/` - Pruebas unitarias y de integración
- `writable/` - Archivos generados y subidos

## Uso

1. Inicia el servidor web apuntando a la carpeta `public/`.
2. Accede al panel de administración desde tu navegador:
   ```
   http://localhost/
   ```
3. Configura las credenciales de MercadoPago en `app/Config/MercadoPago.php`.

## Créditos

Desarrollado por [Geronimo Serial](https://geroserial.com).
