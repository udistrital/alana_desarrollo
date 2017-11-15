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

            if (isset($_REQUEST ['unidad_ejecutora_consulta']) && $_REQUEST ['unidad_ejecutora_consulta'] != '') {
                $unidad_ejecutora = $_REQUEST ['unidad_ejecutora_consulta'];
            } else {
                $unidad_ejecutora = '';
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


            if (isset($_REQUEST ['fecha_inicio_sub']) && $_REQUEST ['fecha_inicio_sub'] != '') {
                $fecha_inicio = $_REQUEST ['fecha_inicio_sub'];
            } else {
                $fecha_inicio = '';
            }

            if (isset($_REQUEST ['fecha_final_sub']) && $_REQUEST ['fecha_final_sub'] != '') {
                $fecha_final = $_REQUEST ['fecha_final_sub'];
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


            $cadenaSql = $this->miSql->getCadenaSql('consultarContratosGeneral', $arreglo);
            $contratos = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        }


        $arreglo = serialize($arreglo);


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
        $atributos ["leyenda"] = "Contratos Suscritos";
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

        if ($contratos) {

            echo "<table id='tablaContratosAprobados'>";

            echo "<thead>
                             <tr>
                                <th><center>Vigencia</center></th>
                                <th><center>Número Contrato</center></th>            
                                <th><center>Tipo Contrato</center></th>            
                                <th><center>Contratista</center></th>
                                <th><center>Fecha Registro</center></th>
                                <th><center>Fecha Aprobado</center></th>
                                <th><center>Estado</center></th>
                                <th><center>Consultar Contrato</center></th>
                                <th><center>Acta de Inicio</center></th>
                                <th><center>Gestion RPs</center></th>
                                <th><center>Cancelar Contrato</center></th>
                                <th><center>Documento<input type='text' name='fuentedocumento' placeholder='Tamaño Fuente' id='fuentedocumento'></th>
                             </tr>
            </thead>
            <tbody>";

            foreach ($contratos as $valor) {
                $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable .= "&opcion=consultarContrato";
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&mensaje_titulo= --> Contrato: " . $valor ['tipo_contrato'] . " | VIGENCIA: " . $valor ['vigencia'] . " | NÚMERO CONTRATO : " . $valor ['numero_contrato_suscrito'];
                $variable .= "&arreglo=" . $arreglo;
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&tiempo=" . $_REQUEST['tiempo'];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



                $variable_acta_inicio = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variable_acta_inicio .= "&opcion=actainicio";
                $variable_acta_inicio .= "&vigencia=" . $valor ['vigencia'];
                $variable_acta_inicio .= "&arreglo=" . $arreglo;
                $variable_acta_inicio .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable_acta_inicio .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable_acta_inicio .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_acta_inicio .= "&mensaje_titulo= --> Contrato: " . $valor ['tipo_contrato'] . " | VIGENCIA: " . $valor ['vigencia'] . " | NÚMERO CONTRATO : " . $valor ['numero_contrato_suscrito'];
                $variable_acta_inicio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_acta_inicio, $directorio);

                $acta_inicio = "<a href='" . $variable_acta_inicio . "'><img src='" . $rutaBloque . "/css/images/acta_inicio.png' width='15px'></a>";

                $variable_rp = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable_rp .= "&opcion=resgitroRp";
                $variable_rp .= "&numerocontrato=" . $valor['numero_contrato'];
                $variable_rp .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable_rp .= "&vigencia=" . $valor ['vigencia'];
                $variable_rp .= "&arreglo=" . $arreglo;
                $variable_rp .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_rp .= "&mensaje_titulo= --> Contrato: " . $valor ['tipo_contrato'] . " | VIGENCIA: " . $valor ['vigencia'] . " | NÚMERO CONTRATO : " . $valor ['numero_contrato_suscrito'];

                $variable_rp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_rp, $directorio);

                $registro_presupuestal = "<a href='" . $variable_rp . "'><img src='" . $rutaBloque . "/css/images/registro_p.png' width='15px'></a>";



                $variable_cancelar_contrato = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable_cancelar_contrato .= "&opcion=cancelar";
                $variable_cancelar_contrato .= "&numerocontrato=" . $valor ['numero_contrato'];
                $variable_cancelar_contrato .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable_cancelar_contrato .= "&vigencia=" . $valor ['vigencia'];
                $variable_cancelar_contrato .= "&arreglo=" . $arreglo;
                $variable_cancelar_contrato .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_cancelar_contrato .= "&mensaje_titulo= --> Contrato: " . $valor ['tipo_contrato'] . " | VIGENCIA: " . $valor ['vigencia'] . " | NÚMERO CONTRATO : " . $valor ['numero_contrato_suscrito'];

                $variable_cancelar_contrato = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_cancelar_contrato, $directorio);

                $cancelar_contrato = "<a href='" . $variable_cancelar_contrato . "'><img src='" . $rutaBloque . "/css/images/cancelar.png' width='15px'></a>";


                $variable_documento = "action=modificarContrato";
                $variable_documento .= "&pagina=modificarContrato";
                $variable_documento .= "&bloque=modificarContrato";
                $variable_documento .= "&bloqueGrupo=gestionContractual/contratos/";
                $variable_documento .= "&opcion=generarDocumento";
                $variable_documento .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable_documento .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable_documento .= "&vigencia=" . $valor ['vigencia'];
                $variable_documento .= "&usuario=" . $_REQUEST['usuario'];
                $variable_documento .= "&tipo_contrato=" . $valor ['tipo_contrato'];
                $variable_documento .= "&unidad=" . $unidadEjecutora[0]['unidad_ejecutora'];
                $variable_documento .= "&opcion=generarDocumento";

                $variable_documento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_documento, $directorio);

                $documento = "<a href='javascript:void(0);' onclick='GenerarDocumento(" . $valor ['vigencia'] . $valor ['numero_contrato'] . ");'><img src='" . $rutaBloque . "/css/images/documento.png' width='15px'> </a>";


                $mostrarHtml = "<tr>
                    <td><center>" . $valor ['vigencia'] . "</center></td>
                    <td><center>" . $valor ['numero_contrato_suscrito'] . "</center></td>";
                if ($valor["convenio"] == '') {
                    $mostrarHtml .= "<td><center>" . $valor['tipo_contrato'] . "</td>";
                } else {
                    $mostrarHtml .= "<td><center>" . $valor ['tipo_contrato'] . "<a href='javascript:void(0);' onclick='VerInfoConvenio(" . $valor ['convenio'] . ");'> (Convenio)</a></center></td>";
                }
                if ($valor["clase_contratista"] == '33') {
                    $mostrarHtml .= "<td><center><a href='javascript:void(0);' onclick='VerInfoContratista(" . $valor ['proveedor'] . ");'> Información Contratista</a></center></td>";
                } else {
                    $mostrarHtml .= "<td><center><a href='javascript:void(0);' onclick='VerInfoSociedadTemporal(" . $valor ['proveedor'] . ");'> Información Contratista</a></center></td>";
                }
                $mostrarHtml .="
                    <td><center>" . $valor ['fecha_registro'] . "</center></td>";
                 $mostrarHtml .="
                    <td><center>" . $valor ['fecha_suscripcion'] . "</center></td>";
                $mostrarHtml .="
                    <td><center>" . $valor ['nombre_estado'] . "</center></td>
                    <td><center>
                    	<a href='" . $variable . "'>
                            <img src='" . $rutaBloque . "/css/images/consulta.png' width='15px'>
                        </a>
                  	</center> </td>";

                $mostrarHtml .= "<td><center>" . $acta_inicio . "</center> </td>";

                $mostrarHtml .= "<td><center>" . $registro_presupuestal . "</center> </td>";


                $mostrarHtml .="<td><center>" . $cancelar_contrato . "</center> </td> 
                               <td><center>" . $documento . "</center> </td>      
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
        } else {

            $mensaje = "No Se Encontraron Contratos<br>Verifique los Parametros de Busqueda";

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
