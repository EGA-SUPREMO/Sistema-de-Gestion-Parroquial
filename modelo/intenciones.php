<?php

require_once 'App.php';
require_once 'EntidadFactory.php';

class GestionPeticionMisa
{
    private $pdo;
    
    function __construct(argument)
    {
        $this->pdo = App::obtenerConexion();
    }

    public function manejarSolicitudDeBusqueda($postData)
    {
        $datos_json = $postData['json'] ?? '{}';
        $datos = json_decode($datos_json, true);
    }
}


App::iniciar();
 
$misa = new GestionPeticionMisa();
$respuesta = $misa->manejarSolicitudDeBusqueda($_POST);
header('Content-Type: application/json');
echo json_encode($respuesta);
exit();
