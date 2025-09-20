<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';
require_once 'Constancia.php';

class ConstanciaDeBautizo extends ModeloBase implements Constancia
{
    private $id;
    private $fecha_bautizo;
    private $feligres_bautizado_id;
    private $feligres_bautizado;
    private $padre_id;
    private $padre;
    private $madre_id;
    private $madre;
    private $padrino_nombre;
    private $madrina_nombre;
    private $observaciones;
    private $municipio;
    private $ministro_id;
    private $ministro;
    private $ministro_certifica_id;
    private $ministro_certifica;
    private $registro_civil;
    private $numero_libro;
    private $numero_pagina;
    private $numero_marginal;
    private $proposito;

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

    public function getPadrinoNombre()
    {
        return $this->padrino_nombre;
    }

    public function getMadrinaNombre()
    {
        return $this->madrina_nombre;
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

    public function setFeligresBautizado($feligres_bautizado)
    {
        $this->feligres_bautizado = $feligres_bautizado;
    }

    public function setPadreId($padre_id)
    {
        $this->padre_id = Validador::validarEntero($padre_id, "ID del padre", null, 1);
    }

    public function setPadre($padre)
    {
        $this->padre = $padre;
    }
    public function setMadreId($madre_id)
    {
        $this->madre_id = Validador::validarEntero($madre_id, "ID de la madre", null, 1);
    }
    public function setMadre($madre)
    {
        $this->madre = $madre;
    }
    public function setPadrinoNombre($padrino_nombre)
    {
        $this->padrino_nombre = Validador::validarString($padrino_nombre, "nombre de la padrino", 100, 3);
    }

    public function setMadrinaNombre($madrina_nombre)
    {
        $this->madrina_nombre = Validador::validarString($madrina_nombre, "nombre de la madrina", 100, 3);
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = Validador::validarString($observaciones, "observaciones", 1000);
    }
    public function setProposito($proposito)
    {
        $this->proposito = Validador::validarString($proposito, "proposito", 10, 5);
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

    public function setMinistro($ministro)
    {
        $this->ministro = $ministro;
    }
    public function setMinistroCertificaId($ministro_certifica_id)
    {
        $this->ministro_certifica_id = Validador::validarEntero($ministro_certifica_id, "ID del ministro que certifica", null, 1);
    }

    public function setMinistroCertifica($ministro_certifica)
    {
        $this->ministro_certifica = $ministro_certifica;
    }
    public function setRegistroCivil($registro_civil)
    {
        $this->registro_civil = Validador::validarString($registro_civil, "registro civil", 100);
        if ($this->registro_civil !== null) {
            $this->registro_civil = strtoupper($this->registro_civil);
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

    public function toArrayParaBD($excluirId = false)
    {
        $datos = parent::toArrayParaBD($excluirId);
        unset($datos['municipio']);
        error_log(print_r($datos));
        return $datos;
    }
    public function toArrayParaMostrar($criterio = null)
    {
        $datos = parent::toArrayParaMostrar();
        return $datos;
    }
    /*
${numero_libro}
${numero_pagina}
${numero_marginal}
${nombre_bautizado}
${padre}
${madre}
${dia_nacimiento}
${mes_nacimiento}
${ano_nacimiento}
${lugar_nacimiento}
${dia_bautizo}
${mes_bautizo}
${ano_bautizo}
${ministro}
${padrino_nombre}
${madrina_nombre}
${observaciones}
${proposito}
${dia_expedicion}
${dia_mes}
${ano_expedicion}
${ministro_certifica}
*/

    public function toArrayParaConstanciaPDF()
    {
        if (empty($this->feligres_bautizado) || empty($this->padre) || empty($this->madre) || empty($this->ministro) || empty($this->ministro_certifica)) {
            throw new InvalidArgumentException("Error: objeto feligres vacio"); // TODO expandir
        }

        $datos_bd = $this->toArrayParaBD();
        $datos_constancia = [];

        $datos_constancia['numero_libro'] = Validador::estaVacio($datos_bd['numero_libro'], 'Número de libro');
        $datos_constancia['numero_pagina'] = Validador::estaVacio($datos_bd['numero_pagina'], 'Número de página');
        $datos_constancia['numero_marginal'] = Validador::estaVacio($datos_bd['numero_marginal'], 'Número marginal');

        $datos_constancia['nombre_bautizado'] = Validador::estaVacio($this->feligres_bautizado->nombreCompleto(), 'Nombre del bautizado');
        $datos_constancia['padre'] = Validador::estaVacio($this->padre->nombreCompleto(), 'Nombre del padre');
        $datos_constancia['madre'] = Validador::estaVacio($this->madre->nombreCompleto(), 'Nombre de la madre');

        $fecha_nacimiento = new DateTime(Validador::estaVacio($datos_bd['fecha_nacimiento'], 'Fecha de nacimiento'));
        $datos_constancia['dia_nacimiento'] = $fecha_nacimiento->format('d');
        $datos_constancia['mes_nacimiento'] = $fecha_nacimiento->format('m');
        $datos_constancia['ano_nacimiento'] = $fecha_nacimiento->format('Y');

        $fecha_bautizo = new DateTime(Validador::estaVacio($datos_bd['fecha_bautizo'], 'Fecha de bautizo'));
        $datos_constancia['dia_bautizo'] = $fecha_bautizo->format('d');
        $datos_constancia['mes_bautizo'] = $fecha_bautizo->format('m');
        $datos_constancia['ano_bautizo'] = $fecha_bautizo->format('Y');

        $datos_constancia['lugar_nacimiento'] = Validador::estaVacio($this->feligres_bautizado->lugarDeNacimiento(), 'Lugar de nacimiento');
        $datos_constancia['ministro'] = Validador::estaVacio($this->ministro->getNombre(), 'Ministro');
        $datos_constancia['padrino_nombre'] = Validador::estaVacio($datos_bd['padrino_nombre'], 'Nombre del padrino');
        $datos_constancia['madrina_nombre'] = Validador::estaVacio($datos_bd['madrina_nombre'], 'Nombre del madrina');
        $datos_constancia['observaciones'] = $datos_bd['observaciones'] ?: 'No hay nota marginal.';

        // Datos de expedición
        $datos_constancia['proposito'] = ''; // O el valor que corresponda
        $datos_constancia['dia_expedicion'] = ''; // Llenar con la fecha actual o del registro
        $datos_constancia['mes_expedicion'] = '';
        $datos_constancia['ano_expedicion'] = '';
        $datos_constancia['ministro_certifica'] = Validador::estaVacio($this->ministro_certifica->getNombre(), 'Ministro que certifica');

        return $datos_constancia;
    }

}
