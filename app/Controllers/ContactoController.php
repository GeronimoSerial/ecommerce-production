<?php

namespace App\Controllers;

use App\Models\ContactoModel;
use App\Models\UsuarioModel;

class ContactoController extends BaseController
{
    protected $contactoModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->contactoModel = new ContactoModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        // Obtener datos del usuario si está logueado
        $session = session();
        $usuario = null;
        
        if ($session->get('usuario_id')) {
            $usuario = $this->usuarioModel->getUserWithAllData($session->get('usuario_id'));
        }

        return view('templates/main_layout', [
            'title' => 'Contacto',
            'content' => view('pages/contact', ['usuario' => $usuario])
        ]);
    }

    /**
     * Procesa el formulario de contacto
     */
    public function enviar()
    {
        $session = session();
        $input = $this->request->getPost();

        // Validación según si el usuario está logueado o no
        if ($session->get('usuario_id')) {
            // Usuario logueado - solo validar asunto y mensaje
            $validationRules = [
                'asunto' => 'required|min_length[5]|max_length[200]',
                'mensaje' => 'required|min_length[10]|max_length[2000]'
            ];
        } else {
            // Usuario no logueado - validar todos los campos
            $validationRules = [
                'nombre' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|max_length[255]',
                'asunto' => 'required|min_length[5]|max_length[200]',
                'mensaje' => 'required|min_length[10]|max_length[2000]'
            ];
        }

        if (!$this->validate($validationRules)) {
            $usuario = null;
            if ($session->get('usuario_id')) {
                $usuario = $this->usuarioModel->getUserWithAllData($session->get('usuario_id'));
            }

            return view('templates/main_layout', [
                'title' => 'Contacto',
                'content' => view('pages/contact', [
                    'usuario' => $usuario,
                    'validation' => $this->validator,
                    'old' => $input
                ])
            ]);
        }

        // Preparar datos para guardar
        $contactoData = [
            'asunto' => $input['asunto'],
            'mensaje' => $input['mensaje']
        ];

        // Si el usuario está logueado, usar su ID
        if ($session->get('usuario_id')) {
            $contactoData['id_usuario'] = $session->get('usuario_id');
        } else {
            // Si no está logueado, usar los datos del formulario
            $contactoData['nombre'] = $input['nombre'];
            $contactoData['email'] = $input['email'];
        }

        // Guardar el contacto
        $contactoId = $this->contactoModel->crearContacto($contactoData);

        if ($contactoId) {
            $session->setFlashdata('success', 'Tu mensaje ha sido enviado correctamente. Te responderemos pronto.');
        } else {
            $session->setFlashdata('error', 'Hubo un error al enviar tu mensaje. Por favor, inténtalo de nuevo.');
        }

        return redirect()->to('/contacto');
    }

    /**
     * Vista del administrador para gestionar contactos
     */
    public function admin()
    {
        $session = session();
        
        // Verificar si es administrador (id_rol = 1)
        if (!$session->get('usuario_id') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $contactos = $this->contactoModel->getAllContactosWithUser();
        $estadisticas = $this->contactoModel->getEstadisticas();

        return view('templates/main_layout', [
            'title' => 'Gestión de Contactos',
            'content' => view('back/admin/contactos', [
                'contactos' => $contactos,
                'estadisticas' => $estadisticas
            ])
        ]);
    }

    /**
     * Marca un contacto como leído
     */
    public function marcarLeido($id)
    {
        $session = session();
        
        if (!$session->get('usuario_id') || $session->get('id_rol') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado']);
        }

        $result = $this->contactoModel->marcarComoLeido($id);
        
        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Contacto marcado como leído' : 'Error al marcar como leído'
        ]);
    }

    /**
     * Responde a un contacto
     */
    public function responder($id)
    {
        $session = session();
        
        if (!$session->get('usuario_id') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $input = $this->request->getPost();
        
        if (!$this->validate(['respuesta' => 'required|min_length[10]|max_length[2000]'])) {
            $session->setFlashdata('error', 'La respuesta debe tener al menos 10 caracteres.');
            return redirect()->to('/contacto/admin');
        }

        $result = $this->contactoModel->responderContacto(
            $id, 
            $input['respuesta'], 
            $session->get('usuario_id')
        );

        if ($result) {
            $session->setFlashdata('success', 'Respuesta enviada correctamente.');
        } else {
            $session->setFlashdata('error', 'Error al enviar la respuesta.');
        }

        return redirect()->to('/contacto/admin');
    }

    /**
     * Vista del usuario para ver sus contactos
     */
    public function misContactos()
    {
        $session = session();
        
        if (!$session->get('usuario_id')) {
            return redirect()->to('/login');
        }

        $contactos = $this->contactoModel->getContactosByUser($session->get('usuario_id'));

        return view('templates/main_layout', [
            'title' => 'Mis Contactos',
            'content' => view('back/usuario/mis_contactos', [
                'contactos' => $contactos
            ])
        ]);
    }

    /**
     * Detalle de un contacto específico
     */
    public function detalle($id)
    {
        $session = session();
        
        if (!$session->get('usuario_id')) {
            return redirect()->to('/login');
        }

        $contacto = $this->contactoModel->getContactoWithUser($id);
        
        if (!$contacto) {
            return redirect()->to('/contacto/mis-contactos');
        }

        // Verificar que el usuario puede ver este contacto
        if ($session->get('id_rol') != 1 && $contacto['id_usuario'] != $session->get('usuario_id')) {
            return redirect()->to('/contacto/mis-contactos');
        }

        // Marcar como leído si es administrador
        if ($session->get('id_rol') == 1 && !$contacto['leido']) {
            $this->contactoModel->marcarComoLeido($id);
        }

        // Determinar qué vista usar según el rol
        $esAdmin = $session->get('id_rol') == 1;
        $vista = $esAdmin ? 'back/admin/detalle_contacto' : 'back/usuario/detalle_contacto';

        return view('templates/main_layout', [
            'title' => 'Detalle del Contacto',
            'content' => view($vista, [
                'contacto' => $contacto,
                'esAdmin' => $esAdmin
            ])
        ]);
    }
}


