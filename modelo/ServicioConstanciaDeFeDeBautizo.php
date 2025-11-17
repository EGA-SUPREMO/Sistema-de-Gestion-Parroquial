<?php

require_once 'ServicioConstanciaBase.php';
require_once 'Feligres.php';
require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'Parentesco.php';
require_once 'ConstanciaDeFeDeBautizo.php';

require_once 'GestorConstanciaDeFeDeBautizo.php';
require_once 'GestorPeticion.php';
require_once 'GestorParentesco.php';
require_once 'GestorSacerdote.php';
require_once 'GestorFeligres.php';
require_once 'GestorAdministrador.php';

class ServicioConstanciaDeFeDeBautizo extends ServicioConstanciaBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->servicioIdParaEstaConstancia = 2;
        $this->gestorConstancia = new GestorConstanciaDeFeDeBautizo($pdo);
        self::$plantilla_nombre = "fe de bautizo.docx";
    }

    public function guardarConstancia($datosFormulario)
    {
        return $this->ejecutarEnTransaccion(function () use ($datosFormulario) {
            $datosConstancia = self::limpiarClavesParaDatosConstancia($datosFormulario);

            $datosDelFeligres = self::mapearParaEntidad($datosFormulario, 'feligres');
            $datosDelPadre = self::mapearParaEntidad($datosFormulario, 'padre');
            $datosDeLaMadre = self::mapearParaEntidad($datosFormulario, 'madre');

            $feligresId = $this->gestorFeligres->upsertFeligresPorArray($datosDelFeligres);
            $feligresPadreId = $this->gestorFeligres->upsertFeligresPorArray($datosDelPadre);
            $feligresMadreId = $this->gestorFeligres->upsertFeligresPorArray($datosDeLaMadre);

            $constancia = new ConstanciaDeFeDeBautizo();
            $datosConstancia['feligres_bautizado_id'] = $feligresId;
            $datosConstancia['padre_id'] = $feligresPadreId;
            $datosConstancia['madre_id'] = $feligresMadreId;

            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorFeligres = $this->gestorConstancia->obtenerConstanciaIdPorFeligresBautizadoId($feligresId);
            $this->gestorConstancia->verificarConsistenciaIds($feligresId, $datosConstancia['numero_libro'], $datosConstancia['numero_pagina'], $datosConstancia['numero_marginal']);
            $constancia->setId($idConstanciaEncontradaPorFeligres);

            $this->gestorConstancia->guardar($constancia, $idConstanciaEncontradaPorFeligres);

            $this->guardarPeticion($constancia, $this->servicioIdParaEstaConstancia);

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

            $constancia->setFeligresBautizado($this->gestorFeligres->obtenerPorId($constancia->getFeligresBautizadoId()));
            $constancia->setPadre($this->gestorFeligres->obtenerPorId($constancia->getPadreId()));
            $constancia->setMadre($this->gestorFeligres->obtenerPorId($constancia->getMadreId()));
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
        if (!$this->gestorFeligres->obtenerPorId($objeto->getFeligresBautizadoId())) {
            throw new InvalidArgumentException("Error: El feligrés {$objeto->getFeligresBautizadoId()} bautizado no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getPadreId())) {
            throw new InvalidArgumentException("Error: El padre {$objeto->getPadreId()} no existe.");
        }

        if (!$this->gestorFeligres->obtenerPorId($objeto->getMadreId())) {
            throw new InvalidArgumentException("Error: La madre {$objeto->getMadreId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroId()} no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroCertificaId()} que certifica no existe.");
        }
        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaExpedicionId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroCertificaExpedicionId()} que certifica expedicion no existe.");
        }
    }
}
