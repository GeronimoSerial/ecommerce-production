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
        // Definir las categorías que queremos mostrar
        $nombresCategorias = ['proteínas', 'creatinas', 'colágenos', 'accesorios'];

        // Obtener IDs de categorías usando el modelo
        $categorias = $this->categoriaModel->getCategoriasPorNombres($nombresCategorias);

        // Obtener productos más vendidos por categoría usando el modelo
        $productosTopVendidos = $this->productoModel->getTopVendidosPorCategorias($categorias);

        return view('templates/main_layout', [
            'title' => 'Inicio - Mi Tienda',
            'content' => view('pages/home', [
                'topProteinas' => $productosTopVendidos['proteínas'] ?? [],
                'topCreatinas' => $productosTopVendidos['creatinas'] ?? [],
                'topColagenos' => $productosTopVendidos['colágenos'] ?? [],
                'topAccesorios' => $productosTopVendidos['accesorios'] ?? []
            ])
        ]);
    }
}
