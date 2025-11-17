<?php

abstract class GestorBase
{
    protected $pdo;
    protected $tabla;
    protected $clavePrimaria;
    protected $clase_nombre;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this ->clavePrimaria = 'id';
    }

    protected function hacerConsulta($consulta, $parametros, $modo_fetch = 'all')
    {
        try {
            $stmt = $this->pdo->prepare($consulta);
            $stmt->execute($parametros);
            switch ($modo_fetch) {
                case 'all':
                    return $stmt->fetchAll(PDO::FETCH_CLASS, $this->clase_nombre);
                case 'single':
                    //$resultado = $stmt->fetchObject($this->clase_nombre);
                    //error_log(print_r($resultado, true));
                    return $stmt->fetchObject($this->clase_nombre);
                case 'column':
                    return $stmt->fetchColumn();
                case 'assoc':
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                case 'insert':
                    return (int)$this->pdo->lastInsertId();
                case 'update':
                default:
                    return $stmt->rowCount();
            }
        } catch (PDOException $e) {
            error_log("Error ejecutando consulta para tabla {$this->tabla}: " . $e->getMessage() . " Consulta: " . $consulta . " Parametros: " . print_r($parametros, true));
            throw new Exception("Error ejecutando consulta para tabla: {$this->tabla}");
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
        return $this->obtenerPor([], 'all');
    }

    public function obtenerPorId($id)
    {
        return $this->obtenerPor([$this->clavePrimaria => $id], 'single');
    }

    public function obtenerPor(array $condiciones, string $modo)
    {
        $sql = "SELECT * FROM {$this->tabla}";
        $valores = [];

        if (!empty($condiciones)) {
            $clausulas = [];

            foreach ($condiciones as $columna => $valor) {
                $clausulas[] = "$columna = ?";
            }

            $sql .= " WHERE " . implode(' AND ', $clausulas);

            $valores = array_values($condiciones);
        }

        return $this->hacerConsulta($sql, $valores, $modo);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM {$this->tabla} WHERE {$this->clavePrimaria} = ?";
        return $this->hacerConsulta($sql, [$id], 'execute');
    }

    protected function insertar($objeto)
    {
        $datos = $objeto->toArrayParaBD($objeto);

        $columnas = implode(", ", array_keys($datos));
        $placeholders = implode(", ", array_fill(0, count($datos), '?'));
        $sql = "INSERT INTO {$this->tabla} ({$columnas}) VALUES ({$placeholders})";
        $id = $this->hacerConsulta($sql, array_values($datos), 'insert');
        $objeto->setId($id);

        return $id;
    }

    protected function actualizar($id, $objeto)
    {
        $datos = $objeto->toArrayParaBD($objeto, true);

        $columnas = array_keys($datos);
        $asignaciones = array_map(fn ($col) => "$col = ?", $columnas);
        $set = implode(", ", $asignaciones);
        $sql = "UPDATE {$this->tabla} SET {$set} WHERE {$this->clavePrimaria} = ?";
        return $this->hacerConsulta($sql, [...array_values($datos), $id], 'update');
    }
    public function guardar($objeto, $id = 0)
    {
        $this->validarDedendecias($objeto);
        if ($id) {
            return $this->actualizar($id, $objeto);
        }
        return $this->insertar($objeto);
    }

    public function getClavePrimaria()
    {
        return $this->clavePrimaria;
    }
    protected function validarDedendecias($objeto)
    {
    }
}
