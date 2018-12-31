<?php 
include'../autoload.php';
$session =  new Session();
$session->validity();
$session->acceso();
$assets =  new Assets();
$assets->nav('..','Plantilla Correo');
$assets->breadcrumbs('Reserva','Plantilla Correo');
$assets->summernote();
 ?>


<div class="row">
  
<div class="col-md-12">

  
    <div class="table-responsive">
      <table id="consulta"  class="table table-hover table-condensend" style="font-size: 12px">
        <thead>
         <tr class="table-active">
              <th>Id</th>
              <th>Nombre</th>
              <th>Cabecera</th>
              <th>Cuerpo</th>
              <th>Fechas</th>
              <th>Firmas</th>
              <th>Pie de Página</th>
              

                      
          </tr>
        </thead>
      </table>
     </div>

</div>

</div>

<!-- Modal Actualizar  -->
<form id="actualizar" autocomplete="off">
<!-- Modal -->
<div class="modal fade" id="modal-actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <input type="hidden" name="id"      class="id">
      <input type="hidden" name="campo"  class="campo">


      <div class="form-group">
      <textarea id="seccion" name="seccion" class="seccion" required ></textarea>
      </div>
      <script>
      $(document).ready(function() {
      $('#seccion').summernote({

      height:300,
      placeholder: 'Ingrese el texto.'


      });
      });
      </script>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
    </div>
  </div>
</div>
</form>


<script>

//Quitar Botones Molestos SummerNote
$(document).ready(function (){

$('.note-btn').attr('style','display:none');
$('.note-children-container').attr('style','display:none');


});

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
"sAjaxSource": "../sources/plantilla-correo.php?op=1",
"aoColumns": [

{ mData: 'id'},
{ mData: 'nombre'},
{ mData: 'seccion_1'},
{ mData: 'seccion_2'},
{ mData: 'seccion_3'},
{ mData: 'seccion_4'},
{ mData: 'seccion_5'}


]

});

 });

}
//Cargar Data
loadData();

//Cargal Modal Actualizar
$(document).on('click','.btn-edit',function (e){

$('.note-btn').attr('style','display:block');
$('.note-children-container').attr('style','display:block');


id      = $(this).data('id');
name    = $(this).data('name');
seccion = $(this).data('seccion');
$('.id').val(id);
$('.campo').val('seccion_'+seccion);
$('#modal-actualizar').modal('show');
$('.modal-title').html(name);


//Cargar Información de la Fila
url = "../sources/plantilla-correo.php?op=2";

$.getJSON(url,{"id":id,"seccion":seccion},function(data){

$('.seccion').summernote('code', data.seccion);



});

});


//Formulario Actualizar
$(document).on('submit','#actualizar',function (e){

parametros = $(this).serialize();

$.ajax({

url:"../sources/plantilla-correo.php?op=3",
type:"POST",
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

//Cargar Data
//loadData();

swal({
  title:"Buen Trabajo",
  type: "success",
  text: "Registro Actualizado",
  timer: 3000,
  showConfirmButton: false
});


}

});


e.preventDefault();
})



</script>


 <?php  $assets->footer('..'); ?>