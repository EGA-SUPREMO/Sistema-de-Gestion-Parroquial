<?php

require_once 'modelo/GestorFactory.php';
require_once 'modelo/FuncionesComunes.php';

class formularioControlador
{
    private $gestor;
    private $nombreTabla;
    private $mapaDatos = [
        'administrador' => ['nombre_usuario', 'password'],
        'sacerdote' => ['nombre', 'vivo'],
        'feligres' => ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'fecha_nacimiento', 'cedula', 'partida_de_nacimiento'],
    ];

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

    public function guardarRegistro()
    {
        $this->requerirLogin();

        if (!array_key_exists($this->nombreTabla, $this->mapaDatos)) {
            throw new Exception("Tabla no válida: {$this->nombreTabla}");
        }
        $camposEsperados = $this->mapaDatos[$this->nombreTabla];

        $datos = [];
        foreach ($camposEsperados as $campo) {
            if (isset($_POST[$campo]) and $_POST[$campo] !== '') {
                $datos[$campo] = htmlspecialchars(trim($_POST[$campo]));
            }
        }
        try {
            $objeto = GestorFactory::crearObjeto($this->nombreTabla);
            $objeto->hydrate($datos);

            $id = (int)($_REQUEST[$this->gestor->getClavePrimaria()] ?? 0);
            $resultado = $this->gestor->guardar($objeto, $id);

            if (!$resultado) {
                $this->guardar("Error: Por favor, introduce datos válidos.");
                exit();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        header('Location:?c=login&a=mostrar');
        exit();
    }

    public function guardar($errorMessage = null)
    {
        $this->requerirLogin();

        $id = (int)($_REQUEST[$this->gestor->getClavePrimaria()] ?? 0);

        $nombre_usuario = '';
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
        if ($id > 0) {
            $admin = $this->gestor->obtenerPorId($id);
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);

            $nombre_usuario = $admin->getNombreUsuario();
        }

        $datos_formulario = [
            'primerElemento' => "#nombre_usuario",
            'id' => $id,
            'titulo' => $titulo,
            'nombre_usuario' => $nombre_usuario,
        ];

        $datos_formulario['formulario'] = json_encode($datos_formulario);

        require_once "vistas/administradores/administrador_registro.php";
        require_once "controlador/formulario.php";
    }

}
