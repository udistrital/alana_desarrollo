<?php

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$conexionAgora = "agora";
$esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);
$conexionCore = "core";
$esteRecursoDBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);
$conexionFrameWork = "estructura";
$DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);

if ($_REQUEST ['funcion'] == 'consultarDependencias') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultaContratista') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_contratista', $_GET ['query']);
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
if ($_REQUEST ['funcion'] == 'consultaContrato') {

    $id_usuario = $_REQUEST['usuario'];
    $cadenaSqlUnidad = $this->sql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
    $unidadEjecutora = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");
    $cadenaSql = $this->sql->getCadenaSql('buscar_contrato', array('parametro' => $_GET ['query'], 'unidad' => $unidadEjecutora[0]['unidad_ejecutora']
            , 'vigencia_curso' => date("Y")));
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    foreach ($resultadoItems as $key => $values) {
        $keys = array(
            'value',
            'data'
        );
        $resultado [$key] = array_intersect_key($resultadoItems [$key], array_flip($keys));
    }

    echo '{"suggestions":' . json_encode($resultado) . '}';
}

if ($_REQUEST ['funcion'] == 'consultarDependencia') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarServicios') {

    $cadenaSql = $this->sql->getCadenaSql('serviciosPorClase', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBCore->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarInfoContratistaUnico') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_contratista_unico', $_REQUEST['id']);
    $resultadoItems = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarInfoSociedadTemporal') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_sociedad_temporal_consulta', $_REQUEST['id']);
    $resultadoItems = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $sqlParticipantes = $this->sql->getCadenaSql("obtener_participantes", $_REQUEST['id']);
    $participantes = $esteRecursoDBAgora->ejecutarAcceso($sqlParticipantes, "busqueda");
    array_push($resultadoItems, $participantes);
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarInfoConvenio') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_convenio', $_REQUEST['codigo']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}



if ($_REQUEST ['funcion'] == 'consultarProveedorFiltro') {

    $cadenaSql = $this->sql->getCadenaSql('buscarProveedoresFiltro', $_GET ['query']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
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