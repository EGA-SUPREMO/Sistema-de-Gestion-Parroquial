<?php

require_once 'cargarEnv.php';
require_once 'BaseDatos.php';
// Cargar las variables de entorno
cargarVariablesDeEntorno(__DIR__ . '/../');
define('ROOT_PATH', dirname(__DIR__) . '/');

$pdo = BaseDatos::obtenerConexion(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

require_once 'Feligres.php';
require_once 'GestorFeligres.php';
require_once 'ServicioConstanciaDeBautizo.php';
// Asume que también necesitas Feligres.php o similar si obtienes un objeto Feligres

// 1. Decodificar los datos JSON recibidos de JavaScript
$datos_json = $_POST['json'] ?? '{}';
$datos = json_decode($datos_json, true);

// 2. Extraer la cédula del padre
// El JS envía: { "cedula": "12345678" }
$cedula_padre = $datos['padre-cedula'] ?? null;
$cedula_madre = $datos['madre-cedula'] ?? null;
$cedula_feligres = $datos['feligres-cedula'] ?? null;
$partida_de_nacimiento_feligres = $datos['feligres-partida_de_nacimiento'] ?? null;

$respuesta = [
    'padre' => null,
    'madre' => null,
    'feligres' => null,
];

if (!empty($cedula_padre) || !empty($cedula_madre) || !empty($cedula_feligres) || !empty($partida_de_nacimiento_feligres)) {
    // 3. Crear una instancia del gestor
    $gestorFeligres = new GestorFeligres($pdo);

    // 4. Buscar el feligrés (padre) por la cédula
    $padre_objeto = $gestorFeligres->obtenerPorCedula($cedula_padre);
    $madre_objeto = $gestorFeligres->obtenerPorCedula($cedula_madre);
    $feligres_objeto = $gestorFeligres->obtenerPorCedula($cedula_feligres);
    if (!$feligres_objeto) {
        $feligres_objeto = $gestorFeligres->obtenerPorPartidaDeNacimiento($partida_de_nacimiento_feligres);
    }

    $datos_padre_raw = [];
    if ($padre_objeto) {
        $datos_padre_raw = $padre_objeto->toArrayParaBD() ?? [];
    }
    $datos_madre_raw = [];
    if ($madre_objeto) {
        $datos_madre_raw = $madre_objeto->toArrayParaBD() ?? [];
    }
    $datos_feligres_raw = [];
    if ($feligres_objeto) {
        $datos_feligres_raw = $feligres_objeto->toArrayParaBD() ?? [];
    }
    // La función de JS espera claves como 'primer_nombre', 'segundo_nombre', etc.
    // Solo incluimos las claves que queremos que el autocompletado use.
    $respuesta['padre'] = $datos_padre_raw;
    $respuesta['madre'] = $datos_madre_raw;
    $respuesta['feligres'] = $datos_feligres_raw;

    // TODO usar parentesco para devolver hijos tambien
}

// 6. Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
