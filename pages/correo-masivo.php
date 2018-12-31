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

<div class="col-md-2"></div>

<div class="col-md-2">
  
<button class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
<button class="btn btn-info btn-mensaje"><i class="fa fa-envelope-o"></i></button>

</div>

</div>
<hr>
<div class="row">
  
<div class="col-md-12">

    <div class="table-responsive">
      <table id="consulta"  class="table table-hover table-condensend" style="font-size: 12px">
        <thead>
         <tr class="table-active">
              <th>Id</th>
              <th>Check</th>
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

<!-- Modal Estado -->
<form id="enviar-correo" autocomplete="off">
<div class="modal fade" id="modal-correo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enviar Correo Masivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="mensaje"></div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info btn-submit" disabled>Confirmar Envío</button>
      </div>
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
"iDisplayLength": 25,
"language": {
"url": "../assets/js/spanish.json"
},
"bProcessing": true,
"sAjaxSource": "../sources/correo-masivo.php?op=1&fechaini="+fechaini+"&fechafin="+fechafin+"",
"aoColumns": [

{ mData: 'id'},
{ mData: 'check'},
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


//Check Fila
$(document).on('click','.btn-check',function (){

id       = $(this).data('id');
email    = $(this).data('email');
fullname = $(this).data('fullname');

parametros = {"id":id,"email":email,"fullname":fullname};

url = "../sources/correo-masivo.php?op=2";

//deshabilitar botón
$('.btn-'+id+'').attr('disabled','disabled');
//cambiar clase botón seleccionado
$('.btn-'+id+'').removeClass('btn-default').addClass('btn-primary');
//agregar icono check
$('.'+id+'').removeClass('fa fa-square-o').addClass('fa fa-check-square');

$.getJSON(url,parametros,function(data){

});

 });


//Botón Liberal Selección
$(document).on('click','.btn-delete',function (){

swal({
  title: "Estas Seguro?",
  text: "Esta acción liberará las filas seleccionadas.",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  cancelButtonText:"Cancelar",
  confirmButtonText: "Si Estoy Seguro",
  closeOnConfirm: false
},
function(){
  
url = "../sources/correo-masivo.php?op=3";
$.get(url,{},function(data){

swal({
  title:"Data Liberada",
  text: "...",
  type:"success",
  timer: 3000,
  showConfirmButton: false
});

loadData('<?= $fechaini ?>','<?= $fechafin ?>');

});

});

 });

//Cargar Modal Enviar Correo
$(document).on('click','.btn-mensaje',function (){

url = "../sources/correo-masivo.php?op=4";
$.getJSON(url,{},function(data){

mensaje ="";

if(data.length>0)
{

mensaje += '<div class="alert alert-success" role="alert">';
mensaje += 'Estas Seguro de Enviar los Recordatorios.';
mensaje += '</div>';

$('.btn-submit').removeAttr('disabled','disabled');
}
else
{

mensaje += '<div class="alert alert-warning" role="alert">';
mensaje += 'No hay elementos seleccionados.';
mensaje += '</div>';

$('.btn-submit').attr('disabled','disabled');

}

$('.mensaje').html(mensaje);
$('#modal-correo').modal('show');

});

 });


//Enviar Correos Masivos
$(document).on('submit','#enviar-correo',function (event){

$.ajax({

url:"../sources/correo-masivo.php?op=5",
type:"GET",
data:{},
beforeSend:function()
{

swal({
  title: "Cargando",
  imageUrl:"../assets/img/loader2.gif",
  text:  "Espere un momento, no cierre la ventana.",
  timer: 3000,
  showConfirmButton: false
});


},
success:function(data)
{

swal({
  title:"Buen Trabajo",
  type:"success",
  text:"Recordatorios Enviados.",
  timer: 3000,
  showConfirmButton: false
});

loadData('<?= $fechaini ?>','<?= $fechafin ?>');
$('#modal-correo').modal('hide');

}


});

event.preventDefault();
});

</script>


 <?php  $assets->footer('..'); ?>

