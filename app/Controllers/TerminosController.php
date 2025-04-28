<?php

namespace App\Controllers;

class TerminosController extends BaseController
{
    public function index()
    {
        return view('templates/main_layout', [
            'title' => 'Términos y Condiciones',
            'content' => view('pages/terms')
        ]);
    }


}
