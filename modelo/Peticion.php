<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class Peticion extends ModeloBase
{
    protected $id;
    protected $objeto_de_peticion_id;
    protected $realizado_por_id;
    protected $tipo_de_intencion_id;
    protected $servicio_id;
    protected $creado_en;
    protected $actualizado_en;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $constancia_de_bautizo_id;
    protected $constancia_de_confirmacion_id;
    protected $constancia_de_comunion_id;
    protected $constancia_de_matrimonio_id;

    public function getId()
    {
        return $this->id;
    }

    public function getObjetoDePeticionId()
    {
        return $this->objeto_de_peticion_id;
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

    public function setObjetoDePeticionId($objeto_de_peticion_id)
    {
        $this->objeto_de_peticion_id = Validador::validarEntero($objeto_de_peticion_id, 'Objeto de Peticion ID', valorMinimo: 0);
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
