<?php

require_once 'Peticion.php';
require_once 'GestorBase.php';
require_once 'GestorAdministrador.php';

class GestorPeticion extends GestorBase
{
    private $gestorAdministrador;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->gestorAdministrador = new GestorAdministrador($pdo);
        $this ->clase_nombre = "Peticion";
        $this ->tabla = "peticiones";
    }

    public function obtenerPorConstanciaDeBautizoId($constanciaDeBautizoId)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `constancia_de_bautizo_id` = ?";
        return $this->hacerConsulta($sql, [$constanciaDeBautizoId], 'single');
    }

    public function obtenerPorIdDeConstancia($constanciaColumna, $constanciaId)
    {
        return $this->obtenerPor([$constanciaColumna => $constanciaId], 'single');
    }

    public function guardar($peticion, $id = 0)
    {
        $adminActual = $this->gestorAdministrador->obtenerPorNombreUsuario($_SESSION['nombre_usuario']);
        $peticion->setRealizadoPorId($adminActual->getId());
        parent::guardar($peticion, $id);
    }

}
