<?php
require_once 'modelo/App.php';
require_once 'modelo/Router.php';

App::iniciar();
$pdo = App::obtenerConexion();

$router = new Router($pdo);
$router->despachar();
