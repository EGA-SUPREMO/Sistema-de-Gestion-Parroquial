<?php

require_once 'modelo/administrador.php';

class loginControlador
{
    private $modelo;


    public function __construct(PDO $pdo)
    {
        $this->modelo = new administrador($pdo);
    }


    public function index()
    {
        $errorMessage = '';
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] === 'invalido') {
                $errorMessage = 'Datos incorrectos. Por favor, inténtelo de nuevo.';
            } elseif ($_GET['mensaje'] === 'no_autenticado') {
                $errorMessage = 'Necesitas iniciar sesión para acceder a esta página';
            }
        }
        require_once "vistas/cabezera.php";
        require_once 'vistas/login/login.php';
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre_usuario = $_POST['nombre_usuario'];
            $password = $_POST['password'];


            $resultados_obtenido = $this->modelo->comprobar_datos_usuario($nombre_usuario, $password);

            if ($resultados_obtenido) {
                session_start();
                $_SESSION['nombre_usuario'] = $nombre_usuario;

                header("Location:?c=login&a=dashboard");
                exit();
            } else {

                header("location:?c=login&a=index&mensaje=invalido");
                exit();
            }
        }
    }

    public function dashboard()
    {
        $this->requerirLogin();
        require_once "vistas/cabezera.php";
        require_once "vistas/login/dashboard.php";
    }



    private function requerirLogin()
    {
        if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
            header('Location: ?c=login&a=index&mensaje=no_autenticado');
            exit();
        }
    }

    public function eliminar()
    {
        $this->requerirLogin();

        try {
            $this->modelo->eliminar($_REQUEST['id_admin']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errorMessage = $e->getMessage();
            header('Location:?c=login&a=mostrar&mensaje=' . urlencode($errorMessage));
            exit();
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }
    public function editar()
    {
        $this->requerirLogin();
        $admin = $this->modelo->obtenerPorId($_GET['id_admin']);
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/administradores/administrador_actualizar.php";
    }


    public function mostrar()
    {

        $this->requerirLogin();
        $administradores = $this->modelo->obtenerTodos();
        $errorMessage = $_GET['mensaje'] ?? null;
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/administradores/index.php";
    }


    public function actualizar()
    {
        $this->requerirLogin();

        $id_admin = (int)($_REQUEST['id_admin']);
        $nombre_usuario = htmlspecialchars(trim($_REQUEST['nombre_usuario'] ?? ''));
        $password = $_REQUEST['password'];

        if (empty($nombre_usuario) || empty($password)) {
            $this->editar();
            exit();
        }

        try {
            $this->modelo->editar($id_admin, $nombre_usuario, $password);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }

    public function Guardar()
    {
        $this->requerirLogin();

        $nombre_usuario = htmlspecialchars(trim($_REQUEST['nombre_usuario'] ?? ''));
        $password = $_REQUEST['password'];

        if (empty($nombre_usuario) || empty($password)) {
            $this->Registro();
            exit();
        }
        try {
            $this->modelo->agregar($nombre_usuario, $password);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }

    public function Registro()
    {
        $this->requerirLogin();
        require_once "vistas/cabezera.php";
        require_once "vistas/menu.php";
        require_once "vistas/administradores/administrador_registro.php";
    }

    public function cerrarSesion()
    {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
