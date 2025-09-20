<?php

require_once 'modelo/Feligres.php';
require_once 'modelo/Peticion.php';
require_once 'modelo/ConstanciaDeBautizo.php';

require_once 'modelo/GestorConstanciaDeBautizo.php';
require_once 'modelo/GestorPeticion.php';
require_once 'modelo/GestorFeligres.php';


class ServicioConstanciaDeBautizo
{
    private $pdo;
    private $gestorPeticion;
    private $gestorFeligres;
    private $gestorConstanciaDeBautizo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->gestorPeticion = new GestorPeticion($pdo);
        $this->gestorConstanciaDeBautizo = new GestorConstanciaDeBautizo($pdo);
        $this->gestorFeligres = new GestorFeligres($pdo);
    }

    public function registrarConstancia($idConstancia, $datosFormulario)
    {
        $this->pdo->beginTransaction();

        try {
            $datosDelFeligres = $this->mapearDatos($datosFormulario, 'feligres');
            $datosDelPadre = $this->mapearDatos($datosFormulario, 'padre');
            $datosDeLaMadre = $this->mapearDatos($datosFormulario, 'madre');

            $feligresId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            $feligresPadreId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            $feligresMadreId = $this->obtenerOcrearFeligresId($datosDelFeligres);
            
            $datosConstancia['feligres_id'] = $feligresId;

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
            'registro_civil'    => $datosFormulario[$prefijo . '-registro_civil']    ?? '',
            'primer_nombre'     => $datosFormulario[$prefijo . '-primer_nombre'],
            'segundo_nombre'    => $datosFormulario[$prefijo . '-segundo_nombre']    ?? '',
            'primer_apellido'   => $datosFormulario[$prefijo . '-primer_apellido'],
            'segundo_apellido'  => $datosFormulario[$prefijo . '-segundo_apellido']  ?? '',
            'fecha_nacimiento'  => $datosFormulario[$prefijo . '-fecha_nacimiento']  ?? '',
            'municipio'         => $datosFormulario[$prefijo . '-municipio']         ?? '',
        ];
    }
}
