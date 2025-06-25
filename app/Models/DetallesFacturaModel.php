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
        // Usar LEFT JOIN para incluir productos que pueden haber sido eliminados
        $db = \Config\Database::connect();
        $detalles = $db->table('detalles_factura df')
            ->select('df.*, p.nombre, p.descripcion, p.url_imagen, p.activo as producto_activo')
            ->join('productos p', 'p.id_producto = df.id_producto', 'left')
            ->where('df.id_factura', $facturaId)
            ->get()
            ->getResultArray();

        // Procesar los detalles para manejar productos eliminados
        foreach ($detalles as &$detalle) {
            // Si el producto no existe o está inactivo, usar información por defecto
            if (!$detalle['nombre'] || $detalle['producto_activo'] != 1) {
                $detalle['nombre'] = $detalle['nombre'] ?: 'Producto Eliminado';
                $detalle['descripcion'] = $detalle['descripcion'] ?: 'Este producto ya no está disponible en el catálogo';
                $detalle['url_imagen'] = $detalle['url_imagen'] ?: 'default-product.webp';
            }
            
            // Remover el campo temporal
            unset($detalle['producto_activo']);
        }

        return $detalles;
    }

    /**
     * Obtiene detalles de factura con información completa del estado del producto
     * @param int $facturaId ID de la factura
     * @return array
     */
    public function getDetallesCompletosByFacturaId($facturaId)
    {
        $db = \Config\Database::connect();
        $detalles = $db->table('detalles_factura df')
            ->select('df.*, p.nombre, p.descripcion, p.url_imagen, p.activo as producto_activo, p.precio as precio_actual')
            ->join('productos p', 'p.id_producto = df.id_producto', 'left')
            ->where('df.id_factura', $facturaId)
            ->get()
            ->getResultArray();

        // Procesar los detalles para manejar productos eliminados
        foreach ($detalles as &$detalle) {
            // Si el producto no existe o está inactivo, usar información por defecto
            if (!$detalle['nombre'] || $detalle['producto_activo'] != 1) {
                $detalle['nombre'] = $detalle['nombre'] ?: 'Producto Eliminado';
                $detalle['descripcion'] = $detalle['descripcion'] ?: 'Este producto ya no está disponible en el catálogo';
                $detalle['url_imagen'] = $detalle['url_imagen'] ?: 'default-product.webp';
                $detalle['producto_eliminado'] = true;
            } else {
                $detalle['producto_eliminado'] = false;
            }
            
            // Calcular precio unitario
            $detalle['precio_unitario'] = $detalle['cantidad'] > 0 ? $detalle['subtotal'] / $detalle['cantidad'] : 0;
        }

        return $detalles;
    }

}
