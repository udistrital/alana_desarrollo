<?php ?>

// Asociar el widget de validación al formulario
$("#gestionPolizas").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});


$(function() {
$("#gestionPolizas").submit(function() {
$resultado=$("#gestionPolizas").validationEngine("validate");
if ($resultado) {

return true;
}
return false;
});
});

$('#tablaTitulos').dataTable( {
"sPaginationType": "full_numbers"
} );

$("#ventanaEmergenteContratista" ).dialog({
height: 700,
width: 900,
title: "Datos Convenio",
autoOpen: false,
});



$("#amparo0").width(300);
$("#amparo0").select2();
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2();
$("#<?php echo $this->campoSeguro('amparo') ?>").width(500);
$("#<?php echo $this->campoSeguro('amparo') ?>").select2();
$("#<?php echo $this->campoSeguro('entidad_aseguradora') ?>").width(500);
$("#<?php echo $this->campoSeguro('entidad_aseguradora') ?>").select2();
$("#<?php echo $this->campoSeguro('tipo_amparo_registro') ?>").width(500);
$("#<?php echo $this->campoSeguro('tipo_amparo_registro') ?>").select2();




$('.datepicker').datepicker({

dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']});





$('#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final_sub') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final_sub') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_final_sub') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}


});
$('#<?php echo $this->campoSeguro('fecha_final_sub') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_sub') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').datepicker('option', 'maxDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_final_sub') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}

});

$('#<?php echo $this->campoSeguro('fecha_inicio') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: $('#<?php echo $this->campoSeguro('fecha_suscripcion_validacion') ?>').val(),
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
onSelect: function(dateText, inst) {
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('option', 'minDate', lockDate);
$('input#<?php echo $this->campoSeguro('fecha_aprobacion') ?>').datepicker('option', 'minDate', lockDate);
},
});

$('#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
beforeShow: function() {
var lockDate = $('#<?php echo $this->campoSeguro('fecha_inicial') ?>').val();
$('input#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('option', 'minDate', lockDate);  
},
onClose: function() {
var lockDate = $('#<?php echo $this->campoSeguro('fecha_inicial') ?>').val();
$('input#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('option', 'minDate', lockDate);  
}
});
$('#<?php echo $this->campoSeguro('fecha_aprobacion') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
beforeShow: function() {
var lockDate = $('#<?php echo $this->campoSeguro('fecha_inicial') ?>').val();
$('input#<?php echo $this->campoSeguro('fecha_aprobacion') ?>').datepicker('option', 'minDate', lockDate);  
},
onClose: function() {
var lockDate = $('#<?php echo $this->campoSeguro('fecha_inicial') ?>').val();
$('input#<?php echo $this->campoSeguro('fecha_aprobacion') ?>').datepicker('option', 'minDate', lockDate);  
}

});


$('#<?php echo $this->campoSeguro('fecha_inicio_amparo') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_amparo') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final_amparo') ?>').datepicker('option', 'minDate', lockDate);
},

});

$('#<?php echo $this->campoSeguro('fecha_final_amparo') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
beforeShow: function() {
var lockDate = $('#<?php echo $this->campoSeguro('fecha_inicio_amparo') ?>').val();
$('input#<?php echo $this->campoSeguro('fecha_final_amparo') ?>').datepicker('option', 'minDate', lockDate);  
},
onClose: function() {
var lockDate = $('#<?php echo $this->campoSeguro('fecha_inicio_amparo') ?>').val();
$('input#<?php echo $this->campoSeguro('fecha_final_amparo') ?>').datepicker('option', 'minDate', lockDate);  
}

});

// Gestion de Amparos Interfaz

$('#fechainiamparo0').datepicker({
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
var lockDate = new Date($('#fechainiamparo0').datepicker('getDate'));
$('input#fechafinamparo0').datepicker('option', 'minDate', lockDate);
},

});

$('#fechafinamparo0').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
beforeShow: function() {
var lockDate = $('#fechainiamparo0').val();
$('input#fechafinamparo0').datepicker('option', 'minDate', lockDate);  
},
onClose: function() {
var lockDate = $('#fechainiamparo0').val();
$('input#fechafinamparo0').datepicker('option', 'minDate', lockDate);  
}

});



  $('#<?php echo $this->campoSeguro('porcentaje_amparo') ?>').keyup(function(){
            var valorPorcentaje = $('#<?php echo $this->campoSeguro('porcentaje_amparo') ?>').val();
            var valor_contrato = $("#<?php echo $this->campoSeguro('valor_contrato') ?>").val();
            var valor_amparo = (valorPorcentaje * valor_contrato)/100;
            $('#<?php echo $this->campoSeguro('valor') ?>').val(valor_amparo);
        });
  $('#porcentajeamparo0').keyup(function(){
  
         
            var valorPorcentaje = $("#porcentajeamparo0").val();
            
           if(valorPorcentaje >0){
            var valor_contrato = $("#<?php echo $this->campoSeguro('valor_contrato') ?>").val();
            var valor_amparo = (valorPorcentaje * valor_contrato)/100;
             $("#valoramparo0").val(valor_amparo);
            }else{
                $("#valoramparo0").val("");
                alert("El porcentaje no es un valor Valido.")
            }
             
        });
        

$("#<?php echo $this->campoSeguro('tipo_amparo_registro')?>").change(function() {
                
                if($("#<?php echo $this->campoSeguro('tipo_amparo_registro')?>").val()!=''){
                               
                    if($("#<?php echo $this->campoSeguro('tipo_amparo_registro')?>").val()=='1'){
                                    
                        $("#<?php echo $this->campoSeguro('divisionAmparos')?>").css('display','block');
			$("#<?php echo $this->campoSeguro('divisionAmparoCivilporMinimos')?>").css('display','none');
                        
                    } else{		                    
		       
                        $("#<?php echo $this->campoSeguro('divisionAmparos')?>").css('display','none');
			$("#<?php echo $this->campoSeguro('divisionAmparoCivilporMinimos')?>").css('display','block');
                        
		                   
		    }
		}else{
			
		    $("#<?php echo $this->campoSeguro('divisionAmparos')?>").css('display','none');
		    $("#<?php echo $this->campoSeguro('divisionAmparoCivilporMinimos')?>").css('display','none');
		}
		
 });
