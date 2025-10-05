<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class Parentesco extends ModeloBase
{
    private $id;
    private $id_padre;
    private $id_hijo;

    public function getId()
    {
        return $this->id;
    }
    public function getIdPadre()
    {
        return $this->id_padre;
    }
    public function getIdHijo()
    {
        return $this->id_hijo;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "id de feligrés", null, 1);
    }
    public function setIdPadre($id_padre)
    {
        $this->id_padre = Validador::validarEntero($id_padre, "id padre de feligrés", null, 1);
    }
    public function setIdHijo($id_hijo)
    {
        $this->id_hijo = Validador::validarEntero($id_hijo, "id hijo de feligrés", null, 1);
    }

}
