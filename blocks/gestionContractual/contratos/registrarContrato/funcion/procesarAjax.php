<?php

use contratos\registrarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);

    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
// 	var_dump($resultadoItems);exit;
// 	$resultadoItems = $resultadoItems [0];

    echo json_encode($resultadoItems);
}
if ($_REQUEST ['funcion'] == 'AlmacenarDatos') {

    $arregloDatos = json_decode($_REQUEST ['valor']);
    var_dump($arregloDatos);    
    for ($i = 0; $i <= count($arregloDatos); $i++) {
        $cadenaSql = "INSERT INTO contractual.temporal_contrato (campo_formulario,informacion_campo) Values('" . $arregloDatos[$i+1] . "', '" . $arregloDatos[$i] . "'); ";
        $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
    }

    echo json_encode(count($arregloDatos));
}
?>