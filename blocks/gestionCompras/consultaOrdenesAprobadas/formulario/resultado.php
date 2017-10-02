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


        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);

        if (isset($_REQUEST ['id_contrato']) && $_REQUEST ['id_contrato'] != '') {
            $temporal = explode("-", $_REQUEST ['id_contrato']);
            $contrato = $temporal[0];
            $vigencia = substr($temporal[1], 1, -1);
        } else {
            $contrato = "";
            $vigencia = "";
        }

        if (isset($_REQUEST ['clase_contrato']) && $_REQUEST ['clase_contrato'] != '') {
            $clase_contrato = $_REQUEST ['clase_contrato'];
        } else {
            $clase_contrato = '';
        }

        if (isset($_REQUEST ['id_contratista']) && $_REQUEST ['id_contratista'] != '') {
            $contratista = $_REQUEST ['id_contratista'];
        } else {
            $contratista = '';
        }

        if (isset($_REQUEST ['fecha_inicio_consulta']) && $_REQUEST ['fecha_inicio_consulta'] != '') {
            $fecha_inicio = $_REQUEST ['fecha_inicio_consulta'];
        } else {
            $fecha_inicio = '';
        }

        if (isset($_REQUEST ['fecha_final_consulta']) && $_REQUEST ['fecha_final_consulta'] != '') {
            $fecha_final = $_REQUEST ['fecha_final_consulta'];
        } else {
            $fecha_final = '';
        }

        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidadEjecutora = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        $arreglo = array(
            'clase_contrato' => $clase_contrato,
            'numero_contrato' => $contrato,
            'vigencia' => $vigencia,
            'nit' => $contratista,
            'fecha_inicial' => $fecha_inicio,
            'fecha_final' => $fecha_final,
            'unidad_ejecutora' => $unidadEjecutora[0]['unidad_ejecutora'],
            'vigencia_curso' => date("Y")
        );

        $cadenaSql = $this->miSql->getCadenaSql('consultarOrdenGeneral', $arreglo);

        $Orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


        $arreglo = serialize($arreglo);
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

        $variable = "pagina=" . $miPaginaActual;
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Consulta de Ordenes";
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
        unset($atributos);

        if ($Orden) {

            echo "<table id='tablaTitulos'>";
            echo "<thead>
                             <tr>
                                <th>Tipo Orden</th>
                                <th>Número Contrato</th>
                                <th>Vigencia</th>            
            			<th>Identificación<br>Nombre Contratista</th>
                                <th>Sede - Dependencia</th>
                                <th>Fecha de Registro</th>
                                <th>Estado</th>   
                                <th>Consultar Orden</th>
                                <th>Documento Orden<input type='text' name='fuentedocumento' placeholder='Tamaño Fuente' id='fuentedocumento'></th>
                                <th>Acta de Inicio</th>
                                <th>Gestión RPs</th>
                                <th>Cancelar Contrato</th>
				
                             </tr>
                          </thead>
                          <tbody>";

            for ($i = 0; $i < count($Orden); $i ++) {
                $variableConsulta = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variableConsulta .= "&opcion=consultarOrdenDetalle";
                $variableConsulta .= "&numerocontrato=" . $Orden [$i] ['numero_contrato'];
                $variableConsulta .= "&numero_contrato_suscrito=" . $Orden [$i] ['numero_contrato_suscrito'];
                $variableConsulta .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variableConsulta .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variableConsulta .= "&id_contratista=" . $Orden [$i] ['proveedor'];
                $variableConsulta .= "&arreglo=" . $arreglo;
                $variableConsulta .= "&usuario=" . $_REQUEST ['usuario'];
                $variableConsulta .= "&mensaje_titulo= --> Contrato: " . $Orden [$i] ['tipo_contrato'] . " | VIGENCIA: " . $Orden [$i] ['vigencia'] . " | NÚMERO CONTRATO : " . $Orden [$i] ['numero_contrato_suscrito'];
                $variableConsulta = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableConsulta, $directorio);

                $variable_documento = "action=consultaOrden";
                $variable_documento .= "&pagina=consultaOrden";
                $variable_documento .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                $variable_documento .= "&bloque=consultaOrden";

                $variable_documento .= "&opcion=generarDocumento";
                $variable_documento .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_documento .= "&numero_contrato=" . $Orden [$i] ['numero_contrato'];
                $variable_documento .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable_documento .= "&usuario=" . $_REQUEST['usuario'];

                if ($Orden [$i] ['unidad_ejecutora'] == 1) {
                    $variable_documento .= "&opcion=generarDocumento";
                } else {
                    $variable_documento .= "&opcion=generarDocumentoIdexud";
                }
                $variable_documento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_documento, $directorio);



                $documento = "<a href='javascript:void(0);' onclick='GenerarDocumento(" . $Orden [$i] ['vigencia'] . $Orden [$i] ['numero_contrato'] . ");'><img src='" . $rutaBloque . "/css/images/documento.png' width='15px'> </a>";

                $variable_acta_inicio = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable_acta_inicio .= "&opcion=actainicio";
                $variable_acta_inicio .= "&numerocontrato=" . $Orden [$i] ['numero_contrato'];
                $variable_acta_inicio .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_acta_inicio .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable_acta_inicio .= "&arreglo=" . $arreglo;
                $variable_acta_inicio .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_acta_inicio .= "&numero_contrato_suscrito=" . $Orden [$i] ['numero_contrato_suscrito'];
                $variable_acta_inicio .= "&mensaje_titulo= --> Contrato: " . $Orden [$i] ['tipo_contrato'] . " | VIGENCIA: " . $Orden [$i] ['vigencia'] . " | NÚMERO CONTRATO : " . $Orden [$i] ['numero_contrato_suscrito'];

                $variable_acta_inicio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_acta_inicio, $directorio);

                $acta_inicio = "<a href='" . $variable_acta_inicio . "'><img src='" . $rutaBloque . "/css/images/acta_inicio.png' width='15px'></a>";


                $variable_rp = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable_rp .= "&opcion=resgitroRp";
                $variable_rp .= "&numerocontrato=" . $Orden [$i] ['numero_contrato'];
                $variable_rp .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_rp .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable_rp .= "&arreglo=" . $arreglo;
                $variable_rp .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_rp .= "&numero_contrato_suscrito=" . $Orden [$i] ['numero_contrato_suscrito'];
                $variable_rp .= "&mensaje_titulo= --> Contrato: " . $Orden [$i] ['tipo_contrato'] . " | VIGENCIA: " . $Orden [$i] ['vigencia'] . " | NÚMERO CONTRATO : " . $Orden [$i] ['numero_contrato_suscrito'];

                $variable_rp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_rp, $directorio);

                $registro_presupuestal = "<a href='" . $variable_rp . "'><img src='" . $rutaBloque . "/css/images/registro_p.png' width='15px'></a>";


                $variable_cancelar_contrato = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable_cancelar_contrato .= "&opcion=cancelar";
                $variable_cancelar_contrato .= "&numerocontrato=" . $Orden [$i] ['numero_contrato'];
                $variable_cancelar_contrato .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_cancelar_contrato .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable_cancelar_contrato .= "&arreglo=" . $arreglo;
                $variable_cancelar_contrato .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_cancelar_contrato .= "&numero_contrato_suscrito=" . $Orden [$i] ['numero_contrato_suscrito'];
                $variable_cancelar_contrato .= "&mensaje_titulo= --> Contrato: " . $Orden [$i] ['tipo_contrato'] . " | VIGENCIA: " . $Orden [$i] ['vigencia'] . " | NÚMERO CONTRATO : " . $Orden [$i] ['numero_contrato_suscrito'];

                $variable_cancelar_contrato = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_cancelar_contrato, $directorio);

                $cancelar_contrato = "<a href='" . $variable_cancelar_contrato . "'><img src='" . $rutaBloque . "/css/images/cancelar.png' width='15px'></a>";




                $mostrarHtml = "<tr>";
                if ($Orden [$i]["convenio"] == '') {
                    $mostrarHtml .= "<td><center>" . $Orden [$i] ['tipo_contrato'] . "</td>";
                } else {
                    $mostrarHtml .= "<td><center>" . $Orden [$i] ['tipo_contrato'] . "<a href='javascript:void(0);' onclick='VerInfoConvenio(" . $Orden [$i] ['convenio'] . ");'> (Convenio)</a></center></td>";
                }

                $mostrarHtml .= "<td><center>" . $Orden [$i] ['numero_contrato_suscrito'] . "</center></td>		
                                 <td><center>" . $Orden [$i] ['vigencia'] . "</center></td>";
                if ($Orden [$i]["clase_contratista"] == '33') {
                    $mostrarHtml .= "<td><center><a href='javascript:void(0);' onclick='VerInfoContratista(" . $Orden [$i] ['proveedor'] . ");'> Información Contratista</a></center></td>";
                } else {
                    $mostrarHtml .= "<td><center><a href='javascript:void(0);' onclick='VerInfoSociedadTemporal(" . $Orden [$i] ['proveedor'] . ");'> -Información Contratista</a></center></td>";
                }

                $mostrarHtml .="<td><center>" . $Orden [$i] ['sededependencia'] . "</center></td>";

                $mostrarHtml .= "<td><center>" . $Orden [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $Orden [$i] ['nombre_estado'] . "</center></td>
                                <td><center>
                                    <a href='" . $variableConsulta . "'>
                                        <img src='" . $rutaBloque . "/css/images/consulta.png' width='15px'>
                                    </a>
                                </center> </td>
                		<td><center>" . $documento . "</center> </td>";

                $mostrarHtml .= "<td><center>" . $acta_inicio . "</center> </td>";

                $mostrarHtml .= "<td><center>" . $registro_presupuestal . "</center> </td>";

                $mostrarHtml .="<td><center>" . $cancelar_contrato . "</center> </td>         		
                              		
                                </tr>";
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

            // Fin de Conjunto de Controles
            // echo $this->miFormulario->marcoAgrupacion("fin");
        } else {

            $mensaje = "No Se Encontraron<br>Ordenes.";

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
