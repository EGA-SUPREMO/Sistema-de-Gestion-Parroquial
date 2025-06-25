<?php

//require_once "modelo/fe_bautizo.php";
//require_once "modelo/matrimonio.php";
require_once "public/fpdf/fpdf.php";
session_start();
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

        $constancia = $_POST["constancia"] ?? null;
        $nombreBautizado       = $_POST["nombreBautizado"] ?? null;
        $diaNacimiento         = $_POST["diaNacimiento"] ?? null;
        $mesNacimiento         = $_POST["mesNacimiento"] ?? null;
        $anoNacimiento         = $_POST["anoNacimiento"] ?? null;
        $lugarNacimiento       = $_POST["lugarNacimiento"] ?? null;
        $nombrePadre           = $_POST["nombrePadre"] ?? null;
        $nombreMadre           = $_POST["nombreMadre"] ?? null;
        $numeroLibro           = $_POST["numeroLibro"] ?? null;
        $folio                 = $_POST["folio"] ?? null;
        $numeroMarginal        = $_POST["numeroMarginal"] ?? null;
        $diaBautismo           = $_POST["diaBautismo"] ?? null;
        $mesBautismo           = $_POST["mesBautismo"] ?? null;
        $anoBautismo           = $_POST["anoBautismo"] ?? null;
        $nombreSacerdote       = $_POST["nombreSacerdote"] ?? null;
        $nombrePadrino         = $_POST["nombrePadrino"] ?? null;
        $nombreMadrina         = $_POST["nombreMadrina"] ?? null;
        $propositoCertificacion = $_POST["propositoCertificacion"] ?? null;
        $diaExpedicion         = $_POST["diaExpedicion"] ?? null;
        $mesExpedicion         = $_POST["mesExpedicion"] ?? null;
        $anoExpedicion         = $_POST["anoExpedicion"] ?? null;


        switch ($constancia) {
            case "fe_bautizo":

                $this->generarPdfComunion(
                    $constancia,
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
                    $anoExpedicion
                );
                break;
            default:
                echo "Error: Tipo de constancia no especificado.";
                break;
        }
    }


    private function generarPdfComunion(
        $constancia,
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
        $anoExpedicion
    ) {

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10);

        $logo_path = __DIR__ . '/../public/img/logo.jpg';
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 20, 12, 50);
        }


        // --- Encabezado ---
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
        $pdf->Cell(0, 4, utf8_decode('Tlf. 02418911804'), 0, 1, 'R');

        // --- Título Central ---
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetY(60);
        $pdf->Cell(0, 10, utf8_decode('CERTIFICA'), 0, 1, 'C');

        // --- Cuerpo del documento ---
        $pdf->SetFont('Arial', '', 12);
        $y = $pdf->GetY() + 10;
        $left_margin = 20;
        $pdf->SetXY($left_margin, $y);

        // Libro, folio, número marginal
        $pdf->Cell(0, 1, utf8_decode('Que en el libro ' . $numeroLibro . ' de bautismo al folio ' . $folio . ' y bajo el N°. Marginal ' . $numeroMarginal), 0, 1, 'C');

        $pdf->Ln(1);

        // ACTA DE BAUTISMO
        $pdf->SetX($left_margin);
        $pdf->Cell(0, 10, utf8_decode('se encuentra el'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(200, 10, utf8_decode(' ACTA DE BAUTISMO '), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(200, 10, utf8_decode('De:' . mb_strtoupper($nombreBautizado)), 0, 1, 'C');
        $pdf->Ln(15);

        // Nombre completo del bautizado
        $pdf->SetFont('Arial', '', 12);

        $pdf->Ln(1);

        // Padres
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('Hijo de: '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($nombrePadre));
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode(' y '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($nombreMadre));
        $pdf->Ln(5);
        $y = $pdf->GetY() + 10;
        $left_margin = 20;
        $pdf->SetXY($left_margin, $y);
        // Fecha y lugar de nacimiento
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        // Fecha de nacimiento
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('Que nació el '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $diaNacimiento . utf8_decode(' de ' . $mesNacimiento . ' de ' . $anoNacimiento));
        $pdf->Ln(7); // Salto de línea adicional

        // Lugar de nacimiento
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('En '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($lugarNacimiento));


        $pdf->Ln(10);

        // Bautizado
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 5, utf8_decode('Y'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 5, utf8_decode('FUE BAUTIZADO'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);

        // Día de bautismo
        $pdf->SetX($left_margin);
        $pdf->Write(5, utf8_decode('El '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $diaBautismo . utf8_decode(' de ' . $mesBautismo . ' de ' . $anoBautismo));
        $pdf->Ln(5);

        // Por el sacerdote
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('Por: '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($nombreSacerdote));
        $pdf->Ln(5);

        // Padrinos
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('siendo sus Padrinos: '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($nombrePadrino));
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode(' y '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($nombreMadrina));
        $pdf->Ln(5);

        // Nota marginal
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Ln(10);

        // Finalidad
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('La anterior certificación, se expide para fines de: '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($propositoCertificacion));
        $pdf->Ln(10);

        // Lugar y fecha
        $pdf->SetX($left_margin);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode('En San Diego a los '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $diaExpedicion);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode(' días del mes de '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, utf8_decode($mesExpedicion));
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(5, utf8_decode(' de '));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Write(5, $anoExpedicion);
        $pdf->Ln(20);

        // Firma
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode('Pbro. Hedson Brizuela'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Administrador Parroquial'), 0, 1, 'C');
        $pdf->Ln(5);

        // Pie de página
        $pdf->SetY(-20);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 3, utf8_decode('Calle Sucre Casa Nro. 1 Sector San Diego. Valencia Edo. Carabobo Zona Postal 2006'), 0, 1, 'C');
        $pdf->Cell(0, 3, utf8_decode('Contacto: 0241.891.18.04 / Instagram: sandiegoycandelaria'), 0, 1, 'C');
        $pdf->Cell(0, 3, utf8_decode('Gmail: psandiegodealcalaylacandelaria@gmail.com'), 0, 1, 'C');

        // Salida del PDF
        $uploadDir = __DIR__ . '/../uploads/pdf/';


        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {

                die('Fallo al crear el directorio de uploads: ' . $uploadDir);
            }
        }

        $Nombre_pdf = "fe_bautizo_" . time() . ".pdf";
        $filePath = $uploadDir . $Nombre_pdf;

        $pdf->Output($filePath, 'F');
        $pdf->Output($Nombre_pdf, 'I');

        exit;
    }
}
