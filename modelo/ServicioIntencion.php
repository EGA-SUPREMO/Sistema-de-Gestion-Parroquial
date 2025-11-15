<?php

require_once 'Intencion.php';
require_once 'GestorPeticion.php';
require_once 'GestorObjetoDePeticion.php';
require_once 'GestorIntencion.php';
require_once 'GestorMisa.php';
require_once 'ServicioBase.php';

class ServicioIntencion extends ServicioBase
{
    private $gestorObjetoDePeticion;
    private $gestorIntencion;
    private $gestorMisa;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->gestorObjetoDePeticion = new GestorObjetoDePeticion($pdo);
        $this ->gestorIntencion = new GestorIntencion($pdo);
        $this ->gestorMisa = new GestorMisa($pdo);
    }

    public function guardar($intencion, $id = 0)
    {
        return $this->ejecutarEnTransaccion(function() use ($intencion, $id) {

            $objetoDePeticion = $this->gestorObjetoDePeticion->obtenerPorNombre($intencion->obtenerObjetoDePeticionNombre());
            if (!$objetoDePeticion) {
                $objetoDePeticion = new ObjetoDePeticion();
                $objetoDePeticion ->setNombre($intencion->obtenerObjetoDePeticionNombre());
                $this->gestorObjetoDePeticion->guardar($objetoDePeticion);
            }
            $intencion->setObjetoDePeticionId($objetoDePeticion->getId());
            $resultado = $this->gestorIntencion->guardar($intencion, $id);

            return $resultado;
        }, "de registro o edicion de intencion");
    }
}
