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
$result    = $statement->fetchAll(PDO::FETCH_ASSOC);

$results = [

            "draw"=>1,
			"recordsTotal"=> count($result),
			"recordsFiltered"=> count($result),
			"data"=>$result


           ];


echo json_encode($results);

break;

case 2:


if(isset($_REQUEST['check']))
{


foreach ($_REQUEST['check'] as $key => $id) {

  
  $query     = "SELECT * FROM reserva  WHERE id=".$id;
  $statement = $conexion->prepare($query);
  $statement->execute();
  $data      = $statement->fetch(PDO::FETCH_ASSOC);
   
  //Enviar Correo
  $mail = new Mail();
  $mail->recordatorio($data['email'],$data['fullname']);


}


echo json_encode(array('title'=>'Buen Trabajo','type'=>'success','text'=>'Correo Enviado'));


}
else
{

echo json_encode(array('title'=>'Vacío','type'=>'warning','text'=>'Necesita seleccionar un registro como mínimo'));


}


break;

default:
echo "opción no disponible";
break;

}




 ?>