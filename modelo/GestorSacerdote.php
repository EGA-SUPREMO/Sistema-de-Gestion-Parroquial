<?php

require_once 'GestorBase.php';
require_once 'Sacerdote.php';

class GestorSacerdote extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "sacerdotes";
        $this ->clase_nombre = "Sacerdote";
    }

}
