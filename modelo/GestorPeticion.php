<?php

require_once 'GestorBase.php';

class GestorPeticion extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "Peticion";
        $this ->tabla = "peticiones";
    }
}
