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

    public function registrarConstancia($datosFormulario)
    {
        $this->pdo->beginTransaction();

        try {
            $datosConstancia = $datosFormulario;

            $datosDelFeligres = $this->mapearDatos($datosFormulario, 'feligres');
            $datosDelPadre = $this->mapearDatos($datosFormulario, 'padre');
            $datosDeLaMadre = $this->mapearDatos($datosFormulario, 'madre');

            $feligresId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            $feligresPadreId = $this->obtenerOcrearFeligresId($datosDelPadre);
            $feligresMadreId = $this->obtenerOcrearFeligresId($datosDeLaMadre);

            $constancia = new ConstanciaDeBautizo();
            $datosConstancia['feligres_bautizado_id'] = $feligresId;
            $datosConstancia['padre_id'] = $feligresMadreId;
            $datosConstancia['madre_id'] = $feligresPadreId;
            $constancia -> hydrate($datosConstancia);
            $this->validarDependencias($constancia);
            $constanciaGuardada = $this->gestorConstanciaDeBautizo->guardar($constancia);
            /*
                        $peticionGuardadaId = $this->gestorPeticion->guardar($peticion);

                        $peticion->setConstanciaDeBautizoId($constanciaId);

                        // TODO LO MISMO PARA LOS PARENTESCOS
            */

            $this->pdo->commit();
            return $constancia;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro de constancia: " . $e->getMessage());
            return false;
        }
    }
    private function obtenerOcrearFeligresId($datosFeligres)
    {
        $feligres = $this->gestorFeligres->obtenerPorCedula($datosFeligres['cedula']);
        $id=0;

        if ($feligres) {
            $feligres->hydrate($datosFeligres);
            $id = $feligres->getId();
            $this->gestorFeligres->guardar($feligres, $id);
        } else {
            $nuevoFeligres = new Feligres();
            $nuevoFeligres->hydrate($datosFeligres);
            $id = $this->gestorFeligres->guardar($nuevoFeligres);
        }
        if (!$id) {
            throw new Exception("Error al crear o actualizar el feligrés con cédula: " . $datosFeligres['cedula']);
        }
        return $id;
    }
    private function mapearDatos($datosFormulario, $prefijo)
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

    public function generarPDF($constancia)
    {
        $constancia->setFeligresBautizado($this->gestorFeligres->obtenerPorId($constancia->getFeligresBautizadoId()));
        $constancia->setPadre($this->gestorFeligres->obtenerPorId($constancia->getPadreId()));
        $constancia->setMadre($this->gestorFeligres->obtenerPorId($constancia->getMadreId()));
        $constancia->setMinistro($this->gestorSacerdote->obtenerPorId($constancia->getMinistroId()));
        $constancia->setMinistroCertificaExpedicion($this->gestorSacerdote->obtenerPorId($constancia->getMinistroCertificaExpedicionId()));

        $datos = $constancia->toArrayParaConstanciaPDF();
        GeneradorPdf::guardarPDF(self::$plantilla_nombre, $datos);
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
