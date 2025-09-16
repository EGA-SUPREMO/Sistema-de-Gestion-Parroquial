<?php

require_once 'modelo/GestorBase.php';
require_once 'modelo/GestorFeligres.php';
require_once 'modelo/GestorSacerdote.php';
require_once 'modelo/GestorPeticion.php';

require_once 'modelo/GeneradorPdf.php';
require_once 'modelo/ConstanciaDeBautizo.php';

class GestorConstanciaDeBautizo extends GestorBase
{
    private static $plantilla_nombre;
    private $gestorFeligres;
    private $gestorSacerdote;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_bautizo";
        $this ->clase_nombre = "ConstanciaDeBautizo";

        self::$plantilla_nombre = "fe de bautizo.docx";
        $this->gestorFeligres = new GestorFeligres($pdo);
        $this->gestorSacerdote = new GestorSacerdote($pdo);
    }

    public function guardar($objeto, $id = 0)
    {
        parent::guardar($objeto, $id);
    }

    public function generarPDF($constancia)
    {
        $constancia->setFeligres($this->gestorFeligres->obtenerPorId($constancia->getFeligresBautizadoId()));
        $constancia->setPadre($this->gestorFeligres->obtenerPorId($constancia->getPadreId()));
        $constancia->setMadre($this->gestorFeligres->obtenerPorId($constancia->getMadreId()));
        $constancia->setMinistro($this->gestorSacerdote->obtenerPorId($constancia->getMinistroId()));
        $constancia->setMinistroCertifica($this->gestorSacerdote->obtenerPorId($constancia->getMinistroCertificaId()));

        $datos = $constancia->toArrayParaConstanciaPDF();
        GeneradorPdf::guardarPDF($this->plantilla_nombre, $datos);
    }


    protected function validarDependencias($objeto)
    {
        if (!$this->gestorFeligres->obtenerPorId($objeto->getFeligresBautizadoId())) {
            throw new InvalidArgumentException("Error: El feligrés ${$objeto->getFeligresBautizadoId()} bautizado no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getPadreId())) {
            throw new InvalidArgumentException("Error: El padre ${$objeto->getPadreId()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getMadreId())) {
            throw new InvalidArgumentException("Error: La madre ${$objeto->getMadreId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro ${$objeto->getMinistroId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaId())) {
            throw new InvalidArgumentException("Error: El ministro ${$objeto->getMinistroCertificaId()} que certifica no existe.");
        }
    }

}
