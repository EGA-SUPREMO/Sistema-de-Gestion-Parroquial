<?php

require_once 'GestorBase.php';
require_once 'PeticionMisa.php';

class GestorPeticionMisa extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "PeticionMisa";
        $this ->tabla = "peticion_misa";
    }

}
