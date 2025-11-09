<?php

require_once 'Intencion.php';
require_once 'GestorPeticion.php';
require_once 'GestorObjetoDePeticion.php';
require_once 'GestorIntencion.php';
require_once 'ServicioBase.php';

class ServicioIntencion extends ServicioBase
{
    private $gestorObjetoDePeticion;
    private $gestorIntencion;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->gestorObjetoDePeticion = new GestorObjetoDePeticion($pdo);
        $this ->gestorIntencion = new GestorIntencion($pdo);
    }

    public function guardar($intencion, $id = 0)
    {
        $this->pdo->beginTransaction();
        try {
            $objetoDePeticion = $this->gestorObjetoDePeticion->obtenerPorNombre($intencion->obtenerObjetoDePeticionNombre());
            if(!$objetoDePeticion) {
                $objetoDePeticion = new ObjetoDePeticion();
                $objetoDePeticion ->setNombre($intencion->obtenerObjetoDePeticionNombre());
                $this->gestorObjetoDePeticion->guardar($objetoDePeticion);
            }
            $intencion->setObjetoDePeticionId($objetoDePeticion->getId());
            $resultado = $this->gestorIntencion->guardar($intencion, $id);

            $this->pdo->commit();
            return $resultado;    
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro o edicion de intencion: " . $e->getMessage());    
            throw new Exception($e->getMessage());
        }
    }
}
