<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    public function __construct()
    {
        helper(['form', 'url']);

    }

    public function create()
    {
        // Cargar la página de inicio
        return view('templates/main_layout', [
            'title' => 'Registro',
            'content' => view('back/usuario/registro')
        ]);
    }


}