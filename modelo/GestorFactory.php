<?php

class GestorFactory
{
    public static function crearGestor($pdo, $nombreTabla)
    {
        $nombreClase = 'Gestor' . ucwords($nombreTabla);
        $directorio = 'modelo/' . $nombreClase . '.php';

        if (file_exists($directorio)) {
            require_once $directorio;
            if (class_exists($nombreClase)) {
                return new $nombreClase($pdo);
            }
        }
        throw new Exception("Gestor para la tabla '{$nombreTabla}' no encontrado.");
    }
    
    public static function crearObjeto($nombreTabla)
    {
        $nombreClaseObjeto = ucwords($nombreTabla);
        $directorio = 'modelo/' . $nombreClaseObjeto . '.php';

        if (file_exists($directorio)) {
            require_once $directorio;
            if (class_exists($nombreClaseObjeto)) {
                return new $nombreClaseObjeto();
            }
        }
        throw new Exception("Objeto para la tabla '{$nombreTabla}' no encontrado.");
    }
}
?> 
