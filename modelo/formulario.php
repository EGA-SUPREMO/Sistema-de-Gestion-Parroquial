<?php

require_once 'App.php';
require_once 'EntidadFactory.php';

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
            $rol = null;

            if (is_array($identificador) && isset($identificador[0]['rol']) && $identificador[0]['rol'] == "contrayente_1") {
                return $this->respuestaParaElMatrimonio($identificador, $nombreTabla);
            } elseif (is_array($identificador) && isset($identificador[0]['rol']) && $identificador[0]['rol'] == "libro-registro") {
                return $this->respuestaParaElRegistroLibro($datos, $nombreTabla);
            }

            $rol = $identificador['rol'];
            $persona_objeto = null;

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
    private function respuestaParaElRegistroLibro($datos, $nombreTabla)
    {
        $datosConstancia = $this->obtenerDatosConstanciaRelacionados([$datos['constancia-numero_libro'], $datos['constancia-numero_pagina'], $datos['constancia-numero_marginal']], $nombreTabla, 'libro-registro');
        return $datosConstancia;
    }
    private function respuestaParaElMatrimonio($identificador, $nombreTabla)
    {
        $rol = $identificador[0]['rol'];
        $personas_encontradas = [];

        foreach ($identificador as $id) {
            $persona_objeto = null;

            if ($id['tipo'] === 'cedula') {
                $persona_objeto = $this->gestorFeligres->obtenerPorCedula($id['valor']);
            } elseif ($id['tipo'] === 'partida_de_nacimiento') {
                $persona_objeto = $this->gestorFeligres->obtenerPorPartidaDeNacimiento($id['valor']);
            }

            $personas_encontradas[$id['rol']] = $persona_objeto;
        }

        $datosConstancia = $this->obtenerDatosConstanciaRelacionados([$personas_encontradas['contrayente_1']->getId(), $personas_encontradas['contrayente_2']->getId()], $nombreTabla);

        return $datosConstancia;
    }

    private function obtenerIdentificadorDeBusqueda($datos)
    {
        // Chapuza, pero no hay tiempo para estar arreglando el codigo, caso especial de matrimonio que necesita 2 identificadores en lugar de uno
        $identificadores = [];
        if (isset($datos['contrayente_1-cedula']) && !empty($datos['contrayente_1-cedula'])) {
            $identificadores[] = [
                'rol' => 'contrayente_1',
                'tipo' => 'cedula',
                'valor' => $datos['contrayente_1-cedula']
            ];
        }

        if (isset($datos['contrayente_2-cedula']) && !empty($datos['contrayente_2-cedula'])) {
            $identificadores[] = [
                'rol' => 'contrayente_2',
                'tipo' => 'cedula',
                'valor' => $datos['contrayente_2-cedula']
            ];
        }

        if (count($identificadores) == 2) {
            return $identificadores;
        }
        if (isset($datos['constancia-numero_libro']) && !empty($datos['constancia-numero_libro'])) {
            $identificadores[] = [
                'rol' => 'libro-registro',
                'tipo' => 'numero_libro',
                'valor' => $datos['constancia-numero_libro']
            ];
            return $identificadores;
        }

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

        return null;
    }

    private function obtenerDatosConstanciaRelacionados($identificadorConstancia, $nombreTabla, $rol = 'sujeto_sacramento')
    {
        $datosExtras = [];
        $gestorConstancia = EntidadFactory::crearGestor($this->pdo, $nombreTabla);
        $servicioConstancia = EntidadFactory::crearServicio($this->pdo, $nombreTabla);
        $constancia = null;
        if ($rol == "sujeto_sacramento") {
            $constancia = $gestorConstancia->obtenerConstanciaPorSujetoSacramentoId($identificadorConstancia);
        } elseif ($rol == "libro-registro") {
            $constancia = $gestorConstancia->obtenerConstanciaPorRegistroLibro($identificadorConstancia);
        }

        if ($constancia) {
            $constancia_id = $constancia->getId();
            $datos_completos = $servicioConstancia->obtenerDatosCompletosParaEdicion($constancia_id);

            $datosExtras[''] = ['id' => $datos_completos['id']];
            $datosExtras['constancia-'] = $datos_completos;

            foreach ($datos_completos as $columnaBase => $valor) {
                if (is_array($valor)) {
                    $prefijoFront = $columnaBase . '-';
                    $datosExtras[$prefijoFront] = $valor;

                    unset($datosExtras['constancia-'][$columnaBase]);
                }
            }
        }

        return $datosExtras;
    }


}
//try {
App::iniciar();

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
