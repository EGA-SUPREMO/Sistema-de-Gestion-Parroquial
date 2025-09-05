<?php

require_once 'modelo/FuncionesComunes.php';

class reporteControlador
{
    public function __construct()
    {
        FuncionesComunes::requerirLogin();
    }

    public function acta_matrimonio()
    {
        require_once "vistas/selector/matrimonio.php";
    }

    public function constancia_c()
    {
        require_once "vistas/selector/Constancia_Primera_Comunion.php";
    }

    public function fe_bautizo()
    {
        require_once "vistas/selector/fe_bautizo.php";
    }

    public function intenciones()
    {
        require_once "vistas/selector/intenciones.php";
    }
}
