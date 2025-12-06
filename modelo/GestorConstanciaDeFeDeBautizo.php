<?php

require_once 'GestorConstancia.php';

require_once 'ConstanciaDeFeDeBautizo.php';

class GestorConstanciaDeFeDeBautizo extends GestorConstancia
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_fe_de_bautizo";
        $this ->clase_nombre = "ConstanciaDeFeDeBautizo";
    }

    protected function mapearSujetosACriterios($sujetos)
    {
        return ['feligres_bautizado_id' => $sujetos];
    }
}
