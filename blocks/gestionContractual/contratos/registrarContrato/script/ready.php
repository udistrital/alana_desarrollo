window.onload = detectarCarga;

function detectarCarga() {
    $('#marcoDatos').show('slow');
}

<?php
$_REQUEST ['tiempo'] = time ();
?>

	          

		$("#<?php echo $this->campoSeguro('perfil')?>").change(function() {
		
    	
				if($("#<?php echo $this->campoSeguro('perfil')?>").val()!=''){
		
		$("#<?php echo $this->campoSeguro('profesion')?>").val('');
		$("#<?php echo $this->campoSeguro('especialidad')?>").val('');
				
		 		 switch($("#<?php echo $this->campoSeguro('perfil')?>").val())
			            {
			                           
			                case '221':
			                    
			                    $("#<?php echo $this->campoSeguro('profesion')?>").prop("readonly",true);
			                   
			                    
			                    $("#<?php echo $this->campoSeguro('profesion')?>").removeClass( " validate[required] " );
			
			                break;
			     
			         		case '225':
			                    
			                   
			                   $("#<?php echo $this->campoSeguro('profesion')?>").prop("readonly",true);
			                    
			                   $("#<?php echo $this->campoSeguro('profesion')?>").removeClass( " validate[required] " );                    
			
			                break;
			     			
			     			case '223':
			                    
			                   
			                   $("#<?php echo $this->campoSeguro('profesion')?>").prop("readonly",false);
			                   
			                   $("#<?php echo $this->campoSeguro('profesion')?>").addClass( " validate[required] " );
     		                   
     		                   
     		                   $("#<?php echo $this->campoSeguro('especialidad')?>").prop("readonly",false);
     		                   
     		                   
     		                   $("#<?php echo $this->campoSeguro('especialidad')?>").addClass( " validate[required] " );
     		                   
			                break;
			   
			                default:
			                
			               		
		               		   $("#<?php echo $this->campoSeguro('profesion')?>").prop("readonly",false);
		               		   
		               		   $("#<?php echo $this->campoSeguro('profesion')?>").addClass( " validate[required] " );
		               		   
		               		   
		               		   
		               		   
     		                   $("#<?php echo $this->campoSeguro('especialidad')?>").prop("readonly",true);
     		                   
     		                   $("#<?php echo $this->campoSeguro('especialidad')?>").removeClass( " validate[required] " );
     		                   
			                   break;
			                
			                
			             }
				}else{
					  
					  $("#<?php echo $this->campoSeguro('profesion')?>").prop("readonly",true);
     		  		  $("#<?php echo $this->campoSeguro('especialidad')?>").prop("readonly",true);
                                       	       
			        $("#<?php echo $this->campoSeguro('profesion')?>").removeClass( " validate[required] " );
                   $("#<?php echo $this->campoSeguro('especialidad')?>").removeClass( " validate[required] " );
				                                   
			
				
				}
		
		 });
                 
                
                		 		 	 
	 	$("#<?php echo $this->campoSeguro('tipo_compromiso')?>").change(function() {
    	
    	
    	
				if($("#<?php echo $this->campoSeguro('tipo_compromiso')?>").val()!=''){
		
						if($("#<?php echo $this->campoSeguro('tipo_compromiso')?>").val()==3){
		
							$("#<?php echo $this->campoSeguro('divisionConvenio')?>").css('display','block');
							
		                    }else{
		                    
		                    
		                    $("#<?php echo $this->campoSeguro('divisionConvenio')?>").css('display','none');
		                    $("#<?php echo $this->campoSeguro('numero_convenio')?>").val("");
		                    $("#<?php echo $this->campoSeguro('vigencia_convenio')?>").val("");
		                    }
		
				}else{
				
				$("#<?php echo $this->campoSeguro('divisionConvenio')?>").css('display','none');
				
				
				
				}
		
		 });
	 	$("#<?php echo $this->campoSeguro('tipo_contrato')?>").change(function() {
    	
    	
    	
				if($("#<?php echo $this->campoSeguro('tipo_contrato')?>").val()!=''){
		
						if($("#<?php echo $this->campoSeguro('tipo_contrato')?>").val()==6){
		
							$("#<?php echo $this->campoSeguro('divisionPerfil')?>").css('display','block');
							
		                    }else{
		                    
		                    
		                   $("#<?php echo $this->campoSeguro('divisionPerfil')?>").css('display','none');
		                    $("#<?php echo $this->campoSeguro('perfil')?>").val(null);
		                    $("#<?php echo $this->campoSeguro('perfil')?>").width(220);
	$("#<?php echo $this->campoSeguro('perfil')?>").select2();
		                  
		                    }
		
				}else{
				
				$("#<?php echo $this->campoSeguro('divisionPerfil')?>").css('display','none');
				
				
				
				}
		
		 });
	 	$("#<?php echo $this->campoSeguro('tipo_supervisor')?>").change(function() {
    	
    	
    	
				if($("#<?php echo $this->campoSeguro('tipo_supervisor')?>").val()!=''){
		
						if($("#<?php echo $this->campoSeguro('tipo_supervisor')?>").val()==1){
		
							$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario')?>").css('display','block');
							$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor')?>").css('display','none');
							
		                    }else{
		                    
		                    
                                                        $("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario')?>").css('display','none');
							$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor')?>").css('display','block');
		                    }
		
				}else{
				
				$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario')?>").css('display','none');
				$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor')?>").css('display','none');
				
				
				
				}
		
		 });
	 	$("#<?php echo $this->campoSeguro('tipo_moneda')?>").change(function() {
    	
    	
    	
				if($("#<?php echo $this->campoSeguro('tipo_moneda')?>").val()!=''){
		
						if($("#<?php echo $this->campoSeguro('tipo_moneda')?>").val()!=137){
		
							$("#<?php echo $this->campoSeguro('divisionMonedaExtranjera')?>").css('display','block');
                                                        $("#<?php echo $this->campoSeguro('valor_contrato_moneda_ex')?>").addClass( " validate[required] " );
                                                        $("#<?php echo $this->campoSeguro('tasa_cambio')?>").addClass( " validate[required] " );
							
		                    }else{
		                    
		                    
		                    $("#<?php echo $this->campoSeguro('divisionMonedaExtranjera')?>").css('display','none');
		                    $("#<?php echo $this->campoSeguro('valor_contrato_moneda_ex')?>").val("");
		                    $("#<?php echo $this->campoSeguro('tasa_cambio')?>").val("");
		                    }
		
				}else{
				
				$("#<?php echo $this->campoSeguro('divisionMonedaExtranjera')?>").css('display','none');
				
				$("#<?php echo $this->campoSeguro('valor_contrato_moneda_ex')?>").removeClass( " validate[required] " );
                                $("#<?php echo $this->campoSeguro('tasa_cambio')?>").removeClass( " validate[required] " );
				
				}
		
		 });
		 
		
		 
		 
	 	$("#<?php echo $this->campoSeguro('clase_contratista')?>").change(function() {
                
                                                               
				if($("#<?php echo $this->campoSeguro('clase_contratista')?>").val()!=''){
                               
                                    if($("#<?php echo $this->campoSeguro('clase_contratista')?>").val()==33){
                                    
		
							$("#<?php echo $this->campoSeguro('divisionClaseContratista')?>").css('display','block');
							$("#<?php echo $this->campoSeguro('divisionSociedadTemporal')?>").css('display','none');
							$("#<?php echo $this->campoSeguro('selec_sociedad')?>").val('');
							$("#<?php echo $this->campoSeguro('id_proveedor')?>").val('');
							$('.infosociedadparticipantesspan').html('');
							$('.infosociedadspan').html('');
 	                            }else if ($("#<?php echo $this->campoSeguro('clase_contratista')?>").val() == 32) {
                                                        $("#<?php echo $this->campoSeguro('divisionClaseContratista')?>").css('display','none');
							$("#<?php echo $this->campoSeguro('divisionSociedadTemporal')?>").css('display','block');
                                                        $("#<?php echo $this->campoSeguro('selec_proveedor')?>").val('');
                                                        $("#<?php echo $this->campoSeguro('id_proveedor')?>").val('');
                                                        $('.infoproveedorspan').html('');
                                                       							
                                                                     
		                    }else{		                    
		                    
		                    $("#<?php echo $this->campoSeguro('divisionClaseContratista')?>").css('display','none');
		                   
		                    }
		
				}else{
				
				$("#<?php echo $this->campoSeguro('divisionClaseContratista')?>").css('display','none');
				$("#<?php echo $this->campoSeguro('divisionSociedadTemporal')?>").css('display','none');
				
				
				
				
				}
		
		 });
		 
		 
		 
		$("#<?php echo $this->campoSeguro('vigencia')?>").change(function() {
    	
				if($("#<?php echo $this->campoSeguro('vigencia')?>").val()!=''){
		
					NumeroSolicitud();	
		
				}else{}
		
		 });
		 
     $('#<?php echo $this->campoSeguro('fecha_suscrip_super')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		maxDate: 0,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    
		});
		 		 
		 
		 
		 
     $('#<?php echo $this->campoSeguro('fecha_limite')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    
		});
		 
		 
		 
	$('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    onSelect: function(dateText, inst) {
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
			
		});
              $('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    onSelect: function(dateText, inst) {
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('option', 'maxDate', lockDate);
			 },
			 onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_final')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
	   });
	
           $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").change(function() {

                if($("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").val()!=''){

                    if($("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").val()!=96){
                        
                        $("#<?php echo $this->campoSeguro('divisionSedeDependenciaLugarEjecucion') ?>").css('display','none');
                        $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").val('');
                        $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").val('');
                        $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").select2();
                        $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").select2();

                    }else{

                        $("#<?php echo $this->campoSeguro('divisionSedeDependenciaLugarEjecucion') ?>").css('display','block');
                    }

                }else{

                    $("#<?php echo $this->campoSeguro('divisionSedeDependenciaLugarEjecucion') ?>").css('display','none');
                    $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").val('');
                    $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").val('');
                    $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").select2();
                    $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").select2();
                   
                }

            });	



			 
			 
			    $('#<?php echo $this->campoSeguro('fecha_inicio_poliza')?>').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			    onSelect: function(dateText, inst) {
				var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza')?>').datepicker('getDate'));
				$('input#<?php echo $this->campoSeguro('fecha_final_poliza')?>').datepicker('option', 'minDate', lockDate);
				},
				onClose: function() { 
			 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio_poliza')?>').val()!='')
		            {
		                $('#<?php echo $this->campoSeguro('fecha_final_poliza')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
		        }else {
		                $('#<?php echo $this->campoSeguro('fecha_final_poliza')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
		            }
				  }
			
			
			});
		      $('#<?php echo $this->campoSeguro('fecha_final_poliza')?>').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			    onSelect: function(dateText, inst) {
				var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_poliza')?>').datepicker('getDate'));
				$('input#<?php echo $this->campoSeguro('fecha_inicio_poliza')?>').datepicker('option', 'maxDate', lockDate);
				 },
				 onClose: function() { 
			 	    if ($('input#<?php echo $this->campoSeguro('fecha_final_poliza')?>').val()!='')
		            {
		                $('#<?php echo $this->campoSeguro('fecha_inicio_poliza')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
		        }else {
		                $('#<?php echo $this->campoSeguro('fecha_inicio_poliza')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
		            }
				  }
			
		   });
	
			 
	 	 
	 	
		 
                   
        setTimeout(function() {
            $('#mensajeRegistroPrevio').hide( "drop", { direction: "up" }, "slow" );
                              }, 5000);
	            
	$("#<?php echo $this->campoSeguro('clase_contrato')?>").width(250);
	$("#<?php echo $this->campoSeguro('clase_contrato')?>").select2();
	
	$("#<?php echo $this->campoSeguro('tipo_contrato')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipo_contrato')?>").select2();
	
        $("#<?php echo $this->campoSeguro('perfil')?>").width(220);
	$("#<?php echo $this->campoSeguro('perfil')?>").select2();
	
	$("#<?php echo $this->campoSeguro('tipo_compromiso')?>").select2();
	$("#<?php echo $this->campoSeguro('tipo_compromiso')?>").select2();
	
	$("#<?php echo $this->campoSeguro('dependencia')?>").width(220);
	$("#<?php echo $this->campoSeguro('dependencia')?>").select2();
	
	$("#<?php echo $this->campoSeguro('tipologia_especifica')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipologia_especifica')?>").select2();
	
	$("#<?php echo $this->campoSeguro('modalidad_seleccion')?>").width(220);
	$("#<?php echo $this->campoSeguro('modalidad_seleccion')?>").select2();
	
	$("#<?php echo $this->campoSeguro('vigencia_convenio')?>").width(220);
	$("#<?php echo $this->campoSeguro('vigencia_convenio')?>").select2();
	
	$("#<?php echo $this->campoSeguro('convenio_solicitante')?>").width(220);
	$("#<?php echo $this->campoSeguro('convenio_solicitante')?>").select2();
	
	$("#<?php echo $this->campoSeguro('procedimiento')?>").width(220);
	$("#<?php echo $this->campoSeguro('procedimiento')?>").select2();
	
	$("#<?php echo $this->campoSeguro('regimen_contratación')?>").width(220);
	$("#<?php echo $this->campoSeguro('regimen_contratación')?>").select2();
	
        $("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo')?>").width(220);
	$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo')?>").select2();
	
	$("#<?php echo $this->campoSeguro('tipo_moneda')?>").width(250);
	$("#<?php echo $this->campoSeguro('tipo_moneda')?>").select2();
	
        $("#<?php echo $this->campoSeguro('numero_disponibilidad')?>").width(200);
	$("#<?php echo $this->campoSeguro('numero_disponibilidad')?>").select2();
	
	$("#<?php echo $this->campoSeguro('ordenador_gasto')?>").width(250);
	$("#<?php echo $this->campoSeguro('ordenador_gasto')?>").select2();
	
	
	$("#<?php echo $this->campoSeguro('tipo_gasto')?>").width(250);
	$("#<?php echo $this->campoSeguro('tipo_gasto')?>").select2();
	
	$("#<?php echo $this->campoSeguro('origen_recursos')?>").width(250);
	$("#<?php echo $this->campoSeguro('origen_recursos')?>").select2();

	$("#<?php echo $this->campoSeguro('origen_presupuesto')?>").select2();
	
	$("#<?php echo $this->campoSeguro('tema_gasto_inversion')?>").width(220);
	$("#<?php echo $this->campoSeguro('tema_gasto_inversion')?>").select2();

	
	$("#<?php echo $this->campoSeguro('tema_gasto_inversion')?>").width(220);
	$("#<?php echo $this->campoSeguro('tema_gasto_inversion')?>").select2();

	
	$("#<?php echo $this->campoSeguro('supervisor')?>").width(220);
	$("#<?php echo $this->campoSeguro('supervisor')?>").select2();
	
	
	$("#<?php echo $this->campoSeguro('tipo_supervisor')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipo_supervisor')?>").select2();
	
        $("#<?php echo $this->campoSeguro('dependencia_solicitud')?>").width(220);
	$("#<?php echo $this->campoSeguro('dependencia_solicitud')?>").select2();
	
        $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta')?>").width(200);
	$("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta')?>").select2();
			 
	$("#<?php echo $this->campoSeguro('formaPago')?>").width(180);
	$("#<?php echo $this->campoSeguro('formaPago')?>").select2();
			 
			 

        
        $("#<?php echo $this->campoSeguro('vigencia')?>").select2();
	$("#<?php echo $this->campoSeguro('num_solicitud')?>").select2(); 
	
	
	$("#<?php echo $this->campoSeguro('clase_contratista')?>").select2();
	
	
	$("#<?php echo $this->campoSeguro('supervisor')?>").width(305);
	$("#<?php echo $this->campoSeguro('supervisor')?>").select2();
	
        $("#<?php echo $this->campoSeguro('nombre_supervisor_interventor')?>").width(300);
	$("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});
        
        $('#<?php echo $this->campoSeguro('nombre_supervisor') ?>').width(300);			       
        $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});
        
        $('#<?php echo $this->campoSeguro('cargo_supervisor') ?>').width(300);
        $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").select2();
       
        
        $('#<?php echo $this->campoSeguro('tipo_control') ?>').width(300);
        $("#<?php echo $this->campoSeguro('tipo_control') ?>").select2();


        $('#<?php echo $this->campoSeguro('sede_super') ?>').width(300);
        $("#<?php echo $this->campoSeguro('sede_super') ?>").select2();
        
        $('#<?php echo $this->campoSeguro('sede') ?>').width(300);
        $("#<?php echo $this->campoSeguro('sede') ?>").select2();


        
 


//Lugar de Ejecucion

$("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").select2();
$("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").width(200);  
$("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").select2();
$("#<?php echo $this->campoSeguro('ejecucionPais') ?>").width(200);  
$("#<?php echo $this->campoSeguro('ejecucionPais') ?>").select2();

			 
	
