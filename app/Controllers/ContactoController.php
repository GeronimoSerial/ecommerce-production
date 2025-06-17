<?php

namespace App\Controllers;

class ContactoController extends BaseController
{
    public function index()
    {
        return view('templates/main_layout', [
            'title' => 'Contacto',
            'content' => view('pages/contact')
        ]);
    }

}


