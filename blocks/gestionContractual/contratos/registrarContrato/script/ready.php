<?php
$_REQUEST ['tiempo'] = time ();
?>
  // Asociar el widget de validación al formulario
            $("#registrarContrato").validationEngine({
            promptPosition : "bottomRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });


     $(function() {
            $("#registrarContrato").submit(function() {
                $resultado=$("#registrarContrato").validationEngine("validate");
           
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
	$("#<?php echo $this->campoSeguro('vigencia')?>").select2();
	$("#<?php echo $this->campoSeguro('vigencia')?>").select2(); 
          






