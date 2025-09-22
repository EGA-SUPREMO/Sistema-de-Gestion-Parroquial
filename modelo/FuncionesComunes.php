<?php

class FuncionesComunes
{
    public static function formatearTitulo($cadena)
    {
        $formato_limpio = str_replace('_', ' ', $cadena);
        $titulo_formateado = ucwords($formato_limpio);

        return $titulo_formateado;
    }

    public static function requerirLogin()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            self::redirigir('Location: ?c=login&a=index&mensaje=no_autenticado', 302);
        }
    }

    public static function redirigir($url, $codigo = 302)
    {
        http_response_code($codigo);
        header($url);
        exit();
    }
    public static function formatearSnakeCaseAPascalCase($cadena)
    {
        $cadenaConEspacios = str_replace('_', ' ', $cadena);
        $palabrasCapitalizadas = ucwords($cadenaConEspacios);
        $sinEspacios = str_replace(' ', '', $palabrasCapitalizadas);
        return $sinEspacios;
    }
    
    public static function limpiarString($valor)
    {
        if (!is_string($valor)) {
            return $valor;
        }
        $valorRecortado = htmlspecialchars(trim($valor));

        if (substr($valorRecortado, -1) === '.') {
            $valorRecortado = substr($valorRecortado, 0, -1);
        }

        return $valorRecortado;
    }
}
