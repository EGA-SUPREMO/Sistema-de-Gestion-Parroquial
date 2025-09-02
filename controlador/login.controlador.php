<?php

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
            $this->gestor->eliminar($_POST['id_admin']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errorMessage = $e->getMessage();
            header('Location:?c=login&a=mostrar&mensaje=' . urlencode($errorMessage));
            exit();
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }
    public function editar($errorMessage = null)
    {
        $this->requerirLogin();
        $admin = $this->gestor->obtenerPorId($_REQUEST['id_admin']);
        require_once "vistas/administradores/administrador_registro.php";
        ?>
        <script>
            const definicionFormulario = {
                action: 'index.php?c=login&a=actualizar',
                cancelarBtn: 'index.php?c=login&a=mostrar',
                contenedor: '#formulario-registrar-administrador',
                campos: [
                    { type: 'text', name: 'nombre', label: 'Nombre de Usuario' },
                    { type: 'password', name: 'password', label: 'Contraseña', placeholder: 'Deja este campo vacío si no deseas cambiar la contraseña.'},
                    { type: 'hidden', name: 'id_admin', value: 13},
                ]
            };

            document.addEventListener('DOMContentLoaded', () => {
                generarFormulario(definicionFormulario, 'Actualizar Administrador');
                $('#nombre').focus();
            });

        </script>
        <?php
    }


    public function mostrar()
    {

        $this->requerirLogin();
        $administradores = $this->gestor->obtenerTodos();
        $errorMessage = $_GET['mensaje'] ?? null;
        require_once "vistas/administradores/index.php";
    }


    public function actualizar()
    {
        $this->requerirLogin();

        $id_admin = (int)($_REQUEST['id_admin']);
        $nombre_usuario = htmlspecialchars(trim($_REQUEST['nombre'] ?? ''));
        $password = $_REQUEST['password'];

        if (empty($nombre_usuario)) {
            $this->editar("Por favor introduzca un nombre de usuario y contraseña valido.");
            exit();
        }

        try {
            $admin = new Administrador();

            $admin->setNombreUsuario($nombre_usuario);
            if (!empty($password)) {
                $admin->setPassword($password);
            }
            
            $resultado = $this->gestor->actualizar($id_admin, $admin);
            if (!$resultado) {
                $this->editar("Error: Por favor, introduce un nombre de usuario y contraseña válidos. Asegúrate de que el nombre de usuario no este repetido.");
                exit();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }

    public function Guardar()
    {
        $this->requerirLogin();

        $nombre_usuario = htmlspecialchars(trim($_REQUEST['nombre'] ?? ''));
        $password = $_REQUEST['password'];

        if (empty($nombre_usuario) || empty($password)) {
            $this->Registro("Por favor introduzca un nombre de usuario y contraseña valido.");
            exit();
        }
        try {
            $admin = new Administrador();

            $admin->setNombreUsuario($nombre_usuario);
            $admin->setPassword($password);

            $resultado = $this->gestor->insertar($admin);
            if (!$resultado) {
                $this->Registro("Error: Por favor, introduce un nombre de usuario y contraseña válidos. Asegúrate de que el nombre de usuario no este repetido.");
                exit();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }

    public function Registro($errorMessage = null)
    {
        $this->requerirLogin();

        require_once "vistas/administradores/administrador_registro.php";
        ?>
            <script>
                /*$.post('modelo/adminisrtrador_registrar.php', formData)
                    .done(function(data) {

                }*/
                
                const definicionFormulario = {
                    action: 'index.php?c=login&a=guardar',
                    cancelarBtn: 'index.php?c=login&a=mostrar',
                    contenedor: '#formulario-registrar-administrador',
                    campos: [
                        { type: 'text', name: 'nombre', label: 'Nombre de Usuario' },
                        { type: 'password', name: 'password', label: 'Contraseña' },
                    ]
                };

                document.addEventListener('DOMContentLoaded', () => {
                    generarFormulario(definicionFormulario, 'Registrar Administrador');
                    $('#nombre').focus();
                });

            </script>
        <?php
    }

    public function cerrarSesion()
    {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
