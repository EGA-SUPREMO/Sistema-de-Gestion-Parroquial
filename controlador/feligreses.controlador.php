<?php

require_once "modelo/Feligres.php";

class feligresesControlador
{
    private $model;

    public function __CONSTRUCT(PDO $pdo)
    {
        $this->model = new Feligres($pdo);
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
        require_once 'vistas/feligreses/index.php';
    }

    public function Eliminar()
    {
        try {
            $this->model->eliminar($_REQUEST['id']);
        } catch (Exception $e) {
            error_log($e);
        }
        header('Location:?c=feligreses');
        exit();
    }

    public function Editar($errorMessage = null)
    {
        if (isset($_REQUEST['id'])) {
            $feligres = $this->model->obtenerPorId($_REQUEST['id']);
        }
        require_once 'vistas/feligreses/feligreses_actualizar.php';
    }


    public function Registro($errorMessage = null)
    {
        require_once "vistas/feligreses/feligreses_nuevo.php";
    }


    public function Guardar()
    {
        $datos = [
            'nombre' => htmlspecialchars(trim($_REQUEST['nombre'] ?? '')),
            'cedula' => (int)($_REQUEST['cedula'])
        ];

        if (empty($datos['nombre'])) {
            $this->Registro("Por favor introduzca un nombre");
            exit();
        }

        $resultado = $this->model->agregar($datos['nombre'], $datos['cedula']);
        if ($resultado) {
            header('Location: index.php?c=feligreses');
            exit();
        }

        $errorMessage = "Error: La cédula de identidad ya está registrada. Por favor, verifique los datos o intente con una cédula diferente.";
        $this -> Registro($errorMessage);
    }

    public function actualizar()
    {
        $datos = [
            'id' => (int)($_REQUEST['id']),
            'nombre' => htmlspecialchars(trim($_REQUEST['nombre'] ?? '')),
            'cedula' => (int)($_REQUEST['cedula'])
        ];

        if (empty($datos['nombre'])) {
            $this->Editar("Por favor introduzca un nombre");
            exit();
        }
        $resultado = $this->model->actualizar($datos['id'], $datos['nombre'], $datos['cedula']);
        if ($resultado) {
            header('Location: index.php?c=feligreses');
            exit();
        }

        $errorMessage = "Error: La cédula de identidad ya está registrada. Por favor, verifique los datos o intente con una cédula diferente.";
        $this -> Editar($errorMessage);
    }
}
