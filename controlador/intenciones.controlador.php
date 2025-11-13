<?php

require_once 'controlador/formulario.controlador.php';
require_once 'modelo/EntidadFactory.php';
require_once 'modelo/FuncionesComunes.php';

class intencionesControlador extends formularioControlador
{
    private $servicio;
    private $gestorObjetoDePeticion;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->servicio = EntidadFactory::crearServicio($pdo, $this->nombreTabla);
        $this->gestorObjetoDePeticion = EntidadFactory::crearGestor($pdo, 'objeto_de_peticion');
    }

    public function mostrar()
    {
        $id = (int)($_REQUEST[$this->gestor->getClavePrimaria()] ?? 0);

        $datos_modelo = [];
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);

        if (isset($_SESSION['input_viejo'])) {
            $datos_modelo = $_SESSION['input_viejo'];

            unset($_SESSION['input_viejo']);
        } elseif ($id > 0) {
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
            $modelo = $this->gestor->obtenerPorId($id);
            $datos_modelo = $modelo->toArrayParaBD();
            $datos_modelo['objeto_de_peticion_nombre'] = $this->gestorObjetoDePeticion->obtenerPorId($modelo->getObjetoDePeticionId())->getNombre();
        }
        $datos_objetos_de_peticion = [];
        foreach ($this->gestorObjetoDePeticion->obtenerTodos() as $objeto_de_peticion) {
            $datos_objetos_de_peticion['objeto_de_peticion'][] = $objeto_de_peticion->getNombre();
        }

        $datos = [
            'id' => $id,
            'titulo' => $titulo,
        ];
        $datos = array_merge($datos_objetos_de_peticion, $datos);
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
        $camposEsperados[] = 'objeto_de_peticion_nombre';

        $datos = [];
        foreach ($camposEsperados as $campo) {
            if (isset($_POST[$campo]) and $_POST[$campo] !== '') {
                $datos[$campo] = FuncionesComunes::limpiarString($_POST[$campo]);
            }
        }
        $objeto = EntidadFactory::crearObjeto($this->nombreTabla);
        $objeto->hydrate($datos);
        $objeto->setObjetoDePeticionNombre($datos['objeto_de_peticion_nombre']);

        $id = (int)($_POST[$this->gestor->getClavePrimaria()] ?? 0);

        $this->servicio->guardar($objeto, $id);
    }

}
