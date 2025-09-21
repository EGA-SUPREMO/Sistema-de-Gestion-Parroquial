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

}
