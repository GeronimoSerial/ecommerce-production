<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductoModel;
use App\Models\FacturaModel;
use App\Models\DetallesFacturaModel;
use App\Models\PagoModel;
use CodeIgniter\Controller;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use Config\MercadoPago as MercadoPagoSettings;

class MercadoPagoController extends BaseController
{
    private $cartModel;
    private $productoModel;
    private $facturaModel;
    private $detallesFacturaModel;
    private $pagoModel;
    private $session;
    private $preferenceClient;
    private $paymentClient;
    private $mpConfig;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->cartModel = new CartModel();
        $this->productoModel = new ProductoModel();
        $this->facturaModel = new FacturaModel();
        $this->detallesFacturaModel = new DetallesFacturaModel();
        $this->pagoModel = new PagoModel();
        $this->session = session();
        $this->mpConfig = new MercadoPagoSettings();

        // Configurar MercadoPago
        $this->configureMercadoPago();
    }

    /**
     * Configura MercadoPago con las credenciales
     */
    private function configureMercadoPago()
    {
        MercadoPagoConfig::setAccessToken($this->mpConfig->accessToken);
        
        // Configurar el entorno de runtime (opcional, por defecto es SERVER)
        // Para pruebas locales puedes usar MercadoPagoConfig::LOCAL
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::SERVER);
        
        $this->preferenceClient = new PreferenceClient();
        $this->paymentClient = new PaymentClient();
    }

    /**
     * Crea una preferencia de pago y redirige al checkout
     */
    public function createPreference()
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

        // Verificar stock
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
        $total = $subtotal;

        // Crear la factura primero
        $facturaData = [
            'id_usuario' => $usuarioId,
            'importe_total' => $total,
            'descuento' => 0,
            'activo' => 1
        ];

        $facturaId = $this->facturaModel->insert($facturaData);

        if (!$facturaId) {
            return redirect()->to('/checkout')->with('error', 'Error al crear la factura');
        }

        try {
            // Crear items para MercadoPago
            $items = [];
            foreach ($cartItems as $item) {
                $items[] = [
                    'title' => $item['nombre'],
                    'quantity' => (int) $item['cantidad'],
                    'unit_price' => (float) $item['precio_unitario'],
                    'currency_id' => $this->mpConfig->currency
                ];
            }

            // Crear preferencia
            $preference = [
                'items' => $items,
                'external_reference' => (string) $facturaId,
                'notification_url' => $this->mpConfig->getWebhookUrl(),
                'back_urls' => $this->mpConfig->getBackUrls(),
                'auto_return' => $this->mpConfig->autoReturn,
                'expires' => $this->mpConfig->expires,
                'expiration_date_to' => $this->mpConfig->getExpirationDate()
            ];

            // Agregar configuración de cuotas si está habilitada
            if ($this->mpConfig->installments['enabled']) {
                $preference['installments'] = $this->mpConfig->installments['max'];
            }

            // Agregar métodos de pago excluidos si existen
            if (!empty($this->mpConfig->excludedPaymentMethods)) {
                $preference['payment_methods']['excluded_payment_methods'] = $this->mpConfig->excludedPaymentMethods;
            }

            // Agregar tipos de pago excluidos si existen
            if (!empty($this->mpConfig->excludedPaymentTypes)) {
                $preference['payment_methods']['excluded_payment_types'] = $this->mpConfig->excludedPaymentTypes;
            }

            // Log de los datos que se van a enviar
            log_message('info', 'MercadoPago - Datos a enviar: ' . json_encode($preference));

            $response = $this->preferenceClient->create($preference);

            if (isset($response->id)) {
                // Guardar información del pago
                $this->pagoModel->savePayment(
                    $response->id,
                    'pending',
                    [
                        'preference_id' => $response->id,
                        'external_reference' => $facturaId,
                        'total_amount' => $total,
                        'items_count' => count($cartItems),
                        'currency' => $this->mpConfig->currency
                    ]
                );

                // Redirigir al checkout de MercadoPago
                return redirect()->to($response->init_point);
            } else {
                throw new \Exception('Error al crear la preferencia de pago');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error en MercadoPago createPreference: ' . $e->getMessage());
            
            // Log más detalles del error si es una excepción de MercadoPago
            if ($e instanceof \MercadoPago\Exceptions\MPApiException) {
                log_message('error', 'MercadoPago API Error - Status: ' . $e->getApiResponse()->getStatusCode());
                log_message('error', 'MercadoPago API Error - Content: ' . json_encode($e->getApiResponse()->getContent()));
            }
            
            return redirect()->to('/checkout')->with('error', 'Error al procesar el pago. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Webhook para recibir notificaciones de MercadoPago
     */
    public function webhook()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (!$data) {
            log_message('error', 'Webhook MercadoPago: Datos inválidos');
            http_response_code(400);
            return;
        }

        try {
            // Verificar que sea una notificación de pago
            if (isset($data['type']) && $data['type'] === 'payment') {
                $paymentId = $data['data']['id'];
                
                // Verificar que el payment_id sea válido y convertirlo a entero
                if (!is_numeric($paymentId)) {
                    log_message('error', 'Webhook MercadoPago: Payment ID inválido: ' . $paymentId);
                    http_response_code(400);
                    return;
                }
                
                $paymentId = (int) $paymentId;
                
                // Obtener información del pago usando arrays (SDK v3.x)
                $payment = $this->paymentClient->get($paymentId);
                
                if ($payment) {
                    $status = $payment->status;
                    $externalReference = $payment->external_reference;
                    
                    // Actualizar el pago en la base de datos
                    $this->pagoModel->updatePaymentStatus($paymentId, $status, [
                        'payment_id' => $paymentId,
                        'external_reference' => $externalReference,
                        'status' => $status,
                        'payment_method_id' => $payment->payment_method_id ?? null,
                        'payment_type_id' => $payment->payment_type_id ?? null,
                        'transaction_amount' => $payment->transaction_amount ?? null,
                        'installments' => $payment->installments ?? null,
                        'notification_data' => $data
                    ]);

                    // Si el pago fue aprobado, procesar la factura
                    if ($status === 'approved') {
                        $this->processApprovedPayment($externalReference);
                    }

                    log_message('info', "Webhook MercadoPago: Pago {$paymentId} actualizado a estado {$status}");
                }
            }

            http_response_code(200);
            echo 'OK';

        } catch (\Exception $e) {
            log_message('error', 'Webhook MercadoPago error: ' . $e->getMessage());
            http_response_code(500);
        }
    }

    /**
     * Procesa un pago aprobado
     */
    private function processApprovedPayment($facturaId)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Obtener la factura
            $factura = $this->facturaModel->find($facturaId);
            if (!$factura) {
                throw new \Exception("Factura {$facturaId} no encontrada");
            }

            // Obtener productos del carrito
            $cartItems = $this->cartModel->getCartByUser($factura['id_usuario']);

            // Crear los detalles de la factura
            foreach ($cartItems as $item) {
                $subtotalItem = $item['cantidad'] * $item['precio_unitario'];
                
                $detalleData = [
                    'id_factura' => $facturaId,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['cantidad'],
                    'descuento' => 0,
                    'subtotal' => $subtotalItem
                ];

                $this->detallesFacturaModel->insert($detalleData);

                // Descontar stock
                $producto = $this->productoModel->find($item['id_producto']);
                $nuevoStock = $producto['cantidad'] - $item['cantidad'];
                $nuevosVendidos = $producto['cantidad_vendidos'] + $item['cantidad'];

                $this->productoModel->update($item['id_producto'], [
                    'cantidad' => $nuevoStock,
                    'cantidad_vendidos' => $nuevosVendidos
                ]);
            }

            // Vaciar el carrito
            $this->cartModel->clearCart($factura['id_usuario']);

            $db->transCommit();
            log_message('info', "Pago aprobado procesado para factura {$facturaId}");

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error procesando pago aprobado: ' . $e->getMessage());
        }
    }

    /**
     * Página de éxito
     */
    public function success()
    {
        $paymentId = $this->request->getGet('payment_id');
        $externalReference = $this->request->getGet('external_reference');

        if ($paymentId && is_numeric($paymentId)) {
            try {
                // Convertir a entero para evitar errores de tipo
                $paymentId = (int) $paymentId;
                $payment = $this->paymentClient->get($paymentId);
                $status = $payment->status;

                if ($status === 'approved') {
                    return redirect()->to('/')->with('success', '¡Pago realizado con éxito! Tu pedido ha sido procesado.');
                } else {
                    return redirect()->to('/')->with('info', 'Tu pago está siendo procesado. Te notificaremos cuando esté listo.');
                }
            } catch (\Exception $e) {
                log_message('error', 'Error obteniendo pago en success: ' . $e->getMessage());
            }
        }

        return redirect()->to('/')->with('success', '¡Gracias por tu compra!');
    }

    /**
     * Página de fallo
     */
    public function failure()
    {
        $paymentId = $this->request->getGet('payment_id');
        
        if ($paymentId && is_numeric($paymentId)) {
            try {
                // Convertir a entero para evitar errores de tipo
                $paymentId = (int) $paymentId;
                $payment = $this->paymentClient->get($paymentId);
                $status = $payment->status;
                
                $this->pagoModel->updatePaymentStatus($paymentId, $status);
            } catch (\Exception $e) {
                log_message('error', 'Error obteniendo pago en failure: ' . $e->getMessage());
            }
        }

        return redirect()->to('/checkout')->with('error', 'El pago no pudo ser procesado. Por favor, intenta nuevamente.');
    }

    /**
     * Página de pendiente
     */
    public function pending()
    {
        $paymentId = $this->request->getGet('payment_id');
        
        if ($paymentId && is_numeric($paymentId)) {
            try {
                // Convertir a entero para evitar errores de tipo
                $paymentId = (int) $paymentId;
                $payment = $this->paymentClient->get($paymentId);
                $status = $payment->status;
                
                $this->pagoModel->updatePaymentStatus($paymentId, $status);
            } catch (\Exception $e) {
                log_message('error', 'Error obteniendo pago en pending: ' . $e->getMessage());
            }
        }

        return redirect()->to('/')->with('info', 'Tu pago está pendiente de confirmación. Te notificaremos cuando esté procesado.');
    }

    /**
     * Obtiene el historial de pagos del usuario
     */
    public function getPaymentHistory()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ]);
        }

        $payments = $this->pagoModel->getPaymentsByUser($usuarioId);

        return $this->response->setJSON([
            'success' => true,
            'payments' => $payments
        ]);
    }
} 