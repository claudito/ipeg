<?php 
include'../autoload.php';
$session =  new Session();
$session->validity();
$session->acceso();
$assets =  new Assets();
$assets->nav('..','Diplomados');
$assets->breadcrumbs('Reserva','Diplomados')
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
              <th>Código</th>
              <th>Descripción</th>
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

    <div class="form-group">
    <label>Código</label>
    <input type="text" name="codigo" class="codigo form-control" placeholder="Ingrese el Código" 
     onchange="Mayusculas(this)" required="">
    </div>


    <div class="form-group">
    <label>Descripción</label>
    <input type="text" name="descripcion" class="descripcion form-control" placeholder="Ingrese la descripción" 
     onchange="Mayusculas(this)" required="">
    </div>


    <div class="form-group">
    <label>Estado</label>
    <select name="estado"  class="estado form-control" required></select>
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


<!-- Modal Subir Archivo -->
<form id="upload" autocomplete="off">
<div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 100%;padding-left: 15px;padding-right: 15px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-registro" id="exampleModalLabel">Subir Archivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

    <div class="form-group">
    <a href="https://smallpdf.com/es/comprimir-pdf" target="blank">Web para Comprimir PDF´s</a>
    </div>

    <input type="hidden" name="id" class="id">
    <input type="hidden" name="codigo" class="codigo">

    <div class="input-group">
    <input type="file" name="archivo" class="archivo form-control" accept="application/pdf"  required> 
    <div class="input-group-append">
    <button class="btn  btn-primary" type="submit">Subir PDF</button>
    </div>
    </div>
  
    <hr>

    <!-- Visor -->
    <div class="visor-pdf">
    <div class="embed-responsive embed-responsive-4by3 ">
    <embed src="" id="ruta_pdf"   type="application/pdf" ></embed>
    </div>
    </div>

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
"sAjaxSource": "../sources/diplomado.php?op=1",
"aoColumns": [

{ mData: 'id'},
{ mData: 'idnumber'},
{ mData: 'fullname'},
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

$('.codigo').val('');
$('.descripcion').val('');

$('.title-registro').html('Agregar');
$('.tipo').val('agregar');
$('.btn-submit').attr('value','Agregar');

//Cargar Estado
estado = '<option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option>';

$('.estado').html(estado);

$('#modal-registro').modal('show');

})


//Cargal Modal Actualizar
$(document).on('click','.btn-edit',function (e){

id = $(this).data('id');
$('.id').val(id);

$('.title-registro').html('Actualizar');
$('.tipo').val('actualizar');
$('.btn-submit').attr('value','Actualizar');

url    = "../sources/diplomado.php?op=2";
estado = "";

$.getJSON(url,{"id":id},function(data){

$('.codigo').val(data.idnumber);
$('.descripcion').val(data.fullname);

if(data.estado=='ACTIVO')
{
estado += '<option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option>';
}
else
{
estado += '<option value="INACTIVO">INACTIVO</option><option value="ACTIVO">ACTIVO</option>';
}

$('.estado').html(estado);
$('#modal-registro').modal('show');

});

})


//Registro
$(document).on('submit','#registro',function (e){

parametros = $(this).serialize();

$.ajax({

url:"../sources/diplomado.php?op=3",
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


//Cargal Modal Subir Archivo
$(document).on('click','.btn-upload',function (e){
$('#ruta_pdf').attr('src','');
id = $(this).data('id');
codigo = $(this).data('codigo');
descripcion = $(this).data('descripcion');
$('.id').val(id);
$('.codigo').val(codigo);
$('.title-registro').html(codigo+' - '+descripcion);

url = "../sources/diplomado.php?op=4";
$.getJSON(url,{"id":id},function (data){

if(data.file_pdf=='')
{

$('.visor-pdf').attr('display','none');

}
else
{

ruta_pdf = localStorage.url_ipeg+"uploads/diplomados/"+data.file_pdf;
//Cargar PDF
$('#ruta_pdf').attr('src',ruta_pdf);
$('.visor-pdf').attr('display','block');

}


});

$('#modal-upload').modal('show');

e.preventDefault();
});

//Upload PDF
$(document).on('submit','#upload',function (e){

parametros = $(this).serialize();

id     = $('.id').val(id);
codigo = $('.codigo').val(codigo);

$.ajax({

url:"../sources/diplomado.php?op=5",
type:"POST",
data:new FormData(this),
contentType: false,
cache: false,
processData:false,
beforeSend:function(){

swal({
  title: "Cargando",
  imageUrl:"../assets/img/loader2.gif",
  text:  "Espere un momento, no cierre la ventana.",
  timer: 3000,
  showConfirmButton: false
});


},
success:function(data){

$('#modal-upload').modal('hide');

swal({
  title: "Buen Trabajo",
  type:  "success",
  text:  "Archivo Subido",
  timer: 3000,
  showConfirmButton: false
});

$('.archivo').val('');

}


});


e.preventDefault();
});


</script>


 <?php  $assets->footer('..'); ?>