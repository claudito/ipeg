<?php include'autoload.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>IPEG | Reserva de vacante</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex" />
<link rel="shortcut icon" sizes="16x16" href="https://www.ipeg.edu.pe/wp-content/uploads/2018/01/cropped-logo-ipeg-32x32.png">
<link rel="stylesheet" type="text/css" href="https://www.ipeg.edu.pe/SIPEGWeb/css/styles-form-reserve.css"><!-- Facebook Pixel Code -->
<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1394540127301143'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
</head>
<body>
<script>
fbq('track', 'CompleteRegistration');
</script>
<header></header>
<section>
<h1 class="title"></h1>
<h2 class="subtitle">Instituto Peruano de Gobierno - IPEG</h2>

<!-- Sección #1 -->
<div class="seccion_1"></div>


<form  id="agregar" autocomplete="off" onsubmit="alert('submit!');return false"><fieldset class="container">
<legend class="diagonal">Datos personales</legend>
<div class="form-label">
<label for="idnumber">DNI: <span class="required">*</span></label>
</div>
<div class="form-input">
<input id="idnumber" name="idnumber" type="text" pattern="[0-9]{8}" size="8" placeholder="Tu respuesta" required maxlength="8">
</div>
<div class="form-label">
<label for="fullname">Nombres y apellidos: <span class="required">*</span></label>
</div>
<div class="form-input">
<input id="fullname" name="fullname" type="text" placeholder="Tu respuesta" required>
</div>
<div class="form-label">
<label for="email">Correo electrónico: <span class="required">*</span></label>
</div>
<div class="form-input">
<input id="email" name="email" type="email" placeholder="Tu respuesta" required>
</div>
<div class="form-label">
<label for="movil">Celular de contacto: <span class="required">*</span></label>
</div>
<div class="form-input">
<input id="movil" name="movil" type="text" pattern="[9][0-9]{8}" placeholder="Tu respuesta" required maxlength="9">
</div>
<div class="form-label">
<label for="region">Región: <span class="required">*</span></label>
</div>
<div class="form-select">
<select id="region" name="region" class="region" required>
</select>
</div>
</fieldset><fieldset class="container">
<legend class="diagonal">Datos del diplomado de tu interés</legend>

<!-- Sección #2 -->
<div class="seccion_2"></div>

<div class="form-label">
<label for="diploma1">Diplomado: <span class="required">*</span></label>
</div>
<div class="form-select">
<select id="diploma1" name="diploma1" class="diplomado_1"  required></select>
</div>
<div class="form-label">
<label for="diploma2">Segundo diplomado (opcional): </label>
</div>
<div class="form-select">
<select id="diploma2" name="diploma2" class="diplomado_2"></select>
</div>
<div class="form-label">
<label for="diploma3">Tercer diplomado (opcional): </label>
</div>
<div class="form-select">
<select id="diploma3" name="diploma3" class="diplomado_3"></select>
</div>
<div class="form-label">
<label for="mode">Modalidad de estudio: <span class="required">*</span></label>
</div>
<div class="form-select">
<select id="mode" name="mode" required class="modalidad">
</select>
</div>
<div class="form-label">
<label for="startdate">Fecha de inicio: <span class="required">*</span></label>
</div>
<div class="form-select">
<select id="startdate" name="startdate" required class="fecha_inicio_curso"></select>
</div>
<div class="form-label">
<label for="promotion">Promoción: <span class="required">*</span></label>
</div>
<div class="form-select">
<select id="promotion" name="promotion" required class="promocion_curso">
</select>
</div>
</fieldset><fieldset class="container">
<legend class="diagonal">Datos de la beca gratuita</legend>

<!-- Sección #3 -->
<div class="seccion_3"></div>

<div class="form-label">
<label for="gift-course">Confirma tu registro para acceder a la BECA INTEGRAL:</label>
</div>
<div class="form-select">
<select id="gift-course" name="gift-course" class="beca_curso"></select>
</div>
</fieldset><input id="flag" name="flag" type="hidden" value="registration"/>
<!-- 
<input id="submit" name="submit" type="submit" value="Enviar"> -->
  <input id="submit" name="submit" type="submit" value="Enviar">
</form></section>
<footer>
<p class="credit">&copy; 2016 - <?= date('Y') ?> &#124; 
<a href="https://www.ipeg.edu.pe/">Instituto Peruano de Gobierno - IPEG</a> &#124;
<a href="https://www.ipeg.edu.pe/">Inicio</a> &#124;
<a href="https://www.ipeg.edu.pe/contacto/">Contacto</a>
</p>
</footer>

<script src="assets/vendor/jquery/jquery.min.js"></script>
<script>

$( document ).ready(function() {

//Cargar Secciones:
url = "sources/reserva.php?op=1";

$.getJSON(url,{"id":1},function(data){

$('.seccion_1').html(data.seccion_1);
$('.seccion_2').html(data.seccion_2);
$('.seccion_3').html(data.seccion_3);  
$('.title').html(data.titulo);
$('.subtitle').html(data.subtitulo);

});

//Cargar Regiones
url = "sources/reserva.php?op=2";
region = '<option value="">Elige</option>';
$.getJSON(url,{},function (data){

data.forEach(function (data){

region += '<option value="'+data.Nombre+'">'+data.Nombre+'</option>';

$('.region').html(region);

});

});


//Cargar Diplomado
url       = "sources/reserva.php?op=3";
diplomado = '<option value="">Elige</option>';
$.getJSON(url,{},function (data){

data.forEach(function (data){

diplomado+= '<option value="'+data.id+'">'+data.fullname+'</option>';

$('.diplomado_1').html(diplomado);
$('.diplomado_2').html(diplomado);
$('.diplomado_3').html(diplomado);

});

});


//Cargar Modalidad
url       = "sources/reserva.php?op=4";
modalidad = '<option value="">Elige</option>';
$.getJSON(url,{},function (data){

data.forEach(function (data){

descripcion = data.nombre+' ('+data.semana+' semanas - S/.'+data.costo+')';

modalidad+= '<option value="'+data.codigo+'">'+descripcion+'</option>';

$('.modalidad').html(modalidad);

});

});

//Fecha Inicio Curso
url                = "sources/reserva.php?op=5";
fecha_inicio_curso = '<option value="">Elige</option>';
$.getJSON(url,{},function (data){

data.forEach(function (data){

fecha_inicio_curso+= '<option value="'+data.fecha+'">'+data.descripcion+'</option>';

$('.fecha_inicio_curso').html(fecha_inicio_curso);

});

});

//Promoción Curso
url                = "sources/reserva.php?op=6";
promocion_curso = '<option value="">Elige</option>';
$.getJSON(url,{},function (data){

data.forEach(function (data){

promocion_curso+= '<option value="'+data.id+'">'+data.nombre+'</option>';

$('.promocion_curso').html(promocion_curso);

});

});

//Beca Curso
url                = "sources/reserva.php?op=7";
beca_curso         = '<option value="">Elige</option>';
$.getJSON(url,{},function (data){

data.forEach(function (data){

beca_curso+= '<option value="'+data.id+'">'+data.nombre+'</option>';

$('.beca_curso').html(beca_curso);

});

});

});

//Agregar Reserva

$('#agregar').on('submit',function(e){

parametros = $(this).serialize();

$.ajax({

url:"./sources/reserva?op=8",
type:"POST",
dataType :"JSON",
data:parametros,
beforeSend:function(){

swal({
  title: "Cargando",
  imageUrl:"assets/img/loader2.gif",
  text:  "Espere un momento, no cierre la ventana.",
  timer: 3000,
  showConfirmButton: false
});



},
success:function(data)
{


if(data.text=='success')
{

swal({
  title: data.title,
  type:  data.type,
  text:  data.text,
  timer: 3000,
  showConfirmButton: false
}).then(function() {
    window.location = "redirectURL";
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



}




}

});

e.preventDefault();
});
</script>
</body>
</html>
