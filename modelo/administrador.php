<?php
require_once 'conexion.php';

class administrador
{
    private $conexion;
    public $nombre_usuario;
    public $password;

    public function __construct()
    {
        $this->conexion = base_datos::BD();
    }

    public function obtenerTodos()
    {
        $stmt = $this->conexion->prepare("SELECT * FROM administrador");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function agregar($nombre_usuario, $password)
    {
        try {
            $stmt = $this->conexion->prepare("INSERT INTO administrador (nombre_usuario, password) VALUES (:nombre_usuario, :password)");
            $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function comprobar_datos_usuario($nombre_usuario, $password)
    {
        $query = $this->conexion->prepare("SELECT * FROM administrador WHERE nombre_usuario = ? AND password = ?");
        $query->bindParam(1, $nombre_usuario);
        $query->bindParam(2, $password);
        $query->execute();
        $resultado_obtenido = $query->fetch(PDO::FETCH_ASSOC);

        if ($resultado_obtenido) {

            session_start();
            $_SESSION['nombre_usuario'] = $resultado_obtenido['nombre_usuario'];


            return $resultado_obtenido;
        } else {
            return false;
        }
    }
}
