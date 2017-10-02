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

        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

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

        /*
         * PROCESAR VARIABLES DE CONSULTA
         */ {

            $conexion = "contractual";
            $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

            $conexion = "agora";
            $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

            if (isset($_REQUEST ['identificacion_sociedad']) && $_REQUEST ['identificacion_sociedad'] != '') {
                $identificacion_sociedad = explode("-", $_REQUEST ['identificacion_sociedad'])[0];
            } else {
                $identificacion_sociedad = "";
            }

            if (isset($_REQUEST ['tipo_sociedad']) && $_REQUEST ['tipo_sociedad'] != '') {
                $tipo_sociedad = $_REQUEST ['tipo_sociedad'];
            } else {
                $tipo_sociedad = '';
            }

            if (isset($_REQUEST ['fecha_inicio']) && $_REQUEST ['fecha_inicio'] != '') {
                $fecha_inicio = $_REQUEST ['fecha_inicio'];
            } else {
                $fecha_inicio = '';
            }

            if (isset($_REQUEST ['fecha_final']) && $_REQUEST ['fecha_final'] != '') {
                $fecha_final = $_REQUEST ['fecha_final'];
            } else {
                $fecha_final = '';
            }
            $arreglo_filtros = array(
                'identificacionsociedad' => $identificacion_sociedad,
                'tiposociedad' => $tipo_sociedad,
                'fechainicio' => $fecha_inicio,
                'fechafinal' => $fecha_final,
            );

            $cadenaSql = $this->miSql->getCadenaSql('consultarSociedadesTemporal', $arreglo_filtros);


            $sociedades = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
        }

        $arreglo = serialize($arreglo_filtros);



        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

        $variable = "pagina=" . $miPaginaActual;
        $variable .= "&usuario=" . $_REQUEST ['usuario'];
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Sociedades Temporales";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

        $variable = "pagina=" . $miPaginaActual;
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
        echo "<br>";



        $variable_registrar = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
        $variable_registrar .= "&opcion=registrarSociedad";
        $variable_registrar .= "&arreglo=" . $arreglo;
        $variable_registrar .= "&mensaje_titulo= Registrar Nueva Sociedad Temporal";
        $variable_registrar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_registrar, $directorio);


        echo "<br>";
        echo "<br>";
        echo "<center>";

        $esteCampo = 'registrarSociedad';
        $atributos ['id'] = $esteCampo;
        $atributos ['enlace'] = $variable_registrar;
        $atributos ['tabIndex'] = 1;
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['ancho'] = '10%';
        $atributos ['alto'] = '10%';
        $atributos ['redirLugar'] = true;
        echo $this->miFormulario->enlace($atributos);

        unset($atributos);
        echo "</center>";
        echo "<br>";
        echo "<br>";

        if ($sociedades) {

            echo "<table id='tablaSociedadesTemporales'>";

            echo "<thead>
                             <tr>
                                <th align='center' scope='row'><center>Tipo Sociedad</center></th>
                                <th align='center' scope='row'><center>Identifiación Sociedad<center><c/enter></th>            
                                <th align='center' scope='row'><center>Nombre Sociedad<center></center></th>            
            			<th align='center' scope='row'><center>Digito Verificación</center></th>
                                <th align='center' scope='row'><center>Fecha Registro</center></th>            
            			<th align='center' scope='row'><center>Estado</center></th>
            			<th align='center' scope='row'><center>Consultar</center></th>
            			<th align='center' scope='row'><center>Modificar</center></th>
                                <th align='center' scope='row'><center>Inactivar</center></th>
                             </tr>
            </thead>
            <tbody>";

            foreach ($sociedades as $valor) {

                $variable_modificar = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variable_modificar .= "&opcion=modificarSociedad";
                $variable_modificar .= "&arreglo=" . $arreglo;
                $variable_modificar .= "&id_sociedad=" . $valor ['id_sociedad'];
                $variable_modificar .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_modificar .= "&mensaje_titulo= --> Modificar Sociedad Temporal: " . $valor ['tipopersona'] . " | Documento: " . $valor ['num_documento'] . " | NOMBRE : " . $valor ['nom_proveedor'];
                $variable_modificar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_modificar, $directorio);

                $modificar_sociedad = "<a href='" . $variable_modificar . "'><img src='" . $rutaBloque . "/css/images/edit.png' width='15px'></a>";
               
                $variable_consultar = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variable_consultar .= "&opcion=consultarSociedad";
                $variable_consultar .= "&arreglo=" . $arreglo;
                $variable_consultar .= "&id_sociedad=" . $valor ['id_sociedad'];
                $variable_consultar .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_consultar .= "&mensaje_titulo= --> Consultar Sociedad Temporal: " . $valor ['tipopersona'] . " | Documento: " . $valor ['num_documento'] . " | NOMBRE : " . $valor ['nom_proveedor'];
                $variable_consultar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_consultar, $directorio);

                $consultar_sociedad = "<a href='" . $variable_consultar . "'><img src='" . $rutaBloque . "/css/images/consulta.png' width='15px'></a>";


                $variable_inactivar = "action=" . $esteBloque ["nombre"];
                $variable_inactivar .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variable_inactivar .= "&bloque=" . $esteBloque ['nombre'];
                $variable_inactivar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                $variable_inactivar .= "&opcion=inactivarSociedad";
                $variable_inactivar .= "&id_sociedad=" . $valor ['id_sociedad'];
                $variable_inactivar .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_inactivar .= "&arreglo=" . $arreglo;
                $variable_inactivar .= "&mensaje_titulo= --> Cambio Estado Sociedad Temporal: " . $valor ['tipopersona'] . " | Documento: " . $valor ['num_documento'] . " | NOMBRE : " . $valor ['nom_proveedor'];
                $variable_inactivar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_inactivar, $directorio);

                $inactivar_sociedad = "<a href='" . $variable_inactivar . "'><img src='" . $rutaBloque . "/css/images/intercambio.png' width='15px'></a>";

                if($valor ['estado']=='t'){
                    $estado = "ACTIVA";
                }else{
                    $estado = "INACTIVA";
                }

                $mostrarHtml = "<tr class='bg-info'>
                    <td><center>" . $valor ['tipopersona'] . "</center></td>
                    <td><center>" . $valor ['num_documento'] . "</center></td>
                    <td><center>" . $valor ['nom_proveedor'] . "</center></td>
                    <td><center>" . $valor ['digito_verificacion'] . "</center></td>
                    <td><center>" . $valor ['fecha_registro'] . "</center></td>
                    <td><center>" . $estado . "</center></td>
                    <td><center>" . $consultar_sociedad . "</center> </td>
                    <td><center>" . $modificar_sociedad . "</center> </td>
                    <td><center>" . $inactivar_sociedad . "</center> </td>";


                $mostrarHtml .="</tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";


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
            unset($atributos);
        } else {

            $mensaje = "No Se Encontraron Sociedades Temporales <br>Verifique los Parametros de Busqueda";

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

        echo $this->miFormulario->marcoAgrupacion('fin');

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

        $valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&opcion=aprobarContratoMultiple";
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
