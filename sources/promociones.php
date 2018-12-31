<?php 

include'../autoload.php';

$session =  new Session();
$session->validity();

$opcion     = $_REQUEST['op'];
$funciones  = new Funciones();

$conexion   =  new Conexion();
$conexion   =  $conexion->get_conexion();

$userCreate = $_SESSION[KEY.NOMBRES].' '.$_SESSION[KEY.APELLIDOS];
$dateCreate = date('Y-m-d H:i:s');

switch ($opcion) {
case 1:
header("Content-type: application/json; charset=utf-8");

$query =  "SELECT  * FROM promocion_curso";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
'nombre'=>$value['nombre'],
'estado'=>$value['estado'],
'acciones'=>'

<button type="button" class="btn btn-primary btn-edit btn-sm" data-id="'.$value['id'].'"><i class="fa fa-edit"></i></button>

 '



 ];

}

$results = ["sEcho" => 1,
          "iTotalRecords" => count($data),
          "iTotalDisplayRecords" => count($data),
          "aaData" => $data 
           ];
echo json_encode($results);

break;

case 2:

$id = $_REQUEST['id'];

$query =  "SELECT * FROM promocion_curso WHERE id=".$id;
$result = $funciones->query($query)[0];

echo json_encode($result);

break;

case 3:

$nombre = $funciones->validar_xss($_REQUEST['nombre']);
$estado = $funciones->validar_xss($_REQUEST['estado']);

if($_REQUEST['tipo']=='agregar')
{

//Agregar
try {
	
$query  =  "SELECT  * FROM promocion_curso WHERE nombre=:nombre";
$statement = $conexion->prepare($query);
$statement->bindParam(':nombre',$nombre);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'El nombre ya esta registrado'));

}
else
{

$query  =  "INSERT INTO  promocion_curso(nombre,estado)
VALUES(:nombre,:estado)";
$statement = $conexion->prepare($query);
$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':estado',$estado);
$statement->execute();
echo json_encode(array('title'=>'Buen Trabajo','type'=>'success','text'=>'Registro Agregado'));


}


} catch (Exception $e) {

echo "Error: ".$e->getMessage();
	
}



}
else
{

//Actualizar
$id     = $_REQUEST['id'];

$query  =  "SELECT  * FROM promocion_curso WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result  = $statement->fetch(PDO::FETCH_ASSOC);

if($result['nombre']==$nombre)
{

try {
	
$query  =  "UPDATE   promocion_curso SET 
nombre=:nombre,estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':estado',$estado);
$statement->bindParam(':id',$id);
$statement->execute();
echo json_encode(array('title'=>'Buen Trabajo','type'=>'success','text'=>'Registro Actualizado'));


} catch (Exception $e) {
	
echo "Error: ".$e->getMessage();

}


}
else
{

$query  =  "SELECT  * FROM promocion_curso WHERE nombre=:nombre";
$statement = $conexion->prepare($query);
$statement->bindParam(':nombre',$nombre);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'El nombre ya esta registrado'));


}
else
{

try {
	
$query  =  "UPDATE   promocion_curso SET 
nombre=:nombre,estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':estado',$estado);
$statement->bindParam(':id',$id);
$statement->execute();
echo json_encode(array('title'=>'Buen Trabajo','type'=>'success','text'=>'Registro Actualizado'));


} catch (Exception $e) {
	
echo "Error: ".$e->getMessage();

}




}


}



}


break;

default:
echo "opción no disponible";
break;
}




 ?>