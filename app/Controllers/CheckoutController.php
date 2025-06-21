<?php
namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductoModel;
use App\Models\FacturaModel;
use App\Models\DetallesFacturaModel;
use CodeIgniter\Controller;

class CheckoutController extends BaseController
{
    private $cartModel;
    private $productoModel;
    private $facturaModel;
    private $detallesFacturaModel;
    private $session;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->cartModel = new CartModel();
        $this->productoModel = new ProductoModel();
        $this->facturaModel = new FacturaModel();
        $this->detallesFacturaModel = new DetallesFacturaModel();
        $this->session = session();
    }

    /**
     * Muestra la página de checkout
     */
    public function index()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to('/login')->with('info', 'Debes iniciar sesión para finalizar la compra');
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
            'content' => view('back/compras/checkout', [
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
            return redirect()->to('/login')->with('info', 'Debes iniciar sesión para confirmar la compra');
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
            return redirect()->to('/checkout')->with('info', $errorMessage);
        }

        // Calcular totales
        $subtotal = $this->cartModel->getCartSubtotal($usuarioId);
        $tax = calculate_tax($subtotal);
        $total = calculate_total($subtotal);

        // Procesar la compra
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Crear la factura
            $facturaData = [
                'id_usuario' => $usuarioId,
                'importe_total' => $total,
                'descuento' => 0, // Por defecto sin descuento
                'activo' => 1
            ];

            $facturaId = $this->facturaModel->insert($facturaData);

            if (!$facturaId) {
                throw new \Exception('Error al crear la factura');
            }

            // Crear los detalles de la factura
            foreach ($cartItems as $item) {
                $subtotalItem = $item['cantidad'] * $item['precio_unitario'];
                
                $detalleData = [
                    'id_factura' => $facturaId,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['cantidad'],
                    'descuento' => 0, // Por defecto sin descuento
                    'subtotal' => $subtotalItem
                ];

                $detalleInserted = $this->detallesFacturaModel->insert($detalleData);
                
                if (!$detalleInserted) {
                    throw new \Exception('Error al crear el detalle de factura');
                }

                // Descontar stock de cada producto
                $producto = $this->productoModel->find($item['id_producto']);
                
                // LOGS DE DEPURACIÓN
                log_message('info', "=== PROCESANDO PRODUCTO ===");
                log_message('info', "Producto ID: " . $item['id_producto']);
                log_message('info', "Nombre: " . $item['nombre']);
                log_message('info', "Cantidad en carrito: " . $item['cantidad']);
                log_message('info', "Stock actual: " . $producto['cantidad']);
                log_message('info', "Vendidos actual: " . $producto['cantidad_vendidos']);
                
                $nuevoStock = $producto['cantidad'] - $item['cantidad'];
                $nuevosVendidos = $producto['cantidad_vendidos'] + $item['cantidad'];
                
                log_message('info', "Nuevo stock calculado: " . $nuevoStock);
                log_message('info', "Nuevos vendidos calculado: " . $nuevosVendidos);

                $updateResult = $this->productoModel->update($item['id_producto'], [
                    'cantidad' => $nuevoStock,
                    'cantidad_vendidos' => $nuevosVendidos
                ]);
                
                log_message('info', "Resultado del update: " . var_export($updateResult, true));
                
                // Verificar el resultado después del update
                $productoActualizado = $this->productoModel->find($item['id_producto']);
                log_message('info', "Stock después del update: " . $productoActualizado['cantidad']);
                log_message('info', "Vendidos después del update: " . $productoActualizado['cantidad_vendidos']);
                log_message('info', "=== FIN PRODUCTO ===");
            }

            // Vaciar el carrito
            $this->cartModel->clearCart($usuarioId);

            $db->transCommit();

            // Mostrar mensaje de confirmación
            return redirect()->to('/')->with('success', '¡Compra realizada con éxito! Gracias por tu compra. Número de factura: #' . $facturaId);

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error en checkout: ' . $e->getMessage());
            return redirect()->to('/checkout')->with('info', 'Error al procesar la compra. Por favor, intenta nuevamente.');
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

    /**
     * Obtiene el historial de facturas del usuario
     */
    public function getInvoiceHistory()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ]);
        }

        $facturas = $this->facturaModel->where('id_usuario', $usuarioId)
                                     ->where('activo', 1)
                                     ->orderBy('fecha_factura', 'DESC')
                                     ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'facturas' => $facturas
        ]);
    }

    /**
     * Obtiene los detalles de una factura específica
     */
    public function getInvoiceDetails($facturaId)
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ]);
        }

        // Verificar que la factura pertenece al usuario
        $factura = $this->facturaModel->where('id_factura', $facturaId)
                                    ->where('id_usuario', $usuarioId)
                                    ->where('activo', 1)
                                    ->first();

        if (!$factura) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Factura no encontrada'
            ]);
        }

        // Obtener detalles de la factura
        $detalles = $this->detallesFacturaModel->where('id_factura', $facturaId)->findAll();

        // Obtener información de productos
        $db = \Config\Database::connect();
        $detallesConProductos = $db->table('detalles_factura df')
                                  ->select('df.*, p.nombre, p.descripcion, p.url_imagen')
                                  ->join('productos p', 'p.id_producto = df.id_producto')
                                  ->where('df.id_factura', $facturaId)
                                  ->get()
                                  ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'factura' => $factura,
            'detalles' => $detallesConProductos
        ]);
    }
}