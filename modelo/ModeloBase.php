<?php

abstract class ModeloBase
{
    public function hydrate($datos) {
        foreach ($datos as $llave => $valor) {
            $llaveConEspacios = str_replace('_', ' ', $llave);
            $palabrasCapitalizadas = ucwords($llaveConEspacios);
            $sinEspacios = str_replace(' ', '', $palabrasCapitalizadas);
            $setter = 'set' . $sinEspacios;
            
            if (method_exists($this, $setter)) {
                $this->$setter($valor);
            }
        }
    }
}
