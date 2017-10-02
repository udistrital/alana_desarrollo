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

                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'registroSociedad') {


                    $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                    $_REQUEST['arreglo'] = unserialize($_REQUEST['arreglo']);
                    $arreglo = $_REQUEST['arreglo'];


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=ConsultarSociedades";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&identificacion_sociedad=" . $arreglo ['identificacionsociedad'];
                    $variable .= "&tipo_sociedad=" . $arreglo ['tiposociedad'];
                    $variable .= "&fecha_inicio=" . $arreglo ['fechainicio'];
                    $variable .= "&fecha_final=" . $arreglo ['fechafinal'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



                    $mensaje = "SE REGISTRO LA SOCIEDAD: " . $_REQUEST['nom_proveedor'] . " EXITOSAMENTE, "
                            . " TIPO DE SOCIEDAD: " . $_REQUEST['tipopersona'] . "  , DATOS:  <br> "
                            . "  <b>IDENTIFICACION: </b>" . $_REQUEST['num_documento'] . "<br> "
                            . "  <b>USUARIO: </b>" . $_REQUEST['usuario'] . " <br>"
                            . "  <b>FECHA: </b>" . date("Y") . ". ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noregistroSociedad') {

                    $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                    $_REQUEST['arreglo'] = unserialize($_REQUEST['arreglo']);
                    $arreglo = $_REQUEST['arreglo'];


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=ConsultarSociedades";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&identificacion_sociedad=" . $arreglo ['identificacionsociedad'];
                    $variable .= "&tipo_sociedad=" . $arreglo ['tiposociedad'];
                    $variable .= "&fecha_inicio=" . $arreglo ['fechainicio'];
                    $variable .= "&fecha_final=" . $arreglo ['fechafinal'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



                    $mensaje = "NO SE REGISTRO LA SOCIEDAD TEMPORAL, DATOS:  <br> "
                            . "  <b>NOMBRE SOCIEDAD: </b>" . $_REQUEST['nom_proveedor'] . "<br> "
                            . "  <b>TIP DE SOCIEDAD: </b>" . $_REQUEST['tipopersona'] . "<br> "
                            . "  <b>IDENTIFIACIÓN: </b>" . $_REQUEST['num_documento'] . "<br> "
                            . "  <b>USUARIO: </b>" . $_REQUEST['usuario'] . "<br> "
                            . "  <b>FECHA: </b>" . date("Y") . ". ";
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

                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'actualizoSociedad') {

                    $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                    $_REQUEST['arreglo'] = unserialize($_REQUEST['arreglo']);
                    $arreglo = $_REQUEST['arreglo'];


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=ConsultarSociedades";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&identificacion_sociedad=" . $arreglo ['identificacionsociedad'];
                    $variable .= "&tipo_sociedad=" . $arreglo ['tiposociedad'];
                    $variable .= "&fecha_inicio=" . $arreglo ['fechainicio'];
                    $variable .= "&fecha_final=" . $arreglo ['fechafinal'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



                    $mensaje = "SE ACTUALIZO LA SOCIEDAD: " . $_REQUEST['nom_proveedor'] . " EXITOSAMENTE, "
                            . " TIPO DE SOCIEDAD: " . $_REQUEST['tipopersona'] . "  , DATOS:  <br> "
                            . "  <b>IDENTIFICACION: </b>" . $_REQUEST['num_documento'] . "<br> "
                            . "  <b>USUARIO: </b>" . $_REQUEST['usuario'] . " <br>"
                            . "  <b>FECHA: </b>" . date("Y") . ". ";

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
                if (isset($_REQUEST ['mensaje']) && $_REQUEST ['mensaje'] == 'noActualizoSociedad') {

                    $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                    $_REQUEST['arreglo'] = unserialize($_REQUEST['arreglo']);
                    $arreglo = $_REQUEST['arreglo'];


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=ConsultarSociedades";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&identificacion_sociedad=" . $arreglo ['identificacionsociedad'];
                    $variable .= "&tipo_sociedad=" . $arreglo ['tiposociedad'];
                    $variable .= "&fecha_inicio=" . $arreglo ['fechainicio'];
                    $variable .= "&fecha_final=" . $arreglo ['fechafinal'];
                    $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                    $mensaje = "NO SE ACTUALIZO LA SOCIEDAD TEMPORAL, DATOS:  <br> "
                            . "  <b>NOMBRE SOCIEDAD: </b>" . $_REQUEST['nom_proveedor'] . "<br> "
                            . "  <b>TIP DE SOCIEDAD: </b>" . $_REQUEST['tipopersona'] . "<br> "
                            . "  <b>IDENTIFIACIÓN: </b>" . $_REQUEST['num_documento'] . "<br> "
                            . "  <b>USUARIO: </b>" . $_REQUEST['usuario'] . "<br> "
                            . "  <b>FECHA: </b>" . date("Y") . ". ";
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

                    $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                    $_REQUEST['arreglo'] = unserialize($_REQUEST['arreglo']);
                    $arreglo = $_REQUEST['arreglo'];


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=ConsultarSociedades";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&identificacion_sociedad=" . $arreglo ['identificacionsociedad'];
                    $variable .= "&tipo_sociedad=" . $arreglo ['tiposociedad'];
                    $variable .= "&fecha_inicio=" . $arreglo ['fechainicio'];
                    $variable .= "&fecha_final=" . $arreglo ['fechafinal'];
                   
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                    if ($_REQUEST['estadoNuevo'] == 't') {
                        $estadoNuevo = "ACTIVA";
                        $estadoAnterior = "INACTIVA";
                    } else {
                        $estadoNuevo = "INACTIVA";
                        $estadoAnterior = "ACTIVA";
                    }
                 

                    $mensaje = "SE ACTUALIZO EL ESTADO DE LA SOCIEDAD: ". $_REQUEST['nom_proveedor']." <br>"
                            . " CON IDENTIFICACIÓN: ".$_REQUEST['num_documento']." - TIPO SOCIEDAD: ".$_REQUEST['tipopersona']."<br>"
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

                    $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                    $_REQUEST['arreglo'] = unserialize($_REQUEST['arreglo']);
                    $arreglo = $_REQUEST['arreglo'];


                    $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                    $variable .= "&opcion=ConsultarSociedades";
                    $variable .= "&usuario=" . $_REQUEST ['usuario'];
                    $variable .= "&identificacion_sociedad=" . $arreglo ['identificacionsociedad'];
                    $variable .= "&tipo_sociedad=" . $arreglo ['tiposociedad'];
                    $variable .= "&fecha_inicio=" . $arreglo ['fechainicio'];
                    $variable .= "&fecha_final=" . $arreglo ['fechafinal'];
                  
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


                     $mensaje = "NO SE ACTUALIZO EL ESTADO DE LA SOCIEDAD :". $_REQUEST['nom_proveedor']." <br>"
                            . " CON IDENTIFICACIÓN : ".$_REQUEST['num_documento']." - TIPO SOCIEDAD: ".$_REQUEST['tipopersona']."<br>"
                            . "ASOCIADA AL CONTRATO NUMERO: " . $_REQUEST['numero_contrato_suscrito'] . " CON VIGENCIA: " . $_REQUEST['vigencia'] . " "
                            . "<br>   DE <h4>$estadoAnterior</h4> a <h4>$estadoNuevo</h4> CON EXITÓ. ";

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
