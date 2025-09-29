<?php

$datos = json_decode($_POST['json'], true);

$usuario = $datos['feligres_cedula-padre'][0];
echo "Hola, yutgio, $usuario!";
