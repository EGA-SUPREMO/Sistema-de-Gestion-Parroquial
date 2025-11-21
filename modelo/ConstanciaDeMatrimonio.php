<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class ConstanciaDeMatrimonio extends ModeloBase
{
    private $id;
    private $fecha_matrimonio;
    private $fecha_expedicion;
    private $contrayente_1_id;
    private $contrayente_1;
    private $contrayente_2_id;
    private $contrayente_2;
    private $testigo_1_id;
    private $testigo_1;
    private $testigo_2_id;
    private $testigo_2;
    private $ministro_id;
    private $ministro;
    private $ministro_certifica_expedicion_id;
    private $ministro_certifica_expedicion;
    private $numero_libro;
    private $numero_pagina;
    private $numero_marginal;

    public function getId()
    {
        return $this->id;
    }

    public function getFechaMatrimonio()
    {
        return $this->fecha_matrimonio;
    }

    public function getContrayente1Id()
    {
        return $this->contrayente_1_id;
    }

    public function getContrayente2Id()
    {
        return $this->contrayente_2_id;
    }
    public function getTestigo1Id()
    {
        return $this->testigo_1_id;
    }

    public function getTestigo2Id()
    {
        return $this->testigo_2_id;
    }

    public function getMinistroId()
    {
        return $this->ministro_id;
    }

    public function getMinistroCertificaExpedicionId()
    {
        return $this->ministro_certifica_expedicion_id;
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

    public function obtenerFechaExpedicion()
    {
        return $this->fecha_expedicion;
    }


    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "ID de la constancia", null, 0);
    }

    public function setFechaMatrimonio($fecha_matrimonio)
    {
        $fecha_actual = (new DateTime())->format('Y-m-d');
        $this->fecha_matrimonio = Validador::validarFecha($fecha_matrimonio, "fecha de matrimonio", "1900-01-01", $fecha_actual);
    }
    public function setFechaExpedicion($fecha_expedicion)
    {
        $this->fecha_expedicion = Validador::validarFecha($fecha_expedicion, "fecha de expedicion", "1900-01-01");
    }

    public function setContrayente1Id($contrayente_1_id)
    {
        $this->contrayente_1_id = Validador::validarEntero($contrayente_1_id, "ID del contrayente 1", null, 0);
    }

    public function setContrayente1($contrayente_1)
    {
        $this->contrayente_1 = $contrayente_1;
    }
    public function setContrayente2Id($contrayente_2_id)
    {
        $this->contrayente_2_id = Validador::validarEntero($contrayente_2_id, "ID de la contrayente 2", null, 0);
    }
    public function setContrayente2($contrayente_2)
    {
        $this->contrayente_2 = $contrayente_2;
    }

    public function setTestigo1Id($testigo_1_id)
    {
        $this->testigo_1_id = Validador::validarEntero($testigo_1_id, "ID del testigo 1", null, 0);
    }

    public function setTestigo1($testigo_1)
    {
        $this->testigo_1 = $testigo_1;
    }
    public function setTestigo2Id($testigo_2_id)
    {
        $this->testigo_2_id = Validador::validarEntero($testigo_2_id, "ID del testigo 2", null, 0);
    }
    public function setTestigo2($testigo_2)
    {
        $this->testigo_2 = $testigo_2;
    }

    public function setMinistroId($ministro_id)
    {
        $this->ministro_id = Validador::validarEntero($ministro_id, "ID del ministro", null, 0);
    }

    public function setMinistro($ministro)
    {
        $this->ministro = $ministro;
    }

    public function setMinistroCertificaExpedicionId($ministro_certifica_expedicion_id)
    {
        $this->ministro_certifica_expedicion_id = Validador::validarEntero($ministro_certifica_expedicion_id, "ID del ministro que certifica", null, 0);
    }

    public function setMinistroCertificaExpedicion($ministro_certifica_expedicion)
    {
        $this->ministro_certifica_expedicion = $ministro_certifica_expedicion;
    }

    public function setNumeroLibro($numero_libro)
    {
        $this->numero_libro = Validador::validarEntero($numero_libro, "número de libro", 1000, 0);
    }

    public function setNumeroPagina($numero_pagina)
    {
        $this->numero_pagina = Validador::validarEntero($numero_pagina, "número de página", 1000, 0);
    }

    public function setNumeroMarginal($numero_marginal)
    {
        $this->numero_marginal = Validador::validarEntero($numero_marginal, "número marginal", 1000, 0);
    }

    public function toArrayParaBD($excluirId = false)
    {
        $datos = parent::toArrayParaBD($excluirId);
        unset($datos['ministro_certifica_expedicion_id']);
        return $datos;
    }

    public function toArrayParaConstanciaPDF()
    {
        if (empty($this->contrayente_1)) {
            throw new InvalidArgumentException("Error: 'contrayente_1' está vacío");
        }
        if (empty($this->contrayente_2)) {
            throw new InvalidArgumentException("Error: 'contrayente_2' está vacío");
        }
        if (empty($this->testigo_1)) {
            throw new InvalidArgumentException("Error: 'testigo_1' está vacío");
        }
        if (empty($this->testigo_2)) {
            throw new InvalidArgumentException("Error: 'testigo_2' está vacío");
        }
        if (empty($this->ministro)) {
            throw new InvalidArgumentException("Error: 'ministro' está vacío");
        }
        if (empty($this->ministro_certifica_expedicion)) {
            throw new InvalidArgumentException("Error: 'el ministro que certifica' está vacío");
        }

        $formateador = new IntlDateFormatter('es', IntlDateFormatter::NONE, IntlDateFormatter::NONE, 'America/Caracas', IntlDateFormatter::GREGORIAN, 'MMMM');

        $datos_bd = $this->toArrayParaBD();
        $datos_constancia = [];

        $datos_constancia['numero_libro'] = Validador::estaVacio($datos_bd['numero_libro'], 'Número de libro');
        $datos_constancia['numero_pagina'] = Validador::estaVacio($datos_bd['numero_pagina'], 'Número de página');
        $datos_constancia['numero_marginal'] = Validador::estaVacio($datos_bd['numero_marginal'], 'Número marginal');

        $datos_constancia['contrayente_1'] = Validador::estaVacio($this->contrayente_1->nombreCompleto(), 'Nombre del contrayente_1');
        $datos_constancia['contrayente_2'] = Validador::estaVacio($this->contrayente_2->nombreCompleto(), 'Nombre del contrayente_2');

        $fecha_matrimonio = new DateTime(Validador::estaVacio($datos_bd['fecha_matrimonio'], 'Fecha de matrimonio'));
        $datos_constancia['dia_matrimonio'] = $fecha_matrimonio->format('d');
        $datos_constancia['mes_matrimonio'] = ucwords($formateador->format($fecha_matrimonio));
        $datos_constancia['ano_matrimonio'] = $fecha_matrimonio->format('Y');

        $datos_constancia['ciudad_contrayente_1'] = Validador::estaVacio($this->contrayente_1->getLocalidad(), 'Lugar de nacimiento (Ciudad)');
        $datos_constancia['ciudad_contrayente_2'] = Validador::estaVacio($this->contrayente_2->getLocalidad(), 'Lugar de nacimiento (Ciudad)');
        $datos_constancia['ministro'] = Validador::estaVacio($this->ministro->getNombre(), 'Ministro');

        $fecha_expedicion = new DateTime(Validador::estaVacio($this->fecha_expedicion, 'Fecha de expedicion'));
        $datos_constancia['dia_expedicion'] = $fecha_expedicion->format('d');
        $datos_constancia['mes_expedicion'] = ucwords($formateador->format($fecha_expedicion));
        $datos_constancia['ano_expedicion'] = $fecha_expedicion->format('Y');
        $datos_constancia['ministro_certifica'] = Validador::estaVacio($this->ministro_certifica_expedicion->getNombre(), 'Ministro que certifica');

        return $datos_constancia;
    }

}
