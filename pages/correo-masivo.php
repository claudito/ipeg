<?php 
include'../vendor/autoload.php';
include'../autoload.php';
$session =  new Session();
$session->validity();
$session->acceso();
$assets =  new Assets();
$assets->nav('..','Correo Masivo');
$assets->breadcrumbs('Reserva','Correo Masivo');


$funciones = new Funciones();

$fechaini  =  $funciones->restar_meses(3);

$fecha     = new DateTime();
$fecha->modify('last day of this month');
$fechafin =  $fecha->format('Y-m-d');


 ?>

<div class="row">
<div class="col-md-8">
  
<form id="busqueda" autocomplete="off" class="form-inline">
  
<input type="date" name="fechaini" value="<?= $fechaini ?>" class="fechaini form-control">
<input type="date" name="fechafin" value="<?= $fechafin ?>" class="fechafin form-control">
<button class="btn btn-primary"><i class="fa fa-search"></i> Consultar</button>

</form>

</div>



</div>


<hr>

<form id="enviar" autocomplete="off">

<button class="btn btn-info btn-mensaje"><i class="fa fa-envelope-o"></i> Enviar Correo Masivo</button>
<p></p>

<div class="row">
  
<div class="col-md-12">

    <div class="table-responsive">
      <table id="consulta"  class="table table-hover table-condensend" style="font-size: 12px">
        <thead>
         <tr class="table-active">

             <input type="checkbox"  id="checkTodos" style="display: none">


              <th>Id</th>
              <th><label   for="checkTodos">Check</label></th>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Email</th>
              <th>Dni</th>
              <th>Celular</th>
              <th>Diploma #1</th>
              <th>Diploma #2</th>
              <th>Diploma #3</th>
              <th>Modalidad</th>
              <th>Fecha de Inicio</th>
              <th>Promoción</th>
              <th>Beca</th>
              <th>Fecha de Registro</th>                              
          </tr>
        </thead>
      </table>
     </div>

</div>

</div>


</form>



<script>
function loadData(fechaini,fechafin)
{

 $(document).ready(function (){

$("#consulta").dataTable().fnDestroy();
$('#consulta').dataTable({

 "order": [[ 0, "desc" ]],
//dom: 'Bfrtip',
 "deferRender": true,
"bAutoWidth": false,
"iDisplayLength": 100,
"language": {
"url": "../assets/js/spanish.json"
},
"bProcessing": true,
"sAjaxSource": "../sources/correo-masivo.php?op=1&fechaini="+fechaini+"&fechafin="+fechafin+"",
"aoColumns": [

{ mData: 'id'},
{ mData: null,render:function (data){

var check = '<input type="checkbox" name="check[]"   value="'+data.id+'"  class="form-control" />';


return check;


}},
{ mData: 'fullname'},
{ mData: 'estado'},
{ mData: 'email'},
{ mData: 'dni'},
{ mData: 'celular'},
{ mData: 'diploma_1'},
{ mData: 'diploma_2'},
{ mData: 'diploma_3'},
{ mData: 'modalidad'},
{ mData: 'fecha_inicio'},
{ mData: 'promocion'},
{ mData: 'beca'},
{ mData: 'dateCreate'}


]

});

 });

}
//Cargar Data
loadData('<?= $fechaini ?>','<?= $fechafin ?>');

//Formulario Búsqueda
$(document).on('submit','#busqueda',function (e){

 fechaini = $('.fechaini').val();
 fechafin = $('.fechafin').val();

//Cargar Data
loadData(fechaini,fechafin);

e.preventDefault();
});


//Marcar Todos las Filas
$("#checkTodos").change(function () {
$("input:checkbox").prop('checked', $(this).prop("checked"));
});


//Enviar Correo
$(document).on('submit','#enviar',function(e){


parametros = $(this).serialize();


swal({
  title: "Esta Seguro?",
  text: "Se enviará un correo recordatorio a todos los registros seleccionados, tenga en cuenta que el envío puede demorar dependiendo de la cantidad de correos.",
  type: "info",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  cancelButtonText:"Cancelar",
  confirmButtonText: "Si, Enviar",
  closeOnConfirm: false
},
function(){

$.ajax({

url :"../sources/correo-masivo.php?op=2",
type:"POST",
dataType:"JSON",
data:parametros,
beforeSend:function()
{

swal({
 
  title:"Cargando",
  text: "Espere un momento no cierre la ventana",
  imageUrl: '../assets/img/loader2.gif',
  showConfirmButton:false

});



},
success:function(data){

swal({
 
  title:data.title,
  text:data.text,
  type: data.type,
  timer: 3000,
  showConfirmButton:false

});



}





});






});









e.preventDefault();
});


</script>


 <?php  $assets->footer('..'); ?>

