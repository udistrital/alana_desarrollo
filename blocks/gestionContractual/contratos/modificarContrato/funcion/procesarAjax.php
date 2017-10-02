<?php

use contratos\modificarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$conexionFrameWork = "estructura";
$DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
$conexionAgora = "agora";
$esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);
$conexionSICA = "sicapital";
$DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);
$conexionCore = "core";
$esteRecursoDBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

if ($_REQUEST ['funcion'] == 'obtenerGeneros') {

    $cadenaSql = $this->sql->getCadenaSql('tipo_genero_ajax', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
}

if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);
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

if ($_REQUEST ['funcion'] == 'consultarConveniosxvigencia') {

    $cadenaSql = $this->sql->getCadenaSql('conveniosxvigencia', $_REQUEST ['valor']);

    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

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
if ($_REQUEST ['funcion'] == 'ObtenerRepresentanteSuplente') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_representante_suplente', $_GET ['query']);
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
if ($_REQUEST ['funcion'] == 'consultarCargoSuper') {

    $parametro = explode("-", $_REQUEST['valor']);
    $cadenaSql = $this->sql->getCadenaSql('cargoSuper', $parametro[0]);
    $resultado = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado [0]);

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
if ($_REQUEST ['funcion'] == 'consultarInfoConvenio') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_convenio', $_REQUEST['codigo']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarInfoContratistaUnico') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_contratista_unico', $_REQUEST['id']);
    $resultadoItems = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'SeleccionOrdenador') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_ordenador', $_REQUEST ['ordenador']);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
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
if ($_REQUEST ['funcion'] == 'ObtenerParticipante') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_participante', $_GET ['query']);

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
if ($_REQUEST ['funcion'] == 'consultaInformacionProveedor') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_Informacion_proveedor', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarServicios') {

    $cadenaSql = $this->sql->getCadenaSql('serviciosPorClase', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBCore->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'generarDocumento') {


    $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
    $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');
    $directorio = $this->miConfigurador->getVariableConfiguracion("host");
    $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
    $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

    $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
    $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
    $rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

    $numeroContrato = substr($_REQUEST ['numerocontrato'], 4);
    $vigencia = substr($_REQUEST ['numerocontrato'], 0, 4);

    $datosContraro = array(1 => $numeroContrato, 2 => $vigencia);
    $cadenaSql = $this->sql->getCadenaSql('consultarContratoProcesarAjax', $datosContraro);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $variable_documento = "action=" . $esteBloque ["nombre"];
    $variable_documento .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
    $variable_documento .= "&bloque=" . $esteBloque ['nombre'];
    $variable_documento .= "&bloqueGrupo=" . $esteBloque ["grupo"];
    $variable_documento .= "&opcion=generarDocumento";
    $variable_documento .= "&numero_contrato=" . $numeroContrato;
    $variable_documento .= "&tipo_contrato=" . $resultado[0] ['tipo_contrato'];
    $variable_documento .= "&unidad=" . $resultado[0]['unidad_ejecutora'];
    $variable_documento .= "&tamanoletra=" . $_REQUEST['fuentedocumento'];
    $variable_documento .= "&vigencia=" . $vigencia;

    $variable_documento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_documento, $directorio);
    $indice = strpos($variable_documento, "index");
    $variable_documento = substr($variable_documento, $indice);
    $resultado = json_encode($variable_documento);

    echo $resultado;
}
?>