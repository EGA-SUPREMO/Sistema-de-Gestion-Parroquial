<?php

session_start();
require_once 'modelo/cargarEnv.php';
require_once 'modelo/conexion.php';

cargarVariablesDeEntorno();//TODO ver como quito esto, es muy low level
$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

$controladorNombre = strtolower(isset($_REQUEST['c']) ? $_REQUEST['c'] : 'login');
$accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

$controlador = "controlador/{$controladorNombre}.controlador.php";
$controladorclase = ucwords($controladorNombre) . 'Controlador';

try {
    $pdo = BaseDatos::obtenerConexion($dbHost, $dbName, $dbUser, $dbPass);

    if (!file_exists($controlador)) {
        throw new Exception("Controlador no encontrado");
    }

    require_once $controlador;

    if (!class_exists($controladorclase)) {
        throw new Exception("Clase del controlador no encontrada");
    }

    $controladorInstanciado = new $controladorclase($pdo);

    if (!method_exists($controladorInstanciado, $accion)) {
        throw new Exception("Método no encontrado");
    }

    call_user_func([$controladorInstanciado, $accion]);

} catch (Exception $e) {
    error_log($e->getMessage());
    header('Location: index.php?c=login&a=dashboard');
    exit;
}
