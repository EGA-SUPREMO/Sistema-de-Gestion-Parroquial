<?php

require_once 'modelo/GestorBase.php';

class GestorFeligres extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "feligreses";
        $this ->clase_nombre = "Feligres";
    }

}
