<?php

require_once 'modelo/cargarEnv.php';

cargarVariablesDeEntorno();

$controladorNombre = strtolower(isset($_REQUEST['c']) ? $_REQUEST['c'] : 'login');
$accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';


$controlador = "controlador/{$controladorNombre}.controlador.php";
$controladorclase = ucwords($controladorNombre) . 'Controlador';

try {
    if (!file_exists($controlador)) {
        throw new Exception("Controlador no encontrado");
    }

    require_once $controlador;

    if (!class_exists($controladorclase)) {
        throw new Exception("Clase del controlador no encontrada");
    }

    $controladorInstanciado = new $controladorclase;

    if (!method_exists($controladorInstanciado, $accion)) {
        throw new Exception("Método no encontrado");
    }

    call_user_func([$controladorInstanciado, $accion]);

} catch (Exception $e) {
    header('Location: index.php?c=login&a=dashboard');
    exit;
}

?>
