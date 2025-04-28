<?php

namespace App\Controllers;

class ComercializacionController extends BaseController
{
    public function index()
    {
        return view(
            'templates/main_layout',
            [
                'title' => 'Comercialización',
                'content' => view('pages/comercialization')
            ]
        );
    }

}