<?php

require_once 'App.php';
require_once 'EntidadFactory.php';

App::iniciar();

class Formulario
{
    private $pdo;
    private $gestorFeligres;

    public function __construct()
    {
        $this->pdo = App::obtenerConexion();
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

            if (($rol === 'padre-' || $rol === 'madre-' || $rol === 'padre_1-' || $rol === 'padre_2-') && $persona_objeto) {
                $hijos = $this->gestorFeligres->obtenerHijosPorCedulaPadre($persona_objeto->getCedula());

                foreach ($hijos as $llave => $valor) {
                    $datosConstancia = $this->obtenerDatosConstanciaRelacionados($valor->getId(), $nombreTabla);
                    $respuesta['hijos'][$llave] = $datosConstancia;
                    $datosFeligres = $valor->toArrayParaBD();
                    $datosFeligres['nombre_completo'] = $valor->nombreCompleto();
                    $respuesta['hijos'][$llave]['feligres-'] = $datosFeligres;
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

    private function obtenerDatosConstanciaRelacionados($persona_id, $nombreTabla)
    {
        $datosExtras = [];
        $gestorConstancia = EntidadFactory::crearGestor($this->pdo, $nombreTabla);
        $constancia = $gestorConstancia->obtenerConstanciaPorSujetoSacramentoId($persona_id);

        if ($constancia) {
            $datos_constancia_raw = $constancia->toArrayParaBD() ?? [];

            $datosExtras[''] = ['id' => $datos_constancia_raw['id']];
            $datosExtras['constancia-'] = $datos_constancia_raw;

            $rolesPosibles = [
                'padre'   => 'padre-',
                'madre'   => 'madre-',
                'padre_1' => 'padre_1-',
                'padre_2' => 'padre_2-',
                'contrayente_1' => 'contrayente_1-',
                'contrayente_2' => 'contrayente_2-',
            ];

            foreach ($rolesPosibles as $columnaBase => $prefijoFront) {
                $nombreMetodo = 'get' . FuncionesComunes::formatearSnakeCaseAPascalCase($columnaBase . '_id');

                if (method_exists($constancia, $nombreMetodo)) {

                    $idRelacionado = $constancia->$nombreMetodo();

                    if ($idRelacionado) {
                        $feligres = $this->gestorFeligres->obtenerPorId($idRelacionado);
                        if ($feligres) {
                            $datosExtras[$prefijoFront] = $feligres->toArrayParaBD();
                        }
                    }
                }
            }
        }

        return $datosExtras;
    }

}
//try {
$formulario = new Formulario();
$respuesta = $formulario->manejarSolicitudDeBusqueda($_POST);
header('Content-Type: application/json');
echo json_encode($respuesta);
//} catch (Exception $e) {
//    error_log($e->getMessage());
//    http_response_code(500);
//    echo json_encode(['error' => $e->getMessage()]);
//}
exit();
