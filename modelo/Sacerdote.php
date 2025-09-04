<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class Sacerdote extends ModeloBase
{
    private $id;
    private $nombre;
    private $vivo;

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getVivo()
    {
        return $this->vivo;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "id del sacerdote");
    }

    public function setNombre($nombre)
    {
        $this->nombre = Validador::validarString($nombre, "nombre del sacerdote", 100, 3);
        if ($this->nombre !== null) {
            $this->nombre = ucwords($this->nombre);
        }
    }

    public function setVivo($vivo)
    {
        if ($vivo === "on") {
            $this->vivo = true;
            return;
        }
        $this->vivo = Validador::validarBooleano($vivo, "estado de vida del sacerdote");
    }
}
 
