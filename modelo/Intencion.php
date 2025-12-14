<?php

require_once 'Validador.php';
require_once 'Peticion.php';

class Intencion extends Peticion
{
    private $objeto_de_peticion_nombre;
    private $misa_ids;

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

    public function setMisaIds($misa_ids)
    {
        if (!is_array($misa_ids)) {
            $this->misa_ids = [];
            return;
        }

        $flat_ids = [];

        foreach ($misa_ids as $item) {
            $parts = explode(',', $item);
            $flat_ids = array_merge($flat_ids, $parts);
        }

        $this->misa_ids = array_values(array_unique(array_map('intval', $flat_ids)));
    }

    public function obtenerMisaIds()
    {
        return $this->misa_ids;
    }

}
