<?php

require_once 'modelo/FuncionesComunes.php';
require_once 'controlador/formulario.controlador.php';

class constanciaControlador // extends formularioControlador
{
    private $servicio;
    private $gestor;
    private $gestorSacerdote;
    private $gestorFeligres;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        FuncionesComunes::requerirLogin();
        $this->nombreTabla = $_REQUEST['t'];
        $this->servicio = EntidadFactory::crearServicio($pdo, $this->nombreTabla);
        $this->gestor = EntidadFactory::crearGestor($pdo, $this->nombreTabla);
        $this->gestorSacerdote = EntidadFactory::crearGestor($pdo, 'sacerdote');
        $this->gestorFeligres = EntidadFactory::crearGestor($pdo, 'feligres');
    }

    public function mostrar()
    {
        $id = (int)($_REQUEST['id'] ?? 0);

        $datos_modelo = [];
        $datos_modelo['feligres'] = null;
        $datos_modelo['padre'] = null;
        $datos_modelo['madre'] = null;
        $datos_sacerdotes = [];
        $titulo = "Registrar " . FuncionesComunes::formatearTitulo($this->nombreTabla);

        if (isset($_SESSION['input_viejo'])) {
            $datos_modelo = $_SESSION['input_viejo'];

            unset($_SESSION['input_viejo']);
        } elseif ($id > 0) {
            $titulo = "Editar " . FuncionesComunes::formatearTitulo($this->nombreTabla);
            $modelo = $this->gestor->obtenerPorId($id);
            $datos_modelo = $modelo->toArrayParaBD();
            $feligresBautizado = $this->gestorFeligres->obtenerPorId($modelo->getFeligresBautizadoId());
            $padre = $this->gestorFeligres->obtenerPorId($modelo->getPadreId());
            $madre = $this->gestorFeligres->obtenerPorId($modelo->getMadreId());
            $datos_modelo['feligres'] = $feligresBautizado->toArrayParaBD();
            $datos_modelo['padre'] = $padre->toArrayParaBD();
            $datos_modelo['madre'] = $madre->toArrayParaBD();
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
            'id' => $id,
            'titulo' => $titulo,
        ];
        $datos = array_merge($datos_modelo, $datos);
        $datos = array_merge($sacerdotes, $datos);
        $datos_formulario['formulario'] = json_encode($datos);

        require_once "vistas/formulario.php";
        require_once "controlador/formulario.php";
    }

    public function procesarFormulario()
    {
        try {
            $rutaPdf = $this->guardarDatos();

            if (isset($_SESSION['input_viejo'])) {
                unset($_SESSION['input_viejo']);
            }
            FuncionesComunes::redirigir('Location: ' . $rutaPdf);
        } catch (Exception $e) {
            error_log($e->getMessage());

            $_SESSION['input_viejo'] = $_POST;
            $id = (int)($_POST[$this->gestor->getClavePrimaria()] ?? 0);

            $mensajeCodificado = urlencode($e->getMessage());
            FuncionesComunes::redirigir('Location:?c=constancia&a=mostrar&t='.$this->nombreTabla.'&error='.$mensajeCodificado.'&id='.$id);
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
