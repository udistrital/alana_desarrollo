<?php
$indice=0;



$estilo[$indice++]="validationEngine.jquery.css";
$estilo[$indice++]="jquery.auto-complete.css";
$estilo[$indice++]="select2.css";
$estilo[$indice++]="EstiloBloque.css";
$estilo[$indice++]="jquery-ui.css";
$estilo[$indice++]="jquery.dataTables.css";
$estilo[$indice++]="demo_table.css";
$estilo[$indice++]="jquery.dataTables_themeroller.css";
$estilo[$indice++]="jquery.dataTables.css";
$estilo[$indice++]="jquery.steps.css";
$estilo[$indice++]="modal.css";
$estilo[$indice++]="estiloFechasPolizas.css";
// Bootstrap
$estilo[$indice++] = "bootstrap-theme.css";
$estilo[$indice++] = "bootstrap-theme.min.css";
$estilo[$indice++] = "jquery.dataTables.css";
$estilo[$indice++] = "bootstrap.css";
$estilo[$indice++] = "bootstrap.min.css";





$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}

foreach ($estilo as $nombre){
	echo "<link rel='stylesheet' type='text/css' href='".$rutaBloque."/css/".$nombre."'>\n";
}
?>
