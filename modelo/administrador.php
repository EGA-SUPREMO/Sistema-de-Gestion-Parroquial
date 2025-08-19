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

    public function agregar($nombre_usuario, $password)
    {
        try {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            if ($password_hashed === false) {
                error_log("Password hashing failed for user: " . $nombre_usuario);
                print("Password hashing failed for user: " . $nombre_usuario);
                return false;
            }

            $stmt = $this->db->prepare("INSERT INTO administrador (nombre_usuario, password) VALUES (:nombre_usuario, :password)");
            $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password_hashed, PDO::PARAM_STR);
            $stmt->execute();
            return true;
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

    public function editar($id, $nombre_usuario, $password)
    {
        try {
            $sql = "UPDATE administrador SET nombre_usuario = :nombre_usuario";
            if (!empty($password)) {
                $sql .= ", password = :password";
            }
            $sql .= " WHERE id_admin = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            if (!empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $password_hashed, PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function comprobar_datos_usuario($nombre_usuario, $password_ingresada)
    {
        try {
            $query = $this->db->prepare("SELECT password FROM administrador WHERE nombre_usuario = :nombre_usuario");
            $query->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $hash = $result['password'];

                return password_verify($password_ingresada, $hash);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error verificando password: " . $e->getMessage());
            return false;
        }
    }
}
