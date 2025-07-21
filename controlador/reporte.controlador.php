<?php

class reporteControlador
{
    public function __construct()
    {
        $this->requerirLogin();
    }

    private function requerirLogin()
    {

        if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
            header('Location: ?c=login&a=index&mensaje=no_autenticado');
            exit();
        }
    }


    public function Index()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/selector/Selector_reporte.php';
    }
    public function acta_matrimonio()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/selector/matrimonio.php";
    }

    public function constancia_c()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/selector/Constancia_Primera_Comunion.php";
    }

    public function fe_bautizo()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/selector/fe_bautizo.php";
    }

    public function intenciones()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/selector/intenciones.php";
    }
}
