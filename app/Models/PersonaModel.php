<?php
namespace App\Models;
use CodeIgniter\Model;
class PersonaModel extends Model
{
    // Specifies the database table associated with this model
    protected $table = "personas";

    // Specifies the primary key of the table
    protected $primaryKey = "id_persona";

    // Lists the fields that are allowed to be mass-assigned
    protected $allowedFields = [
        "dni",
        "nombre",
        "apellido",
        "id_domicilio",
        "telefono",
    ];

    // Specifies the fields that should be hidden when converting to an array or JSON
    protected $hidden = ["password"];
}
