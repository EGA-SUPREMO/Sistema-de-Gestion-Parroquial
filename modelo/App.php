<?php

require_once 'cargarEnv.php';
require_once 'BaseDatos.php';

class App
{
    private static $pdo = null;

    public static function iniciar()
    {
        session_start();
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(__DIR__) . '/');
        }
        cargarVariablesDeEntorno(ROOT_PATH);
    }

    public static function obtenerConexion()
    {
        if (self::$pdo === null) {
            self::$pdo = BaseDatos::obtenerConexion(
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );
        }
        return self::$pdo;
    }
}
