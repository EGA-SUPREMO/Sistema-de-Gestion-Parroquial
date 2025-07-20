<?php
require_once "conexion.php";

class Feligres {
    private $db;
    public $nombre;
    public $cedula;
   public $id;
    public function __construct() {
        $this->db = base_datos::BD();
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT * FROM feligreses");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM feligreses WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function agregar($nombre, $cedula) {
        try {
            $stmt = $this->db->prepare("INSERT INTO feligreses (nombre, cedula) VALUES (:nombre, :cedula)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":cedula", $cedula, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($id, $nombre, $cedula) {
        try {
            $stmt = $this->db->prepare("UPDATE feligreses SET nombre = :nombre, cedula = :cedula WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":cedula", $cedula, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminar($id)
    {
        try
        {
            
            $consulta = $this->db->prepare("DELETE FROM feligreses WHERE id = ?;");

            $consulta->execute(array($id));

        } catch (Exception $e)
        {
          
              header('Location:?c=feligreses');
        }
    }

}
?>