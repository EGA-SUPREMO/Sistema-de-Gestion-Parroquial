<?php

class GeneradorPdf
{

    public static function generarPdfMatrimonio(
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

    public static function generarPdfBautizo(
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

    public static function generarPdfIntenciones(
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

    public static function generarPdfComunion(
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
