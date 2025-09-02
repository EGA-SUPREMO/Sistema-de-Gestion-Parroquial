<?php

require_once 'modelo/GestorFactory.php';
require_once 'modelo/FuncionesComunes.php';

class formularioControlador
{
    private $gestor;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        $this->nombreTabla = $_REQUEST['t'];
        $this->gestor = GestorFactory::crearGestor($pdo, $this->nombreTabla);
    }

    private function requerirLogin()
    {
        if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
            header('Location: ?c=login&a=index&mensaje=no_autenticado');
            exit();
        }
    }

    public function editar($errorMessage = null)
    {
        $this->requerirLogin();
        $admin = $this->gestor->obtenerPorId($_REQUEST[$this->gestor->getClavePrimaria()]);
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

    public function actualizar()
    {
        $this->requerirLogin();

        $id_admin = (int)($_REQUEST[$this->gestor->getClavePrimaria()]);
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

    public function guardar1()
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

        $datos_formulario = [
            'primerElemento' => "#nombre",
            'titulo' => "Registrar Administrador",
        ];

        $datos_formulario['formulario'] = json_encode($datos_formulario);

        require_once "vistas/administradores/administrador_registro.php";
        require_once "controlador/formulario.php";
    }

    public function guardar($errorMessage = null)
    {
        $this->requerirLogin();

        $id_admin = (int)($_REQUEST[$this->gestor->getClavePrimaria()] ?? 0);

        $nombre_usuario = '';
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
        if ($id_admin > 0) {
            $admin = $this->gestor->obtenerPorId($id_admin);
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
            
            $nombre_usuario = $admin->getNombreUsuario();
        }

        $datos_formulario = [
            'primerElemento' => "#nombre",
            'id_admin' => $id_admin,
            'titulo' => $titulo,
            'nombre' => $nombre_usuario,
        ];

        $datos_formulario['formulario'] = json_encode($datos_formulario);

        require_once "vistas/administradores/administrador_registro.php";
        require_once "controlador/formulario.php";
    }

}
