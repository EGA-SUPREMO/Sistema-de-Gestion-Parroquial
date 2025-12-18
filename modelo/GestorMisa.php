<?php

require_once 'GestorBase.php';
require_once 'Misa.php';

class GestorMisa extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "misas";
        $this ->clase_nombre = "Misa";
    }

    public function existeMisaEnFechaHora($fechaHoraString) {
        $sql = "SELECT COUNT(*) FROM " . $this ->tabla . " WHERE fecha_hora = :fecha_hora";
        
        return $this->hacerConsulta($sql, [':fecha_hora' => $fechaHoraString], 'column') > 0;
    }
    public function obtenerUltimaMisaRegistrada()
    {
        $sql = "SELECT MAX(fecha_hora) as ultima_fecha FROM " . $this ->tabla;

        return $this->hacerConsulta($sql, [], 'assoc');
    }

    public function obtenerMisasConIntencionesPorRangoFechas($fecha_inicio, $fecha_fin)
    {
        $sql = "SELECT * 
                FROM " . $this ->tabla . " 
                WHERE fecha_hora BETWEEN :inicio AND :fin 
                AND permite_intenciones = 1 
                ORDER BY fecha_hora ASC";

        $valores = [
            ':inicio' => $fecha_inicio . ' 00:00:00',
            ':fin'    => $fecha_fin . ' 23:59:59'
        ];
        return $this->hacerConsulta($sql, $valores, 'all');
    }

}
