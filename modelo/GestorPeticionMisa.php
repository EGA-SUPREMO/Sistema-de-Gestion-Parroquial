<?php

require_once 'GestorBase.php';
require_once 'PeticionMisa.php';

class GestorPeticionMisa extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "PeticionMisa";
        $this ->tabla = "peticion_misa";
    }

    public function existeObjetoEnMisa($misa_id, $objeto_de_peticion_id)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM " . $this ->tabla . " pm
                JOIN peticiones p ON pm.peticion_id = p.id
                WHERE pm.misa_id = :misa_id
                AND p.objeto_de_peticion_id = :objeto_id";

        $params = [
            ':misa_id'   => $misa_id,
            ':objeto_id' => $objeto_de_peticion_id
        ];

        $resultado = $this->hacerConsulta($sql, $params, 'assoc');

        return ($resultado['total'] > 0);
    }

    public function eliminarPorPeticionId($peticion_id)
    {
        $sql = "DELETE FROM {$this->tabla} WHERE peticion_id = ?";
        return $this->hacerConsulta($sql, [$peticion_id], 'execute');
    }
}
