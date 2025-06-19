<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['nombre', 'descripcion', 'activo'];



    public function getCategorySales()
    {
        $db = \Config\Database::connect();
        return $db->table('productos')
            ->join('categorias', 'categorias.id_categoria = productos.id_categoria')
            ->select('categorias.id_categoria, categorias.nombre, SUM(productos.cantidad_vendidos) as total_vendidos')
            ->groupBy('categorias.id_categoria, categorias.nombre')
            ->orderBy('total_vendidos', 'DESC')
            ->get()->getResultArray();
    }
}
