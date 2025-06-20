<?php
namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductoModel;
use CodeIgniter\Controller;

class CheckoutController extends BaseController
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
     * Muestra la página de checkout
     */
    public function index()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder al checkout');
        }

        // Obtener productos del carrito
        $cartItems = $this->cartModel->getCartByUser($usuarioId);
        
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Tu carrito está vacío');
        }

        // Calcular totales
        $subtotal = $this->cartModel->getCartSubtotal($usuarioId);
        $tax = calculate_tax($subtotal);
        $total = calculate_total($subtotal);

        return view('templates/main_layout', [
            'title' => 'Finalizar Compra',
            'content' => view('pages/checkout', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'usuarioId' => $usuarioId
            ])
        ]);
    }

    /**
     * Procesa la confirmación de la compra
     */
    public function confirm()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para confirmar la compra');
        }

        // Obtener productos del carrito
        $cartItems = $this->cartModel->getCartByUser($usuarioId);
        
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Tu carrito está vacío');
        }

        // Verificar stock nuevamente antes de procesar
        $stockErrors = $this->cartModel->checkStockAvailability($usuarioId);
        if (!empty($stockErrors)) {
            $errorMessage = 'Algunos productos no tienen stock suficiente:';
            foreach ($stockErrors as $error) {
                $errorMessage .= "\n- {$error['producto']}: solicitado {$error['cantidad_solicitada']}, disponible {$error['stock_disponible']}";
            }
            return redirect()->to('/checkout')->with('error', $errorMessage);
        }

        // Procesar la compra
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Descontar stock de cada producto
            foreach ($cartItems as $item) {
                $producto = $this->productoModel->find($item['id_producto']);
                $nuevoStock = $producto['cantidad'] - $item['cantidad'];
                $nuevosVendidos = $producto['cantidad_vendidos'] + $item['cantidad'];

                $this->productoModel->update($item['id_producto'], [
                    'cantidad' => $nuevoStock,
                    'cantidad_vendidos' => $nuevosVendidos
                ]);
            }

            // Vaciar el carrito
            $this->cartModel->clearCart($usuarioId);

            $db->transCommit();

            // Mostrar mensaje de confirmación
            return redirect()->to('/')->with('success', '¡Compra realizada con éxito! Gracias por tu compra.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/checkout')->with('error', 'Error al procesar la compra. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Obtiene el resumen del carrito para AJAX
     */
    public function getSummary()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ]);
        }

        $cartItems = $this->cartModel->getCartByUser($usuarioId);
        $subtotal = $this->cartModel->getCartSubtotal($usuarioId);
        $tax = calculate_tax($subtotal);
        $total = calculate_total($subtotal);

        return $this->response->setJSON([
            'success' => true,
            'summary' => [
                'items' => $cartItems,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'itemCount' => count($cartItems)
            ]
        ]);
    }
} 