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
r.estado

FROM reserva r
LEFT JOIN mdlwf_programmed_course d1 ON r.diploma_1=d1.idnumber
LEFT JOIN mdlwf_programmed_course d2 ON r.diploma_2=d2.idnumber
LEFT JOIN mdlwf_programmed_course d3 ON r.diploma_3=d3.idnumber
INNER JOIN modalidad m ON r.modalidad=m.codigo
INNER JOIN promocion_curso c ON r.promocion=c.id
INNER JOIN beca_curso b ON r.beca=b.id  
WHERE DATE_FORMAT(r.dateCreate,'%Y-%m-%d') BETWEEN '".$fechaini."' AND '".$fechafin."'
";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
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
'estado'=>'<a  href="#"
 data-id="'.$value['id'].'"
 data-fullname="'.$value['fullname'].'"
 data-correo="'.$value['email'].'"
  class="btn-estado badge badge-'.$value['label'].'">'.$value['estado'].'</a>',

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

$query  =  "SELECT * FROM reserva WHERE id=".$id;
$result = $funciones->query($query)[0];

echo json_encode($result);

break;

case 3:

$id         = $_REQUEST['id'];
$estado     = $_REQUEST['estado'];
$correo     = $_REQUEST['correo'];
$fullname   = $_REQUEST['fullname'];
$comentario = $funciones->validar_xss($_REQUEST['comentario']);

try {
	
$query =  "UPDATE reserva SET estado=:estado,comentario=:comentario,userUpdate=:userUpdate,dateUpdate=:dateUpdate WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->bindParam(':estado',$estado);
$statement->bindParam(':comentario',$comentario);
$statement->bindParam(':userUpdate',$userCreate);
$statement->bindParam(':dateUpdate',$dateCreate);
$statement->execute();
echo json_encode(array('title'=>'Buen Trabajo','type'=>'success','text'=>'Registro Actualizado'));

} catch (Exception $e) {
	
echo "Error: ".$e->getMessage();

}

//Agregar  a SPAM
if($estado=='SPAM')
{

$spam = new Spam();
$spam->agregar($correo,$fullname,$id);

}


break;

default:
echo "opción no disponible";
break;
}




 ?>