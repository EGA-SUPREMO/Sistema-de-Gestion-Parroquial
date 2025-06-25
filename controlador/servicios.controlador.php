<?php

require_once "modelo/Servicio.php";
session_start();
class ServiciosControlador
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Servicio();
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
        $servicios = $this->model->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/servicios/index.php';
    }

    public function Registro()
    {
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/servicios/servicios_registro.php";
    }

   

    public function Editar()
    {
        $servicio = new Servicio();

        if (isset($_REQUEST['id'])) {
            $servicio = $this->model->obtenerPorId($_REQUEST['id']);
        }
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/servicios/servicios_actualizar.php';
    }

   

    public function Eliminar()
    {
        $this->model->eliminar($_REQUEST['id']);

        header('Location:?c=servicios');
    }

    public function actualizar()
    {
        $servicio = new Servicio();

        $servicio->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $servicio->nombre = $_REQUEST['nombre'];
        $servicio->descripcion = $_REQUEST['descripcion'];


        $this->model->actualizar($servicio->id, $servicio->nombre, $servicio->descripcion);

        header('Location: index.php?c=servicios');
    }

      public function Guardar()
    {
        $servicio = new Servicio();

        $servicio->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $servicio->nombre = $_REQUEST['nombre'];
        $servicio->descripcion = $_REQUEST['descripcion'];


        $this->model->agregar($servicio->nombre, $servicio->descripcion);

        header('Location: index.php?c=servicios');
    }
  
}
