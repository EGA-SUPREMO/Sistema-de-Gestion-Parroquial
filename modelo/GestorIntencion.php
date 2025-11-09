<?php

require_once 'Intencion.php';
require_once 'GestorBase.php';

class GestorIntencion extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "Intencion";
        $this ->tabla = "peticiones";
    }
 
}
