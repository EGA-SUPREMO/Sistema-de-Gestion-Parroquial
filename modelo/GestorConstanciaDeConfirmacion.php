<?php

require_once 'GestorConstancia.php';

require_once 'ConstanciaDeConfirmacion.php';

class GestorConstanciaDeConfirmacion extends GestorConstancia
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_confirmacion";
        $this ->clase_nombre = "ConstanciaDeConfirmacion";
    }
}
