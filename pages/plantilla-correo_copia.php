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
              <th>Cabecera</th>
              <th>Cuerpo</th>
              <th>Fechas</th>
              <th>Firmas</th>
              <th>Pie de Página</th>
              <th>Acciones</th>
              

                      
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

      <input type="hidden" name="id"  class="id">


      <div class="form-group">
      <label>Cabecera</label>
      <textarea id="seccion_1" name="seccion_1" class="seccion_1" required ></textarea>
      </div>
        <script>
        $(document).ready(function() {
        $('#seccion_1').summernote({

        height:150,
        placeholder: 'Ingrese el texto.'


        });
        });
        </script>




          <div class="form-group">
      <label>Cuerpo</label>
      <textarea id="seccion_2" name="seccion_2"  class="seccion_2" required placeholder="hola"></textarea>
      </div>
        <script>
        $(document).ready(function() {
        $('#seccion_2').summernote({

        height:150,
        placeholder: 'Ingrese el texto.'


        });
        });
        </script>

          <div class="form-group">
      <label>Fechas</label>
      <textarea id="seccion_3" name="seccion_3" class="seccion_3" required placeholder="hola"></textarea>
      </div>
        <script>
        $(document).ready(function() {
        $('#seccion_3').summernote({

        height: 150,
        placeholder: 'Ingrese el texto.'


        });
        });
        </script>


      <div class="form-group">
      <label>Firmas</label>
      <textarea id="seccion_4" name="seccion_4" class="seccion_4" required placeholder="hola"></textarea>
      </div>
        <script>
        $(document).ready(function() {
        $('#seccion_4').summernote({

        height: 150,
        placeholder: 'Ingrese el texto.'


        });
        });
        </script>


        <div class="form-group">
      <label>Pie de Página</label>
      <textarea id="seccion_5" name="seccion_5" class="seccion_5" required placeholder="hola"></textarea>
      </div>
        <script>
        $(document).ready(function() {
        $('#seccion_5').summernote({

        height: 150,
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
{ mData: 'seccion_1'},
{ mData: 'seccion_2'},
{ mData: 'seccion_3'},
{ mData: 'seccion_4'},
{ mData: 'seccion_5'},
{ mData: 'acciones'}


]

});

 });

}
//Cargar Data
loadData();

//Cargal Modal Actualizar
$(document).on('click','.btn-edit',function (e){

id = $(this).data('id');
$('.id').val(id);

$('#modal-actualizar').modal('show');


//Cargar Información de la Fila
url = "../sources/plantilla-correo.php?op=2";

$.getJSON(url,{"id":id},function(data){

$('.seccion_1').summernote('code', data.seccion_1);
$('.seccion_2').summernote('code', data.seccion_2); 
$('.seccion_3').summernote('code', data.seccion_3); 
$('.seccion_4').summernote('code', data.seccion_4);
$('.seccion_5').summernote('code', data.seccion_5);


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
loadData();

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