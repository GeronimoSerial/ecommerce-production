<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

//controlador para login

class LoginController extends BaseController
{
    public function index()
    {

        helper(['form', 'url']);
        $session = session();
        if ($session->get('logueado')) {
            return redirect()->to('/panel')->with('error', 'Ya estás logueado. No puedes registrarte nuevamente.');
        }
        return view('templates/main_layout', [
            'title' => 'Login',
            'content' => view('back/usuario/login')
        ]);
    }
    public function registro()
    {
        $session = session();
        if ($session->get('logueado')) {
            return redirect()->to('/panel')->with('error', 'Ya estás logueado. No puedes registrarte nuevamente.');
        }
        return view('templates/main_layout', [
            'title' => 'Registro',
            'content' => view('back/usuario/registro')
        ]);
    }

    public function auth()
    {
        helper(['form', 'url']);
        $session = session();
        $usuarioModel = new UsuarioModel();
        $input = $this->request->getPost();

        $email = $input['email'];
        $password = $input['password'];
        // $activo = $usuarioModel->where('email', $email)->first()['activo'] == 0 ? false : true;

        // if (!$activo) {
        //     $session->setFlashdata('error', 'El usuario está inactivo. Contacte al administrador.');
        //     return redirect()->to('/login');
        // }

        // Validación simple
        if (empty($email) || empty($password)) {
            $session->setFlashdata('error', 'Por favor, complete todos los campos.');
            return redirect()->to('/login');
        }

        $usuario = $usuarioModel->where('email', $email)->first();
        if ($usuario) {
            // Obtener el nombre de la persona asociada
            $db = \Config\Database::connect();
            $builder = $db->table('personas');
            $persona = $builder->where('id_persona', $usuario['id_persona'])->get()->getRowArray();
            $nombre = $persona ? $persona['nombre'] : '';
            $apellido = $persona ? $persona['apellido'] : '';
            $activo = $usuario['activo'] == 0 ? false : true;

            if (!$activo) {
                $session->setFlashdata('error', 'El usuario está inactivo. Contacte al administrador.');
                return redirect()->to('/login');
            }

            if (password_verify($password, $usuario['password_hash'])) {
                // Eliminar perfil_id si existe en la sesión anterior
                $session->remove('perfil_id');

                // Guardar datos en sesión
                $session->set([
                    'usuario_id' => $usuario['id_usuario'],
                    'usuario_email' => $usuario['email'],
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'id_rol' => $usuario['id_rol'] ?? 2,
                    'logueado' => true
                ]);

                // NOTA: El flag 'logueado' se guarda como tempdata si el usuario marca 'Mantener sesión iniciada'.
                // Los demás datos de usuario siguen en la sesión normal.
                // Si el usuario quiere mantener la sesión iniciada, extiende la duración de la cookie
                // if ($remember) {
                //     $session->setTempdata('logueado', true, 60 * 60 * 24 * 30); // 30 días
                // }

                return redirect()->to('/panel');
            } else {
                $session->setFlashdata('error', 'Contraseña incorrecta.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'El usuario no existe.');
            return redirect()->to('/login');
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        // $session->remove('apellido');
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
