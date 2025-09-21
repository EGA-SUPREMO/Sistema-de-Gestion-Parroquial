<?php

require_once 'modelo/Feligres.php';
//require_once 'modelo/Peticion.php';
require_once 'modelo/Sacerdote.php';
require_once 'modelo/ConstanciaDeBautizo.php';

require_once 'modelo/GestorConstanciaDeBautizo.php';
require_once 'modelo/GestorPeticion.php';
require_once 'modelo/GestorSacerdote.php';
require_once 'modelo/GestorFeligres.php';


class ServicioConstanciaDeBautizo
{
    private $pdo;
    private $gestorPeticion;
    private $gestorFeligres;
    private $gestorSacerdote;
    private $gestorConstanciaDeBautizo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        //$this->gestorPeticion = new GestorPeticion($pdo);
        $this->gestorConstanciaDeBautizo = new GestorConstanciaDeBautizo($pdo);
        $this->gestorFeligres = new GestorFeligres($pdo);
        $this->gestorSacerdote = new gestorSacerdote($pdo);
    }

    public function registrarConstancia($datosFormulario)
    {
        $this->pdo->beginTransaction();

        try {
            $datosDelFeligres = $this->mapearDatos($datosFormulario, 'feligres');
            $datosDelPadre = $this->mapearDatos($datosFormulario, 'padre');
            $datosDeLaMadre = $this->mapearDatos($datosFormulario, 'madre');

            $feligresId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            $feligresPadreId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            $feligresMadreId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            
            $constancia = new ConstanciaDeBautizo();
            $datosConstancia['feligres_bautizado_id'] = $feligresId;
            $datosConstancia['padre_id'] = $feligresMadreId;
            $datosConstancia['madre_id'] = $feligresPadreId;
            $constancia -> hydrate($datosConstancia);
/*
            $peticionGuardada = $this->gestorPeticion->guardar($peticion);
            if (!$peticionGuardada) {
                throw new Exception("No se pudo guardar la petición.");
            }
            $constanciaId = $this->pdo->lastInsertId();

            $peticion->setConstanciaDeBautizoId($constanciaId);

            // TODO LO MISMO PARA LOS PARENTESCOS
*/
            $constanciaGuardada = $this->gestorConstanciaDeBautizo->guardar($constancia);
            if (!$constanciaGuardada) {
                throw new Exception("No se pudo guardar la constancia de bautizo.");
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro de constancia: " . $e->getMessage());
            return false;
        }
    }
    private function obtenerOcrearFeligresId($datosFeligres)
    {
        $feligres = $this->gestorFeligres->buscarPorCedula($datosFeligres['cedula']);

        if ($feligres) {
            return $feligres->getId();
        }
        $nuevoFeligres = new Feligres();
        $nuevoFeligres->hydrate($datosFeligres); 
        
        $guardado = $this->gestorFeligres->guardar($nuevoFeligres);
        if (!$guardado) {
            throw new Exception("Error al crear el feligrés con cédula: " . $cedula);
        }
        return (int)$this->pdo->lastInsertId();
    }
    private function mapearDatos($datosFormulario, $prefijo)
    {
        return [
            'cedula'            => $datosFormulario[$prefijo . '-cedula']            ?? '',
            'partida_de_nacimiento'    => $datosFormulario[$prefijo . '-partida_de_nacimiento']    ?? '',
            'primer_nombre'     => $datosFormulario[$prefijo . '-primer_nombre'],
            'segundo_nombre'    => $datosFormulario[$prefijo . '-segundo_nombre']    ?? '',
            'primer_apellido'   => $datosFormulario[$prefijo . '-primer_apellido'],
            'segundo_apellido'  => $datosFormulario[$prefijo . '-segundo_apellido']  ?? '',
            'fecha_nacimiento'  => $datosFormulario[$prefijo . '-fecha_nacimiento']  ?? '',
            'municipio'         => $datosFormulario[$prefijo . '-municipio']         ?? '',
        ];
    }

    public function generarPDF($constancia)
    {
        $constancia->setFeligres($this->gestorFeligres->obtenerPorId($constancia->getFeligresBautizadoId()));
        $constancia->setPadre($this->gestorFeligres->obtenerPorId($constancia->getPadreId()));
        $constancia->setMadre($this->gestorFeligres->obtenerPorId($constancia->getMadreId()));
        $constancia->setMinistro($this->gestorSacerdote->obtenerPorId($constancia->getMinistroId()));
        $constancia->setMinistroCertifica($this->gestorSacerdote->obtenerPorId($constancia->getMinistroCertificaId()));

        $datos = $constancia->toArrayParaConstanciaPDF();
        GeneradorPdf::guardarPDF($this->plantilla_nombre, $datos);
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
    public function getClavePrimaria() {
        return "id";
    }
}
