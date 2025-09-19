<?php
class ServicioConstanciaDeBautizo
{
    private $pdo;
    private $gestorPeticion;
    private $gestorConstanciaDeBautizo;

    public function __construct(PDO $pdo, $gestorPeticion, $gestorConstanciaDeBautizo)
    {
        $this->pdo = $pdo;
        $this->gestorPeticion = $gestorPeticion;
        $this->gestorConstanciaDeBautizo = $gestorConstanciaDeBautizo;
    }

    public function registrarConstancia($peticion, $constancia, $datosFeligres)
    {
        $this->pdo->beginTransaction();

        try {
            $feligresRepo = new FeligresRepo($this->pdo);
            $feligres = $feligresRepo->buscarPorCedula($datosFeligres['cedula']);

            $feligresId = 0;

            if (!$feligres) {
                $nuevoFeligres = new Feligres();
                $nuevoFeligres->hydrate($datosFeligres);
                $feligresGuardado = $feligresRepo->guardar($nuevoFeligres);
                if (!$feligresGuardado) {
                    throw new Exception("Error al crear el nuevo feligrés.");
                }
                $feligresId = $this->pdo->lastInsertId();
            } else {
                // Ya existe, usamos su ID
                $feligresId = $feligres->getId();
            }
            
            $datosConstancia['feligres_id'] = $feligresId;

/*
            $peticionGuardada = $this->gestorPeticion->guardar($peticion);
            if (!$peticionGuardada) {
                throw new Exception("No se pudo guardar la petición.");
            }
            $constanciaId = $this->pdo->lastInsertId();

            $peticion->setConstanciaDeBautizoId($constanciaId);
*/
            $constanciaGuardada = $this->gestorConstanciaDeBautizo->guardar($constancia);
            if (!$constanciaGuardada) {
                throw new Exception("No se pudo guardar la constancia de bautizo.");
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de registro de constancia: " . $e->getMessage());
            return false;
        }
    }
}
