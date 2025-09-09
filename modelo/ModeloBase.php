<?php

require_once 'FuncionesComunes.php';

abstract class ModeloBase
{
    public function hydrate($datos)
    {
        foreach ($datos as $llave => $valor) {
            $setter = 'set' . FuncionesComunes::formatearSnakeCaseAPascalCase($llave);

            if (method_exists($this, $setter)) {
                $this->$setter($valor);
            }
        }
    }
    public function toArrayParaBD($excluirId = false)
    {
        $datos = [];
        $metodos = get_class_methods($this);

        foreach ($metodos as $nombreDeMetodo) {
            if (strpos($nombreDeMetodo, 'get') === 0) {
                $pascalCaseNombrePropiedad = substr($nombreDeMetodo, 3);
                if (empty($pascalCaseNombrePropiedad)) {
                    continue;
                }
                $patron = '/
                    (?<!^) # Inspección negativa: Revisa que no estamos al inicio de la cadena.
                    [A-Z]  # El objetivo a encontrar
                /x';
                $snakeCaseConMayusculas = preg_replace($patron, '_$0', $pascalCaseNombrePropiedad);
                $snakeCaseNombre = strtolower($snakeCaseConMayusculas);
                $datos[$snakeCaseNombre] = $this->$nombreDeMetodo();
            }
        }

        if ($excluirId) {
            unset($datos['id']);
        }
        
        return $datos;
    }
    public function toArrayParaMostrar($criterio = null)
    {
        return $this->toArrayParaBD();
    }
}
