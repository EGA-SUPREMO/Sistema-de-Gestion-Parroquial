<?php
class base_datos
{
    public static function BD()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=registro_de_pagos;charset=utf8', 'test', '1234');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
