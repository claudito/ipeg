$(document).ready(function (){

$('#login').on('submit',function(e){


   //redirect
   
//Local Storage
	 url = localStorage.url_ipeg ;

setTimeout(function(){
            window.location.href = url+"gracias";
         }, 3000);



e.preventDefault();
});

});

