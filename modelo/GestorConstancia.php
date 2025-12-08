<?php

require_once 'GestorBase.php';

abstract class GestorConstancia extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    abstract protected function mapearSujetosACriterios($sujetos);

    public function obtenerConstanciaIdPorSujetoSacramentoId($sujetos)
    {
        $criterios = $this->mapearSujetosACriterios($sujetos);
        $resultado = $this->obtenerPor($criterios, 'single');

        return $resultado ? $resultado->getId() : 0;
    }

    public function obtenerConstanciaPorSujetoSacramentoId($sujetos)
    {
        $criterios = $this->mapearSujetosACriterios($sujetos);
        return $this->obtenerPor($criterios, 'single');
    }

    public function obtenerConstanciaIdPorRegistroLibro($numero_libro, $numero_pagina, $numero_marginal)
    {
        $resultado = $this->obtenerPor(['numero_libro' => $numero_libro, 'numero_pagina' => $numero_pagina, 'numero_marginal' => $numero_marginal], 'single');
        return $resultado ? $resultado->getId() : 0;
    }
    public function obtenerConstanciaPorRegistroLibro($registroLibro)
    {
        return $this->obtenerPor(['numero_libro' => $registroLibro[0], 'numero_pagina' => $registroLibro[1], 'numero_marginal' => $registroLibro[2]], 'single');
    }

    public function verificarConsistenciaIds($sujetosSacramentoIds, $numero_libro, $numero_pagina, $numero_marginal)
    {
        $idConstanciaEncontradaPorSujetoSacramento = $this->obtenerConstanciaIdPorSujetoSacramentoId($sujetosSacramentoIds);
        $idConstanciaEncontradaPorLibro = $this->obtenerConstanciaIdPorRegistroLibro($numero_libro, $numero_pagina, $numero_marginal);

        if ($idConstanciaEncontradaPorSujetoSacramento !== $idConstanciaEncontradaPorLibro) {
            throw new Exception("Error: el sujeto de sacramento y el registro de libro apuntan a constancias distintas (IDs: $idConstanciaEncontradaPorSujetoSacramento vs $idConstanciaEncontradaPorLibro).");
        }
    }

}
