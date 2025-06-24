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


// ==================== RUTAS DEL REGISTRO DE USUARIOS ====================
$routes->get('registro', 'LoginController::registro');
$routes->post('registro', 'UsuarioController::Create');

//==================== RUTAS DEL LOGIN ====================
$routes->get('/login', 'LoginController');
$routes->post('/login', 'LoginController::auth');
$routes->get('/logout', 'LoginController::logout');

// ==================== RUTAS DEL PANEL DE USUARIO ====================
$routes->get('/panel', 'PanelController::index', ['filter' => 'auth']);
$routes->get('/panel/mis-facturas', 'FacturaController::facturasUsuario', ['filter' => 'auth']);
$routes->get('/panel/factura/(:num)', 'FacturaController::detalleFacturaUsuario/$1', ['filter' => 'auth']);




// ==================== RUTAS DE PRODUCTOS ====================
$routes->get('categoria/(:segment)', 'ProductosController::porCategoria/$1');
$routes->get('producto/(:num)', 'ProductosController::detalle/$1');
$routes->get('productos/buscar', 'ProductosController::buscar');
$routes->post('productos/buscar', 'ProductosController::buscar');
$routes->get('buscar', 'ProductosController::buscar');


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
$routes->post('/checkout/confirm', 'CheckoutController::confirm', ['filter' => 'auth']);
$routes->get('/checkout/summary', 'CheckoutController::getSummary', ['filter' => 'auth']);
$routes->get('/checkout/history', 'CheckoutController::getInvoiceHistory', ['filter' => 'auth']);
$routes->get('/checkout/invoice/(:num)', 'CheckoutController::getInvoiceDetails/$1', ['filter' => 'auth']);

// ==================== RUTAS DE MERCADOPAGO ====================
$routes->get('/mercadopago/create', 'MercadoPagoController::createPreference', ['filter' => 'auth']);
$routes->post('/mercadopago/webhook', 'MercadoPagoController::webhook');
$routes->get('/mercadopago/success', 'MercadoPagoController::success', ['filter' => 'auth']);
$routes->get('/mercadopago/failure', 'MercadoPagoController::failure', ['filter' => 'auth']);
$routes->get('/mercadopago/pending', 'MercadoPagoController::pending', ['filter' => 'auth']);
$routes->get('/mercadopago/history', 'MercadoPagoController::getPaymentHistory', ['filter' => 'auth']);


// ==================== RUTAS DE ACTUALIZACIÓN DATOS PERSONALES ====================
$routes->get('actualizar', 'UsuarioController::Read', ['filter' => 'auth']);
$routes->post('actualizar', 'UsuarioController::Update', ['filter' => 'auth']);

// ==================== RUTAS DEL PANEL DE ADMINISTRACIÓN ====================
// Dashboard principal
$routes->get('admin', 'AdminController::index', ['filter' => 'authadmin']);


// Gestión de Usuarios
$routes->get('admin/usuarios', 'UsuarioController::adminIndex', ['filter' => 'authadmin']);
$routes->get('admin/usuarios/crear', 'UsuarioController::adminCreate', ['filter' => 'authadmin']);
$routes->post('admin/usuarios/crear', 'UsuarioController::adminCreate', ['filter' => 'authadmin']);
$routes->get('admin/usuarios/editar/(:num)', 'UsuarioController::adminEdit/$1', ['filter' => 'authadmin']);
$routes->post('admin/usuarios/editar/(:num)', 'UsuarioController::adminEdit/$1', ['filter' => 'authadmin']);
$routes->get('admin/usuarios/eliminar/(:num)', 'UsuarioController::adminDelete/$1', ['filter' => 'authadmin']);

// Control de Inventario
$routes->get('admin/inventario', 'AdminController::inventario', ['filter' => 'authadmin']);
$routes->get('admin/inventario/crear', 'AdminController::crearProducto', ['filter' => 'authadmin']);
$routes->post('admin/inventario/crear', 'AdminController::crearProducto', ['filter' => 'authadmin']);
$routes->get('admin/inventario/editar/(:num)', 'AdminController::editarProducto/$1', ['filter' => 'authadmin']);
$routes->post('admin/inventario/editar/(:num)', 'AdminController::editarProducto/$1', ['filter' => 'authadmin']);
$routes->get('admin/inventario/eliminar/(:num)', 'AdminController::eliminarProducto/$1', ['filter' => 'authadmin']);

// Reportes y Estadísticas
// $routes->get('admin/reportes', 'AdminController::reportes', ['filter' => 'authadmin']);

// ===================== RUTAS DE CONTACTO (ADMIN) ====================
$routes->get('/contacto/mis-contactos', 'ContactoController::misContactos', ['filter' => 'auth']);
$routes->get('/contacto/detalle/(:num)', 'ContactoController::detalle/$1', ['filter' => 'auth']);
$routes->get('/contacto/admin', 'ContactoController::admin', ['filter' => 'authadmin']);
$routes->post('/contacto/responder/(:num)', 'ContactoController::responder/$1', ['filter' => 'authadmin']);
$routes->get('/contacto/marcar-leido/(:num)', 'ContactoController::marcarLeido/$1', ['filter' => 'authadmin']);


// ==================== RUTAS DE CONTACTO (USUARIO) ====================
$routes->get('/contacto', 'ContactoController::index');
$routes->post('/contacto/enviar', 'ContactoController::enviar');

// ==================== RUTAS DE UBICACIONES (API GEOREF)====================
$routes->get('/ubicacion/provincias', 'UbicacionController::provincias');
$routes->get('/ubicacion/localidades/(:any)', 'UbicacionController::localidades/$1');

// ==================== RUTAS DE VENTAS ====================
$routes->get('/admin/ventas', 'FacturaController::ventas', ['filter' => 'authadmin']);
$routes->get('/admin/venta/(:num)', 'FacturaController::detalleVenta/$1', ['filter' => 'authadmin']);
// ==================== RUTAS 404 ====================
$routes->set404Override(function () {
    return view('templates/main_layout', [
        'title' => 'Página no encontrada',
        'content' => view('errors/cli/error_404')
    ]);
});


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
