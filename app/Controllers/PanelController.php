<?php
namespace App\Controllers;


class PanelController extends BaseController
{
    private $facturaModel;
    private $detallesFacturaModel;
    private $usuarioModel;
    private $pagoModel;
    private $session;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        // $this->facturaModel = new FacturaModel();
        // $this->detallesFacturaModel = new DetallesFacturaModel();
        // $this->usuarioModel = new UsuarioModel();
        // $this->pagoModel = new PagoModel();
        $this->session = session();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('logueado')) {
            return redirect()->to('/login');
        }
        $nombre = $session->get('nombre');
        $perfil = $session->get('id_rol');

        return view('templates/main_layout', [
            'title' => 'Panel de Usuario',
            'content' => view('back/usuario/perfil', [
                'nombre' => $nombre,
                'perfil' => $perfil
            ])
        ]);
    }

    /**
     * Muestra las facturas del usuario
     */
    // public function misFacturas()
    // {
    //     $usuarioId = $this->session->get('usuario_id');

    //     if (!$usuarioId) {
    //         return redirect()->to('/login');
    //     }

    //     // Obtener facturas del usuario con información de usuario
    //     $facturas = $this->facturaModel->getFacturasByUsuario($usuarioId);

    //     return view('templates/main_layout', [
    //         'title' => 'Mis Facturas',
    //         'content' => view('back/usuario/mis_facturas', [
    //             'facturas' => $facturas
    //         ])
    //     ]);
    // }

    /**
     * Muestra los detalles de una factura específica del usuario
     */
    // public function detalleFactura($facturaId)
    // {
    //     $usuarioId = $this->session->get('usuario_id');

    //     if (!$usuarioId) {
    //         return redirect()->to('/login');
    //     }

    //     // Verificar que la factura pertenece al usuario
    //     $factura = $this->facturaModel->getFacturaByIdAndUsuario($facturaId, $usuarioId);

    //     if (!$factura) {
    //         return redirect()->to('/panel/mis-facturas')->with('error', 'Factura no encontrada');
    //     }

    //     // Obtener detalles de la factura con información de productos
    //     $detalles = $this->detallesFacturaModel->getDetallesByFacturaId($facturaId);

    //     // Obtener información del usuario
    //     $usuario = $this->usuarioModel->getUserWithAllData($usuarioId);

    //     // Obtener información del pago de MercadoPago de forma más segura
    //     $pago = null;
    //     try {
    //         $db = \Config\Database::connect();
    //         // Buscar pagos aprobados que correspondan a esta factura
    //         $pagos = $db->table('pagos')
    //             ->where('status', 'approved')
    //             ->get()
    //             ->getResultArray();

    //         foreach ($pagos as $pagoItem) {
    //             $detail = json_decode($pagoItem['detail'], true);
    //             if (isset($detail['external_reference']) && $detail['external_reference'] == $facturaId) {
    //                 $pago = array_merge($pagoItem, $detail);
    //                 break;
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         // Si hay error, simplemente no mostrar información de pago
    //         log_message('error', 'Error obteniendo información de pago: ' . $e->getMessage());
    //         $pago = null;
    //     }

    //     return view('templates/main_layout', [
    //         'title' => 'Detalle de Factura #' . $facturaId,
    //         'content' => view('back/usuario/detalle_factura', [
    //             'factura' => $factura,
    //             'detalles' => $detalles,
    //             'usuario' => $usuario,
    //             'pago' => $pago
    //         ])
    //     ]);
    // }

    /**
     * Muestra todas las ventas para el administrador


     * Muestra el historial de pagos del usuario
     */
    // public function historialPagos()
    // {
    //     $usuarioId = $this->session->get('usuario_id');

    //     if (!$usuarioId) {
    //         return redirect()->to('/login');
    //     }

    //     $processedPayments = [];

    //     try {
    //         $db = \Config\Database::connect();
    //         // Obtener pagos del usuario de forma más simple

    //         // Primero verificar si la tabla pagos existe
    //         $tableExists = $db->tableExists('pagos');
    //         if (!$tableExists) {
    //             log_message('warning', 'Tabla pagos no existe');
    //             return view('templates/main_layout', [
    //                 'title' => 'Historial de Pagos',
    //                 'content' => view('back/usuario/historial_pagos', [
    //                     'payments' => $processedPayments
    //                 ])
    //             ]);
    //         }

    //         // Obtener todos los pagos primero
    //         $payments = $db->table('pagos')
    //             ->orderBy('created_at', 'DESC')
    //             ->get()
    //             ->getResultArray();

    //         // Obtener las facturas del usuario
    //         $facturas = $db->table('facturas')
    //             ->where('id_usuario', $usuarioId)
    //             ->where('activo', 1)
    //             ->get()
    //             ->getResultArray();

    //         $facturaIds = array_column($facturas, 'id_factura');
    //         $facturasMap = array_column($facturas, null, 'id_factura');

    //         // Procesar los pagos y filtrar solo los del usuario
    //         foreach ($payments as $payment) {
    //             $detail = json_decode($payment['detail'], true);
    //             $externalReference = $detail['external_reference'] ?? null;

    //             // Solo incluir pagos que correspondan a facturas del usuario
    //             if ($externalReference && in_array($externalReference, $facturaIds)) {
    //                 $factura = $facturasMap[$externalReference] ?? null;

    //                 $processedPayments[] = [
    //                     'id' => $payment['id'],
    //                     'payment_id' => $payment['payment_id'],
    //                     'status' => $payment['status'],
    //                     'created_at' => $payment['created_at'],
    //                     'factura_id' => $externalReference,
    //                     'importe_total' => $detail['transaction_amount'] ?? $factura['importe_total'] ?? 0,
    //                     'payment_method_id' => $detail['payment_method_id'] ?? null,
    //                     'payment_type_id' => $detail['payment_type_id'] ?? null,
    //                     'installments' => $detail['installments'] ?? null,
    //                     'fecha_factura' => $factura['fecha_factura'] ?? null,
    //                     'detail' => $detail
    //                 ];
    //             }
    //         }

    //     } catch (\Exception $e) {
    //         log_message('error', 'Error obteniendo historial de pagos: ' . $e->getMessage());
    //         // Si hay error, mostrar lista vacía pero no fallar
    //     }

    //     return view('templates/main_layout', [
    //         'title' => 'Historial de Pagos',
    //         'content' => view('back/usuario/historial_pagos', [
    //             'payments' => $processedPayments
    //         ])
    //     ]);
    // }
}