<?php

class Peticion 
{
    private $db;
    public $id;
    public $feligres_id;
    public $servicio_id;
    public $descripcion;
    public $fecha_registro;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function obtenerTodos()
    {
        try{
            $stmt = $this->db->prepare("SELECT
                    p.id AS id,
                    p.descripcion AS peticion_descripcion, 
                    p.fecha_registro,
                    p.fecha_inicio,
                    p.fecha_fin,
                    f.id AS feligres_id, 
                    f.nombre AS feligres_nombre, 
                    f.cedula AS feligres_cedula, 
                    s.id AS servicio_id, 
                    s.nombre AS servicio_nombre, 
                    s.descripcion AS servicio_descripcion 
                FROM
                    peticiones AS p
                INNER JOIN
                    feligreses AS f ON p.feligres_id = f.id 
                INNER JOIN
                    servicios AS s ON p.servicio_id = s.id
                ORDER BY
                    p.id DESC; "); 
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function obtenerPorId($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM peticiones WHERE id = :id"); 
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function agregar($feligres_id, $servicio_id, $descripcion, $fecha_registro, $fecha_inicio, $fecha_fin) 
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO peticiones (feligres_id, servicio_id, descripcion, fecha_registro, fecha_inicio, fecha_fin) VALUES (:feligres_id, :servicio_id, :descripcion, :fecha_registro, :fecha_inicio, :fecha_fin)"); 
            $stmt->bindParam(":feligres_id", $feligres_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_registro", $fecha_registro, PDO::PARAM_STR); 
            $stmt->bindParam(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);     
            $stmt->bindParam(":fecha_fin", $fecha_fin, PDO::PARAM_STR);          
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function actualizar($id, $feligres_id, $servicio_id, $descripcion, $fecha_registro, $fecha_inicio, $fecha_fin) 
    {
        try{
            $stmt = $this->db->prepare("UPDATE peticiones SET feligres_id = :feligres_id, servicio_id = :servicio_id, descripcion = :descripcion, fecha_registro = :fecha_registro, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id = :id"); 
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":feligres_id", $feligres_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_registro", $fecha_registro, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $consulta = $this->db->prepare("DELETE FROM peticiones WHERE id = ?;"); 
            $consulta->execute(array($id));
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>