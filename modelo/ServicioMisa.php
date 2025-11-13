<?php

require_once 'GestorMisa.php';
require_once 'ServicioBase.php';

class ServicioIntencion extends ServicioBase
{
    private $gestorMisa;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->gestorMisa = new GestorMisa($pdo);
    }

/*
Comparación: El API compara:

Fecha pedida (hasta): 05/01/2026.

Fecha máxima en BD: 31/12/2025.

Conclusión: ¡Faltan misas! Faltan las de los días 1, 2, 3, 4 y 5 de Enero.

Generación (JIT): El API antes de continuar, llama a una función interna: GenerarMisasHasta('2026-01-05').

Esta función usa tu plantilla de horario (L-S 7pm, DOM 8am, DOM 12pm, DOM 7pm).

Calcula los días que faltan (01/01/2026 al 05/01/2026).

Crea los registros en la tabla misas solo para esos 5 días (probablemente 1 misa el jueves, 1 el viernes, 1 el sábado, 3 el domingo, 1 el lunes).

Importante: Esto debe hacerse en una transacción para evitar que dos secretarias lo hagan al mismo tiempo.

Consulta Final: Una vez generadas las misas que faltaban, el API ahora sí ejecuta la consulta final (la que iba a hacer en el paso 3) y devuelve a la UI la lista completa de misas disponibles entre el 28/12 y el 05/01.

*/
    public function guardar($queponer, $id = 0)
    {
        $this->pdo->beginTransaction();
        try {
            $this->generarMisasHasta($hastaFecha)
            
            $this->pdo->commit();
            return $resultado;    
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de : " . $e->getMessage());    
            throw new Exception($e->getMessage());
        }
    }

    private function generarMisasHasta($hastaFecha)
    {
        $inicio = new DateTime('now');
        $fecha_actual = clone $inicio;
        
        $fin_de_ano = new DateTime($hastaFecha);
        $fin_de_ano->setTime(23, 59, 59);

        while ($fecha_actual <= $fin_de_ano) {
            $dia_semana = (int) $fecha_actual->format('N');

            if ($dia_semana == 7) {
                $this->crearMisa($fecha_actual, '08:30:00', true);
                $this->crearMisa($fecha_actual, '10:30:00', false);
                $this->crearMisa($fecha_actual, '16:30:00', true);
            } else {
                $this->crearMisa($fecha_actual, '17:00:00', true);
            }

            $fecha_actual->modify('+1 day');
            $fecha_actual->setTime(0, 0, 0);
        }
    }

    private function crearMisa(DateTime $fecha, string $hora_string, bool $permite_intenciones)
    {
        $fecha_hora_misa = clone $fecha;

        list($hora, $minuto, $segundo) = explode(':', $hora_string);
        $fecha_hora_misa->setTime((int)$hora, (int)$minuto, (int)$segundo);

        $ahora = new DateTime('now');
        if ($fecha_hora_misa < $ahora) {
            error_log("   -> Omitiendo: Misa del " . $fecha_hora_misa->format('Y-m-d H:i') . " ya pasó.\n");
            return;
        }
        $misa = new Misa();
        $misa ->setFechaHora($fecha_hora_misa);
        $misa ->setPermiteIntenciones($permite_intenciones);

        $this->gestorMisa->guardar($misa);
    }
}
