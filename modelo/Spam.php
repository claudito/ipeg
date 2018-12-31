<?php 

class Spam extends Conexion
{ 

function agregar($correo,$fullname,$id_reserva)
{

try {
	
$conexion = $this->get_conexion();
$query    = "SELECT * FROM correo_spam WHERE 
correo=:correo AND fullname=:fullname";
$statement = $conexion->prepare($query);
$statement->bindParam(':correo',$correo);
$statement->bindParam(':fullname',$fullname);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{
 
 return "existe";

}
else
{

$query =  "INSERT INTO correo_spam(correo,fullname,id_reserva)VALUES
(:correo,:fullname,:id_reserva)";
$statement = $conexion->prepare($query);
$statement->bindParam(':correo',$correo);
$statement->bindParam(':fullname',$fullname);
$statement->bindParam(':id_reserva',$id_reserva);
$statement->execute();
return "ok";

}



} catch (Exception $e) {

echo "Error: ".$e->getMessage();
	
}

}


}


 ?>