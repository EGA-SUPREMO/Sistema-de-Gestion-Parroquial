<?php

require_once 'GestorBase.php';

abstract class GestorConstancia extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function obtenerConstanciaIdPorSujetoSacramentoId($sujetos)
    {
        $resultado = $this->obtenerPor($sujetos, 'single');

        return $resultado ? $resultado->getId() : 0;
    }
    public function obtenerConstanciaPorSujetoSacramentoId($sujetos)
    {
        return $this->obtenerPor($sujetos, 'single');
    }
    public function obtenerConstanciaIdPorRegistroLibro($numero_libro, $numero_pagina, $numero_marginal)
    {
        $resultado = $this->obtenerPor(['numero_libro' => $numero_libro, 'numero_pagina' => $numero_pagina, 'numero_marginal' => $numero_marginal], 'single');
        return $resultado ? $resultado->getId() : 0;
    }
    
    public function verificarConsistenciaIds($sujetosSacramento, $numero_libro, $numero_pagina, $numero_marginal)
    {
        $idConstanciaEncontradaPorSujetoSacramento = $this->obtenerConstanciaIdPorSujetoSacramentoId($sujetosSacramento);
        $idConstanciaEncontradaPorLibro = $this->obtenerConstanciaIdPorRegistroLibro($numero_libro, $numero_pagina, $numero_marginal);

        if ($idConstanciaEncontradaPorSujetoSacramento !== $idConstanciaEncontradaPorLibro) {
            throw new Exception("Error: el feligrés y el registro de libro apuntan a constancias distintas (IDs: $idConstanciaEncontradaPorFeligres vs $idConstanciaEncontradaPorLibro).");
        }
    }

}
