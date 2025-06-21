<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('/comercializacion', 'ComercializacionController::index');
$routes->get('/terminos', 'TerminosController::index');
$routes->get('/nosotros', 'NosotrosController::index');
$routes->get('/contacto', 'ContactoController::index');
$routes->post('/contacto/enviar', 'ContactoController::enviar');

// Rutas del registro de usuarios
$routes->get('registro', 'LoginController::registro');       // Muestra el formulario
$routes->post('registro', 'UsuarioController::Create'); // Procesa el formulario

// Rutas del Login
$routes->get('/login', 'LoginController');
$routes->post('/login', 'LoginController::auth');
$routes->get('/panel', 'PanelController::index');
$routes->get('/panel/mis-facturas', 'PanelController::misFacturas');
$routes->get('/panel/factura/(:num)', 'PanelController::detalleFactura/$1');
$routes->get('/panel/ventas', 'PanelController::ventas');
$routes->get('/panel/venta/(:num)', 'PanelController::detalleVenta/$1');

$routes->get('/logout', 'LoginController::logout');

$routes->get('/recuperar', function () {
    return view('templates/main_layout', [
        'title' => 'Recuperar contraseña',
        'content' => '<div class="container py-5"><h2>Página de recuperación de contraseña (en construcción)</h2></div>'
    ]);
});

// Rutas de productos unificadas
$routes->get('categoria/(:segment)', 'ProductosController::porCategoria/$1');
$routes->get('producto/(:num)', 'ProductosController::detalle/$1');
$routes->get('productos/buscar', 'ProductosController::buscar');
$routes->post('productos/buscar', 'ProductosController::buscar');
$routes->get('buscar', 'ProductosController::buscar'); // Si también necesitas esta ruta
// Ruta legacy para compatibilidad (redirige a la nueva estructura)
$routes->get('productos/(:segment)', 'ProductosController::porCategoria/$1');

// ==================== RUTAS DEL CARRITO DE COMPRAS ====================
$routes->get('/cart', 'CartController::index');
$routes->post('/cart/add', 'CartController::add');
$routes->post('/cart/actualizar_cantidad', 'CartController::updateQuantity');
$routes->post('/cart/eliminar', 'CartController::remove');
$routes->post('/cart/vaciar', 'CartController::clear');
$routes->get('/cart/checkout', 'CartController::checkout');
$routes->get('/cart/count', 'CartController::getCartCount');

// ==================== RUTAS DEL CHECKOUT ====================
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/confirm', 'CheckoutController::confirm');
$routes->get('/checkout/summary', 'CheckoutController::getSummary');
$routes->get('/checkout/history', 'CheckoutController::getInvoiceHistory');
$routes->get('/checkout/invoice/(:num)', 'CheckoutController::getInvoiceDetails/$1');

$routes->set404Override(function () {
    return view('templates/main_layout', [
        'title' => 'Página no encontrada',
        'content' => view('errors/cli/error_404')
    ]);
});

$routes->get('actualizar', 'UsuarioController::Read');
$routes->post('actualizar', 'UsuarioController::Update');

// ==================== RUTAS DEL PANEL DE ADMINISTRACIÓN ====================
// Dashboard principal
$routes->get('admin', 'AdminController::index');


// Gestión de Usuarios
$routes->get('admin/usuarios', 'UsuarioController::adminIndex');
$routes->get('admin/usuarios/crear', 'UsuarioController::adminCreate');
$routes->post('admin/usuarios/crear', 'UsuarioController::adminCreate');
$routes->get('admin/usuarios/editar/(:num)', 'UsuarioController::adminEdit/$1');
$routes->post('admin/usuarios/editar/(:num)', 'UsuarioController::adminEdit/$1');
$routes->get('admin/usuarios/eliminar/(:num)', 'UsuarioController::adminDelete/$1');

// Control de Inventario
$routes->get('admin/inventario', 'AdminController::inventario');
$routes->get('admin/inventario/crear', 'AdminController::crearProducto');
$routes->post('admin/inventario/crear', 'AdminController::crearProducto');
$routes->get('admin/inventario/editar/(:num)', 'AdminController::editarProducto/$1');
$routes->post('admin/inventario/editar/(:num)', 'AdminController::editarProducto/$1');
$routes->get('admin/inventario/eliminar/(:num)', 'AdminController::eliminarProducto/$1');

// Reportes y Estadísticas
$routes->get('admin/reportes', 'AdminController::reportes');

// Rutas del sistema de contacto
$routes->get('/contacto/mis-contactos', 'ContactoController::misContactos');
$routes->get('/contacto/detalle/(:num)', 'ContactoController::detalle/$1');
$routes->get('/contacto/admin', 'ContactoController::admin');
$routes->post('/contacto/responder/(:num)', 'ContactoController::responder/$1');
$routes->get('/contacto/marcar-leido/(:num)', 'ContactoController::marcarLeido/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
