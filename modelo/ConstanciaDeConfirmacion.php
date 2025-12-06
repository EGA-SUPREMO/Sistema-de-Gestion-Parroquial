<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class ConstanciaDeConfirmacion extends ModeloBase
{
    private $id;
    private $fecha_confirmacion;
    private $fecha_expedicion;
    private $padre_1_id;
    private $padre_1;
    private $feligres_confirmado_id;
    private $feligres_confirmado;
    private $padre_2_id;
    private $padre_2;
    private $padrino_nombre;
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

    public function getFechaConfirmacion()
    {
        return $this->fecha_confirmacion;
    }

    public function getPadre1Id()
    {
        return $this->padre_1_id;
    }

    public function getFeligresConfirmadoId()
    {
        return $this->feligres_confirmado_id;
    }

    public function getPadre2Id()
    {
        return $this->padre_2_id;
    }
    public function getPadrinoNombre()
    {
        return $this->padrino_nombre;
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

    public function setFechaConfirmacion($fecha_confirmacion)
    {
        $fecha_actual = (new DateTime())->format('Y-m-d');
        $this->fecha_confirmacion = Validador::validarFecha($fecha_confirmacion, "fecha de confirmacion", "1900-01-01", $fecha_actual);
    }
    public function setFechaExpedicion($fecha_expedicion)
    {
        $this->fecha_expedicion = Validador::validarFecha($fecha_expedicion, "fecha de expedicion", "1900-01-01");
    }

    public function setFeligresConfirmadoId($feligres_confirmado_id)
    {
        $this->feligres_confirmado_id = Validador::validarEntero($feligres_confirmado_id, "ID del feligres confirmado", null, 0);
    }

    public function setFeligresConfirmado($feligres_confirmado)
    {
        $this->feligres_confirmado = $feligres_confirmado;
    }
    public function setPadre1Id($padre_1_id)
    {
        $this->padre_1_id = Validador::validarEntero($padre_1_id, "ID del padre 1", null, 0);
    }
    public function setPadre1($padre_1)
    {
        $this->padre_1 = $padre_1;
    }
    public function setPadre2Id($padre_2_id)
    {
        $this->padre_2_id = Validador::validarEntero($padre_2_id, "ID de la padre 2", null, 0);
    }
    public function setPadre2($padre_2)
    {
        $this->padre_2 = $padre_2;
    }

    public function setPadrinoNombre($padrino_nombre)
    {
        $this->padrino_nombre = Validador::validarString($padrino_nombre, "nombre del padrino", 100, 3);
        if ($this->padrino_nombre !== null) {
            $this->padrino_nombre = ucwords($this->padrino_nombre);
        }
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
        if (empty($this->padre_1)) {
            throw new InvalidArgumentException("Error: 'padre_1' está vacío");
        }
        if (empty($this->padre_2)) {
            throw new InvalidArgumentException("Error: 'padre_2' está vacío");
        }
        if (empty($this->ministro)) {
            throw new InvalidArgumentException("Error: 'ministro' está vacío");
        }
        if (empty($this->ministro_certifica_expedicion)) {
            throw new InvalidArgumentException("Error: 'el ministro que certifica' está vacío");
        }

        $formateador = new IntlDateFormatter(
            'es_VE',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Caracas'
        );

        $datos_bd = $this->toArrayParaBD();
        $datos_constancia = [];

        $datos_constancia['numero_libro'] = Validador::estaVacio($datos_bd['numero_libro'], 'Número de libro');
        $datos_constancia['numero_pagina'] = Validador::estaVacio($datos_bd['numero_pagina'], 'Número de página');
        $datos_constancia['numero_marginal'] = Validador::estaVacio($datos_bd['numero_marginal'], 'Número marginal');

        $datos_constancia['feligres_confirmado'] = Validador::estaVacio($this->feligres_confirmado->nombreCompleto(), 'Nombre del Feligres Confirmado');
        $datos_constancia['edad_feligres'] = Validador::estaVacio($this->feligres_confirmado->edad(), 'Edad del Feligres Confirmado');

        $datos_constancia['padre_1'] = Validador::estaVacio($this->padre_1->nombreCompleto(), 'Nombre del padre_1');
        $datos_constancia['padre_2'] = Validador::estaVacio($this->padre_2->nombreCompleto(), 'Nombre del padre_2');

        $datos_constancia['padrino_nombre'] = Validador::estaVacio($datos_bd['padrino_nombre'], 'Nombre del testigo 1');

        $fecha_confirmacion = new DateTime(Validador::estaVacio($datos_bd['fecha_confirmacion'], 'Fecha de confirmacion'));
        $datos_constancia['fecha_confirmacion'] = ucwords($formateador->format($fecha_confirmacion));

        $datos_constancia['ministro'] = Validador::estaVacio($this->ministro->getNombre(), 'Ministro');

        $fecha_expedicion = new DateTime(Validador::estaVacio($this->fecha_expedicion, 'Fecha de expedicion'));
        $datos_constancia['fecha_expedicion'] = ucwords($formateador->format($fecha_expedicion));
        $datos_constancia['ministro_certifica'] = Validador::estaVacio($this->ministro_certifica_expedicion->getNombre(), 'Ministro que certifica');

        return $datos_constancia;
    }

}
