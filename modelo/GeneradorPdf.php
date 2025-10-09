<?php

require_once ROOT_PATH . "vendor/autoload.php";
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

require_once "FuncionesComunes.php";

class GeneradorPdf
{
    private static $ruta_plantillas = __DIR__ . "/../public/plantillas/";
    private static $ruta_documentos = __DIR__ . "/../public/documentos/";

    public static function generarDocumento($nombre_plantilla, $datos)
    {
        $ruta_plantilla_completa = self::$ruta_plantillas . $nombre_plantilla;

        if (!file_exists($ruta_plantilla_completa)) {
            error_log("Error: La plantilla no existe en la ruta: " . $ruta_plantilla_completa);
            throw new InvalidArgumentException("Error: La plantilla no existe en la ruta: " . $ruta_plantilla_completa);
        }
        $nombre_base = pathinfo($nombre_plantilla, PATHINFO_FILENAME);
        $nombre_archivo_salida = $nombre_base . '_generado.docx';

        $ruta_salida_completa = self::$ruta_documentos . $nombre_archivo_salida;

        $plantilla = new TemplateProcessor($ruta_plantilla_completa);
        foreach ($datos as $key => $valor) {
            $plantilla->setValue($key, $valor);
        }
        $plantilla->saveAs($ruta_salida_completa);

        return $ruta_salida_completa;
    }

    public static function guardarPDF($nombre_plantilla, $datos)
    {
        $rutaAbsolutaDocumentoDocx = self::generarDocumento($nombre_plantilla, $datos);
        $rutaAbsolutaDocumentoPdf = self::convertirDocxAPdf($rutaAbsolutaDocumentoDocx);
        return FuncionesComunes::rutaDocumentoAUrl($rutaAbsolutaDocumentoPdf);
    }

    public static function convertirDocxAPdf($ruta_docx)
    {
        $ruta_pdf = str_replace('.docx', '.pdf', $ruta_docx);

        $salida = dirname($ruta_docx);

        // Detectar sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            // En Windows el comando es soffice.exe, que suele estar en:
            // C:\Program Files\LibreOffice\program\soffice.exe
            // OJO: asegúrate de que esté en el PATH, si no, pon la ruta completa. "C:\Program Files\LibreOffice\program\soffice.exe"
            $comando = 'soffice --headless --convert-to pdf "' . $ruta_docx . '" --outdir "' . $salida . '"';
        } else {
            // Linux
            // Usamos un directorio temporal como HOME para evitar problemas de permisos
            $lo_profile = sys_get_temp_dir() . '/lo_profile';
            if (!is_dir($lo_profile)) {
                mkdir($lo_profile, 0755, true);
            }
            $comando = 'export HOME="' . $lo_profile . '" && libreoffice --headless --convert-to pdf "' . $ruta_docx . '" --outdir "' . $salida . '"';
        }

        // Comando con la variable de entorno definida
        $comando = 'export HOME="' . $lo_profile . '" && libreoffice --headless --convert-to pdf "' . $ruta_docx . '" --outdir "' . dirname($ruta_docx) . '"';
        exec($comando . " 2>&1", $output, $return_var);

        if ($return_var !== 0) {
            throw new \Exception("Error al convertir DOCX a PDF: " . implode("\n", $output));
        }

        return $ruta_pdf;
    }

}
