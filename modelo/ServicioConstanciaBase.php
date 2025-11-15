<?php

require_once 'ServicioBase.php';
require_once 'Feligres.php';
require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'Parentesco.php';
require_once 'ConstanciaDeBautizo.php';

require_once 'GestorConstanciaDeBautizo.php';
require_once 'GestorPeticion.php';
require_once 'GestorParentesco.php';
require_once 'GestorSacerdote.php';
require_once 'GestorFeligres.php';
require_once 'GestorAdministrador.php';


class ServicioConstanciaBase extends ServicioBase
{
    protected $gestorPeticion;
    protected $gestorAdministrador;
    protected $gestorFeligres;
    protected $gestorSacerdote;
    protected $gestorConstancia;

    protected static $plantilla_nombre;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->gestorPeticion = new GestorPeticion($pdo);
        $this->gestorAdministrador = new GestorAdministrador($pdo);
        $this->gestorFeligres = new GestorFeligres($pdo);
        $this->gestorParentesco = new gestorParentesco($pdo);
        $this->gestorSacerdote = new gestorSacerdote($pdo);
    }

    public function guardarConstancia($datosFormulario)
    {
        $this->pdo->beginTransaction();
        try {
            $datosConstancia = self::limpiarClavesParaDatosConstancia($datosFormulario);

            $datosDelFeligres = self::mapearParaEntidad($datosFormulario, 'feligres');
            $datosDelPadre = self::mapearParaEntidad($datosFormulario, 'padre');
            $datosDeLaMadre = self::mapearParaEntidad($datosFormulario, 'madre');

            $feligresId = $this->gestorFeligres->upsertFeligresPorArray($datosDelFeligres);
            $feligresPadreId = $this->gestorFeligres->upsertFeligresPorArray($datosDelPadre);
            $feligresMadreId = $this->gestorFeligres->upsertFeligresPorArray($datosDeLaMadre);

            $constancia = new ConstanciaDeBautizo();
            $datosConstancia['feligres_bautizado_id'] = $feligresId;
            $datosConstancia['padre_id'] = $feligresPadreId;
            $datosConstancia['madre_id'] = $feligresMadreId;

            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorFeligres = $this->gestorConstanciaDeBautizo->obtenerConstanciaIdPorFeligresBautizadoId($feligresId);
            $this->gestorConstanciaDeBautizo->verificarConsistenciaIds($feligresId, $datosConstancia['numero_libro'], $datosConstancia['numero_pagina'], $datosConstancia['numero_marginal']);

            $idConstanciaGuardada = $this->gestorConstanciaDeBautizo->guardar($constancia, $idConstanciaEncontradaPorFeligres);

            $this->guardarPeticion($constancia, $idConstanciaGuardada);

            $parentescoPadre = new Parentesco();
            $parentescoPadre->setIdPadre($feligresPadreId);
            $parentescoPadre->setIdHijo($feligresId);

            $parentescoMadre = new Parentesco();
            $parentescoMadre->setIdPadre($feligresMadreId);
            $parentescoMadre->setIdHijo($feligresId);

            $this->gestorParentesco->verificarParadojaDeParentesco($parentescoPadre, [$parentescoMadre]);
            if (!$this->gestorParentesco->existeParentescoDirecto($parentescoPadre)) {
                $this->gestorParentesco->guardar($parentescoPadre);
            }
            $this->gestorParentesco->verificarParadojaDeParentesco($parentescoMadre, [$parentescoPadre]);
            if (!$this->gestorParentesco->existeParentescoDirecto($parentescoMadre)) {
                $this->gestorParentesco->guardar($parentescoMadre);
            }

            $rutaPDF = $this->generarPDF($constancia);
            if (!$rutaPDF) {
                throw Exception("Error generando la constancia");
            }
            $this->pdo->commit();

            return $rutaPDF;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro o generacion de constancia: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return false;
    }

    protected function guardarPeticion($constancia, $servicioId)// TODO falta terminar
    {

        $peticionEncontrada = $this->gestorPeticion->obtenerPorIdDeConstancia($constanciaColumna, $constancia->getId());
        if ($peticionEncontrada) {
            return;
        }

        $peticion = new Peticion();
        $adminActual = $this->gestorAdministrador->obtenerPorNombreUsuario($_SESSION['nombre_usuario']);
        $peticion->setRealizadoPorId($adminActual->getId());
        $peticion->setServicioId($servicioId);
        $peticion->setFechaInicio($constancia->obtenerFechaExpedicion());
        $peticion->setFechaFin($constancia->obtenerFechaExpedicion());
        $peticion->setConstanciaDeBautizoId($constancia->getId());
        $peticionGuardadaId = $this->gestorPeticion->guardar($peticion);
    }


    public static function limpiarClavesParaDatosConstancia($datosConstancia)
    {
        $datosLimpios = [];
        $prefijo = 'constancia-';
        $longitudPrefijo = strlen($prefijo);

        foreach ($datosConstancia as $clave => $valor) {
            if (strpos($clave, $prefijo) === 0) {
                $nuevaClave = substr($clave, $longitudPrefijo);
                $datosLimpios[$nuevaClave] = $valor;
            } else {
                $datosLimpios[$clave] = $valor;
            }
        }

        return $datosLimpios;
    }
    public static function mapearParaEntidad($datosFormulario, $prefijo)
    {
        return [
            'cedula'            => $datosFormulario[$prefijo . '-cedula']            ?? '',
            'partida_de_nacimiento' => $datosFormulario[$prefijo . '-partida_de_nacimiento']    ?? '',
            'primer_nombre'     => $datosFormulario[$prefijo . '-primer_nombre'],
            'segundo_nombre'    => $datosFormulario[$prefijo . '-segundo_nombre']    ?? '',
            'primer_apellido'   => $datosFormulario[$prefijo . '-primer_apellido'],
            'segundo_apellido'  => $datosFormulario[$prefijo . '-segundo_apellido']  ?? '',
            'fecha_nacimiento'  => $datosFormulario[$prefijo . '-fecha_nacimiento']  ?? '',
            'municipio'         => $datosFormulario[$prefijo . '-municipio']         ?? null,
            'estado'            => $datosFormulario[$prefijo . '-estado']            ?? null,
            'pais'              => $datosFormulario[$prefijo . '-pais']              ?? null,
        ];
    }

    protected function generarPDF($constancia)
    {
        return GeneradorPdf::guardarPDF(self::$plantilla_nombre, $constancia->toArrayParaConstanciaPDF());
    }


    protected abstract function validarDependencias($objeto);
}
