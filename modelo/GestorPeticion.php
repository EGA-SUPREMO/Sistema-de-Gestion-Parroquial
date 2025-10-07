<?php

require_once 'GestorBase.php';

class GestorPeticion extends GestorBase
{
    public $id;
    public $feligres_id;
    public $servicio_id;
    public $descripcion;
    public $fecha_registro;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "Peticion";
        $this ->tabla = "peticiones";
    }
}
