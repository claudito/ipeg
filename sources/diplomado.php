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

$query =  "SELECT * FROM mdlwf_programmed_course";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
'idnumber'=>$value['idnumber'],
'fullname'=>$value['fullname'],
'estado'=>$value['estado'],
'acciones'=>'

<button type="button" class="btn btn-primary btn-edit btn-sm" data-id="'.$value['id'].'"><i class="fa fa-edit"></i></button>
<button type="button" class="btn btn-warning btn-upload btn-sm" 
data-id="'.$value['id'].'"
data-codigo="'.$value['idnumber'].'"
data-descripcion="'.$value['fullname'].'"
><i class="fa fa-upload"></i></button>

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

$query =  "SELECT * FROM mdlwf_programmed_course WHERE id=".$id;
$result = $funciones->query($query)[0];

echo json_encode($result);

break;

case 3:

$descripcion = $funciones->validar_xss($_REQUEST['descripcion']);
$idnumber    = $funciones->validar_xss($_REQUEST['codigo']);
$estado      = $funciones->validar_xss($_REQUEST['estado']);

if($_REQUEST['tipo']=='agregar')
{

//Agregar
try {
	
$query  =  "SELECT  * FROM mdlwf_programmed_course WHERE fullname=:fullname";
$statement = $conexion->prepare($query);
$statement->bindParam(':fullname',$descripcion);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'El nombre ya esta registrado'));

}
else
{

$query  =  "INSERT INTO  mdlwf_programmed_course(idnumber,fullname,estado)
VALUES(:idnumber,:fullname,:estado)";
$statement = $conexion->prepare($query);
$statement->bindParam(':idnumber',$idnumber);
$statement->bindParam(':fullname',$descripcion);
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

$query  =  "SELECT  * FROM  mdlwf_programmed_course WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result  = $statement->fetch(PDO::FETCH_ASSOC);

if($result['idnumber']==$idnumber)
{

try {
	
$query  =  "UPDATE    mdlwf_programmed_course SET 
fullname=:fullname,idnumber=:idnumber,estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':fullname',$descripcion);
$statement->bindParam(':idnumber',$idnumber);
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

$query  =  "SELECT  * FROM  mdlwf_programmed_course WHERE fullname=:fullname";
$statement = $conexion->prepare($query);
$statement->bindParam(':fullname',$descripcion);
$statement->execute();
$result  = $statement->fetchAll(PDO::FETCH_ASSOC);
if(count($result)>0)
{

echo json_encode(array('title'=>'Registro Duplicado','type'=>'warning','text'=>'El Código ya esta registrado'));


}
else
{

try {
	
$query  =  "UPDATE    mdlwf_programmed_course SET 
idnumber=:idnumber,fullname=:fullname,estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':idnumber',$idnumber);
$statement->bindParam(':fullname',$descripcion);
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

case 4:

$id        = $_REQUEST['id'];

$query  = "SELECT id,IFNULL(file_pdf,'')file_pdf FROM mdlwf_programmed_course WHERE id=".$id;
$result = $funciones->query($query)[0];

echo json_encode($result);

break;

case 5:

$id        = $_REQUEST['id'];
$codigo    = $_REQUEST['codigo'];
$archivo   = $_FILES['archivo'];
$extension = pathinfo($archivo['name'],PATHINFO_EXTENSION);
$name_file = $codigo.'.'.$extension;

$filename    = $archivo['tmp_name'];
$destination = "../uploads/diplomados/".$name_file;

//Subir Archivo
if(move_uploaded_file($filename, $destination))
{
  echo "archivo subido";
}
else
{
  echo "error al subir archivo";
}

//Subir Ruta al PDF
try {
	
$query     = "UPDATE mdlwf_programmed_course SET file_pdf=:file_pdf WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->bindParam(':file_pdf',$name_file);
$statement->execute();
echo "Archivo Actualizado";


} catch (Exception $e) {
	
echo "Error: ".$e->getMessage();

}

break;

default:
echo "opción no disponible";
break;
}




 ?>