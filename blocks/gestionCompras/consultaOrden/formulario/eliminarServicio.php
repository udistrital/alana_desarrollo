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
        $tiempo = $_REQUEST ['tiempo'];

        // lineas para conectar base de d atos-------------------------------------------------------------------------------------------------

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        // ___________________________________________________________________________________
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
        $atributos ['marco'] = false;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos); {

            // ---------------- SECCION: Controles del Formulario -----------------------------------------------
            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = "Eliminar Servicio Numero: " . $_REQUEST ["id_servicio"];
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos); {

                $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

                $directorio = $this->miConfigurador->getVariableConfiguracion("host");
                $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
                $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
                $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
                $arreglo = unserialize($_REQUEST ['arreglo']);

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=consultaElementos";
                $variable .= "&id_contrato=";
                $variable .= "&clase_contrato=";
                $variable .= "&id_contratista=";
                $variable .= "&fecha_inicio_consulta=";
                $variable .= "&fecha_final_consulta=";
                $variable .= "&usuario=";
                $variable .= "&arreglo=";
                $variable .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                $variable .= "&numerocontrato=" . $_REQUEST['numerocontrato'];
                $variable .= "&vigencia=" . $_REQUEST['vigencia'];

                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

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

                $mensaje = "¿ESTÁ SEGURO DE  QUERER ELIMINAR EL SERVICIO CON CODIGO NUMERO " . $_REQUEST ["id_servicio"] . "?";

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
                // --------------- FIN CONTROL : Cuadro de Texto --------------------
                // ------------------Division para los botones-------------------------
                $atributos ["id"] = "botones";
                $atributos ["estilo"] = "marcoBotones";
                echo $this->miFormulario->division("inicio", $atributos);

                // -----------------CONTROL: Botón ----------------------------------------------------------------
                $esteCampo = 'botonEliminarServicio';
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
                // // -----------------CONTROL: Botón ----------------------------------------------------------------
                // $esteCampo = 'botonCancelar';
                // $atributos ["id"] = $esteCampo;
                // $atributos ["tabIndex"] = $tab;
                // $atributos ["tipo"] = 'boton';
                // // submit: no se coloca si se desea un tipo button genérico
                // $atributos ['submit'] = true;
                // $atributos ["estiloBoton"] = 'jqueryui';
                // $atributos ["estiloMarco"] = '';
                // // verificar: true para verificar el formulario antes de pasarlo al servidor.
                // $atributos ["verificar"] = '';
                // $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                // $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
                // $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
                // $tab ++;
                // // Aplica atributos globales al control
                // $atributos = array_merge ( $atributos, $atributosGlobales );
                // echo $this->miFormulario->campoBoton ( $atributos );
                // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
                // Se debe declarar el mismo atributo de marco con que se inició el formulario.
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
            $valorCodificado .= "&opcion=eliminarServicio";
            $valorCodificado .= "&id_servicio=" . $_REQUEST ['id_servicio'];
            $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];

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

            return true;
        }
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
