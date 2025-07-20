<?php

//require_once "modelo/fe_bautizo.php";
// "modelo/matrimonio.php";
require_once "public/fpdf/fpdf.php";
session_start();
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

                $this->generarPdfComunion(
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


    private function generarPdfComunion(
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
    ) {
        //PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10);


        $logo_path = __DIR__ . '/../public/img/logo.jpg';
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 20, 12, 50);
        }


        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(105, 18);
        $pdf->Cell(0, 4, utf8_decode('AQUIDIÓCESIS DE VALENCIA'), 0, 1, 'R');
        $pdf->SetX(105);
        $pdf->Cell(0, 4, utf8_decode('PARROQUIA SAN DIEGO DE ALCALÁ Y DE LA CANDELARIA'), 0, 1, 'R');
        $pdf->SetX(105);
        $pdf->Cell(0, 4, utf8_decode('SAN DIEGO - EDO. CARABOBO'), 0, 1, 'R');


        $pdf->Ln(5);

        $pdf->SetX(105);
        $pdf->Cell(0, 4, utf8_decode('El Suscrito Administrador Parroquial de la Parroquia'), 0, 1, 'R');
        $pdf->SetX(105);
        $pdf->Cell(0, 4, utf8_decode('San Diego de Alcalá y de la Candelaria'), 0, 1, 'R');
        $pdf->SetX(105);
        $pdf->Cell(0, 4, utf8_decode('TLF. 02418911804'), 0, 1, 'R');



        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetY(60);
        $pdf->Cell(0, 10, utf8_decode('CERTIFICA'), 0, 1, 'C');


        $pdf->SetFont('Arial', '', 12);
        $y = $pdf->GetY() + 10;
        $left_margin = 20;
        $pdf->SetLeftMargin($left_margin);
        $pdf->SetRightMargin($left_margin);


        $pdf->Cell(0, 10, utf8_decode('Que en el libro ' . $numeroLibro . ' de bautismo al folio ' . $folio . ' y bajo el N°. Marginal ' . $numeroMarginal), 0, 1, 'C');
        $pdf->Ln(5);

        // "ACTA DE MATRIMONIO ECLESIÁSTICO"
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode('ACTA DE MATRIMONIO ECLESIÁSTICO'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);

        // "De: Contrayente 1"
        $pdf->Write(5, utf8_decode('De:  '));
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Write(5, utf8_decode(mb_strtoupper($nombreContrayente1))); // Uppercase name
        $pdf->Ln(7);


        $pdf->SetX($left_margin + 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(10, utf8_decode('Natural de: '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(10, utf8_decode($naturalContrayente1));
        $pdf->Ln(7);


        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 5, utf8_decode('y'), 0, 1, 'C');
        $pdf->Ln(7);


        $pdf->Write(5, utf8_decode('        '));
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Write(5, utf8_decode(mb_strtoupper($nombreContrayente2)));
        $pdf->Ln(7);

        // "Natural de: Valencia" (Contrayente 2)
        $pdf->SetX($left_margin + 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('Natural de: '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($naturalContrayente2));
        $pdf->Ln(10);


        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('El Matrimonio se efectuó el día  '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $diaMatrimonio);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('  del mes de  '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($mesMatrimonio));
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('  del   '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $anoMatrimonio);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(7);

        // "Y fue presenciado por el Pbro..."
        $pdf->Write(5, utf8_decode('Y fue presenciado por el Pbro .  '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode(mb_strtoupper($nombreSacerdoteMatrimonio)));
        $pdf->Ln(15);



        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('La presente certificación se expide a petición de la parte interesada, en San Diego a los  '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $diaExpedicion);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('  días '));
        $pdf->Ln(8);
        $pdf->Write(5, utf8_decode('Del  mes de  '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($mesExpedicion));
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('  del Año  '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $anoExpedicion);
        $pdf->Ln(20);


        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode($nombreAdministradorParroquial), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Administrador Parroquial'), 0, 1, 'C');
        $pdf->Ln(5);


        $pdf->SetY(-30); // el pie de pagina
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 3, utf8_decode('Calle Sucre Casa Nro. 1 Sector San Diego. Valencia Edo. Carabobo Zona Postal 2006'), 0, 1, 'C');
        $pdf->Cell(0, 3, utf8_decode('Contacto: 0241.891.18.04 / Instagram: sandiegoycandelaria'), 0, 1, 'C');
        $pdf->Cell(0, 3, utf8_decode('Gmail: psandiegodealcalaylacandelaria@gmail.com'), 0, 1, 'C');

        $uploadDir = __DIR__ . '/../uploads/pdf/';

        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                
                die('Fallo al crear el directorio de uploads: ' . $uploadDir);
            }
        }

        $Nombre_pdf = "matrimonio_eclesiastico_" . time() . ".pdf";
        $filePath = $uploadDir . $Nombre_pdf; 

        $pdf->Output($filePath, 'F');
        $pdf->Output($Nombre_pdf, 'I');
        exit;
    }
}
