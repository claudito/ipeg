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

$query =  "SELECT  
id,
codigo,
nombre,
semana,
CAST(CAST(costo AS decimal(8,2)) AS char)costo,
estado

FROM modalidad";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
'codigo'=>$value['codigo'],
'nombre'=>$value['nombre'],
'semana'=>$value['semana'],
'costo'=>$value['costo'],
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


$query =  "SELECT id,
codigo,
nombre,
semana,
CAST(CAST(costo AS decimal(8,2)) AS char)costo,
estado FROM modalidad WHERE id=".$id;
$result = $funciones->query($query)[0];

echo json_encode($result);

break;

case 3:

$codigo = $funciones->validar_xss($_REQUEST['codigo']);
$nombre = $funciones->validar_xss($_REQUEST['nombre']);
$semana = $_REQUEST['semana'];
$costo  = $_REQUEST['costo'];
$estado = $_REQUEST['estado'];


if($_REQUEST['tipo']=='agregar')
{

//Agregar
try {
	
$query  =  "SELECT  * FROM modalidad WHERE codigo=:codigo";
$statement = $conexion->prepare($query);
$statement->bindParam(':codigo',$codigo);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'El nombre ya esta registrado'));

}
else
{

$query  =  "INSERT INTO  modalidad(codigo,nombre,semana,costo,estado)
VALUES(:codigo,:nombre,:semana,:costo,:estado)";
$statement = $conexion->prepare($query);
$statement->bindParam(':codigo',$codigo);
$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':semana',$semana);
$statement->bindParam(':costo',$costo);
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

$query  =  "SELECT  * FROM modalidad WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result  = $statement->fetch(PDO::FETCH_ASSOC);

if($result['codigo']==$codigo)
{

try {
	
$query  =  "UPDATE   modalidad SET
codigo=:codigo,
nombre=:nombre,
semana=:semana,
costo=:costo,
estado=:estado
 WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':codigo',$codigo);
$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':semana',$semana);
$statement->bindParam(':costo',$costo);
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

$query  =  "SELECT  * FROM modalidad WHERE codigo=:codigo";
$statement = $conexion->prepare($query);
$statement->bindParam(':codigo',$codigo);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'El nombre ya esta registrado'));


}
else
{

try {
	
$query  =  "UPDATE   modalidad SET 
codigo=:codigo,
nombre=:nombre,
semana=:semana,
costo=:costo,
estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':codigo',$codigo);
$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':semana',$semana);
$statement->bindParam(':costo',$costo);
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