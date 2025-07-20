<?php

class BaseDatos
{
    private static ?PDO $pdoInstance = null;
    private string $host;
    private string $dbname;
    private string $user;
    private string $pass;
    private string $charset;

    private function __construct($host, $dbname, $user, $pass, $charset = 'utf8')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
        $this->charset = $charset;
    }

    public static function obtenerConexion($host, $dbname, $user, $pass, $charset = 'utf8')
    {
        if (self::$pdoInstance === null) {
            try {
                $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
                self::$pdoInstance = new PDO($dsn, $user, $pass);
                self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                throw new PDOException("No se pudo conectar a la base de datos. Por favor, inténtelo de nuevo más tarde.");
            }
        }
        return self::$pdoInstance;
    }
}
