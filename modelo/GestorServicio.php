<?php

require_once 'modelo/GestorBase.php';

class GestorServicio extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "servicios";
        $this ->clase_nombre = "Servicio";
    }
}
