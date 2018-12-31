<!DOCTYPE html>
<html lang="es">
<head>
<title>IPEG | Reserva de vacante</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex" />
<link rel="shortcut icon" sizes="16x16" href="https://www.ipeg.edu.pe/wp-content/uploads/2018/01/cropped-logo-ipeg-32x32.png">
<link rel="stylesheet" type="text/css" href="https://www.ipeg.edu.pe/SIPEGWeb/css/styles-form-reserve.css"><!-- Facebook Pixel Code -->
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
<div class="seccion_1"></div>

<div class="seccion_5"></div>

</section>
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

$('.seccion_1').html(data.seccion_1)
$('.seccion_5').html(data.seccion_5); 


});




});
</script>
</body>
</html>
