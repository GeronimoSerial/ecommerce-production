<?php

namespace App\Controllers;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class HomeController extends BaseController
{
    private $productoModel;
    private $categoriaModel;
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    public function index()
    {
        // Definir las categorías que queremos mostrar (sin acentos para coincidir con la BD)
        $nombresCategorias = ['proteinas', 'creatinas', 'colagenos', 'accesorios'];

        // Obtener IDs de categorías usando el modelo
        $categorias = $this->categoriaModel->getCategoriasPorNombres($nombresCategorias);

        // Obtener productos más vendidos por categoría usando el modelo
        $productosTopVendidos = $this->productoModel->getTopVendidosPorCategorias($categorias);

        return view('templates/main_layout', [
            'title' => 'Inicio - Mi Tienda',
            'content' => view('pages/home', [
                'topProteinas' => $productosTopVendidos['proteinas'] ?? [],
                'topCreatinas' => $productosTopVendidos['creatinas'] ?? [],
                'topColagenos' => $productosTopVendidos['colagenos'] ?? [],
                'topAccesorios' => $productosTopVendidos['accesorios'] ?? []
            ])
        ]);
    }
}
