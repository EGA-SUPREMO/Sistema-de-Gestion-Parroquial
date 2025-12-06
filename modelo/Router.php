<?php

class Router
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function despachar()
    {
        $cNombre = strtolower($_REQUEST['c'] ?? 'login');
        $accion  = $_REQUEST['a'] ?? 'index';

        $archivoControlador = "controlador/{$cNombre}.controlador.php";
        $claseControlador   = ucwords($cNombre) . 'Controlador';

        try {
            if (!file_exists($archivoControlador)) {
                throw new Exception("Router: Controlador '$cNombre' no encontrado.");
            }

            require_once $archivoControlador;

            if (!class_exists($claseControlador)) {
                throw new Exception("Router: Clase '$claseControlador' no encontrada.");
            }

            $instancia = new $claseControlador($this->pdo);

            if (!method_exists($instancia, $accion)) {
                throw new Exception("Router: Método '$accion' no encontrado en '$claseControlador'.");
            }

            require_once "vistas/cabezera.php";

            if (!($cNombre === 'login' && $accion === 'index')) {
                require_once "vistas/menu.php";
            }

            call_user_func([$instancia, $accion]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            require_once 'modelo/FuncionesComunes.php';
            $mensaje = urlencode($e->getMessage());
            FuncionesComunes::redirigir('Location: index.php?c=dashboard&a=index&error=' . $mensaje);
        }
    }
}
