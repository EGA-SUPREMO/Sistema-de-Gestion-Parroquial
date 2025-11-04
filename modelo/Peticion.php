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
        $this->id = Validador::validarEntero($id, 'id de petición', valorMinimo: 0);
    }

    public function setPorQuienId($por_quien_id)
    {
        $this->por_quien_id = Validador::validarEntero($por_quien_id, 'Por quien feligres ID', valorMinimo: 0);
    }

    public function setRealizadoPorId($realizado_por_id)
    {
        $this->realizado_por_id = Validador::validarEntero($realizado_por_id, 'Realizado por ID', valorMinimo: 0);
    }

    public function setTipoDeIntencionId($tipo_de_intencion_id)
    {
        $this->tipo_de_intencion_id = Validador::validarEntero($tipo_de_intencion_id, 'Tipo de Intención ID', valorMinimo: 0);
    }

    public function setServicioId($servicio_id)
    {
        $this->servicio_id = Validador::validarEntero($servicio_id, 'Servicio ID', valorMinimo: 0);
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
        $this->constancia_de_bautizo_id = Validador::validarEntero($id, 'Constancia de Bautizo ID', valorMinimo: 0);
    }

    public function setConstanciaDeConfirmacionId($id)
    {
        $this->constancia_de_confirmacion_id = Validador::validarEntero($id, 'Constancia de Confirmación ID', valorMinimo: 0);
    }

    public function setConstanciaDeComunionId($id)
    {
        $this->constancia_de_comunion_id = Validador::validarEntero($id, 'Constancia de Comunión ID', valorMinimo: 0);
    }

    public function setConstanciaDeMatrimonioId($id)
    {
        $this->constancia_de_matrimonio_id = Validador::validarEntero($id, 'Constancia de Matrimonio ID', valorMinimo: 0);
    }

    public function toArrayParaBD($excluirId = false)
    {
        $datos = parent::toArrayParaBD($excluirId);
        unset($datos['creado_en']);
        unset($datos['actualizado_en']);
        return $datos;
    }
    public function toArrayParaMostrar($criterio = null)
    {
        $datos = parent::toArrayParaMostrar($criterio);
        $datos['creado_en'] = $this->getCreadoEn();
        $datos['actualizado_en'] = $this->getActualizadoEn();
        return $datos;
    }

}
