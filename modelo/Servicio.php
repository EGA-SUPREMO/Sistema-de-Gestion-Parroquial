<?php

require_once 'Validador.php';

class Servicio
{
    private $id;
    private $id_categoria;
    private $nombre;
    private $descripcion;

    public function getId()
    {
        return $this->id;
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "id", null, 0);
    }
    public function setIdCategoria($id)
    {
        $this->id_categoria = Validador::validarEntero($id_categoria, "id de categoria", null, 0);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = Validador::validarString($nombre, "nombre", 100, 3);
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = Validador::validarString($descripcion, "descripcion");
    }
}
