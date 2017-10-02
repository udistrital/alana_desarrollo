<?php
$_REQUEST ['tiempo'] = time();
?>


$("#ventanaEmergenteContratista" ).dialog({
height: 700,
width: 900,
title: "Datos Convenio",
autoOpen: false,
});
var fechaMinima = $('#<?php echo $this->campoSeguro('fecha_ejecucion_validacion') ?>').val();
var susDate = $('#<?php echo $this->campoSeguro('fecha_inicio_suspension_validacion') ?>').val();
var susDate2 = $('#<?php echo $this->campoSeguro('fecha_fin_suspension_validacion') ?>').val();
$('#<?php echo $this->campoSeguro('fecha_reanuadion') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: susDate,
maxDate: susDate2,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],

});
$('#<?php echo $this->campoSeguro('fecha_inicio_cesion') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: fechaMinima,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],

});
$('#<?php echo $this->campoSeguro('fecha_oficial_cambio') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: fechaMinima,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],

});
$('#<?php echo $this->campoSeguro('fecha_Terminacion_anticipada') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: fechaMinima,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],

});

var dates0 = $("#<?php echo $this->campoSeguro('fecha_inicio_suspension') ?>").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
minDate: fechaMinima,
onSelect: function (selectedDate) {
var option = this.id == "from" ? "maxDate" : "minDate",
instance = $(this).data("datepicker"),
date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
dates0.not(this).datepicker("option", option, date);
}
});
var inidate0 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_suspension') ?>').datepicker('getDate'));
var dates0 = $("#<?php echo $this->campoSeguro('fecha_fin_suspension') ?>").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
minDate: inidate0,
monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

});

$("#<?php echo $this->campoSeguro('clase_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2();
$("#<?php echo $this->campoSeguro('tipo_novedad') ?>").select2();
$('#<?php echo $this->campoSeguro('tipo_contrato') ?>').width(500);
$("#<?php echo $this->campoSeguro('tipo_contrato') ?>").select2();                 
$('#<?php echo $this->campoSeguro('sedeConsulta') ?>').width(350);
$("#<?php echo $this->campoSeguro('sedeConsulta') ?>").select2(); 
$("#<?php echo $this->campoSeguro('tipo_adicion_modificacion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipo_adicion_modificacion') ?>").select2();                 
$("#<?php echo $this->campoSeguro('tipo_adicion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipo_adicion') ?>").select2();                 
$("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").width(200);  
$("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").select2();                 
$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").select2();                 

$("#<?php echo $this->campoSeguro('unidad_tiempo_ejecucion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('unidad_tiempo_ejecucion') ?>").select2();                 

$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").width(200);  
$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();                 

$("#<?php echo $this->campoSeguro('unidad_tiempo_ejecucion_suspencion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('unidad_tiempo_ejecucion_suspencion') ?>").select2();                 

$("#<?php echo $this->campoSeguro('tipo_anulacion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipo_anulacion') ?>").select2();                 
$("#<?php echo $this->campoSeguro('registro_presupuestal_reduccion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('registro_presupuestal_reduccion') ?>").select2();                 
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").width(200);  
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();                 
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").width(200);  
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();                 
$("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").select2();                 

$("#<?php echo $this->campoSeguro('tipoCambioSupervisor') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipoCambioSupervisor') ?>").select2();                 
$("#<?php echo $this->campoSeguro('cargosExistentes') ?>").width(200);  
$("#<?php echo $this->campoSeguro('cargosExistentes') ?>").select2();                 
$("#<?php echo $this->campoSeguro('sede_super') ?>").width(300);  
$("#<?php echo $this->campoSeguro('sede_super') ?>").select2();                 
$("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").width(400);  
$("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").select2();      


//Uniones Temporales

$("#<?php echo $this->campoSeguro('tipoCuenta') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipoCuenta') ?>").select2();                 
$("#<?php echo $this->campoSeguro('entidadBancaria') ?>").width(200);  
$("#<?php echo $this->campoSeguro('entidadBancaria') ?>").select2();      




$("#<?php echo $this->campoSeguro('tipo_novedad') ?>").change(function() {


if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()!=''){

$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val(null);
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").val(null);
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();
$("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(null);
$("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").select2();
$("#<?php echo $this->campoSeguro('valor_adicion_presupuesto') ?>").val('');
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").attr('disabled', '');
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").attr('disabled', '');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');


if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==220){
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');


}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==234){
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');
}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==222){
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');
}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==219){
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');
}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==216){
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');
}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==217){

$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');
}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==218){
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');
}if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==224){

$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');

}if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==257){

$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','none');

}
if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==258){

$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionModificacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReduccion') ?>").css('display','block');

}
}
else{

$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionReanudacion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionTerminacionAnticipada') ?>").css('display','none');


}

});



$("#<?php echo $this->campoSeguro('tipo_adicion') ?>").change(function() {

if($("#<?php echo $this->campoSeguro('tipo_adicion') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('tipo_adicion') ?>").val()==248){
$("#<?php echo $this->campoSeguro('divisionAdicionPresupuesto') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAdicionTiempo') ?>").css('display','none');

}
else{
$("#<?php echo $this->campoSeguro('divisionAdicionTiempo') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionAdicionPresupuesto') ?>").css('display','none');

$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val(null);
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").val(null);
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();
$("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(null);
$("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").select2();
$("#<?php echo $this->campoSeguro('valor_adicion_presupuesto') ?>").val('');
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").attr('disabled', '');
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").attr('disabled', '');

}
}
else{

$("#<?php echo $this->campoSeguro('divisionAdicionTiempo') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicionPresupuesto') ?>").css('display','none');


}

});

$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").change(function() {

if($("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()==261){
$("#<?php echo $this->campoSeguro('divisionContrato') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionNovedad') ?>").css('display','none');

}
else{
$("#<?php echo $this->campoSeguro('divisionNovedad') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionContrato') ?>").css('display','none');

}
}
else{

$("#<?php echo $this->campoSeguro('divisionNovedad') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionContrato') ?>").css('display','none');


}

});




$('#<?php echo $this->campoSeguro('fecha_inicio') ?>').datepicker({
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
minDate: fechaMinima,
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


$('#<?php echo $this->campoSeguro('fecha_inicio_consulta') ?>').datepicker({
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
minDate: fechaMinima,
onSelect: function(dateText, inst) {
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_consulta') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final_consulta') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicio_consulta') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final_consulta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_final_consulta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}


});
$('#<?php echo $this->campoSeguro('fecha_final_consulta') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_consulta') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_inicio_consulta') ?>').datepicker('option', 'maxDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_final_consulta') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_inicio_consulta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_inicio_consulta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}

});


