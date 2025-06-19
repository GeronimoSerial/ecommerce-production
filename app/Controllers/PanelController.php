<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class PanelController extends BaseController
{
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

}