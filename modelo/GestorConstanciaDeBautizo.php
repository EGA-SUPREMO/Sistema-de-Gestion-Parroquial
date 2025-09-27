<?php

require_once 'modelo/GestorBase.php';
require_once 'modelo/GestorFeligres.php';
require_once 'modelo/GestorSacerdote.php';
require_once 'modelo/GestorPeticion.php';

require_once 'modelo/GeneradorPdf.php';
require_once 'modelo/ConstanciaDeBautizo.php';

class GestorConstanciaDeBautizo extends GestorBase
{
    private $gestorFeligres;
    private $gestorSacerdote;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_bautizo";
        $this ->clase_nombre = "ConstanciaDeBautizo";

        $this->gestorFeligres = new GestorFeligres($pdo);
        $this->gestorSacerdote = new GestorSacerdote($pdo);
    }

    public function obtenerConstanciaIdPorFeligresId($id)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `feligres_bautizado_id` = ?";
        $resultado = $this->hacerConsulta($sql, [$id], 'single');
        return $resultado ? $resultado->getId() : 0;
    }
    public function obtenerConstanciaIdPorRegistroLibro($numero_libro, $numero_pagina, $numero_marginal)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `numero_libro` = ? AND `numero_pagina` = ? AND `numero_marginal` = ?";
        $resultado = $this->hacerConsulta($sql, [$numero_libro, $numero_pagina, $numero_marginal], 'single');
        return $resultado ? $resultado->getId() : 0;
    }
    public function verificarConsistenciaIds($feligresId, $numero_libro, $numero_pagina, $numero_marginal)
    {
        $idConstanciaEncontradaPorFeligres = $this->obtenerConstanciaIdPorFeligresId($feligresId);
        $idConstanciaEncontradaPorLibro = $this->obtenerConstanciaIdPorRegistroLibro($numero_libro, $numero_pagina, $numero_marginal);

        if ($idConstanciaEncontradaPorFeligres !== $idConstanciaEncontradaPorLibro) {   
            throw new Exception("Error: el feligrés y el registro de libro apuntan a constancias distintas (IDs: $idConstanciaEncontradaPorFeligres vs $idConstanciaEncontradaPorLibro).");
        }
    }

}
