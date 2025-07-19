<?php

function cargarVariablesDeEntorno($ruta = '.', $nombreArchivo = '.env')
{
    $archivoRuta = rtrim($ruta, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $nombreArchivo;

    if (!file_exists($archivoRuta) || !is_readable($archivoRuta)) {
        throw new Exception("Error: archivo no encontrado/no es legible. " . $archivoRuta);
    }

    $lineas = file($archivoRuta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (empty($linea) || str_starts_with($linea, '#')) {
            continue;
        }

        list($key, $valor) = explode('=', $linea, 2);

        $key = trim($key);
        $valor = trim($valor);

        if (str_starts_with($valor, '"') && str_ends_with($valor, '"')) {
            $valor = substr($valor, 1, -1);
        } elseif (str_starts_with($valor, "'") && str_ends_with($valor, "'")) {
            $valor = substr($valor, 1, -1);
        }

        $_ENV[$key] = $valor;
    }
}
