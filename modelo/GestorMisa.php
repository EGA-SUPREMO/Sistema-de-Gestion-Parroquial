<?php

require_once 'GestorBase.php';
require_once 'Misa.php';

class GestorMisa extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "misas";
        $this ->clase_nombre = "Misa";
    }

}
