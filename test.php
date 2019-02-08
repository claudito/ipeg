<?php 

include'autoload.php';

$conexion = new Conexion();
$conexion = $conexion->get_conexion();

echo URL;
echo "<br>";

$query =  "SELECT * FROM plantilla_correo WHERE id=1";
$statement = $conexion->prepare($query);
$statement->execute();

$result = $statement->fetch();

$banner = URL.'uploads/banner/'.$result['banner'];

$html  = $result['cuerpo'];
$html  = str_replace('banner_correo', $banner, $html);


echo $html;


 ?>