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

        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

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
        $atributos ["leyenda"] = "Registrar Novedad Contractual " . $_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");


        $datosContrato = array(0 => $_REQUEST['numero_contrato'],
            1 => $_REQUEST['vigencia']);

        $cadenaSql = $this->miSql->getCadenaSql('Consultar_Info_Acta_inicio', $datosContrato);
        $fecha_acta_inicio = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        $esteCampo = 'fecha_ejecucion_validacion';
        $atributos ["id"] = $esteCampo; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ['valor'] = $fecha_acta_inicio[0]['fecha_inicio'];
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
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

            $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
            $arreglo = unserialize($_REQUEST['arreglo']);
           
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=consultar";
            $variable .= "&id_contrato=" . $arreglo ['numero\_contrato']."-(". $arreglo ['vigencia'].")";
            $variable .= "&clase_contrato=" . $arreglo ['clase\_contrato'];
            $variable .= "&id_contratista=" . $arreglo ['nit'];
            $variable .= "&fecha_inicio_consulta=" . $arreglo ['fecha\_inicial'];
            $variable .= "&fecha_final_consulta=" . $arreglo ['fecha\_final'];
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "RegistroNovedad";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos);
            { {
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

                    $esteCampo = "AgrupacionInformación";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Datos Generales Contratista";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {
                        if ($datosContratista) {

                            foreach ($etiquetas as $key => $values) {
                                if ($values == 'Convenio' && $datosContratista[0][$key] != '') {
                                    $datosContratista[0][$key] = $datosContratista[0][$key] . "<a href='javascript:void(0);' onclick='VerInfoConvenio(" . $datosContratista [0] [$key] . ");'> (Convenio)</a>";
                                };
                                if ($values == 'Contratista' && $datosContratista[0][$key] != '') {
                                    if ($datosContratista[0]['clase_contratista'] == '33') {
                                        $datosContratista[0][$key] = "<a href='javascript:void(0);' onclick='VerInfoContratista(" . $datosContratista [0] [$key] . ");'> Información Contratista</a>";
                                    } else {
                                        $datosContratista[0][$key] = "<a href='javascript:void(0);' onclick='VerInfoSociedadTemporal(" . $datosContratista [0] [$key] . ");'> --> Información Contratista</a>";
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
                    unset($atributos);
                    {

                        if ($datosContratista[0]['estado_contrato'] == 2) {

                            $mensaje = "<center><h4>Estado del Contrato: " . $datosContratista[0]['nombre_estado'] . "</h4></center>";
                            $sqlSuspension = $this->miSql->getCadenaSql("obtenerInformacionSuspension", array(0 => $_REQUEST['numero_contrato'], 1 => $_REQUEST['vigencia']));
                            $suspension = $esteRecursoDB->ejecutarAcceso($sqlSuspension, "busqueda");

                            if ($suspension) {
                                $mensaje .= "Acto Administrativo:" . $suspension[0]['acto_administrativo'] . "<br>"
                                        . "Fecha Inicio Suspension: " . $suspension[0]['fecha_inicio'] . "<br>"
                                        . "Fecha Final Suspension: " . $suspension[0]['fecha_fin'];
                            }


                            $esteCampo = 'mensajeRegistro';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['estilo'] = 'textoCentrar';
                            $atributos ['tipo'] = 'information';
                            $atributos ['mensaje'] = $mensaje;

                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->cuadroMensaje($atributos);
                        }

                        $esteCampo = 'tipo_novedad';
                        $atributos ['columnas'] = 3;
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
                        $atributos ['anchoCaja'] = 100;
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

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';

                        if ($datosContratista[0]['estado_contrato'] != '2') {
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_novedad");
                        } else {
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_novedad_suspendido");
                        }
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

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

                        $atributos ["id"] = "divisionCesion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {


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
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);
                        $atributos ["id"] = "divisionSuspension";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

                            $esteCampo = 'fecha_inicio_suspension';
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
                            $atributos ['anchoEtiqueta'] = 250;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'fecha_fin_suspension';
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
                            $atributos ['anchoEtiqueta'] = 250;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        $atributos ["id"] = "divisionTerminacionAnticipada";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

                            $esteCampo = 'fecha_Terminacion_anticipada';
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
                            $atributos ['anchoEtiqueta'] = 250;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'fecha_actual';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'hidden';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = false;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['valor'] = date("Y-m-d");
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
                        $atributos ["id"] = "divisionReduccion";
                        $atributos ["estiloEnLinea"] = "display:none";
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
                            $atributos ['validar'] = 'required, minSize[1],maxSize[250]';
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
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);


                        $atributos ["id"] = "divisionAnulacion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

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

                        $atributos ["id"] = "divisionCambioSupervisor";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

                            $esteCampo = 'id_supervisor';
                            $atributos ["id"] = $esteCampo; // No cambiar este nombre
                            $atributos ["tipo"] = "hidden";
                            $atributos ['estilo'] = '';
                            $atributos ["obligatorio"] = false;
                            $atributos ['marco'] = true;
                            $atributos ["etiqueta"] = "";
                            $atributos ['valor'] = $datosContratista[0]['idsupervisor'];
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

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
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios_cambio", explode("-", $datosContratista[0][4])[0]);

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);



                            $atributos ["id"] = "divisionSupervisor";
                            $atributos ["estiloEnLinea"] = "";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);
                            {

                                $esteCampo = "AgrupacionSupervisor";
                                $atributos ['id'] = $esteCampo;
                                $atributos ['leyenda'] = "Datos del Supervisor";
                                echo $this->miFormulario->agrupacion('inicio', $atributos); {

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
                                    $atributos ['deshabilitado'] = false;
                                    $atributos ['tamanno'] = 40;
                                    $atributos ['maximoTamanno'] = '';
                                    $atributos ['anchoEtiqueta'] = 150;
                                    $tab ++;

                                    // Aplica atributos globales al control
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
                                    $atributos ['deshabilitado'] = true;
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
                                   
                                }
                                echo $this->miFormulario->agrupacion('fin');
                            }
                            // ------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
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
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        $atributos ["id"] = "divisionAdicion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

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

                            $atributos ['baseDatos'] = 'contractual';
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_adicion");

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);


                            $atributos ["id"] = "divisionAdicionPresupuesto";
                            $atributos ["estiloEnLinea"] = "display:none";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);
                            {

                                $esteCampo = 'vigencia_novedad';
                                $atributos ['columnas'] = 2;
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
                                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencias_sica_disponibilidades", date("Y"));

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
                                $atributos ['deshabilitado'] = true;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['tab'] = $tab;
                                $atributos ['tamanno'] = 1;
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['validar'] = 'required';
                                $atributos ['limitar'] = false;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['anchoEtiqueta'] = 213;
                                $atributos ['cadena_sql'] = '';
                                $arreglo = array(
                                    array(
                                        '',
                                        'Seleccione .....'
                                    )
                                );

                                $matrizItems = $arreglo;
                                $atributos ['matrizItems'] = $matrizItems;
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
                                $atributos ['deshabilitado'] = true;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['tab'] = $tab;
                                $atributos ['tamanno'] = 1;
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['validar'] = 'required';
                                $atributos ['limitar'] = false;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['anchoEtiqueta'] = 213;
                                $atributos ['cadena_sql'] = '';

                                $matrizItems = $arreglo;
                                $atributos ['matrizItems'] = $matrizItems;
                                $tab ++;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroLista($atributos);
                                unset($atributos);

                                $esteCampo = 'registro_presupuestal_adicion';
                                $atributos ['columnas'] = 2;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['seleccion'] = - 1;
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
                                $atributos ['cadena_sql'] = '';

                                $matrizItems = $arreglo;
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
                                $atributos ['validar'] = 'required, minSize[1],maxSize[250]';
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



                            $atributos ["id"] = "divisionAdicionTiempo";
                            $atributos ["estiloEnLinea"] = "display:none";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);
                            {

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
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        $atributos ["id"] = "divisionReanudacion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {


                            $esteCampo = 'fecha_reanuadion';
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

                            if (isset($suspension[0]['fecha_fin'])) {
                                $atributos ['valor'] = $suspension[0]['fecha_fin'];
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

                            $esteCampo = 'fecha_inicio_suspension_validacion';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'hidden';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = false;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['valor'] = $suspension[0]['fecha_inicio'];
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 30;
                            $atributos ['maximoTamanno'] = '';
                            $tab ++;
                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'fecha_fin_suspension_validacion';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'hidden';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = false;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['valor'] = $suspension[0]['fecha_fin'];
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 30;
                            $atributos ['maximoTamanno'] = '';
                            $tab ++;
                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'identificador_suspension';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'hidden';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = false;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['valor'] = $suspension[0]['id'];
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


                        $atributos ["id"] = "divisionModificacion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

                            $esteCampo = 'tipo_modificacion';
                            $atributos ['columnas'] = 3;
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
                            $atributos ['anchoCaja'] = 100;
                            $atributos ['seleccion'] = -1;
                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $atributos ['baseDatos'] = 'contractual';
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_modificacion");

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);


                            $esteCampo = 'razon_modificacion';
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

                            $atributos ["id"] = "divisionNovedad";
                            $atributos ["estiloEnLinea"] = "display:none";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);
                            {

                                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                                $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/gestionContractual/novedad/" . $esteBloque ['nombre'] . "/archivoSoporte/";

                                $datosContrato = array(0 => $_REQUEST['numero_contrato'],
                                    1 => $_REQUEST['vigencia']);
                                $sqlNovedadesContrato = $sqlAdicionesPresupuesto = $this->miSql->getCadenaSql('consultarNovedadesContrato', $datosContrato);
                                $novedadesContrato = $esteRecursoDB->ejecutarAcceso($sqlNovedadesContrato, "busqueda");

                                if ($novedadesContrato) {

                                    echo "<table id='tablaNovedadesContrato'>";
                                    echo "<thead>
                                             <tr>
                                                <th>Tipo de Novedad</th>
                                                <th>Estado</th>
                                                <th>Fecha de Registro</th>
                                                <th>Usuario</th>
                                                <th>Numero Acto Administrativo</th>
                                                <th>Documento</th>
                                                <th>Observaciones</th>
                                                <th>Modificar</th>
                                             </tr>
                                          </thead>
                                        <tbody>";

                                    for ($i = 0; $i < count($novedadesContrato); $i ++) {
                                        if ($novedadesContrato [$i] ['estado'] == 't') {
                                            $estado = "Activa";
                                        } else {
                                            $estado = "Inactiva";
                                        }


                                        $nombre = 'radioinput';
                                        $atributos ['id'] = $nombre;
                                        $atributos ['nombre'] = $nombre;
                                        $atributos ['marco'] = true;
                                        $atributos ['estiloMarco'] = true;
                                        $atributos ["etiquetaObligatorio"] = true;
                                        $atributos ['columnas'] = 1;
                                        $atributos ['dobleLinea'] = 1;
                                        $atributos ['tabIndex'] = $tab;
                                        $atributos ['etiqueta'] = '';
                                        $atributos ['validar'] = '';
                                        $atributos ['valor'] = $novedadesContrato[$i] ['id'] . "-" . $novedadesContrato[$i] ['tipo_novedad'];
                                        $atributos ['deshabilitado'] = false;
                                        $tab ++;

                                        // Aplica atributos globales al control
                                        $atributos = array_merge($atributos, $atributosGlobales);


                                        $mostrarHtml = "<tr>
                                <td><center>" . $novedadesContrato [$i] ['descripcion'] . "</center></td>		
                                <td><center>" . $estado . "</center></td>		
                                <td><center>" . $novedadesContrato [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $novedadesContrato [$i] ['usuario'] . "</center></td>
                                <td><center>" . $novedadesContrato [$i] ['acto_administrativo'] . "</center></td>
                                <td><center><a href='" . $host . $novedadesContrato [$i] ['documento'] . "' TARGET='_blank' >" . $novedadesContrato [$i] ['documento'] . "</a></center></td>
                                <td><center>" . $novedadesContrato [$i] ['observaciones'] . "</center></td>
                                <td><center>" . $this->miFormulario->campoBotonRadial($atributos) . "</center> </td>
                                </tr>";
                                        echo $mostrarHtml;
                                        unset($mostrarHtml);
                                    }

                                    echo "</tbody>";

                                    echo "</table>";
                                } else {

                                    $mensaje = "El contrato numero:  " . $datosContrato[0] . " "
                                            . "con vigencia: " . $datosContrato[0] . "<br>no presenta novedades registradas.";

                                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                                    $esteCampo = 'mensajeRegistro';
                                    $atributos ['id'] = $esteCampo;
                                    $atributos ['tipo'] = 'error';
                                    $atributos ['estilo'] = 'textoCentrar';
                                    $atributos ['mensaje'] = $mensaje;

                                    $tab ++;

                                    // Aplica atributos globales al control
                                    $atributos = array_merge($atributos, $atributosGlobales);
                                    echo $this->miFormulario->cuadroMensaje($atributos);
                                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                                }
                            }
                            // ------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
                            unset($atributos);
                            $atributos ["id"] = "divisionContrato";
                            $atributos ["estiloEnLinea"] = "display:none";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);
                            {
                                echo "<center><h2>Para Realizar la Novedad de Modificación Contractual Ingrese la Información Solicitada del Formulario <br> y "
                                . "clic en  Registrar, para continuar.</h2></center>";
                            }
                            // ------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);
                        //--------------------------------------------------------------------------------
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
                        $atributos ['validar'] = 'required';

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

                        $esteCampo = 'vigencia_hidden';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'hidden';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = false;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['valor'] = $_REQUEST['vigencia'];
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 30;
                        $atributos ['maximoTamanno'] = '';
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


                        $sqlConsultaCdpRegistrados = $this->miSql->getCadenaSql("cdpRegistradas", date("Y"));
                        $resultado = $esteRecursoDB->ejecutarAcceso($sqlConsultaCdpRegistrados, "busqueda");

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
        $esteCampo = 'botonAceptar';
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
        $valorCodificado .= "&opcion=registrarNovedad";
        $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $valorCodificado .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
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

