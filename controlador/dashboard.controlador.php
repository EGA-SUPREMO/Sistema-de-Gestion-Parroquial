<?php

require_once 'modelo/FuncionesComunes.php';

class DashboardControlador
{
    public function index()
    {
        FuncionesComunes::requerirLogin();
        require_once "vistas/dashboard/index.php";
    }
    public function administracion()
    {
        FuncionesComunes::requerirLogin();
        require_once "vistas/dashboard/administracion.php";
    }
    public function constancias()
    {
        FuncionesComunes::requerirLogin();
        require_once 'vistas/dashboard/constancias.php';
    }
}
