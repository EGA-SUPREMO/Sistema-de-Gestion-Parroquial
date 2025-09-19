<?php

require_once 'modelo/GestorBase.php';
require_once "modelo/Feligres.php";

class GestorFeligres extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "feligreses";
        $this ->clase_nombre = "Feligres";
    }

    public function obtenerPorCedula($cedula)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE {cedula} = ?";
        return $this->hacerConsulta($sql, [$cedula], 'single');
    }
}
