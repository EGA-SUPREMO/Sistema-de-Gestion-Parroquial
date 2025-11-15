<?php

class ServicioBase
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function ejecutarEnTransaccion(Closure $operacion, $error_mensaje)
    {
        $this->pdo->beginTransaction();
        try {
            $resultado = $operacion();

            $this->pdo->commit();
            return $resultado;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en la transacción de " . $error_mensaje . ": " . $e->getMessage());
            throw $e;
        }
    }

}
