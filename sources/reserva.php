<?php 

include'../vendor/autoload.php';
include'../autoload.php';

//$session =  new Session();
//$session->validity();

$opcion     = $_REQUEST['op'];
$funciones  = new Funciones();

$conexion   =  new Conexion();
$conexion   =  $conexion->get_conexion();

$userCreate = "INTERNET";
$dateCreate = date('Y-m-d H:i:s');


switch ($opcion) {

case '1':

$id = $_REQUEST['id'];

$query =  "SELECT * FROM plantilla_formulario WHERE id=".$id;
$result = $funciones->query($query);
$data  = array();
foreach ($result as $key => $value) {

$data[] =  [

'id'=>$value['id'],
'seccion_1'=>$value['seccion_1'],
'seccion_2'=>$value['seccion_2'],
'seccion_3'=>$value['seccion_3'], 
'seccion_4'=>$value['seccion_4'],
'seccion_5'=>$value['seccion_5']

];


}

echo json_encode($data[0]);

break;


case 2:

$query  = "SELECT * FROM ubigeo2006 WHERE CodProv =0 AND CodDist = 0 order by Nombre";
$result = $funciones->query($query);

echo json_encode($result);

break;

case 3:

$query  = "SELECT * FROM  mdlwf_programmed_course WHERE estado='ACTIVO'";
$result = $funciones->query($query);

echo json_encode($result);

break;

case 4:

$query  = "SELECT 
id,
codigo,
nombre,
semana,
CAST(costo as decimal(8,2)) costo FROM  modalidad WHERE estado='ACTIVO'";
$result = $funciones->query($query);

echo json_encode($result);

break;

case 5:

$query  = "SELECT * FROM   fecha_inicio_curso WHERE estado='ACTIVO'";
$result = $funciones->query($query);

$data  = array();
foreach ($result as $key => $value) {

$data[] =  [

'id'=>$value['id'],
'fecha'=>$value['fecha'],
'descripcion'=>$funciones->formato_fecha_inicio($value['fecha']) 
];


}

echo json_encode($data);

break;


case 6:

$query  = "SELECT * FROM   promocion_curso WHERE estado='ACTIVO'";
$result = $funciones->query($query);

$data  = array();
foreach ($result as $key => $value) {

$data[] =  [

'id'=>$value['id'],
'nombre'=>$value['nombre']

];


}

echo json_encode($data);

break;


case 7:

$query  = "SELECT * FROM   beca_curso WHERE estado='ACTIVO'";
$result = $funciones->query($query);

$data  = array();
foreach ($result as $key => $value) {

$data[] =  [

'id'=>$value['id'],
'nombre'=>$value['nombre']

];


}

echo json_encode($data);

break;


case 8;

$idnumber  = $_REQUEST['idnumber'];
$fullname  = $funciones->validar_xss($_REQUEST['fullname']);
$email     = $funciones->validar_xss($_REQUEST['email']);
$phone     = $funciones->validar_xss($_REQUEST['movil']);
$movil     = $_REQUEST['movil'];
$fecha_inicio = $_REQUEST['startdate'];
$region    = $funciones->validar_xss($_REQUEST['region']);
$diploma1  = $funciones->validar_xss($_REQUEST['diploma1']);
$diploma2  = $funciones->validar_xss($_REQUEST['diploma2']);
$diploma3  = $funciones->validar_xss($_REQUEST['diploma3']);
$modalidad = $_REQUEST['mode'];
$promocion = $_REQUEST['promotion'];
$beca      = $_REQUEST['gift-course'];

try {
	
$query =  "INSERT INTO reserva(email,idnumber,fullname,phone,region,diploma_1,diploma_2,diploma_3,modalidad,
fecha_inicio,promocion,beca,dateCreate,userCreate)VALUES
(:email,:idnumber,:fullname,:phone,:region,:diploma_1,:diploma_2,:diploma_3,:modalidad,
:fecha_inicio,:promocion,:beca,:dateCreate,:userCreate)";
$statement = $conexion->prepare($query);
$statement->bindParam(':email',$email);
$statement->bindParam(':idnumber',$idnumber);
$statement->bindParam(':fullname',$fullname);
$statement->bindParam(':phone',$phone);
$statement->bindParam(':region',$region);
$statement->bindParam(':diploma_1',$diploma1);
$statement->bindParam(':diploma_2',$diploma2);
$statement->bindParam(':diploma_3',$diploma3);
$statement->bindParam(':modalidad',$modalidad);
$statement->bindParam(':fecha_inicio',$fecha_inicio);
$statement->bindParam(':promocion',$promocion);
$statement->bindParam(':beca',$beca);
$statement->bindParam(':dateCreate',$dateCreate);
$statement->bindParam(':userCreate',$userCreate);
$statement->execute();
echo "ok";

//Enviar Correo

$mail       = new Mail();
$msg_correo = $mail->send($email,$fullname,$diploma1,$diploma2,$diploma3);

echo $msg_correo;


} catch (Exception $e) {
	
echo json_encode(array('title'=>'Error','type'=>'error','text'=>'Consultar el área de Soporte'));

//echo $e->getMessage();

}

break;
	
	default:
echo "Opción no disponible";
		break;
}


 ?>