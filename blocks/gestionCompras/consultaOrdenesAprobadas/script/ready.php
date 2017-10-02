window.onload = detectarCarga;

function detectarCarga() {
    $('#marcoDatos').show('slow');
}

<?php ?>

// Asociar el widget de validación al formulario
$("#consultaOrdenesAprobadas").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});


$(function() {
$("#consultaOrdenesAprobadas").submit(function() {
$resultado=$("#consultaOrdenesAprobadas").validationEngine("validate");
if ($resultado) {

return true;
}
return false;
});
});



$('#tablaParticipantesSociedad').dataTable();

$("#ventanaEmergenteContratista" ).dialog({
height: 700,
width: 700,
title: "Datos Convenio",
autoOpen: false,
});

$("#ventanaEmergenteATC" ).dialog({
height: 700,
width: 700,
title: "Datos Convenio",
autoOpen: false,
});

$('#tablaDisponibilidades').dataTable();
$('#tablaRegistros').dataTable();

$('#<?php echo $this->campoSeguro('dependencia_solicitante') ?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2(); 


$('#<?php echo $this->campoSeguro('clase_contrato') ?>').width(350);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2(); 

$('#<?php echo $this->campoSeguro('poliza') ?>').width(350);
$("#<?php echo $this->campoSeguro('poliza') ?>").select2(); 

$("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").select2();


$('#<?php echo $this->campoSeguro('vigencia_convenio') ?>').width(150);
$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").select2();

$('#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>').width(350);
$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").select2(); 

$('#<?php echo $this->campoSeguro('registro_presupuestal') ?>').width(220);
$("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").select2(); 

$('#<?php echo $this->campoSeguro('sede') ?>').width(350);
$("#<?php echo $this->campoSeguro('sede') ?>").select2();                 

$('#<?php echo $this->campoSeguro('formaPago') ?>').width(150);
$("#<?php echo $this->campoSeguro('formaPago') ?>").select2();                 

$('#<?php echo $this->campoSeguro('convenio_solicitante') ?>').width(150);
$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();                 

$('#<?php echo $this->campoSeguro('sede_super') ?>').width(250);
$("#<?php echo $this->campoSeguro('sede_super') ?>").select2();

$('#<?php echo $this->campoSeguro('unidad_ejecucion') ?>').width(200);
$("#<?php echo $this->campoSeguro('unidad_ejecucion') ?>").select2();

$('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(250);
$("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2(); 

$('#<?php echo $this->campoSeguro('ordenador_gasto') ?>').width(300);			       
$("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").select2();

$('#<?php echo $this->campoSeguro('nombre_supervisor') ?>').width(300);			       
$("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});
$('#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>').width(300);			       
$("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});

$('#<?php echo $this->campoSeguro('tipo_orden') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_orden') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipo_compromiso') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipologia_especifica') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipologia_especifica') ?>").select2(); 

$('#<?php echo $this->campoSeguro('modalidad_seleccion') ?>').width(350);
$("#<?php echo $this->campoSeguro('modalidad_seleccion') ?>").select2(); 

$('#<?php echo $this->campoSeguro('procedimiento') ?>').width(350);
$("#<?php echo $this->campoSeguro('procedimiento') ?>").select2(); 

$('#<?php echo $this->campoSeguro('regimen_contratación') ?>').width(350);
$("#<?php echo $this->campoSeguro('regimen_contratación') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipo_moneda') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_moneda') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipo_gasto') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_gasto') ?>").select2(); 

$('#<?php echo $this->campoSeguro('origen_recursos') ?>').width(350);
$("#<?php echo $this->campoSeguro('origen_recursos') ?>").select2(); 

$('#<?php echo $this->campoSeguro('origen_presupuesto') ?>').width(350);
$("#<?php echo $this->campoSeguro('origen_presupuesto') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>').width(350);
$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipo_control') ?>').width(250);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2(); 

$("#<?php echo $this->campoSeguro('numero_orden') ?>").select2();
$("#<?php echo $this->campoSeguro('sedeConsulta') ?>").select2();
$("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").select2();
$("#<?php echo $this->campoSeguro('proveedorContratista') ?>").select2();
$("#<?php echo $this->campoSeguro('sede') ?>").select2();

$('#<?php echo $this->campoSeguro('orden_consulta') ?>').select2();

$('#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>').width(100);             
$("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").select2();
$('#<?php echo $this->campoSeguro('diponibilidad') ?>').width(150);
$('#<?php echo $this->campoSeguro('diponibilidad') ?>').select2();


$("#<?php echo $this->campoSeguro('vigencia_registro') ?>").select2();
$('#<?php echo $this->campoSeguro('registro') ?>').width(150);
$("#<?php echo $this->campoSeguro('registro') ?>").select2(); 



$('#<?php echo $this->campoSeguro('cargo_supervisor') ?>').width(500);
$("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").select2();


$('#<?php echo $this->campoSeguro('tipo_control') ?>').width(300);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2();

$("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").select2();
$('#<?php echo $this->campoSeguro('nombreContratista') ?>').attr("style", "width: 60px '");





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




$('#<?php echo $this->campoSeguro('fecha_disponibilidad') ?>').datepicker({
dateFormat: 'yy-mm-dd',
maxDate: 0,
changeYear: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
});


$('#<?php echo $this->campoSeguro('fecha_registro') ?>').datepicker({
dateFormat: 'yy-mm-dd',
maxDate: 0,
changeYear: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
});



$("#<?php echo $this->campoSeguro('contratista_consulta') ?>").select2();




$('#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>').attr('disabled','');
$("#<?php echo $this->campoSeguro('sede_consultar') ?>").select2();











$("#<?php echo $this->campoSeguro('rubro') ?>").select2({
placeholder: "Search for a repository",
minimumInputLength: 3,

});

$("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").select2();
$("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").select2();
$("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2();


$( "#<?php echo $this->campoSeguro('cantidad') ?>" ).keyup(function() {

$("#<?php echo $this->campoSeguro('valor') ?>").val('');
$("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');


resetIva();


});  



$( "#<?php echo $this->campoSeguro('valor') ?>" ).keyup(function() {
$("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');
resetIva(); 
cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());

precio = Math.round((cantidad * valor)*100)/100;


if (precio==0){


$("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');

}else{

$("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val(precio);

}

}); 


$( "#<?php echo $this->campoSeguro('iva') ?>" ).change(function() {

switch($("#<?php echo $this->campoSeguro('iva') ?>").val())
{

case '1':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
precio=cantidad * valor;
total=Math.round(precio*100)/100;

$("#<?php echo $this->campoSeguro('total_iva') ?>").val('0');

$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val(total);

break;

case '2':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
precio=cantidad * valor;
total=Math.round(precio*100)/100;

$("#<?php echo $this->campoSeguro('total_iva') ?>").val('0');

$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val(total);

break;

case '3':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
iva = Math.round(((cantidad * valor)* 0.05)*100)/100;
precio=Math.round((cantidad * valor)*100)/100;
total=Math.round((precio+iva)*100)/100;


$("#<?php echo $this->campoSeguro('total_iva') ?>").val(iva);

$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val(total);

break;

case '4':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
iva = Math.round(((cantidad * valor)* 0.04)*100)/100;
precio = Math.round((cantidad*valor)*100)/100;
total=Math.round((precio+iva)*100)/100;


$("#<?php echo $this->campoSeguro('total_iva') ?>").val(iva);
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val(total);

break;

case '5':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
iva = Math.round(((cantidad * valor)* 0.1)*100)/100;
precio = Math.round((cantidad*valor)*100)/100;
total=Math.round((precio+iva)*100)/100;

$("#<?php echo $this->campoSeguro('total_iva') ?>").val(iva);
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val(total);

break;

case '6':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
iva = Math.round(((cantidad * valor)* 0.16)*100)/100;
precio = Math.round((cantidad*valor)*100)/100;
total=Math.round((precio+iva)*100)/100;


$("#<?php echo $this->campoSeguro('total_iva') ?>").val(iva);
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val(total);

break;


default:
$("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

break;

}

});  


var dates0 = $("#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
minDate: $('#<?php echo $this->campoSeguro('fecha_inicio_validacion') ?>').val(),
monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
onSelect: function (selectedDate) {
var option = this.id == "from" ? "maxDate" : "minDate",
instance = $(this).data("datepicker"),
date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
dates0.not(this).datepicker("option", option, date);
}
});
var inidate0 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').datepicker('getDate'));
var dates0 = $("#<?php echo $this->campoSeguro('fecha_final_acta') ?>").datepicker({
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

var fechaActualCancelacion = $('#<?php echo $this->campoSeguro('fecha_cancelacion_actual') ?>').val();
var fechaCancelacion = $("#<?php echo $this->campoSeguro('fecha_cancelacion') ?>").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
minDate: fechaActualCancelacion,
monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

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




