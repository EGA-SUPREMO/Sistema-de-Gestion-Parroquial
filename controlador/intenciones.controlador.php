<?php

require_once "modelo/GeneradorPdf.php";
require_once "public/fpdf/fpdf.php";

class IntencionesControlador
{


    public function __construct()
    {
        $this->requerirLogin();
    }

    private function requerirLogin()
    {

        if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {

            header('Location: ?c=login&a=index&mensaje=no_autenticado');
            exit();
        }
    }


    public function generar()
    {

        $plantilla = $_POST["plantilla"] ?? null;
        $accionDeGracias = htmlspecialchars(trim($_POST["acciondegracias"] ?? ''));
        $salud = htmlspecialchars(trim($_POST["salud"] ?? ''));
        $aniversarios = htmlspecialchars(trim($_POST["aniversarios"] ?? ''));
        $difunto = htmlspecialchars(trim($_POST["difunto"] ?? ''));

        if (empty($accionDeGracias) || empty($salud) || empty($aniversarios) || empty($difunto)) {
            header('Location:?c=reporte&a=intenciones');
            exit();
        }
        
        if ($plantilla === "intenciones") {

            GeneradorPdf::generarPdfIntenciones(
                $accionDeGracias,
                $salud,
                $aniversarios,
                $difunto
            );
        } else {
            echo "Error: Tipo de plantilla no especificado o incorrecto.";
        }
    }


}
