<?php

require_once "modelo/GeneradorPdf.php";
require_once "public/fpdf/fpdf.php";

class matrimoniocontrolador
{
    private $model;

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


    public function matrimonio()
    {
        $constancia = isset($_POST["constancia"]) ? $_POST["constancia"] : '';

        $nombreContrayente1 = htmlspecialchars(trim($_POST["nombreContrayente1"] ?? ''));
        $naturalContrayente1 = htmlspecialchars(trim($_POST["naturalContrayente1"] ?? ''));
        $nombreContrayente2 = htmlspecialchars(trim($_POST["nombreContrayente2"] ?? ''));
        $naturalContrayente2 = htmlspecialchars(trim($_POST["naturalContrayente2"] ?? ''));
        $numeroLibro = $_POST["numeroLibro"];
        $folio = $_POST["folio"];
        $numeroMarginal = $_POST["numeroMarginal"];
        $diaMatrimonio = $_POST["diaMatrimonio"];
        $mesMatrimonio = $_POST["mesMatrimonio"];
        $anoMatrimonio = $_POST["anoMatrimonio"];
        $nombreSacerdoteMatrimonio = htmlspecialchars(trim($_POST["nombreSacerdoteMatrimonio"] ?? ''));


        $diaExpedicion = $_POST["diaExpedicion"];
        $mesExpedicion = $_POST["mesExpedicion"];
        $anoExpedicion = $_POST["anoExpedicion"];
        $nombreAdministradorParroquial = htmlspecialchars(trim($_POST["nombreAdministradorParroquial"] ?? ''));

        if (empty($nombreContrayente1) || empty($nombreContrayente2) || empty($nombreAdministradorParroquial) || empty($nombreSacerdoteMatrimonio) || empty($naturalContrayente1) || empty($naturalContrayente2)) {
            header('Location:?c=reporte&a=acta_matrimonio');
            exit();
        }

        switch ($constancia) {
            case "matrimonio":

                GeneradorPdf::generarPdfMatrimonio(
                    $constancia,
                    $nombreContrayente1,
                    $naturalContrayente1,
                    $nombreContrayente2,
                    $naturalContrayente2,
                    $numeroLibro,
                    $folio,
                    $numeroMarginal,
                    $diaMatrimonio,
                    $mesMatrimonio,
                    $anoMatrimonio,
                    $nombreSacerdoteMatrimonio,
                    $diaExpedicion,
                    $mesExpedicion,
                    $anoExpedicion,
                    $nombreAdministradorParroquial
                );
                break;
            default:
                echo "Error: Tipo de constancia no especificado.";
                break;
        }
    }



}
