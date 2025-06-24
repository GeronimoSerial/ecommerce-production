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

}