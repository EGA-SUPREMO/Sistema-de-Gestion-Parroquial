<?php

require_once 'Validador.php';
require_once 'Peticion.php';

class Intencion extends Peticion
{

    private $objeto_de_peticion_nombre;

    public function __construct()
    {
  //      parent::__construct();
        $this->setServicioId(1);
    }

    public function setObjetoDePeticionNombre($objeto_de_peticion_nombre)
    {
        $this->objeto_de_peticion_nombre = Validador::validarString($objeto_de_peticion_nombre, 'Nombre de Objeto de Peticion', 50, 2);
    }
    public function obtenerObjetoDePeticionNombre()
    {
        return $this->objeto_de_peticion_nombre;
    }

}
