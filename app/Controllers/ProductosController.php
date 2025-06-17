<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProductosController extends BaseController
{
    public function proteinas()
    {
        $data = [
            'title' => 'Proteínas',
            'content' => view('pages/productos/proteinas')
        ];

        return view('templates/main_layout', $data);
    }

    public function creatinas()
    {
        $data = [
            'title' => 'Creatinas',
            'content' => view('pages/productos/creatinas')
        ];

        return view('templates/main_layout', $data);
    }
    public function colagenos()
    {
        $data = [
            'title' => 'Colagenos',
            'content' => view('pages/productos/colagenos')
        ];

        return view('templates/main_layout', $data);
    }
    public function accesorios()
    {
        $data = [
            'title' => 'Accesorios',
            'content' => view('pages/productos/accesorios')
        ];

        return view('templates/main_layout', $data);
    }
}
