<?php

use contratos\registrarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$conexionSICA = "sicapital";
$DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);

$conexionAgora = "agora";
$esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

$conexionCore = "core";
$esteRecursoDBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

//---------------Obtener Numeros de Solicitud de Necesidad
if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
}

if ($_REQUEST ['funcion'] == 'obtenerGeneros') {

    $cadenaSql = $this->sql->getCadenaSql('tipo_genero_ajax', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
}
//-------------------------Obtener Solicitud y CDPs por Vigencia ----------------------------------------------------------
if ($_REQUEST ['funcion'] == 'ObtenersCdps') {

    if ($_REQUEST['cdpseleccion'] != "") {
        $seleccionados = "";
        $disponibilidades = explode(",", substr($_REQUEST['cdpseleccion'], 1));
        for ($i = 0; $i < count($disponibilidades); $i++) {
            if ($_REQUEST ['vigencia'] == explode("-", $disponibilidades[$i])[1]) {
                $seleccionados .= "," . explode("-", $disponibilidades[$i])[0];
            }
        }
        if ($seleccionados != "") {
            $seleccionados = substr($seleccionados, 1);
        } else {
            $seleccionados = 0;
        }
    } else {
        $seleccionados = 0;
    }
  
    $datos = array('unidad_ejecutora' => $_REQUEST ['unidad'], 'vigencia' => $_REQUEST ['vigencia'], 'cdps_seleccion' => $seleccionados);
    $cadenaSql = $this->sql->getCadenaSql('obtener_cdps_vigencia', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'ObtenerInfoCdps') {

    $datos = array('numero_disponibilidad' => $_REQUEST ['numero_disponibilidad'],
        'vigencia' => $_REQUEST ['vigencia'], 'unidad_ejecutora' => $_REQUEST ['unidad']);
    $cadenaSql = $this->sql->getCadenaSql('obtenerInfoCdp', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarConveniosxvigencia') {

    $cadenaSql = $this->sql->getCadenaSql('conveniosxvigencia', $_REQUEST ['valor']);

    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultado);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarConvenio') {

    $conexion = "contractual";
    $esteRecursoDBO = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $cadenaSql = $this->sql->getCadenaSql('buscar_nombre_convenio', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBO->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado[0]);
    echo $resultado;
}



if ($_REQUEST ['funcion'] == 'consultarDepartamentoAjax') {
    $cadenaSql = $this->sql->getCadenaSql('buscarDepartamentoAjax', $_REQUEST['valor']);
    $resultado = $esteRecursoDBCore->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarCiudadAjax') {
    $cadenaSql = $this->sql->getCadenaSql('buscarCiudadAjax', $_REQUEST['valor']);
    $resultado = $esteRecursoDBCore->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarDependencia') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
//-------------------------Obtener Direccion de la Sede---------------------------------
if ($_REQUEST ['funcion'] == 'consultarDireccionSede') {

    $cadenaSql = $this->sql->getCadenaSql('obtenerDireccionSede', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarCargoSuper') {

    $parametro = explode("-", $_REQUEST['valor']);
    $cadenaSql = $this->sql->getCadenaSql('cargoSuper', $parametro[0]);
    $resultado = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'SeleccionOrdenador') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_ordenador', $_REQUEST ['ordenador']);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems [0]);
    echo $resultado;
}

//-------Obtener la informacion del proveedo sociedad a partir del id
if ($_REQUEST ['funcion'] == 'consultaInformacionProveedorSociedad') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_Informacion_sociedad', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $cadenaSqlParticipantes = $this->sql->getCadenaSql('buscar_participantes_sociedad', $_REQUEST ['valor']);
    $participantes = $esteRecursoDBAgora->ejecutarAcceso($cadenaSqlParticipantes, "busqueda");
    array_push($resultado, $participantes);
    $resultado = json_encode($resultado);
    echo $resultado;
}
//-------Obtener la informacion del proveedor unico a partir del id
if ($_REQUEST ['funcion'] == 'consultaInformacionProveedor') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_Informacion_proveedor', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
//-------------------------Obtener Proveedor Unico ----------------------------------------------------------
if ($_REQUEST ['funcion'] == 'consultaProveedor') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_proveedor_contrato', $_GET ['query']);
    $resultadoItems = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    foreach ($resultadoItems as $key => $values) {
        $keys = array(
            'value',
            'data'
        );
        $resultado [$key] = array_intersect_key($resultadoItems [$key], array_flip($keys));
    }

    echo '{"suggestions":' . json_encode($resultado) . '}';
}
//-------------------------Obtener Proveedor Sociedad ----------------------------------------------------------
if ($_REQUEST ['funcion'] == 'consultaProveedorSociedad') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_sociedad_contrato', $_GET ['query']);
    $resultadoItems = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    foreach ($resultadoItems as $key => $values) {
        $keys = array(
            'value',
            'data'
        );
        $resultado [$key] = array_intersect_key($resultadoItems [$key], array_flip($keys));
    }

    echo '{"suggestions":' . json_encode($resultado) . '}';
}
?>