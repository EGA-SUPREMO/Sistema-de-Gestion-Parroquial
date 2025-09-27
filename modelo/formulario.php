<?php

$data = json_decode($_POST['json'], true);

$usuario = $data['usuario'][0];
echo "Hola, yutgio, $usuario!";
