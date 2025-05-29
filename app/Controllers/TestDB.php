<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Database;

class TestDB extends Controller
{
    public function index()
    {
        // Conectar a la base de datos
        $db = Database::connect();

        if ($db->connID) {
            echo "✅ Conexión exitosa a la base de datos.";
        } else {
            echo "❌ No se pudo conectar a la base de datos.";
        }
    }
}