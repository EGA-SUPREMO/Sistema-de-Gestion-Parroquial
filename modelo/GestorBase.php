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
                    return $stmt->rowCount(); // para UPDATE, DELETE, etc.
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

    protected function insertar($objeto)
    {
        $datos = self::get_object_vars_reflection($objeto);
        $columnas = implode(", ", array_keys($datos));
        $placeholders = implode(", ", array_fill(0, count($datos), '?'));
        $sql = "INSERT INTO {$this->tabla} ({$columnas}) VALUES ({$placeholders})";
        return $this->hacerConsulta($sql, array_values($datos), 'execute');
    }

    protected function actualizar($id, $objeto)
    {
        $datos = self::get_object_vars_reflection($objeto);
        unset($datos[$this->clavePrimaria]);

        $columnas = array_keys($datos);
        $asignaciones = array_map(fn ($col) => "$col = ?", $columnas);
        $set = implode(", ", $asignaciones);
        $sql = "UPDATE {$this->tabla} SET {$set} WHERE {$this->clavePrimaria} = ?";
        return $this->hacerConsulta($sql, [...array_values($datos), $id], 'execute');
    }
    public function guardar($objeto, $id = 0)
    {
        if ($id) {
            return $this->actualizar($id, $objeto);
        }
        return $this->insertar($objeto);

    }

    private static function get_object_vars_reflection($objeto)
    {
        $reflector = new ReflectionClass($objeto);
        $propiedades = $reflector->getProperties();

        $array_de_propiedades = [];

        foreach ($propiedades as $propiedad) {
            $propiedad->setAccessible(true);
            $nombre = $propiedad->getName();
            $valor = $propiedad->getValue($objeto);

            if ($valor === null) {
                continue;
            }
            $array_de_propiedades[$nombre] = $valor;
        }

        return $array_de_propiedades;
    }
    public function getClavePrimaria()
    {
        return $this->clavePrimaria;
    }
}
