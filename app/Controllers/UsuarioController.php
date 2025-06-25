<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    private $usuarioModel;
    private $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->usuarioModel = new UsuarioModel();
        $this->session = session();
    }


    public function Read()
    {
        if (!$this->session->get('logueado')) {
            return redirect()->to('/login');
        }
        $userData = $this->usuarioModel->getUserWithAllData($this->session->get('usuario_id'));

        if (!$userData) {
            return redirect()->to('/login');
        }

        return view('templates/main_layout', [
            'title' => 'Actualizar mis datos',
            'content' => view('back/usuario/actualizar_datos', [
                'dni' => $userData['dni'] ?? '',
                'nombre' => $userData['nombre'] ?? '',
                'apellido' => $userData['apellido'] ?? '',
                'email' => $userData['email'] ?? '',
                'telefono' => $userData['telefono'] ?? '',
                'calle' => $userData['calle'] ?? '',
                'numero' => $userData['numero'] ?? '',
                'codigo_postal' => $userData['codigo_postal'] ?? '',
                'localidad' => $userData['localidad'] ?? '',
                'provincia' => $userData['provincia'] ?? '',
                'pais' => $userData['pais'] ?? ''
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
            'email' => 'required|valid_email|is_unique[usuarios.email]|max_length[100]',
            'password' => 'required|min_length[6]|max_length[32]',
            'calle' => 'required|min_length[3]|max_length[100]',
            'numero' => 'required|numeric|min_length[1]|max_length[10]',
            'codigo_postal' => 'required|numeric|min_length[2]|max_length[10]',
            'localidad' => 'required|min_length[3]|max_length[50]',
            'provincia' => 'required|min_length[3]|max_length[50]',
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

        $input = $this->request->getPost();

        $domicilioData = [
            'calle' => $input['calle'],
            'numero' => $input['numero'],
            'codigo_postal' => $input['codigo_postal'],
            'localidad' => $input['localidad'],
            'provincia' => $input['provincia'],
            'pais' => $input['pais'],
            'activo' => true
        ];

        $personaData = [
            'dni' => $input['dni'],
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'telefono' => $input['telefono']
        ];

        $userData = [
            'id_rol' => 2, // Cliente
            'email' => $input['email'],
            'password_hash' => password_hash($input['password'], PASSWORD_DEFAULT),
            'activo' => true
        ];

        if ($this->usuarioModel->createUserWithRelations($userData, $personaData, $domicilioData)) {
            session()->setFlashdata('success', 'Usuario registrado con éxito.');
        } else {
            session()->setFlashdata('error', 'Error al registrar el usuario.');
        }

        return redirect()->to('/registro');
    }

    public function Update()
    {
        if (!$this->session->get('logueado')) {
            return redirect()->to('/login');
        }

        $input = $this->request->getPost();

        // Validación simple
        if (
            empty($input['nombre']) || empty($input['apellido']) || empty($input['email']) ||
            empty($input['calle']) || empty($input['numero']) || empty($input['codigo_postal']) ||
            empty($input['localidad']) || empty($input['provincia']) || empty($input['pais'])
        ) {
            return redirect()->to('/actualizar')->with('msg', 'Todos los campos obligatorios deben estar completos.');
        }

        $domicilioData = [
            'calle' => $input['calle'],
            'numero' => $input['numero'],
            'codigo_postal' => $input['codigo_postal'],
            'localidad' => $input['localidad'],
            'provincia' => $input['provincia'],
            'pais' => $input['pais']
        ];

        $personaData = [
            'dni' => $input['dni'],
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'telefono' => $input['telefono']
        ];

        // if ($input['password']) {
        //     $userData['password_hash'] = password_hash($input['password'], PASSWORD_DEFAULT);
        // } else {
        //     $userData['password_hash'] = $this->usuarioModel->getUserPasswordHash($this->session->get('usuario_id'));
        // }

        $userData = [
            'email' => $input['email'],
            'password_hash' => $input['password'] ? password_hash($input['password'], PASSWORD_DEFAULT) : $this->usuarioModel->getUserPasswordHash($this->session->get('usuario_id')),
        ];

        if ($this->usuarioModel->updateUserWithRelations($this->session->get('usuario_id'), $userData, $personaData, $domicilioData)) {
            // Actualizar sesión
            $this->session->set('nombre', $input['nombre']);
            $this->session->set('apellido', $input['apellido']);
            return redirect()->to('/actualizar')->with('msg', 'Datos personales actualizados correctamente.');
        } else {
            return redirect()->to('/actualizar')->with('msg', 'Error al actualizar los datos personales.');
        }
    }

    // ==================== MÉTODOS PARA PANEL DE ADMINISTRACIÓN ====================

    /**
     * Lista todos los usuarios para el panel de administración
     */
    public function adminIndex()
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $usuarios = $this->usuarioModel->getAllUsersWithPersonas();

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
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nombre' => 'required|min_length[3]|max_length[50]',
                'apellido' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email|is_unique[usuarios.email]|max_length[100]',
                'password' => 'required|min_length[6]|max_length[32]',
                'id_rol' => 'required|in_list[1,2]'
            ];

            if ($this->validate($rules)) {
                $input = $this->request->getPost();

                $personaData = [
                    'nombre' => $input['nombre'],
                    'apellido' => $input['apellido'],
                ];

                $userData = [
                    'id_rol' => $input['id_rol'],
                    'email' => $input['email'],
                    'password_hash' => password_hash($input['password'], PASSWORD_DEFAULT),
                    'activo' => 1,
                ];

                if ($this->usuarioModel->createUserWithRelations($userData, $personaData, null)) {
                    $this->session->setFlashdata('msg', 'Usuario creado exitosamente');
                    return redirect()->to('/admin/usuarios');
                } else {
                    $this->session->setFlashdata('error', 'Error al crear el usuario');
                }
            } else {
                $this->session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
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
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $userData = $this->usuarioModel->getUserWithAllData($id);
        // if (!$userData) {
        //     return redirect()->to('/admin/usuarios');
        // }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'id_rol' => 'required|in_list[1,2]',
                'activo' => 'required|in_list[0,1]'
            ];

            if ($this->validate($rules)) {
                $input = $this->request->getPost();

                $userData = [
                    'id_rol' => $input['id_rol'],
                    'activo' => $input['activo']
                ];

                // // Solo actualizar password si se proporciona uno nuevo
                // if ($input['password']) {
                //     $userData['password_hash'] = password_hash($input['password'], PASSWORD_DEFAULT);
                // // }

                // $personaData = [
                //     'nombre' => $input['nombre'],
                //     'apellido' => $input['apellido']
                // ];

                if ($this->usuarioModel->updateRolOrStatus($userData, $id)) {
                    $this->session->setFlashdata('msg', 'Usuario actualizado exitosamente');
                    return redirect()->to('/admin/usuarios');
                } else {
                    $this->session->setFlashdata('error', 'Error al actualizar el usuario');
                }
            } else {
                $this->session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
            }
        }

        return view('templates/main_layout', [
            'title' => 'Editar Usuario',
            'content' => view('back/admin/usuarios/editar', [
                'usuario' => $userData,
                'validation' => \Config\Services::validation()
            ])
        ]);
    }

    /**
     * Elimina un usuario desde el panel de administración
     */
    public function adminDelete($id = null)
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();

        if ($usuarioModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Usuario eliminado exitosamente');
        } else {
            $this->session->setFlashdata('error', 'Error al eliminar el usuario');
        }

        return redirect()->to('/admin/usuarios');
    }
}
