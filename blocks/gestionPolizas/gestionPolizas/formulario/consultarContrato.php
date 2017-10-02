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
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);


        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

        $conexionCore = "core";
        $esteRecursoDBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");



        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        // Limpia Items Tabla temporal
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];

        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;

        /**
         * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
         * validationEngine.
         */
        $atributos ['validar'] = false;

        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo);
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = false;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos = array_merge($atributos);
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $ventanaClaseContratista = 'none';
        $ventanaConvenio = 'none';

        if (isset($_REQUEST ['opcion']) == 'modificarContrato') {
            $datosContrato = array($_REQUEST ['numero_contrato'], $_REQUEST ['vigencia']);
            $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contrato_Particular', $datosContrato);
            $contrato = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            $contrato = $contrato [0];


            $arregloContrato = array(
                "numero_contrato" => $contrato ['numero_contrato'],
                "clase_contratista" => $contrato ['clase_contratista'],
                "clase_contrato" => $contrato ['tipologia_contrato'],
                "tipo_compromiso" => $contrato ['tipo_compromiso'],
                "plazo_ejecucion" => $contrato ['plazo_ejecucion'],
                "unidad_ejecucion_tiempo" => $contrato ['unidad_ejecucion'],
                "tipologia_especifica" => $contrato ['tipologia_contrato'],
                "numero_constancia" => $contrato ['numero_constancia'],
                "modalidad_seleccion" => $contrato ['modalidad_seleccion'],
                "procedimiento" => $contrato ['procedimiento'],
                "regimen_contratación" => $contrato ['regimen_contratacion'],
                "tipo_moneda" => $contrato ['tipo_moneda'],
                "tipo_gasto" => $contrato ['tipo_gasto'],
                "origen_recursos" => $contrato ['origen_recursos'],
                "origen_presupuesto" => $contrato ['origen_presupueso'],
                "tema_gasto_inversion" => $contrato ['tema_gasto_inversion'],
                "valor_contrato_moneda_ex" => $contrato ['valor_contrato_me'],
                "tasa_cambio" => $contrato ['valor_tasa_cambio'],
                "observacionesContrato" => $contrato ['observaciones'],
                "tipo_control" => $contrato ['tipo_control'],
                "nombre_supervisor" => $contrato ['documento'] . "-" . $contrato['nombre'],
                "cargo_supervisor" => $contrato ['cargo'],
                "numero_convenio" => $contrato ['convenio'],
                "digito_supervisor" => $contrato ['digito_verificacion'],
                "formaPago" => $contrato ['forma_pago'],
                "clausula_presupuesto" => $contrato ['clausula_registro_presupuestal'],
                "objeto_contrato" => $contrato ['objeto_contrato'],
                "clausulas_contractuales" => $contrato ['clausulas_contractuales'],
                "valor_contrato" => $contrato ['valor_contrato'],
                "dependencia_solicitante" => $contrato ['dependencia_solicitante'],
                "sede" => $contrato ['sede_solicitante'],
                "dependencia_supervisor" => $contrato ['dependencia_supervisor'],
                "sede_super" => $contrato ['sede_supervisor'],
                "justificacion" => $contrato ['justificacion'],
                "especificaciones_tecnicas" => $contrato ['especificaciones_tecnicas'],
                "descripcion_forma_pago" => $contrato ['descripcion_forma_pago'],
                "condiciones" => $contrato ['condiciones'],
                "ordenador_gasto" => $contrato ['ordenador_gasto'],
                "convenio_solicitante" => $contrato ['convenio'],
                "ejecucionCiudad" => $contrato ['ciudad'],
                "sede_ejecucion" => $contrato ['sede'],
                "dependencia_ejecucion" => $contrato ['dependencia'],
                "direccion_ejecucion" => $contrato ['direccion'],
                "tipo_supervisor" => $contrato['tipo']
            );
            $_REQUEST = array_merge($_REQUEST, $arregloContrato);
        }
        $sqlPadresCiudad = $this->miSql->getCadenaSql("buscarPadresCiudad", $_REQUEST['ejecucionCiudad']);
        $padresCiudad = $esteRecursoDBCore->ejecutarAcceso($sqlPadresCiudad, "busqueda");
        $padresCiudad = array(
            'ejecucionDepartamento' => $padresCiudad[0]['id_departamento'],
            'ejecucionPais' => $padresCiudad[0]['id_pais'],
        );


        $_REQUEST = array_merge($_REQUEST, $padresCiudad);
        $datos_disponibilidad = array(0 => $contrato ['numero_cdp'], 1 => $_REQUEST['vigencia'], 2 => $unidad[0]['unidad_ejecutora']);
        $cadena_sql = $this->miSql->getCadenaSql('Consultar_Disponibilidad', $datos_disponibilidad);
        $disponibilidad = $DBSICA->ejecutarAcceso($cadena_sql, "busqueda");
        $datos_disponibilidad[0] = $disponibilidad[0][0];
        //.------------------- Consulta de RPs Asociados----------------------------------------------
        $cadena_sql = $this->miSql->getCadenaSql('Consultar_Rubros', $datos_disponibilidad);
        $registrosPresupuestales = $DBSICA->ejecutarAcceso($cadena_sql, "busqueda");

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Cosultar Contrato ".$_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);
        {

            $datosContrato = array('vigencia' => $_REQUEST['vigencia'], 'numero_contrato' => $_REQUEST['numero_contrato']);
            if (isset($_REQUEST['ordenATC']) && $_REQUEST['ordenATC'] == "true") {

                $arreglo = unserialize(base64_decode($_REQUEST['arreglo']));
                $variable = "pagina=gestionContratosATC";
                $variable .= "&opcion=ConsultarContratos";
                $variable .= "&estado=" . $arreglo['estado'];
                $variable .= "&tipo_contrato=" . $arreglo['tipo_contrato'];
                $variable .= "&fecha_inicial=" . $arreglo['fecha_inicial'];
                $variable .= "&fecha_final=" . $arreglo['fecha_final'];
                $variable .= "&vigencia=" . $arreglo['vigencia'];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
            } else {

                $arreglo = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                $arreglo = unserialize($arreglo);

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=ConsultarContratos";
                $variable .= "&clase_contrato=" . $arreglo['clase\_contrato'];
                $variable .= "&id_contrato=" . $arreglo['numero\_contrato'] . "-" . $arreglo['vigencia'];
                $variable .= "&fecha_inicio_sub=" . $arreglo['fecha\_inicial'];
                $variable .= "&id_contratista=" . $arreglo['nit'];
                $variable .= "&fecha_final_sub=" . $arreglo['fecha\_final'];
                $variable .= "&unidad_ejecutora_consulta=" . $arreglo['unidad\_ejecutora'];

                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
            }
            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'botonRegresar';
            $atributos ['id'] = $esteCampo;
            $atributos ['enlace'] = $variable;
            $atributos ['tabIndex'] = 1;
            $atributos ['estilo'] = 'textoSubtitulo';
            $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['ancho'] = '10%';
            $atributos ['alto'] = '10%';
            $atributos ['redirLugar'] = true;
            echo $this->miFormulario->enlace($atributos);
            unset($atributos);
            echo "<br>";

            if (isset($_REQUEST['ordenATC']) && $_REQUEST['ordenATC'] == "true") {

                $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/gestionContractual/novedad/registrarNovedad/archivoSoporte/";
                $hostLiquidados = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/gestionContractual/gestionContratosATC/archivoSoporte/";


                if ($_REQUEST['estado'] == '7') {
                    $consultaOrdenATC = $this->miSql->getCadenaSql("info_orden_Cancelada", $datosContrato);
                    $infoCancelada = $esteRecursoDB->ejecutarAcceso($consultaOrdenATC, "busqueda");
                    $mensaje = "Contrato Cancelado en la fecha:" . $infoCancelada[0]['fecha_cancelacion'] . "<br>";
                    $mensaje .= "Motivo de Cancelacion:" . $infoCancelada[0]['motivo_cancelacion'] . "<br>";
                    $mensaje .= "Usuario:" . $infoCancelada[0]['usuario'] . "<br>";
                    $mensaje .= "Acto Administrativo:" . $infoCancelada[0]['usuario'] . "<br>";
                } elseif ($_REQUEST['estado'] == '5') {
                    $consultaOrdenATC = $this->miSql->getCadenaSql("info_orden_Anulada", $datosContrato);
                    $infoAnulada = $esteRecursoDB->ejecutarAcceso($consultaOrdenATC, "busqueda");
                    $mensaje = "Contrato Anulado en la fecha: " . $infoAnulada[0]['fecha_registro'] . "<br>";
                    $mensaje .= "Motivo de Anulación: " . $infoAnulada[0]['descripcion'] . "<br>";
                    $mensaje .= "Tipo de Anulación: " . $infoAnulada[0]['tipoanulacion'] . "<br>";
                    $mensaje .= "Usuario: " . $infoAnulada[0]['usuario'] . "<br>";
                    $mensaje .= "Acto Administrativo: " . $infoAnulada[0]['acto_administrativo'] . "<br>";
                    $mensaje .= "Documento: <a href='" . $host . $infoAnulada[0]['documento'] . "' TARGET='_blank' >" . $infoAnulada[0]['documento'] . "</a>";
                } elseif ($_REQUEST['estado'] == '8') {
                    $consultaOrdenATC = $this->miSql->getCadenaSql("info_orden_terminada_anticipada", $datosContrato);
                    $infoTerminadoAnticipado = $esteRecursoDB->ejecutarAcceso($consultaOrdenATC, "busqueda");
                    $mensaje = "Contrato Terminado Anticipadamente en la fecha: " . $infoTerminadoAnticipado[0]['fecha'] . "<br>";
                    $mensaje .= "Motivo de la Terminacion Anticipada: " . $infoTerminadoAnticipado[0]['descripcion'] . "<br>";
                    $mensaje .= "Usuario: " . $infoTerminadoAnticipado[0]['usuario'] . "<br>";
                    $mensaje .= "Acto Administrativo: " . $infoTerminadoAnticipado[0]['acto_administrativo'] . "<br>";
                    $mensaje .= "Documento: <a href='" . $host . $infoTerminadoAnticipado[0]['documento'] . "' TARGET='_blank' >" . $infoTerminadoAnticipado[0]['documento'] . "</a>";
                } elseif ($_REQUEST['estado'] == '9') {
                    $consultaOrdenATC = $this->miSql->getCadenaSql("info_contrato_liquidado", $datosContrato);
                    $infoLiquidado = $esteRecursoDB->ejecutarAcceso($consultaOrdenATC, "busqueda");
                    $mensaje = "Contrato Liquidado en la fecha: " . $infoLiquidado[0]['fecha_liquidacion'] . "<br>";
                    $mensaje .= "Observaciones: " . $infoLiquidado[0]['observaciones'] . "<br>";
                    $mensaje .= "Usuario: " . $infoLiquidado[0]['usuario'] . "<br>";
                    $mensaje .= "Acto Administrativo: " . $infoLiquidado[0]['numero_acto'] . "<br>";
                    $mensaje .= "Documento: <a href='" . $hostLiquidados . $infoLiquidado[0]['documento'] . "' TARGET='_blank' >" . $infoLiquidado[0]['documento'] . "</a>";
                } else {
                    $consultaOrdenATC = $this->miSql->getCadenaSql("info_orden_termminada", $datosContrato);
                    $infoTerminada = $esteRecursoDB->ejecutarAcceso($consultaOrdenATC, "busqueda");
                    $mensaje = "Contrato Finalizado en la fecha: " . $infoTerminada[0]['fecha_registro'] . "<br>";
                    $mensaje .= "Observaciones: " . $infoTerminada[0]['descripcion'] . "<br>";
                    $mensaje .= "Usuario: " . $infoTerminada[0]['usuario'] . "<br>";
                    $mensaje .= "Acto Administrativo: " . $infoTerminada[0]['acto_administrativo'] . "<br>";
                    $mensaje .= "Documento: <a href='" . $host . $infoTerminada[0]['documento'] . "' TARGET='_blank' >" . $infoTerminada[0]['documento'] . "</a>";
                };

                $esteCampo = "marcoContratoATC";
                $atributos ['id'] = $esteCampo;
                $atributos ["estilo"] = "jqueryui";
                $atributos ['tipoEtiqueta'] = 'inicio';
                $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo);

                echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


                echo "<center><button id='myBtn2' >Ver Información</button></center>";
                echo "<div id='myModal2' class='modal'>
                            <div class='modal-content'>";

                $esteCampo = "marcoOrdenATC";
                $atributos ['id'] = $esteCampo;
                $atributos ["estilo"] = "jqueryui";
                $atributos ['tipoEtiqueta'] = 'inicio';
                $atributos ["leyenda"] = "Informacion Adicional del Contrato";

                echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

                $esteCampo = 'mensajeATC';
                $atributos ['id'] = $esteCampo;
                $atributos ['tipo'] = 'information';
                $atributos ['estilo'] = 'textoCentrar';
                $atributos ['mensaje'] = $mensaje;

                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->cuadroMensaje($atributos);

                unset($atributos);
                echo "<center><span id='span2' class='close'>CERRAR</span><center>";
                echo $this->miFormulario->agrupacion('fin');
                echo "</div></div>";
                echo $this->miFormulario->agrupacion('fin');
            }

            $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $_REQUEST['usuario']);
            $unidadEjecutora = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");


            $esteCampo = 'unidad_ejecutora';
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

            if (isset($unidadEjecutora)) {
                $atributos ['valor'] = $unidadEjecutora[0]['nombre'];
            } else {
                $atributos ['valor'] = 'Usuario sin Dependencia Registrada';
            }
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = true;
            $atributos ['tamanno'] = 35;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 180;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);
            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "ventanaA";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos);
            {

                echo "<h3>Informacion del Contrato</h3>
							<section>";
                {

                    $esteCampo = 'tipo_compromiso';
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
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 20;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_compromiso");

                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    if ($_REQUEST ['tipo_compromiso'] == 34) {
                        $estiloConvenio = "";
                    } else {
                        $estiloConvenio = "display:none";
                    }


                    $atributos ["id"] = "divisionConvenio";
                    $atributos = array_merge($atributos, $atributosGlobales);
                    $atributos ["estiloEnLinea"] = $estiloConvenio;
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {


                        $esteCampo = 'vigencia_convenio';
                        $atributos ['columnas'] = 2;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['id'] = $esteCampo;
                        $atributos ['evento'] = '';
                        $atributos ['deshabilitado'] = true;
                        $atributos ["etiquetaObligatorio"] = false;
                        $atributos ['tab'] = $tab;
                        $atributos ['tamanno'] = 1;
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['validar'] = '';
                        $atributos ['limitar'] = true;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 170;

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencia_convenios");
                        $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = "convenio_solicitante";
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
                        $atributos ['limitar'] = false;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 15;
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("convenios");
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $sqlNombreConvenio = $this->miSql->getCadenaSql("buscar_nombre_convenio", $_REQUEST['convenio_solicitante']);
                        $nombreConvenio = $esteRecursoDB->ejecutarAcceso($sqlNombreConvenio, "busqueda");


                        $esteCampo = 'nombre_convenio_solicitante';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 140;
                        $atributos ['filas'] = 2;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'minSize[1]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        if ($nombreConvenio != false) {
                            $atributos ['valor'] = $nombreConvenio[0][0];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);
                        unset($atributos);
                    }
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $esteCampo = 'tipologia_especifica';
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
                    $atributos ['limitar'] = false;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 15;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipologia_contrato");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'modalidad_seleccion';
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
                    $atributos ['limitar'] = false;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 27;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modalidad_seleccion");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'procedimiento';
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
                    $atributos ['limitar'] = false;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 30;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_procedimiento");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'regimen_contratación';
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
                    $atributos ['limitar'] = false;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 30;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("regimen_contratacion");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);


                    $esteCampo = 'unidad_ejecucion_tiempo';
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
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 20;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_ejecucion_tiempo");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);


                    $esteCampo = 'plazo_ejecucion';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 2;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 213;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'numero_constancia';
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
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 213;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }
                echo "</section>";


                echo "<h3>Información del Solicitante y el Supervisor</h3><section>";

                $esteCampo = "AgrupacionSolicitante";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Información del Solicitante";
                echo $this->miFormulario->agrupacion('inicio', $atributos); {

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'sede';
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
                    $atributos ['anchoEtiqueta'] = 170;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;


                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = "dependencia_solicitante";
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
                    $atributos ['anchoEtiqueta'] = 115;
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("dependenciasConsultadas", $_REQUEST['sede']);
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);


                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                }
                echo $this->miFormulario->agrupacion('fin');

                $esteCampo = "AgrupacionSupervisor";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Datos del Supervisor";
                echo $this->miFormulario->agrupacion('inicio', $atributos); {

                    //------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'sede_super';
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
                    $atributos ['anchoEtiqueta'] = 175;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
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
                    $atributos ['anchoEtiqueta'] = 175;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("dependenciasConsultadas", $_REQUEST['sede_super']);
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $atributos ['matrizItems'] = $matrizItems;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);


                    $esteCampo = 'tipo_supervisor';
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
                    $atributos ['anchoEtiqueta'] = 175;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $matrizItems = array(
                        array(1, 'FUNCIONARIO'),
                        array(2, 'INTERVENTOR')
                    );

                    $atributos ['matrizItems'] = $matrizItems;


                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $estiloDivisionFuncionario = "display:none";
                    $estiloDivisionInterventor = "display:none";
                    if ($_REQUEST['tipo_supervisor'] == 1) {
                        $estiloDivisionFuncionario = "";
                    } else {
                        $estiloDivisionInterventor = "";
                    }


                    $atributos ["id"] = "divisionSupervisorFuncionario";
                    $atributos = array_merge($atributos, $atributosGlobales);
                    $atributos ["estiloEnLinea"] = $estiloDivisionFuncionario;
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {
                        $esteCampo = 'nombre_supervisor';
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['id'] = $esteCampo;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['tab'] = $tab ++;
                        $atributos ['anchoEtiqueta'] = 175;
                        $atributos ['evento'] = '';
                        if (isset($_REQUEST [$esteCampo]) && $_REQUEST['tipo_supervisor'] == 1) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }
                        $atributos ['deshabilitado'] = true;
                        $atributos ['columnas'] = 2;
                        $atributos ['tamanno'] = 1;
                        $atributos ['ajax_function'] = "";
                        $atributos ['ajax_control'] = $esteCampo;
                        $atributos ['estilo'] = "jqueryui";
                        $atributos ['validar'] = "required";
                        $atributos ['limitar'] = true;
                        $atributos ['anchoCaja'] = 52;
                        $atributos ['miEvento'] = '';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios");
                        $matrizItems = array(
                            array(
                                0,
                                ' '
                            )
                        );
                        $matrizItems = $DBSICA->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    echo $this->miFormulario->division("fin");
                    unset($atributos);
                    $atributos ["id"] = "divisionSupervisorInterventor";
                    $atributos = array_merge($atributos, $atributosGlobales);
                    $atributos ["estiloEnLinea"] = $estiloDivisionInterventor;
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'nombre_supervisor_interventor';
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['id'] = $esteCampo;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['tab'] = $tab ++;
                        $atributos ['anchoEtiqueta'] = 175;
                        $atributos ['evento'] = '';
                        if (isset($_REQUEST ['nombre_supervisor']) && $_REQUEST['tipo_supervisor'] == 2) {
                            $atributos ['seleccion'] = $_REQUEST ['nombre_supervisor'];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }
                        $atributos ['deshabilitado'] = true;
                        $atributos ['columnas'] = 2;
                        $atributos ['tamanno'] = 1;
                        $atributos ['ajax_function'] = "";
                        $atributos ['ajax_control'] = $esteCampo;
                        $atributos ['estilo'] = "jqueryui";
                        $atributos ['validar'] = "required";
                        $atributos ['limitar'] = true;
                        $atributos ['anchoCaja'] = 52;
                        $atributos ['miEvento'] = '';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("interventores");
                        $matrizItems = $esteRecursoDBAgora->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
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
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 175;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);


                    // -----------------CONTROL: Botón ----------------------------------------------------------------


                    $esteCampo = 'tipo_control';
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
                    $atributos ['limitar'] = false;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 175;
                    $atributos ['anchoCaja'] = 100;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = '-1';
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_control");
                    $tab ++;
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
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 175;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->agrupacion('fin');
                $esteCampo = "AgrupacionLugarEjecucion";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Lugar de Ejecución";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                    $esteCampo = 'ejecucionPais';
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos['tab'] = $tab;
                    $atributos['seleccion'] = -1;
                    $atributos['evento'] = ' ';
                    $atributos['deshabilitado'] = true;
                    $atributos['limitar'] = 50;
                    $atributos['tamanno'] = 1;
                    $atributos['columnas'] = 2;
                    $atributos ['anchoEtiqueta'] = 175;

                    $atributos ['obligatorio'] = true;
                    $atributos ['etiquetaObligatorio'] = true;
                    $atributos ['validar'] = '';

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarPais");
                    $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $atributos['matrizItems'] = $matrizItems;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = '';
                    }

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);

                    $esteCampo = 'ejecucionDepartamento';
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos['tab'] = $tab;
                    $atributos['seleccion'] = -1;
                    $atributos['evento'] = ' ';
                    $atributos['deshabilitado'] = true;
                    $atributos['limitar'] = 50;
                    $atributos['tamanno'] = 1;
                    $atributos['columnas'] = 2;
                    $atributos ['anchoEtiqueta'] = 175;

                    $atributos ['obligatorio'] = true;
                    $atributos ['etiquetaObligatorio'] = true;
                    $atributos ['validar'] = '';

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarDepartamento");
                    $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos['matrizItems'] = $matrizItems;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = '';
                    }
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    // --------------- FIN CONTROL : Select --------------------------------------------------
                    // ---------------- CONTROL: Select --------------------------------------------------------
                    $esteCampo = 'ejecucionCiudad';
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos['tab'] = $tab;
                    $atributos['seleccion'] = -1;
                    $atributos['evento'] = ' ';
                    $atributos['deshabilitado'] = true;
                    $atributos['limitar'] = 50;
                    $atributos['tamanno'] = 1;
                    $atributos['columnas'] = 2;
                    $atributos ['anchoEtiqueta'] = 175;

                    $atributos ['obligatorio'] = true;
                    $atributos ['etiquetaObligatorio'] = true;
                    $atributos ['validar'] = 'required';

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarCiudad");
                    $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = '';
                    }
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'sede_ejecucion';
                    $atributos ['columnas'] = 2;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['evento'] = '';
                    $atributos ['deshabilitado'] = true;
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['validar'] = '';
                    $atributos ['limitar'] = true;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 175;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'dependencia_ejecucion';
                    $atributos ['columnas'] = 2;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['evento'] = '';
                    $atributos ['deshabilitado'] = true;
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['validar'] = '';
                    $atributos ['limitar'] = true;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 175;

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("dependenciasConsultadas", $_REQUEST['sede_ejecucion']);

                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);




                    $esteCampo = 'direccion_ejecucion';
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
                    $atributos ['validar'] = 'required';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 175;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->agrupacion('fin');
//
                echo "</section>";



                echo "<h3>Información Contratista</h3><section>";

                $esteCampo = 'clase_contratista';
                $atributos ['columnas'] = 3;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['id'] = $esteCampo;
                $atributos ['evento'] = '';
                $atributos ['deshabilitado'] = true;
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['tab'] = $tab;
                $atributos ['tamanno'] = 1;
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['validar'] = 'required';
                $atributos ['limitar'] = false;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['anchoEtiqueta'] = 213;
                $atributos ['anchoCaja'] = 35;
                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['seleccion'] = - 1;
                }

                $matrizItems = array(
                    array(
                        ' ',
                        'Sin Solicitud de Necesidad'
                    )
                );

                // $atributos ['matrizItems'] = $matrizItems;
                // Utilizar lo siguiente cuando no se pase un arreglo:
                $atributos ['baseDatos'] = 'contractual';
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_clase_contratista");

                $tab ++;
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);

                if (isset($_REQUEST['clase_contratista'])) {
                    if ($_REQUEST['clase_contratista'] == '33') {

                        $estiloUnicoContratista = "";
                        $estiloSociedadTemporal = "display:none";
                        $parametro = $contrato['contratista'];
                        $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
                        $url = "http://10.20.0.127/agora/index.php?";
                        $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&parametro1=$parametro";
                        $url_servicio = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($data, $enlace);
                        $cliente = curl_init();
                        curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($cliente, CURLOPT_URL, $url_servicio);
                        $repuestaWeb = curl_exec($cliente);
                        curl_close($cliente);
                        $repuestaWeb = explode("<json>", $repuestaWeb);
                        $proveedor = json_decode($repuestaWeb[1]);
                        $proveedor = (array) $proveedor;
                        $proveedor = (array) $proveedor['datos'];
                    } elseif ($_REQUEST['clase_contratista'] == '31' || $_REQUEST['clase_contratista'] == '32') {

                        $estiloUnicoContratista = "display:none";
                        $estiloSociedadTemporal = "";
                        $cadenaInfoSociedad = $this->miSql->getCadenaSql("informacion_sociedad_proveedor", $contrato['contratista']);
                        $sociedad_temporal = $esteRecursoDBAgora->ejecutarAcceso($cadenaInfoSociedad, "busqueda");
                        $cadenaTelefonoSociedad = $this->miSql->getCadenaSql("informacion_sociedad_telefono", $contrato['contratista']);
                        $telefonoSociedad = $esteRecursoDBAgora->ejecutarAcceso($cadenaTelefonoSociedad, "busqueda");
                        $arreglo_sociedad_temporal = $sociedad_temporal[0];
                        $sqlNombreRepresentante = $this->miSql->getCadenaSql("nombre_participante_natural", $arreglo_sociedad_temporal['documento_representante']);
                        $nombreRepresentante = $esteRecursoDBAgora->ejecutarAcceso($sqlNombreRepresentante, "busqueda");
                        $sqlNombreRepresentanteSuplente = $this->miSql->getCadenaSql("nombre_participante_natural", $arreglo_sociedad_temporal['documento_suplente']);

                        $nombreRepresentanteSuplente = $esteRecursoDBAgora->ejecutarAcceso($sqlNombreRepresentanteSuplente, "busqueda");

                        $arreglo_sociedad_temporal = array(
                            'nombre_Consorcio_union' => $arreglo_sociedad_temporal['nom_proveedor'],
                            'identificacion_clase_contratista' => $arreglo_sociedad_temporal['num_documento'],
                            'digito_verificacion_clase_contratista' => $arreglo_sociedad_temporal['digito_verificacion'],
                            'representante_sociedad' => $nombreRepresentante[0][0],
                            'representante_suplente_sociedad' => $nombreRepresentanteSuplente[0][0],
                            'sociedadCiudad' => $arreglo_sociedad_temporal['id_ciudad_contacto'],
                            'correo_sociedad_temporal' => $arreglo_sociedad_temporal['correo'],
                            'sitio_web_temporal' => $arreglo_sociedad_temporal['web'],
                            'tipoCuenta' => $arreglo_sociedad_temporal['tipo_cuenta_bancaria'],
                            'numeroCuenta' => $arreglo_sociedad_temporal['num_cuenta_bancaria'],
                            'entidadBancaria' => $arreglo_sociedad_temporal['id_entidad_bancaria'],
                            'telefono_sociedad' => $telefonoSociedad[0]['numero_tel'],
                        );

                        $_REQUEST = array_merge($_REQUEST, $arreglo_sociedad_temporal);
                        $sqlParticipantes = $this->miSql->getCadenaSql("obtener_participantes", $contrato['contratista']);
                        $participantes = $esteRecursoDBAgora->ejecutarAcceso($sqlParticipantes, "busqueda");
                    } else {

                        $estiloUnicoContratista = "display:none";
                        $estiloSociedadTemporal = "display:none";
                    }
                } else {


                    $estiloUnicoContratista = "display:none";
                    $estiloSociedadTemporal = "display:none";
                }
                $atributos ["id"] = "divisionSociedadTemporal";
                $atributos = array_merge($atributos, $atributosGlobales);
                $atributos ["estiloEnLinea"] = $estiloSociedadTemporal;
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);
                {
                    $esteCampo = 'nombre_Consorcio_union';
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
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 320;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'identificacion_clase_contratista';
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
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 213;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'digito_verificacion_clase_contratista';
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
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 213;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'correo_sociedad_temporal';
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
                    $atributos ['validar'] = 'required, custom[email], maxSize[40]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 30;
                    $atributos ['maximoTamanno'] = '30';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'sitio_web_temporal';
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
                    $atributos ['validar'] = 'required';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 30;
                    $atributos ['maximoTamanno'] = '30';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'numeroCuenta';
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
                    $atributos ['validar'] = 'required, minSize[1],maxSize[15],custom[onlyNumberSp]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 15;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = "tipoCuenta";
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 200;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = -1;
                    }
                    $atributos ['deshabilitado'] = true;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "required";
                    $atributos ['limitar'] = false;
                    $atributos ['anchoCaja'] = 60;
                    $atributos ['miEvento'] = '';

                    // Valores a mostrar en el control
                    $matrizItems = array(
                        array('AHORROS', 'AHORROS'),
                        array('CORRIENTE', 'CORRIENTE')
                    );
                    $atributos ['matrizItems'] = $matrizItems;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);



                    $esteCampo = "entidadBancaria";
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 200;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = -1;
                    }
                    $atributos ['deshabilitado'] = true;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "required";
                    $atributos ['limitar'] = false;
                    $atributos ['anchoCaja'] = 60;
                    $atributos ['miEvento'] = '';

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("consultarBanco");
                    $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $sqlObtenerDepto = $this->miSql->getCadenaSql("buscarDepartamentodeCiudad", $_REQUEST['sociedadCiudad']);
                    $depto = $esteRecursoDBCore->ejecutarAcceso($sqlObtenerDepto, "busqueda");

                    $esteCampo = 'sociedadDepartamento';
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos['tab'] = $tab;
                    $atributos['seleccion'] = -1;
                    $atributos['evento'] = ' ';
                    $atributos['deshabilitado'] = true;
                    $atributos['limitar'] = 50;
                    $atributos['tamanno'] = 1;
                    $atributos['columnas'] = 2;
                    $atributos ['anchoEtiqueta'] = 200;

                    $atributos ['obligatorio'] = true;
                    $atributos ['etiquetaObligatorio'] = false;
                    $atributos ['validar'] = '';

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarDepartamento");
                    $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos['matrizItems'] = $matrizItems;

                    if (isset($depto) && $depto != false) {
                        $atributos ['seleccion'] = $depto[0][0];
                    } else {
                        $atributos ['seleccion'] = '';
                    }
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    // --------------- FIN CONTROL : Select --------------------------------------------------
                    // ---------------- CONTROL: Select --------------------------------------------------------
                    $esteCampo = 'sociedadCiudad';
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos['tab'] = $tab;
                    $atributos['seleccion'] = -1;
                    $atributos['evento'] = ' ';
                    $atributos['deshabilitado'] = true;
                    $atributos['limitar'] = 50;
                    $atributos['tamanno'] = 1;
                    $atributos['columnas'] = 2;
                    $atributos ['anchoEtiqueta'] = 200;

                    $atributos ['obligatorio'] = true;
                    $atributos ['etiquetaObligatorio'] = true;
                    $atributos ['validar'] = '';

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarCiudad");

                    $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos['matrizItems'] = $matrizItems;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = '';
                    }
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'telefono_sociedad';
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
                    $atributos ['validar'] = 'required';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 15;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'representante_sociedad';
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
                    $atributos ['validar'] = '';
                    $atributos ['textoFondo'] = 'Digite el numero de documento del representante';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 35;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 213;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);


                    $esteCampo = 'representante_suplente_sociedad';
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
                    $atributos ['validar'] = '';
                    $atributos ['textoFondo'] = 'Digite el numero de documento del suplente';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 35;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 213;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                    echo "<table id='tablaParticipantesSociedad'>";

                    echo "<thead>
                             <tr>
                                <th>Id unico Registro</th>            
                                <th>Nombre</th>            
                                <th>Identificacion</th>            
            			<th>Naturaleza</th>
            			<th>Puntaje</th>
                                <th>Porcentaje de Participacion</th>            
            			</tr>
                                </thead><tbody>";

                    for ($i = 0; $i < count($participantes); $i ++) {

                        $sqlParticipante = $this->miSql->getCadenaSql("nombre_participante", $participantes[$i] ['documento_contratista']);
                        $participante = $esteRecursoDBAgora->ejecutarAcceso($sqlParticipante, "busqueda");

                        $mostrarHtml = "<tr>
                            <td><center>" . $participantes[$i] ['id_participante'] . "</center></td>
                            <td><center>" . $participante[0][0] . "</center></td>
                            <td><center>" . $participantes[$i] ['documento_contratista'] . "</center></td>
                            <td><center>" . $participante[0][1] . "</center></td>
                            <td><center>" . $participante[0][2] . "</center></td>
                            <td>" . $participantes[$i] ['porcentaje_participacion'] . "</td></tr>";

                        echo $mostrarHtml;
                        unset($mostrarHtml);
                    }
                    echo "</tbody></table>";



                    $esteCampo = 'identificadores';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'hidden';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = false;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['valor'] = "";
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 30;
                    $atributos ['maximoTamanno'] = '';
                    $tab ++;
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'porcentajes';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'hidden';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = false;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['valor'] = "";
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 30;
                    $atributos ['maximoTamanno'] = '';
                    $tab ++;
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);



                $atributos ["id"] = "divisionClaseContratista";
                $atributos = array_merge($atributos, $atributosGlobales);
                $atributos ["estiloEnLinea"] = $estiloUnicoContratista;
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {


                    $esteCampo = 'tipo_identificacion';
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
                    $atributos ['validar'] = 'required';

                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = "NIT";
                    } else {
                        $atributos ['valor'] = utf8_decode($proveedor['tipo_documento_persona_natural']);
                    }

                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'numero_identificacion';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['num_nit_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['num_documento_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);


                    $esteCampo = 'digito_verificacion';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['digito_verificacion_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['digito_verificacion_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // Aplica atributos globales al control


                    $esteCampo = 'tipo_persona';
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
                    $atributos ['validar'] = 'required';
                    $atributos ['valor'] = $proveedor['tipo_persona'];
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ------------------Fin Division para los botones-------------------------





                    $esteCampo = 'nombre_Razon_Social';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['nom_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['primer_nombre_persona_natural'] . " " .
                                $proveedor['segundo_nombre_persona_natural'] . " " .
                                $proveedor['primer_apellido_persona_natural'] . " " .
                                $proveedor['segundo_nombre_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);



                    $esteCampo = 'genero';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['genero_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['genero_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'nacionalidad';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['nom_pais_empresa'] . " (" . $proveedor['nom_departamento_empresa'] . " - " . $proveedor['nom_ciudad_empresa'] . ")";
                    } else {
                        $atributos ['valor'] = $proveedor['pais_nacimiento_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);



                    $esteCampo = 'direccion';
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
                    $atributos ['validar'] = 'required';
                    $atributos ['valor'] = $proveedor['dir_contacto'];
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'telefono';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['telefono_empresa'] . " -" . $proveedor['movil_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['telefono_persona_natural'] . " -" . $proveedor['movil_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'nombre_representante';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['primer_nombre_representante'] . " " .
                                $proveedor['segundo_nombre_representante'] . " " . $proveedor['primer_apellido_representante'] . " " .
                                $proveedor['segundo_apellido_representante'];
                    } else {
                        $atributos ['valor'] = "N/A";
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'correo';
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
                    $atributos ['validar'] = 'required';
                    $atributos ['valor'] = $proveedor['correo_contacto'];
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'perfil';
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
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['perfil_representante'];
                    } else {
                        $atributos ['valor'] = $proveedor['perfil_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);




                    $esteCampo = 'profesion';
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
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['profesion_representante'];
                    } else {
                        $atributos ['valor'] = $proveedor['profesion_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'especialidad';
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
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['especialidad_representante'];
                    } else {
                        $atributos ['valor'] = $proveedor['especialidad_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'tipo_cuenta';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['tipo_cuenta_bancaria_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['tipo_cuenta_bancaria_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'numero_cuenta';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['num_cuenta_bancaria_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['num_cuenta_bancaria_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);



                    $esteCampo = 'entidad_bancaria';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = $proveedor['nom_banco_empresa'];
                    } else {
                        $atributos ['valor'] = $proveedor['nom_banco_persona_natural'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'tipo_configuracion';
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
                    $atributos ['validar'] = 'required';
                    if ($proveedor['tipo_persona'] == 'JURIDICA') {
                        $atributos ['valor'] = utf8_decode($proveedor['tipo_conformacion_empresa']);
                    } else {
                        $atributos ['valor'] = "N/A";
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 200;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }
                // ------------------Fin Division para los botones-------------------------
                echo $this->miFormulario->division("fin");
                unset($atributos);




                echo "</section>
							<h3>Objeto de Contrato</h3>
							<section>";
                {


                    $esteCampo = "AgrupacionDuracionPolizasPago";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Gestionar Polizas";
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {

                        unset($atributos);

                        $sqlPolizasactivas = $this->miSql->getCadenaSql('obtenerPolizarOrden', array('numero_contrato' => $contrato['numero_contrato'],
                            'vigencia' => $contrato['vigencia']));
                        $polizasActivas = $esteRecursoDB->ejecutarAcceso($sqlPolizasactivas, "busqueda");
                        echo "<div id='myModal' class='modal'>
                            <div class='modal-content'>";

                        $esteCampo = "AgrupacionPoliza";
                        $atributos ['id'] = $esteCampo;
                        $atributos ["estilo"] = "jqueryui";
                        $atributos ['tipoEtiqueta'] = 'inicio';
                        $atributos ['leyenda'] = "Gestion de Pólizas";
                        echo $this->miFormulario->agrupacion('inicio', $atributos);
                        $cadenaSql = $this->miSql->getCadenaSql('polizas');
                        $resultado_polizas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda"); {
                            for ($i = 0; $i < count($resultado_polizas); $i ++) {

                                $esteCampo = "AgrupacionPoliza$i";
                                $atributos ['id'] = $esteCampo;
                                $atributos ['leyenda'] = "";
                                $atributos ["estilo"] = "jqueryui";
                                echo $this->miFormulario->agrupacion('inicio', $atributos);
                                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                                $nombre = 'poliza' . $i;
                                $atributos ['id'] = $nombre;
                                $atributos ['nombre'] = $nombre;
                                $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = false;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['columnas'] = 2;
                                $atributos ['dobleLinea'] = 1;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['etiqueta'] = $resultado_polizas [$i]['descripcion_poliza'];
                                $atributos ['validar'] = '';

                                for ($j = 0; $j < count($polizasActivas); $j++) {
                                    if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                        $atributos ['valor'] = 'TRUE';
                                        $atributos ['seleccionado'] = 'checked';
                                    } else {
                                        $atributos ['valor'] = 'TRUE';
                                    }
                                }
                                $atributos ['deshabilitado'] = true;
                                $tab ++;

                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroSeleccion($atributos);
                                unset($atributos);

                                $estilo = "display:none";
                                for ($j = 0; $j < count($polizasActivas); $j++) {
                                    if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                        $estilo = "";
                                    }
                                }

                                $atributos ["id"] = "divisionPoliza$i";
                                $atributos ["estiloEnLinea"] = $estilo;
                                echo $this->miFormulario->division("inicio", $atributos);
                                unset($atributos);

                                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                                $esteCampo = 'fecha_inicio_poliza' . $i;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'fecha';
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ["etiquetaObligatorio"] = false;
                                $atributos ['columnas'] = 2;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['etiqueta'] = "Fecha Inicio Poliza";
                                $atributos ['validar'] = '';

                                for ($j = 0; $j < count($polizasActivas); $j++) {
                                    if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                        $atributos ['valor'] = $polizasActivas[$j]['fecha_inicio'];
                                    }
                                }
                                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                $atributos ['deshabilitado'] = true;
                                $atributos ['tamanno'] = 8;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 147;
                                $tab ++;

                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);

                                echo $this->miFormulario->campoCuadroTexto($atributos);
                                unset($atributos);

                                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                                $esteCampo = 'fecha_final_poliza' . $i;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'fecha';
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ["etiquetaObligatorio"] = false;
                                $atributos ['columnas'] = 2;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['etiqueta'] = "Fecha Final Poliza:";
                                $atributos ['validar'] = '';

                                for ($j = 0; $j < count($polizasActivas); $j++) {
                                    if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                        $atributos ['valor'] = $polizasActivas[$j]['fecha_final'];
                                    }
                                }
                                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                $atributos ['deshabilitado'] = true;
                                $atributos ['tamanno'] = 8;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 147;
                                $tab ++;

                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);

                                echo $this->miFormulario->campoCuadroTexto($atributos);
                                unset($atributos);

                                // ------------------Fin Division para las polizas-------------------------
                                echo $this->miFormulario->division("fin");
                                unset($atributos);
                                echo $this->miFormulario->agrupacion('fin');
                            }
                            $atributos ["id"] = "divisiobotonPolizas";
                            $atributos ["estilo"] = "marcoBotones";
                            echo $this->miFormulario->division("inicio", $atributos);
                            echo "<center><span id='span' class='close'>CONFIRMAR</span><center>";
                            echo $this->miFormulario->division('fin');
                        }
                        echo $this->miFormulario->agrupacion('fin');
                        echo " </div></div>";

                        $atributos ["id"] = "botones";
                        $atributos ["estilo"] = "marcoBotones";
                        echo $this->miFormulario->division("inicio", $atributos);
                        echo "<button id='myBtn' >Gestionar Polizas</button>";
                        echo $this->miFormulario->division('fin');
                    }
                    echo $this->miFormulario->agrupacion('fin');



                    $esteCampo = "AgrupacionObjetoContrato";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Objeto del Contrato";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {



                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'objeto_contrato';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 145;
                        $atributos ['filas'] = 5;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;

                        if (isset($_REQUEST ['objeto_contrato'])) {
                            $atributos ['valor'] = $_REQUEST ['objeto_contrato'];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);

                        unset($atributos);

                        $esteCampo = 'clausulas_contractuales';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 145;
                        $atributos ['filas'] = 5;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
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

                        $esteCampo = 'condiciones';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 145;
                        $atributos ['filas'] = 4;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
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
                    }

                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                }

                echo "</section>";

                echo "<h3>Justificacion y Condiciones</h3><section>";

                $esteCampo = "AgrupacionJustificacionCondiciones";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Justificación y Condiciones";
                echo $this->miFormulario->agrupacion('inicio', $atributos); {

                    $esteCampo = 'justificacion';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 105;
                    $atributos ['filas'] = 7;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
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

                    $esteCampo = 'especificaciones_tecnicas';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 105;
                    $atributos ['filas'] = 7;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
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

                    $esteCampo = 'observacionesContrato';
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
                }

                echo $this->miFormulario->agrupacion('fin');
                unset($atributos);


                echo "</section>";

                echo "<h3>Información Presupuestal</h3>
							<section>"; {

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {

                        $esteCampo = 'tipo_moneda';
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
                        $atributos ['limitar'] = false;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 27;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = 139;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_moneda");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'valor_contrato';
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
                        $atributos ['validar'] = 'required,custom[number]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
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

                    $esteCampo = "AgrupacionDisponibilidad";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Disponibilidades Presupuestales Asociadas";
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {
                        $suma = 0;
                        if ($disponibilidad) {
                            echo "<table id='tablaDisponibilidades'>";

                            echo
                            "<thead>
                             <tr>
                                <th>Número Disponibilidad</th>
                                <th>Vigencia </th>
                                <th>Id Rubro </th>
                                <th>Rubro </th>
                                <th>Valor($)</th>
                                 
                             </tr>
                             </thead>
            		     <tbody>";

                            foreach ($disponibilidad as $valor) {
                                $suma = $suma + $valor ['VALOR'];
                                $mostrarHtml = "<tr>
						   <td><center>" . $valor ['NUMERO_DISPONIBILIDAD'] . "</center></td>
						   <td><center>" . $valor ['VIGENCIA'] . "</center></td>
                                                   <td><center>" . $valor ['RUBRO_INTERNO'] . "</center></td>
                                                   <td><center>" . $valor ['DESCRIPCION'] . "</center></td>
						   <td><center>$" . number_format($valor ['VALOR'], 2, ",", ".") . "</center></td>
							                   
						</tr>";
                                echo $mostrarHtml;
                                unset($mostrarHtml);
                                unset($variable);
                            }

                            echo "</tbody>
									</table>";

                            echo "<center>Total: $" . number_format($suma, 2, ",", ".") . "</center>";
                        } else {
                            echo "<center>No Existen Disponibilidades Asociadas</center>";
                        }
                    }
                    echo $this->miFormulario->agrupacion('fin');

                    $esteCampo = "AgrupacionRegistrosP";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Registros Presupuestales Asociados";
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {

                        $suma = 0;
                        if ($registrosPresupuestales) {
                            echo "<center><table id='tablaRegistros'>";

                            echo
                            "<thead>
                                <tr>
                                 <th>Número Registro</th>
                                <th>Id del Rubro</th>
                                <th>Rubro</th>
            			<th>Valor($)</th>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach ($registrosPresupuestales as $valor) {
                                $suma = $suma + $valor ['VALOR'];
                                $mostrarHtml = "<tr>
                                            <td><center>" . $valor ['NUMERO_REGISTRO'] . "</center></td>
                                            <td><center>" . $valor ['RUBRO_INTERNO'] . "</center></td>
					    <td><center>" . $valor ['DESCRIPCION'] . "</center></td>
                                            <td><center>$" . number_format($valor ['VALOR'], 2, ",", ".") . "</center></td>
                                            </tr>";
                                echo $mostrarHtml;
                                unset($mostrarHtml);
                                unset($variable);
                            }

                            echo "</tbody>
									</table>";
                            echo "<center>Total: $" . number_format($suma, 2, ",", ".") . "</center>";
                        } else {

                            echo "<center>No Existen Registros Presupuestales Asociados</center>";
                        }
                    }
                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                    $esteCampo = 'ordenador_gasto';
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
                    $atributos ['limitar'] = false;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['anchoCaja'] = 26;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("ordenadorGasto");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $sqlNombreOrdenador = $this->miSql->getCadenaSql("informacion_ordenador", $_REQUEST['ordenador_gasto']);
                    $nombreOrdenador = $esteRecursoDB->ejecutarAcceso($sqlNombreOrdenador, "busqueda");

                    $esteCampo = 'nombreOrdenador';
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
                    $atributos ['validar'] = 'required, minSize[1],maxSize[2000]';

                    if ($nombreOrdenador != false) {
                        $atributos ['valor'] = $nombreOrdenador[0][0];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 120;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {

                        $esteCampo = 'tipo_gasto';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_gasto");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'origen_recursos';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("origen_recursos");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {

                        $esteCampo = 'origen_presupuesto';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("origen_presupuesto");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'tema_gasto_inversion';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = 164;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tema_gasto");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    if ($_REQUEST['tipo_moneda'] != 137) {
                        $estiloDivisionModenaExt = "";
                    } else {
                        $estiloDivisionModenaExt = "display:none";
                    }

                    $atributos ["id"] = "divisionMonedaExtranjera";
                    $atributos = array_merge($atributos, $atributosGlobales);
                    $atributos ["estiloEnLinea"] = $estiloDivisionModenaExt;
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {

                        $esteCampo = 'valor_contrato_moneda_ex';
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
                        $atributos ['validar'] = 'custom[number]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'tasa_cambio';
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
                        $atributos ['validar'] = 'custom[number]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
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

                    //---------Campo de Seleccion Clausula Presupuestal-------------------------------
                    $esteCampo = 'clausula_presupuesto';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = true;
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['anchoEtiqueta'] = 70;
                    $atributos ['columnas'] = 3;
                    $atributos ['dobleLinea'] = 1;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = '';

                    if (isset($_REQUEST [$esteCampo]) && $_REQUEST [$esteCampo] == 't') {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                        $atributos ['seleccionado'] = 'checked';
                    } else {
                        $atributos ['valor'] = 'TRUE';
                    }

                    $atributos ['deshabilitado'] = true;
                    $tab ++;
                    //Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroSeleccion($atributos);
                    unset($atributos);

                    $esteCampo = 'formaPago';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 120;
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['evento'] = '';
                    $atributos ['seleccion'] = 240;
                    $atributos ['deshabilitado'] = true;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = 'required';
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 20;
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("forma_pago");
                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                    //---------Fin Campo de Seleccion Clausula Presupuestal-------------------------------
                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                    $esteCampo = 'descripcion_forma_pago';
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
                    $atributos ['validar'] = 'required, minSize[1]';
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
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
                }



                // // ---------------- CONTROL: hidden Atributos Contrado--------------------------------------------------------
                $esteCampo = 'atributosContratoTempHidden';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;
                $atributos ['valor'] = $_REQUEST ['numero_contrato'];
                $atributos ['deshabilitado'] = true;
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

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        }



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
        $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
        $valorCodificado .= "&id_solicitud_necesidad=" . $_REQUEST ['id_solicitud_necesidad'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $valorCodificado .= "&vigencia=" . $_REQUEST ['vigencia'];

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
