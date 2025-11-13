<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class PeticionMisa extends ModeloBase
{
    private $id;
    private $peticion_id;
    private $misa_id;

    public function getId()
    {
        return $this->id;
    }
    public function getPeticionId()
    {
        return $this->peticion_id;
    }
    public function getMisaId()
    {
        return $this->misa_id;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "id", null, 0);
    }
    public function setPeticionId($peticion_id)
    {
        $this->peticion_id = Validador::validarEntero($peticion_id, "id de peticion", null, 0);
    }
    public function setMisaId($misa_id)
    {
        $this->misa_id = Validador::validarEntero($misa_id, "id de misa", null, 0);
    }

}
