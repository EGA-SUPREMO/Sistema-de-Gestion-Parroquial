<?php

class BaseDatos
{
    private static ?PDO $pdoInstance = null;
    private static $host = null;
    private static $dbname = null;
    private static $user = null;
    private static $pass = null;
    private static $charset = 'utf8';

    private function __construct()
    {
    }

    public static function obtenerConexion(
        $host = null,
        $dbname = null,
        $user = null,
        $pass = null,
        $charset = null
    ) {
        if (self::$pdoInstance !== null) {
            return self::$pdoInstance;
        }
        $h = $host ?? self::$host;
        $d = $dbname ?? self::$dbname;
        $u = $user ?? self::$user;
        $p = $pass ?? self::$pass;
        $c = $charset ?? self::$charset;

        if ($h === null || $d === null || $u === null || $p === null) {
            throw new PDOException("Faltan credenciales. Deben proporcionarse en la primera llamada.");
        }

        try {
            $dsn = "mysql:host={$h};dbname={$d};charset={$c}";

            self::$pdoInstance = new PDO($dsn, $u, $p);
            self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$host = $h;
            self::$dbname = $d;
            self::$user = $u;
            self::$pass = $p;
            self::$charset = $c;

        } catch (PDOException $e) {
            self::$pdoInstance = null;
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            throw new PDOException("No se pudo conectar a la base de datos.");
        }

        return self::$pdoInstance;
    }
}
