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

    public function obtenerMisasSinIntencionRegistradaPorRangoFechas($fecha_inicio, $fecha_fin, $objeto_de_peticion_nombre = '')
    {
        $sql = "SELECT
                m.*
            FROM
                misas m
            WHERE
                m.fecha_hora BETWEEN :inicio AND :fin
                AND m.permite_intenciones = 1
                AND NOT EXISTS (
                    SELECT 1
                    FROM peticion_misa pm
                    JOIN peticiones p ON pm.peticion_id = p.id
                    JOIN objetos_de_peticion odp ON p.objeto_de_peticion_id = odp.id
                    WHERE
                        pm.misa_id = m.id
                        AND odp.nombre IN (:objeto_de_peticion_nombre)
                )
            ORDER BY
                m.fecha_hora ASC;";

        $valores = [
            ':inicio' => $fecha_inicio . ' 00:00:00',
            ':fin'    => $fecha_fin . ' 23:59:59',
            ':objeto_de_peticion_nombre' => $objeto_de_peticion_nombre
        ];

        return $this->hacerConsulta($sql, $valores, 'all');
    }

}
