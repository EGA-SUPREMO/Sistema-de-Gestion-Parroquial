<?php

require_once "modelo/peticiones.php";
require_once "modelo/Servicio.php";
require_once "modelo/Feligres.php";
require_once "modelo/Validador.php";
session_start();

class PeticionesControlador
{
    private $model;
    private $model_servicio;
    private $model_feligres;

    public function __CONSTRUCT(PDO $pdo)
    {
        $this->model = new Peticion($pdo);
        $this->model_feligres = new Feligres($pdo);
        $this->model_servicio = new Servicio($pdo);
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

    public function Registro($errorMessage = null)
    {
        $servicio = $this->model_servicio->obtenerTodos();
        $feligres = $this->model_feligres->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/peticiones/peticiones_registrar.php';
    }


    public function Editar($errorMessage = null)
    {
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
        exit();
    }


    public function Guardar()
    {        
        $feligres_id = (int)($_REQUEST['feligres_id'] ?? 0);
        $servicio_id = (int)($_REQUEST['servicio_id'] ?? 0);
        $descripcion = htmlspecialchars(trim($_REQUEST['descripcion'] ?? ''));
        $fecha_registro = $_REQUEST['fecha_registro'] ?? '';
        $fecha_inicio = $_REQUEST['fecha_inicio'] ?? '';
        $fecha_fin = $_REQUEST['fecha_fin'] ?? '';

        if (empty($descripcion)) {
            $this->Registro("Por favor introduce una descripcion.");
            exit();
        }

        $es_fecha_valida = Validador::validarRangoFechas($fecha_inicio, $fecha_fin);
        
        if ($es_fecha_valida) {
            $resultado = $this->model->agregar(
                $feligres_id,
                $servicio_id,
                $descripcion,
                $fecha_registro,
                $fecha_inicio,
                $fecha_fin
                );
            if ($resultado) {
                header('Location: index.php?c=peticiones');
                exit();
            }
        }
        $errorMessage = "La 'Fecha de Fin' no puede ser anterior a la 'Fecha de Inicio'";
        $this -> Registro($errorMessage);
    }

    public function actualizar()
    {
        $id = (int)($_REQUEST['id'] ?? 0);
        $feligres_id = (int)($_REQUEST['feligres_id'] ?? 0);
        $servicio_id = (int)($_REQUEST['servicio_id'] ?? 0);
        $descripcion = htmlspecialchars(trim($_REQUEST['descripcion'] ?? ''));
        $fecha_registro = $_REQUEST['fecha_registro'] ?? '';
        $fecha_inicio = $_REQUEST['fecha_inicio'] ?? '';
        $fecha_fin = $_REQUEST['fecha_fin'] ?? '';

        if (empty($descripcion)) {
            $this->Editar("Por favor introduce una descripcion.");
            exit();
        }

        $es_fecha_valida = Validador::validarRangoFechas($fecha_inicio, $fecha_fin);
        
        if ($es_fecha_valida) {

            $this->model->actualizar(
                $id,
                $feligres_id,
                $servicio_id,
                $descripcion,
                $fecha_registro,
                $fecha_inicio,
                $fecha_fin
            );

            if ($resultado) {
                header('Location: index.php?c=peticiones');
                exit();
            }
        }
        $errorMessage = "La 'Fecha de Fin' no puede ser anterior a la 'Fecha de Inicio'";
        $this -> Editar($errorMessage);
    }
}
