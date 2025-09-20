<?php

require_once 'controlador/formulario.controlador.php';

class constanciaControlador extends formularioControlador
{
    public function guardarRegistro()
    {
        FuncionesComunes::requerirLogin();

        $objetoConstancia = $this->guardarDatos();

        if ($objetoConstancia) {
            try {
                $rutaPdf = $this->gestor->generarPdf($objetoConstancia);
                FuncionesComunes::redirigir($rutaPdf);
            } catch (Exception $e) {
                error_log("Error generando PDF: " . $e->getMessage());
                $this->guardar("El registro se guardó, pero falló la creación del PDF.");
            }
        }
        $this->guardar("Error al guardar la constancia.");
    }

    protected function guardarDatos()
    {
        $objeto = EntidadFactory::crearObjeto($this->nombreTabla);
        $arrayBD = $objeto->toArrayParaBD(true);
        $camposEsperados = array_keys($arrayBD);

        $datos = [];
        foreach ($camposEsperados as $campo) {
            if (isset($_POST[$campo]) and $_POST[$campo] !== '') {
                $datos[$campo] = htmlspecialchars(trim($_POST[$campo]));
            }
        }
        try {
            $id = (int)($_POST[$this->gestor->getClavePrimaria()] ?? 0);

            if ($this->gestor->registrarConstancia($id, $datosFormulario)) {
                return false;
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }
}
