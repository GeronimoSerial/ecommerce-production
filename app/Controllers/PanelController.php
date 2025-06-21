<?php
namespace App\Controllers;

use App\Models\FacturaModel;
use App\Models\DetallesFacturaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class PanelController extends BaseController
{
    private $facturaModel;
    private $detallesFacturaModel;
    private $usuarioModel;
    private $session;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->facturaModel = new FacturaModel();
        $this->detallesFacturaModel = new DetallesFacturaModel();
        $this->usuarioModel = new UsuarioModel();
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
            'content' => view('back/usuario/usuarioLogueado', [
                'nombre' => $nombre,
                'perfil' => $perfil
            ])
        ]);
    }

    /**
     * Muestra las facturas del usuario
     */
    public function misFacturas()
    {
        $usuarioId = $this->session->get('usuario_id');
        
        if (!$usuarioId) {
            return redirect()->to('/login');
        }

        // Obtener facturas del usuario con información de usuario
        $db = \Config\Database::connect();
        $facturas = $db->table('facturas f')
                      ->select('f.*, p.nombre, p.apellido')
                      ->join('usuarios u', 'u.id_usuario = f.id_usuario')
                      ->join('personas p', 'p.id_persona = u.id_persona')
                      ->where('f.id_usuario', $usuarioId)
                      ->where('f.activo', 1)
                      ->orderBy('f.fecha_factura', 'DESC')
                      ->get()
                      ->getResultArray();

        return view('templates/main_layout', [
            'title' => 'Mis Facturas',
            'content' => view('back/usuario/mis_facturas', [
                'facturas' => $facturas
            ])
        ]);
    }

    /**
     * Muestra los detalles de una factura específica del usuario
     */
    public function detalleFactura($facturaId)
    {
        $usuarioId = $this->session->get('usuario_id');
        
        if (!$usuarioId) {
            return redirect()->to('/login');
        }

        // Verificar que la factura pertenece al usuario
        $factura = $this->facturaModel->where('id_factura', $facturaId)
                                    ->where('id_usuario', $usuarioId)
                                    ->where('activo', 1)
                                    ->first();

        if (!$factura) {
            return redirect()->to('/panel/mis-facturas')->with('error', 'Factura no encontrada');
        }

        // Obtener detalles de la factura con información de productos
        $db = \Config\Database::connect();
        $detalles = $db->table('detalles_factura df')
                      ->select('df.*, p.nombre, p.descripcion, p.url_imagen')
                      ->join('productos p', 'p.id_producto = df.id_producto')
                      ->where('df.id_factura', $facturaId)
                      ->get()
                      ->getResultArray();

        // Obtener información del usuario
        $usuario = $this->usuarioModel->getUserWithAllData($usuarioId);

        return view('templates/main_layout', [
            'title' => 'Detalle de Factura #' . $facturaId,
            'content' => view('back/usuario/detalle_factura', [
                'factura' => $factura,
                'detalles' => $detalles,
                'usuario' => $usuario
            ])
        ]);
    }

    /**
     * Muestra todas las ventas para el administrador
     */
    public function ventas()
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        // Obtener todas las facturas con información de usuarios
        $db = \Config\Database::connect();
        $ventas = $db->table('facturas f')
                    ->select('f.*, p.nombre, p.apellido, u.email')
                    ->join('usuarios u', 'u.id_usuario = f.id_usuario')
                    ->join('personas p', 'p.id_persona = u.id_persona')
                    ->where('f.activo', 1)
                    ->orderBy('f.fecha_factura', 'DESC')
                    ->get()
                    ->getResultArray();

        return view('templates/main_layout', [
            'title' => 'Gestión de Ventas',
            'content' => view('back/admin/ventas/index', [
                'ventas' => $ventas
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
        $factura = $this->facturaModel->where('id_factura', $facturaId)
                                    ->where('activo', 1)
                                    ->first();

        if (!$factura) {
            return redirect()->to('/panel/ventas')->with('error', 'Venta no encontrada');
        }

        // Obtener detalles de la factura con información de productos
        $db = \Config\Database::connect();
        $detalles = $db->table('detalles_factura df')
                      ->select('df.*, p.nombre, p.descripcion, p.url_imagen')
                      ->join('productos p', 'p.id_producto = df.id_producto')
                      ->where('df.id_factura', $facturaId)
                      ->get()
                      ->getResultArray();

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