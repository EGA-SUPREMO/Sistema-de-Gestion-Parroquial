<?php

require_once 'modelo/FuncionesComunes.php';
require_once 'controlador/formulario.controlador.php';

class constanciaControlador // extends formularioControlador
{
    private $servicio;
    private $gestor;
    private $gestorSacerdote;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        FuncionesComunes::requerirLogin();
        $this->nombreTabla = $_REQUEST['t'];
        $this->servicio = EntidadFactory::crearServicio($pdo, $this->nombreTabla);
        $this->gestor = EntidadFactory::crearGestor($pdo, $this->nombreTabla);
        $this->gestorSacerdote = EntidadFactory::crearGestor($pdo, 'sacerdote');
    }

    public function guardar($errorMessage = null)
    {
        $id = (int)($_REQUEST['id'] ?? 0);

        $datos_modelo = [];
        $datos_sacerdotes = [];
        $nombre_usuario = '';
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
        if ($id > 0) {
            $modelo = $this->gestor->obtenerPorId($id);
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);

            $datos_modelo = $modelo->toArrayParaBD();
        }
        $sacerdotes = [];
        $sacerdotes['sacerdotes'][] = ['id' => 0, 'nombre' => 'Escoge un sacerdote', 'vivo' => 0];
        $sacerdotes['sacerdotes_vivos'][] = ['id' => 0, 'nombre' => 'Escoge un sacerdote', 'vivo' => 0];

        foreach ($this->gestorSacerdote->obtenerTodos() as $sacerdote_objeto) {
            $sacerdotes['sacerdotes'][] = $sacerdote_objeto->toArrayParaMostrar();
            if ($sacerdote_objeto->getVivo()) {
                $sacerdotes['sacerdotes_vivos'][] = $sacerdote_objeto->toArrayParaMostrar();
            }
        }

        $datos = [
            'primerElemento' => "#nombre_usuario",
            'id' => $id,
            'titulo' => $titulo,
        ];
        $datos = array_merge($datos_modelo, $datos);
        $datos = array_merge($sacerdotes, $datos);
        $datos_formulario['formulario'] = json_encode($datos);

        require_once "vistas/formulario.php";
        require_once "controlador/formulario.php";
    }

    public function guardarRegistro()
    {
        try {
            $rutaPdf = $this->guardarDatos();
            FuncionesComunes::redirigir('Location: ' . $rutaPdf);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $mensajeCodificado = urlencode($e->getMessage());
            FuncionesComunes::redirigir('Location:?c=constancia&a=guardar&t='.$this->nombreTabla.'&error='.$mensajeCodificado.'&id='.$_REQUEST[$this->gestor->getClavePrimaria()]);
        }
    }

    protected function guardarDatos()
    {
        $objeto = EntidadFactory::crearObjeto($this->nombreTabla);

        $datosFormulario = $_POST;
        foreach ($datosFormulario as $campo => $valor) {
            if (is_string($valor)) {
                $datosFormulario[$campo] = FuncionesComunes::limpiarString($valor);
            }
        }

        $rutaPdf = $this->servicio->guardarConstancia($datosFormulario);
        return $rutaPdf;
    }
}
