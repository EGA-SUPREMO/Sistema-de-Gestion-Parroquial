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

            $datosDeContrayente1 = self::mapearParaEntidad($datosFormulario, 'contrayente_1');
            $datosDeContrayente2 = self::mapearParaEntidad($datosFormulario, 'contrayente_2');

            $contrayente1Id = $this->gestorFeligres->upsertFeligresPorArray($datosDeContrayente1);
            $contrayente2Id = $this->gestorFeligres->upsertFeligresPorArray($datosDeContrayente2);

            $constancia = new ConstanciaDeConfirmacion();
            $datosConstancia['contrayente_1_id'] = $contrayente1Id;
            $datosConstancia['contrayente_2_id'] = $contrayente2Id;

            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorSujeto = $this->gestorConstancia->obtenerConstanciaIdPorSujetoSacramentoId(['contrayente_1_id' => $contrayente1Id, 'contrayente_2_id' => $contrayente2Id]);
            $this->gestorConstancia->verificarConsistenciaIds(['contrayente_1_id' => $contrayente1Id, 'contrayente_2_id' => $contrayente2Id], $datosConstancia['numero_libro'], $datosConstancia['numero_pagina'], $datosConstancia['numero_marginal']);
            $constancia->setId($idConstanciaEncontradaPorSujeto);

            $this->gestorConstancia->guardar($constancia, $idConstanciaEncontradaPorSujeto);
            $this->guardarPeticion($constancia, $this->servicioIdParaEstaConstancia);

            $constancia->setContrayente1($this->gestorFeligres->obtenerPorId($constancia->getContrayente1Id()));
            $constancia->setContrayente2($this->gestorFeligres->obtenerPorId($constancia->getContrayente2Id()));
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

        if (!$this->gestorFeligres->obtenerPorId($objeto->getContrayente1Id())) {
            throw new InvalidArgumentException("Error: El contrayente 1 {$objeto->getContrayente1Id()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getContrayente2Id())) {
            throw new InvalidArgumentException("Error: La contrayente 2 {$objeto->getContrayente2Id()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaExpedicionId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroCertificaExpedicionId()} que certifica expedicion no existe.");
        }
    }
}
