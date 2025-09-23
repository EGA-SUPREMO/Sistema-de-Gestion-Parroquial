<?php

require_once 'modelo/FuncionesComunes.php';
require_once 'controlador/formulario.controlador.php';

class constanciaControlador // extends formularioControlador
{
    private $servicio;
    private $gestor;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        $this->nombreTabla = $_REQUEST['t'];
        $this->servicio = EntidadFactory::crearServicio($pdo, $this->nombreTabla);
        $this->gestor = EntidadFactory::crearGestor($pdo, $this->nombreTabla);
    }

    public function guardar($errorMessage = null)
    {
        FuncionesComunes::requerirLogin();

        $id = (int)($_REQUEST['id'] ?? 0);

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

    public function guardarRegistro()
    {
        FuncionesComunes::requerirLogin();
        
        try {
            $rutaPdf = $this->guardarDatos();
            FuncionesComunes::redirigir('Location: ' . $rutaPdf);
        } catch (Exception $e) {
            error_log("Error generando PDF: " . $e->getMessage());
            $this->guardar("error.");
        }
    
        $this->guardar("Error al guardar la constancia.");
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
