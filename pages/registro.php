<?php 
include'../autoload.php';
$session =  new Session();
$session->validity();
$session->acceso();
$assets =  new Assets();
$assets->nav('..','Registro');
$assets->breadcrumbs('Reserva','<a href="'.URL.'reserva" target="blank">Registro<a/>');


$funciones = new Funciones();

$fechaini  =  $funciones->restar_meses(3);

$fecha     = new DateTime();
$fecha->modify('last day of this month');
$fechafin =  $fecha->format('Y-m-d');


 ?>

<div class="row">
<div class="col-md-12">
  
<form id="busqueda" autocomplete="off" class="form-inline">
  
<input type="date" name="fechaini" value="<?= $fechaini ?>" class="fechaini form-control">
<input type="date" name="fechafin" value="<?= $fechafin ?>" class="fechafin form-control">
<button class="btn btn-primary"><i class="fa fa-search"></i> Consultar</button>

</form>


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
<form id="estado" autocomplete="off">
<div class="modal fade" id="modal-estado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-estado" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


    <input type="hidden" name="id" class="id">
    <input type="hidden" name="correo" class="correo">
    <input type="hidden" name="fullname" class="fullname">

    <div class="form-group">
    <label>Estado</label>
    <select name="estado" class="estado form-control" required></select>
    </div>
       
    <div class="form-group">
    <label>Comentario</label>
    <textarea name="comentario"  rows="5" class="comentario form-control" required onchange="Mayusculas(this)"></textarea>
    </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit" value="Actualizar" class="btn btn-primary btn-submit">
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
"sAjaxSource": "../sources/registro.php?op=1&fechaini="+fechaini+"&fechafin="+fechafin+"",
"aoColumns": [

{ mData: 'id'},
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

//Cargar Modal Estado
$(document).on('click','.btn-estado',function (e){

$('.estado').html('');
$('.comentario').val('');
id       = $(this).data('id');
correo   = $(this).data('correo');
fullname = $(this).data('fullname');
$('.id').val(id);
$('.correo').val(correo);
$('.fullname').val(fullname);
$('.title-estado').html('Id '+id+' : Actualizar Estado');

url = "../sources/registro.php?op=2";

$.getJSON(url,{"id":id},function(data){

$('.comentario').val(data.comentario);

//Cargar Estado
var obj_estado = ["PENDIENTE", "ATENDIDO", "SPAM"];

estado = '<option value="'+data.estado+'">'+data.estado+'</option>';

obj_estado.forEach(function (data_estado){

if(data_estado!==data.estado)
{
 
 estado += '<option value="'+data_estado+'">'+data_estado+'</option>';

}
 
});

$('.estado').html(estado);

$('#modal-estado').modal('show');

});

});


//Actualizar Datos Estado
$(document).on('submit','#estado',function (e){

parametros = $(this).serialize();

$.ajax({

url:"../sources/registro.php?op=3",
type:"POST",
dataType :"JSON",
data:parametros,
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
  title: data.title,
  type:  data.type,
  text:  data.text,
  timer: 3000,
  showConfirmButton: false
});

loadData('<?= $fechaini ?>','<?= $fechafin ?>');

$('#modal-estado').modal('hide');




}

});


e.preventDefault();
})



</script>


 <?php  $assets->footer('..'); ?>