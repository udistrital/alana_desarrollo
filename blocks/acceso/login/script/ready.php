<?php
$_REQUEST ['tiempo'] = time ();

?>            
            
            
  // Asociar el widget de validación al formulario
            $("#<?php echo $this->campoSeguro('login')?>").validationEngine({
            promptPosition : "centerLeft", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });


     $(function() {
            $("#<?php echo $this->campoSeguro('login')?>").submit(function() {
                $resultado=$("#<?php echo $this->campoSeguro('login')?>").validationEngine("validate");
           
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });




 $( "button" ).button().click(function( event ) 
 {
    event.preventDefault();
    });
    
setTimeout(function() {
    $('#divMensaje').hide( "drop", { direction: "up" }, "slow" );
}, 10000); // <-- time in milliseconds


   $("#abrir").click(function(event) {

             event.preventDefault();

             $("#fondo_login").slideToggle();

         });


