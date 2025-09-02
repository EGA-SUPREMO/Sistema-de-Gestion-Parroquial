<?php
require_once 'modelo/Validador.php';
require_once 'modelo/ModeloBase.php';

class Administrador extends ModeloBase {
    
    private $id;
    private $nombre_usuario;
    private $password;

    public function getIdAdmin() {
        return $this->id;
    }

    public function getNombreUsuario() {
        return $this->nombre_usuario;
    }
    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = Validador::validarEntero($id, "id de administrador");
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
