<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $productoModel = new \App\Models\ProductoModel();
        $categoriaModel = new \App\Models\CategoriaModel();

        // Definir las categorías que queremos mostrar
        $nombresCategorias = ['proteínas', 'creatinas', 'colágenos', 'accesorios'];
        
        // Obtener IDs de categorías usando el modelo
        $categorias = $categoriaModel->getCategoriasPorNombres($nombresCategorias);
        
        // Obtener productos más vendidos por categoría usando el modelo
        $productosTopVendidos = $productoModel->getTopVendidosPorCategorias($categorias);

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
