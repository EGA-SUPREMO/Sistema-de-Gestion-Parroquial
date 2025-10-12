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

$persona = '';
$cedulas = [];
$partidas_de_nacimiento = [];
$respuesta = [];


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
    $gestorFeligres = new GestorFeligres($pdo);
    
error_log(print_r($partidas_de_nacimiento, true));
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

        // 8. Rompemos el bucle. Como sabemos que solo viene una persona,
        // no tiene sentido seguir iterando.
        break; 
    }
}


// 6. Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
