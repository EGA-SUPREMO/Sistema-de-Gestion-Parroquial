<?php

require_once 'modelo/GestorFactory.php';
require_once 'modelo/FuncionesComunes.php';

class PanelControlador
{
    private $gestor;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        $this->nombreTabla = $_REQUEST['t'];
        $this->gestor = GestorFactory::crearGestor($pdo, $this->nombreTabla);
    }
    public function index()
    {
        FuncionesComunes::requerirLogin();
        $modelos = $this->gestor->obtenerTodos();
        include_once 'vistas/tabla.php';
        require_once "controlador/tabla.php";
    }
}
