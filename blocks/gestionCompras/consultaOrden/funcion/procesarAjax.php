<?php

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$conexionSICA = "sicapital";
$DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);
$conexionAgora = "agora";
$esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);
$conexionCore = "core";
$esteRecursoDBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);
$conexionFrameWork = "estructura";
$DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
$conexion = "inventarios";
$esteRecursoDBArka = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

class EnLetras {

    var $Void = "";
    var $SP = " ";
    var $Dot = ".";
    var $Zero = "0";
    var $Neg = "Menos";

    function ValorEnLetras($x, $Moneda) {
        $s = "";
        $Ent = "";
        $Frc = "";
        $Signo = "";

        if (floatVal($x) < 0)
            $Signo = $this->Neg . " ";
        else
            $Signo = "";

        if (intval(number_format($x, 2, '.', '')) != $x) // <- averiguar si tiene decimales
            $s = number_format($x, 2, '.', '');
        else
            $s = number_format($x, 0, '.', '');

        $Pto = strpos($s, $this->Dot);

        if ($Pto === false) {
            $Ent = $s;
            $Frc = $this->Void;
        } else {
            $Ent = substr($s, 0, $Pto);
            $Frc = substr($s, $Pto + 1);
        }

        if ($Ent == $this->Zero || $Ent == $this->Void)
            $s = "Cero ";
        elseif (strlen($Ent) > 7) {
            $s = $this->SubValLetra(intval(substr($Ent, 0, strlen($Ent) - 6))) . "Millones " . $this->SubValLetra(intval(substr($Ent, - 6, 6)));
        } else {
            $s = $this->SubValLetra(intval($Ent));
        }

        if (substr($s, - 9, 9) == "Millones " || substr($s, - 7, 7) == "Millón ")
            $s = $s . "de ";

        $s = $s . $Moneda;

        if ($Frc != $this->Void) {
            $s = $s . " Con " . $this->SubValLetra(intval($Frc)) . "Centavos";
            // $s = $s . " " . $Frc . "/100";
        }
        return ($Signo . $s . "");
    }

    function SubValLetra($numero) {
        $Ptr = "";
        $n = 0;
        $i = 0;
        $x = "";
        $Rtn = "";
        $Tem = "";

        $x = trim("$numero");
        $n = strlen($x);

        $Tem = $this->Void;
        $i = $n;

        while ($i > 0) {
            $Tem = $this->Parte(intval(substr($x, $n - $i, 1) . str_repeat($this->Zero, $i - 1)));
            If ($Tem != "Cero")
                $Rtn .= $Tem . $this->SP;
            $i = $i - 1;
        }

        // --------------------- GoSub FiltroMil ------------------------------
        $Rtn = str_replace(" Mil Mil", " Un Mil", $Rtn);
        while (1) {
            $Ptr = strpos($Rtn, "Mil ");
            If (!($Ptr === false)) {
                If (!(strpos($Rtn, "Mil ", $Ptr + 1) === false))
                    $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr);
                else
                    break;
            } else
                break;
        }

        // --------------------- GoSub FiltroCiento ------------------------------
        $Ptr = - 1;
        do {
            $Ptr = strpos($Rtn, "Cien ", $Ptr + 1);
            if (!($Ptr === false)) {
                $Tem = substr($Rtn, $Ptr + 5, 1);
                if ($Tem == "M" || $Tem == $this->Void)
                    ;
                else
                    $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr);
            }
        } while (!($Ptr === false));

        // --------------------- FiltroEspeciales ------------------------------
        $Rtn = str_replace("Diez Un", "Once", $Rtn);
        $Rtn = str_replace("Diez Dos", "Doce", $Rtn);
        $Rtn = str_replace("Diez Tres", "Trece", $Rtn);
        $Rtn = str_replace("Diez Cuatro", "Catorce", $Rtn);
        $Rtn = str_replace("Diez Cinco", "Quince", $Rtn);
        $Rtn = str_replace("Diez Seis", "Dieciseis", $Rtn);
        $Rtn = str_replace("Diez Siete", "Diecisiete", $Rtn);
        $Rtn = str_replace("Diez Ocho", "Dieciocho", $Rtn);
        $Rtn = str_replace("Diez Nueve", "Diecinueve", $Rtn);
        $Rtn = str_replace("Veinte Un", "Veintiun", $Rtn);
        $Rtn = str_replace("Veinte Dos", "Veintidos", $Rtn);
        $Rtn = str_replace("Veinte Tres", "Veintitres", $Rtn);
        $Rtn = str_replace("Veinte Cuatro", "Veinticuatro", $Rtn);
        $Rtn = str_replace("Veinte Cinco", "Veinticinco", $Rtn);
        $Rtn = str_replace("Veinte Seis", "Veintiseís", $Rtn);
        $Rtn = str_replace("Veinte Siete", "Veintisiete", $Rtn);
        $Rtn = str_replace("Veinte Ocho", "Veintiocho", $Rtn);
        $Rtn = str_replace("Veinte Nueve", "Veintinueve", $Rtn);

        // --------------------- FiltroUn ------------------------------
        If (substr($Rtn, 0, 1) == "M")
            $Rtn = "Un " . $Rtn;
        // --------------------- Adicionar Y ------------------------------
        for ($i = 65; $i <= 88; $i ++) {
            If ($i != 77)
                $Rtn = str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
        }
        $Rtn = str_replace("*", "a", $Rtn);
        return ($Rtn);
    }

    function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) {
        $x = substr($x, 0, $Ptr) . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
    }

    function Parte($x) {
        $Rtn = '';
        $t = '';
        $i = '';
        Do {
            switch ($x) {
                Case 0 :
                    $t = "Cero";
                    break;
                Case 1 :
                    $t = "Un";
                    break;
                Case 2 :
                    $t = "Dos";
                    break;
                Case 3 :
                    $t = "Tres";
                    break;
                Case 4 :
                    $t = "Cuatro";
                    break;
                Case 5 :
                    $t = "Cinco";
                    break;
                Case 6 :
                    $t = "Seis";
                    break;
                Case 7 :
                    $t = "Siete";
                    break;
                Case 8 :
                    $t = "Ocho";
                    break;
                Case 9 :
                    $t = "Nueve";
                    break;
                Case 10 :
                    $t = "Diez";
                    break;
                Case 20 :
                    $t = "Veinte";
                    break;
                Case 30 :
                    $t = "Treinta";
                    break;
                Case 40 :
                    $t = "Cuarenta";
                    break;
                Case 50 :
                    $t = "Cincuenta";
                    break;
                Case 60 :
                    $t = "Sesenta";
                    break;
                Case 70 :
                    $t = "Setenta";
                    break;
                Case 80 :
                    $t = "Ochenta";
                    break;
                Case 90 :
                    $t = "Noventa";
                    break;
                Case 100 :
                    $t = "Cien";
                    break;
                Case 200 :
                    $t = "Doscientos";
                    break;
                Case 300 :
                    $t = "Trescientos";
                    break;
                Case 400 :
                    $t = "Cuatrocientos";
                    break;
                Case 500 :
                    $t = "Quinientos";
                    break;
                Case 600 :
                    $t = "Seiscientos";
                    break;
                Case 700 :
                    $t = "Setecientos";
                    break;
                Case 800 :
                    $t = "Ochocientos";
                    break;
                Case 900 :
                    $t = "Novecientos";
                    break;
                Case 1000 :
                    $t = "Mil";
                    break;
                Case 1000000 :
                    $t = "Millón";
                    break;
            }

            If ($t == $this->Void) {
                $i = $i + 1;
                $x = $x / 1000;
                If ($x == 0)
                    $i = 0;
            } else
                break;
        } while ($i != 0);

        $Rtn = $t;
        Switch ($i) {
            Case 0 :
                $t = $this->Void;
                break;
            Case 1 :
                $t = " Mil";
                break;
            Case 2 :
                $t = " Millones";
                break;
            Case 3 :
                $t = " Billones";
                break;
        }
        return ($Rtn . $t);
    }

}

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

if ($_REQUEST ['funcion'] == 'letrasNumeros') {

    $funcionLetras = new EnLetras ();

    $Letras = $funcionLetras->ValorEnLetras($_REQUEST ['valor'], '( $Pesos ).');

    $Letras = json_encode($Letras);

    echo $Letras;
}
if ($_REQUEST ['funcion'] == 'consultarCiudadAjax') {
    $cadenaSql = $this->sql->getCadenaSql('buscarCiudadAjax', $_REQUEST['valor']);
    $resultado = $esteRecursoDBCore->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarDepartamentoAjax') {
    $cadenaSql = $this->sql->getCadenaSql('buscarDepartamentoAjax', $_REQUEST['valor']);
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

if ($_REQUEST ['funcion'] == 'SeleccionOrdenador') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_ordenador', $_REQUEST ['ordenador']);

    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'SeleccionCargo') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_cargo_jefe', $_REQUEST ['cargo']);

    $resultadoItems = $esteRecursoDBO->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarConvenio') {

    $conexion = "contractual";
    $esteRecursoDBO = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $cadenaSql = $this->sql->getCadenaSql('buscar_nombre_convenio', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBO->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado[0]);
    echo $resultado;
}if ($_REQUEST ['funcion'] == 'ObtenerParticipante') {

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

if ($_REQUEST ['funcion'] == 'disponibilidades') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_disponibilidad', array(
        $_REQUEST ['vigencia'],
        $_REQUEST ['unidad']
    ));

    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarConveniosxvigencia') {

    $cadenaSql = $this->sql->getCadenaSql('conveniosxvigencia', $_REQUEST ['valor']);

    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

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

if ($_REQUEST ['funcion'] == 'Infodisponibilidades') {

    $arreglo = array(
        $_REQUEST ['disponibilidad'],
        $_REQUEST ['vigencia']
    );

    $cadenaSql = $this->sql->getCadenaSql('info_disponibilidad', $arreglo);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarInfoConvenio') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_convenio', $_REQUEST['codigo']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'registroPresupuestal') {

    $arreglo = array(
        $_REQUEST ['vigencia'],
        $_REQUEST ['disponibilidad'],
        $_REQUEST ['unidad']
    );

    $cadenaSql = $this->sql->getCadenaSql('buscar_registro', $arreglo);

    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'Inforegistro') {

    $arreglo = array(
        $_REQUEST ['registro'],
        $_REQUEST ['vigencia']
    );

    $cadenaSql = $this->sql->getCadenaSql('info_registro', $arreglo);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarContratistas') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_contratista', $_REQUEST ['vigencia']);
    $resultadoItems = $esteRecursoDBO->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'SeleccionProveedor') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_proveedor', $_REQUEST ['proveedor']);

    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarCargoSuper') {

    $cadenaSql = $this->sql->getCadenaSql('obtenerCargoSuper', explode("-", $_REQUEST ['valor'])[0]);

    $resultado = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultado [0]);


    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarServicios') {

    $cadenaSql = $this->sql->getCadenaSql('serviciosPorClase', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBCore->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);

    echo $resultado;
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
//------------------------obtener Dependencias de acuerdo al identificador de la sede -------------------------
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

if ($_REQUEST ['funcion'] == 'SeleccionTipoBien') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultaTipoBien', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDBArka->ejecutarAcceso($cadenaSql, "busqueda");
    $resultadoItems = $resultadoItems [0];

    echo json_encode($resultadoItems);
}

if ($_REQUEST ['funcion'] == 'consultarIva') {

    $cadenaSql = $this->sql->getCadenaSql('consultar_tipo_iva');

    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultado);

    echo $resultado;
}if ($_REQUEST ['funcion'] == 'generarDocumento') {


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
