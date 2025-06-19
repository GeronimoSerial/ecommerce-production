<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['nombre', 'descripcion', 'activo'];

    public function getVendidosPorCategoria()
    {
        $db = \Config\Database::connect();
        return $db->table('categorias c')
            ->select('c.id_categoria, c.nombre, SUM(p.cantidad_vendidos) as vendidos_categoria')
            ->join('productos p', 'p.id_categoria = c.id_categoria', 'left')
            ->groupBy('c.id_categoria, c.nombre')
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
