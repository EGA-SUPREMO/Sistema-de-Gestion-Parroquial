<?php

require_once 'modelo/Validador.php';

class CategoriaDeServicios {
    
    private $id;
    private $nombre;
    private $descripcion;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = Validador::validarEntero($id, "id");
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = Validador::validarString($nombre, "nombre", 100, 3);
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = Validador::validarString($descripcion, "descripcion");
    }
}