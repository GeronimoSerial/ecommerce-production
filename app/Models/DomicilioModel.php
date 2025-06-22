<?php
namespace App\Models;
use CodeIgniter\Model;

class DomicilioModel extends Model{
    protected $table = 'domicilios';
    protected $primaryKey = 'id_domicilio';
    protected $allowedFields = ['calle', 'numero', 'codigo_postal', 'localidad', 'provincia', 'pais', 'activo'];
}