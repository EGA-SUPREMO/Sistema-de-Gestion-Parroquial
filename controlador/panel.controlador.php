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
        $datos = [];

        if (!empty($modelos)) {
            foreach ($modelos as $modelo) {
                $datos[] = $modelo->toArrayParaMostrar();
            }
            $datos_tabla = [
                'datos'  => $datos,
                'campos' => array_keys($datos[0])
            ];

            $datos_tabla = json_encode($datos_tabla);
        }
        include_once 'vistas/panel.php';
        require_once "controlador/panel.php";
    }
}
