<?php

require_once 'ServicioConstanciaBase.php';
require_once 'Feligres.php';
require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'Parentesco.php';
require_once 'ConstanciaDeConfirmacion.php';

require_once 'GestorConstanciaDeConfirmacion.php';
require_once 'GestorPeticion.php';
require_once 'GestorParentesco.php';
require_once 'GestorSacerdote.php';
require_once 'GestorFeligres.php';
require_once 'GestorAdministrador.php';

class ServicioConstanciaDeConfirmacion extends ServicioConstanciaBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->servicioIdParaEstaConstancia = 4;
        $this->gestorConstancia = new GestorConstanciaDeConfirmacion($pdo);
        self::$plantilla_nombre = "confirmacion.docx";
    }

    public function guardarConstancia($datosFormulario)
    {
        return $this->ejecutarEnTransaccion(function () use ($datosFormulario) {
            $datosConstancia = self::limpiarClavesParaDatosConstancia($datosFormulario);

            $datosDeConfirmado = self::mapearParaEntidad($datosFormulario, 'feligres');
            $datosDePadre1 = self::mapearParaEntidad($datosFormulario, 'padre_1');
            $datosDePadre2 = self::mapearParaEntidad($datosFormulario, 'padre_2');

            $confirmadoId = $this->gestorFeligres->upsertFeligresPorArray($datosDeConfirmado);
            $padre1Id = $this->gestorFeligres->upsertFeligresPorArray($datosDePadre1);
            $padre2Id = $this->gestorFeligres->upsertFeligresPorArray($datosDePadre2);

            $constancia = new ConstanciaDeConfirmacion();
            $datosConstancia['feligres_confirmado_id'] = $confirmadoId;
            $datosConstancia['padre_1_id'] = $padre1Id;
            $datosConstancia['padre_2_id'] = $padre2Id;

            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorSujeto = $this->gestorConstancia->obtenerConstanciaIdPorSujetoSacramentoId($confirmadoId);
            $this->gestorConstancia->verificarConsistenciaIds($confirmadoId, $datosConstancia['numero_libro'], $datosConstancia['numero_pagina'], $datosConstancia['numero_marginal']);
            $constancia->setId($idConstanciaEncontradaPorSujeto);

            $this->gestorConstancia->guardar($constancia, $idConstanciaEncontradaPorSujeto);
            $this->guardarPeticion($constancia, $this->servicioIdParaEstaConstancia);

            $constancia->setFeligresConfirmado($this->gestorFeligres->obtenerPorId($constancia->getFeligresConfirmadoId()));
            $constancia->setPadre1($this->gestorFeligres->obtenerPorId($constancia->getPadre1Id()));
            $constancia->setPadre2($this->gestorFeligres->obtenerPorId($constancia->getPadre2Id()));
            $constancia->setMinistro($this->gestorSacerdote->obtenerPorId($constancia->getMinistroId()));
            $constancia->setMinistroCertificaExpedicion($this->gestorSacerdote->obtenerPorId($constancia->getMinistroCertificaExpedicionId()));

            $rutaPDF = $this->generarPDF($constancia);
            if (!$rutaPDF) {
                throw Exception("Error generando la constancia");
            }

            return $rutaPDF;
        }, "de registro o generacion de constancia");
    }

    protected function validarDependencias($objeto)
    {

        if (!$this->gestorFeligres->obtenerPorId($objeto->getFeligresConfirmadoId())) {
            throw new InvalidArgumentException("Error: El feligres confirmado {$objeto->getFeligresConfirmadoId()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getPadre1Id())) {
            throw new InvalidArgumentException("Error: El padre 1 {$objeto->getPadre1Id()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getPadre2Id())) {
            throw new InvalidArgumentException("Error: La padre 2 {$objeto->getPadre2Id()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaExpedicionId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroCertificaExpedicionId()} que certifica expedicion no existe.");
        }
    }

    protected function obtenerActoresRelacionados($modelo)
    {
        return [
            'feligres_confirmado' => $this->buscarFeligres($modelo->getFeligresConfirmadoId()),
        ];
    }

}
