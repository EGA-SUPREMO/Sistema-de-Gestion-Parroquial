<?php
class base_datos
{
    public static function BD()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cesar;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
