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

        // var_dump ( $_REQUEST );
        // exit ();
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];

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

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

        $datos = array(
            $_REQUEST['numerocontrato'],
            $_REQUEST['vigencia']
        );


        $cadenaSql = $this->miSql->getCadenaSql('consultarElementosOrden', $datos);
        $ElementosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");



        $cadenaSqlServicios = $this->miSql->getCadenaSql('consultarServiciosOrden', $datos);
        $ServiciosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSqlServicios, "busqueda");



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

        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');
        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

       
        $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
        $arreglo = unserialize($_REQUEST ['arreglo']);
        foreach ($arreglo as $clave => $valor) {
            $clave = str_replace("\\", "", $clave);
            $arreglo[$clave] = $clave;
            $arreglo[$clave] = $valor;
        }
        $variable = "pagina=" . $miPaginaActual;
        $variable .= "&opcion=ConsultarContratos";
        $variable .= "&id_contrato=" . $arreglo ['numero_contrato'] . "-(" . $arreglo ['vigencia'] . ")";
        $variable .= "&clase_contrato=" . $arreglo ['clase_contrato'];
        $variable .= "&id_contratista=" . $arreglo ['nit'];
        $variable .= "&fecha_inicio_sub=" . $arreglo ['fecha_inicial'];
        $variable .= "&fecha_final_sub=" . $arreglo ['fecha_final'];
        $variable .= "&usuario=" . $_REQUEST ['usuario'];
        $variable .= "&arreglo=";
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "ELEMENTOS O SERVICIOS " . $_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);

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

        if ($ElementosOrden) {

            echo "<center><h3>Elementos Asociados al Contrato</h3></center>";

            echo "<table id='tablaElmentos'>";

            echo "<thead>
                             <tr>
                                <th>Nivel<br>Inventarios</th>
                    		<th>Tipo de Bien</th>            
            			<th>Descripción</th>
                                <th>Cantidad</th>
                                 <th>Valor($)</th>
                                <th>Iva Aplicado</th>
                                <th>Dependencia</th>
                                <th>Funcionario</th>
			        <th>Modificar</th>
                                <th>Eliminar</th>
                             </tr>
                             </thead>
                                <tbody>";

            for ($i = 0; $i < count($ElementosOrden); $i ++) {




                $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable .= "&opcion=modificarElementos";
                $variable .= "&id_elemento_acta=" . $ElementosOrden [$i] ['id_elemento_ac'];
                $variable .= "&arreglo=" . $_REQUEST ['arreglo'];
                $variable .= "&vigencia=" . $_REQUEST['vigencia'];
                $variable .= "&numerocontrato=" . $_REQUEST['numerocontrato'];
                $variable .= "&usuario=" . $_REQUEST['usuario'];
                $variable .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                $variable1 = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable1 .= "&opcion=eliminarElementos";
                $variable1 .= "&id_elemento_acta=" . $ElementosOrden [$i] ['id_elemento_ac'];
                $variable1 .= "&arreglo=" . $_REQUEST ['arreglo'];
                $variable1 .= "&vigencia=" . $_REQUEST['vigencia'];
                $variable1 .= "&numerocontrato=" . $_REQUEST['numerocontrato'];
                $variable1 .= "&usuario=" . $_REQUEST['usuario'];
                $variable1 .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                $variable1 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable1, $directorio);

                $mostrarHtml = "<tr>
                    <td><center>" . $ElementosOrden [$i] ['nivel_nombre'] . "</center></td>
                    <td><center>" . $ElementosOrden [$i] ['nombre_tipo'] . "</center></td>		
                    <td><center>" . $ElementosOrden [$i] ['descripcion'] . "</center></td>
                    <td><center>" . $ElementosOrden [$i] ['cantidad'] . "</center></td>
                    <td><center>" . $ElementosOrden [$i] ['valor'] . "</center></td>
                    <td><center>" . $ElementosOrden [$i] ['nombre_iva'] . "</center></td>
                    <td><center>" . $ElementosOrden [$i] ['ESF_DEP_ENCARGADA'] . "</center></td>
                    <td><center>" . $ElementosOrden [$i] ['funcionario'] . "</center></td>
                    <td><center>
                    	<a href='" . $variable . "'>
                            <img src='" . $rutaBloque . "/css/images/edit.png' width='15px'>
                        </a>
                  	</center> </td>
                    <td><center>
                    
                    	<a href='" . $variable1 . "'>
                            <img src='" . $rutaBloque . "/css/images/delete.png' width='15px'>
                        </a>
                  	</center> </td>
           
                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";
        } else {

            $mensaje = "No Se Encontraron<br>Elementos Asociados al Contrato";

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


        if ($ServiciosOrden) {

            echo "<center><h3>Servicios Asociados al Contrato</h3></center>";
            echo "<table id='tablaServicios'>";

            echo "<thead>
                             <tr>
                                <th>Numeracion</th>
                    		<th>Servicio</th>
                                <th>Nombre del Servicio (Resumen)</th>
                                <th>Descripcion del Servicio</th>
                                <th>Fecha de Registro</th>
                                <th>Modificar</th>
                                <th>Eliminar</th>
                             </tr>
                             </thead>
                                <tbody>";

            for ($i = 0; $i < count($ServiciosOrden); $i ++) {
                $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable .= "&opcion=modificarServicios";
                $variable .= "&id_servicio=" . $ServiciosOrden [$i] ['id'];
                $variable .= "&arreglo=" . $_REQUEST ['arreglo'];
                $variable .= "&usuario=" . $_REQUEST['usuario'];
                $variable .= "&numerocontrato=" . $_REQUEST['numerocontrato'];
                $variable .= "&vigencia=" . $_REQUEST['vigencia'];
                $variable .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                $variable1 = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable1 .= "&opcion=eliminarServicio";
                $variable1 .= "&id_servicio=" . $ServiciosOrden [$i] ['id'];
                $variable1 .= "&arreglo=" . $_REQUEST ['arreglo'];
                $variable1 .= "&usuario=" . $_REQUEST['usuario'];
                $variable1 .= "&numerocontrato=" . $_REQUEST['numerocontrato'];
                $variable1.= "&vigencia=" . $_REQUEST['vigencia'];
                $variable1 .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                $variable1 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable1, $directorio);

                $mostrarHtml = "<tr>
                    <td><center>" . $i . "</center></td>
                    <td><center>" . $ServiciosOrden [$i] ['codigo_ciiu'] . "</center></td>		
                    <td><center>" . $ServiciosOrden [$i] ['nombre'] . "</center></td>		
                    <td><center>" . $ServiciosOrden [$i] ['descripcion'] . "</center></td>
                    <td><center>" . $ServiciosOrden [$i] ['fecha_registro'] . "</center></td>
                                       
                    <td><center>
                    	<a href='" . $variable . "'>
                            <img src='" . $rutaBloque . "/css/images/edit.png' width='15px'>
                        </a>
                  	</center> </td>
                    <td><center>
                    
                    	<a href='" . $variable1 . "'>
                            <img src='" . $rutaBloque . "/css/images/delete.png' width='15px'>
                        </a>
                  	</center> </td>
           
                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";

            // Fin de Conjunto de Controles
            // echo $this->miFormulario->marcoAgrupacion("fin");
        } else {

            $mensaje = "No Se Encontraron<br>Servidos Asociados al Contrato";

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

        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=regresar";
        $valorCodificado .= "&redireccionar=regresar";
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
