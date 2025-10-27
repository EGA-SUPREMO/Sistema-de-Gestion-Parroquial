<?php

require_once 'cargarEnv.php';
require_once 'BaseDatos.php';
require_once 'EntidadFactory.php';

class Formulario
{
    private $pdo;
    private $gestorFeligres;

    public function __construct()
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

            if (($rol === 'padre-' || $rol === 'madre-') && $persona_objeto) {
                $hijos = $this->gestorFeligres->obtenerHijosPorCedulaPadre($persona_objeto->getCedula());

                foreach ($hijos as $llave => $valor) {
                    $datosConstancia = $this->obtenerDatosConstanciaRelacionados($valor->getId(), $nombreTabla);
                    $respuesta['hijos'][$llave] = $datosConstancia;
                    $respuesta['hijos'][$llave]['feligres-'] = $valor->toArrayParaBD();
                }
            }

            if ($rol === 'feligres-' && $persona_objeto) {
                $datosConstancia = $this->obtenerDatosConstanciaRelacionados($persona_objeto->getId(), $nombreTabla);
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
     * Encapsula la lógica de búsqueda de la constancia y padres
     * para el caso especial 'bautizado-'.
     *
     * @param object $persona_objeto El feligrés bautizado.
     * @param string $nombreTabla El nombre de la tabla de la constancia.
     * @return array Datos adicionales para la respuesta.
     */
    private function obtenerDatosConstanciaRelacionados($persona_id, $nombreTabla)
    {
        $datosExtras = [];
        $gestorConstancia = EntidadFactory::crearGestor($this->pdo, $nombreTabla);
        $constancia = $gestorConstancia->obtenerConstanciaPorFeligresBautizadoId($persona_id);// TODO usar una funcion generica que funcione para cada constancia de ser posible

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
