<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index(){
        return view('templates/main_layout', [
            'title' => 'Contacto',
            'content' => view('pages/contact')
        ]);
    }

    public function send()
    {
        // Validar el formulario
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            // Si la validación falla, mostrar errores
            return view('templates/main_layout', [
                'title' => 'Contacto - Mi Tienda',
                'content' => view('pages/contact', [
                    'validation' => $this->validator
                ])
            ]);
        }
        
        // Procesar el formulario (en una implementación completa, 
        // aquí se enviaría un email)
        
        // Redirigir con mensaje de éxito
        return redirect()->to('/contact')->with('message', 
            'Gracias por contactarnos. Te responderemos a la brevedad.');
    }
}


            