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


    public function Read()
    {
        $session = session();
        if (!$session->get('logueado')) {
            return redirect()->to('/login');
        }
        $usuarioModel = new UsuarioModel();
        $personaModel = new PersonaModel();
        $domicilioModel = new DomicilioModel();
        $usuario = $usuarioModel->find($session->get('usuario_id'));
        $persona = $personaModel->find($usuario['id_persona']);
        $domicilio = $domicilioModel->find($persona['id_domicilio']);
        return view('templates/main_layout', [
            'title' => 'Actualizar mis datos',
            'content' => view('back/usuario/actualizarDatos', [
                'dni' => $persona['dni'] ?? '',
                'nombre' => $persona['nombre'] ?? '',
                'apellido' => $persona['apellido'] ?? '',
                'email' => $usuario['email'] ?? '',
                'telefono' => $persona['telefono'] ?? '',
                'calle' => $domicilio['calle'] ?? '',
                'numero' => $domicilio['numero'] ?? '',
                'codigo_postal' => $domicilio['codigo_postal'] ?? '',
                'localidad' => $domicilio['localidad'] ?? '',
                'provincia' => $domicilio['provincia'] ?? '',
                'pais' => $domicilio['pais'] ?? ''
            ])
        ]);
    }
    public function Create()
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

        //
        $input = $this->request->getPost();

        // 1. Insertar domicilio
        $idDomicilio = $domicilioModel->insert([
            'calle' => $input['calle'],
            'numero' => $input['numero'],
            'codigo_postal' => $input['codigo_postal'],
            'localidad' => $input['localidad'],
            'provincia' => $input['provincia'],
            'pais' => $input['pais'],
            'activo' => true
        ]);

        // 2. Insertar persona con referencia al domicilio
        $idPersona = $personaModel->insert([
            'dni' => $input['dni'],
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'id_domicilio' => $idDomicilio,
            'telefono' => $input['telefono'],
        ]);

        // 3. Insertar usuario con referencia a la persona
        $usuarioModel->insert([
            'id_persona' => $idPersona,
            'id_rol' => 2, // Por ejemplo: 2 = cliente (podés cambiar esto)
            'email' => $input['email'],
            'password_hash' => password_hash($input['password'], PASSWORD_DEFAULT),
            'activo' => true
        ]);

        session()->setFlashdata('success', 'Usuario registrado con éxito.');
        return redirect()->to('/registro');
    }
    public function Update()
    {
        $session = session();
        if (!$session->get('logueado')) {
            return redirect()->to('/login');
        }
        $usuarioModel = new UsuarioModel();
        $personaModel = new PersonaModel();
        $domicilioModel = new DomicilioModel();
        $usuario = $usuarioModel->find($session->get('usuario_id'));
        $persona = $personaModel->find($usuario['id_persona']);
        $domicilio = $domicilioModel->find($persona['id_domicilio']);
        $input = $this->request->getPost();
        // Validación simple
        if (empty($input['nombre']) || empty($input['apellido']) || empty($input['email']) || empty($input['calle']) || empty($input['numero']) || empty($input['codigo_postal']) || empty($input['localidad']) || empty($input['provincia']) || empty($input['pais'])) {
            return redirect()->to('/actualizar')->with('msg', 'Todos los campos obligatorios deben estar completos.');
        }
        // Actualizar domicilio
        $domicilioModel->update($domicilio['id_domicilio'], [
            'calle' => $input['calle'],
            'numero' => $input['numero'],
            'codigo_postal' => $input['codigo_postal'],
            'localidad' => $input['localidad'],
            'provincia' => $input['provincia'],
            'pais' => $input['pais']
        ]);
        // Actualizar persona
        $personaModel->update($persona['id_persona'], [
            'dni' => $input['dni'],
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'telefono' => $input['telefono']
        ]);
        // Actualizar usuario (email)
        $usuarioModel->update($usuario['id_usuario'], [
            'email' => $input['email']
        ]);
        // Actualizar sesión
        $session->set('nombre', $input['nombre']);
        $session->set('apellido', $input['apellido']);
        return redirect()->to('/actualizar')->with('msg', 'Datos personales actualizados correctamente.');
    }

    // ==================== MÉTODOS PARA PANEL DE ADMINISTRACIÓN ====================

    /**
     * Lista todos los usuarios para el panel de administración
     */
    public function adminIndex()
    {
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->getAllUsersWithPersonas();

        return view('templates/main_layout', [
            'title' => 'Gestión de Usuarios',
            'content' => view('back/admin/usuarios/index', [
                'usuarios' => $usuarios
            ])
        ]);
    }

    /**
     * Muestra formulario para crear usuario desde el panel de administración
     */
    public function adminCreate()
    {
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nombre' => 'required|min_length[3]',
                'apellido' => 'required|min_length[3]',
                'email' => 'required|valid_email|is_unique[usuarios.email]',
                'password' => 'required|min_length[6]',
                'id_rol' => 'required|in_list[1,2]'
            ];

            if ($this->validate($rules)) {
                $domicilioModel = new DomicilioModel();
                $personaModel = new PersonaModel();
                $usuarioModel = new UsuarioModel();

                // 1. Insertar domicilio por defecto
                $idDomicilio = $domicilioModel->insert([
                    'calle' => 'Por definir',
                    'numero' => '0',
                    'codigo_postal' => '0000',
                    'localidad' => 'Por definir',
                    'provincia' => 'Por definir',
                    'pais' => 'Por definir',
                    'activo' => true
                ]);

                // 2. Insertar persona
                $idPersona = $personaModel->insert([
                    'dni' => $this->request->getPost('dni'),
                    'nombre' => $this->request->getPost('nombre'),
                    'apellido' => $this->request->getPost('apellido'),
                    'id_domicilio' => $idDomicilio,
                    'telefono' => $this->request->getPost('telefono', FILTER_SANITIZE_STRING)
                ]);

                // 3. Insertar usuario
                $usuarioModel->insert([
                    'id_persona' => $idPersona,
                    'id_rol' => $this->request->getPost('id_rol'),
                    'email' => $this->request->getPost('email'),
                    'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'activo' => 1
                ]);

                $session->setFlashdata('msg', 'Usuario creado exitosamente');
                return redirect()->to('/admin/usuarios');
            } else {
                $session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
            }
        }

        return view('templates/main_layout', [
            'title' => 'Crear Usuario',
            'content' => view('back/admin/usuarios/crear', [
                'validation' => \Config\Services::validation()
            ])
        ]);
    }

    /**
     * Muestra formulario para editar usuario desde el panel de administración
     */
    public function adminEdit($id = null)
    {
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();
        $personaModel = new PersonaModel();

        $usuario = $usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to('/admin/usuarios');
        }

        $persona = $personaModel->find($usuario['id_persona']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nombre' => 'required|min_length[3]',
                'apellido' => 'required|min_length[3]',
                'email' => 'required|valid_email',
                'id_rol' => 'required|in_list[1,2]',
                'activo' => 'required|in_list[0,1]'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'id_rol' => $this->request->getPost('id_rol'),
                    'activo' => $this->request->getPost('activo')
                ];

                // Solo actualizar password si se proporciona uno nuevo
                if ($this->request->getPost('password')) {
                    $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }

                // Actualizar usuario
                $usuarioModel->update($id, $data);

                // Actualizar persona
                $personaModel->update($usuario['id_persona'], [
                    'nombre' => $this->request->getPost('nombre'),
                    'apellido' => $this->request->getPost('apellido')
                ]);

                $session->setFlashdata('msg', 'Usuario actualizado exitosamente');
                return redirect()->to('/admin/usuarios');
            } else {
                $session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
            }
        }

        return view('templates/main_layout', [
            'title' => 'Editar Usuario',
            'content' => view('back/admin/usuarios/editar', [
                'usuario' => array_merge($usuario, $persona),
                'validation' => \Config\Services::validation()
            ])
        ]);
    }

    /**
     * Elimina un usuario desde el panel de administración
     */
    public function adminDelete($id = null)
    {
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();

        if ($usuarioModel->delete($id)) {
            $session->setFlashdata('msg', 'Usuario eliminado exitosamente');
        } else {
            $session->setFlashdata('error', 'Error al eliminar el usuario');
        }

        return redirect()->to('/admin/usuarios');
    }
}
