<?php

require_once "modelo/Pagos.php";
require_once "modelo/MetodosP.php";
require_once "modelo/Feligres.php";
require_once "modelo/peticiones.php";
session_start();

class pagosControlador
{
    private $model;
    private $model_feligres;
    private $model_peticiones;
    private $model_metodos;

    public function __CONSTRUCT(PDO $pdo)
    {
        $this->model = new Pago($pdo);
        $this->model_feligres = new Feligres($pdo);
        $this->model_peticiones = new peticion($pdo);
        $this->model_metodos = new MetodoPago($pdo);
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
        $pagos = $this->model->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/pagos/index.php';
    }

    public function Registro()
    {
        $feligres = $this->model_feligres->obtenerTodos();
        $peticion = $this->model_peticiones->obtenerTodos();
        $metodos = $this->model_metodos->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/pagos/pagos_registrar.php";
    }


    public function Editar()
    {
        if (isset($_REQUEST['id'])) {
            $pago = $this->model->obtenerPorId($_REQUEST['id']);
        }

        $feligres = $this->model_feligres->obtenerTodos();
        $peticion = $this->model_peticiones->obtenerTodos();
        $metodos = $this->model_metodos->obtenerTodos();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once 'vistas/pagos/pagos_actualizar.php';
    }


    public function Guardar()
    {
        $peticion_id     = (int)($_REQUEST['peticion_id'] ?? 0);
        $feligres_id     = (int)($_REQUEST['feligres_id'] ?? 0);
        $metodo_pago_id  = (int)($_REQUEST['metodo_pago_id'] ?? 0);
        $monto_usd       = (float)($_REQUEST['monto_usd'] ?? -1.0);
        $fecha_pago      = $_REQUEST['fecha_pago'] ?? '';
        $referencia_pago = htmlspecialchars(trim($_REQUEST['referencia_pago'] ?? ''));

        if ($monto_usd < 0) {
            $this -> Registro();
            exit();
        }

        $this->model->agregar(
            $peticion_id,
            $feligres_id,
            $metodo_pago_id,
            $monto_usd,
            $referencia_pago,
            $fecha_pago
        );        
        header('Location: index.php?c=pagos');
        exit();

    }


    public function Eliminar()
    {
        $this->model->eliminar($_REQUEST['id']);

        header('Location:?c=pagos');
        exit();
    }

    public function actualizar()
    {
        $id              = (int)($_REQUEST['id'] ?? 0);
        $peticion_id     = (int)($_REQUEST['peticion_id'] ?? 0);
        $feligres_id     = (int)($_REQUEST['feligres_id'] ?? 0);
        $metodo_pago_id  = (int)($_REQUEST['metodo_pago_id'] ?? 0);
        $monto_usd       = (float)($_REQUEST['monto_usd'] ?? -1.0);
        $fecha_pago      = $_REQUEST['fecha_pago'] ?? '';
        $referencia_pago = htmlspecialchars(trim($_REQUEST['referencia_pago'] ?? ''));

        if ($monto_usd < 0) {
            $this -> Editar();
            exit();
        }

        $this->model->actualizar(
            $id,
            $peticion_id,
            $feligres_id,
            $metodo_pago_id,
            $monto_usd,
            $referencia_pago,
            $fecha_pago
        );

        header('Location: index.php?c=pagos');
        exit();
    }
}
