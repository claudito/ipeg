$(document).ready(function (){

//Cargar Secciones:
url = "./sources/reserva.php?op=1";

$.getJSON(url,{"id":1},function(data){

$('.seccion_1').html(data.seccion_1);
$('.seccion_2').html(data.seccion_2);
$('.seccion_3').html(data.seccion_3);  
$('.title').html(data.titulo);
$('.subtitle').html(data.subtitulo);

});








});

