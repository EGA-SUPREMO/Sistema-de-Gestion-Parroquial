<?php

require_once 'modelo/GestorBase.php';

class GestorPeticion extends GestorBase
{
    public $id;
    public $feligres_id;
    public $servicio_id;
    public $descripcion;
    public $fecha_registro;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "Peticion";
        $this ->tabla = "peticiones";
    }

    public function obtenerTodos()//usar hacerConsulta del padre
    {
        try {
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
}
