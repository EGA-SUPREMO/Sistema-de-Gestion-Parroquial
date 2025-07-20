<?php 

class Validador
{
    public static function validarRangoFechas($fechaInicioStr, $fechaFinStr)
    {
        try {
            $fechaInicio = new DateTime($fechaInicioStr);
            $fechaFin = new DateTime($fechaFinStr);

            if ($fechaInicio > $fechaFin) {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error de formato de fecha en validacionRangoFechas: " . $e->getMessage());
            return false;
        }
        return true;
        
    }

} 
