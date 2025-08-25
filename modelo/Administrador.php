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
        $this->id_admin = Validador::validarEntero($id_admin, "id_admin");
    }

    public function setNombreUsuario($nombre_usuario) {
        $this->nombre_usuario = Validador::validarString($nombre_usuario, "nombre", 30, 3);
    }

    public function setPassword($password) {
        $this->password = $password;
    }
} 
