<?php

require_once "modelo/Servicio.php";

class ServiciosControlador
{
    private $model;

    public function __CONSTRUCT(PDO $pdo)
    {
        $this->model = new Servicio($pdo);
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

        require_once 'vistas/servicios/index.php';
    }

    public function Registro()
    {
        require_once "vistas/servicios/servicios_registro.php";
    }



    public function Editar()
    {
        if (isset($_REQUEST['id'])) {
            $servicio = $this->model->obtenerPorId($_REQUEST['id']);
        }

        require_once 'vistas/servicios/servicios_actualizar.php';
    }



    public function Eliminar()
    {
        $this->model->eliminar($_REQUEST['id']);

        header('Location:?c=servicios');
        exit();
    }

    public function actualizar()
    {
        $datos = [
            'id'          => isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0,
            'nombre'      => htmlspecialchars(trim($_REQUEST['nombre'] ?? '')),
            'descripcion' => htmlspecialchars(trim($_REQUEST['descripcion'] ?? '')),
        ];

        if (empty($datos['nombre']) || empty($datos['descripcion'])) {
            $this->Editar();
            exit();
        }

        $this->model->actualizar($datos['id'], $datos['nombre'], $datos['descripcion']);
        header('Location: index.php?c=servicios');
        exit();
    }

    public function Guardar()
    {
        $datos = [
            'nombre'      => htmlspecialchars(trim($_REQUEST['nombre'] ?? '')),
            'descripcion' => htmlspecialchars(trim($_REQUEST['descripcion'] ?? '')),
        ];

        if (empty($datos['nombre']) || empty($datos['descripcion'])) {
            $this->Registro();
            exit();
        }

        $this->model->agregar($datos['nombre'], $datos['descripcion']);

        header('Location: index.php?c=servicios');
        exit();
    }

}
