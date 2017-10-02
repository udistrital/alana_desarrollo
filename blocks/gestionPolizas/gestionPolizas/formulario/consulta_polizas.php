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

        $_REQUEST ['tiempo'] = time();
        //-----Esto es una Actualizacion del repositorio 
        // -------------------------------------------------------------------------------------------------

        $conexionContractual = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionContractual);


        // Limpia Items Tabla temporal
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


        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        $datos_contrato = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
        );
        $cadenaPolizas = $this->miSql->getCadenaSql("obtenerPolizas", $datos_contrato);
        $polizas = $esteRecursoDB->ejecutarAcceso($cadenaPolizas, "busqueda");


        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------




        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Gestion de Polizas Contractuales " . $_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


        $variableRegresar = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
        $variableRegresar .= "&opcion=ConsultarContratos";
        $variableRegresar .= "&vigencia=" . $_REQUEST ['vigencia'];
        $variableRegresar .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $variableRegresar .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
        $variableRegresar .= "&usuario=" . $_REQUEST ['usuario'];
        $variableRegresar .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
        if (isset($_REQUEST['arreglo'])) {
            $arreglo = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
            $arreglo = unserialize($arreglo);
            $variableRegresar .= "&clase_contrato=" . $arreglo['clase\_contrato'];
            $variableRegresar .= "&id_contrato=" . $arreglo['numero\_contrato'] . "-(" . $arreglo['vigencia'] . ")";
            $variableRegresar .= "&fecha_inicio_sub=" . $arreglo['fecha\_inicial'];
            $variableRegresar .= "&id_contratista=" . $arreglo['nit'];
            $variableRegresar .= "&fecha_final_sub=" . $arreglo['fecha\_final'];
        }

        $variableRegresar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableRegresar, $directorio);


        $esteCampo = 'botonRegresar';
        $atributos ['id'] = $esteCampo;
        $atributos ['enlace'] = $variableRegresar;
        $atributos ['tabIndex'] = 1;
        $atributos ['estilo'] = '';
        $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['ancho'] = '10%';
        $atributos ['alto'] = '10%';
        $atributos ['redirLugar'] = true;
        echo $this->miFormulario->enlace($atributos);


        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón de Registro de Poliza ----------------------------------------------------------------


        $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
        $variable .= "&opcion=registrarPoliza";
        $variable .= "&usuario=" . $_REQUEST ['usuario'];
        $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
        $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
        $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


        echo "<br>";
        echo "<br>";

        $esteCampo = 'registrarPoliza';
        $atributos ['id'] = $esteCampo;
        $atributos ['enlace'] = $variable;
        $atributos ['tabIndex'] = 1;
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['ancho'] = '10%';
        $atributos ['alto'] = '10%';
        $atributos ['redirLugar'] = true;
        echo $this->miFormulario->enlace($atributos);

        unset($atributos);
        echo "<br>";
        echo "<br>";


        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
        // ---------------------------------------------------------
        $contador = 1;

        if ($polizas) {

            echo "<table id='tablaPolizas'>";

            echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Número de la Poliza</th>            
                                <th>Entidad Aseguradora</th>            
                                <th>Descripcion de la Poliza</th>            
            			<th>Fecha de Aprobación</th>
            			<th>Fecha Inicio</th>
            			<th>Fecha Fin</th>
            			<th>Estado</th>
                                <th>Modificar Poliza</th>            
            			<th>Cambiar Estado</th>
            			<th>Gestionar Amparos</th>
                             </tr>
            </thead>
            <tbody>";

            foreach ($polizas as $valor) {


                $variableActualizar = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variableActualizar .= "&opcion=editarPoliza";
                $variableActualizar .= "&usuario=" . $_REQUEST['usuario'];
                $variableActualizar .= "&id_poliza=" . $valor ['id_poliza'];
                $variableActualizar .= "&vigencia=" . $_REQUEST ['vigencia'];
                $variableActualizar .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                $variableActualizar .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                $variableActualizar .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                $variableActualizar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableActualizar, $directorio);

                $variableCambioEstado = "action=" . $esteBloque ["nombre"];
                $variableCambioEstado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variableCambioEstado .= "&bloque=" . $esteBloque ['nombre'];
                $variableCambioEstado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                $variableCambioEstado .= "&opcion=cambiarEstadopoliza";
                $variableCambioEstado .= "&usuario=" . $_REQUEST['usuario'];
                $variableCambioEstado .= "&id_poliza=" . $valor ['id_poliza'];
                $variableCambioEstado .= "&vigencia=" . $_REQUEST ['vigencia'];
                $variableCambioEstado .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variableCambioEstado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                $variableCambioEstado .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                $variableCambioEstado .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                $variableCambioEstado = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableCambioEstado, $directorio);


                $variableAmparos = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variableAmparos .= "&opcion=gestionAmparos";
                $variableAmparos .= "&usuario=" . $_REQUEST['usuario'];
                $variableAmparos .= "&id_poliza=" . $valor ['id_poliza'];
                $variableAmparos .= "&vigencia=" . $_REQUEST ['vigencia'];
                $variableAmparos .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                $variableAmparos .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                $variableAmparos .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                $variableAmparos = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableAmparos, $directorio);

                $mostrarHtml = "<tr>
                    <td><center>" . $contador . "</center></td>
                    <td><center>" . $valor ['numero_poliza'] . "</center></td>
                    <td><center>" . $valor ['nombre_aseguradora'] . "</center></td>
                    <td><center>" . $valor ['descripcion_poliza'] . "</center></td>
                    <td><center>" . $valor ['fecha_aprobacion'] . "</center></td>
                    <td><center>" . $valor ['fecha_inicio'] . "</center></td>
                    <td><center>" . $valor ['fecha_fin'] . "</center></td>";

                if ($valor["estado"] == 't') {
                    $mostrarHtml .= "<td><center>Activa</center></td>";
                } else {
                    $mostrarHtml .= "<td><center>Inactiva</center></td>";
                }


                $mostrarHtml .= "<td><center><a href='" . $variableActualizar . "'><img src='" . $rutaBloque . "/css/images/edit.png' width='15px'></a></center> </td>
                                 <td><center><a href='" . $variableCambioEstado . "'><img src='" . $rutaBloque . "/css/images/intercambio.png' width='15px'></a></center> </td>";

                if ($valor["estado"] == 't') {
                    $mostrarHtml .= "<td><center><a href='" . $variableAmparos . "'><img src='" . $rutaBloque . "/css/images/amparos.png' width='15px'></a></center> </td>";
                } else {
                    $mostrarHtml .= "<td><center>Poliza Inactiva</center></td>";
                }

                $mostrarHtml .= "</tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
                $contador += 1;
            }
        } else {

            $mensaje = "No Se Encontraron Polizas.";

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

        echo "</tbody>";

        echo "</table>";



        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");

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
        $valorCodificado .= "&opcion=ConsultarContratos";
        $valorCodificado .= "&usuario=" . $_REQUEST['usuario'];
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
