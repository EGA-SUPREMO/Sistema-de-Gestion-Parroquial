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
    private $municipio_de_nacimiento;
    private $estado_de_nacimiento;
    private $pais_de_nacimiento;
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

    public function getMunicipioDeNacimiento()
    {
        return $this->municipio_de_nacimiento;
    }
    public function getEstadoDeNacimiento()
    {
        return $this->estado_de_nacimiento;
    }
    public function getPaisDeNacimiento()
    {
        return $this->pais_de_nacimiento;
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
        $this->id = Validador::validarEntero($id, "id de feligrés", null, 1);
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

    public function setMunicipioDeNacimiento($municipio_de_nacimiento)
    {
        $this->municipio_de_nacimiento = Validador::validarString($municipio_de_nacimiento, "municipio de nacimiento", 50, 4);

        if ($this->municipio_de_nacimiento !== null) {
            $this->municipio_de_nacimiento = ucwords(strtolower($this->municipio_de_nacimiento));
        }
    }

    public function setEstadoDeNacimiento($estado_de_nacimiento)
    {
        $this->estado_de_nacimiento = Validador::validarString($estado_de_nacimiento, "estado de nacimiento", 50, 4);

        if ($this->estado_de_nacimiento !== null) {
            $this->estado_de_nacimiento = ucwords(strtolower($this->estado_de_nacimiento));
        }
    }

    public function setPaisDeNacimiento($pais_de_nacimiento)
    {
        $this->pais_de_nacimiento = Validador::validarString($pais_de_nacimiento, "pais de nacimiento", 50, 4);

        if ($this->pais_de_nacimiento !== null) {
            $this->pais_de_nacimiento = ucwords(strtolower($this->pais_de_nacimiento));
        }
    }

    public function setCedula($cedula)
    {
        $this->cedula = Validador::validarEntero($cedula, "cédula", 100000000, 1000);
    }

    public function setPartidaDeNacimiento($partida_de_nacimiento)
    {
        $this->partida_de_nacimiento = Validador::validarString($partida_de_nacimiento, "partida de nacimiento", 30, 4);
    }
    public function lugarDeNacimiento()
    {
        $partes = [];
        if (!empty($this->municipio_nacimiento)) {
            $partes[] = $this->municipio_nacimiento;
        }
        if (!empty($this->estado_nacimiento)) {
            $partes[] = $this->estado_nacimiento;
        }
        if (!empty($this->pais_nacimiento)) {
            $partes[] = $this->pais_nacimiento;
        }

        return implode(' - ', $partes);
    }
}
