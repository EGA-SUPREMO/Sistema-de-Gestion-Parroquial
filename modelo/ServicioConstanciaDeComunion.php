<?php

require_once 'ServicioConstanciaBase.php';
require_once 'Feligres.php';
require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'Parentesco.php';
require_once 'ConstanciaDeComunion.php';

require_once 'GestorConstanciaDeComunion.php';
require_once 'GestorPeticion.php';
require_once 'GestorParentesco.php';
require_once 'GestorSacerdote.php';
require_once 'GestorFeligres.php';
require_once 'GestorAdministrador.php';


class ServicioConstanciaDeComunion extends ServicioConstanciaBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->servicioIdParaEstaConstancia = 3;
        $this->gestorConstancia = new GestorConstanciaDeComunion($pdo);
        self::$plantilla_nombre = "primera comunion.docx";
    }

    public function guardarConstancia($datosFormulario)
    {
        return $this->ejecutarEnTransaccion(function () use ($datosFormulario) {
            $datosConstancia = self::limpiarClavesParaDatosConstancia($datosFormulario);

            $datosDelFeligres = self::mapearParaEntidad($datosFormulario, 'feligres');

            $feligresId = $this->gestorFeligres->upsertFeligresPorArray($datosDelFeligres);

            $constancia = new ConstanciaDeComunion();
            $datosConstancia['feligres_id'] = $feligresId;

            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);

            $idConstanciaEncontradaPorFeligres = $this->gestorConstancia->obtenerConstanciaIdPorFeligresId($feligresId);
            $constancia->setId($idConstanciaEncontradaPorFeligres);

            $this->gestorConstancia->guardar($constancia, $idConstanciaEncontradaPorFeligres);

            $this->guardarPeticion($constancia, $this->servicioIdParaEstaConstancia);

            $constancia->setFeligres($this->gestorFeligres->obtenerPorId($constancia->getFeligresId()));
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
        if (!$this->gestorFeligres->obtenerPorId($objeto->getFeligresId())) {
            throw new InvalidArgumentException("Error: El feligrés {$objeto->getFeligresId()} bautizado no existe.");
        }

        if (!$this->gestorSacerdote->obtenerPorId($objeto->getMinistroCertificaExpedicionId())) {
            throw new InvalidArgumentException("Error: El ministro {$objeto->getMinistroCertificaExpedicionId()} que certifica no existe.");
        }
    }
}
