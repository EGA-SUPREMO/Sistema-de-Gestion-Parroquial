<?php

require_once 'Validador.php';
require_once 'ModeloBase.php';

class Feligres extends ModeloBase
{
    private $id;
    private $primer_nombre;
    private $segundo_nombre;
    private $primer_apellido;
    private $segundo_apellido;
    private $fecha_nacimiento;
    private $localidad;
    private $municipio;
    private $estado;
    private $pais;
    private $cedula;
    private $partida_de_nacimiento;

    public function getId()
    {
        return $this->id;
    }

    public function getPrimerNombre()
    {
        return $this->primer_nombre;
    }

    public function getSegundoNombre()
    {
        return $this->segundo_nombre;
    }

    public function getPrimerApellido()
    {
        return $this->primer_apellido;
    }

    public function getSegundoApellido()
    {
        return $this->segundo_apellido;
    }

    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    public function getMunicipio()
    {
        return $this->municipio;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getPais()
    {
        return $this->pais;
    }

    public function getCedula()
    {
        return $this->cedula;
    }

    public function getPartidaDeNacimiento()
    {
        return $this->partida_de_nacimiento;
    }

    public function setId($id)
    {
        $this->id = Validador::validarEntero($id, "id de feligrés", null, 0);
    }

    public function setPrimerNombre($primer_nombre)
    {
        $this->primer_nombre = Validador::validarString($primer_nombre, "primer nombre", 50, 2);

        if ($this->primer_nombre !== null) {
            $this->primer_nombre = ucwords($this->primer_nombre);
        }
    }

    public function setSegundoNombre($segundo_nombre)
    {
        $this->segundo_nombre = Validador::validarString($segundo_nombre, "segundo nombre", 50, 2);

        if ($this->segundo_nombre !== null) {
            $this->segundo_nombre = ucwords($this->segundo_nombre);
        }
    }

    public function setPrimerApellido($primer_apellido)
    {
        $this->primer_apellido = Validador::validarString($primer_apellido, "primer apellido", 50, 2);

        if ($this->primer_apellido !== null) {
            $this->primer_apellido = ucwords($this->primer_apellido);
        }
    }

    public function setSegundoApellido($segundo_apellido)
    {
        $this->segundo_apellido = Validador::validarString($segundo_apellido, "segundo apellido", 50, 2);

        if ($this->segundo_apellido !== null) {
            $this->segundo_apellido = ucwords($this->segundo_apellido);
        }
    }

    public function setFechaNacimiento($fecha_nacimiento)
    {
        $fecha_actual = (new DateTime())->format('Y-m-d');
        $this->fecha_nacimiento = Validador::validarFecha($fecha_nacimiento, "fecha de nacimiento", "1900-01-01", $fecha_actual);
    }

    public function setMunicipio($municipio)
    {
        $this->municipio = Validador::validarString($municipio, "municipio de nacimiento", 50, 4);

        if ($this->municipio !== null) {
            $this->municipio = ucwords(strtolower($this->municipio));
        }
    }
    public function setLocalidad($localidad)
    {
        $this->localidad = Validador::validarString($localidad, "localidad de nacimiento", 50, 4);

        if ($this->localidad !== null) {
            $this->localidad = ucwords(strtolower($this->localidad));
        }
    }

    public function setEstado($estado)
    {
        $this->estado = Validador::validarString($estado, "estado de nacimiento", 50, 4);

        if ($this->estado !== null) {
            $this->estado = ucwords(strtolower($this->estado));
        }
    }

    public function setPais($pais)
    {
        $this->pais = Validador::validarString($pais, "pais de nacimiento", 50, 4);

        if ($this->pais !== null) {
            $this->pais = ucwords(strtolower($this->pais));
        }
    }

    public function setCedula($cedula)
    {
        $this->cedula = Validador::validarEntero($cedula, "cédula", 100000000, 999);
    }
    public function setPartidaDeNacimiento($partida_de_nacimiento)
    {
        $this->partida_de_nacimiento = Validador::validarString($partida_de_nacimiento, "partida de nacimiento", 30, 4);
        if ($this->partida_de_nacimiento !== null) {
            $this->partida_de_nacimiento = strtoupper($this->partida_de_nacimiento);
        }
    }
    public function lugarDeNacimiento()
    {
        $partes = [];
        if (!empty($this->municipio)) {
            $partes[] = $this->municipio;
        }
        if (!empty($this->estado)) {
            $partes[] = 'Estado ' . $this->estado;
        }
        if (!empty($this->pais)) {
            $partes[] = 'País ' . $this->pais;
        }

        return implode(' - ', $partes);
    }
    public function nombreCompleto()
    {
        $partes = [];
        if (!empty($this->primer_nombre)) {
            $partes[] = $this->primer_nombre;
        }
        if (!empty($this->segundo_nombre)) {
            $partes[] = $this->segundo_nombre;
        }
        if (!empty($this->primer_apellido)) {
            $partes[] = $this->primer_apellido;
        }
        if (!empty($this->segundo_apellido)) {
            $partes[] = $this->segundo_apellido;
        }

        return implode(' ', $partes);
    }
}
