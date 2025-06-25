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

}