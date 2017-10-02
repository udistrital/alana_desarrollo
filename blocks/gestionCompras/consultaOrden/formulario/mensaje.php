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

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        // -------------------------------------------------------------------------------------------------
        // Limpia Items Tabla temporal
        // $cadenaSql = $this->miSql->getCadenaSql ( 'limpiar_tabla_items' );
        // $resultado_secuancia = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        // $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos); {
            // ---------------- SECCION: Controles del Formulario -----------------------------------------------

            $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

            $directorio = $this->miConfigurador->getVariableConfiguracion("host");
            $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
            $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

            switch ($_REQUEST ['mensaje']) {
                case 'actualizo' :
                    $opcion = "&opcion=modificarOrden";
                    $opcion .= "&id_orden=" . $_REQUEST ['numero_orden'];
                    $opcion .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                    $opcion .= "&arreglo=" . $_REQUEST ['arreglo'];

                    break;

                case 'ActualizoElemento' :

                    $opcion = "&opcion=modificarElementos";
                    $opcion .= "&id_orden=" . $_REQUEST ['id_orden'];
                    $opcion .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                    $opcion .= "&arreglo=" . $_REQUEST ['arreglo'];
                    $opcion .= "&id_elemento_acta=" . $_REQUEST ['id_elemento_acta'];

                    break;
            }

            $variable = "pagina=" . $miPaginaActual;
            if (isset($opcion) == true) {
                $variable .= $opcion;
            }
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

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
            unset($atributos); {

                if ($_REQUEST ['mensaje'] == 'noActualizoElemento') {

                    $mensaje = "<h3>NO SE REALIZO LA ACTUALIZACION DEL ELEMENTO.</h3>";

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
                if ($_REQUEST ['mensaje'] == 'ErrorRegistroSociedadTemporal') {

                    $mensaje = "<h3>NO SE REALIZO LA MODIFICACIÓN DE LA ORDEN. <br> ERROR AL ACTUALIZAR LA INFORMACIÓN DE LAS SOCIEDAD TEMPORAL.</h3>";

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
                if ($_REQUEST ['mensaje'] == 'noActualizoServicio') {

                    $mensaje = "<h3>NO SE REALIZO LA MODIFICACIÓN DEL SERVICIO. <br> VERIFIQUE LA INFORMACIÓN E INTENTE DE NUEVO.</h3>";

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
                if ($_REQUEST ['mensaje'] == 'ActualizoElemento') {

                    $mensaje = "<h3>SE ACTUALIZO EL ELEMENTO DE LA ORDEN.</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'novedaddeModificacion') {

                    $cadenaSqlInfoNovedadModificacion = $this->miSql->getCadenaSql('consultarInfoNovedadModificacion', $_REQUEST['idnovedadModificacion']);
                    $infoNovedadModificacion = $esteRecursoDB->ejecutarAcceso($cadenaSqlInfoNovedadModificacion, "busqueda");
                    $infoNovedadModificacion = $infoNovedadModificacion[0];

                    $mensaje = "Se Actualizo la Información del .<br>Contrato N# " .
                            $_REQUEST ['numero_contrato_suscrito'] . " y  Vigencia " . $_REQUEST ['vigencia'] . "<br><h3> A traves"
                            . " de la Novedad de Modificación Registrada con la Siguiente Informacion:</h3> .<br>"
                            . " ID: " . $infoNovedadModificacion['id'] . "<br>"
                            . " Numero de Acto Administrativo: " . $infoNovedadModificacion['acto_administrativo'] . ""
                            . " Razon: " . $infoNovedadModificacion['razon'] . ".<br>"
                            . " Observaciones: " . $infoNovedadModificacion['descripcion'] . ".<br>"
                            . " Fecha: " . $infoNovedadModificacion['fecha_registro'] . ".<br>"
                            . " Usuario: " . $infoNovedadModificacion['usuario'] . ".<br>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'ActualizoServicio') {

                    $mensaje = "<h3>EL SERVICIO IDENTIFICADO CON NUMERO: " . $_REQUEST['id_servicio'] . ""
                            . " FUE ACTUALIZADO CON ÉXITO.</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'aproboContrato') {

                    $mensaje = "<h3>EL CONTRADO FUE SUSCRITO CON ÉXITO</h3> <br>"
                            . " <h4>CONSECUTIVO DE ELABORACIÓN: " . $_REQUEST['numero_contrato'] . "<br>"
                            . " VIGENCIA: " . $_REQUEST['vigencia'] . "<br>"
                            . " FECHA DE SUSCRIPCIÓN: " . $_REQUEST['fecha_aprobacion'] . "<br>"
                            . " USUARIO QUE REALIZO LA SUSCRIPCIÓN: " . $_REQUEST['usuario'] . "</h4><br>";

                    $mensaje .="<h2> EL ESTADO DEL CONTRATO SE ACTUALIZO (SUSCRITO)  Y <br>"
                            . "EL NUMERO DE CONTRATO UNICO ASIGNADO PARA LA VIGENCIA (" . $_REQUEST['vigencia'] . ") ES:<br> "
                            . "<h1>" . $_REQUEST['numero_contrato_suscrito'] . "</h1> </h2>";


                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = strtoupper($mensaje);

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'noAproboContrato') {

                    $mensaje = "<h3>EL CONTRATO NO FUE SUSCRITO, <br> VERIFIQUE LA INFORMACIÓN E INTENTE DE NUEVO.</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'error';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = strtoupper($mensaje);

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'aproboContratos') {

                    $_REQUEST['datos'] = str_replace("\\", "", $_REQUEST['datos']);
                    $datos = stripslashes($_REQUEST['datos']);
                    $datos = urldecode($datos);
                    $datos = unserialize($datos);

                    $mensaje = "<h2>LOS SIGUIENTES CONTRATOS FUERON SUSCRITOS CON ÉXITO</h2> <br>"
                            . "<h3>A continuación se listan los Contratos Suscritos, el consecutivo de elaboracion, la vigencia <br>"
                            . "y el Numero de Contrato Unico Asignado para la respectiva vigencia.</h3>";

                    for ($j = 0; $j < count($datos) - 1; $j++) {
                        $mensaje .= " <p><h5>CONSECUTIVO DE ELABORACIÓN: <>" . $datos[$j]['numero_contrato'] . ""
                                . " VIGENCIA: " . $datos[$j]['vigencia'] . "</h5>";

                        $mensaje .="<p> EL ESTADO DEL CONTRATO SE ACTUALIZO  Y EL "
                                . " NUMERO UNICO DE CONTRATO ASIGNADO ES: " . $datos[$j]['numero_contrato_suscrito'] . " </p>";
                        if ($j % 3 == 0) {
                            $mensaje .= "<br>";
                        }
                    }

                    $mensaje .= " <br> FECHA DE SUSCRIPCIÓN: " . $datos[count($datos) - 1] . ""
                            . " USUARIO QUE REALIZO LA SUSCRIPCIÓN: " . $_REQUEST['usuario'] . "</p>";
                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = strtoupper($mensaje);

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'noAproboContratos') {

                    $_REQUEST['datos'] = str_replace("\\", "", $_REQUEST['datos']);
                    $datos = stripslashes($_REQUEST['datos']);
                    $datos = urldecode($datos);
                    $datos = unserialize($datos);
                   

                    $mensaje = "<h1>LA TRANSACCION PRESENTO PROBLEMAS, <br> LOS INCONVENIENTES SE REFIEREN A CONTINUACIÓN:</h1>";

                    $mensaje .= "<h2>RESULTADO DE LA OPERACION DE SUSCRIPCIÓN MULTIPLE:</h2> <br>"
                            . "<h3>A continuación se listan los Contratos, y el resultado obtenido con cada uno de ellos:.</h3>";

                    for ($j = 0; $j < count($datos) - 1; $j++) {
                        if (isset($datos[$j]['numero_contrato_suscrito'])) {
                            $mensaje .= " <p><h5>El CONTRATO CON CONSECUTIVO DE ELABORACIÓN: <>" . $datos[$j]['numero_contrato'] . ""
                                    . " VIGENCIA: " . $datos[$j]['vigencia'] . ",<b> FUE SUSCRITO CON EXITO</b>.</h5>";

                            $mensaje .="<p> EL ESTADO DEL CONTRATO SE ACTUALIZO  Y EL "
                                    . " NUMERO UNICO DE CONTRATO ASIGNADO ES: " . $datos[$j]['numero_contrato_suscrito'] . " </p>";
                        } else {
                            $mensaje .= " <p><h5>El CONTRATO CON CONSECUTIVO DE ELABORACIÓN: <>" . $datos[$j]['numero_contrato'] . ""
                                    . " VIGENCIA: " . $datos[$j]['vigencia'] . ", <b>NO FUE SUSCRITO CON EXITO</b>.</h5>";
                        }
                    }


                    $mensaje .= " <br> FECHA DE SUSCRIPCIÓN: " . $datos[count($datos) - 1] . ""
                            . " USUARIO QUE REALIZO LA SUSCRIPCIÓN: " . $_REQUEST['usuario'] . "</p>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'error';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = strtoupper($mensaje);

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'actualizoOrden') {

                    $mensaje = "<h3>SE ACTUALIZO LA ORDEN EXITOSAMENTE. "
                            . "<br>CONSECUTIVO DE ELABORACIÓN: " . $_REQUEST['numero_contrao'] . " <br> VIGENCIA: " . $_REQUEST['vigencia'] . "</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeActualizo';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'noactualizoOrden') {

                    $mensaje = "<h3>NO SE PUDO ACTUALIZAR LA ORDEN EXITOSAMENTE. "
                            . "<br>CONSECUTIVO DE ELABORACIÓN: " . $_REQUEST['numero_contrao'] . " <br> VIGENCIA: " . $_REQUEST['vigencia'] . "</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeActualizo';
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

                if ($_REQUEST ['mensaje'] == 'eliminoElemento') {

                    $mensaje = "<h3>SE ELIMINO EL ELEMENTO DE LA ORDEN.</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'eliminoServicio') {

                    $mensaje = "<h3>SE ELIMINO EXISITOSAMENTE EL SERVICIO DEL CONTRATO.</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }

                if ($_REQUEST ['mensaje'] == 'noeliminoElemento') {

                    $mensaje = "<h3>NO SE PUDO ELIMINAR ELEMENTO DE LA ORDEN.</h3>";

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
                if ($_REQUEST ['mensaje'] == 'noeliminoServicio') {

                    $mensaje = "<h3>NO SE PUDO ELIMINAR EL SERVICIO, VERIFIQUE LOS DATOS E INTENTE DE NUEVO.</h3>";

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

                if ($_REQUEST ['mensaje'] == 'actualizo') {

                    $mensaje = "<h3>SE ACTUALIZO LA " . $_REQUEST ['mensaje_titulo'] . "</h3>";

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'mensajeRegistro';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'success';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = $mensaje;

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }
                if ($_REQUEST ['mensaje'] == 'error') {

                    $mensaje = "<h3>NO SE PUDO ACTUALIZAR LA ORDEN.</h3>";

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

                if (isset($_REQUEST ['errores']) && $_REQUEST ['errores'] == 'notextos') {

                    $mensaje = "<h3>No se Creo Orden de Servicios, No se Colocaron Objeto de Contrato Y/O Forma de Pago.</h3>";

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

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            // -----------------CONTROL: Botón ----------------------------------------------------------------
            $esteCampo = 'botonContinuar';
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

            echo $this->miFormulario->marcoAgrupacion('fin');

            // ---------------- SECCION: División ----------------------------------------------------------
            $esteCampo = 'division1';
            $atributos ['id'] = $esteCampo;
            $atributos ['estilo'] = 'general';
            echo $this->miFormulario->division("inicio", $atributos);

            // ---------------- FIN SECCION: División ----------------------------------------------------------
            echo $this->miFormulario->division('fin');

            // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
            // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
            // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        }

        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
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
        $valorCodificado .= "&opcion=registrarOrden";
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
