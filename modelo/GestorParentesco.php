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

    public function esAncestroDirecto($idPadre, $idHijo)
    {// TODO testear si esta funcion 'sirve'
        $sql = "
            SELECT 
                COUNT(*) 
            FROM 
                {$this->tabla} 
            WHERE 
                id_padre = ? AND id_hijo = ?;
        ";
        
        $cantidad = $this->hacerConsulta($sql, [$idHijo, $idPadre], 'column'); // NO CAMBIAR DE ORDEN
        if ($cantidad) {
            throw new Exception("Error: La relación entre padre e hijo crea una dependencia circular.");
        }
    }

    public function verificarParadojaDeParentesco($parentescoAValidar, $listaNuevosParentescos)
    {
        $idPadrePropuesto = $parentescoAValidar->getPadreId();
        $idHijoPropuesto = $parentescoAValidar->getIdHijo();

        if ($this->esAncestroDirecto($idPadrePropuesto, $idHijoPropuesto)) {
            throw new Exception("Error: La relación entre padre e hijo crea una dependencia circular.");
        }

        foreach ($listaNuevosParentescos as $otroParentesco) {
            $esInverso = ($otroParentesco->getPadreId() === $idHijoPropuesto) && 
                         ($otroParentesco->getIdHijo() === $idPadrePropuesto);

            if ($esInverso) {
                throw new Exception("Error: La relación entre padre e hijo crea una dependencia circular.");
            }
        }
    }

}
