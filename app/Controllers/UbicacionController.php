<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class UbicacionController extends Controller
{
    public function provincias()
    {
        $apiUrl = "https://apis.datos.gob.ar/georef/api/provincias?campos=id,nombre";
        $response = file_get_contents($apiUrl);
        return $this->response->setJSON(json_decode($response, true));
    }

    public function localidades($provinciaId)
    {
        $apiUrl = "https://apis.datos.gob.ar/georef/api/localidades?provincia=" . $provinciaId . "&campos=id,nombre&max=1000";
        $response = file_get_contents($apiUrl);
        return $this->response->setJSON(json_decode($response, true));
    }
}