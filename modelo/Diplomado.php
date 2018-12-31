<?php 

class Diplomado extends Conexion
{


function consulta($id)
{

try {
	
$conexion = $this->get_conexion();
$query    = "SELECT * FROM mdlwf_programmed_course WHERE id=:id";
$statement= $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result   = $statement->fetch(PDO::FETCH_ASSOC);
return $result;

} catch (Exception $e) {
	
echo "Error: "$e->getMessage();

}


}






}



 ?>