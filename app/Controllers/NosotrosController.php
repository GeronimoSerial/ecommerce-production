<?php

namespace App\Controllers;

class NosotrosController extends BaseController
{
    public function index()
    {
        return view('templates/main_layout', [
            'title' => 'Quiénes Somos',
            'content' => view('pages/about')
        ]);
    }


}
