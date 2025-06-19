<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = "productos";
    protected $primaryKey = "id_producto";
    protected $allowedFields = [
        "id_categoria",
        "nombre",
        "descripcion",
        "precio",
        "cantidad",
        "url_imagen",
        "activo",
        "cantidad_vendidos"
    ];

    public function getAllProductsWithCategories($orden = 'nombre', $direccion = 'ASC', $limit = 20, $offset = 0)
    {
        $db = \Config\Database::connect();
        $allowedOrder = ['nombre', 'precio', 'cantidad', 'categoria_nombre', 'activo', 'id_producto', 'cantidad_vendidos'];
        $allowedDir = ['ASC', 'DESC'];
        if (!in_array($orden, $allowedOrder))
            $orden = 'nombre';
        if (!in_array($direccion, $allowedDir))
            $direccion = 'ASC';

        $builder = $db->table('productos p')
            ->select('p.*, c.nombre as categoria_nombre')
            ->join('categorias c', 'c.id_categoria = p.id_categoria', 'left')
            ->orderBy(($orden == 'categoria_nombre' ? 'c.nombre' : 'p.' . $orden), $direccion)
            ->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    public function getAllProductsValue()
    {
        $db = \Config\Database::connect();
        return $db->table('productos')
            ->select('SUM(precio * cantidad) as total')
            ->get()->getRow()->total ?? 0;
    }
    public function countAllProductsWithCategories()
    {
        $db = \Config\Database::connect();
        return $db->table('productos')->countAllResults();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->where('id_categoria', $categoryId)->findAll();
    }

    public function getLowCantidadProducts($threshold = 10)
    {
        return $this->where('cantidad <', $threshold)->findAll();
    }

    public function countActiveProducts()
    {
        $db = \Config\Database::connect();
        return $db->table('productos')
            ->where('activo', 1)
            ->countAllResults();
    }

    /**
     * Obtiene los productos más vendidos, opcionalmente por categoría.
     * @param int|null $categoriaId Si se pasa, filtra por esa categoría
     * @param int $limite Cantidad máxima de productos a devolver
     * @return array
     */
    public function getTopVendidos($categoriaId = null, $limite = 3)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('productos');
        $builder->where('activo', 1);
        if ($categoriaId !== null) {
            $builder->where('id_categoria', $categoriaId);
        }
        $builder->orderBy('cantidad_vendidos', 'DESC');
        $builder->limit($limite);
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene los productos más vendidos para múltiples categorías
     * @param array $categorias Array asociativo de [nombre_categoria => id_categoria]
     * @param int $limite Cantidad máxima de productos por categoría
     * @return array Array asociativo con [nombre_categoria => [productos]]
     */
    public function getTopVendidosPorCategorias(array $categorias, int $limite = 3)
    {
        $db = \Config\Database::connect();
        $resultado = [];

        foreach ($categorias as $nombre => $id) {
            $builder = $db->table($this->table);
            $productos = $builder->where('activo', 1)
                               ->where('id_categoria', $id)
                               ->orderBy('cantidad_vendidos', 'DESC')
                               ->limit($limite)
                               ->get()
                               ->getResultArray();
            
            $resultado[$nombre] = $productos;
        }

        return $resultado;
    }
}
