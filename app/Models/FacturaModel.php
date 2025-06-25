<?php
namespace App\Models;
use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = "facturas";
    protected $primaryKey = "id_factura";
    protected $allowedFields = [
        "id_usuario",
        "importe_total",
        "descuento",
        "activo",
        "fecha_factura"
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_factura';
    protected $updatedField = false;

    public function getFacturasById($facturaId)
    {
        return $this->where('id_factura', $facturaId)
            ->where('activo', 1)
            ->first();
    }


    /**
     * Obtiene todas las facturas con información de usuario y persona
     */
    public function getAllFacturasWithUserData()
    {
        $db = \Config\Database::connect();
        return $db->table('facturas f')
            ->select('f.*, p.nombre, p.apellido, u.email')
            ->join('usuarios u', 'u.id_usuario = f.id_usuario')
            ->join('personas p', 'p.id_persona = u.id_persona')
            ->where('f.activo', 1)
            ->orderBy('f.fecha_factura', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene estadísticas de ventas: total de ventas, ingresos totales y ventas de hoy
     * @return array
     */
    public function getEstadisticasVentas()
    {
        $totalVentas = $this->where('activo', 1)->countAllResults();
        $ingresosTotales = $this->where('activo', 1)->selectSum('importe_total')->get()->getRow()->importe_total ?? 0;
        $ventasHoy = $this->where('activo', 1)
            ->where('DATE(fecha_factura)', date('Y-m-d'))
            ->countAllResults();
        return [
            'totalVentas' => $totalVentas,
            'ingresosTotales' => $ingresosTotales,
            'ventasHoy' => $ventasHoy
        ];
    }

    /**
     * Obtiene las facturas activas de un usuario con información de persona
     */
    public function getFacturasByUsuario($usuarioId)
    {
        $db = \Config\Database::connect();
        return $db->table('facturas f')
            ->select('f.*, p.nombre, p.apellido')
            ->join('usuarios u', 'u.id_usuario = f.id_usuario')
            ->join('personas p', 'p.id_persona = u.id_persona')
            ->where('f.id_usuario', $usuarioId)
            ->where('f.activo', 1)
            ->orderBy('f.fecha_factura', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene una factura activa por id y usuario
     */
    public function getFacturaByIdAndUsuario($facturaId, $usuarioId)
    {
        return $this->where('id_factura', $facturaId)
            ->where('id_usuario', $usuarioId)
            ->where('activo', 1)
            ->first();
    }

}