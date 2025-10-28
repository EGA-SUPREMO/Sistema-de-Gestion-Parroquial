<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class Peticion extends ModeloBase
{
    private $id;
    private $por_quien_id;
    private $realizado_por_id;
    private $tipo_de_intencion_id;
    private $servicio_id;
    private $creado_en;
    private $actualizado_en;
    private $fecha_inicio;
    private $fecha_fin;
    private $constancia_de_bautizo_id;
    private $constancia_de_confirmacion_id;
    private $constancia_de_comunion_id;
    private $constancia_de_matrimonio_id;

    public function getId()
    {
        return $this->id;
    }

    public function getPorQuienId()
    {
        return $this->por_quien_id;
    }

    public function getRealizadoPorId()
    {
        return $this->realizado_por_id;
    }

    public function getTipoDeIntencionId()
    {
        return $this->tipo_de_intencion_id;
    }

    public function getServicioId()
    {
        return $this->servicio_id;
    }

    public function getCreadoEn()
    {
        return $this->creado_en;
    }

    public function getActualizadoEn()
    {
        return $this->actualizado_en;
    }

    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    public function getConstanciaDeBautizoId()
    {
        return $this->constancia_de_bautizo_id;
    }

    public function getConstanciaDeConfirmacionId()
    {
        return $this->constancia_de_confirmacion_id;
    }

    public function getConstanciaDeComunionId()
    {
        return $this->constancia_de_comunion_id;
    }

    public function getConstanciaDeMatrimonioId()
    {
        return $this->constancia_de_matrimonio_id;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, 'id de petición', valorMinimo: 1);
    }

    public function setPorQuienId($por_quien_id)
    {
        $this->por_quien_id = Validador::validarEntero($por_quien_id, 'Por Quien ID', valorMinimo: 1);
    }

    public function setRealizadoPorId($realizado_por_id)
    {
        $this->realizado_por_id = Validador::validarEntero($realizado_por_id, 'Realizado Por ID', valorMinimo: 1);
    }

    public function setTipoDeIntencionId($tipo_de_intencion_id)
    {
        $this->tipo_de_intencion_id = Validador::validarEntero($tipo_de_intencion_id, 'Tipo de Intención ID', valorMinimo: 1);
    }

    public function setServicioId($servicio_id)
    {
        $this->servicio_id = Validador::validarEntero($servicio_id, 'Servicio ID', valorMinimo: 1);
    }

    public function setCreadoEn($creado_en)
    {
        $this->creado_en = Validador::validarFecha($creado_en, 'Creado En');
    }

    public function setActualizadoEn($actualizado_en)
    {
        $this->actualizado_en = Validador::validarFecha($actualizado_en, 'Actualizado En');
    }

    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = Validador::validarFecha($fecha_inicio, 'Fecha Inicio');

        if ($this->fecha_fin !== null) {
            Validador::validarRangoFechas($this->fecha_inicio, $this->fecha_fin);
        }
    }

    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = Validador::validarFecha($fecha_fin, 'Fecha Fin');

        
        if ($this->fecha_inicio !== null) {
            Validador::validarRangoFechas($this->fecha_inicio, $this->fecha_fin);
        }
    }

    

    public function setConstanciaDeBautizoId($id)
    {
        if ($id === null) {
            $this->constancia_de_bautizo_id = null;
        } else {
            $this->constancia_de_bautizo_id = Validador::validarEntero($id, 'Constancia Bautizo ID', valorMinimo: 1);
        }
    }

    public function setConstanciaDeConfirmacionId($id)
    {
        if ($id === null) {
            $this->constancia_de_confirmacion_id = null;
        } else {
            $this->constancia_de_confirmacion_id = Validador::validarEntero($id, 'Constancia Confirmación ID', valorMinimo: 1);
        }
    }

    public function setConstanciaDeComunionId($id)
    {
        if ($id === null) {
            $this->constancia_de_comunion_id = null;
        } else {
            $this->constancia_de_comunion_id = Validador::validarEntero($id, 'Constancia Comunión ID', valorMinimo: 1);
        }
    }

    public function setConstanciaDeMatrimonioId($id)
    {
        if ($id === null) {
            $this->constancia_de_matrimonio_id = null;
        } else {
            $this->constancia_de_matrimonio_id = Validador::validarEntero($id, 'Constancia Matrimonio ID', valorMinimo: 1);
        }
    }

}
