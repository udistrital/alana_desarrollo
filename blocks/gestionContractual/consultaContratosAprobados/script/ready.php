window.onload = detectarCarga;

function detectarCarga() {
    $('#marcoDatos').show('slow');
}

<?php ?>

// Asociar el widget de validación al formulario
$("#consultaContratosAprobados").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});


$(function() {
$("#consultaContratosAprobados").submit(function() {
$resultado=$("#consultaContratosAprobados").validationEngine("validate");
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

$('#tablaParticipantesSociedad').DataTable({
dom: 'T<"clear">lfrtip',
tableTools: {
"sRowSelect": "os",
"aButtons": ["select_all", "select_none"]
},
"language": {
"sProcessing": "Procesando...",
"sLengthMenu": "Mostrar _MENU_ registros",
"sZeroRecords": "No se encontraron resultados",
"sSearch": "Buscar:",
"sLoadingRecords": "Cargando...",
"sEmptyTable": "Ningún dato disponible en esta tabla",
"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
"oPaginate": {
"sFirst": "Primero",
"sLast": "Ãšltimo",
"sNext": "Siguiente",
"sPrevious": "Anterior"
}
},
"columnDefs": [
{
"targets": [0, 1],
"visible": false,
"searchable": false
}
],
processing: true,
searching: true,
info: true,
"scrollY": "400px",
"scrollCollapse": false,
"bLengthChange": false,
"bPaginate": false,
"aoColumns": [
{sWidth: "10%", sClass: "center"},
{sWidth: "10%", sClass: "center"},
{sWidth: "10%", sClass: "center"},
{sWidth: "10%", sClass: "center"},
{sWidth: "10%", sClass: "center"},
{sWidth: "10%", sClass: "center"},
]


});

$('#tablaRegistros').DataTable();

$("#<?php echo $this->campoSeguro('clase_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2();

$("#<?php echo $this->campoSeguro('clase_contratista') ?>").width(220);
$("#<?php echo $this->campoSeguro('clase_contratista') ?>").select2();

$("#<?php echo $this->campoSeguro('perfil') ?>").width(220);
$("#<?php echo $this->campoSeguro('perfil') ?>").select2();


$("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_contrato') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_orden') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_orden') ?>").select2();

$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").width(220);
$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").select2();

$("#<?php echo $this->campoSeguro('formaPago') ?>").width(220);
$("#<?php echo $this->campoSeguro('formaPago') ?>").select2();

$("#<?php echo $this->campoSeguro('dependencia') ?>").width(220);
$("#<?php echo $this->campoSeguro('dependencia') ?>").select2();

$("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").width(220);
$("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").select2();

$("#<?php echo $this->campoSeguro('tipologia_especifica') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipologia_especifica') ?>").select2();

$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").width(220);
$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();

$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").width(220);
$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").select2();

$("#<?php echo $this->campoSeguro('modalidad_seleccion') ?>").width(220);
$("#<?php echo $this->campoSeguro('modalidad_seleccion') ?>").select2();

$("#<?php echo $this->campoSeguro('procedimiento') ?>").width(220);
$("#<?php echo $this->campoSeguro('procedimiento') ?>").select2();

$("#<?php echo $this->campoSeguro('regimen_contratación') ?>").width(220);
$("#<?php echo $this->campoSeguro('regimen_contratación') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_moneda') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_moneda') ?>").select2();

$("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").width(220);
$("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").select2();


$("#<?php echo $this->campoSeguro('tipo_gasto') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_gasto') ?>").select2();


$("#<?php echo $this->campoSeguro('origen_recursos') ?>").width(220);
$("#<?php echo $this->campoSeguro('origen_recursos') ?>").select2();


$("#<?php echo $this->campoSeguro('origen_presupuesto') ?>").width(220);
$("#<?php echo $this->campoSeguro('origen_presupuesto') ?>").select2();

$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").width(220);
$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").width(305);
$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_control') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2();



$('#<?php echo $this->campoSeguro('nombre_supervisor') ?>').width(300);			       

$("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});

$("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").width(300);
$("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});


$('#<?php echo $this->campoSeguro('cargo_supervisor') ?>').width(500);
$("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").select2();


$('#<?php echo $this->campoSeguro('tipo_control') ?>').width(300);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2();



$('#<?php echo $this->campoSeguro('sede_super') ?>').width(300);
$("#<?php echo $this->campoSeguro('sede_super') ?>").select2();

$('#<?php echo $this->campoSeguro('sede') ?>').width(300);
$("#<?php echo $this->campoSeguro('sede') ?>").select2();

$("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").width(220);
$("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2();

$("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").width(220);
$("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();


$("#<?php echo $this->campoSeguro('supervisor') ?>").width(220);
$("#<?php echo $this->campoSeguro('supervisor') ?>").select2();


//Uniones Temporales

$("#<?php echo $this->campoSeguro('tipoCuenta') ?>").width(200);  
$("#<?php echo $this->campoSeguro('tipoCuenta') ?>").select2();                 
$("#<?php echo $this->campoSeguro('entidadBancaria') ?>").width(200);  
$("#<?php echo $this->campoSeguro('entidadBancaria') ?>").select2();      
$("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").width(200);  
$("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").select2();                 
$("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").width(200);  
$("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").select2();     

//Lugar de Ejecucion

$("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").select2();
$("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").width(200);  
$("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").select2();
$("#<?php echo $this->campoSeguro('ejecucionPais') ?>").width(200);  
$("#<?php echo $this->campoSeguro('ejecucionPais') ?>").select2();
$("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").width(200);  
$("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").select2();
$("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").width(200);  
$("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").select2();






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


$('#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: $('#<?php echo $this->campoSeguro('fecha_inicio_validacion') ?>').val(),
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
onSelect: function(dateText, inst) {
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final_acta') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final_acta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_final_acta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}


});
$('#<?php echo $this->campoSeguro('fecha_final_acta') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_acta') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_inicio_sub') ?>').datepicker('option', 'maxDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_final_acta') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}

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




