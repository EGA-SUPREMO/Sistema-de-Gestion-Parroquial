<?php

require_once 'modelo/GestorBase.php';
require_once "modelo/Parentesco.php";

class GestorParentesco extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "Parentescos";
        $this ->clase_nombre = "Parentesco";
    }

    public function obtenerHijosPorCedula($cedula)
    {
        $sql = "
            SELECT 
                H.* FROM 
                feligreses AS P 
            JOIN 
                {$this->tabla} AS R ON P.id = R.id_padre 
            JOIN 
                feligreses AS H ON R.id_hijo = H.id 
            WHERE 
                P.cedula = ?;
        ";
        return $this->hacerConsulta($sql, [$cedula], 'all');
    }
}
