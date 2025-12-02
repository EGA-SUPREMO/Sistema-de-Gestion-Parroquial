<?php

require_once 'GestorConstancia.php';

require_once 'ConstanciaDeComunion.php';

class GestorConstanciaDeComunion extends GestorConstancia
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_comunion";
        $this ->clase_nombre = "ConstanciaDeComunion";
    }

    protected function mapearSujetosACriterios($sujetos)
    {
        return ['feligres_id' => $sujetos];
    }

    public function obtenerConstanciaIdPorFeligresId($id)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `feligres_id` = ?";
        $resultado = $this->hacerConsulta($sql, [$id], 'single');
        return $resultado ? $resultado->getId() : 0;
    }
    public function obtenerConstanciaPorFeligresId($id)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `feligres_id` = ?";
        $resultado = $this->hacerConsulta($sql, [$id], 'single');
        return $resultado;
    }

}
