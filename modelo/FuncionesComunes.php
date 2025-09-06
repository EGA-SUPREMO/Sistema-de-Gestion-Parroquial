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
}
