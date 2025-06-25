<?php
require_once "conexion.php";

class Pago
{
    private $db;
    public $id;
    public $peticion_id;
    public $feligres_id;
    public $metodo_pago_id;
    public $monto_usd;
    public $referencia_pago;
    public $fecha_pago;


    public function __construct()
    {
        $this->db = base_datos::BD();
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("SELECT p.id,pe.descripcion,f.nombre,f.cedula,m.nombre as 
        metodo,p.monto_usd,p.referencia_pago,p.fecha_pago FROM
         pagos p 
        INNER JOIN peticiones pe on p.peticion_id = pe.id
         INNER JOIN feligreses f on 
f.id = p.feligres_id INNER JOIN metodos_pago m on m.id = p.metodo_pago_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pagos WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function agregar($peticion_id, $feligres_id, $metodo_pago_id, $monto_usd, $referencia_pago, $fecha_pago)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO pagos (peticion_id, feligres_id, metodo_pago_id, monto_usd, referencia_pago, fecha_pago) VALUES (:peticion_id, :feligres_id, :metodo_pago_id, :monto_usd, :referencia_pago, :fecha_pago)");
            $stmt->bindParam(":peticion_id", $peticion_id, PDO::PARAM_INT);
            $stmt->bindParam(":feligres_id", $feligres_id, PDO::PARAM_INT);
            $stmt->bindParam(":metodo_pago_id", $metodo_pago_id, PDO::PARAM_INT);
            $stmt->bindParam(":monto_usd", $monto_usd, PDO::PARAM_STR);
            $stmt->bindParam(":referencia_pago", $referencia_pago, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_pago", $fecha_pago, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($id, $peticion_id, $feligres_id, $metodo_pago_id, $monto_usd, $referencia_pago, $fecha_pago)
    {
        $stmt = $this->db->prepare("UPDATE pagos SET peticion_id = :peticion_id, feligres_id = :feligres_id, metodo_pago_id = :metodo_pago_id, monto_usd = :monto_usd, referencia_pago = :referencia_pago, fecha_pago = :fecha_pago WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":peticion_id", $peticion_id, PDO::PARAM_INT);
        $stmt->bindParam(":feligres_id", $feligres_id, PDO::PARAM_INT);
        $stmt->bindParam(":metodo_pago_id", $metodo_pago_id, PDO::PARAM_INT);
        $stmt->bindParam(":monto_usd", $monto_usd, PDO::PARAM_STR);
        $stmt->bindParam(":referencia_pago", $referencia_pago, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_pago", $fecha_pago, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        try {
            $consulta = $this->db->prepare("DELETE FROM pagos WHERE id = ?;");
            $consulta->execute(array($id));
        } catch (Exception $e) {
            //  die($e->getMessage());
            header('Location:?c=pagos');
        }
    }
}
