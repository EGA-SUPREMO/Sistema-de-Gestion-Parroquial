<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';


class Misa extends ModeloBase
{
    private $id;
    private $fecha_hora;
    private $permite_intenciones;

    public function getId()
    {
        return $this->id;
    }

    public function getFechaHora()
    {
        return $this->fecha_hora;
    }

    public function getPermiteIntenciones()
    {
        return $this->permite_intenciones;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "id de la misa", null, 0);
    }

    public function setFechaHora($fecha_hora)
    {
        $fecha_actual_ayer = (new DateTime())->modify('-1 day')->format('Y-m-d H:i:s');
        $fecha_actual_uno_anno_despues = (new DateTime())->modify('+1 year')->format('Y-m-d H:i:s');
        $this->fecha_hora = Validador::validarFecha($fecha_hora, "fecha y hora de la misa", $fecha_actual_ayer, $fecha_actual_uno_anno_despues, 'Y-m-d H:i:s');
    }

    public function setPermiteIntenciones($permite_intenciones)
    {
        if ($permite_intenciones === "on") {
            $this->permite_intenciones = true;
            return;
        }
        $this->permite_intenciones = Validador::validarBooleano($permite_intenciones, "permite intenciones esta misa");
    }
}
