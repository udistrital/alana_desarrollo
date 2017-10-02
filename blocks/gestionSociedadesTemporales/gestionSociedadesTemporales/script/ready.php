<?php ?>

// Asociar el widget de validación al formulario
$("#gestionSociedadesTemporales").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});


$(function() {
$("#gestionSociedadesTemporales").submit(function() {
$resultado=$("#gestionSociedadesTemporales").validationEngine("validate");
if ($resultado) {

    
    if ( $("#acumuladoPorcentajes")[0] ) {
        if($("#acumuladoPorcentajes").val() != 100){
            alert("Los Porcentajes de Pariticipación deben sumar Cien por Ciento (100%)");
            return false;
        }else{
            return true;
        }
    }else{
        return true;
    }
}
return false;
});
});


$("#ventanaEmergenteContratista" ).dialog({
height: 700,
width: 900,
title: "Datos Convenio",
autoOpen: false,
});



$("#<?php echo $this->campoSeguro('tipo_sociedad') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_sociedad') ?>").select2();

$('#<?php echo $this->campoSeguro('fecha_inicio') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicio') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_final') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}


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
onSelect: function(dateText, inst) {
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_inicio') ?>').datepicker('option', 'maxDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_final') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_inicio') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_inicio') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}

});


//Registro Sociedad


$("#<?php echo $this->campoSeguro('tipoCuenta') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipoCuenta') ?>").select2();                 
$("#<?php echo $this->campoSeguro('clase_sociedad') ?>").width(200);  
$("#<?php echo $this->campoSeguro('clase_sociedad') ?>").select2();                 
$("#<?php echo $this->campoSeguro('entidadBancaria') ?>").width(200);  
$("#<?php echo $this->campoSeguro('entidadBancaria') ?>").select2();      
$("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").width(200);  
$("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").select2();                 
$("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").width(200);  
$("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").select2();      

