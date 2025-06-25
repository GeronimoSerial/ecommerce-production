<?php
namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductoModel;
use CodeIgniter\Controller;

class CartController extends BaseController
{
    private $cartModel;
    private $productoModel;
    private $session;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->cartModel = new CartModel();
        $this->productoModel = new ProductoModel();
        $this->session = session();
    }

    /**
     * Muestra la vista del carrito
     */
    public function index()
    {
        $usuarioId = $this->session->get('usuario_id');
        $cartItems = [];
        $subtotal = 0;

        if ($usuarioId) {
            // Usuario logueado - verificar si hay carrito de sesión para transferir
            $sessionCart = get_session_cart();
            if (!empty($sessionCart)) {
                // Transferir carrito de sesión a base de datos
                $this->cartModel->transferFromSession($usuarioId, $sessionCart);
                clear_session_cart();
            }

            // Obtener carrito de base de datos
            $cartItems = $this->cartModel->getCartByUser($usuarioId);
            $subtotal = $this->cartModel->getCartSubtotal($usuarioId);
        } else {
            // Usuario anónimo - obtener de sesión
            $sessionCart = get_session_cart();
            foreach ($sessionCart as $productoId => $item) {
                $producto = $this->productoModel->find($productoId);
                if ($producto && $producto['activo']) {
                    $cartItems[] = [
                        'id_carrito' => $productoId, // Usar productoId como identificador temporal
                        'id_producto' => $productoId,
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $item['precio'],
                        'nombre' => $item['nombre'],
                        'descripcion' => $producto['descripcion'],
                        'url_imagen' => $item['imagen'] ?: $producto['url_imagen'],
                        'stock_disponible' => $producto['cantidad']
                    ];
                }
            }
            $subtotal = get_session_cart_subtotal();
        }

        return view('templates/main_layout', [
            'title' => 'Carrito de Compras',
            'content' => view('back/compras/cart', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'isLoggedIn' => (bool) $usuarioId
            ])
        ]);
    }

    /**
     * Agrega un producto al carrito
     */
    public function add()
    {
        $productoId = $this->request->getPost('producto_id');
        $cantidad = (int) $this->request->getPost('cantidad') ?: 1;
        $compraDirecta = $this->request->getPost('compra_directa') === 'true';
        $usuarioId = $this->session->get('usuario_id');

        // Validar producto
        $producto = $this->productoModel->find($productoId);
        if (!$producto || !$producto['activo']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Producto no encontrado o no disponible'
            ]);
        }

        // Si es compra directa, verificar si el producto ya está en el carrito
        if ($compraDirecta) {
            if ($usuarioId) {
                $itemExistente = $this->cartModel->getCartItem($usuarioId, $productoId);
            } else {
                $sessionCart = get_session_cart();
                $itemExistente = isset($sessionCart[$productoId]) ? $sessionCart[$productoId] : null;
            }

            if ($itemExistente) {
                // El producto ya está en el carrito, redirigir directamente al checkout
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Producto ya en carrito, redirigiendo al checkout',
                    'redirect' => true
                ]);
            }
        }

        // Validar stock considerando la cantidad ya en el carrito
        $cantidadEnCarrito = 0;
        if ($usuarioId) {
            $itemExistente = $this->cartModel->getCartItem($usuarioId, $productoId);
            if ($itemExistente) {
                $cantidadEnCarrito = $itemExistente['cantidad'];
            }
        } else {
            $sessionCart = get_session_cart();
            if (isset($sessionCart[$productoId])) {
                $cantidadEnCarrito = $sessionCart[$productoId]['cantidad'];
            }
        }

        $cantidadTotal = $cantidadEnCarrito + $cantidad;
        if ($cantidadTotal > $producto['cantidad']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No hay stock suficiente'
            ]);
        }

        // Validar cantidad
        if ($cantidad <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La cantidad debe ser mayor a 0'
            ]);
        }

        if ($usuarioId) {
            // Usuario logueado - guardar en base de datos
            $success = $this->cartModel->addToCart($usuarioId, $productoId, $cantidad, $producto['precio']);
            $cartCount = $this->cartModel->getCartItemCount($usuarioId);
        } else {
            // Usuario anónimo - guardar en sesión
            $success = add_to_session_cart($productoId, $cantidad, $producto['precio'], $producto['nombre'], $producto['url_imagen']);
            $cartCount = get_session_cart_count();
        }

        if ($success) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'cartCount' => $cartCount
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al agregar el producto al carrito'
            ]);
        }
    }

    /**
     * Actualiza la cantidad de un producto en el carrito
     */
    public function updateQuantity()
    {
        $carritoId = $this->request->getPost('carrito_id');
        $cantidad = (int) $this->request->getPost('cantidad');
        $usuarioId = $this->session->get('usuario_id');

        if ($cantidad < 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La cantidad no puede ser negativa'
            ]);
        }

        if ($usuarioId) {
            // Usuario logueado - actualizar en base de datos
            $success = $this->cartModel->updateQuantity($carritoId, $cantidad);
            $subtotal = $this->cartModel->getCartSubtotal($usuarioId);
        } else {
            // Usuario anónimo - actualizar en sesión
            $success = update_session_cart_quantity($carritoId, $cantidad);
            $subtotal = get_session_cart_subtotal();
        }

        if ($success) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cantidad actualizada',
                'subtotal' => format_currency($subtotal)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al actualizar la cantidad'
            ]);
        }
    }

    /**
     * Elimina un producto del carrito
     */
    public function remove()
    {
        $carritoId = $this->request->getPost('carrito_id');
        $usuarioId = $this->session->get('usuario_id');

        if ($usuarioId) {
            // Usuario logueado - eliminar de base de datos
            $success = $this->cartModel->removeFromCart($carritoId);
            $subtotal = $this->cartModel->getCartSubtotal($usuarioId);
            $cartCount = $this->cartModel->getCartItemCount($usuarioId);
        } else {
            // Usuario anónimo - eliminar de sesión
            $success = remove_from_session_cart($carritoId);
            $subtotal = get_session_cart_subtotal();
            $cartCount = get_session_cart_count();
        }

        if ($success) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Producto eliminado del carrito',
                'subtotal' => format_currency($subtotal),
                'cartCount' => $cartCount
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al eliminar el producto'
            ]);
        }
    }

    /**
     * Vacía el carrito
     */
    public function clear()
    {
        $usuarioId = $this->session->get('usuario_id');

        if ($usuarioId) {
            // Usuario logueado - vaciar base de datos
            $success = $this->cartModel->clearCart($usuarioId);
        } else {
            // Usuario anónimo - vaciar sesión
            $success = clear_session_cart();
        }

        if ($success) {
            return redirect()->to('/cart')->with('success', 'Carrito vaciado correctamente');
        } else {
            return redirect()->to('/cart')->with('error', 'Error al vaciar el carrito');
        }
    }

    /**
     * Finaliza la compra (redirige según el estado de login)
     */
    public function checkout()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            // Usuario no logueado - redirigir a login con URL de retorno
            $this->session->set('return_url', '/checkout');
            return redirect()->to('/login')->with('info', 'Debes iniciar sesión para realizar la compra');
        }

        // Usuario logueado - transferir carrito de sesión si existe
        $sessionCart = get_session_cart();
        if (!empty($sessionCart)) {
            $this->cartModel->transferFromSession($usuarioId, $sessionCart);
            clear_session_cart();
        }

        // Verificar que el carrito no esté vacío
        $cartItems = $this->cartModel->getCartByUser($usuarioId);
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Tu carrito está vacío');
        }

        // Verificar stock
        $stockErrors = $this->cartModel->checkStockAvailability($usuarioId);
        if (!empty($stockErrors)) {
            $errorMessage = 'Algunos productos no tienen stock suficiente:';
            foreach ($stockErrors as $error) {
                $errorMessage .= "\n- {$error['producto']}: solicitado {$error['cantidad_solicitada']}, disponible {$error['stock_disponible']}";
            }
            return redirect()->to('/cart')->with('error', $errorMessage);
        }

        // Redirigir al checkout
        return redirect()->to('/checkout');
    }

    /**
     * Obtiene el conteo del carrito para el navbar
     */
    public function getCartCount()
    {
        $usuarioId = $this->session->get('usuario_id');

        if ($usuarioId) {
            $count = $this->cartModel->getCartItemCount($usuarioId);
        } else {
            $count = get_session_cart_count();
        }

        return $this->response->setJSON(['count' => $count]);
    }
}