<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    protected $db;
    protected $builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('usuarios');
    }

    public function index()
    {
        $usuarios = $this->builder->get()->getResult();

        return view('usuarios_view', [
            'usuarios' => $usuarios
        ]);
    }

    public function create()
    {
        return view('/back/usuario/crear');
    }

    public function store()
    {
        // Validar los datos del formulario
        $dni = $this->request->getPost('dni');
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $telefono = $this->request->getPost('telefono');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $id_rol = $this->request->getPost('id_rol');

        $db = $this->db;

        //1- Insertar persona
        $personaData = [
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'id_domicilio' => null,
        ];
        $db->table('personas')->insert($personaData);
        $personaId = $db->insertID();

        //2- Insertar usuario
        $usuarioData = [
            'id_persona' => $personaId,
            'id_rol' => $id_rol,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'activo' => 1
        ];

        $db->table('usuarios')->insert($usuarioData);

        return redirect()->to('/usuarios')->with('success', 'Usuario creado exitosamente.');
    }

    //3- Listar usuarios

    public function listar()
    {
        $builder = $this->db->table('usuarios');
        $builder->select('usuarios.id_usuario, usuarios.email, personas.nombre, personas.apellido, personas.telefono');
        $builder->join('personas', 'usuarios.id_persona = personas.id_persona');
        $usuarios = $builder->get()->getResult();

        return view('usuarios/listar', ['usuarios' => $usuarios]);
    }

}