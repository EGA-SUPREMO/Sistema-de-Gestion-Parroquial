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

    public function obtenerPorPartidaDeNacimiento($partida_de_nacimiento)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `partida_de_nacimiento` = ?";
        return $this->hacerConsulta($sql, [$partida_de_nacimiento], 'single');
    }
}
