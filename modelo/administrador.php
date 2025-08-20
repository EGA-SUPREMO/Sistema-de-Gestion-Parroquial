<?php

require_once 'modelo/ModeloBase.php';

class administrador extends ModeloBase
{
    public $nombre_usuario;
    public $password;
    public $id_admin;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "administrador";
        $this ->clavePrimaria = 'id_admin';
    }

    public function insertar($datos)
    {
        try {
            $password_hashed = password_hash($datos['password'], PASSWORD_DEFAULT);
            if (!$password_hashed) {
                error_log("Password hashing fallo para usuario: " . $datos['nombre_usuario']);
                return false;
            }

            return parent::insertar($datos);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function eliminar($id)
    {
        if ($this->contarTodos() <= 1) {
            throw new Exception("No se puede eliminar el ultimo administrador", 403);
        }
        parent::eliminar($id);
    }

    public function actualizar($id, $datos)
    {
        try {
            $sql = "UPDATE administrador SET nombre_usuario = ?";
            if (!empty($datos['password'])) {
                $sql .= ", password = ?";
                $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
            }
            $sql .= " WHERE id_admin = ?";
            return $this -> hacerConsulta($sql, [...array_values($datos), $id], "execute");
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function comprobar_datos_usuario($nombre_usuario, $password_ingresada)
    {
        try {
            $consulta = "SELECT password FROM administrador WHERE nombre_usuario = ?";
            $resultado = $this->hacerConsulta($consulta, [$nombre_usuario], 'assoc');

            if ($resultado) {
                $hash = $resultado['password'];

                return password_verify($password_ingresada, $hash);
            }

            return false;
        } catch (PDOException $e) {
            error_log("Error verificando password: " . $e->getMessage());
            return false;
        }
    }
}
