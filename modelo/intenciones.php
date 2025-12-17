<?php

require_once 'App.php';
require_once 'EntidadFactory.php';

class GestionPeticionMisa
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = App::obtenerConexion();
    }

    public function manejarSolicitudDeBusqueda($postData)
    {
        $datos_json = $postData['json'] ?? '{}';
        $datos = json_decode($datos_json, true);

        if (isset($datos['metodo']) && $datos['metodo'] === 'consultarOCrearMisas') {
            return $this->consultarOCrearMisas($datos);
        }
    }

    private function consultarOCrearMisas($datos)
    {
        $gestorMisa = EntidadFactory::crearGestor($this->pdo, 'Misa');
        $servicioMisa = EntidadFactory::crearServicio($this->pdo, 'Misa');
        $fechaInicioReq = $datos['fecha_inicio']; // "2025-11-15"
        $fechaFinReq = $datos['fecha_fin'];       // "2025-11-23"

        $resultado = $gestorMisa->obtenerUltimaMisaRegistrada();
        $ultimaFechaRegistrada = $resultado['ultima_fecha']
            ? new DateTime($resultado['ultima_fecha'])
            : new DateTime('yesterday');
        $fechaFinRequerida = new DateTime($fechaFinReq . ' 23:59:59');

        $inicioGeneracion = clone $ultimaFechaRegistrada;
        $inicioGeneracion->modify('+1 day');
        $inicioGeneracion->setTime(0, 0, 0);

        // Paso A2: Si la fecha que piden es mayor a lo que tengo, genero lo que falta
        if ($fechaFinRequerida > $inicioGeneracion) {
            $servicioMisa->generarMisasEnRango($inicioGeneracion, $fechaFinRequerida);
        }

        // === PARTE B: CONSULTA FINAL ===

        $formatoDiaSemana = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Caracas' // Ajusta a tu zona horaria para precisión (o déjala nula si no importa la zona)
        );
        $formatoDiaSemana->setPattern('EEEE'); // Ejemplo: "jueves"

        // El formato 'h:mm a' es para 12 horas con AM/PM (ej. 07:00 PM)
        $formatoHora = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::NONE,
            IntlDateFormatter::SHORT
        );
        $formatoHora->setPattern('h:mm a'); // Ejemplo: "7:00 p. m." (Si prefieres "7:00 PM", usa 'A' mayúscula: 'h:mm A')


        $misas = $gestorMisa->obtenerMisasConIntencionesPorRangoFechas($fechaInicioReq, $fechaFinReq);
        $respuesta = [];
        foreach ($misas as $misa) {
            $misa_arr = $misa->toArrayParaBD();
            $timestamp = strtotime($misa_arr['fecha_hora']);
            $misa_arr['hora_formato'] = $formatoHora->format($timestamp);
            $misa_arr['dia_semana'] = ucfirst($formatoDiaSemana->format($timestamp));
            $respuesta[] = $misa_arr;
        }

        return $respuesta;
    }
}


App::iniciar();

$misa = new GestionPeticionMisa();
$respuesta = $misa->manejarSolicitudDeBusqueda($_POST);
header('Content-Type: application/json');
echo json_encode($respuesta);
exit();
