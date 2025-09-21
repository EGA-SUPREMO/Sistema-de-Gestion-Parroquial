<?php

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
        $objetoConstancia = null;
        try {
            $objetoConstancia = $this->guardarDatos();
        } catch (Exception $e) {
            error_log("Error guardando registro: " . $e->getMessage());
            $this->guardar("El registro no se guardó");
        }
        if ($objetoConstancia) {
            try {
                $rutaPdf = $this->servicio->generarPdf($objetoConstancia);
                FuncionesComunes::redirigir($rutaPdf);
            } catch (Exception $e) {
                error_log("Error generando PDF: " . $e->getMessage());
                $this->guardar("El registro se guardó, pero falló la creación del PDF.");// TODO ESTO NO DEBERIA PASAR BAJO NINGUN CASO
            }
        }
        $this->guardar("Error al guardar la constancia.");
    }

    protected function guardarDatos()
    {
        $objeto = EntidadFactory::crearObjeto($this->nombreTabla);

        $datosFormulario = $_POST;
        foreach ($datosFormulario as $campo => $valor) {
            if (is_string($valor)) {
                $datosFormulario[$campo] = htmlspecialchars(trim($valor));
            }
        }
        error_log(print_r($datosFormulario, true));

        $id = (int)($_POST['id'] ?? 0);
        $constancia = $this->servicio->registrarConstancia($datosFormulario);
        return $constancia;

        return false;
    }
}
