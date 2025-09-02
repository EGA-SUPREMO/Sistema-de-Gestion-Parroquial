<?php

class FuncionesComunes
{
    public static function formatearTitulo($cadena) {
        $formato_limpio = str_replace('_', ' ', $cadena);
        $titulo_formateado = ucwords($formato_limpio);
        
        return $titulo_formateado;
    }    
}
