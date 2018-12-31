<?php 

include'../vendor/autoload.php';
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

$fechaini = $_REQUEST['fechaini'];
$fechafin = $_REQUEST['fechafin'];

$query =  "SELECT 
r.id,
r.email,
r.idnumber dni,
r.fullname,
r.phone celular,
d1.fullname diploma_1,
d2.fullname diploma_2,
d3.fullname diploma_3,
m.nombre modalidad,
DATE_FORMAT(r.fecha_inicio,'%d/%m/%Y') fecha_inicio,
DATE_FORMAT(r.dateCreate,'%d/%m/%Y') dateCreate,
c.nombre promocion,
b.nombre beca,
case r.estado
WHEN 'PENDIENTE' THEN 'warning'
WHEN 'ATENDIDO' THEN 'success'
WHEN 'SPAM' THEN 'danger'
END label,
r.estado,
IFNULL(cc.id,0) check_correo

FROM reserva r
LEFT JOIN mdlwf_programmed_course d1 ON r.diploma_1=d1.idnumber
LEFT JOIN mdlwf_programmed_course d2 ON r.diploma_2=d2.idnumber
LEFT JOIN mdlwf_programmed_course d3 ON r.diploma_3=d3.idnumber
INNER JOIN modalidad m ON r.modalidad=m.codigo
INNER JOIN promocion_curso c ON r.promocion=c.id
INNER JOIN beca_curso b ON r.beca=b.id
LEFT JOIN check_correo cc ON r.id=cc.id_reserva 
WHERE DATE_FORMAT(r.dateCreate,'%Y-%m-%d') BETWEEN '".$fechaini."' AND '".$fechafin."'
";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {

if($value['check_correo']==0)
{

$btn_check = '<button class="btn btn-default btn-check btn-'.$value['id'].'" 
data-id="'.$value['id'].'"
data-email="'.$value['email'].'"
data-fullname="'.$value['fullname'].'"
><i class="fa fa-square-o '.$value['id'].'"></i></button>';

}
else
{

$btn_check = '<button 
class="btn btn-primary btn-check btn-'.$value['id'].'"  
disabled><i class="fa fa-check-square"></i></button>';

}

 $data[] = [ 

'id'=>$value['id'],
'check'=>$btn_check,
'fullname'=>$value['fullname'],
'dni'=>$value['dni'],
'email'=>$value['email'],
'celular'=>$value['celular'],
'diploma_1'=>$value['diploma_1'],
'diploma_2'=>$value['diploma_2'],
'diploma_3'=>$value['diploma_3'],
'modalidad'=>$value['modalidad'],
'fecha_inicio'=>$value['fecha_inicio'],
'dateCreate'=>$value['dateCreate'],
'promocion'=>$value['promocion'],
'beca'=>$value['beca'],
'estado'=>'<a  href="#" data-id="'.$value['id'].'" class="btn-estado badge badge-'.$value['label'].'">'.$value['estado'].'</a>',

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

$id       = $_REQUEST['id'];
$email    = $_REQUEST['email'];
$fullname = $_REQUEST['fullname'];

$query   = "INSERT INTO  check_correo(correo,fullname,id_reserva)VALUES
(:correo,:fullname,:id_reserva)";
$statement = $conexion->prepare($query);
$statement->bindParam(':correo',$email);
$statement->bindParam(':fullname',$fullname);
$statement->bindParam(':id_reserva',$id);
$statement->execute();
echo "ok";

break;


case 3:

$query   = "TRUNCATE TABLE check_correo";
$statement = $conexion->prepare($query);
$statement->execute();
echo "ok";
break;


case 4:

$query   = "SELECT * FROM check_correo";
$result  = $funciones->query($query);
echo json_encode($result);
break;


case 5:

$query   = "SELECT * FROM check_correo";
$result  = $funciones->query($query);

//Enviar Correo
foreach ($result as $key => $value) {
	
 $mail =  new Mail();
 echo $mail->recordatorio($value['correo'],$value['fullname']);

}

//Limpiar Data
$query   = "TRUNCATE TABLE check_correo";
$statement = $conexion->prepare($query);
$statement->execute();
echo "Data Truncada";

break;

default:
echo "opción no disponible";
break;

}




 ?>