<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['id_persona', 'id_rol', 'email', 'password_hash', 'activo'];

    /**
     * Obtiene todos los usuarios con sus datos personales
     * @return array
     */
    public function getAllUsersWithPersonas()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table . ' u')
            ->select('u.*, p.nombre, p.apellido, p.dni, p.telefono, r.nombre as rol')
            ->join('personas p', 'p.id_persona = u.id_persona')
            ->join('roles r', 'r.id_rol = u.id_rol')
            ->get()
            ->getResultArray();
    }

    public function getUsersByRole($roleId)
    {
        return $this->where('id_rol', $roleId)->findAll();
    }

    public function getActiveUsers()
    {
        return $this->where('activo', 1)->findAll();
    }

    /**
     * Obtiene un usuario con todos sus datos relacionados
     * @param int $usuarioId ID del usuario
     * @return array|null
     */
    public function getUserWithAllData($usuarioId)
    {
        $db = \Config\Database::connect();
        return $db->table($this->table . ' u')
            ->select('u.*, p.*, d.*, r.nombre as rol')
            ->join('personas p', 'p.id_persona = u.id_persona')
            ->join('domicilios d', 'd.id_domicilio = p.id_domicilio')
            ->join('roles r', 'r.id_rol = u.id_rol')
            ->where('u.id_usuario', $usuarioId)
            ->get()
            ->getRowArray();
    }

    /**
     * Crea un nuevo usuario con todos sus datos relacionados
     * @param array $userData Datos del usuario
     * @param array $personaData Datos de la persona
     * @param array $domicilioData Datos del domicilio
     * @return int|false ID del usuario creado o false si falla
     */
    public function createUserWithRelations($userData, $personaData, $domicilioData = null)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $idDomicilio = null;

            // 1. Insertar domicilio si se proporciona
            if ($domicilioData !== null) {
                $db->table('domicilios')->insert($domicilioData);
                $idDomicilio = $db->insertID();
            }

            // 2. Insertar persona
            if ($idDomicilio !== null) {
                $personaData['id_domicilio'] = $idDomicilio;
            }

            $db->table('personas')->insert($personaData);
            $idPersona = $db->insertID();

            // 3. Insertar usuario
            $userData['id_persona'] = $idPersona;
            $db->table($this->table)->insert($userData);
            $idUsuario = $db->insertID();

            $db->transCommit();
            return $idUsuario;
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }

    /**
     * Actualiza un usuario y sus datos relacionados
     * @param int $usuarioId ID del usuario
     * @param array $userData Datos del usuario
     * @param array $personaData Datos de la persona
     * @param array $domicilioData Datos del domicilio
     * @return bool
     */
    public function updateUserWithRelations($usuarioId, $userData, $personaData, $domicilioData)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Obtener IDs relacionados
            $usuario = $this->find($usuarioId);
            $persona = $db->table('personas')->where('id_persona', $usuario['id_persona'])->get()->getRowArray();

            // Actualizar domicilio
            if ($domicilioData) {
                $db->table('domicilios')
                    ->where('id_domicilio', $persona['id_domicilio'])
                    ->update($domicilioData);
            }

            // Actualizar persona
            if ($personaData) {
                $db->table('personas')
                    ->where('id_persona', $usuario['id_persona'])
                    ->update($personaData);
            }

            // Actualizar usuario
            if ($userData) {
                $db->table($this->table)
                    ->where('id_usuario', $usuarioId)
                    ->update($userData);
            }

            $db->transCommit();
            return true;
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }

    //el administrador solo puede modificar rol y estado del usuario
    public function updateRolOrStatus($userData, $usuarioId)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            // Verificar si el usuario existe
            $usuario = $this->find($usuarioId);
            if (!$usuario) {
                throw new \Exception('Usuario no encontrado');
            }

            // $persona = $db->table('personas')->where('id_persona', $usuario['id_persona'])->get()->getRowArray();
            // Actualizar usuario
            if ($userData) {
                $db->table($this->table)
                    ->where('id_usuario', $usuarioId)
                    ->update($userData);
            }
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
        $db->transComplete();
        if ($db->transStatus() === false) {
            throw new \Exception('Error al actualizar el usuario');
        }
        return true;
    }

    /**
     * Autentica un usuario con email y contraseña
     * @param string $email Email del usuario
     * @param string $password Contraseña en texto plano
     * @return array|false Datos del usuario autenticado o false si falla
     */
    public function authenticateUser($email, $password)
    {
        $db = \Config\Database::connect();

        // Buscar usuario con datos de persona
        $usuario = $db->table($this->table . ' u')
            ->select('u.*, p.nombre, p.apellido')
            ->join('personas p', 'p.id_persona = u.id_persona')
            ->where('u.email', $email)
            ->get()
            ->getRowArray();

        if (!$usuario) {
            return false;
        }

        // Verificar si el usuario está activo
        if ($usuario['activo'] != 1) {
            return false;
        }

        // Verificar contraseña
        if (!password_verify($password, $usuario['password_hash'])) {
            return false;
        }

        return $usuario;
    }

    /**
     * Verifica si un email ya existe en la base de datos
     * @param string $email Email a verificar
     * @param int|null $excludeId ID de usuario a excluir (para actualizaciones)
     * @return bool
     */
    public function emailExists($email, $excludeId = null)
    {
        $query = $this->where('email', $email);

        if ($excludeId !== null) {
            $query->where('id_usuario !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }

    /**
     * Obtiene un usuario por email
     * @param string $email Email del usuario
     * @return array|null
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Actualiza la contraseña de un usuario
     * @param int $usuarioId ID del usuario
     * @param string $newPassword Nueva contraseña en texto plano
     * @return bool
     */
    public function updatePassword($usuarioId, $newPassword)
    {
        return $this->update($usuarioId, [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }
}