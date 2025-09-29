<?php

require_once "GestorBase.php";
require_once "Feligres.php";

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
        $sql = "SELECT * FROM {$this->tabla} WHERE `cedula` = ?";
        return $this->hacerConsulta($sql, [$cedula], 'single');
    }
}
