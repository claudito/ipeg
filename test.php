<?php 

include'vendor/autoload.php';
include'autoload.php';

//Enviar Mail
//Create a new PHPMailer instance
$mail = new PHPMailer\PHPMailer\PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
$mail->SMTPDebug = 0;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Config UTF-8
$mail->CharSet = "utf-8";

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = USER_MAIL;
//Password to use for SMTP authentication
$mail->Password = USER_PASS;

//Set who the message is to be sent from
$mail->setFrom(USER_MAIL, 'BCG CONSULTING');

//Set who the message is to be sent to
$mail->addAddress('luis.claudio@perutec.com.pe', 'LUIS CLAUDIO');

//Set the subject line
$mail->Subject = 'BCG CONSULTING';

//Crear Cuerpo del Mensaje
$funciones = new Funciones();

$query = "SELECT * FROM plantilla_correo WHERE id=1";
$dato  = $funciones->query($query)[0];

$html           = $dato['cuerpo']; 

//Agregar Contenido
$mail->msgHTML($html);


//send the message, check for errors
if (!$mail->send()) 
{

echo $mail->ErrorInfo;
} 
else 
{
 
 echo "correo enviado";

}







 ?>