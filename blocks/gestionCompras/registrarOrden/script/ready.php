window.onload = detectarCarga;

function detectarCarga() {
    $('#marcoDatos').show('slow');
}

$(function () {
$("#registrarOrden").submit(function () {
$resultado = $("#registrarOrden").validationEngine("validate");

if ($resultado) {

return true;
}
return false;
});
});

$('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final_pago') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  ");
}else {
$('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}

var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').datepicker('getDate'));

var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').datepicker('getDate'));


var tiempo = fechaFin.getTime() - fechaIn.getTime();

var dias = Math.floor(tiempo / (1000*60*60*24));

if($('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').val()!=''){

$('#<?php echo $this->campoSeguro('duracion') ?>').val(dias);

$('#<?php echo $this->campoSeguro('numero_dias') ?>').val(dias);

}




}



});



$('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').datepicker('option', 'maxDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_final_pago') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
}else {
$('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}


var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').datepicker('getDate'));

var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final_pago') ?>').datepicker('getDate'));


var tiempo = fechaFin.getTime() - fechaIn.getTime();

var dias = Math.floor(tiempo / (1000*60*60*24));

if($('#<?php echo $this->campoSeguro('fecha_inicio_pago') ?>').val()!=''){

$('#<?php echo $this->campoSeguro('duracion') ?>').val(dias);

$('#<?php echo $this->campoSeguro('numero_dias') ?>').val(dias);
}
}

});




$('#<?php echo $this->campoSeguro('fecha_inicial') ?>').datepicker({
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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicial') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicial') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  ");
}else {
$('#<?php echo $this->campoSeguro('fecha_final') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}

var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicial') ?>').datepicker('getDate'));

var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('getDate'));





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
var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicial') ?>').datepicker('getDate'));
$('input#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('option', 'minDate', lockDate);
},
onClose: function() { 
if ($('input#<?php echo $this->campoSeguro('fecha_inicial') ?>').val()!='')
{
$('#<?php echo $this->campoSeguro('fecha_final') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  ");
}else {
$('#<?php echo $this->campoSeguro('fecha_final') ?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
}

var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicial') ?>').datepicker('getDate'));

var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final') ?>').datepicker('getDate'));







}



});




//$('#<?php echo $this->campoSeguro('duracion') ?>').attr('disabled',''); 
$('#<?php echo $this->campoSeguro('total_iva') ?>').attr('disabled',''); 
$('#<?php echo $this->campoSeguro('total') ?>').attr('disabled','');    

$('#<?php echo $this->campoSeguro('nombreOrdenador') ?>').attr('disabled',''); 
$('#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>').attr('disabled',''); 







$("#<?php echo $this->campoSeguro('iva') ?>").change(function(){ 

switch($("#<?php echo $this->campoSeguro('iva') ?>").val())

{

case '0':

$('#<?php echo $this->campoSeguro('total_iva') ?>').val(0);

var total =$('#<?php echo $this->campoSeguro('total_preliminar') ?>').val();
var iva =$('#<?php echo $this->campoSeguro('total_iva') ?>').val();
var numero = Number(total) + Number(iva) ;

$('#<?php echo $this->campoSeguro('total') ?>').val(numero);


break;

case '1':

$('#<?php echo $this->campoSeguro('total_iva') ?>').val($('#<?php echo $this->campoSeguro('total_preliminar') ?>').val() * 0.16);

var total =$('#<?php echo $this->campoSeguro('total_preliminar') ?>').val();
var iva =$('#<?php echo $this->campoSeguro('total_iva') ?>').val();
var numero = Number(total) + Number(iva) ;

$('#<?php echo $this->campoSeguro('total') ?>').val(numero);


break;	


}

});


$("#<?php echo $this->campoSeguro('total_preliminar') ?>").keyup(function(){ 


var total =$('#<?php echo $this->campoSeguro('total_preliminar') ?>').val();
var iva =$('#<?php echo $this->campoSeguro('total_iva') ?>').val();
var numero = Number(total) + Number(iva) 

$('#<?php echo $this->campoSeguro('total') ?>').val(numero);


});




$("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").select2();
$("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2({
placeholder: "Search for a repository",
minimumInputLength: 3,

});
$('#<?php echo $this->campoSeguro('ordenador_gasto') ?>').width(300);			       
$("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").select2();

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


$("#<?php echo $this->campoSeguro('rubro') ?>").select2({
placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
minimumInputLength: 3,
});


$("#<?php echo $this->campoSeguro('clase_contratista') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('clase_contratista') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('clase_contratista') ?>").val()==33){


$("#<?php echo $this->campoSeguro('divisionClaseContratista') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionSociedadTemporal') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('selec_sociedad') ?>").val('');
$("#<?php echo $this->campoSeguro('id_proveedor') ?>").val('');
$('.infosociedadparticipantesspan').html('');
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

$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").val()!=''){
$("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val('');

if($("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").val()==1){

$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario') ?>").css('display','block');
$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor') ?>").css('display','none');

}else{


$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor') ?>").css('display','block');
}

}else{

$("#<?php echo $this->campoSeguro('divisionSupervisorFuncionario') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionSupervisorInterventor') ?>").css('display','none');



}

});

$("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").change(function() {



if($("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('tipo_compromiso') ?>").val()==3){

$("#<?php echo $this->campoSeguro('divisionConvenio') ?>").css('display','block');

}else{


$("#<?php echo $this->campoSeguro('divisionConvenio') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('numero_convenio') ?>").val("");
$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").val("");
}

}else{

$("#<?php echo $this->campoSeguro('divisionConvenio') ?>").css('display','none');



}

});


$('#<?php echo $this->campoSeguro('sede') ?>').width(300);
$("#<?php echo $this->campoSeguro('sede') ?>").select2();

$('#<?php echo $this->campoSeguro('formaPago') ?>').width(150);
$("#<?php echo $this->campoSeguro('formaPago') ?>").select2();

$('#<?php echo $this->campoSeguro('vigencia_convenio') ?>').width(150);
$("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").select2();
$('#<?php echo $this->campoSeguro('convenio_solicitante') ?>').attr('disabled',''); 
$('#<?php echo $this->campoSeguro('cargo_supervisor') ?>').width(300);
$("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").select2();


$('#<?php echo $this->campoSeguro('tipo_control') ?>').width(300);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2();

$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").width(220);
$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").select2();
$('#<?php echo $this->campoSeguro('sede_super') ?>').width(300);
$("#<?php echo $this->campoSeguro('sede_super') ?>").select2();

$("#<?php echo $this->campoSeguro('clase_contratista') ?>").select2();



$("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").select2();
$('#<?php echo $this->campoSeguro('diponibilidad') ?>').select2();

$('#<?php echo $this->campoSeguro('dependencia_solicitante') ?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2();



$('#<?php echo $this->campoSeguro('convenio_solicitante') ?>').width(200);
$("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();

$('#<?php echo $this->campoSeguro('unidad_ejecucion') ?>').width(100);
$("#<?php echo $this->campoSeguro('unidad_ejecucion') ?>").select2();

$('#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>').width(200);
$("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").select2();


$('#<?php echo $this->campoSeguro('numero_solicitud') ?>').width(200);
$("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();

$('#<?php echo $this->campoSeguro('numero_cdp') ?>').width(200);
$("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();

$('#<?php echo $this->campoSeguro('dependencia_solicitud') ?>').width(200);
$("#<?php echo $this->campoSeguro('dependencia_solicitud') ?>").select2();


$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").width(220);
$("#<?php echo $this->campoSeguro('tipo_supervisor') ?>").select2();

$('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipo_control') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_control') ?>").select2(); 

$('#<?php echo $this->campoSeguro('clase_contrato') ?>').width(350);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2(); 

$('#<?php echo $this->campoSeguro('tipo_orden') ?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_orden') ?>").select2(); 

$('#<?php echo $this->campoSeguro('poliza') ?>').width(350);
$("#<?php echo $this->campoSeguro('poliza') ?>").select2(); 

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

$("#<?php echo $this->campoSeguro('vigencia_registro') ?>").select2();
$("#<?php echo $this->campoSeguro('registro') ?>").select2();

$("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").select2();
$('#<?php echo $this->campoSeguro('nombreContratista') ?>').attr("style", "width: 60px '");

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