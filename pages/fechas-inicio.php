<?php 
include'../autoload.php';
$session =  new Session();
$session->validity();
$session->acceso();
$assets =  new Assets();
$assets->nav('..','Fechas de Inicio');
$assets->breadcrumbs('Reserva','Fechas de Inicio')
 ?>


<div class="row">
  
<div class="col-md-12">

<div class="pull-right">
<div class="form-group">
<button class="btn btn-primary btn-agregar"><i class="fa fa-plus"></i> Agregar</button>
</div>
</div>

  
    <div class="table-responsive">
      <table id="consulta"  class="table table-hover table-condensend" style="font-size: 12px">
        <thead>
         <tr class="table-active">
              <th>Id</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Acciones</th>
              

                      
          </tr>
        </thead>
      </table>
     </div>

</div>

</div>

<!-- Modal Registro -->
<form id="registro" autocomplete="off">
<div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-registro" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      <input type="hidden" name="id" class="id">
      <input type="hidden" name="tipo" class="tipo">
   
    <!--  
    <div class="form-group">
    <label>Nombre</label>
     <textarea name="nombre" class="nombre form-control" placeholder="Ingrese la descripción de la promoción." 
      required="" rows="3"></textarea>
    </div>-->

    <div class="form-group">
    <label>Fecha</label>
    <input type="date" name="fecha" class="fecha form-control" required>
    </div>


    <div class="form-group">
    <label>Estado</label>
    <select name="estado" class="estado form-control" required></select>
    </div>

    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit" value="" class="btn btn-primary btn-submit">
      </div>
    </div>
  </div>
</div>
</form>


<script>
function loadData()
{

 $(document).ready(function (){

$("#consulta").dataTable().fnDestroy();
$('#consulta').dataTable({

 //"order": [[ 4, "desc" ]],
//dom: 'Bfrtip',
 "deferRender": true,
"bAutoWidth": false,
"iDisplayLength": 25,
"language": {
"url": "../assets/js/spanish.json"
},
"bProcessing": true,
"sAjaxSource": "../sources/fechas-inicio.php?op=1",
"aoColumns": [

{ mData: 'id'},
{ mData: 'fecha'},
{ mData: 'estado'},
{ mData: 'acciones'}


]

});

 });

}
//Cargar Data
loadData();

//Cargal Modal Agregar
$(document).on('click','.btn-agregar',function (e){

$('.fecha').val('');
estado = '';
estado = '<option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option>';
$('.estado').html(estado);
$('.title-registro').html('Agregar');
$('.tipo').val('agregar');
$('.btn-submit').attr('value','Agregar');
$('#modal-registro').modal('show');

})


//Cargal Modal Actualizar
$(document).on('click','.btn-edit',function (e){

id = $(this).data('id');
$('.id').val(id);

$('.title-registro').html('Actualizar');
$('.tipo').val('actualizar');
$('.btn-submit').attr('value','Actualizar');

url = "../sources/fechas-inicio.php?op=2";

$.getJSON(url,{"id":id},function(data){

$('.fecha').val(data.fecha);
estado = '';
if(data.estado=='ACTIVO')
{
estado = '<option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option>';
}
else
{
estado = '<option value="INACTIVO">INACTIVO</option><option value="ACTIVO">ACTIVO</option>';
}

$('.estado').html(estado);
$('#modal-registro').modal('show');

});

})


//Registro
$(document).on('submit','#registro',function (e){

parametros = $(this).serialize();

$.ajax({

url:"../sources/fechas-inicio.php?op=3",
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


if(data.type=='warning')
{

swal({
  title: data.title,
  type:  data.type,
  text:  data.text,
  timer: 3000,
  showConfirmButton: false
});


}
else
{

swal({
  title: data.title,
  type:  data.type,
  text:  data.text,
  timer: 3000,
  showConfirmButton: false
});

loadData();

$('#modal-registro').modal('hide');


}


}

});


e.preventDefault();
})


</script>


 <?php  $assets->footer('..'); ?>