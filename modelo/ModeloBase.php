<?php

abstract class ModeloBase
{
    protected $db;
    protected $tabla;
    protected $clavePrimaria = 'id';
    protected $claseEntidad;
    
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function contarTodos() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->tabla}");
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error en contarTodos para tabla {$this->tabla}: " . $e->getMessage());
            return null;
        }
    }
    public function obtenerTodos()
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM {$this->tabla}");
            $stmt->execute();

            if ($this->claseEntidad) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, $this->claseEntidad);
            } else {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            error_log("Error en obtenerTodos para tabla {$this->tabla}: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerPorId($id)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM {$this->tabla} WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($this->claseEntidad) {
                return $stmt->fetch(PDO::FETCH_CLASS, $this->claseEntidad);
            } else {
                return $stmt->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId para tabla {$this->tabla}: " . $e->getMessage());
            return null;
        }
    }

    public function eliminar($id)
    {
        try{
            $stmt = $this->db->prepare("DELETE FROM {$this->tabla} WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en eliminar para tabla {$this->tabla}: " . $e->getMessage());
            return null;
        }
    }

    public function insertar($datos) {
        try{
            $columnas = implode(", ", array_keys($datos));
            $placeholders = implode(", ", array_fill(0, count($datos), '?'));
            $stmt = $this->db->prepare("INSERT INTO {$this->tabla} ($columnas) VALUES ($placeholders)");
            return $stmt->execute(array_values($datos));
        } catch (PDOException $e) {
            error_log("Error en insertar para tabla {$this->tabla}: " . $e->getMessage());
            return null;
        }
    }

    public function actualizar($id, $datos) {
        try{
            $columnas = array_keys($datos);
            $asignaciones = array_map(fn($col) => "$col = ?", $columnas);
            $set = implode(", ", $asignaciones);
            $stmt = $this->db->prepare("UPDATE {$this->tabla} SET $set WHERE {$this->clavePrimaria} = ?");
            return $stmt->execute([...array_values($datos), $id]);
        } catch (PDOException $e) {
            error_log("Error en actualizar para tabla {$this->tabla}: " . $e->getMessage());
            return null;
        }
    }
}
 
