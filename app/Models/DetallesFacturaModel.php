<?php
namespace App\Models;
use CodeIgniter\Model;

class DetallesFacturaModel extends Model
{
    protected $table = "detalles_factura";
    protected $primaryKey = "id_detalle_factura";
    protected $allowedFields = [
        "id_factura",
        "id_producto",
        "cantidad",
        "descuento",
        "subtotal",
    ];
}
