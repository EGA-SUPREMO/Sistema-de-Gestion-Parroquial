<?php

require_once 'cargarEnv.php';
require_once 'conexion.php';

// Cargar las variables de entorno
cargarVariablesDeEntorno(__DIR__ . '/../');

// 1. Crear la conexión $pdo dentro del script AJAX
$pdo = BaseDatos::obtenerConexion(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

// Asegúrate de incluir tu gestor de base de datos y la clase GestorFeligres
require_once 'GestorFeligres.php';
// Asume que también necesitas Feligres.php o similar si obtienes un objeto Feligres

// 1. Decodificar los datos JSON recibidos de JavaScript
$datos_json = $_POST['json'] ?? '{}';
$datos = json_decode($datos_json, true);

// 2. Extraer la cédula del padre
// El JS envía: { "cedula": "12345678" }
$cedula_padre = $datos['padre-cedula'] ?? null;
$cedula_madre = $datos['madre-cedula'] ?? null;
$cedula_feligres = $datos['feligres-cedula'] ?? null;

$respuesta = [
    'padre' => null,
    'madre' => null,
    'feligres' => null,
];

if (!empty($cedula_padre)) {
    // 3. Crear una instancia del gestor
    $gestorFeligres = new GestorFeligres($pdo);

    // 4. Buscar el feligrés (padre) por la cédula
    $padre_objeto = $gestorFeligres->obtenerPorCedula($cedula_padre);

    // 5. Formatear la respuesta
    if ($padre_objeto) {
        // Usar el método toArrayParaBD() para obtener el array de datos
        $datos_padre_raw = $padre_objeto->toArrayParaBD();

        // La función de JS espera claves como 'primer_nombre', 'segundo_nombre', etc.
        // Solo incluimos las claves que queremos que el autocompletado use.
        $respuesta['padre'] = [// TODO usar mapear datos de servicio
            'cedula' => $datos_padre_raw['cedula'] ?? '',
            'primer_nombre' => $datos_padre_raw['primer_nombre'] ?? '',
            'segundo_nombre' => $datos_padre_raw['segundo_nombre'] ?? '',
            'primer_apellido' => $datos_padre_raw['primer_apellido'] ?? '',
            'segundo_apellido' => $datos_padre_raw['segundo_apellido'] ?? '',
            // Puedes agregar más campos que coincidan con los inputs del formulario
        ];

        // Opcional: Si el padre tiene un ID de feligrés asociado,
        // podrías buscar a la madre y al propio feligrés aquí.
        // Por ahora, solo devolvemos al padre.
    }
}

// 6. Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
