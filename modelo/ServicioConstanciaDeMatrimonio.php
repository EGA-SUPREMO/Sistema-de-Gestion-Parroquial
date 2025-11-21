<?php

require_once 'ServicioConstanciaBase.php';
require_once 'Feligres.php';
require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'Parentesco.php';
require_once 'ConstanciaDeMatrimonio.php';

require_once 'GestorConstanciaDeMatrimonio.php';
require_once 'GestorPeticion.php';
require_once 'GestorParentesco.php';
require_once 'GestorSacerdote.php';
require_once 'GestorFeligres.php';
require_once 'GestorAdministrador.php';

class ServicioConstanciaDeMatrimonio extends ServicioConstanciaBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->servicioIdParaEstaConstancia = 5;
        $this->gestorConstancia = new GestorConstanciaDeMatrimonio($pdo);
        self::$plantilla_nombre = "matrimonio.docx";
    }

    public function guardarConstancia($datosFormulario)
    {
        return $this->ejecutarEnTransaccion(function () use ($datosFormulario) {
            $datosConstancia = self::limpiarClavesParaDatosConstancia($datosFormulario);

            $datosDeContrayente1 = self::mapearParaEntidad($datosFormulario, 'contrayente_1');
            $datosDeContrayente2 = self::mapearParaEntidad($datosFormulario, 'contrayente_2');
            $datosDeTestigo1 = self::mapearParaEntidad($datosFormulario, 'testigo_1');
            $datosDeTestigo2 = self::mapearParaEntidad($datosFormulario, 'testigo_2');

            $contrayente1Id = $this->gestorFeligres->upsertFeligresPorArray($datosDeContrayente1);
            $contrayente2Id = $this->gestorFeligres->upsertFeligresPorArray($datosDeContrayente2);
            $testigo1Id = $this->gestorFeligres->upsertFeligresPorArray($datosDeTestigo1);
            $testigo2Id = $this->gestorFeligres->upsertFeligresPorArray($datosDeTestigo2);

            $constancia = new ConstanciaDeMatrimonio();
            $datosConstancia['contrayente_1_id'] = $contrayente1Id;
            $datosConstancia['contrayente_2_id'] = $contrayente2Id;
            $datosConstancia['testigo_1_id'] = $testigo1Id;
            $datosConstancia['testigo_2_id'] = $testigo2Id;

            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorSujeto = $this->gestorConstancia->obtenerConstanciaIdPorSujetoSacramentoId(['contrayente_1_id' => $contrayente1Id, 'contrayente_2_id' => $contrayente2Id]);
            $this->gestorConstancia->verificarConsistenciaIds(['contrayente_1_id' => $contrayente1Id, 'contrayente_2_id' => $contrayente2Id], $datosConstancia['numero_libro'], $datosConstancia['numero_pagina'], $datosConstancia['numero_marginal']);
            $constancia->setId($idConstanciaEncontradaPorSujeto);

            $this->gestorConstancia->guardar($constancia, $idConstanciaEncontradaPorSujeto);
            $this->guardarPeticion($constancia, $this->servicioIdParaEstaConstancia);

            $constancia->setContrayente1($this->gestorFeligres->obtenerPorId($constancia->getContrayente1Id()));
            $constancia->setContrayente2($this->gestorFeligres->obtenerPorId($constancia->getContrayente2Id()));
            $constancia->setTestigo1($this->gestorFeligres->obtenerPorId($constancia->getTestigo1Id()));
            $constancia->setTestigo2($this->gestorFeligres->obtenerPorId($constancia->getTestigo2Id()));
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

        if (!$this->gestorFeligres->obtenerPorId($objeto->getTestigo1Id())) {
            throw new InvalidArgumentException("Error: El testigo 1 {$objeto->getTestigo1Id()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getTestigo2Id())) {
            throw new InvalidArgumentException("Error: La testigo 2 {$objeto->getTestigo2Id()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaExpedicionId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroCertificaExpedicionId()} que certifica expedicion no existe.");
        }
    }
}
