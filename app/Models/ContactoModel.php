<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoModel extends Model
{
    protected $table = "contactos";
    protected $primaryKey = "id_contacto";
    protected $allowedFields = [
        "id_usuario", 
        "nombre", 
        "email", 
        "asunto", 
        "mensaje", 
        "fecha_envio", 
        "leido",
        "respondido",
        "fecha_respuesta",
        "respuesta",
        "id_admin_responde"
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    /**
     * Obtiene todos los contactos con información del usuario si existe
     */
    public function getAllContactosWithUser()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table . ' c')
            ->select('c.*, u.email as email_usuario, CONCAT(p.nombre, " ", p.apellido) as nombre_usuario, 
                     CONCAT(pa.nombre, " ", pa.apellido) as nombre_admin')
            ->join('usuarios u', 'u.id_usuario = c.id_usuario', 'left')
            ->join('personas p', 'p.id_persona = u.id_persona', 'left')
            ->join('usuarios ua', 'ua.id_usuario = c.id_admin_responde', 'left')
            ->join('personas pa', 'pa.id_persona = ua.id_persona', 'left')
            ->orderBy('c.fecha_envio', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene contactos no leídos
     */
    public function getContactosNoLeidos()
    {
        return $this->where('leido', 0)
                    ->orderBy('fecha_envio', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene contactos no respondidos
     */
    public function getContactosNoRespondidos()
    {
        return $this->where('respondido', 0)
                    ->orderBy('fecha_envio', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene contactos de un usuario específico
     */
    public function getContactosByUser($userId)
    {
        return $this->where('id_usuario', $userId)
                    ->orderBy('fecha_envio', 'DESC')
                    ->findAll();
    }

    /**
     * Marca un contacto como leído
     */
    public function marcarComoLeido($contactoId)
    {
        return $this->update($contactoId, ['leido' => 1]);
    }

    /**
     * Responde a un contacto
     */
    public function responderContacto($contactoId, $respuesta, $adminId)
    {
        return $this->update($contactoId, [
            'respuesta' => $respuesta,
            'respondido' => 1,
            'fecha_respuesta' => date('Y-m-d H:i:s'),
            'id_admin_responde' => $adminId,
            'leido' => 1
        ]);
    }

    /**
     * Obtiene estadísticas de contactos
     */
    public function getEstadisticas()
    {
        $db = \Config\Database::connect();
        
        $total = $this->countAll();
        $noLeidos = $this->where('leido', 0)->countAllResults();
        $noRespondidos = $this->where('respondido', 0)->countAllResults();
        $hoy = $this->where('DATE(fecha_envio)', date('Y-m-d'))->countAllResults();
        
        return [
            'total' => $total,
            'no_leidos' => $noLeidos,
            'no_respondidos' => $noRespondidos,
            'hoy' => $hoy
        ];
    }

    /**
     * Crea un nuevo contacto
     * Si se proporciona id_usuario, obtiene automáticamente nombre y email del usuario
     */
    public function crearContacto($data)
    {
        $data['fecha_envio'] = date('Y-m-d H:i:s');
        $data['leido'] = 0;
        $data['respondido'] = 0;
        
        // Si hay id_usuario, obtener nombre y email automáticamente
        if (!empty($data['id_usuario'])) {
            $usuarioModel = new \App\Models\UsuarioModel();
            $usuario = $usuarioModel->getUserWithAllData($data['id_usuario']);
            
            if ($usuario) {
                $data['nombre'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                $data['email'] = $usuario['email'];
            }
        }
        
        return $this->insert($data);
    }

    /**
     * Obtiene un contacto con información completa del usuario
     */
    public function getContactoWithUser($contactoId)
    {
        $db = \Config\Database::connect();
        return $db->table($this->table . ' c')
            ->select('c.*, u.email as email_usuario, CONCAT(p.nombre, " ", p.apellido) as nombre_usuario, 
                     CONCAT(pa.nombre, " ", pa.apellido) as nombre_admin')
            ->join('usuarios u', 'u.id_usuario = c.id_usuario', 'left')
            ->join('personas p', 'p.id_persona = u.id_persona', 'left')
            ->join('usuarios ua', 'ua.id_usuario = c.id_admin_responde', 'left')
            ->join('personas pa', 'pa.id_persona = ua.id_persona', 'left')
            ->where('c.id_contacto', $contactoId)
            ->get()
            ->getRowArray();
    }
}