<?php

require_once 'modelo/EntidadFactory.php';
require_once 'modelo/FuncionesComunes.php';

class PanelControlador
{
    private $gestor;
    private $nombreTabla;

    public function __construct(PDO $pdo)
    {
        FuncionesComunes::requerirLogin();
        $this->nombreTabla = $_REQUEST['t'];
        $this->gestor = EntidadFactory::crearGestor($pdo, $this->nombreTabla);
    }

    public function intenciones()
    {
        include_once 'vistas/intenciones.php';
    }

    public function index()
    {
        $modelos = $this->gestor->obtenerTodos();
        $datos = [];
        $datos_tabla = [];

        if (!empty($modelos)) {
            foreach ($modelos as $modelo) {
                $datos[] = $modelo->toArrayParaMostrar();
            }

            $campos = array_keys($datos[0]);
            $campos_formateados = $campos;
            foreach ($campos_formateados as $llave => $campo) {
                $campoConEspacios = str_replace('_', ' ', $campo);
                $palabrasCapitalizadas = ucwords($campoConEspacios);
                $campos_formateados[$llave] = $palabrasCapitalizadas;
            }

            $datos_tabla = [
                'datos'  => $datos,
                'campos_formateados'      => $campos_formateados,
                'campos'                  => $campos,
            ];
        }
        $datos_tabla['nombre_tabla_formateado'] = FuncionesComunes::formatearTitulo($this->nombreTabla);

        $datos_tabla = json_encode($datos_tabla);
        include_once 'vistas/panel.php';
        require_once "controlador/panel.php";
    }

    public function eliminar()
    {
        try {
            $this->gestor->eliminar($_POST[$this->gestor->getClavePrimaria()]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errorMessage = $e->getMessage();
            FuncionesComunes::redirigir('Location:?c=panel&a=index&t='.$this->nombreTabla.'&mensaje=' . urlencode($errorMessage));
        }
        FuncionesComunes::redirigir('Location:?c=panel&a=index&t='.$this->nombreTabla);
    }
}
