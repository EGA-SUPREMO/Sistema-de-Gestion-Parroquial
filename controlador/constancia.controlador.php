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
}
