<?php
require_once 'conexion.php';

class administrador
{
    private $conexion;
    public $nombre_usuario;
    public $password;

    public function __construct()
    {
        $this->conexion = base_datos::BD();
    }

    public function obtenerTodos()
    {
        $stmt = $this->conexion->prepare("SELECT * FROM administrador");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function obtenerPorId($id_admin)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM administrador WHERE id_admin = :id_admin");
        $stmt->bindParam(":id_admin", $id_admin, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function agregar($nombre_usuario, $password)
    {
        try {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            if ($password_hashed === false) {
                error_log("Password hashing failed for user: " . $nombre_usuario);
                print("Password hashing failed for user: " . $nombre_usuario);
                return false;
            }

            $stmt = $this->conexion->prepare("INSERT INTO administrador (nombre_usuario, password) VALUES (:nombre_usuario, :password)");
            $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password_hashed, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function eliminar($id)
    {
        try {
            $stmt = $this->conexion->prepare("DELETE FROM administrador WHERE id_admin = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editar($id, $nombre_usuario, $password)
    {
        try {
            $sql = "UPDATE administrador SET nombre_usuario = :nombre_usuario";
            if (!empty($password)) {
                $sql .= ", password = :password";
            }
            $sql .= " WHERE id_admin = :id";
            
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            if (!empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $password_hashed, PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function comprobar_datos_usuario($nombre_usuario, $password_ingresada) {
        try {
            $query = $this->conexion->prepare("SELECT password FROM administrador WHERE nombre_usuario = :nombre_usuario");
            $query->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $hash = $result['password'];
                if (password_verify($password_ingresada, $hash)) {
                    session_start();
                    $_SESSION['nombre_usuario'] = $nombre_usuario;
                    return true;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error verificando password: " . $e->getMessage());
            return false;
        }
    }
}
