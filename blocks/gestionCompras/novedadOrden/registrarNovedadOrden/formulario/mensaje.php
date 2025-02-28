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
        $_REQUEST ['tiempo'] = time();

        $atributosGlobales ['campoSeguro'] = 'true';

        // -------------------------------------------------------------------------------------------------
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

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

            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&usuario=" . $_REQUEST ['usuario'];
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

            // // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            // $esteCampo = 'botonRegresar';
            // $atributos ['id'] = $esteCampo;
            // $atributos ['enlace'] = $variable;
            // $atributos ['tabIndex'] = 1;
            // $atributos ['estilo'] = 'textoSubtitulo';
            // $atributos ['enlaceTexto'] = $this->lenguaje->getCadena ( $esteCampo );
            // $atributos ['ancho'] = '10%';
            // $atributos ['alto'] = '10%';
            // $atributos ['redirLugar'] = true;
            // echo $this->miFormulario->enlace ( $atributos );
            // unset ( $atributos );

            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            {
                $cadenaSqlTipoNovedad = $this->miSql->getCadenaSql('consultarTipoNovedad', $_REQUEST['tipo_novedad']);
                $Novedad = $esteRecursoDB->ejecutarAcceso($cadenaSqlTipoNovedad, "busqueda");

                switch ($_REQUEST ['mensaje']) {

                    case "ErrorSeleccionNovedad" :

                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2>SE DEBE SELECCIONAR UNA NOVEDAD PARA CONTINUAR CON EL PROCESO, INTENTE DE NUEVO. </h2> ";

                        break;

                    case "Inserto" :

                        $atributos ['tipo'] = 'success';
                        $atributos ['mensaje'] = "<h2>SE REGISTRO LA NOVEDAD CON EXITO: </h2> "
                                . "<h4><br> Contrato Numero:" . $_REQUEST ['numero_contrato_suscrito'] . ". "
                                . "<br> Vigencia: " . $_REQUEST ['vigencia'] . "."
                                . "<br> Novedad: " . $Novedad[0][0] . "."
                                . "<br> Numero de Acto Administrativo: " . $_REQUEST ['acto_administrativo'] . "."
                                . "<br> Usuario: " . $_REQUEST ['usuario'] . ".</h4>";

                        break;

                    case "noInserto" :
                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2> Error al Registrar la Novedad.<br>Verifique los Datos.</h2> "
                                . "<h4><br> Contrato Numero:" . $_REQUEST ['numero_contrato_suscrito'] . ". "
                                . "<br> Vigencia: " . $_REQUEST ['vigencia'] . "."
                                . "<br> Novedad: " . $Novedad[0][0] . "."
                                . "<br> Usuario: " . $_REQUEST ['usuario'] . ".</h4>";
                        break;
                    case "actualizo" :

                        $cadenaSqlTipoNovedad = $this->miSql->getCadenaSql('consultarTipoNovedad', $_REQUEST['tipo_novedad']);
                        $Novedad = $esteRecursoDB->ejecutarAcceso($cadenaSqlTipoNovedad, "busqueda");

                        $cadenaSqlInfoNovedadModificacion = $this->miSql->getCadenaSql('consultarInfoNovedadModificacion', $_REQUEST['idnovedadModificacion']);
                        $infoNovedadModificacion = $esteRecursoDB->ejecutarAcceso($cadenaSqlInfoNovedadModificacion, "busqueda");
                        $infoNovedadModificacion = $infoNovedadModificacion[0];

                        $atributos ['tipo'] = 'success';
                        $atributos ['mensaje'] = "<h3>LA NOVEDAD DE MODIFICACION FUE REGISTRADA CON EXITO:  <br> "
                                . "Numero Acto Administrativo: " . $infoNovedadModificacion['acto_administrativo'] . "<br>"
                                . "Razon: " . $infoNovedadModificacion['razon'] . "<br>"
                                . "Usuario: " . $infoNovedadModificacion['usuario'] . "<br>"
                                . "Id Novedad Asociada y Modificada: " . $infoNovedadModificacion['novedad'] . "<br></h3>" .
                                "<h2>SE ACTUALIZO LA NOVEDAD: </h2> "
                                . "<h4><br> Contrato Numero:" . $_REQUEST ['numero_contrato_suscrito'] . ". "
                                . "<br> Vigencia: " . $_REQUEST ['vigencia'] . "."
                                . "<br> Novedad: " . $Novedad[0][0] . "."
                                . "<br> Numero de Acto Administrativo: " . $_REQUEST ['acto_administrativo'] . "."
                                . "<br> Usuario: " . $_REQUEST ['usuario'] . ".</h4>";

                        break;


                    case "ErrorActualizo" :
                        $cadenaSqlTipoNovedad = $this->miSql->getCadenaSql('consultarTipoNovedad', $_REQUEST['tipo_novedad']);
                        $Novedad = $esteRecursoDB->ejecutarAcceso($cadenaSqlTipoNovedad, "busqueda");

                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2> Error al Actualizar la Novedad.<br>Verifique los Datos.</h2> "
                                . "<h4><br> Contrato Numero:" . $_REQUEST ['numero_contrato_suscrito'] . ". "
                                . "<br> Vigencia: " . $_REQUEST ['vigencia'] . "."
                                . "<br> Novedad: " . $Novedad[0][0] . "."
                                . "<br> Usuario: " . $_REQUEST ['usuario'] . ".</h4>";
                        break;


                    case "errorVigencia" :
                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2> Error al Actualizar la Novedad.<br>La Vigencia del CDP Asociado al OTRO SI de Presupuesto"
                                . "<br> debe ser del año en curso y la vigecia seleccionara es: " . $_REQUEST['vigencia_novedad'] . ".</h2> "
                                . "<h4><br> Contrato Numero:" . $_REQUEST ['numero_contrato_suscrito'] . ". "
                                . "<br> Vigencia: " . $_REQUEST ['vigencia'] . "."
                                . "<br> Novedad: " . $Novedad[0][0] . "."
                                . "<br> Usuario: " . $_REQUEST ['usuario'] . ".</h4>";
                        break;

                    case "rebasaOtroSI" :

                        $valorTotal = $_REQUEST ['valor_adicion'] + $_REQUEST ['acumulado'];
                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2> Error al Registrar la Novedad de Adición."
                                . "<br>RECUERDE:</h2> "
                                . "<h3> La adición de presupuesto a un contrato no puede superar, "
                                . "el 50% del valor inicial del contrato, ni en una sola adición "
                                . "ni en el acumulado de las que se realizen. </h3>"
                                . "<h4>"
                                . "<br> Al Contrato Numero: " . $_REQUEST ['numero_contrato_suscrito'] . " con Vigencia: " . $_REQUEST ['vigencia'] . "<br>"
                                . " Se le esta realizando una Adición por el Siguiente Valor: <br>"
                                . "Valor Adición: " . number_format($_REQUEST ['valor_adicion'], 2, ",", ".") . "<br>"
                                . "El Valor Acumulado en Adiciones de Presupuesto es: <br> " . number_format($_REQUEST ['acumulado'], 2, ",", ".") . "</h4>"
                                . "El Valor del Contrato es: " . number_format($_REQUEST ['valor_contrado'], 2, ",", ".") . " <br>  Por ende el valor tope de Adición por presupuesto "
                                . "es: " . number_format($_REQUEST ['valor_tope'], 2, ",", ".") . "   <br>"
                                . "Teniendo en cuenta que el valor que se trata de Adicionar es :  " . number_format($_REQUEST ['valor_adicion'], 2, ",", ".") . "<br></h4>"
                                . "El valor acumulado mas esta nueva adición da como resultado: " . number_format($valorTotal, 2, ",", ".") . "<br>"
                                . "Valor que SOBREPASA el valor tope de adiciones. "
                                . " Ajuste los valores de adición y repita el proceso.";

                        break;

                    case "rebasaReduccion" :
                        
                        $valorTotal = $_REQUEST ['valor_reduccion'] + $_REQUEST ['acumulado'];
                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2> Error al Registrar la Novedad de Reduccion."
                                . "<br>RECUERDE:</h2> "
                                . "<h3> La reduccion de presupuesto a un contrato no puede superar, "
                                . "el 50% del valor inicial del contrato, ni en una sola adición "
                                . "ni en el acumulado de las que se realizen. </h3>"
                                . "<h4>"
                                . "<br> Al Contrato Numero: " . $_REQUEST ['numero_contrato_suscrito'] . " con Vigencia: " . $_REQUEST ['vigencia'] . "<br>"
                                . " Se le esta realizando una Reduccion por el Siguiente Valor: <br>"
                                . "Valor Reduccion: " . number_format($_REQUEST ['valor_reduccion'], 2, ",", ".") . "<br>"
                                . "El Valor Acumulado en Reducciones de Presupuesto es: <br> " . number_format($_REQUEST ['acumulado'], 2, ",", ".") . "</h4>"
                                . "El Valor del Registro Presupuestal del Contrato es: " . number_format($_REQUEST ['valor_rp'], 2, ",", ".") . " <br>  Por ende el valor tope de Reduccion por presupuesto "
                                . "es: " . number_format($_REQUEST ['valor_tope'], 2, ",", ".") . "   <br>"
                                . "Teniendo en cuenta que el valor que se trata de Reducir es :  " . number_format($_REQUEST ['valor_reduccion'], 2, ",", ".") . "<br></h4>"
                                . "El valor acumulado mas esta nueva reduccion da como resultado: " . number_format($valorTotal, 2, ",", ".") . "<br>"
                                . "Valor que SOBREPASA el valor tope de Reduccion. "
                                . " Ajuste los valores de Reduccion y repita el proceso.";

                        break;

                    case "rebasaOtroSitiempo" :

                        $valorTotal = $_REQUEST ['acumuladoNovedades'] + $_REQUEST ['valor_adicion'];
                        $atributos ['tipo'] = 'error';
                        $atributos ['mensaje'] = "<h2> Error al Registrar la Novedad de Adición."
                                . "<br>RECUERDE:</h2> "
                                . "<h3> La adición de tiempo a un contrato no puede superar, "
                                . "el 50% del plazo de ejecución del contrato, ni en una sola adición "
                                . "ni en el acumulado de las que se realizen. </h3>"
                                . "<h4>"
                                . "<br> Al Contrato Numero: " . $_REQUEST ['numero_contrato_suscrito'] . " con Vigencia: " . $_REQUEST ['vigencia'] . "<br>"
                                . " Se le esta realizando una Adición de tiempo por el Siguiente Valor: <br>"
                                . "Valor Adición: " . $_REQUEST ['valor_adicion'] . " Dia(s).<br>"
                                . "El Valor Acumulado en Adiciones de Tiempo es de:  <br> " . $_REQUEST ['acumuladoNovedades'] . " Dia(s).</h4>"
                                . "El tiempo de ejecución del Contrato es de: " . $_REQUEST ['tiempo_contrato'] . " Dia(s).<br>  Por ende el valor tope de Adición de Tiempo "
                                . "es: " . $_REQUEST ['valor_tope'] . "    Dia(s).<br>"
                                . "Teniendo en cuenta que el valor que se trata de Adicionar es de:  " . $_REQUEST ['valor_adicion'] . " Dia(s).<br></h4>"
                                . "El valor acumulado mas esta nueva adición da como resultado: " . $valorTotal . " Dia(s).<br>"
                                . "Valor que SOBREPASA el valor tope de adiciones de Tiempo. "
                                . " Ajuste los valores de adición y repita el proceso.";

                        break;
                }

                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'mensajeRegistro';
                $atributos ['id'] = $esteCampo;
                $atributos ['estilo'] = 'textoCentrar';

                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->cuadroMensaje($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
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

        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=paginaPrincipal";
        $valorCodificado .= "&usuario=" . $_REQUEST['usuario'];
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
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
