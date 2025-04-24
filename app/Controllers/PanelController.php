<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class PanelController extends Controller{

    public function index(){
        $session = session();
        $nombre = $session->get('usuario');
        $perfil = $session->get('perfil_id');

        $data['perfil_id']=$perfil;
        $dato['titulo']='panel del usuario';
        
        return view('templates/main_layout', [
            'title' => 'Panel de Administración',
            'content' => view('back/admin/usuario_logueado')
        ]);
    }
}