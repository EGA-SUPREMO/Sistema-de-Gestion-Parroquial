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
        $valorRecortado = preg_replace('/\s+/', ' ', $valorRecortado);
        $valorRecortado = rtrim($valorRecortado, '.,;');

        return $valorRecortado;
    }
    public static function rutaDocumentoAUrl($rutaAbsoluta) 
    {
        $rutaRaizServidor = $_SERVER['DOCUMENT_ROOT'];
        $rutaNormalizada = realpath($rutaAbsoluta);

        if ($rutaNormalizada === false) {
            throw new Exception("Error: ruta no existe");
        }

        $rutaRelativa = str_replace($rutaRaizServidor, '', $rutaNormalizada);

        $rutaFinal = '//' . $_SERVER['HTTP_HOST'] . $rutaRelativa;

        return $rutaFinal;
    }
}
