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

    public function getAllProductsWithCategories($orden = 'nombre', $direccion = 'ASC', $limite = 20, $offset = 0)
    {
        $db = \Config\Database::connect();
        // Mapeo de nombres de ordenamiento
        $columnasOrdenamiento = [
            'categoria' => 'c.nombre',
            'nombre' => 'p.nombre',
            'precio' => 'p.precio',
            'cantidad' => 'p.cantidad',
            'id_producto' => 'p.id_producto'
        ];

        $columnaOrden = $columnasOrdenamiento[$orden] ?? 'p.nombre';

        $query = $db->table($this->table . ' p')
            ->select('p.*, c.nombre as categoria')
            ->join('categorias c', 'c.id_categoria = p.id_categoria');

        // Aplicar ordenamiento
        $query->orderBy($columnaOrden, $direccion);

        return $query->limit($limite, $offset)
            ->get()
            ->getResultArray();
    }

    public function getAllProductsValue()
    {
        $db = \Config\Database::connect();
        $result = $db->table($this->table)
            ->select('SUM(precio * cantidad) as valor_total')
            ->get()
            ->getRow();
        return $result ? $result->valor_total : 0;
    }

    public function countAllProductsWithCategories()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table . ' p')
            ->join('categorias c', 'c.id_categoria = p.id_categoria')
            ->countAllResults();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->where('id_categoria', $categoryId)->findAll();
    }

    public function getLowCantidadProducts($limite = 10)
    {
        return $this->where('cantidad <', $limite)
            ->findAll();
    }

    

    public function getProductosSinStock()
    {
        return $this->where('cantidad', 0)
            ->findAll();
    }

    public function countActiveProducts()
    {
        return $this->where('activo', 1)
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

    /**
     * Obtiene productos filtrados y paginados por categoría
     * @param int $categoriaId ID de la categoría
     * @param array $filtros Array con filtros (busqueda, precio_min, precio_max, orden, direccion)
     * @param array $paginacion Array con datos de paginación (pagina, limite)
     * @return array Array con productos y total
     */
    public function getProductosFiltrados($categoriaId = null, array $filtros = [], array $paginacion = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        // Aplicar filtros base
        $builder->where('activo', 1);

        // Filtrar por categoría si se proporciona
        if ($categoriaId !== null) {
            $builder->where('id_categoria', $categoriaId);
        }

        // Aplicar filtros de búsqueda
        if (!empty($filtros['q'])) {
            $builder->groupStart()
                ->like('nombre', $filtros['q'])
                ->orLike('descripcion', $filtros['q'])
                ->groupEnd();
        }

        // Obtener total antes de aplicar límites
        $total = $builder->countAllResults(false);

        // Aplicar ordenamiento
        $ordenesPermitidos = ['nombre', 'precio', 'cantidad', 'cantidad_vendidos'];
        $direccionesPermitidas = ['ASC', 'DESC'];

        $orden = $filtros['orden'] ?? 'nombre';
        $direccion = $filtros['direccion'] ?? 'ASC';

        if (in_array($orden, $ordenesPermitidos)) {
            $builder->orderBy($orden, in_array($direccion, $direccionesPermitidas) ? $direccion : 'ASC');
        } else {
            $builder->orderBy('nombre', 'ASC');
        }

        // Aplicar paginación
        if (!empty($paginacion['limite'])) {
            $pagina = $paginacion['pagina'] ?? 1;
            $limite = $paginacion['limite'];
            $offset = ($pagina - 1) * $limite;
            $builder->limit($limite, $offset);
        }

        return [
            'productos' => $builder->get()->getResultArray(),
            'total' => $total
        ];
    }

    /**
     * Obtiene estadísticas de precios de productos
     * @param int|null $categoriaId ID de la categoría (opcional)
     * @return array Array con precio mínimo y máximo
     */
    public function getEstadisticasPrecios($categoriaId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table)->where('activo', 1);

        if ($categoriaId !== null) {
            $builder->where('id_categoria', $categoriaId);
        }

        $precioMinimo = $builder->selectMin('precio')->get()->getRowArray();
        $precioMaximo = $builder->selectMax('precio')->get()->getRowArray();

        return [
            'minimo' => $precioMinimo['precio'] ?? 0,
            'maximo' => $precioMaximo['precio'] ?? 0
        ];
    }

    /**
     * Obtiene productos relacionados por categoría
     * @param int $productoId ID del producto actual
     * @param int $categoriaId ID de la categoría
     * @param int $limite Cantidad de productos a retornar
     * @return array
     */
    public function getProductosRelacionados($productoId, $categoriaId, $limite = 3)
    {
        return $this->where('id_categoria', $categoriaId)
            ->where('id_producto !=', $productoId)
            ->where('activo', 1)
            ->limit($limite)
            ->findAll();
    }

    public function getNombreCategoria($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categorias')->where('id_categoria', $id);
        return $builder->get()->getRowArray()['nombre'];
    }
}
