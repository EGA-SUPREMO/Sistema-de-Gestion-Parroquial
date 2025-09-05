<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class ConstanciaBautizo extends ModeloBase
{
    private $id;
    private $fecha_bautizo;
    private $feligres_bautizado_id;
    private $padre_id;
    private $madre_id;
    private $padrino_id;
    private $madrina_id;
    private $observaciones;
    private $municipio;
    private $ministro_id;
    private $ministro_certifica_id;
    private $registro_civil;
    private $numero_libro;
    private $numero_pagina;
    private $numero_marginal;

    public function getId()
    {
        return $this->id;
    }

    public function getFechaBautizo()
    {
        return $this->fecha_bautizo;
    }

    public function getFeligresBautizadoId()
    {
        return $this->feligres_bautizado_id;
    }

    public function getPadreId()
    {
        return $this->padre_id;
    }

    public function getMadreId()
    {
        return $this->madre_id;
    }

    public function getPadrinoId()
    {
        return $this->padrino_id;
    }

    public function getMadrinaId()
    {
        return $this->madrina_id;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function getMunicipio()
    {
        return $this->municipio;
    }

    public function getMinistroId()
    {
        return $this->ministro_id;
    }

    public function getMinistroCertificaId()
    {
        return $this->ministro_certifica_id;
    }

    public function getRegistroCivil()
    {
        return $this->registro_civil;
    }

    public function getNumeroLibro()
    {
        return $this->numero_libro;
    }

    public function getNumeroPagina()
    {
        return $this->numero_pagina;
    }

    public function getNumeroMarginal()
    {
        return $this->numero_marginal;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "ID de la constancia", null, 1);
    }

    public function setFechaBautizo($fecha_bautizo)
    {
        $fecha_actual = (new DateTime())->format('Y-m-d');
        $this->fecha_bautizo = Validador::validarFecha($fecha_bautizo, "fecha de bautizo", "1900-01-01", $fecha_actual);
    }

    public function setFeligresBautizadoId($feligres_bautizado_id)
    {
        $this->feligres_bautizado_id = Validador::validarEntero($feligres_bautizado_id, "ID del feligrés bautizado", null, 1);
    }

    public function setPadreId($padre_id)
    {
        $this->padre_id = Validador::validarEntero($padre_id, "ID del padre", null, 1);
    }

    public function setMadreId($madre_id)
    {
        $this->madre_id = Validador::validarEntero($madre_id, "ID de la madre", null, 1);
    }

    public function setPadrinoId($padrino_id)
    {
        $this->padrino_id = Validador::validarEntero($padrino_id, "ID del padrino", null, 1);
    }

    public function setMadrinaId($madrina_id)
    {
        $this->madrina_id = Validador::validarEntero($madrina_id, "ID de la madrina", null, 1);
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = Validador::validarString($observaciones, "observaciones", 1000);
    }

    public function setMunicipio($municipio)
    {
        $this->municipio = Validador::validarString($municipio, "municipio", 100, 6);
        if ($this->municipio !== null) {
            $this->municipio = ucwords(strtolower($this->municipio));
        }
    }

    public function setMinistroId($ministro_id)
    {
        $this->ministro_id = Validador::validarEntero($ministro_id, "ID del ministro", null, 1);
    }

    public function setMinistroCertificaId($ministro_certifica_id)
    {
        $this->ministro_certifica_id = Validador::validarEntero($ministro_certifica_id, "ID del ministro que certifica", null, 1);
    }

    public function setRegistroCivil($registro_civil)
    {
        $this->registro_civil = Validador::validarString($registro_civil, "registro civil", 100);
        if ($this->registro_civil !== null) {
            $this->registro_civil = strtolower($this->registro_civil);
        }
    }

    public function setNumeroLibro($numero_libro)
    {
        $this->numero_libro = Validador::validarEntero($numero_libro, "número de libro", null, 1);
    }

    public function setNumeroPagina($numero_pagina)
    {
        $this->numero_pagina = Validador::validarEntero($numero_pagina, "número de página", null, 1);
    }

    public function setNumeroMarginal($numero_marginal)
    {
        $this->numero_marginal = Validador::validarEntero($numero_marginal, "número marginal", null, 1);
    }
}
