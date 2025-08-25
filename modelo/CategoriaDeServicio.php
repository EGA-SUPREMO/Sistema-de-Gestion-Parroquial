<?php

class CategoriaDeServicios {
    
    private $id;
    private $nombre;
    private $descripcion;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if ($id !== null && !is_int($id)) {
            throw new InvalidArgumentException("El ID debe ser un número entero.");
        }
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        if ($nombre !== null) {
            $nombre = trim($nombre);
            if (empty($nombre)) {
                throw new InvalidArgumentException("El nombre no puede estar vacío.");
            }
            if (strlen($nombre) > 100) {
                throw new InvalidArgumentException("El nombre no puede exceder los 100 caracteres.");
            }
        }
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        if ($descripcion !== null) {
            $descripcion = trim($descripcion);
        }
        $this->descripcion = $descripcion;
    }
}