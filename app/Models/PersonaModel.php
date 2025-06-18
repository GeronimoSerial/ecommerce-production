<?php
namespace App\Models;
use CodeIgniter\Model;

class PersonaModel extends Model {
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    protected $allowedFields = ['nombre', 'apellido', 'id_domicilio', 'telefono'];
}