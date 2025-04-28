<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class LoginController extends BaseController
{
    public function index()
    {
        helper(['form', 'url']);
        return view('templates/main_layout', [
            'title' => 'Login',
            'content' => view('back/usuario/login')
        ]);
    }

}
