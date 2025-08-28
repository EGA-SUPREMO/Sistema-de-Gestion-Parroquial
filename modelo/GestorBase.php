<?php

abstract class GestorBase
{
    protected $db;
    protected $tabla;
    protected $clavePrimaria;
    protected $clase_nombre;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
        $this ->clavePrimaria = 'id';
    }

    protected function hacerConsulta($consulta, $parametros, $modo_fetch = 'all')
    {
        try {
            $stmt = $this->db->prepare($consulta);
            $stmt->execute($parametros);

            switch ($modo_fetch) {
                case 'all':
                    return $stmt->fetchAll(PDO::FETCH_CLASS, $this->clase_nombre);
                case 'single':
                    return $stmt->fetchObject($this->clase_nombre);
                case 'column':
                    return $stmt->fetchColumn();
                case 'assoc':
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                default:
                    return $stmt; // para UPDATE, DELETE, INSERT, etc.
            }
        } catch (PDOException $e) {
            error_log("Error ejecutando consulta para tabla {$this->tabla}: " . $e->getMessage() . " Consulta: " . $consulta);
            return null;
        }
    }

    public function contarTodos()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla}";
        $result = $this->hacerConsulta($sql, [], 'column');
        return (int) $result;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM {$this->tabla}";
        return $this->hacerConsulta($sql, [], 'all');
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE {$this->clavePrimaria} = ?";
        return $this->hacerConsulta($sql, [$id], 'single');
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM {$this->tabla} WHERE {$this->clavePrimaria} = ?";
        return $this->hacerConsulta($sql, [$id], 'execute');
    }

    public function insertar($datos)
    {
        $columnas = implode(", ", array_keys($datos));
        $placeholders = implode(", ", array_fill(0, count($datos), '?'));
        $sql = "INSERT INTO {$this->tabla} ({$columnas}) VALUES ({$placeholders})";
        return $this->hacerConsulta($sql, array_values($datos), 'execute');
    }

    public function actualizar($id, $datos)
    {
        $columnas = array_keys($datos);
        $asignaciones = array_map(fn ($col) => "$col = ?", $columnas);
        $set = implode(", ", $asignaciones);
        $sql = "UPDATE {$this->tabla} SET {$set} WHERE {$this->clavePrimaria} = ?";
        return $this->hacerConsulta($sql, [...array_values($datos), $id], 'execute');
    }
}
