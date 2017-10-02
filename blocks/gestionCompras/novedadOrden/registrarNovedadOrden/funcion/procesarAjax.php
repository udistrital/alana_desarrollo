<?php

use contratos\modificarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$conexionSICA = "sicapital";
$DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);
$conexionAgora = "agora";
$esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);
$conexionFrameWork = "estructura";
$DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);


//-----Consulta Contratos ---------------------------------

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
//---------------------------------------------------------
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


if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    echo json_encode($resultadoItems);
}




if ($_REQUEST ['funcion'] == 'consultarInfoRP') {

    $datosRp = array(0 => $_REQUEST ['valor'], 1 => $_REQUEST ['vigencia'], 2 => $_REQUEST ['unidad']);
    $cadenaSql = $this->sql->getCadenaSql('informacion_RP', $datosRp);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}



if ($_REQUEST ['funcion'] == 'ObtenerCdps') {

    $datos = array(1 => $_REQUEST ['numsol'], 0 => $_REQUEST ['vigencia'], 2 => $_REQUEST ['unidad'], 3 => $_REQUEST ['cdps'],
        4 => $_REQUEST ['cdpsNovedades']);
    $cadenaSql = $this->sql->getCadenaSql('obtener_cdp_numerosol', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}



if ($_REQUEST ['funcion'] == 'consultarTerceroCesion') {

    $cadenaSql = $this->sql->getCadenaSql('buscarTerceroCesion', $_GET ['query']);
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

if ($_REQUEST ['funcion'] == 'consultarInfoConvenio') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_convenio', $_REQUEST['codigo']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'validarSupervisor') {

    $cadenaSql = $this->sql->getCadenaSql('validarSupervisor', explode("-", $_REQUEST['id'])[0]);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    if ($resultadoItems != false) {
        $resultadoItems = "true";
    } else {
        $resultadoItems = "false";
    }
    $resultado = json_encode($resultadoItems);

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




if ($_REQUEST ['funcion'] == 'consultarDependencia') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarCargoSuper') {



    $cadenaSql = $this->sql->getCadenaSql('cargoSuper', explode("-", $_REQUEST ['valor'])[0]);
    $resultado = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'ObtenerSolicitudesCdp') {

    $datos = array(0 => $_REQUEST ['vigencia'], 1 => $_REQUEST ['unidad']);
    $cadenaSql = $this->sql->getCadenaSql('obtener_solicitudes_vigencia', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarInfoRPxCdp') {

    $arreglo = array(
        $_REQUEST ['numerocdp'],
        $_REQUEST ['vigencia'],
        $_REQUEST ['unidad']
    );

    $cadenaSql = $this->sql->getCadenaSql('Consultar_RpsxCdp', $arreglo);
    $resultado = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarinformacionRpadicion') {

    $arreglo = array(
        $_REQUEST ['registroPresupuestal'],
        $_REQUEST ['vigencia'],
        $_REQUEST ['unidad']
    );

    $cadenaSql = $this->sql->getCadenaSql('Consultar_Info_Registro', $arreglo);
    $resultado = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultaProveedor') {

    $parametro = $_REQUEST ['proveedor'];
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $url = "http://10.20.2.38/agora/index.php?";
    $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&parametro1=$parametro";
    $url_servicio = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($data, $enlace);
    $cliente = curl_init();
    curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cliente, CURLOPT_URL, $url_servicio);
    $repuestaWeb = curl_exec($cliente);
    curl_close($cliente);
    $repuestaWeb = explode("<json>", $repuestaWeb);
    echo $repuestaWeb[1];
}
?>