<?php

require_once 'modelo/GestorBase.php';

class GestorAdministrador extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "administrador";
        $this ->clavePrimaria = 'id_admin';
        $this ->clase_nombre = "Administrador";
    }

    public function insertar($datos)
    {
        try {
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
            if (!$datos['password']) {
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
        if (!empty($datos['password'])) {
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        }
        return parent::actualizar($id, $datos);
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
