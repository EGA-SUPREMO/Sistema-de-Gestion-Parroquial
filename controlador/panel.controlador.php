<?php

require_once 'modelo/GestorFactory.php';
require_once 'modelo/FuncionesComunes.php';

class formularioControlador
{
    private $gestor;
    private $nombreTabla;
    private $mapaDatos = [
        'administrador' => ['nombre_usuario', 'password'],
    ];

    public function __construct(PDO $pdo)
    {
        $this->nombreTabla = $_REQUEST['t'];
        $this->gestor = GestorFactory::crearGestor($pdo, $this->nombreTabla);
    }
    public function index()
    {
        FuncionesComunes::requerirLogin();
        include_once 'vistas/tabla.php';
        require_once "controlador/tabla.php";
    }
}
