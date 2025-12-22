<?php

require_once 'modelo/EntidadFactory.php';
require_once 'modelo/FuncionesComunes.php';

class formularioControlador
{
    protected $gestor;
    protected $nombreTabla;
    protected $nombreControlador;
    protected $urlOperacionExitosa;

    public function __construct(PDO $pdo)
    {
        FuncionesComunes::requerirLogin();
        $this->nombreTabla = $_REQUEST['t'];
        $this->nombreControlador = $_REQUEST['c'];
        $this->gestor = EntidadFactory::crearGestor($pdo, $this->nombreTabla);
        $this->urlOperacionExitosa = 'Location:?c=panel&a=index&t='.$this->nombreTabla;
    }

    public function procesarFormulario()
    {
        try {
            $this->guardarDatos();
            if (isset($_SESSION['input_viejo'])) {
                unset($_SESSION['input_viejo']);
            }
            FuncionesComunes::redirigir($this->urlOperacionExitosa);
        } catch (Exception $e) {
            error_log($e->getMessage());

            $_SESSION['input_viejo'] = $_POST;
            $id = (int)($_POST[$this->gestor->getClavePrimaria()] ?? 0);

            $mensajeCodificado = urlencode($e->getMessage());
            FuncionesComunes::redirigir('Location:?c='.$this->nombreControlador.'&a=mostrar&t='.$this->nombreTabla.'&error='.$mensajeCodificado.'&id='.$id);
        }
    }

    public function mostrar()
    {
        $id = (int)($_REQUEST[$this->gestor->getClavePrimaria()] ?? 0);

        $datos_modelo = [];
        $nombre_usuario = '';
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);

        if (isset($_SESSION['input_viejo'])) {
            $datos_modelo = $_SESSION['input_viejo'];

            unset($_SESSION['input_viejo']);
        } elseif ($id > 0) {
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
            $modelo = $this->gestor->obtenerPorId($id);
            $datos_modelo = $modelo->toArrayParaMostrar("formulario");
        }

        $datos = [
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
                $datos[$campo] = FuncionesComunes::limpiarString($_POST[$campo]);
            }
        }
        $objeto = EntidadFactory::crearObjeto($this->nombreTabla);
        $objeto->hydrate($datos);

        $id = (int)($_POST[$this->gestor->getClavePrimaria()] ?? 0);

        $this->gestor->guardar($objeto, $id);
    }

}
