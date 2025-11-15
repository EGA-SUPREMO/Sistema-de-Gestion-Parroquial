<?php

require_once "GestorBase.php";
require_once "Feligres.php";

class GestorFeligres extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "feligreses";
        $this ->clase_nombre = "Feligres";
    }

    public function obtenerHijosPorCedulaPadre($cedula)
    {
        $sql = "
            SELECT 
                H.* FROM 
                {$this->tabla} AS P 
            JOIN 
                parentescos AS R ON P.id = R.id_padre 
            JOIN 
                {$this->tabla} AS H ON R.id_hijo = H.id 
            WHERE 
                P.cedula = ?;
        ";
        return $this->hacerConsulta($sql, [$cedula], 'all');
    }

    public function obtenerPorCedula($cedula)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `cedula` = ?";
        return $this->hacerConsulta($sql, [$cedula], 'single');
    }

    public function obtenerPorPartidaDeNacimiento($partida_de_nacimiento)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `partida_de_nacimiento` = ?";
        return $this->hacerConsulta($sql, [$partida_de_nacimiento], 'single');
    }

    public function upsertFeligresPorArray($datosFeligres)
    {
        $feligres = $this->obtenerPorCedula($datosFeligres['cedula']);
        $id = 0;
        if ($feligres) {
            $feligres->hydrate($datosFeligres);
            $id = $feligres->getId();
            $this->guardar($feligres, $id);
        } else {
            $feligres = new Feligres();
            $feligres->hydrate($datosFeligres);
            $id = $this->guardar($feligres);
        }

        if (!$id) {
            throw new Exception("Error al persistir el feligrés con cédula: " . $datosFeligres['cedula']);
        }

        return $id;
    }
}
