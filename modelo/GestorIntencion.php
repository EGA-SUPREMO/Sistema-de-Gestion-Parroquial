<?php

require_once 'Intencion.php';
require_once 'GestorPeticion.php';
require_once 'GestorObjetoDePeticion.php';

class GestorIntencion extends GestorPeticion
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "Intencion";
        $this ->tabla = "peticiones";
    }

}
