<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class ConstanciaDeComunion extends ModeloBase
{
    private $id;
    private $feligres_id;
    private $feligres;
    private $fecha_comunion;
    private $fecha_expedicion;
    private $ministro_certifica_expedicion_id;
    private $ministro_certifica_expedicion;

    public function getId()
    {
        return $this->id;
    }

    public function getFechaComunion()
    {
        return $this->fecha_comunion;
    }

    public function getFeligresId()
    {
        return $this->feligres_id;
    }

    public function getMinistroCertificaExpedicionId()
    {
        return $this->ministro_certifica_expedicion_id;
    }

    public function obtenerFechaExpedicion()
    {
        return $this->fecha_expedicion;
    }


    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "ID de la constancia", null, 0);
    }

    public function setFechaComunion($fecha_comunion)
    {
        $fecha_actual = (new DateTime())->format('Y-m-d');
        $this->fecha_comunion = Validador::validarFecha($fecha_comunion, "fecha de comunion", "1900-01-01", $fecha_actual);
    }
    public function setFechaExpedicion($fecha_expedicion)
    {
        $this->fecha_expedicion = Validador::validarFecha($fecha_expedicion, "fecha de expedicion", "1900-01-01");
    }

    public function setFeligresId($feligres_id)
    {
        $this->feligres_id = Validador::validarEntero($feligres_id, "ID del feligrés ", null, 0);
    }

    public function setFeligres($feligres)
    {
        $this->feligres = $feligres;
    }

    public function setMinistroCertificaExpedicionId($ministro_certifica_expedicion_id)
    {
        $this->ministro_certifica_expedicion_id = Validador::validarEntero($ministro_certifica_expedicion_id, "ID del ministro que certifica", null, 0);
    }

    public function setMinistroCertificaExpedicion($ministro_certifica_expedicion)
    {
        $this->ministro_certifica_expedicion = $ministro_certifica_expedicion;
    }

    public function toArrayParaBD($excluirId = false)
    {
        $datos = parent::toArrayParaBD($excluirId);
        unset($datos['ministro_certifica_expedicion_id']);
        return $datos;
    }

    public function toArrayParaConstanciaPDF()
    {
        if (empty($this->feligres)) {
            throw new InvalidArgumentException("Error: 'el feligres' está vacío");
        }
        if (empty($this->ministro_certifica_expedicion)) {
            throw new InvalidArgumentException("Error: 'el ministro que certifica' está vacío");
        }

        $formateador = new IntlDateFormatter('es', IntlDateFormatter::NONE, IntlDateFormatter::NONE, 'America/Caracas', IntlDateFormatter::GREGORIAN, 'MMMM');

        $datos_bd = $this->toArrayParaBD();
        $datos_constancia = [];

        $datos_constancia['feligres_nombre_completo'] = strtoupper(Validador::estaVacio($this->feligres->nombreCompleto(), 'Nombre del feligres'));
        if ($this->feligres->getCedula()) {
            $datos_constancia['feligres_cedula_texto'] = ", titular de la Cédula de Identidad N.º " . Validador::estaVacio($this->feligres->getCedula(), 'Cedula del feligres');
        } elseif ($this->feligres->getPartidaDeNacimiento()) {
            $datos_constancia['feligres_cedula_texto'] = "";
        } else {
            throw new InvalidArgumentException("Error: 'partida de nacimiento' y 'cedula' estan vacíos");
        }

        $fecha_comunion = new DateTime(Validador::estaVacio($datos_bd['fecha_comunion'], 'Fecha de Comunion'));
        $datos_constancia['dia'] = $fecha_comunion->format('d');
        $datos_constancia['mes'] = ucwords($formateador->format($fecha_comunion));
        $datos_constancia['ano'] = $fecha_comunion->format('Y');

        $fecha_expedicion = new DateTime(Validador::estaVacio($this->fecha_expedicion, 'Fecha de expedicion'));
        $datos_constancia['dia_expedicion'] = $fecha_expedicion->format('d');
        $datos_constancia['mes_expedicion'] = ucwords($formateador->format($fecha_expedicion));
        $datos_constancia['ano_expedicion'] = $fecha_expedicion->format('Y');
        $datos_constancia['ministro_certifica'] = Validador::estaVacio($this->ministro_certifica_expedicion->getNombre(), 'Ministro que certifica');

        return $datos_constancia;
    }

}
