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


function Mayusculas(field) 
{
field.value         = field.value.toUpperCase();
}
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
<!-- Sección #1 -->
<div class="seccion_1"></div>

<!-- Sección #2 -->
<div class="seccion_2"></div>


<form  id="agregar" autocomplete="off"><fieldset class="container">
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
<input id="fullname" name="fullname" type="text" placeholder="Tu respuesta" required
 onchange="Mayusculas(this)">
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

<!-- Sección #3 -->
<div class="seccion_3"></div>

<div class="form-label">
<label for="diploma1">Diplomado: <span class="required">*</span></label>
</div>

<div class="form-input">
  
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN GESTIÓN PÚBLICA<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN DERECHO ADMINISTRATIVO<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN CONTRATACIONES DEL ESTADO<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN DELITOS DE CORRUPCIÓN DE FUNCIONARIOS<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN ESTRATEGIAS ANTICORRUPCIÓN<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN DERECHO TRIBUTARIO<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN DERECHO ADMINISTRATIVO Y PAS<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN GESTIÓN DE RECURSOS HUMANOS Y LEY DEL SERVICIO CIVIL<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN DERECHO LABORAL Y PROCESAL LABORAL<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN SEGURIDAD Y SALUD EN EL TRABAJO<BR>
<input type="checkbox" name="" id="">DIPLOMADO ESPECIALIZADO EN DERECHO MINERO


</div>

<p></p>

<div class="form-label">
<label for="mode">Modalidad de estudio: <span class="required">*</span></label>
</div>

<div class="form-input">

<input type="radio" name="" id=""> Presencial
<input type="radio" name="" id=""> Virtual

</div>

<p></p>
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

<!-- Sección #4 -->
<div class="seccion_4"></div>

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
$('.seccion_4').html(data.seccion_4);  


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

diplomado+= '<option value="'+data.idnumber+'">'+data.fullname+'</option>';

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
//dataType :"JSON",
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

setTimeout(function(){
            window.location.href = "gracias";
         }, 3000);



swal({
  title:"Gracias",
  text: "Tú Reserva se ha realizado de manera satisfactoria",
  type:"success",
  timer: 3000,
  showConfirmButton: false
});


}

});

e.preventDefault();
});
</script>
</body>
</html>
