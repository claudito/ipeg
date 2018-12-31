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
correo,
fullname,
id_reserva,
estado,
case estado
WHEN 'ON' THEN 'success'
WHEN 'OFF' THEN 'danger'
END label

 FROM correo_spam";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
'fullname'=>$value['fullname'],
'correo'=>$value['correo'],
'estado'=>'<a  href="#"  class="btn-estado badge badge-'.$value['label'].'"" 
data-id="'.$value['id'].'" data-valor="'.$value['estado'].'" >'.$value['estado'].'</a>',
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

$id     = $_REQUEST['id'];
$estado = $_REQUEST['estado'];

try {
	
$query     = "UPDATE correo_spam SET estado=:estado WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':estado',$estado);
$statement->bindParam(':id',$id);
$statement->execute();
echo "ok";


} catch (Exception $e) {
	
echo "Error: ".$e->getMessage();

}


break;


default:
echo "opción no disponible";
break;
}




 ?>