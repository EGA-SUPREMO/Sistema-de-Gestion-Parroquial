<?php

require_once "modelo/MetodosP.php";
session_start();

class MetodosPControlador
{
    private $model;

    public function __CONSTRUCT(PDO $pdo)
    {
        $this->model = new MetodoPago($pdo);
        $this->requerirLogin();
    }

    private function requerirLogin()
    {

        if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {

            header('Location: ?c=login&a=index&mensaje=no_autenticado');
            exit();
        }
    }




    public function Registro()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/metodosP/metodos_registrar.php';
    }

    public function Index()
    {
        $metodosPago = $this->model->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/metodosP/index.php';
    }


    public function Editar()
    {
        if (isset($_REQUEST['id'])) {
            $metodoPago = $this->model->obtenerPorId($_REQUEST['id']);
        }

        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/metodosP/actualizar_metodos.php';
    }


    public function Eliminar()
    {
        $this->model->eliminar($_REQUEST['id']);

        header('Location:?c=metodosP');
        exit();
    }

    public function Guardar()
    {
        $metodoPago = new MetodoPago();


        $metodoPago->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $metodoPago->nombre = $_REQUEST['nombre'];



        $this->model->agregar($metodoPago->nombre);

        header('Location: index.php?c=metodosP');
        exit();
    }



    public function actualizar()
    {
        $metodoPago = new MetodoPago();


        $metodoPago->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $metodoPago->nombre = $_REQUEST['nombre'];


        $this->model->actualizar($metodoPago->id, $metodoPago->nombre);

        header('Location: index.php?c=metodosP');
        exit();
    }
}
