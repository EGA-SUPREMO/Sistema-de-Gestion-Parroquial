<?php

require_once 'GestorConstancia.php';

require_once 'ConstanciaDeMatrimonio.php';

class GestorConstanciaDeMatrimonio extends GestorConstancia
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "constancia_de_matrimonio";
        $this ->clase_nombre = "ConstanciaDeMatrimonio";
    }
    protected function mapearSujetosACriterios($sujetos)
    {
        if (!is_array($sujetos) || !isset($sujetos['contrayente_1'], $sujetos['contrayente_2'])) {
            throw new Exception("Error interno: Para validar matrimonio se requieren los IDs de contrayente_1 y contrayente_2.");
        }

        return [
            'contrayente_1_id' => $sujetos['contrayente_1'],
            'contrayente_2_id' => $sujetos['contrayente_2']
        ];
    }
}
