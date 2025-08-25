<?php

class Administrador {
    
    private $id_admin;
    private $nombre_usuario;
    private $password;

    public function getIdAdmin(): ?int {
        return $this->id_admin;
    }

    public function getNombreUsuario(): ?string {
        return $this->nombre_usuario;
    }

    
    public function getPassword(): ?string {
        return $this->password;
    }

    public function setIdAdmin(?int $id_admin): void {
        if ($id_admin !== null && !is_int($id_admin)) {
            throw new InvalidArgumentException("El ID de admin debe ser un número entero.");
        }
        $this->id_admin = $id_admin;
    }
    public function setNombreUsuario(?string $nombre_usuario): void {
        if ($nombre_usuario !== null) {
            $nombre_usuario = trim($nombre_usuario);
            if (empty($nombre_usuario)) {
                throw new InvalidArgumentException("El nombre de usuario no puede estar vacío.");
            }
            if (strlen($nombre_usuario) > 30) {
                throw new InvalidArgumentException("El nombre de usuario no puede exceder los 30 caracteres.");
            }
        }
        $this->nombre_usuario = $nombre_usuario;
    }

    public function setPassword(?string $password): void {
        if ($password !== null) {
            if (empty($password)) {
                throw new InvalidArgumentException("La contraseña no puede estar vacía.");
            }
        }
        $this->password = $password;
    }
} 
