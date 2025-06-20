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
}