<?php

require_once "modelo/peticiones.php";
require_once "modelo/Servicio.php";
require_once "modelo/Feligres.php";
session_start();

class PeticionesControlador
{
    private $model;
    private $model_servicio;
    private $model_feligres;

    public function __CONSTRUCT()
    {
        $this->model = new Peticion();
        $this->model_feligres = new Feligres();
        $this->model_servicio = new Servicio();
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
        $peticiones = $this->model->obtenerTodos();

        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/peticiones/index.php';
    }

    public function Registro()
    {
        $servicio = $this->model_servicio->obtenerTodos();
        $feligres = $this->model_feligres->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/peticiones/peticiones_registrar.php';
    }


    public function Editar()
    {
        $peticion = new Peticion();

        if (isset($_REQUEST['id'])) {
            $peticion = $this->model->obtenerPorId($_REQUEST['id']);
        }

        $servicio = $this->model_servicio->obtenerTodos();
        $feligres = $this->model_feligres->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/peticiones/peticiones_actualizar.php';
    }

    public function Eliminar()
    {
        $this->model->eliminar($_REQUEST['id']);

        header('Location:?c=peticiones');
    }


    public function Guardar()
    {
        $peticion = new Peticion();

        $peticion->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $peticion->feligres_id = $_REQUEST['feligres_id'];
        $peticion->servicio_id = $_REQUEST['servicio_id'];
        $peticion->descripcion = $_REQUEST['descripcion'];
        $peticion->fecha_registro = date('Y-m-d');
        $peticion->fecha_inicio = $_REQUEST['fecha_inicio'];
        $peticion->fecha_fin = $_REQUEST['fecha_fin'];


        $this->model->agregar(
            $peticion->feligres_id,
            $peticion->servicio_id,
            $peticion->descripcion,
            $peticion->fecha_registro,
            $peticion->fecha_inicio,
            $peticion->fecha_fin
        );

        header('Location: index.php?c=peticiones');
    }




    public function actualizar()
    {
        $peticion = new Peticion();

        $peticion->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $peticion->feligres_id = $_REQUEST['feligres_id'];
        $peticion->servicio_id = $_REQUEST['servicio_id'];
        $peticion->descripcion = $_REQUEST['descripcion'];
        $peticion->fecha_registro = $_REQUEST['fecha_registro'];
        $peticion->fecha_inicio = $_REQUEST['fecha_inicio'];
        $peticion->fecha_fin = $_REQUEST['fecha_fin'];

        $this->model->actualizar(
            $peticion->id,
            $peticion->feligres_id,
            $peticion->servicio_id,
            $peticion->descripcion,
            $peticion->fecha_registro,
            $peticion->fecha_inicio,
            $peticion->fecha_fin
        );

        header('Location: index.php?c=peticiones');
    }
}
