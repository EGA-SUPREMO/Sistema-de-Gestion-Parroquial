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
        require_once 'vistas/login.php';
    }

    public function procesarDatos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $password = $_POST['password'];

            $resultados_obtenido = $this->gestor->comprobar_datos_usuario($nombre_usuario, $password);
            if ($resultados_obtenido) {
                session_start();
                $_SESSION['nombre_usuario'] = $nombre_usuario;

                FuncionesComunes::redirigir("Location:?c=dashboard&a=index");
            }

            FuncionesComunes::redirigir("location:?c=login&a=index&error=". urlencode('Datos incorrectos. Por favor, inténtelo de nuevo.'));
        }
        FuncionesComunes::redirigir("location:?c=login&a=index");
    }

    public function cerrarSesion()
    {
        session_destroy();
        FuncionesComunes::redirigir('Location: index.php');
    }
}
