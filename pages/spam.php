<?php 
include'../autoload.php';
$session =  new Session();
$session->validity();
$session->acceso();
$assets =  new Assets();
$assets->nav('..','Spam');
$assets->breadcrumbs('Reserva','Spam')
 ?>


<div class="row">
  
<div class="col-md-12">


  
    <div class="table-responsive">
      <table id="consulta"  class="table table-hover table-condensend" style="font-size: 12px">
        <thead>
         <tr class="table-active">
              <th>Id</th>
              <th>Nombres</th>
              <th>Correo</th>
              <th>Estado</th>            

                      
          </tr>
        </thead>
      </table>
     </div>

</div>

</div>




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
"sAjaxSource": "../sources/spam.php?op=1",
"aoColumns": [

{ mData: 'id'},
{ mData: 'fullname'},
{ mData: 'correo'},
{ mData: 'estado'}


]

});

 });

}
//Cargar Data
loadData();

//Cargal Modal Agregar
$(document).on('click','.btn-estado',function (e){

id     = $(this).data('id');
valor  = $(this).data('valor');

if(valor=='ON')
{
 valor = 'OFF';
}
else
{
 valor = 'ON';
}

parametros = {"id":id,"estado":valor};

url = "../sources/spam.php?op=2";

$.get(url,parametros,function(data){

loadData();

});


});

</script>


 <?php  $assets->footer('..'); ?>