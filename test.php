<?php 

include'autoload.php';

$funciones = new Funciones();

$fullname = "LUIS AUGUSTO CLAUDIO PONCE";

$query = "SELECT * FROM plantilla_correo";
$dato  = $funciones->query($query)[0];

$email =  $dato['seccion_1']. $dato['seccion_2']. $dato['seccion_3']. $dato['seccion_4']. $dato['seccion_5'];

$email = str_replace('#cliente#','<strong>'.$fullname.'</strong>', $email);

echo $email;

 ?>