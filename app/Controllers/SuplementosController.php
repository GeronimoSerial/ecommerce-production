<?php

namespace App\Controllers;

class SuplementosController extends BaseController
{
    public function index()
    {
        return view('templates/main_layout', [
            'title' => 'Suplementos Deportivos',
            'content' => view('pages/supplements')
        ]);
    }
}