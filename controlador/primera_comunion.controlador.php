<?php

//require_once "modelo/fe_bautizo.php";
//require_once "modelo/matrimonio.php";
require_once "public/fpdf/fpdf.php";
session_start();

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
        $nombreCiudadano = $_POST["nombreCiudadano"];
        $cedulaIdentidad = $_POST["cedulaIdentidad"];
        $diaComunion     = $_POST["diaComunion"];
        $mesComunion     = $_POST["mesComunion"];
        $anoComunion     = $_POST["anoComunion"];
        $diaExpedicion   = $_POST["diaExpedicion"];
        $mesExpedicion   = $_POST["mesExpedicion"];
        $anoExpedicion   = $_POST["anoExpedicion"];

        // El switch ahora decide qué método de generación llamar.
        switch ($constancia) {
            case "primera_comunion":
                $this->generarPdfComunion(
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


    private function generarPdfComunion(
        $nombreCiudadano,
        $cedulaIdentidad,
        $diaComunion,
        $mesComunion,
        $anoComunion,
        $diaExpedicion,
        $mesExpedicion,
        $anoExpedicion
    ) {

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10);

        // --- Logo Superior Izquierdo ---
        $logo_path = __DIR__ . '/../public/img/logo.jpg';
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 20, 12, 50);
        }

        // --- Información de la Parroquia Superior Derecha ---
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(110, 18);
        $pdf->Cell(0, 5, utf8_decode('PARROQUIA SAN DIEGO DE ALCALÁ'), 0, 0, 'R');
        $pdf->SetXY(110, 23);
        $pdf->Cell(0, 5, 'RIF: G-200074582', 0, 0, 'R');

        // --- Título de CONSTANCIA ---
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetXY(10, 50);
        $pdf->Cell(0, 10, utf8_decode('CONSTANCIA'), 0, 1, 'C');

        // --- Texto Principal del Cuerpo y Datos Dinámicos ---
        $pdf->SetFont('Arial', '', 12);
        $y = 80;
        $left_margin = 20;

        // Frase Introductoria
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $sangria = 15; 

        // Guarda la posición X actual del cursor (opcional, si necesitas restaurarla después)
        $x_original = $pdf->GetX();

        
        $pdf->SetX($x_original + $sangria);
        $pdf->MultiCell(0, 10, utf8_decode('Quien suscribe, Administrador Parroquial de San Diego de Alcalá y de La'), 5, 'C');
        $pdf->MultiCell(0, 8, utf8_decode('Candelaria, por medio de la presente hace CONSTAR que el ciudadano'), 0, 'C');

        // Línea con nombre y cédula llenados automáticamente
        $pdf->Ln(3);
        $pdf->Cell(0, 8, utf8_decode($nombreCiudadano . ', titular de la Cédula de'), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('Identidad N° ' . $cedulaIdentidad . ', Realizó su PRIMERA COMUNIÓN en esta'), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('Parroquia.'), 0, 1, 'C');

        // Fecha de Primera Comunión
        $pdf->Ln(5);
        $pdf->Cell(0, 8, utf8_decode('El día ' . $diaComunion . ' del mes de ' . $mesComunion . ' del año ' . $anoComunion . '.'), 0, 1, 'C');

        // Fecha de expedición
        $pdf->Ln(10);
        $pdf->MultiCell(0, 8, utf8_decode('Constancia que se expide en San Diego Edo. Carabobo a los ' . $diaExpedicion . ' días del mes'), 0, 'C');
        $pdf->MultiCell(0, 8, utf8_decode('de ' . $mesExpedicion . ' del año ' . $anoExpedicion . '.'), 0, 'C');



        // --- Bloque de Firma del Administrador ---
        $pdf->SetY(200);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode('Pbro. Hedson Brizuela'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Administrador Parroquial'), 0, 1, 'C');
        $pdf->Cell(0, 5, utf8_decode('Parroquia San Diego de Alcalá y de La Candelaria.'), 0, 1, 'C');

        // ---(Pie de Página) ---
        $pdf->SetY(260);
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

        $Nombre_pdf = "primera_comunion_" . time() . ".pdf";
        $filePath = $uploadDir . $Nombre_pdf;

        $pdf->Output($filePath, 'F');
        $pdf->Output($Nombre_pdf, 'I');

        exit;
    }
}
