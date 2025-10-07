<?php

require_once 'Feligres.php';
//require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'ConstanciaDeBautizo.php';

require_once 'GestorConstanciaDeBautizo.php';
require_once 'GestorPeticion.php';
require_once 'GestorSacerdote.php';
require_once 'GestorFeligres.php';


class ServicioConstanciaDeBautizo
{
    private $pdo;
    private $gestorPeticion;
    private $gestorFeligres;
    private $gestorSacerdote;
    private $gestorConstanciaDeBautizo;

    private static $plantilla_nombre;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        //$this->gestorPeticion = new GestorPeticion($pdo);
        $this->gestorConstanciaDeBautizo = new GestorConstanciaDeBautizo($pdo);
        $this->gestorFeligres = new GestorFeligres($pdo);
        $this->gestorSacerdote = new gestorSacerdote($pdo);

        self::$plantilla_nombre = "fe de bautizo.docx";
    }

    public function guardarConstancia($datosFormulario)
    {
        $this->pdo->beginTransaction();
        try {
            $datosConstancia = $datosFormulario;

            $datosDelFeligres = self::mapearParaEntidad($datosFormulario, 'feligres');
            $datosDelPadre = self::mapearParaEntidad($datosFormulario, 'padre');
            $datosDeLaMadre = self::mapearParaEntidad($datosFormulario, 'madre');

            $feligresId = $this->upsertFeligresId($datosDelFeligres);
            $feligresPadreId = $this->upsertFeligresId($datosDelPadre);
            $feligresMadreId = $this->upsertFeligresId($datosDeLaMadre);

            $constancia = new ConstanciaDeBautizo();
            $datosConstancia['feligres_bautizado_id'] = $feligresId;
            $datosConstancia['padre_id'] = $feligresMadreId;
            $datosConstancia['madre_id'] = $feligresPadreId;
            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorFeligres = $this->gestorConstanciaDeBautizo->obtenerConstanciaIdPorFeligresBautizadoId($feligresId);
            $this->gestorConstanciaDeBautizo->verificarConsistenciaIds($feligresId, $datosConstancia['numero_libro'], $datosConstancia['numero_pagina'], $datosConstancia['numero_marginal']);

            $idConstanciaGuardada = $this->gestorConstanciaDeBautizo->guardar($constancia, $idConstanciaEncontradaPorFeligres);
            /*
                        $peticion->setConstanciaDeBautizoId($constanciaId);

                        $peticionGuardadaId = $this->gestorPeticion->guardar($peticion);

                        // TODO LO MISMO PARA LOS PARENTESCOS
            */
            $rutaPDF = $this->generarPDF($constancia);
            if (!$rutaPDF) {
                throw Exception("Error generando la constancia");
            }
            $this->pdo->commit();

            return $rutaPDF;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro o generacion de constancia: " . $e->getMessage());
            throw Exception($e->getMessage());
        }
        return false;
    }

    private function upsertFeligresId($datosFeligres)
    {
        $feligres = $this->gestorFeligres->obtenerPorCedula($datosFeligres['cedula']);
        $id = 0;
        if ($feligres) {
            $feligres->hydrate($datosFeligres);
            $id = $feligres->getId();
            $this->gestorFeligres->guardar($feligres, $id);
        } else {
            $feligres = new Feligres();
            $feligres->hydrate($datosFeligres);
            $id = $this->gestorFeligres->guardar($feligres);
        }

        if (!$id) {
            throw new Exception("Error al persistir el feligrés con cédula: " . $datosFeligres['cedula']);
        }

        return $id;
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
    public static function mapearParaFormulario($datosEntidad)
    {
        $datosFormulario = [];
        $claves = [
            'cedula', 
            'partida_de_nacimiento', 
            'primer_nombre', 
            'segundo_nombre', 
            'primer_apellido', 
            'segundo_apellido', 
            'fecha_nacimiento', 
            'municipio', 
            'estado', 
            'pais',
        ];

        foreach ($claves as $clave) {
            $datosFormulario[$clave] = $datosEntidad[$clave] ?? null;
        }

        return $datosFormulario;
    }

    protected function generarPDF($constancia)
    {
        $constancia->setFeligresBautizado($this->gestorFeligres->obtenerPorId($constancia->getFeligresBautizadoId()));
        $constancia->setPadre($this->gestorFeligres->obtenerPorId($constancia->getPadreId()));
        $constancia->setMadre($this->gestorFeligres->obtenerPorId($constancia->getMadreId()));
        $constancia->setMinistro($this->gestorSacerdote->obtenerPorId($constancia->getMinistroId()));
        $constancia->setMinistroCertificaExpedicion($this->gestorSacerdote->obtenerPorId($constancia->getMinistroCertificaExpedicionId()));

        $datos = $constancia->toArrayParaConstanciaPDF();
        return GeneradorPdf::guardarPDF(self::$plantilla_nombre, $datos);
    }


    protected function validarDependencias($objeto)
    {
        if (!$this->gestorFeligres->obtenerPorId($objeto->getFeligresBautizadoId())) {
            throw new InvalidArgumentException("Error: El feligrés ${$objeto->getFeligresBautizadoId()} bautizado no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getPadreId())) {
            throw new InvalidArgumentException("Error: El padre ${$objeto->getPadreId()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getMadreId())) {
            throw new InvalidArgumentException("Error: La madre ${$objeto->getMadreId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro ${$objeto->getMinistroId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaId())) {
            throw new InvalidArgumentException("Error: El ministro ${$objeto->getMinistroCertificaId()} que certifica no existe.");
        }
    }
    public function getClavePrimaria()
    {
        return "id";
    }
}
