<?php
require_once "conexion.php"; 

class Servicio
{
    private $db;
    public $nombre;
    public $descripcion;
    public $id;

    public function __construct()
    {
        $this->db = base_datos::BD();
    }

    public function obtenerTodos()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM servicios");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function obtenerPorId($id)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM servicios WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function agregar($nombre, $descripcion)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO servicios (nombre, descripcion) VALUES (:nombre, :descripcion)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function actualizar($id, $nombre, $descripcion)
    {
        try {
            $stmt = $this->db->prepare("UPDATE servicios SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $consulta = $this->db->prepare("DELETE FROM servicios WHERE id = ?;");
            $consulta->execute(array($id));
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
