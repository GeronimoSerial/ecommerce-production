<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends Controller {
    public function __construct() {
        helper(['form', 'url']);
    }

    public function create() {
        return view('templates/main_layout', [
            'title' => 'Registro',
            'content' => view('back/usuario/registro')
        ]); 
    }

    public function formValidation() {
        $input = $this->validate([
            'nombre' => 'required|min_length[3]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'usuario' => 'required|min_length[3]',
            'email' => 'required|min_length[3]|max_length[100]|valid_email',
            'pass' => 'required|min_length[3]|max_length[10]'
        ]);
    
        $formModel = new UsuarioModel();
        $email = $this->request->getVar('email');
        
        // Verificar si el email ya está en uso
        if ($formModel->where('email', $email)->first()) {
            session()->setFlashdata('fail', 'El email ya está en uso.');
            return redirect()->to('registro')->withInput();
        }

        if (!$input) {
            return view('back/usuario/registro', [
                'title' => 'Registro',
                'validation' => $this->validator
            ]); 
        }

        $formModel->save([
            'nombre' => $this->request->getVar('nombre'),
            'apellido' => $this->request->getVar('apellido'),
            'usuario' => $this->request->getVar('usuario'),
            'email' => $this->request->getVar('email'),
            'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
        ]);

        // flashData funciona solo en redirigir la funcion en el controlador en la vista de carga.
        session()->setFlashdata('success', 'Usuario registrado con exito');
        return redirect()->to('registro');
    }
}