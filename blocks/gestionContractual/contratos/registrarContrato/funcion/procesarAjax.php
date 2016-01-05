<?php
use contratos\registrarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {
	
	$cadenaSql = $this->sql->getCadenaSql ( 'ConsultarNumeroNecesidades', $_REQUEST ['valor'] );
	
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
// 	var_dump($resultadoItems);exit;
// 	$resultadoItems = $resultadoItems [0];
	
	echo json_encode ( $resultadoItems );
}

?>