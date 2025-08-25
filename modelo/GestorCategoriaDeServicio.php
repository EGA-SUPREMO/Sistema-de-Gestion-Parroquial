<?php
require_once 'modelo/GestorBase.php';

class GestorCategoriaDeServicio extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "CategoriaDeServicio";
        $this ->tabla = "categoria_de_servicios";
    }
}
 
