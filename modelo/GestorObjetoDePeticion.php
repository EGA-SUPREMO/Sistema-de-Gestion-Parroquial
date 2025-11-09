<?php

require_once 'ObjetoDePeticion.php';
require_once 'GestorBase.php';

class GestorObjetoDePeticion extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "ObjetoDePeticion";
        $this ->tabla = "objetos_de_peticion";
    }

    public function obtenerPorNombre($nombre)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `nombre` = ?";
        return $this->hacerConsulta($sql, [$nombre], 'single');
    }

}
