window.onload = detectarCarga;

function detectarCarga() {
    $('#marcoDatos').show('slow');
}

<?php
$_REQUEST ['tiempo'] = time();
?>


// Asociar el widget de validación al formulario
$("#modificarContrato").validationEngine({
promptPosition : "centerRight", 
validateNonVisibleFields: false,
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});


$(function() {
$("#modificarContrato").submit(function() {
$resultado=$("#modificarContrato").validationEngine("validate");
if ($resultado) {

return true;
}
else{

return false;

}
});
});



$("#ventanaEmergenteContratista" ).dialog({
height: 700,
width: 900,
title: "Datos Convenio",
autoOpen: false,
});

$('#tablaRegistros').DataTable();
$('#tablaDisponibilidades').DataTable();

$('.datepicker').datepicker();
$('.fechaJquery').datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
});


$("#<?php echo $this->campoSeguro('clase_contratista') ?>").select2();


$("#<?php echo $this->campoSeguro('clase_contratista') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('clase_contratista') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('clase_contratista') ?>").val()==33){


$("#<?php echo $this->campoSeguro('divisionClaseContratista') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionSociedadTemporal') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('selec_sociedad') ?>").val('');
$("#<?php echo $this->campoSeguro('id_proveedor') ?>").val('');
$('.infosociedadparticipantesspan').html('');
$('.infoproveedorspan').html('');
$('.infosociedadspan').html('');




}else if ($("#<?php echo $this->campoSeguro('clase_contratista') ?>").val() == 31 || $("#<?php echo $this->campoSeguro('clase_contratista') ?>").val() == 32) {
$("#<?php echo $this->campoSeguro('divisionClaseContratista') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSociedadTemporal') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val('');
$("#<?php echo $this->campoSeguro('id_proveedor') ?>").val('');
$('.infoproveedorspan').html('');


}                                                
else{		                    

$("#<?php echo $this->campoSeguro('divisionClaseContratista') ?>").css('display','none');

}

}else{

$("#<?php echo $this->campoSeguro('divisionClaseContratista') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSociedadTemporal') ?>").css('display','none');




}

});


$("#<?php echo $this->campoSeguro('perfil') ?>").change(function() {


if($("#<?php echo $this->campoSeguro('perfil') ?>").val()!=''){

$("#<?php echo $this->campoSeguro('profesion') ?>").val('');
$("#<?php echo $this->campoSeguro('especialidad') ?>").val('');

switch($("#<?php echo $this->campoSeguro('perfil') ?>").val())
{

case '221':

$("#<?php echo $this->campoSeguro('profesion') ?>").prop("readonly",true);


$("#<?php echo $this->campoSeguro('profesion') ?>").removeClass( " validate[required] " );

break;

case '225':


$("#<?php echo $this->campoSeguro('profesion') ?>").prop("readonly",true);

$("#<?php echo $this->campoSeguro('profesion') ?>").removeClass( " validate[required] " );                    

break;

case '223':


$("#<?php echo $this->campoSeguro('profesion') ?>").prop("readonly",false);

$("#<?php echo $this->campoSeguro('profesion') ?>").addClass( " validate[required] " );


$("#<?php echo $this->campoSeguro('especialidad') ?>").prop("readonly",false);


$("#<?php echo $this->campoSeguro('especialidad') ?>").addClass( " validate[required] " );

break;

default:


$("#<?php echo $this->campoSeguro('profesion') ?>").prop("readonly",false);

$("#<?php echo $this->campoSeguro('profesion') ?>").addClass( " validate[required] " );




$("#<?php echo $this->campoSeguro('especialidad') ?>").prop("readonly",true);

$("#<?php echo $this->campoSeguro('especialidad') ?>").removeClass( " validate[required] " );

break;


}
}else{

$("#<?php echo $this->campoSeguro('profesion') ?>").prop("readonly",true);
$("#<?php echo $this->campoSeguro('especialidad') ?>").prop("readonly",true);

$("#<?php echo $this->campoSeguro('profesion') ?>").removeClass( " validate[required] " );
$("#<?php echo $this->campoSeguro('especialidad') ?>").removeClass( " validate[required] " );



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




$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").val()!=''){


if($("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").val()== 3){



$("#<?php echo $this->campoSeguro('divisionConvenio') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('numero_convenio') ?>").addClass( " validate[required] " );


}else{


$("#<?php echo $this->campoSeguro('divisionConvenio') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('numero_convenio') ?>").val("");
$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").val("");
$("#<?php echo $this->campoSeguro('numero_convenio') ?>").removeClass( " validate[required] " );




}

}else{

$("#<?php echo $this->campoSeguro('divisionConvenio') ?>").css('display','none');



}

});




$("#<?php echo $this->campoSeguro('tipo_contrato') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('tipo_contrato') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('tipo_contrato') ?>").val()==6){

$("#<?php echo $this->campoSeguro('divisionPerfil') ?>").css('display','block');

}else{


$("#<?php echo $this->campoSeguro('divisionPerfil') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('perfil') ?>").val(null);
$("#<?php echo $this->campoSeguro('perfil') ?>").width(220);
$("#<?php echo $this->campoSeguro('perfil') ?>").select2();

}

}else{

$("#<?php echo $this->campoSeguro('divisionPerfil') ?>").css('display','none');



}

});



$("#<?php echo $this->campoSeguro('tipo_moneda') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('tipo_moneda') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('tipo_moneda') ?>").val()!=137){

$("#<?php echo $this->campoSeguro('divisionMonedaExtranjera') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").addClass( " validate[required] " );
$("#<?php echo $this->campoSeguro('tasa_cambio') ?>").addClass( " validate[required] " );

}else{


$("#<?php echo $this->campoSeguro('divisionMonedaExtranjera') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").val("");
$("#<?php echo $this->campoSeguro('tasa_cambio') ?>").val("");
}

}else{

$("#<?php echo $this->campoSeguro('divisionMonedaExtranjera') ?>").css('display','none');

$("#<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").removeClass( " validate[required] " );
$("#<?php echo $this->campoSeguro('tasa_cambio') ?>").removeClass( " validate[required] " );

}

});




//$("#<?php echo $this->campoSeguro('tipo_persona') ?>").change(function() {
//
//               
//
//			if($("#<?php echo $this->campoSeguro('tipo_persona') ?>").val()!=''){
//
//				if($("#<?php echo $this->campoSeguro('tipo_persona') ?>").val()!= 1){
//                                        
//                                      
//					$("#divisionPersonaJuridica").css('display','block');
//					$("#divisionPersonaNatural").css('display','none');
//                                      $("#<?php echo $this->campoSeguro('primer_nombre') ?>").val("");
//                                        $("#<?php echo $this->campoSeguro('segundo_nombre') ?>").val("");
//                                        $("#<?php echo $this->campoSeguro('primer_apellido') ?>").val("");
//                                        $("#<?php echo $this->campoSeguro('segundo_apellido') ?>").val("");
//                                       							
//                    }else{
//                    
//                                       $("#divisionPersonaJuridica").css('display','none');
//                                       $("#divisionPersonaNatural").css('display','block');
//                                       $("#<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").val("");
//                    }
//
//		}else{
//		
//		$("#divisionPersonaJuridica").css('display','none');
//                $("#divisionPersonaNatural").css('display','block');
//		
//		
//		
//		}
//
// });



$("#<?php echo $this->campoSeguro('vigencia') ?>").change(function() {

if($("#<?php echo $this->campoSeguro('vigencia') ?>").val()!=''){

NumeroSolicitud();	

}else{}

});

$('#<?php echo $this->campoSeguro('fecha_suscrip_super') ?>').datepicker({
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




$('#<?php echo $this->campoSeguro('fecha_limite') ?>').datepicker({
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

$('#<?php echo $this->campoSeguro('fecha_suscripcion') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
minDate: $('#<?php echo $this->campoSeguro('fecha_registro_validacion') ?>').val(),
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
});




$('#<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final_poliza') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final_poliza') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_final_poliza') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}


});
$('#<?php echo $this->campoSeguro('fecha_final_poliza') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_poliza') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>').datepicker('option', 'maxDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_final_poliza') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}
}

});



$("#<?php echo $this->campoSeguro('clase_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2();

$("#<?php echo $this->campoSeguro('formaPago') ?>").width(150);
$("#<?php echo $this->campoSeguro('formaPago') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_contrato') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_contrato') ?>").select2();

$("#<?php echo $this->campoSeguro('perfil') ?>").width(220);
$("#<?php echo $this->campoSeguro('perfil') ?>").select2();


$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").select2();
$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").select2();
$("#<?php echo $this->campoSeguro('dependencia') ?>").width(220);
$("#<?php echo $this->campoSeguro('dependencia') ?>").select2();

$("#<?php echo $this->campoSeguro('tipologia_especifica') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipologia_especifica') ?>").select2();

$("#<?php echo $this->campoSeguro('modalidad_seleccion') ?>").width(220);
$("#<?php echo $this->campoSeguro('modalidad_seleccion') ?>").select2();

$("#<?php echo $this->campoSeguro('procedimiento') ?>").width(220);
$("#<?php echo $this->campoSeguro('procedimiento') ?>").select2();

$("#<?php echo $this->campoSeguro('regimen_contratación') ?>").width(220);
$("#<?php echo $this->campoSeguro('regimen_contratación') ?>").select2();

$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").width(220);
$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_moneda') ?>").width(250);
$("#<?php echo $this->campoSeguro('tipo_moneda') ?>").select2();

$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").width(250);
$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").select2();

$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").width(250);
$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();

$("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").width(500);
$("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").select2();


$("#<?php echo $this->campoSeguro('tipo_gasto') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_gasto') ?>").select2();

$("#<?php echo $this->campoSeguro('origen_recursos') ?>").width(220);
$("#<?php echo $this->campoSeguro('origen_recursos') ?>").select2();

$("#<?php echo $this->campoSeguro('origen_presupuesto') ?>").select2();

$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").width(220);
$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").select2();

$("#<?php echo $this->campoSeguro('unidad_ejecutora_consulta') ?>").width(220);
$("#<?php echo $this->campoSeguro('unidad_ejecutora_consulta') ?>").select2();

$("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").width(220);
$("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2();

$("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").width(220);
$("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();


$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").width(220);
$("#<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").select2();

$("#<?php echo $this->campoSeguro('supervisor') ?>").width(335);
$("#<?php echo $this->campoSeguro('supervisor') ?>").select2();




$("#<?php echo $this->campoSeguro('supervisor') ?>").width(305);
$("#<?php echo $this->campoSeguro('supervisor') ?>").select2();

$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").width(305);
$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").select2();

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


$('#<?php echo $this->campoSeguro('cargo_supervisor') ?>').width(300);
$("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").select2();


$('#<?php echo $this->campoSeguro('tipo_control') ?>').width(300);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2();


$('#<?php echo $this->campoSeguro('sede_super') ?>').width(300);
$("#<?php echo $this->campoSeguro('sede_super') ?>").select2();

$('#<?php echo $this->campoSeguro('sede') ?>').width(300);
$("#<?php echo $this->campoSeguro('sede') ?>").select2();


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

//Servicios 


$('#<?php echo $this->campoSeguro('tipo_servicio') ?>').width(400);
$("#<?php echo $this->campoSeguro('tipo_servicio') ?>").select2();

$('#<?php echo $this->campoSeguro('codigo_ciiu') ?>').width(400);
$("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").select2();

//Multiples CDP 


$("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").width(200);
$("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").select2();
$("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").width(200);
$("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").select2();

//Elementos Contrato


$("#<?php echo $this->campoSeguro('nivel') ?>").select2();
$("#<?php echo $this->campoSeguro('iva') ?>").select2();
$('#<?php echo $this->campoSeguro('funcionario') ?>').width(350);
$("#<?php echo $this->campoSeguro('funcionario') ?>").select2();   


$( "#<?php echo $this->campoSeguro('cantidad') ?>" ).keyup(function() {

$("#<?php echo $this->campoSeguro('valor') ?>").val('');
$("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

});  

$( "#<?php echo $this->campoSeguro('valor') ?>" ).keyup(function() {
$("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
$("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

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

case '7':

cantidad=Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
valor=Number($("#<?php echo $this->campoSeguro('valor') ?>").val());
iva = Math.round(((cantidad * valor)* 0.19)*100)/100;
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



//Fin Elementos Contrato----------------------------------------------------------------


setTimeout(function() {
$('#mensajeEdicionPrevio').hide( "drop", { direction: "up" }, "slow" );
}, 8000);


$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").val()!=''){

$("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val('');
if($("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").val()==1){

$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").val(null);
$("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").select2();

}else{


$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val(null);
$("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").select2();
}

}else{

$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor') ?>").css('display','none');



}

});

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










