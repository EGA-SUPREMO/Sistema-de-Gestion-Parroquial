<?php

require_once 'GestorConstancia.php';

require_once 'ConstanciaDeMatrimonio.php';

class GestorConstanciaDeMatrimonio extends GestorConstancia
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_matrimonio";
        $this ->clase_nombre = "ConstanciaDeMatrimonio";
    }
}
