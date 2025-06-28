<?php

$controladorNombre = strtolower(isset($_REQUEST['c']) ? $_REQUEST['c'] : 'login');
$accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';


$controlador = "controlador/{$controladorNombre}.controlador.php";
$controladorclase = ucwords($controladorNombre) . 'Controlador';


require_once $controlador;


$controladorInstanciado = new $controladorclase;


call_user_func([$controladorInstanciado, $accion]);

?>

