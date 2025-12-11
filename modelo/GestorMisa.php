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

    public function obtenerUltimaMisaRegistrada()
    {
        $sql = "SELECT MAX(fecha_hora) as ultima_fecha FROM misas";

        return $this->hacerConsulta($sql, [], 'assoc');
    }

    public function obtenerBORRAR($fecha)
    {
        return $this->obtenerPor($criterios, 'single');
    }

}
