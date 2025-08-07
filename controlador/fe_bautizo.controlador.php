<?php

require_once "modelo/GeneradorPdf.php";
require_once "public/fpdf/fpdf.php";

class fe_bautizocontrolador
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


    public function fe_bautizo()
    {
        $nombreBautizado       = htmlspecialchars(trim($_POST["nombreBautizado"] ?? ''));
        $diaNacimiento         = $_POST["diaNacimiento"] ?? null;
        $mesNacimiento         = $_POST["mesNacimiento"] ?? null;
        $anoNacimiento         = $_POST["anoNacimiento"] ?? null;
        $lugarNacimiento       = $_POST["lugarNacimiento"] ?? null;
        $nombrePadre           = htmlspecialchars(trim($_POST["nombrePadre"] ?? ''));
        $nombreMadre           = htmlspecialchars(trim($_POST["nombreMadre"] ?? ''));
        $numeroLibro           = $_POST["numeroLibro"] ?? null;
        $folio                 = $_POST["folio"] ?? null;
        $numeroMarginal        = $_POST["numeroMarginal"] ?? null;
        $diaBautismo           = $_POST["diaBautismo"] ?? null;
        $mesBautismo           = $_POST["mesBautismo"] ?? null;
        $anoBautismo           = $_POST["anoBautismo"] ?? null;
        $nombreSacerdote       = htmlspecialchars(trim($_POST["nombreSacerdote"] ?? ''));
        $nombrePadrino         = htmlspecialchars(trim($_POST["nombrePadrino"] ?? ''));
        $nombreMadrina         = htmlspecialchars(trim($_POST["nombreMadrina"] ?? ''));
        $propositoCertificacion = htmlspecialchars(trim($_POST["propositoCertificacion"] ?? ''));
        $diaExpedicion         = $_POST["diaExpedicion"] ?? null;
        $mesExpedicion         = $_POST["mesExpedicion"] ?? null;
        $anoExpedicion         = $_POST["anoExpedicion"] ?? null;
        $notaMarginal          = $_POST["notaMarginal"] ?? null;


        if (empty($nombreBautizado) || empty($nombreMadre) || empty($nombrePadre) || empty($nombreMadrina) || empty($nombrePadrino) || empty($nombreSacerdote) || empty($lugarNacimiento) || empty($propositoCertificacion)|| empty($notaMarginal)) {
            header('Location:?c=reporte&a=fe_bautizo');
            exit();
        }

        GeneradorPdf::generarPdfBautizo(
            $nombreBautizado,
            $diaNacimiento,
            $mesNacimiento,
            $anoNacimiento,
            $lugarNacimiento,
            $nombrePadre,
            $nombreMadre,
            $numeroLibro,
            $folio,
            $numeroMarginal,
            $diaBautismo,
            $mesBautismo,
            $anoBautismo,
            $nombreSacerdote,
            $nombrePadrino,
            $nombreMadrina,
            $propositoCertificacion,
            $diaExpedicion,
            $mesExpedicion,
            $anoExpedicion,
            $notaMarginal
        );
    }

}
