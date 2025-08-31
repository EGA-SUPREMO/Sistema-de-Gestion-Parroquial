<?php
require_once 'modelo/Validador.php';

class Administrador {
    
    private $id_admin;
    private $nombre_usuario;
    private $password;

    public function getIdAdmin() {
        return $this->id_admin;
    }

    public function getNombreUsuario() {
        return $this->nombre_usuario;
    }
    public function getPassword() {
        return $this->password;
    }

    public function setIdAdmin($id_admin) {
        $this->id_admin = Validador::validarEntero($id_admin, "id de administrador");
    }

    public function setNombreUsuario($nombre_usuario) {
        $this->nombre_usuario = Validador::validarString($nombre_usuario, "nombre de usuario", 30, 3);
        if ($this->nombre_usuario !== null) {
            $this->nombre_usuario = strtolower($this->nombre_usuario);
        }
    }

    public function setPassword($password, $encriptar = true)
    {
        $this->password = Validador::validarString($password, 'contraseña', 255, 6);

        if ($encriptar) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            if ($hashed_password === false) {
                throw new Exception("Error al encriptar la contraseña para usuario: " . $this -> nombre_usuario);
            }
            $this->password = $hashed_password;
        }
    }
} 
