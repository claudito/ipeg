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
DATE_FORMAT(fecha,'%d/%m/%Y')fecha,
nombre,
estado
FROM fecha_inicio_curso";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
'nombre'=>$value['nombre'],
'fecha'=>$value['fecha'],
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

$query =  "SELECT * FROM fecha_inicio_curso WHERE id=".$id;
$result = $funciones->query($query)[0];

echo json_encode($result);

break;

case 3:

//$nombre = $funciones->validar_xss($_REQUEST['nombre']);
$fecha  = $_REQUEST['fecha'];
$estado = $funciones->validar_xss($_REQUEST['estado']);

if($_REQUEST['tipo']=='agregar')
{

//Agregar
try {
	
$query  =  "SELECT  * FROM fecha_inicio_curso WHERE fecha=:fecha";
$statement = $conexion->prepare($query);
//$statement->bindParam(':nombre',$nombre);
$statement->bindParam(':fecha',$fecha);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'Registro Duplicado'));

}
else
{

$query  =  "INSERT INTO  fecha_inicio_curso(fecha,estado)
VALUES(:fecha,:estado)";
$statement = $conexion->prepare($query);
$statement->bindParam(':fecha',$fecha);
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

$query  =  "SELECT  * FROM fecha_inicio_curso WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result  = $statement->fetch(PDO::FETCH_ASSOC);

if($result['fecha']==$fecha)
{

try {
	
$query  =  "UPDATE   fecha_inicio_curso SET 
fecha=:fecha,estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':fecha',$fecha);
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

$query  =  "SELECT  * FROM fecha_inicio_curso WHERE fecha=:fecha";
$statement = $conexion->prepare($query);
$statement->bindParam(':fecha',$fecha);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'La fecha ya esta registrado.'));


}
else
{

try {
	
$query  =  "UPDATE   fecha_inicio_curso SET 
fecha=:fecha,estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':fecha',$fecha);
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