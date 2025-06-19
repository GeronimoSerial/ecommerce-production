<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['id_persona','id_rol', 'email', 'password_hash', 'activo'];
    
    public function getAllUsersWithPersonas()
    {
        $db = \Config\Database::connect();
        
        return $db->table('usuarios u')
            ->select('u.*, p.nombre, p.apellido')
            ->join('personas p', 'p.id_persona = u.id_persona', 'left')
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
}