<?php

require_once 'modelo/EntidadFactory.php';
require_once 'modelo/FuncionesComunes.php';

class formularioControlador
{
    private $gestor;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        $this->nombreTabla = $_REQUEST['t'];
        $this->gestor = EntidadFactory::crearGestor($pdo, $this->nombreTabla);
    }

    public function guardarRegistro()
    {
        FuncionesComunes::requerirLogin();

        $resultado = $this->guardarDatos();
        if ($resultado) {
            $this->guardar("Error: Por favor, introduce datos válidos.");
            exit();
        }
        FuncionesComunes::redirigir('Location:?c=panel&a=index&t='.$this->nombreTabla);
    }

    public function guardar($errorMessage = null)
    {
        FuncionesComunes::requerirLogin();
        $id = (int)($_REQUEST[$this->gestor->getClavePrimaria()] ?? 0);

        $datos_modelo = [];
        $nombre_usuario = '';
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
        if ($id > 0) {
            $modelo = $this->gestor->obtenerPorId($id);
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);

            $datos_modelo = $modelo->toArrayParaBD();
        }

        $datos = [
            'primerElemento' => "#nombre_usuario",
            'id' => $id,
            'titulo' => $titulo,
        ];
        $datos = array_merge($datos_modelo, $datos);
        $datos_formulario['formulario'] = json_encode($datos);

        require_once "vistas/formulario.php";
        require_once "controlador/formulario.php";
    }

    protected function guardarDatos()
    {
        $objeto = EntidadFactory::crearObjeto($this->nombreTabla);
        $arrayBD = $objeto->toArrayParaBD(true);
        $camposEsperados = array_keys($arrayBD);

        $datos = [];
        foreach ($camposEsperados as $campo) {
            if (isset($_POST[$campo]) and $_POST[$campo] !== '') {
                $datos[$campo] = FuncionesComunes::limpiarString($_POST[$campo]));
            }
        }
        try {
            $objeto = EntidadFactory::crearObjeto($this->nombreTabla);
            $objeto->hydrate($datos);

            $id = (int)($_POST[$this->gestor->getClavePrimaria()] ?? 0);

            if ($this->gestor->guardar($objeto, $id)) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }

}
