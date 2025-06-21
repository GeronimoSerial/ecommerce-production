<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

//controlador para login

class LoginController extends BaseController
{
    private $usuarioModel;
    private $session;


    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->usuarioModel = new UsuarioModel();
        $this->session = session();
    }

    public function index()
    {
        if ($this->session->get('logueado')) {
            return redirect()->to('/panel')->with('error', 'Ya estás logueado. No puedes registrarte nuevamente.');
        }
        return view('templates/main_layout', [
            'title' => 'Login',
            'content' => view('back/usuario/login')
        ]);
    }
    public function registro()
    {
        if ($this->session->get('logueado')) {
            return redirect()->to('/panel')->with('error', 'Ya estás logueado. No puedes registrarte nuevamente.');
        }
        return view('templates/main_layout', [
            'title' => 'Registro',
            'content' => view('back/usuario/registro')
        ]);
    }

    public function auth()
    {
        $input = $this->request->getPost();

        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        // Validación simple
        if (empty($email) || empty($password)) {
            $this->session->setFlashdata('error', 'Por favor, complete todos los campos.');
            return redirect()->to('/login');
        }

        // Autenticar usuario usando el modelo
        $usuario = $this->usuarioModel->authenticateUser($email, $password);

        if ($usuario) {
            // Eliminar perfil_id si existe en la sesión anterior
            $this->session->remove('perfil_id');

            // Guardar datos en sesión
            $this->session->set([
                'usuario_id' => $usuario['id_usuario'],
                'usuario_email' => $usuario['email'],
                'nombre' => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'id_rol' => $usuario['id_rol'] ?? 2,
                'logueado' => true
            ]);

            // Transferir carrito de sesión a base de datos si existe
            $sessionCart = get_session_cart();
            if (!empty($sessionCart)) {
                $cartModel = new \App\Models\CartModel();
                $cartModel->transferFromSession($usuario['id_usuario'], $sessionCart);
                clear_session_cart();
            }

            // Verificar si hay URL de retorno
            $returnUrl = $this->session->get('return_url');
            if ($returnUrl) {
                $this->session->remove('return_url');
                return redirect()->to($returnUrl);
            }

            return redirect()->to('/panel');
        } else {
            // Verificar si el usuario existe pero la contraseña es incorrecta
            $usuarioExiste = $this->usuarioModel->getUserByEmail($email);

            if ($usuarioExiste) {
                if ($usuarioExiste['activo'] != 1) {
                    $this->session->setFlashdata('error', 'El usuario está inactivo. Contacte al administrador.');
                } else {
                    $this->session->setFlashdata('error', 'Contraseña incorrecta.');
                }
            } else {
                $this->session->setFlashdata('error', 'El usuario no existe.');
            }

            return redirect()->to('/login');
        }
    }
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
