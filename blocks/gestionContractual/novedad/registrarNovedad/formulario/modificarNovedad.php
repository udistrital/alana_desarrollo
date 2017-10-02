<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class registrarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function miForm() {

        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $atributosGlobales ['campoSeguro'] = 'true';

        $_REQUEST ['tiempo'] = time();

        // -------------------------------------------------------------------------------------------------
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);

        // Limpia Items Tabla temporal
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------

        $esteCampo = $esteBloque ['nombre'];

        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;

        /**
         * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
         * validationEngine.
         */
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo);
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos = array_merge($atributos);
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------


        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Modificación de  Novedad al Contrato Numero: " . $_REQUEST['numero_contrato'] . " | Vigencia: " . $_REQUEST['vigencia'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");
        $datosContrato = array(0 => $_REQUEST['numero_contrato'],
            1 => $_REQUEST['vigencia']);
        {


            $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contrato_Particular', $datosContrato);
            $datosContratista = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            $etiquetas = array(
                0 => 'Vigencia',
                1 => 'Número Contrato',
                2 => 'Contratista',
                3 => 'Unidad Ejecutora',
                4 => 'Supervisor',
                5 => 'Numero de Solicitud de Necesidad',
                6 => 'Numero de CDP',
                7 => 'Sede',
                8 => 'Dependencia',
                9 => 'Valor Contrato',
                10 => 'Convenio',
            );

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "modificacionNovedad";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); { {


                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                    $estiloAdicion = "display:none";
                    $estiloAnulacion = "display:none";
                    $estiloCambioSupervisor = "display:none";
                    $estiloReduccion = "display:none";
                    $estiloCesion = "display:none";
                    $estiloPresupuesto = "display:none";
                    $estiloTiempo = "display:none";

                    $_REQUEST['id_novedad'] = explode("-", $_REQUEST['info_novedad'])[0];
                    $_REQUEST['tipo_novedad'] = explode("-", $_REQUEST['info_novedad'])[1];


                    $sqlInfoNovedadGeneral = $this->miSql->getCadenaSql("consultarInfoGeneralNovedad", $_REQUEST['id_novedad']);
                    $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlInfoNovedadGeneral, "busqueda");
                    $infoNovedad = $infoNovedad[0];
                    $datos_generales_novedad = array(
                        'numero_acto' => $infoNovedad['acto_administrativo'],
                        'observaciones' => $infoNovedad['descripcion'],
                        'documentoSoporte' => $infoNovedad['documento']
                    );

                    $_REQUEST = array_merge($_REQUEST, $datos_generales_novedad);


                    $esteCampo = "AgrupacionInformación";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Datos Generales Contratista";
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {
                        if ($datosContratista) {

                            foreach ($etiquetas as $key => $values) {
                                if ($values == 'Convenio' && $datosContratista[0][$key] != '') {
                                    $datosContratista[0][$key] = $datosContratista[0][$key] . "<a href='javascript:void(0);' onclick='VerInfoConvenio(" . $datosContratista [0] [$key] . ");'> (Convenio)</a>";
                                };
                                if ($values == 'Contratista' && $datosContratista[0][$key] != '') {
                                    if ($datosContratista[0]['clase_contratista'] == '33') {
                                        $datosContratista[0][$key] = $datosContratista[0][$key] . "<a href='javascript:void(0);' onclick='VerInfoContratista(" . $datosContratista [0] [$key] . ");'> --> Ver Mas</a>";
                                    } else {
                                        $datosContratista[0][$key] = $datosContratista[0][$key] . "<a href='javascript:void(0);' onclick='VerInfoSociedadTemporal(" . $datosContratista [0] [$key] . ");'> --> Ver Mas</a>";
                                    }
                                };
                                $esteCampo = $etiquetas[$key];
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'text';
                                $atributos ['estilo'] = 'textoPequenno';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ['texto'] = $etiquetas[$key] . ": " . $datosContratista[0][$key];
                                $atributos ["etiquetaObligatorio"] = false;
                                $atributos ['columnas'] = 1;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['validar'] = '';
                                $atributos ['titulo'] = '';
                                $atributos ['deshabilitado'] = true;
                                $atributos ['tamanno'] = 10;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 10;
                                $tab ++;
                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoTexto($atributos);
                                unset($atributos);
                            }
                        } else {

                            echo "<center>No hay datos para el contratista</center>";
                        }


                        $atributos ["id"] = "ventanaEmergenteContratista";
                        $atributos ["estilo"] = " ";
                        echo $this->miFormulario->division("inicio", $atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'infoContratista';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['tipo'] = 'information';
                        $atributos ['estilo'] = 'textoNotasFormulario';
                        $atributos ['mensaje'] = "";
                        $atributos ['span'] = "spandid";

                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->cuadroMensaje($atributos);
                        unset($atributos);

                        echo $this->miFormulario->division("fin");
                    }

                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                } {

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {



                        $esteCampo = 'numero_acto';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 3;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1],maxSize[9]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = "";
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 10;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 250;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'documentoSoporte';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'file';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 3;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = '';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST[$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 250;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 160;
                        $tab ++;


                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'observaciones';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 105;
                        $atributos ['filas'] = 5;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1],maxSize[250]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 10;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);
                        unset($atributos);



                        switch ($_REQUEST['tipo_novedad']) {
                            Case 220 :
                                $estiloAdicion = "";
                                $sqlTipoAdicion = $this->miSql->getCadenaSql("consultarTipoAdcion", $_REQUEST['id_novedad']);
                                $tipoAdicion = $esteRecursoDB->ejecutarAcceso($sqlTipoAdicion, "busqueda");
                                $_REQUEST['tipo_adicion'] = $tipoAdicion[0][0];


                                $atributos ["id"] = "divisionAdicion";
                                $atributos ["estiloEnLinea"] = $estiloAdicion;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->division("inicio", $atributos);
                                unset($atributos); {
                                    if (isset($_REQUEST['tipo_adicion']) && $_REQUEST['tipo_adicion'] == 248) {
                                        $estiloPresupuesto = "";
                                        $sqlNovedad = $this->miSql->getCadenaSql("consultarAdcionPresupuesto", $_REQUEST['id_novedad']);
                                        $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                        $infoNovedad = $infoNovedad[0];
                                        $datos = array(
                                            'tipo_adicion_modificacion' => $infoNovedad['tipo_adicion'],
                                            'numero_solicitud' => $infoNovedad['numero_solicitud'],
                                            'numero_cdp' => $infoNovedad['numero_cdp'],
                                            'valor_adicion_presupuesto' => $infoNovedad['valor_presupuesto'],
                                            'vigencia_novedad' => $infoNovedad['vigencia_adicion']
                                        );
                                        $_REQUEST = array_merge($_REQUEST, $datos);


                                        $esteCampo = 'tipo_adicion';
                                        $atributos ['columnas'] = 1;
                                        $atributos ['nombre'] = $esteCampo;
                                        $atributos ['id'] = $esteCampo;
                                        $atributos ['evento'] = '';
                                        $atributos ['deshabilitado'] = false;
                                        $atributos ["etiquetaObligatorio"] = true;
                                        $atributos ['tab'] = $tab;
                                        $atributos ['tamanno'] = 1;
                                        $atributos ['estilo'] = 'jqueryui';
                                        $atributos ['validar'] = 'required';
                                        $atributos ['limitar'] = false;
                                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                        $atributos ['anchoEtiqueta'] = 213;
                                        $atributos ['anchoCaja'] = 150;
                                        $atributos ['seleccion'] = -1;
                                        if (isset($_REQUEST [$esteCampo])) {
                                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                        } else {
                                            $atributos ['seleccion'] = '';
                                        }

                                        $matrizItems = array(
                                            array(
                                                ' ',
                                                'Sin Tipo de Novedades'
                                            )
                                        );

                                        $atributos ['baseDatos'] = 'contractual';
                                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_adicion");

                                        $tab ++;
                                        $atributos = array_merge($atributos, $atributosGlobales);
                                        echo $this->miFormulario->campoCuadroLista($atributos);
                                        unset($atributos);


                                        $sqlConsultaSolicitudRegistradas = $this->miSql->getCadenaSql("cdpRegistradas", date("Y"));
                                        $resultado = $esteRecursoDB->ejecutarAcceso($sqlConsultaSolicitudRegistradas, "busqueda");

                                        if ($resultado[0][0] == null) {
                                            $resultado[0][0] = "0";
                                        }


                                        $esteCampo = 'cdpRegistradas';
                                        $atributos ['id'] = $esteCampo;
                                        $atributos ['nombre'] = $esteCampo;
                                        $atributos ['tipo'] = 'hidden';
                                        $atributos ['estilo'] = 'jqueryui';
                                        $atributos ['marco'] = true;
                                        $atributos ['columnas'] = 1;
                                        $atributos ['dobleLinea'] = false;
                                        $atributos ['tabIndex'] = $tab;
                                        $atributos ['valor'] = $resultado[0][0];
                                        $atributos ['deshabilitado'] = false;
                                        $atributos ['tamanno'] = 30;
                                        $atributos ['maximoTamanno'] = '';
                                        $tab ++;
                                        // Aplica atributos globales al control
                                        $atributos = array_merge($atributos, $atributosGlobales);
                                        echo $this->miFormulario->campoCuadroTexto($atributos);
                                        unset($atributos);

                                        $sqlConsultaSolicitudRegistradasNovedades = $this->miSql->getCadenaSql("cdpRegistradasNovedades", date("Y"));
                                        $resultadoNovedades = $esteRecursoDB->ejecutarAcceso($sqlConsultaSolicitudRegistradasNovedades, "busqueda");
                                        if ($resultadoNovedades[0][0] == null) {
                                            $resultadoNovedades[0][0] = "0";
                                        }

                                        $esteCampo = 'cdpRegistradasNovedades';
                                        $atributos ['id'] = $esteCampo;
                                        $atributos ['nombre'] = $esteCampo;
                                        $atributos ['tipo'] = 'hidden';
                                        $atributos ['estilo'] = 'jqueryui';
                                        $atributos ['marco'] = true;
                                        $atributos ['columnas'] = 1;
                                        $atributos ['dobleLinea'] = false;
                                        $atributos ['tabIndex'] = $tab;
                                        $atributos ['valor'] = $resultadoNovedades[0][0];
                                        $atributos ['deshabilitado'] = false;
                                        $atributos ['tamanno'] = 30;
                                        $atributos ['maximoTamanno'] = '';
                                        $tab ++;
                                        // Aplica atributos globales al control
                                        $atributos = array_merge($atributos, $atributosGlobales);
                                        echo $this->miFormulario->campoCuadroTexto($atributos);
                                        unset($atributos);

                                        $atributos ["id"] = "divisionAdicionPresupuesto";
                                        $atributos ["estiloEnLinea"] = $estiloPresupuesto;
                                        $atributos = array_merge($atributos, $atributosGlobales);
                                        echo $this->miFormulario->division("inicio", $atributos);
                                        unset($atributos); {

                                            $esteCampo = 'vigencia_novedad';
                                            $atributos ['columnas'] = 1;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['evento'] = '';
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['tab'] = $tab;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = '';
                                            $atributos ['validar'] = 'required';
                                            $atributos ['limitar'] = false;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['anchoEtiqueta'] = 213;
                                            $atributos ['anchoCaja'] = 150;
                                            $atributos ['seleccion'] = -1;

                                            $matrizItems = array(
                                                array(
                                                    ' ',
                                                    'Sin Tipo de Novedades'
                                                )
                                            );

                                            $atributos ['baseDatos'] = 'sicapital';
                                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencias_sica_disponibilidades", date("Y"));

                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['seleccion'] = '';
                                            }



                                            $tab ++;
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);


                                            $esteCampo = 'numero_solicitud';
                                            $atributos ['columnas'] = 2;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['seleccion'] = - 1;
                                            $atributos ['evento'] = '';
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['tab'] = $tab;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['validar'] = 'required';
                                            $atributos ['limitar'] = false;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['anchoEtiqueta'] = 213;
                                            $sqlsolicitud = $this->miSql->getCadenaSql("obtener_solicitudes_vigencia", array(0 => $_REQUEST['vigencia_novedad'],
                                                1 => $unidad[0]['unidad_ejecutora']));
                                            $matrizItems = $DBSICA->ejecutarAcceso($sqlsolicitud, "busqueda");
                                            $atributos ['matrizItems'] = $matrizItems;
                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['seleccion'] = '';
                                            }
                                            $tab ++;
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);

                                            $esteCampo = 'numero_cdp';
                                            $atributos ['columnas'] = 2;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['seleccion'] = - 1;
                                            $atributos ['evento'] = '';
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['tab'] = $tab;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['validar'] = 'required';
                                            $atributos ['limitar'] = false;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['anchoEtiqueta'] = 213;
                                            $sqlcdp = $this->miSql->getCadenaSql("obtener_cdp_numerosol_editar", array(0 => $_REQUEST['vigencia_novedad'],
                                                1 => $_REQUEST ['numero_solicitud'], 2 => $unidad[0]['unidad_ejecutora'], 3 => $resultado[0][0]));
                                            $matrizItems = $DBSICA->ejecutarAcceso($sqlcdp, "busqueda");
                                            $atributos ['matrizItems'] = $matrizItems;
                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['seleccion'] = '';
                                            };
                                            $tab ++;
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);

                                            $esteCampo = 'registro_presupuestal_adicion';
                                            $atributos ['columnas'] = 2;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['seleccion'] = 1;
                                            $atributos ['evento'] = '';
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['tab'] = $tab;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['validar'] = 'required';
                                            $atributos ['limitar'] = false;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['anchoEtiqueta'] = 213;
                                            $atributos ['cadena_sql'] = '';
                                            $sqlRP = $this->miSql->getCadenaSql("Consultar_RpsxCdp", array(0 => $_REQUEST['numero_cdp'],
                                                1 => $_REQUEST ['vigencia_novedad'], 2 => $unidad[0]['unidad_ejecutora']));
                                            $matrizItems = $DBSICA->ejecutarAcceso($sqlRP, "busqueda");
                                            $atributos ['matrizItems'] = $matrizItems;

                                            $tab ++;
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);

                                            $esteCampo = 'info_rubro';
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['tipo'] = 'text';
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['marco'] = true;
                                            $atributos ['estiloMarco'] = '';
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['columnas'] = 50;
                                            $atributos ['filas'] = 5;
                                            $atributos ['dobleLinea'] = 0;
                                            $atributos ['tabIndex'] = $tab;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['validar'] = '';
                                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                            $atributos ['deshabilitado'] = true;
                                            $atributos ['tamanno'] = 10;
                                            $atributos ['maximoTamanno'] = '';
                                            $atributos ['anchoEtiqueta'] = 220;
                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['valor'] = '';
                                            }
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoTextArea($atributos);
                                            unset($atributos);

                                            $esteCampo = 'valor_contrato';
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['tipo'] = 'text';
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['marco'] = true;
                                            $atributos ['estiloMarco'] = '';
                                            $atributos ["etiquetaObligatorio"] = false;
                                            $atributos ['columnas'] = 3;
                                            $atributos ['dobleLinea'] = 0;
                                            $atributos ['tabIndex'] = $tab;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['validar'] = '';
                                            $atributos ['valor'] = $datosContratista[0]['valor_contrato'];
                                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                            $atributos ['deshabilitado'] = true;
                                            $atributos ['tamanno'] = 10;
                                            $atributos ['maximoTamanno'] = '';
                                            $atributos ['anchoEtiqueta'] = 213;
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroTexto($atributos);
                                            unset($atributos);

                                            $esteCampo = 'valor_adicion_presupuesto';
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['tipo'] = 'text';
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['marco'] = true;
                                            $atributos ['estiloMarco'] = '';
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['columnas'] = 3;
                                            $atributos ['dobleLinea'] = 0;
                                            $atributos ['tabIndex'] = $tab;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['validar'] = 'required, minSize[1],maxSize[16],custom[onlyNumberSp]';

                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['valor'] = '';
                                            }
                                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ['tamanno'] = 10;
                                            $atributos ['maximoTamanno'] = '';
                                            $atributos ['anchoEtiqueta'] = 213;
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroTexto($atributos);
                                            unset($atributos);
                                        }
                                        // ------------------Fin Division para los botones-------------------------
                                        echo $this->miFormulario->division("fin");
                                        unset($atributos);
                                    } else {
                                        $estiloTiempo = "";
                                        $sqlNovedad = $this->miSql->getCadenaSql("consultarAdcionTiempo", $_REQUEST['id_novedad']);
                                        $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                        $infoNovedad = $infoNovedad[0];
                                        $datos = array(
                                            'valor_adicion_tiempo' => $infoNovedad['valor_tiempo'],
                                            'tipo_adicion_modificacion' => $infoNovedad['tipo_adicion'],
                                            'unidad_tiempo_ejecucion' => $infoNovedad['unidad_tiempo_ejecucion'],
                                        );
                                        $_REQUEST = array_merge($_REQUEST, $datos);

                                        $atributos ["id"] = "divisionAdicionTiempo";
                                        $atributos ["estiloEnLinea"] = $estiloTiempo;
                                        $atributos = array_merge($atributos, $atributosGlobales);
                                        echo $this->miFormulario->division("inicio", $atributos);
                                        unset($atributos); {

                                            $esteCampo = 'valor_adicion_tiempo';
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['tipo'] = 'text';
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['marco'] = true;
                                            $atributos ['estiloMarco'] = '';
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['columnas'] = 2;
                                            $atributos ['dobleLinea'] = 0;
                                            $atributos ['tabIndex'] = $tab;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['validar'] = 'required, minSize[1],maxSize[3],custom[onlyNumberSp]';

                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['valor'] = '';
                                            }
                                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ['tamanno'] = 10;
                                            $atributos ['maximoTamanno'] = '';
                                            $atributos ['anchoEtiqueta'] = 300;
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroTexto($atributos);
                                            unset($atributos);
                                        }
                                        // ------------------Fin Division para los botones-------------------------
                                        echo $this->miFormulario->division("fin");
                                        unset($atributos);
                                    }
                                }
                                // ------------------Fin Division para los botones-------------------------
                                echo $this->miFormulario->division("fin");
                                unset($atributos);

                                break;
                            Case 234 :
                                $estiloAnulacion = "";
                                $sqlNovedad = $this->miSql->getCadenaSql("consultarAnulacion", $_REQUEST['id_novedad']);
                                $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                $infoNovedad = $infoNovedad[0];
                                $datos = array(
                                    'tipo_anulacion' => $infoNovedad['tipo_anulacion']
                                );
                                $_REQUEST = array_merge($_REQUEST, $datos);


                                $atributos ["id"] = "divisionAnulacion";
                                $atributos ["estiloEnLinea"] = $estiloAnulacion;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->division("inicio", $atributos);
                                unset($atributos); {

                                    $esteCampo = 'tipo_anulacion';
                                    $atributos ['columnas'] = 1;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['evento'] = '';
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['tab'] = $tab;
                                    $atributos ['tamanno'] = 1;
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['validar'] = 'required';
                                    $atributos ['limitar'] = false;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['anchoEtiqueta'] = 213;
                                    $atributos ['anchoCaja'] = 150;
                                    $atributos ['seleccion'] = -1;
                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['seleccion'] = '';
                                    }

                                    $matrizItems = array(
                                        array(
                                            ' ',
                                            'Sin Tipo de Novedades'
                                        )
                                    );

                                    $atributos ['baseDatos'] = 'contractual';
                                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_anulacion");

                                    $tab ++;
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroLista($atributos);
                                    unset($atributos);
                                }
                                // ------------------Fin Division para los botones-------------------------
                                echo $this->miFormulario->division("fin");
                                unset($atributos);
                                break;
                            Case 222 :
                                $estiloCambioSupervisor = "";
                                $sqlNovedad = $this->miSql->getCadenaSql("ConsultarcambioSupervisorPaticular", $_REQUEST['id_novedad']);
                                $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                $infoNovedad = $infoNovedad[0];

                                $datos = array(
                                    'tipoCambioSupervisor' => $infoNovedad['tipo_cambio'],
                                    'fecha_oficial_cambio' => $infoNovedad['fecha_cambio'],
                                    'nuevoSupervisor' => $infoNovedad['supervisor_nuevo'],
                                    'supervisor_actual' => $infoNovedad['supervisor_antiguo']
                                );
                                $_REQUEST = array_merge($_REQUEST, $datos);


                                $atributos ["id"] = "divisionCambioSupervisor";
                                $atributos ["estiloEnLinea"] = $estiloCambioSupervisor;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->division("inicio", $atributos);
                                unset($atributos); {

                                    $esteCampo = 'tipoCambioSupervisor';
                                    $atributos ['columnas'] = 1;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['evento'] = '';
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['tab'] = $tab;
                                    $atributos ['tamanno'] = 1;
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['validar'] = 'required';
                                    $atributos ['limitar'] = false;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['anchoEtiqueta'] = 220;
                                    $atributos ['anchoCaja'] = 150;
                                    $atributos ['seleccion'] = -1;
                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['seleccion'] = '';
                                    }

                                    $matrizItems = array(
                                        array(
                                            ' ',
                                            'Sin Tipo de Novedades'
                                        )
                                    );

                                    $atributos ['baseDatos'] = 'contractual';
                                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_cambio_supervisor");

                                    $tab ++;
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroLista($atributos);
                                    unset($atributos);


                                    $esteCampo = 'supervisor_actual';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'text';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['estiloMarco'] = '';
                                    $atributos ["etiquetaObligatorio"] = false;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = 0;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['validar'] = '';
                                    $atributos ['valor'] = $datosContratista[0][4];
                                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                    $atributos ['deshabilitado'] = true;
                                    $atributos ['tamanno'] = 40;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 150;
                                    $tab ++;

                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);


                                    $esteCampo = 'nuevoSupervisor';
                                    $atributos ['columnas'] = 1;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['evento'] = '';
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['tab'] = $tab;
                                    $atributos ['tamanno'] = 1;
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['validar'] = 'required';
                                    $atributos ['limitar'] = false;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['anchoEtiqueta'] = 150;
                                    $atributos ['anchoCaja'] = 150;
                                    $atributos ['seleccion'] = -1;
                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }

                                    $matrizItems = array(
                                        array(
                                            ' ',
                                            'Sin Tipo de Novedades'
                                        )
                                    );

                                    $atributos ['baseDatos'] = 'sicapital';
                                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios_cambio", $_REQUEST['nuevoSupervisor']);


                                    $tab ++;
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroLista($atributos);
                                    unset($atributos);

                                    $esteCampo = 'fecha_oficial_cambio';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'text';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['estiloMarco'] = '';
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = 0;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['validar'] = 'required';

                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }
                                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 10;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 213;
                                    $tab ++;

                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);



                                    $atributos ["id"] = "divisionSupervisor";
                                    $atributos ["estiloEnLinea"] = "display:none";
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->division("inicio", $atributos);
                                    unset($atributos); {

                                        $esteCampo = "AgrupacionSupervisor";
                                        $atributos ['id'] = $esteCampo;
                                        $atributos ['leyenda'] = "Datos del Supervisor";
                                        echo $this->miFormulario->agrupacion('inicio', $atributos);
                                        {

                                            $esteCampo = 'sede_super';
                                            $atributos ['columnas'] = 2;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['evento'] = '';
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['tab'] = $tab;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['validar'] = 'required';
                                            $atributos ['limitar'] = true;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['anchoEtiqueta'] = 150;

                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['seleccion'] = - 1;
                                            }

                                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                                            $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                                            $atributos ['matrizItems'] = $matrizItems;

                                            $tab ++;
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);

                                            $esteCampo = 'dependencia_supervisor';
                                            $atributos ['columnas'] = 2;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['evento'] = '';
                                            $atributos ['deshabilitado'] = true;
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['tab'] = $tab;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['validar'] = 'required';
                                            $atributos ['limitar'] = true;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['anchoEtiqueta'] = 150;
                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['seleccion'] = - 1;
                                            }
                                            // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "dependencias" );
                                            // $matrizItems = $esteRecursoDBO->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
                                            $matrizItems = array(
                                                array(
                                                    ' ',
                                                    'VACIO'
                                                )
                                            );

                                            $atributos ['matrizItems'] = $matrizItems;

                                            // Utilizar lo siguiente cuando no se pase un arreglo:
                                            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                                            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                                            $tab ++;
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);

                                            $esteCampo = 'cargo_supervisor';
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['tipo'] = 'text';
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['marco'] = true;
                                            $atributos ['estiloMarco'] = '';
                                            $atributos ["etiquetaObligatorio"] = false;
                                            $atributos ['columnas'] = 2;
                                            $atributos ['dobleLinea'] = 0;
                                            $atributos ['tabIndex'] = $tab;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['validar'] = 'required, minSize[1]';

                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['valor'] = '';
                                            }
                                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                            $atributos ['deshabilitado'] = true;
                                            $atributos ['tamanno'] = 40;
                                            $atributos ['maximoTamanno'] = '';
                                            $atributos ['anchoEtiqueta'] = 150;
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroTexto($atributos);
                                            unset($atributos);

                                            $esteCampo = 'cargo_inicial';
                                            $atributos ["id"] = $esteCampo; // No cambiar este nombre
                                            $atributos ["tipo"] = "hidden";
                                            $atributos ['estilo'] = '';
                                            $atributos ["obligatorio"] = false;
                                            $atributos ['marco'] = true;
                                            $atributos ["etiqueta"] = "";
                                            $atributos ['valor'] = '';
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroTexto($atributos);
                                            unset($atributos);



                                            // ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
                                            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                                            $esteCampo = 'cargosExistentes';
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ["etiquetaObligatorio"] = false;
                                            $atributos ['tab'] = $tab ++;
                                            $atributos ['anchoEtiqueta'] = 150;
                                            $atributos ['evento'] = '';
                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['seleccion'] = - 1;
                                            }
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ['columnas'] = 2;
                                            $atributos ['tamanno'] = 1;
                                            $atributos ['estilo'] = "jqueryui";
                                            $atributos ['validar'] = "";
                                            $atributos ['limitar'] = true;
                                            $atributos ['anchoCaja'] = 52;
                                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("cargos_existentes");

                                            $matrizItems = array(
                                                array(
                                                    0,
                                                    ' '
                                                )
                                            );
                                            $matrizItems = $DBSICA->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                                            for ($i = 0; $i < count($matrizItems); $i++) {
                                                $opciones[$i] = array($matrizItems[$i][0], $matrizItems[$i][0]);
                                            }
                                            $atributos ['matrizItems'] = $opciones;


                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroLista($atributos);
                                            unset($atributos);

                                            $esteCampo = 'digito_supervisor';
                                            $atributos ['id'] = $esteCampo;
                                            $atributos ['nombre'] = $esteCampo;
                                            $atributos ['tipo'] = 'text';
                                            $atributos ['estilo'] = 'jqueryui';
                                            $atributos ['marco'] = true;
                                            $atributos ['estiloMarco'] = '';
                                            $atributos ["etiquetaObligatorio"] = true;
                                            $atributos ['columnas'] = 2;
                                            $atributos ['dobleLinea'] = 0;
                                            $atributos ['tabIndex'] = $tab;
                                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                            $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                                            if (isset($_REQUEST [$esteCampo])) {
                                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                                            } else {
                                                $atributos ['valor'] = '';
                                            }
                                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                            $atributos ['deshabilitado'] = false;
                                            $atributos ['tamanno'] = 20;
                                            $atributos ['maximoTamanno'] = '';
                                            $atributos ['anchoEtiqueta'] = 150;
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoCuadroTexto($atributos);
                                            unset($atributos);
                                            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                                            // -----------------CONTROL: Botón ----------------------------------------------------------------
                                            echo "<center>";
                                            $esteCampo = 'botonCargo';
                                            $atributos ["id"] = $esteCampo;
                                            $atributos ["tabIndex"] = $tab;
                                            $atributos ["tipo"] = 'boton';
                                            // submit: no se coloca si se desea un tipo button genérico
                                            $atributos ['onClick'] = 'registrarNuevoCargo()';
                                            $atributos ["estiloMarco"] = '';
                                            $atributos ["estiloBoton"] = '';
                                            // verificar: true para verificar el formulario antes de pasarlo al servidor.
                                            $atributos ["verificar"] = '';
                                            $atributos ["tipoSubmit"] = ''; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                                            $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoBoton($atributos);
                                            unset($atributos);
                                            $esteCampo = 'restablecerCargo';
                                            $atributos ["id"] = $esteCampo;
                                            $atributos ["tabIndex"] = $tab;
                                            $atributos ["tipo"] = 'boton';
                                            // submit: no se coloca si se desea un tipo button genérico
                                            $atributos ['onClick'] = 'restCargoSuper()';
                                            $atributos ["estiloMarco"] = '';
                                            $atributos ["estiloBoton"] = '';
                                            // verificar: true para verificar el formulario antes de pasarlo al servidor.
                                            $atributos ["verificar"] = '';
                                            $atributos ["tipoSubmit"] = ''; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                                            $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                                            $tab ++;

                                            // Aplica atributos globales al control
                                            $atributos = array_merge($atributos, $atributosGlobales);
                                            echo $this->miFormulario->campoBoton($atributos);
                                            unset($atributos);

                                            echo "</center>";
                                        }
                                        echo $this->miFormulario->agrupacion('fin');
                                    }
                                }
                                // ------------------Fin Division para los botones-------------------------
                                echo $this->miFormulario->division("fin");
                                unset($atributos);
                                break;
                            Case 219 :
                                $estiloCesion = "";
                                $sqlNovedad = $this->miSql->getCadenaSql("consultaCesion", $_REQUEST['id_novedad']);
                                $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                $infoNovedad = $infoNovedad[0];
                                $datos = array(
                                    'fecha_inicio_cesion' => $infoNovedad['fecha_cesion'],
                                );
                                $_REQUEST = array_merge($_REQUEST, $datos);


                                $atributos ["id"] = "divisionCesion";
                                $atributos ["estiloEnLinea"] = $estiloCesion;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->division("inicio", $atributos);
                                unset($atributos); {


                                    $esteCampo = "selec_proveedor";
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'text';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['estiloMarco'] = '';
                                    $atributos ["etiquetaObligatorio"] = false;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = 0;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['validar'] = ' ';
                                    $atributos ['textoFondo'] = 'Ingrese el documento y de clic en el boton que aparece a continuación.';

                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }
                                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 50;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 220;
                                    $tab ++;



                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);




                                    $esteCampo = 'id_proveedor';
                                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                                    $atributos ["tipo"] = "hidden";
                                    $atributos ['estilo'] = '';
                                    $atributos ["obligatorio"] = false;
                                    $atributos ['marco'] = true;
                                    $atributos ["etiqueta"] = "";
                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);


                                    $esteCampo = 'fecha_inicio_cesion';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'text';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['estiloMarco'] = '';
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = 0;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['validar'] = 'required';

                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }
                                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 10;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 213;
                                    $tab ++;

                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);

                                    $esteCampo = 'actualContratista';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'hidden';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = false;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['valor'] = $datosContratista[0]['contratista'];
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 30;
                                    $atributos ['maximoTamanno'] = '';
                                    $tab ++;
                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);
                                }
                                // ------------------Fin Division para los botones-------------------------
                                echo $this->miFormulario->division("fin");
                                unset($atributos);

                                break;

                            Case 258 :
                                $estiloReduccion = "";
                                $sqlNovedad = $this->miSql->getCadenaSql("ConsultaReduccionModificacion", $_REQUEST['id_novedad']);
                                $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                $infoNovedad = $infoNovedad[0];
                                $datos = array(
                                    'registro_presupuestal_reduccion' => $infoNovedad['numero_rp'],
                                    'valor_reduccion' => $infoNovedad['valor_presupuesto'],
                                    'informacion_rp' => $infoNovedad['valor_presupuesto'],
                                    'vigencia_rp_hidden' => $infoNovedad['vigencia'],
                                );
                                $_REQUEST = array_merge($_REQUEST, $datos);

                                $atributos ["id"] = "divisionReduccion";
                                $atributos ["estiloEnLinea"] = $estiloReduccion;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->division("inicio", $atributos);
                                unset($atributos);
                                {

                                    $datosContrato = array('vigencia' => $_REQUEST['vigencia'], 'numero_contrato'
                                        => $_REQUEST['numero_contrato']);
                                    $cadenaConsultarCDP = $this->miSql->getCadenaSql('ConsultarCDPContrato', $datosContrato);
                                    $CDP = $esteRecursoDB->ejecutarAcceso($cadenaConsultarCDP, "busqueda");
                                    $CDP = $CDP[0][0];

                                    $datosCDP = array(0 => $CDP, 1 => $_REQUEST['vigencia'],
                                        2 => $unidad[0]['unidad_ejecutora']);



                                    $datosRP = array(
                                        0 => $infoNovedad['numero_rp'],
                                        1 => $infoNovedad['vigencia'],
                                        2 => $unidad[0]['unidad_ejecutora']
                                    );
                                    $consultaInforp = $this->miSql->getCadenaSql('informacion_RP', $datosRP);
                                    $infoRp = $DBSICA->ejecutarAcceso($consultaInforp, "busqueda");
                                    $infoRp = $infoRp[0];

                                    $esteCampo = 'registro_presupuestal_reduccion';
                                    $atributos ['columnas'] = 1;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['evento'] = '';
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['tab'] = $tab;
                                    $atributos ['tamanno'] = 1;
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['validar'] = 'required';
                                    $atributos ['limitar'] = false;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['anchoEtiqueta'] = 213;
                                    $atributos ['anchoCaja'] = 150;
                                    $atributos ['seleccion'] = -1;
                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['seleccion'] = '';
                                    }

                                    $matrizItems = array(
                                        array(
                                            ' ',
                                            'Sin Tipo de Novedades'
                                        )
                                    );

                                    $atributos ['baseDatos'] = 'sicapital';
                                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("Consultar_rps", $datosCDP);
                                    $tab ++;
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroLista($atributos);
                                    unset($atributos);

                                    $esteCampo = 'informacion_rp';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'text';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['estiloMarco'] = '';
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['columnas'] = 105;
                                    $atributos ['filas'] = 5;
                                    $atributos ['dobleLinea'] = 0;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['validar'] = '';
                                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                    $atributos ['deshabilitado'] = true;
                                    $atributos ['tamanno'] = 10;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 220;
                                    if (isset($infoRp)) {
                                        $atributos ['valor'] = "Numero Registro Presupuestal: " . $infoRp['NUMERO_REGISTRO']
                                                . " \nId Rubro Interno:" . $infoRp['RUBRO_INTERNO'] . "\nDescripcion: " . $infoRp['DESCRIPCION'] . "\nValor: " . $infoRp['VALOR'];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }
                                    $tab ++;

                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoTextArea($atributos);
                                    unset($atributos);

                                    $esteCampo = 'valor_reduccion';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'text';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['estiloMarco'] = '';
                                    $atributos ["etiquetaObligatorio"] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = 0;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                    $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                                    if (isset($_REQUEST [$esteCampo])) {
                                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                                    } else {
                                        $atributos ['valor'] = '';
                                    }
                                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 10;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 250;
                                    $tab ++;

                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);


                                    $esteCampo = 'valor_rp_hidden';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'hidden';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = false;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['valor'] = $infoRp['VALOR'];
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 30;
                                    $atributos ['maximoTamanno'] = '';
                                    $tab ++;
                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);

                                    $esteCampo = 'vigencia_rp_hidden';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'hidden';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = false;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['valor'] = $infoNovedad['vigencia'];
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 30;
                                    $atributos ['maximoTamanno'] = '';
                                    $tab ++;
                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);

                                    $esteCampo = 'valor_reduccion_actual';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['nombre'] = $esteCampo;
                                    $atributos ['tipo'] = 'hidden';
                                    $atributos ['estilo'] = 'jqueryui';
                                    $atributos ['marco'] = true;
                                    $atributos ['columnas'] = 1;
                                    $atributos ['dobleLinea'] = false;
                                    $atributos ['tabIndex'] = $tab;
                                    $atributos ['valor'] = $_REQUEST['valor_reduccion'];
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 30;
                                    $atributos ['maximoTamanno'] = '';
                                    $tab ++;
                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->campoCuadroTexto($atributos);
                                    unset($atributos);
                                }
                                // ------------------Fin Division para los botones-------------------------
                                echo $this->miFormulario->division("fin");
                                unset($atributos);


                                break;

                            default :
                                $sqlNovedad = $this->miSql->getCadenaSql("ConsultaOtra", $_REQUEST['id_novedad']);
                                $infoNovedad = $esteRecursoDB->ejecutarAcceso($sqlNovedad, "busqueda");
                                $infoNovedad = $infoNovedad[0];
                                break;
                        }
                        $jsondatosActules = "";
                        $infoActualNovedad = array_merge($datos_generales_novedad, $infoNovedad);
                        for ($i = 0; $i < count($infoActualNovedad); $i++) {
                            unset($infoActualNovedad[$i]);
                        }
                        foreach ($infoActualNovedad as &$valor) {
                            $key = array_search ($valor, $infoActualNovedad);
                            $jsondatosActules .= "\"".$key."\":\"".str_replace("\"", "'", $valor)."\",";
                        }
                        
                        $jsondatosActules = "{".substr($jsondatosActules, 0,-1)."}";
                        

                        $esteCampo = 'unidad_ejecutora_hidden';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'hidden';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = false;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['valor'] = $unidad[0]['unidad_ejecutora'];
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 30;
                        $atributos ['maximoTamanno'] = '';
                        $tab ++;
                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);
                }
            }

            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");
            unset($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        }
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonModificar';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
        $atributos ["estiloMarco"] = '';
        $atributos ["estiloBoton"] = 'jqueryui';
        // verificar: true para verificar el formulario antes de pasarlo al servidor.
        $atributos ["verificar"] = '';
        $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoBoton($atributos);
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
        // ---------------------------------------------------------
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");

        // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
         */
        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
        // Paso 1: crear el listado de variables

        $valorCodificado = "action=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=modificarNovedad";
        $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $valorCodificado .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
        $valorCodificado .= "&vigencia=" . $_REQUEST ['vigencia'];
        $valorCodificado .= "&tipo_novedad=" . $_REQUEST ['tipo_novedad'];
        $valorCodificado .= "&id_novedad=" . $_REQUEST ['id_novedad'];
        $valorCodificado .= "&idnovedadModificacion=" . $_REQUEST ['idnovedadModificacion'];
        $valorCodificado .= "&datosActualesNovedad=" . $jsondatosActules;
        $valorCodificado .= "&tipo_novedad=" . $_REQUEST['tipo_novedad'];
        if (isset($_REQUEST['tipo_adicion'])) {
            $valorCodificado .= "&tipo_adicion=" . $_REQUEST ['tipo_adicion'];
        }

        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
        $valorCodificado .= "&tiempo=" . time();
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>

