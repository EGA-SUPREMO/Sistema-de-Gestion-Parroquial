<?php

//require_once 'Validador.php';
require_once 'Peticion.php';

class Intencion extends Peticion
{

/*    private $id;
    private $tipo_de_intencion_id;
    private $por_quien_id;
    private $fecha_inicio;
    private $fecha_fin;
*/
    public function __construct()
    {
        parent::__construct();
        $this->setServicioId(1);
    }

}
