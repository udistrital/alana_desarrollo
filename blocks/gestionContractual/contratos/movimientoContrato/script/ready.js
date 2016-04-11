 $('#tabla').dataTable( {
"sPaginationType": "full_numbers"
 } );
 
 $('#tablaRegistros').dataTable( {
	 paging: false,
	 "bLengthChange": false,
	  } );
          
          
                      $("#movimientoContrato").validationEngine({
            promptPosition : "bottomRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 1000
	         });


     $(function() {
            $("#movimientoContrato").submit(function() {
		                $resultado = $("#movimientoContrato").validationEngine("validate");

		if ($resultado) {

			return true;
		}
		return false;
            });
        });

		