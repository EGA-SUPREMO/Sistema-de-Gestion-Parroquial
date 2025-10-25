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

        // (Esta línea se ejecuta en el original, aunque su resultado no se usa 
        // inmediatamente, la mantenemos por fidelidad)
        EntidadFactory::crearGestor($this->pdo, $nombreTabla);

        // 2. Extraer los identificadores del JSON
        $identificadores = $this->parsearIdentificadoresDeEntrada($datos);
        
        $cedulas = $identificadores['cedulas'];
        $partidas_de_nacimiento = $identificadores['partidas'];
        
        // Esta variable $persona es crucial en el código original, 
        // ya que almacena el *último* rol procesado en el parseo.
        $persona_activa_parseo = $identificadores['persona_activa'];

        $respuesta = [];

        // 3. Ejecutar la lógica de búsqueda principal
        if (!empty($cedulas) || !empty($partidas_de_nacimiento)) {
            
            // 3a. Crear una instancia del gestor (solo si es necesario)
            $this->gestorFeligres = EntidadFactory::crearGestor($this->pdo, 'Feligres');

            // 3b. Procesar la búsqueda (que solo se ejecuta una vez)
            $respuesta = $this->procesarBusquedaPrincipal(
                $cedulas,
                $partidas_de_nacimiento,
                $persona_activa_parseo,
                $nombreTabla
            );
        }

        // 4. Asegurar el ID por defecto en la respuesta
        if (!isset($respuesta['']['id'])) {
            $respuesta['']['id'] = 0;
        }

        return $respuesta;
    }

    /**
     * Extrae las cédulas y partidas de los datos de entrada.
     * * Esta función replica el primer bucle 'foreach' del script original.
     * Devuelve la variable $persona que es fundamental para la lógica
     * de búsqueda por partida de nacimiento original.
     *
     * @param array $datos Los datos decodificados del JSON.
     * @return array Un array con 'cedulas', 'partidas' y 'persona_activa'.
     */
    private function parsearIdentificadoresDeEntrada(array $datos): array
    {
        $persona = '';
        $cedulas = [];
        $partidas_de_nacimiento = [];

        foreach ($datos as $key => $value) {
            if (str_ends_with($key, 'cedula')) {
                $rol = str_replace('cedula', '', $key);
                if (!empty($value)) {
                    $cedulas[$rol] = $value;
                    $persona = $rol; // Se asigna el rol de la persona que se está buscando
                }
            } elseif (str_ends_with($key, 'partida_de_nacimiento')) {
                $rol = str_replace('partida_de_nacimiento', '', $key);
                if (!empty($value)) {
                    $cedulas[$rol] = 0; // Lógica original
                    $partidas_de_nacimiento[$rol] = $value;
                    $persona = $rol; // Se asigna el rol de la persona que se está buscando
                }
            }
        }
        
        // La asignación original "$persona = $persona;" era redundante y se omite.
        
        return [
            'cedulas' => $cedulas,
            'partidas' => $partidas_de_nacimiento,
            'persona_activa' => $persona // Esta es la variable $persona original
        ];
    }

    /**
     * Ejecuta la lógica del bucle principal que busca a la persona.
     * * Replica el 'foreach ($cedulas...)' que contiene un 'break' 
     * y solo procesa el primer elemento.
     *
     * @param array $cedulas
     * @param array $partidas_de_nacimiento
     * @param string $persona_activa_parseo (La variable $persona del primer bucle)
     * @param string $nombreTabla
     * @return array La respuesta generada por la búsqueda.
     */
    private function procesarBusquedaPrincipal(array $cedulas, array $partidas_de_nacimiento, string $persona_activa_parseo, string $nombreTabla): array
    {
        $respuesta = [];

        // 3. Iterar sobre el array (aunque solo tendrá un elemento debido al 'break')
        foreach ($cedulas as $rol => $cedula) {

            // 4 & 5. Buscar a la persona por Cédula o Partida
            $persona_objeto = $this->buscarPersona(
                $cedula, 
                $rol, 
                $partidas_de_nacimiento, 
                $persona_activa_parseo // Se pasa la variable $persona original
            );

            // 6. Preparar los datos de respuesta
            $datos_persona_raw = [];
            if ($persona_objeto) {
                $datos_persona_raw = $persona_objeto->toArrayParaBD() ?? [];
            }

            // 7. Añadir los datos al array de respuesta
            $respuesta[$rol] = $datos_persona_raw;
            
            // Lógica especial si es el bautizado
            if ($rol === 'bautizado-' && $persona_objeto) {
                $datosConstancia = $this->obtenerDatosConstanciaRelacionados(
                    $persona_objeto, 
                    $nombreTabla
                );
                // Fusionamos los datos de la constancia (padres, etc.)
                $respuesta = array_merge($respuesta, $datosConstancia);
            }

            // 8. Rompemos el bucle (lógica original)
            break;
        }
        
        return $respuesta;
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
    private function buscarPersona($cedula, string $rol, array $partidas_de_nacimiento, string $persona_activa_parseo)
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
    private function obtenerDatosConstanciaRelacionados($persona_objeto, string $nombreTabla): array
    {
        $datosExtras = [];
        $gestorConstancia = EntidadFactory::crearGestor($this->pdo, $nombreTabla);
        $constancia = $gestorConstancia->obtenerConstanciaPorFeligresBautizadoId($persona_objeto->getId());

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

/*
// 1. Decodificar los datos JSON recibidos de JavaScript
$datos_json = $_POST['json'] ?? '{}';
$datos = json_decode($datos_json, true);

$persona = '';
$cedulas = [];
$partidas_de_nacimiento = [];
$respuesta = [];
$nombreTabla = $datos['nombre_tabla'];

EntidadFactory::crearGestor($pdo, $nombreTabla);


foreach ($datos as $key => $value) {
    // Si la clave termina en "-cedula"
    if (str_ends_with($key, 'cedula')) {
        // Extraemos el rol (ej: 'padre' de 'padre-cedula')
        $persona = str_replace('cedula', '', $key);

        // Si hay un valor, almacenamos la cédula y fijamos el persona activo
        if (!empty($value)) {
            $cedulas[$persona] = $value;
            $persona = $persona; // Asignamos el persona de la persona que se está buscando
        }
    } elseif (str_ends_with($key, 'partida_de_nacimiento')) {
        // Extraemos el persona (ej: 'feligres' de 'feligres-partida_nacimiento')
        $persona = str_replace('partida_de_nacimiento', '', $key);

        // Si hay un valor, almacenamos la partida
        if (!empty($value)) {
            $cedulas[$persona] = 0;
            $partidas_de_nacimiento[$persona] = $value;
            $persona = $persona; // Asignamos el persona de la persona que se está buscando
        }
    }
}


if (!empty($cedulas) || !empty($partidas_de_nacimiento)) {
    // 2. Crear una instancia del gestor (solo si es necesario)
    $gestorFeligres = EntidadFactory::crearGestor($pdo, 'Feligres');

    // 3. Iterar sobre el array (aunque solo tendrá un elemento)
    // Esto nos da el rol ('padre', 'madre', etc.) y la cédula dinámicamente.
    foreach ($cedulas as $rol => $cedula) {

        $persona_objeto = null;

        // 4. Buscar a la persona por su cédula
        if (!empty($cedula)) {
            $persona_objeto = $gestorFeligres->obtenerPorCedula($cedula);
        }

        // 5. Caso especial: si es el feligrés y no se encontró por cédula,
        // intentar buscar por partida de nacimiento.
        if (!$persona_objeto) {
            $partida_de_nacimiento = $partidas_de_nacimiento[$persona] ?? null;
            if ($partida_de_nacimiento) {
                $persona_objeto = $gestorFeligres->obtenerPorPartidaDeNacimiento($partida_de_nacimiento);
            }
        }

        // 6. Preparar los datos de respuesta
        $datos_persona_raw = [];
        if ($persona_objeto) {
            // Si se encontró el objeto, lo convertimos a un array
            $datos_persona_raw = $persona_objeto->toArrayParaBD() ?? [];
        }

        // 7. Añadir los datos al array de respuesta con la clave dinámica (ej: 'padre-')
        $respuesta[$rol] = $datos_persona_raw;
        if ($rol === 'bautizado-' && $persona_objeto) {
            $gestorConstancia = EntidadFactory::crearGestor($pdo, $nombreTabla);
            $constancia = $gestorConstancia->obtenerConstanciaPorFeligresBautizadoId($persona_objeto->getId());
            if ($constancia) {
                $datos_constancia_raw = $constancia->toArrayParaBD() ?? [];
                $respuesta[''] = ['id' => $datos_constancia_raw['id']];
                $respuesta['padre-'] = $gestorFeligres->obtenerPorId($constancia->getPadreId())->toArrayParaBD();
                $respuesta['madre-'] = $gestorFeligres->obtenerPorId($constancia->getMadreId())->toArrayParaBD();
                $respuesta['constancia-'] = $datos_constancia_raw;
            }
        }

        // 8. Rompemos el bucle. Como sabemos que solo viene una persona,
        // no tiene sentido seguir iterando.
        break;
    }
}


if (!isset($respuesta['']['id'])) {
    $respuesta['']['id'] = 0;
}
*/
// 6. Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
