<?php

require_once "modelo/Feligres.php";
session_start();

class feligresesControlador
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Feligres();
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

        $feligreses = $this->model->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/feligreses/index.php';
    }

    public function Eliminar()
    {

        try {
            $this->model->eliminar($_REQUEST['id']);


            header('Location:?c=feligreses');
        } catch (Exception $e) {
            header('Location:?c=feligreses');
        }
    }

    public function Editar()
    {
        $feligres = new Feligres();


        if (isset($_REQUEST['id'])) {

            $feligres = $this->model->obtenerPorId($_REQUEST['id']);
        }
        require_once "vistas/cabezera.php";

        require_once "vistas/menu.php";
        require_once 'vistas/feligreses/feligreses_actualizar.php';
    }


    public function Registro()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";

        require_once "vistas/feligreses/feligreses_nuevo.php";
    }


    public function Guardar()
    {
        $feligres = new Feligres();


        $feligres->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $feligres->nombre = $_REQUEST['nombre'];
        $feligres->cedula = $_REQUEST['cedula'];


        $this->model->agregar($feligres->nombre, $feligres->cedula);

        header('Location: index.php?c=feligreses');
    }




    public function actualizar()
    {

        $feligres = new Feligres();


        $feligres->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $feligres->nombre = $_REQUEST['nombre'];
        $feligres->cedula = $_REQUEST['cedula'];
        $this->model->actualizar($feligres->id, $feligres->nombre, $feligres->cedula);

        header('Location: index.php?c=feligreses');
    }
}
