 $('#tabla').dataTable( {
                "sPaginationType": "full_numbers"
                 } );



			
			$("#ventanaA").steps({
			    headerTag: "h3",
			    bodyTag: "section",
			    enableAllSteps: true,
			    enablePagination: true,
			    transitionEffect: "slide",
			    onStepChanging: function (event, currentIndex, newIndex){
			    
		             $resultado = $("#registrarContrato").validationEngine("validate");

		     		if ($resultado) {

		     			return true;
		     		}
		     		return false;
			    },
			    onFinished: function (event, currentIndex)
			    {
			    	
			    	 $("#registrarContrato").submit();
			        
			    },
			    labels: {
			        cancel: "Cancelar",
			        current: "current step:",
			        pagination: "Paginación",
			        finish: "Guardar Información",
			        next: "Siquiente",
			        previous: "Atras",
			        loading: "Cagarndo ..."
			    }
			     
			});






            $("#registrarContrato").validationEngine({
            promptPosition : "bottomRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 100000
	         });


     $(function() {
            $("#registrarContrato").submit(function() {
		                $resultado = $("#registrarContrato").validationEngine("validate");

		if ($resultado) {

			return true;
		}
		return false;
            });
        });
