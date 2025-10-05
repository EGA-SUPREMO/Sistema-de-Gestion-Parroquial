<?php

require_once 'modelo/FuncionesComunes.php';
require_once 'modelo/Administrador.php';
require_once 'modelo/GestorAdministrador.php';

class loginControlador
{
    private $gestor;


    public function __construct(PDO $pdo)
    {
        $this->gestor = new GestorAdministrador($pdo);
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
        require_once 'vistas/login/login.php';
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre_usuario = $_POST['nombre_usuario'];
            $password = $_POST['password'];


            $resultados_obtenido = $this->gestor->comprobar_datos_usuario($nombre_usuario, $password);

            if ($resultados_obtenido) {
                session_start();
                $_SESSION['nombre_usuario'] = $nombre_usuario;

                FuncionesComunes::redirigir("Location:?c=dashboard&a=index");
            } else {
                FuncionesComunes::redirigir("location:?c=login&a=index&mensaje=invalido");
            }
        }
    }

    public function eliminar()
    {
        FuncionesComunes::requerirLogin();

        try {
            $this->gestor->eliminar($_POST['id_admin']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errorMessage = $e->getMessage();
            FuncionesComunes::redirigir('Location:?c=login&a=mostrar&mensaje=' . urlencode($errorMessage));
        }
        FuncionesComunes::redirigir('Location:?c=login&a=mostrar');
    }

    public function mostrar()
    {
        FuncionesComunes::requerirLogin();
        $administradores = $this->gestor->obtenerTodos();
        $errorMessage = $_GET['mensaje'] ?? null;
        require_once "vistas/administradores/index.php";
    }

    public function cerrarSesion()
    {
        session_destroy();
        FuncionesComunes::redirigir('Location: index.php');
    }
}
