<?php
namespace App\Controllers;
use App\Models\FacturaModel;
use App\Models\UsuarioModel;
use App\Models\DetallesFacturaModel;
class FacturaController extends BaseController
{
    private $facturaModel;
    private $usuarioModel;
    private $detallesFacturaModel;

    private $session;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->facturaModel = new FacturaModel();
        $this->usuarioModel = new UsuarioModel();
        $this->detallesFacturaModel = new DetallesFacturaModel();
        $this->session = session();
    }


    //============== Usuario ==============
    public function facturasUsuario()
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to('/login');
        }

        // Obtener facturas del usuario con información de usuario
        $facturas = $this->facturaModel->getFacturasByUsuario($usuarioId);

        return view('templates/main_layout', [
            'title' => 'Mis Facturas',
            'content' => view('back/usuario/mis_facturas', [
                'facturas' => $facturas
            ])
        ]);
    }

    public function detalleFacturaUsuario($facturaId)
    {
        $usuarioId = $this->session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to('/login');
        }

        // Verificar que la factura pertenece al usuario
        $factura = $this->facturaModel->getFacturaByIdAndUsuario($facturaId, $usuarioId);

        if (!$factura) {
            return redirect()->to('/panel/mis-facturas')->with('error', 'Factura no encontrada');
        }

        // Obtener detalles de la factura con información de productos
        $detalles = $this->detallesFacturaModel->getDetallesByFacturaId($facturaId);

        // Obtener información del usuario
        $usuario = $this->usuarioModel->getUserWithAllData($usuarioId);

        // Obtener información del pago de MercadoPago de forma más segura
        $pago = null;
        try {
            $db = \Config\Database::connect();
            // Buscar pagos aprobados que correspondan a esta factura
            $pagos = $db->table('pagos')
                ->where('status', 'approved')
                ->get()
                ->getResultArray();

            foreach ($pagos as $pagoItem) {
                $detail = json_decode($pagoItem['detail'], true);
                if (isset($detail['external_reference']) && $detail['external_reference'] == $facturaId) {
                    $pago = array_merge($pagoItem, $detail);
                    break;
                }
            }
        } catch (\Exception $e) {
            // Si hay error, simplemente no mostrar información de pago
            log_message('error', 'Error obteniendo información de pago: ' . $e->getMessage());
            $pago = null;
        }

        return view('templates/main_layout', [
            'title' => 'Detalle de Factura #' . $facturaId,
            'content' => view('back/usuario/detalle_factura', [
                'factura' => $factura,
                'detalles' => $detalles,
                'usuario' => $usuario,
                'pago' => $pago
            ])
        ]);
    }


    //============== Administrador ==============
    public function ventas()
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        // Obtener todas las facturas con información de usuarios
        $ventas = $this->facturaModel->getAllFacturasWithUserData();

        $stats = $this->getStats();
        return view('templates/main_layout', [
            'title' => 'Gestión de Ventas',
            'content' => view('back/admin/ventas/index', [
                'ventas' => $ventas,
                'stats' => $stats
            ])
        ]);
    }

    /**
     * Muestra los detalles de una venta específica para el administrador
     */
    public function detalleVenta($facturaId)
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        // Obtener la factura
        $factura = $this->facturaModel->getFacturasById($facturaId);
        //Obtener los detalles de la factura
        $detalles = $this->detallesFacturaModel->getDetallesByFacturaId($facturaId);

        if (!$factura) {
            return redirect()->to('/admin/ventas')->with('error', 'Venta no encontrada');
        }



        // Obtener información del usuario
        $usuario = $this->usuarioModel->getUserWithAllData($factura['id_usuario']);

        return view('templates/main_layout', [
            'title' => 'Detalle de Venta #' . $facturaId,
            'content' => view('back/admin/ventas/detalle', [
                'factura' => $factura,
                'detalles' => $detalles,
                'usuario' => $usuario
            ])
        ]);
    }

    private function getStats()
    {
        // Obtener estadísticas de ventas
        $stats = $this->facturaModel->getEstadisticasVentas();
        return [
            'totalVentas' => $stats['totalVentas'] ?? 0,
            'ingresosTotales' => $stats['ingresosTotales'] ?? 0,
            'ventasHoy' => $stats['ventasHoy'] ?? 0
        ];
    }
}