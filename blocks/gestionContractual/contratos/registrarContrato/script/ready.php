<?php

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

        

          






