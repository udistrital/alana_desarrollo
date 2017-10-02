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
        echo $this->miFormulario->formulario($atributos);
        {
            // ---------------- SECCION: Controles del Formulario -----------------------------------------------

            $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

            $directorio = $this->miConfigurador->getVariableConfiguracion("host");
            $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
            $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

            $conexionContractual = "contractual";
            $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionContractual);
            $conexionCore = "core";
            $DBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            {



                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'cambioEstadoAmparo') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionAmparos";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    $cadenaObtenerNombre = $this->miSql->getCadenaSql("obtenerNombreAmparo", $_REQUEST['id_amparo']);
                    $nombreAmparo = $DBCore->ejecutarAcceso($cadenaObtenerNombre, "busqueda");

                    if ($_REQUEST['estadoNuevo'] == 't') {
                        $estadoNuevo = "ACTIVO";
                        $estadoAnterior = "INACTIVO";
                    } else {
                        $estadoNuevo = "INACTIVO";
                        $estadoAnterior = "ACTIVO";
                    }
                    $nombre = $_REQUEST['nombrePoliza'];

                    $mensaje = "SE ACTUALIZO EL ESTADO DEL AMPARO: " . $nombreAmparo[0][0] . " <br> "
                            . "ASOCIADO A LA POLIZA: " . $_REQUEST['id_poliza'] . " DEL CONTRATO NUMERO: " .
                            $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA: " . $_REQUEST['vigencia'] . " "
                            . "<br>   DE <h4>$estadoAnterior</h4> a <h4>$estadoNuevo</h4> CON EXITÓ. ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noCambioEstadoAmparo') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionAmparos";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    $cadenaObtenerNombre = $this->miSql->getCadenaSql("obtenerNombreAmparo", $_REQUEST['amparo']);
                    $nombreAmparo = $DBCore->ejecutarAcceso($cadenaObtenerNombre, "busqueda");

                    $nombre = $nombreAmparo[0][0];
                    $mensaje = "NO SE PUDO CAMBIAR EL ESTADO DE LA POLIZA: $nombre  <br> <h4>$estadoAnterior</h4> a <h4>$estadoNuevo</h4>. ERROR, VERIFIQUE E INTENTE DE NUEVO.";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'cambioEstado') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionPolizas";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                    if ($_REQUEST['estadoNuevo'] == 't') {
                        $estadoNuevo = "ACTIVA";
                        $estadoAnterior = "INACTIVA";
                    } else {
                        $estadoNuevo = "INACTIVA";
                        $estadoAnterior = "ACTIVA";
                    }
                    $numero = $_REQUEST['numero_poliza'];

                    $mensaje = "SE ACTUALIZO EL ESTADO DE LA POLIZA NUMERO: $numero <br> "
                            . "ASOCIADA AL CONTRATO NUMERO: " . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA: " . $_REQUEST['vigencia'] . " "
                            . "<br>   DE <h4>$estadoAnterior</h4> a <h4>$estadoNuevo</h4> CON EXITÓ. ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noCambioEstado') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionPolizas";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                    $numero = $_REQUEST['numero_poliza'];
                    $mensaje = "NO SE PUDO CAMBIAR EL ESTADO DE LA POLIZA NUMERO: $numero  <br> <h4>$estadoAnterior</h4> a <h4>$estadoNuevo</h4>. ERROR, VERIFIQUE E INTENTE DE NUEVO.";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'registroPoliza') {


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionPolizas";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



                    $mensaje = "SE REGISTRO LA POLIZA AL CONTRATO " . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA"
                            . " " . $_REQUEST['vigencia'] . "  EXITOSAMENTE, DATOS:  <br> "
                            . "  <b>IDENTIFICACOR:</b>" . $_REQUEST['id_poliza'] . "<br> "
                            . "  <b>NUMERO DE LA POLIZA:</b>" . $_REQUEST['numero_poliza'] . "<br> "
                            . "  <b>DESCRIPCION:</b>" . $_REQUEST['descripcion'] . "<br> "
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . " <br>"
                            . "  <b>FECHA:</b>" . date("Y") . ". ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noregistroPoliza') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionPolizas";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    $mensaje = "NO SE REGISTRO LA POLIZA, DATOS:  <br> "
                            . "  <b>NUMERO DE LA POLIZA:</b>" . $_REQUEST['numero_poliza'] . "<br> "
                            . "  <b>DESCRIPCION:</b>" . $_REQUEST['descripcion'] . "<br> "
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . "<br> "
                            . "  <b>FECHA:</b>" . date("Y") . ". ";
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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'actualizarPoliza') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionPolizas";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    $mensaje = "SE ACTUALIZO LA POLIZA DEL CONTRATO " . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA "
                            . "  " . $_REQUEST['vigencia'] . "  EXITOSAMENTE, DATOS:  <br> "
                            . "  <b>IDENTIFICACOR:</b>" . $_REQUEST['id_poliza'] . "<br> "
                            . "  <b>NUMERO DE LA POLIZA:</b>" . $_REQUEST['numero_poliza'] . "<br> "
                            . "  <b>DESCRIPCION:</b>" . $_REQUEST['descripcion'] . "<br> "
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . " <br>"
                            . "  <b>FECHA:</b>" . date("Y") . ". ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noactualizarPoliza') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionPolizas";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                    $mensaje = "NO SE ACTUALIZO LA POLIZA, DATOS:  <br> "
                            . "  <b>IDENTIFICACOR:</b>" . $_REQUEST['id_poliza'] . "<br> "
                            . "  <b>NUMERO DE LA POLIZA:</b>" . $_REQUEST['numero_poliza'] . "<br> "
                            . "  <b>DESCRIPCION:</b>" . $_REQUEST['descripcion'] . "<br> "
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . "<br> "
                            . "  <b>FECHA:</b>" . date("Y") . ". ";
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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'actualizarAmparo') {


                    $datos_contrato = array('numero_contrato' => $_REQUEST['numero_contrato'], 'vigencia' => $_REQUEST['vigencia']);

                    $cadenaValorContato = $this->miSql->getCadenaSql("obtenerValorContrato", $datos_contrato);
                    $valorContrato = $esteRecursoDB->ejecutarAcceso($cadenaValorContato, "busqueda");
                    $valorContrato = $valorContrato[0][0];
                    
                      $cadenaMinimoVigente = $this->miSql->getCadenaSql("obtenerMinimoVigente", date("Y"));
                    $minimoVigente = $esteRecursoDB->ejecutarAcceso($cadenaMinimoVigente, "busqueda");

                    $cadenaObtenerNombre = $this->miSql->getCadenaSql("obtenerNombreAmparo", $_REQUEST['amparo']);
                    $nombreAmparo = $DBCore->ejecutarAcceso($cadenaObtenerNombre, "busqueda");

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionAmparos";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    if ($_REQUEST['tipo_unidad'] == '1') {
                        $valorAmparo = "VALOR AMPARO</b>: " . number_format(($_REQUEST['unidad_amparo'] * $valorContrato) / 100, 2, ",", ".");
                    } else {
                        $valorAmparo = "VALOR AMPARO</b>: " . number_format($_REQUEST['unidad_amparo']*$minimoVigente[0][0], 2, ",", ".");
                    }

                    $mensaje = "SE ACTUALIZO EL AMPARO NUMERO: " . $_REQUEST['id_amparo'] . " ASOCIADO"
                            . " A LA POLIZA NUMERO: " . $_REQUEST['id_poliza'] . "  DEL CONTRATO " . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA "
                            . "  " . $_REQUEST['vigencia'] . "  EXITOSAMENTE, DATOS:  <br> "
                            . "  <b>AMPARO:</b>" . $nombreAmparo[0][0] . "<br> "
                            . "  <b>" . $valorAmparo . "<br> "
                            . "  <b>FECHA INICIO:</b>" . $_REQUEST['fecha_inicio'] . "<br> "
                            . "  <b>FECHA FINAL:</b>" . $_REQUEST['fecha_final'] . " <br>"
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . " <br>"
                            . "  <b>FECHA:</b>" . date("Y") . ". ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noactualizarAmparo') {
                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionAmparos";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    $mensaje = "NO SE ACTUALIZO EL AMPARO NUMERO: " . $_REQUEST['id_amparo'] . " ASOCIADO"
                            . " A LA POLIZA NUMERO: " . $_REQUEST['id_poliza'] . "  DEL CONTRATO " . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA "
                            . "  " . $_REQUEST['vigencia'] . ", DATOS:  <br> "
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . " <br>"
                            . "  <b>FECHA:</b>" . date("Y") . ". ";
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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'registroAmparos') {




                    $_REQUEST['datos'] = str_replace("\\", "", $_REQUEST['datos']);
                    $datos = stripslashes($_REQUEST['datos']);
                    $datos = urldecode($datos);
                    $datos = unserialize($datos);

                    $datos_contrato = array('numero_contrato' => $_REQUEST['numero_contrato'], 'vigencia' => $_REQUEST['vigencia']);
                    $cadenaValorContato = $this->miSql->getCadenaSql("obtenerValorContrato", $datos_contrato);
                    $valorContrato = $esteRecursoDB->ejecutarAcceso($cadenaValorContato, "busqueda");


                    $valorContrato = $valorContrato[0][0];

                    $cadenaMinimoVigente = $this->miSql->getCadenaSql("obtenerMinimoVigente", date("Y"));
                    $minimoVigente = $esteRecursoDB->ejecutarAcceso($cadenaMinimoVigente, "busqueda");


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionAmparos";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                    if ($_REQUEST['tipo_amparo_registro'] == '1') {

                        $mensaje = "<h3>SE REGISTRARON EXITOSAMENTE LOS AMPAROS A LA POLIZA: " . $_REQUEST['id_poliza'] . " DEL CONTRATO "
                                . "" . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA " . $_REQUEST['vigencia'] . ",  <br>FECHA: " . date("Y-m-d") . ". </h3> ";

                        $mensajeInfo = "<br> <h4>Información Amparos Registrados <br><br> ";

                        for ($i = 0; $i < count($datos) - 1; $i++) {
                            $cadenaObtenerNombre = $this->miSql->getCadenaSql("obtenerNombreAmparo", $datos[$i]['amparo']);
                            $nombreAmparo = $DBCore->ejecutarAcceso($cadenaObtenerNombre, "busqueda");
                            $valorAmparo = ($datos[$i]['unidad_amparo'] * $valorContrato) / 100;
                            $mensajeInfo .= " <p>AMPARO: " . $nombreAmparo[0][0] . "| PORCENTAJE AMPARADO: " . $datos[$i]['unidad_amparo'] . "% | VALOR AMPARADO: " . number_format($valorAmparo, 2, ",", ".") . " | FECHA INCIO DEL AMPARO: " . $datos[$i]['fecha_inicio'] . " | FECHA FINAL DEL AMPARO: " . $datos[$i]['fecha_final'] . " </p>";
                        }

                        $mensajeInfo .= "</h4>";
                    } else {

                        $mensaje = "<h3>SE REGISTRO EXITOSAMENTE EL AMPARO DE RESPONSABILIDAD CIVIL A LA POLIZA: " . $_REQUEST['id_poliza'] . " DEL CONTRATO "
                                . "" . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA " . $_REQUEST['vigencia'] . ",  <br>FECHA: " . date("Y-m-d") . ". </h3> ";

                        $cadenaObtenerNombre = $this->miSql->getCadenaSql("obtenerNombreAmparo", $datos[0]['amparo']);
                        $nombreAmparo = $DBCore->ejecutarAcceso($cadenaObtenerNombre, "busqueda");
                        $valorAmparo = ($datos[0]['unidad_amparo'] * $minimoVigente[0][0]);
                        $mensajeInfo = "<br> <h4>Información del Amparo Registrado <br><br> ";
                        $mensajeInfo .= " <p>AMPARO: " . $nombreAmparo[0][0] . "| NUMERO DE SMLV: " . $datos[0]['unidad_amparo'] . " | VALOR AMPARADO: " . number_format($valorAmparo, 2, ",", ".") . " | FECHA INCIO DEL AMPARO: " . $datos[0]['fecha_inicio'] . " | FECHA FINAL DEL AMPARO: " . $datos[0]['fecha_final'] . " </p>";
                    }

                    $esteCampo = 'mensajeInfoAmparos';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['tipo'] = 'information';
                    $atributos ['estilo'] = 'textoCentrar';
                    $atributos ['mensaje'] = strtoupper($mensajeInfo);

                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);

                    $mensaje .= $this->miFormulario->cuadroMensaje($atributos);

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noRegistroAmparos') {

                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=gestionAmparos";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
                    $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                    $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                    $variable .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                    $mensaje = "NO SE REGISTRARON LOS AMPAROS, DATOS:  <br> "
                            . "  <b>USUARIO:</b>" . $_REQUEST['usuario'] . "<br> "
                            . "  <b>FECHA:</b>" . date("Y") . ". ";
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
            $atributos ['id'] = $esteCampo;
            $atributos ['enlace'] = $variable;
            $atributos ['tabIndex'] = 1;
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['ancho'] = '10%';
            $atributos ['alto'] = '10%';
            $atributos ['redirLugar'] = true;
            echo $this->miFormulario->enlace($atributos);
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
