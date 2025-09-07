<?php

require_once 'modelo/GestorBase.php';
require_once 'modelo/ConstanciaBautizo.php';

class GestorConstanciaBautizo extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_bautizo";
        $this ->clase_nombre = "ConstanciaBautizo";
    }

    protected function insertar($objeto) {// TODO insertar tambien una peticion con los datos para la constancia sin necesidad de pedirlos por el metodo
        parent::insertar($objeto);
    }

    protected function actualizar($id, $objeto) {// TODO actualizar tambien una peticion con los datos para la constancia sin necesidad de pedirlos por el metodo
        parent::actualizar($id, $objeto);
    }

}
