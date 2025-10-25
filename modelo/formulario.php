<?php

require_once 'cargarEnv.php';
require_once 'BaseDatos.php';
require_once 'EntidadFactory.php';

class Formulario
{
    private $pdo;
    private $gestorFeligres;
    
    function __construct()
    {
        cargarVariablesDeEntorno(__DIR__ . '/../');
        define('ROOT_PATH', dirname(__DIR__) . '/');

        $this->pdo = BaseDatos::obtenerConexion(
            $_ENV['DB_HOST'],
            $_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    /**
     * Método principal que orquesta la operación completa.
     * Reemplaza el script procedural.
     * * @param array $postData Los datos recibidos (ej: $_POST)
     * @return array La respuesta final
     */
    public function manejarSolicitudDeBusqueda($postData)
    {
        // 1. Decodificar los datos JSON
        $datos_json = $postData['json'] ?? '{}';
        $datos = json_decode($datos_json, true);
        $nombreTabla = $datos['nombre_tabla'];

        // 2. Extraer los identificadores del JSON
        $identificador = $this->obtenerIdentificadorDeBusqueda($datos);

        $respuesta = [];

        if ($identificador) {
            $this->gestorFeligres = EntidadFactory::crearGestor($this->pdo, 'Feligres');
            $persona_objeto = null;
            $rol = $identificador['rol'];

            if ($identificador['tipo'] === 'cedula') {
                $persona_objeto = $this->gestorFeligres->obtenerPorCedula($identificador['valor']);
            } elseif ($identificador['tipo'] === 'partida_de_nacimiento') {
                $persona_objeto = $this->gestorFeligres->obtenerPorPartidaDeNacimiento($identificador['valor']);
            }

            $datos_persona_raw = [];
            if ($persona_objeto) {
                $datos_persona_raw = $persona_objeto->toArrayParaBD() ?? [];
            }

            $respuesta[$rol] = $datos_persona_raw;
            
            if ($rol === 'bautizado-' && $persona_objeto) {
                $datosConstancia = $this->obtenerDatosConstanciaRelacionados(
                    $persona_objeto, 
                    $nombreTabla
                );
                $respuesta = array_merge($respuesta, $datosConstancia);
            }

        }

        // 4. Asegurar el ID por defecto en la respuesta
        if (!isset($respuesta['']['id'])) {
            $respuesta['']['id'] = 0;
        }

        return $respuesta;
    }

    private function obtenerIdentificadorDeBusqueda($datos)
    {
        foreach ($datos as $key => $valor) {
            if (empty($valor)) {
                continue;
            }

            if (str_ends_with($key, 'cedula')) {
                return [
                    'rol' => str_replace('cedula', '', $key),
                    'tipo' => 'cedula',
                    'valor' => $valor
                ];
            }
            
            if (str_ends_with($key, 'partida_de_nacimiento')) {
                return [
                    'rol' => str_replace('partida_de_nacimiento', '', $key),
                    'tipo' => 'partida_de_nacimiento',
                    'valor' => $valor
                ];
            }
        }
        
        return null; // No se encontró ningún identificador
    }

    /**
     * Encapsula la lógica de búsqueda (puntos 4 y 5 del original).
     *
     * @param string|int $cedula La cédula del rol actual.
     * @param string $rol El rol del bucle actual (ej: 'padre-').
     * @param array $partidas_de_nacimiento
     * @param string $persona_activa_parseo El *último* rol detectado en el parseo.
     * @return object|null El $persona_objeto encontrado.
     */
    private function buscarPersona($cedula, $rol, $partidas_de_nacimiento, $persona_activa_parseo)
    {
        $persona_objeto = null;

        // 4. Buscar a la persona por su cédula
        if (!empty($cedula)) {
            $persona_objeto = $this->gestorFeligres->obtenerPorCedula($cedula);
        }

        // 5. Caso especial: si no se encontró por cédula, buscar por partida.
        if (!$persona_objeto) {
            
            // NOTA: Se mantiene la lógica original que usa $persona_activa_parseo 
            // (el último rol del primer bucle) en lugar de $rol (el rol del
            // bucle actual) para buscar la partida.
            $partida_de_nacimiento = $partidas_de_nacimiento[$persona_activa_parseo] ?? null;
            
            if ($partida_de_nacimiento) {
                $persona_objeto = $this->gestorFeligres->obtenerPorPartidaDeNacimiento($partida_de_nacimiento);
            }
        }

        return $persona_objeto;
    }

    /**
     * Encapsula la lógica de búsqueda de la constancia y padres
     * para el caso especial 'bautizado-'.
     *
     * @param object $persona_objeto El feligrés bautizado.
     * @param string $nombreTabla El nombre de la tabla de la constancia.
     * @return array Datos adicionales para la respuesta.
     */
    private function obtenerDatosConstanciaRelacionados($persona_objeto, $nombreTabla)
    {
        $datosExtras = [];
        $gestorConstancia = EntidadFactory::crearGestor($this->pdo, $nombreTabla);
        $constancia = $gestorConstancia->obtenerConstanciaPorFeligresBautizadoId($persona_objeto->getId());// TODO usar una funcion generica que funcione para cada constancia de ser posible

        if ($constancia) {
            $datos_constancia_raw = $constancia->toArrayParaBD() ?? [];
            
            $datosExtras[''] = ['id' => $datos_constancia_raw['id']];
            $datosExtras['padre-'] = $this->gestorFeligres->obtenerPorId($constancia->getPadreId())->toArrayParaBD();
            $datosExtras['madre-'] = $this->gestorFeligres->obtenerPorId($constancia->getMadreId())->toArrayParaBD();
            $datosExtras['constancia-'] = $datos_constancia_raw;
        }

        return $datosExtras;
    }
}

$formulario = new Formulario();
$respuesta = $formulario->manejarSolicitudDeBusqueda($_POST);

header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
