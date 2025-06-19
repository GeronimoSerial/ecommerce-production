<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['nombre', 'descripcion', 'activo'];

    /**
     * Obtiene el conteo de productos por categoría
     * @return array
     */
    public function getProductosPorCategoria()
    {
        $db = \Config\Database::connect();
        return $db->table('productos p')
                 ->select('c.nombre as categoria, COUNT(*) as total')
                 ->join('categorias c', 'c.id_categoria = p.id_categoria')
                 ->groupBy('p.id_categoria')
                 ->get()
                 ->getResultArray();
    }

    /**
     * Obtiene el total de productos vendidos por categoría
     * @return array
     */
    public function getVendidosPorCategoria()
    {
        $db = \Config\Database::connect();
        return $db->table('productos p')
                 ->select('c.nombre as categoria, SUM(p.cantidad_vendidos) as total_vendidos')
                 ->join('categorias c', 'c.id_categoria = p.id_categoria')
                 ->groupBy('p.id_categoria')
                 ->get()
                 ->getResultArray();
    }

    // public function getCategorySales()
    // {
    //     $db = \Config\Database::connect();
    //     return $db->table('productos')
    //         ->join('categorias', 'categorias.id_categoria = productos.id_categoria')
    //         ->select('categorias.id_categoria, categorias.nombre, SUM(productos.cantidad_vendidos) as total_vendidos')
    //         ->groupBy('categorias.id_categoria, categorias.nombre')
    //         ->orderBy('total_vendidos', 'DESC')
    //         ->get()->getResultArray();
    // }

    /**
     * Obtiene las categorías por sus nombres
     * @param array $nombres Array de nombres de categorías a buscar
     * @return array Array asociativo con [nombre_en_minúsculas => id_categoria]
     */
    public function getCategoriasPorNombres(array $nombres)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        
        // Convertir todos los nombres a minúsculas para la comparación
        $nombresMin = array_map('strtolower', $nombres);
        
        $categorias = $builder->whereIn('LOWER(nombre)', $nombresMin)
                            ->get()
                            ->getResultArray();
        
        // Crear array asociativo [nombre_en_minusculas => id_categoria]
        $resultado = [];
        foreach ($categorias as $cat) {
            $resultado[strtolower($cat['nombre'])] = $cat['id_categoria'];
        }
        
        return $resultado;
    }
}
