<?php

require_once 'modelo/GestorBase.php';
require_once 'modelo/ConstanciaBautizo.php';

class GestorConstanciaBautizo extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_bautizo";
        $this ->clase_nombre = "ConstanciaBautizo";
    }

}
 
