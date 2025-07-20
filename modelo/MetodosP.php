<?php
require_once "conexion.php"; 

class MetodoPago 
{
    private $db;
    public $nombre;
    public $id;

    public function __construct()
    {
        $this->db = base_datos::BD();
    }

    public function obtenerTodos()
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM metodos_pago"); 
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
            $stmt = $this->db->prepare("SELECT * FROM metodos_pago WHERE id = :id"); 
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function agregar($nombre) 
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO metodos_pago (nombre) VALUES (:nombre)"); 
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
            error_log($e->getMessage());
        }
    }

    public function actualizar($id, $nombre) 
    {
        try{
            $stmt = $this->db->prepare("UPDATE metodos_pago SET nombre = :nombre WHERE id = :id"); 
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function eliminar($id)
    {
        try {
            $consulta = $this->db->prepare("DELETE FROM metodos_pago WHERE id = ?;"); 
            $consulta->execute(array($id));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}
?>