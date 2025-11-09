<?php

require_once 'Intencion.php';
require_once 'GestorPeticion.php';
require_once 'GestorObjetoDePeticion.php';

class GestorIntencion extends GestorPeticion
{
    private $gestorObjetoDePeticion;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->gestorObjetoDePeticion = new GestorObjetoDePeticion($pdo);
        $this ->clase_nombre = "Intencion";
        $this ->tabla = "peticiones";
    }

    public function guardar($intencion, $id = 0)
    {
        $this->pdo->beginTransaction();
        try {
            $objetoDePeticion = $this->gestorObjetoDePeticion->obtenerPorNombre($intencion->getObjetoDePeticionNombre());
            if(!$objetoDePeticion) {
                $objetoDePeticion = new ObjetoDePeticion();
                $objetoDePeticion ->setNombre($intencion->getObjetoDePeticionNombre());
                $this->gestorObjetoDePeticion->guardar($objetoDePeticion);
            }
            $intencion->setObjetoDePeticionId($objetoDePeticion->getId());
            $resultado = parent::guardar($intencion, $id);

            $this->pdo->commit();
            return $resultado;    
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro o edicion de intencion: " . $e->getMessage());    
            throw new Exception($e->getMessage());
        }
    }
}
