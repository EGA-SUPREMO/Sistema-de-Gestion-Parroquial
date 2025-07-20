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

    public function __CONSTRUCT()
    {
        $this->model = new Pago();
        $this->model_feligres = new Feligres();
        $this->model_peticiones = new peticion();
        $this->model_metodos = new MetodoPago();
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
        $pago = new Pago();

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
        $pago = new Pago();

        $pago->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $pago->peticion_id = $_REQUEST['peticion_id'];
        $pago->feligres_id = $_REQUEST['feligres_id'];
        $pago->metodo_pago_id = $_REQUEST['metodo_pago_id'];
        $pago->monto_usd = $_REQUEST['monto_usd'];
        $pago->referencia_pago = $_REQUEST['referencia_pago'];
        $pago->fecha_pago = $_REQUEST['fecha_pago'];


        if ($pago->id > 0) {
            $this->model->actualizar(
                $pago->id,
                $pago->peticion_id,
                $pago->feligres_id,
                $pago->metodo_pago_id,
                $pago->monto_usd,
                $pago->referencia_pago,
                $pago->fecha_pago
            );
        } else {
            $this->model->agregar(
                $pago->peticion_id,
                $pago->feligres_id,
                $pago->metodo_pago_id,
                $pago->monto_usd,
                $pago->referencia_pago,
                $pago->fecha_pago
            );
        }

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
        $pago = new Pago();

        $pago->id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $pago->peticion_id = $_REQUEST['peticion_id'];
        $pago->feligres_id = $_REQUEST['feligres_id'];
        $pago->metodo_pago_id = $_REQUEST['metodo_pago_id'];
        $pago->monto_usd = $_REQUEST['monto_usd'];
        $pago->referencia_pago = $_REQUEST['referencia_pago'];
        $pago->fecha_pago = $_REQUEST['fecha_pago'];

        $this->model->actualizar(
            $pago->id,
            $pago->peticion_id,
            $pago->feligres_id,
            $pago->metodo_pago_id,
            $pago->monto_usd,
            $pago->referencia_pago,
            $pago->fecha_pago
        );

        header('Location: index.php?c=pagos');
        exit();
    }
}
