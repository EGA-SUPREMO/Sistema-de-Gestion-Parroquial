<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class ObjetoDePeticion extends ModeloBase
{
    private $id;
    private $nombre;

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "Id del Objecto de Peticion", null, 0);
    }

    public function setNombre($nombre)
    {
        $this->nombre = Validador::validarString($nombre, "Nombre del Objecto de Peticion", 50, 3);
        if ($this->nombre !== null) {
            $this->nombre = ucwords($this->nombre);
        }
    }
}
