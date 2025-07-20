<?php
class base_datos
{
    public static function BD()
    {
        try {
            $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';
                dbname='. $_ENV['DB_NAME'] . ';
                charset=utf8', $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            error_log("Error en la conexión: " . $e->getMessage());
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
