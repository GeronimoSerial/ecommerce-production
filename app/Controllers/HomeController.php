<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
        {
            // Cargar la página de inicio
            return view('templates/main_layout', [
                'title' => 'Inicio - Mi Tienda',
                'content' => view('pages/home')
            ]);
        }


}
