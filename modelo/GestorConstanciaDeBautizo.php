<?php

require_once 'modelo/GestorBase.php';
require_once 'modelo/GestorFeligres.php';
require_once 'modelo/GestorPeticion.php';

require_once 'modelo/GeneradorPdf.php';
require_once 'modelo/ConstanciaDeBautizo.php';

class GestorConstanciaDeBautizo extends GestorBase
{
    private $gestorFeligres;
    private $gestorSacerdote;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_bautizo";
        $this ->clase_nombre = "ConstanciaDeBautizo";

        $this->gestorFeligres = new GestorFeligres();
        $this->gestorSacerdote = new GestorSacerdote();
    }

    protected function insertar($objeto) // TODO insertar tambien una peticion con los datos para la constancia sin necesidad de pedirlos por el metodo
    {// TODO insertar o actualizar feligres al crear constancia, en caso de que feligres no sea encontrado
        parent::insertar($objeto);
    }

    protected function actualizar($id, $objeto) // TODO actualizar tambien una peticion con los datos para la constancia sin necesidad de pedirlos por el metodo
    {// TODO insertar o actualizar feligres al crear constancia, en caso de que feligres no sea encontrado
        parent::actualizar($id, $objeto);
    }

    public function guardar($objeto, $id = 0)
    {
        parent::guardar($objeto, $id);

        $objeto->setFeligres($this->gestorFeligres->obtenerPorId($objeto->getFeligresBautizadoId());
        $objeto->setPadre($this->gestorFeligres->obtenerPorId($objeto->getPadreId());
        $objeto->setMadre($this->gestorFeligres->obtenerPorId($objeto->getMadreId());
        $objeto->setMinistro($this->gestorSacerdote->obtenerPorId($objeto->getMinistroId());
        $objeto->setMinistroCertifica($this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaId());

        $datos = $objeto->toArrayParaConstanciaPDF();
        GeneradorPdf::guardarPDF($datos);
    }


    protected function validarDependencias($objeto)
    {
        if (!$this->gestorFeligres->obtenerPorId($objeto->getFeligresBautizadoId())) {
            throw new InvalidArgumentException("Error: El feligrés bautizado no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getPadreId())) {
            throw new InvalidArgumentException("Error: El padre no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getMadreId())) {
            throw new InvalidArgumentException("Error: La madre no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaId())) {
            throw new InvalidArgumentException("Error: El ministro que certifica no existe.");
        }
    }

}
