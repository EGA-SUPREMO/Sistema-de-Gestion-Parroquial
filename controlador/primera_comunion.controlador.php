<?php

require_once "modelo/GeneradorPdf.php";
require_once "public/fpdf/fpdf.php";

class primera_comunioncontrolador
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


    public function comunion()
    {

        $constancia = $_POST["constancia"];

        $nombreCiudadano = htmlspecialchars(trim($_POST["nombreCiudadano"] ?? ''));
        $cedulaIdentidad = htmlspecialchars(trim($_POST["cedulaIdentidad"] ?? ''));
        $diaComunion     = $_POST["diaComunion"];
        $mesComunion     = $_POST["mesComunion"];
        $anoComunion     = $_POST["anoComunion"];
        $diaExpedicion   = $_POST["diaExpedicion"];
        $mesExpedicion   = $_POST["mesExpedicion"];
        $anoExpedicion   = $_POST["anoExpedicion"];

        if (empty($nombreCiudadano) || empty($cedulaIdentidad)) {
            header('Location:?c=reporte&a=constancia_c');
            exit();
        }
        // El switch ahora decide qué método de generación llamar.
        switch ($constancia) {
            case "primera_comunion":
                GeneradorPdf::generarPdfComunion(
                    $nombreCiudadano,
                    $cedulaIdentidad,
                    $diaComunion,
                    $mesComunion,
                    $anoComunion,
                    $diaExpedicion,
                    $mesExpedicion,
                    $anoExpedicion
                );
                break;
            default:
                echo "Error: Tipo de constancia no especificado.";
                break;
        }
    }



}
