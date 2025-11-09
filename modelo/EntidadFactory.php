<?php

require_once 'FuncionesComunes.php';

class EntidadFactory
{
    public static function crearGestor($pdo, $nombreTabla)
    {
        $nombreClase = 'Gestor' . FuncionesComunes::formatearSnakeCaseAPascalCase($nombreTabla);
        $directorio = ROOT_PATH . 'modelo/' . $nombreClase . '.php';

        if (file_exists($directorio)) {
            require_once $directorio;
            if (class_exists($nombreClase)) {
                return new $nombreClase($pdo);
            }
            throw new Exception("Clase del gestor para la tabla '{$nombreTabla}' no encontrado.");
        }
        throw new Exception("Archivo del gestor para la tabla '{$nombreTabla}' no encontrado.");
    }
    public static function crearServicio($pdo, $nombreTabla)
    {
        $nombreClase = 'Servicio' . FuncionesComunes::formatearSnakeCaseAPascalCase($nombreTabla);
        $directorio = ROOT_PATH . 'modelo/' . $nombreClase . '.php';

        if (file_exists($directorio)) {
            require_once $directorio;
            if (class_exists($nombreClase)) {
                return new $nombreClase($pdo);
            }
        }
        throw new Exception("Servicio para la constancia '{$nombreTabla}' no encontrado.");
    }

    public static function crearObjeto($nombreTabla)
    {
        $nombreClaseObjeto = FuncionesComunes::formatearSnakeCaseAPascalCase($nombreTabla);
        $directorio = ROOT_PATH . 'modelo/' . $nombreClaseObjeto . '.php';

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
