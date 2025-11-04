<?php

require_once 'Peticion.php';
require_once 'GestorBase.php';

class GestorPeticion extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "Peticion";
        $this ->tabla = "peticiones";
    }

    public function obtenerPorConstanciaDeBautizoId($constanciaDeBautizoId)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `constancia_de_bautizo_id` = ?";
        return $this->hacerConsulta($sql, [$constanciaDeBautizoId], 'single');
    }

}
