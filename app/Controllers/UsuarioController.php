<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DomicilioModel;
use App\Models\PersonaModel;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function create()
    {
        return view('templates/main_layout', [
            'title' => 'Registro',
            'content' => view('back/usuario/registro')
        ]);
    }

    public function formValidation()
    {
        $validationRules = [
            'nombre' => 'required|min_length[3]|max_length[50]',
            'apellido' => 'required|min_length[3]|max_length[50]',
            'dni' => 'required|numeric|min_length[7]|max_length[10]',
            'telefono' => 'required|min_length[6]|max_length[20]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[8]|max_length[32]|regex_match[/(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+/]',
            'calle' => 'required|min_length[3]',
            'numero' => 'required',
            'codigo_postal' => 'required',
            'localidad' => 'required',
            'provincia' => 'required',
            'pais' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return view('templates/main_layout', [
                'title' => 'Registro',
                'content' => view('back/usuario/registro', [
                    'validation' => $this->validator
                ])
            ]);
        }

        $domicilioModel = new DomicilioModel();
        $personaModel = new PersonaModel();
        $usuarioModel = new UsuarioModel();

        // 1. Insertar domicilio
        $idDomicilio = $domicilioModel->insert([
            'calle' => $this->request->getVar('calle'),
            'numero' => $this->request->getVar('numero'),
            'codigo_postal' => $this->request->getVar('codigo_postal'),
            'localidad' => $this->request->getVar('localidad'),
            'provincia' => $this->request->getVar('provincia'),
            'pais' => $this->request->getVar('pais'),
            'activo' => true
        ]);

        // 2. Insertar persona con referencia al domicilio
        $idPersona = $personaModel->insert([
            'dni' => $this->request->getVar('dni'),
            'nombre' => $this->request->getVar('nombre'),
            'apellido' => $this->request->getVar('apellido'),
            'id_domicilio' => $idDomicilio,
            'telefono' => $this->request->getVar('telefono'),
        ]);

        // 3. Insertar usuario con referencia a la persona
        $usuarioModel->insert([
            'id_persona' => $idPersona,
            'id_rol' => 2, // Por ejemplo: 2 = cliente (podés cambiar esto)
            'email' => $this->request->getVar('email'),
            'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'activo' => true
        ]);

        session()->setFlashdata('success', 'Usuario registrado con éxito.');
        return redirect()->to('/registro');
    }
}