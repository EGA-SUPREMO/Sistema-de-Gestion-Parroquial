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
            throw new InvalidArgumentException("Error de formato de fecha en validacionRangoFechas: ");
            error_log("Error de formato de fecha en validacionRangoFechas: " . $e->getMessage());
            return false;
        }
        return true;

    }

    public static function validarEntero($valor, $nombreCampo, $valorMaximo = 2147483647, $valorMinimo = null)
    {
        if ($valor === null) {
            return null;
        }

        if (!filter_var($valor, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException("El campo '$nombreCampo' debe ser un número entero.");
        }

        $valor = (int) $valor;

        if ($valor > $valorMaximo) {
            throw new InvalidArgumentException("El campo '$nombreCampo' debe ser menor o igual a " . $valorMaximo . ".");
        }
        if ($valorMinimo !== null && $valor < $valorMinimo) {
            throw new InvalidArgumentException("El campo '$nombreCampo' debe ser mayor o igual a " . $valorMinimo . ".");
        }

        return $valor;
    }

    public static function validarString($valor, $nombreCampo, $longitudMaxima, $longitudMinima = null)
    {
        if ($valor === null) {
            return null;
        }

        $valorRecortado = trim($valor);

        if (empty($valorRecortado)) {
            throw new InvalidArgumentException("El campo '$nombreCampo' no puede estar vacío.");
        }

        if (strlen($valorRecortado) > $longitudMaxima) {
            throw new InvalidArgumentException("El campo '$nombreCampo' no puede exceder los $longitudMaxima caracteres.");
        }

        if ($longitudMinima !== null && strlen($valorRecortado) < $longitudMinima) {
            throw new InvalidArgumentException("El campo '$nombreCampo' debe tener al menos $longitudMinima caracteres.");
        }

        return $valorRecortado;
    }

    public static function validarFecha($fecha, $nombreCampo, $fechaMinima = null, $fechaMaxima = null)
    {
        if ($valor === null) {
            return null;
        }

        if (empty($fecha)) {
            throw new InvalidArgumentException("El campo '{$nombreCampo}' no puede estar vacío.");
        }

        $formato = 'Y-m-d';
        $d = DateTime::createFromFormat($formato, $fecha);

        if (!($d && $d->format($formato) === $fecha && checkdate($d->format('m'), $d->format('d'), $d->format('Y')))) {
            throw new InvalidArgumentException("El campo '{$nombreCampo}' debe ser una fecha válida en formato YYYY-MM-DD.");
        }

        if ($fechaMinima !== null) {
        }// TODO
        if ($fechaMaxima !== null) {// TODO
        }
        return $fecha;
    }

    public static function validarBooleano($valor, $campo)
    {
        if (is_string($valor) && $valor !== 'true' && $valor !== 'false' && $valor !== '1' && $valor !== '0') {
            throw new Exception("El campo '{$campo}' no tiene un formato booleano válido.");
        }

        $es_booleano = (bool)$valor;
        return $es_booleano ? 1 : 0;
    }
}
