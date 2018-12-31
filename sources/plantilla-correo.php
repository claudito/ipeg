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

$query =  "SELECT  * FROM plantilla_correo";
$statement = $conexion->query($query);
$statement->execute();
$result      = $statement->fetchAll(PDO::FETCH_ASSOC);

$data  = array();

foreach ($result as $key => $value) {


 $data[] = [ 

'id'=>$value['id'],
'nombre'=>$value['nombre'],
'seccion_1'=>'<a class="btn-edit" data-id="'.$value['id'].'" data-seccion="1" data-name="Cabecera"><button type="button" class="btn btn-primary btn-sm">Editar</button><a>',
'seccion_2'=>'<a class="btn-edit" data-id="'.$value['id'].'" data-seccion="2" data-name="Cuerpo"><button type="button" class="btn btn-primary btn-sm">Editar</button><a>',
'seccion_3'=>'<a class="btn-edit" data-id="'.$value['id'].'" data-seccion="3" data-name="Fechas"><button type="button" class="btn btn-primary btn-sm">Editar</button><a>',
'seccion_4'=>'<a class="btn-edit" data-id="'.$value['id'].'" data-seccion="4" data-name="Firmas"><button type="button" class="btn btn-primary btn-sm">Editar</button><a>',
'seccion_5'=>'<a class="btn-edit" data-id="'.$value['id'].'" data-seccion="5" data-name="Pie de Página"><button type="button" class="btn btn-primary btn-sm">Editar</button><a>'


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

$id      = $_REQUEST['id'];
$seccion = $_REQUEST['seccion'];

$query =  "SELECT * FROM plantilla_correo WHERE id=".$id;
$result = $funciones->query($query);
$data  = array();
foreach ($result as $key => $value) {

$data[] =  [

'id'=>$value['id'],
'seccion'=>$value['seccion_'.$seccion]

];


}

echo json_encode($data[0]);


break;

case 3:

$id        = $_REQUEST['id'];
$campo     = $_REQUEST['campo'];
$seccion   = trim($_REQUEST['seccion']);


try {

$query = "UPDATE plantilla_correo SET 
".$campo."=:seccion  WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':seccion',$seccion);
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