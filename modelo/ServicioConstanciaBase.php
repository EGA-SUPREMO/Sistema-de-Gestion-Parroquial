<?php

require_once 'ServicioBase.php';
require_once 'Feligres.php';
require_once 'Peticion.php';
require_once 'Sacerdote.php';
require_once 'Servicio.php';
require_once 'Parentesco.php';
require_once 'ConstanciaDeBautizo.php';

require_once 'FuncionesComunes.php';
require_once 'GestorConstanciaDeBautizo.php';
require_once 'GestorPeticion.php';
require_once 'GestorParentesco.php';
require_once 'GestorSacerdote.php';
require_once 'gestorServicio.php';
require_once 'GestorFeligres.php';
require_once 'GestorAdministrador.php';


abstract class ServicioConstanciaBase extends ServicioBase
{
    protected $gestorPeticion;
    protected $gestorAdministrador;
    protected $gestorFeligres;
    protected $gestorSacerdote;
    protected $gestorConstancia;
    protected $gestorServicio;

    protected static $plantilla_nombre;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->gestorPeticion = new GestorPeticion($pdo);
        $this->gestorAdministrador = new GestorAdministrador($pdo);
        $this->gestorFeligres = new GestorFeligres($pdo);
        $this->gestorParentesco = new gestorParentesco($pdo);
        $this->gestorSacerdote = new gestorSacerdote($pdo);
        $this->gestorServicio = new gestorServicio($pdo);
    }

    public abstract function guardarConstancia($datosFormulario);
    
    protected function guardarPeticion($constancia, $servicioId)
    {
        $servicio = $this->gestorServicio->obtenerPorId($servicioId);
        if (!$servicio) {
            throw new Exception("Servicio con ID {$servicioId} no encontrado.");
        }
        $columnaConstancia = "constancia_de_" . FuncionesComunes::formatearTituloASnakeCase($servicio->getNombre()) . "_id";

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
        
        $nombreMetodoSetter = "set" . $this->formatearSnakeCaseAPascalCase($columnaConstancia);
        
        if (method_exists($peticion, $nombreMetodoSetter)) {
            $peticion->{$nombreMetodoSetter}($constancia->getId());
        } else {
            throw new Exception("El método setter '{$nombreMetodoSetter}' no existe en la clase Peticion.");
        }

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
