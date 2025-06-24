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


    public function getDetallesByFacturaId($facturaId)
    {
        // Obtener detalles de la factura con información de productos
        $db = \Config\Database::connect();
        return $detalles = $db->table('detalles_factura df')
            ->select('df.*, p.nombre, p.descripcion, p.url_imagen')
            ->join('productos p', 'p.id_producto = df.id_producto')
            ->where('df.id_factura', $facturaId)
            ->get()
            ->getResultArray();
    }

}
