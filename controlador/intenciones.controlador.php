<?php

require_once "public/fpdf/fpdf.php";
session_start();
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
        $accionDeGracias = $_POST["acciondegracias"] ?? '';
        $salud = $_POST["salud"] ?? '';
        $aniversarios = $_POST["aniversarios"] ?? '';
        $difunto = $_POST["difunto"] ?? '';

        
        if ($plantilla === "intenciones") {

            $this->generarPdfIntenciones(
                $accionDeGracias,
                $salud,
                $aniversarios,
                $difunto
            );
        } else {
            echo "Error: Tipo de plantilla no especificado o incorrecto.";
        }
    }

    private function generarPdfIntenciones(
        $accionDeGracias,
        $salud,
        $aniversarios,
        $difunto
    ) {

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();

        $pdf->SetMargins(5, 10, 5);


        $pdf->SetAutoPageBreak(true, 20);


        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 10, utf8_decode('INTENCIONES'), 0, 1, 'C');


        $pdf->Ln(10);


        // --- CONTENIDO DE LAS INTENCIONES ---
        $pdf->SetFont('Arial', '', 12);

        // Función para imprimir una sección
        $imprimirSeccion = function ($titulo, $contenido) use ($pdf) {
            if (!empty(trim($contenido))) {
                // Guarda la posición X actual para alinear el contenido
                $current_x = $pdf->GetX();

                // --- Título con los bordes de arriba, izquierdo y derecho ---
                $pdf->SetFont('Arial', 'B', 14);

                $pdf->Cell(0, 10, "  " . utf8_decode($titulo), 'TLR', 1, 'L');

                // --- Contenido con los bordes izquierdo, derecho y de abajo ---
                $pdf->SetFont('Arial', '', 12);
                // Se establece la posición X para que coincida con el borde izquierdo del título.
                $pdf->SetX($current_x);

                $pdf->MultiCell(0, 7, utf8_decode($contenido), 'LRB', 'L');


                $pdf->Ln(8);
            }
        };

        // Imprimir cada sección utilizando el formato del documento 
        $imprimirSeccion('ACCIÓN DE GRACIAS:', $accionDeGracias);
        $imprimirSeccion('SALUD:', $salud);
        $imprimirSeccion('ANIVERSARIOS:', $aniversarios);
        $imprimirSeccion('DIFUNTOS:', $difunto);





        // --- SALIDA DEL PDF ---

        $uploadDir = __DIR__ . '/../uploads/pdf/';


        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                die('Fallo al crear el directorio de uploads: ' . $uploadDir);
            }
        }

        $Nombre_pdf = "intenciones_" . time() . ".pdf";
        $filePath = $uploadDir . $Nombre_pdf;

        $pdf->Output($filePath, 'F');
        $pdf->Output($Nombre_pdf, 'I');

        exit;
    }
}
