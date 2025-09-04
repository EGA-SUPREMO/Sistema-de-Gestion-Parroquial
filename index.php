<?php

session_start();
require_once 'modelo/cargarEnv.php';
require_once 'modelo/conexion.php';

cargarVariablesDeEntorno();

$controladorNombre = strtolower(isset($_REQUEST['c']) ? $_REQUEST['c'] : 'login');
$accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

$controlador = "controlador/{$controladorNombre}.controlador.php";
$controladorclase = ucwords($controladorNombre) . 'Controlador';

try {
    $pdo = BaseDatos::obtenerConexion($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

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


    require_once "vistas/cabezera.php";
    if (!($controladorNombre == "login" && $accion == "index")) {
        require_once "vistas/menu.php";
    }

    call_user_func([$controladorInstanciado, $accion]);

} catch (Exception $e) {
    error_log($e->getMessage());
    header('Location: index.php?c=dashboard&a=index');
    exit;
}
