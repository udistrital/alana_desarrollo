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
        //-----Esto es una Actualizacion del repositorio 
        // -------------------------------------------------------------------------------------------------
        $conexionContractual = "contractual";
        $DBContractual = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionContractual);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);

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

        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        if ($unidad[0]['unidad_ejecutora'] == 1) {
            $unidadEjecutora = 209;
        } else {
            $unidadEjecutora = 208;
        }

        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Registrar Acta de Inicio: " . $_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);



        $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
        $arreglo = unserialize($_REQUEST ['arreglo']);
        $variable = "pagina=" . $miPaginaActual;
        $variable .= "&opcion=ConsultarContratos";
        $variable .= "&id_contrato=" . $arreglo ['numero\_contrato'] . "-(" . $arreglo ['vigencia'] . ")";
        $variable .= "&clase_contrato=" . $arreglo ['clase\_contrato'];
        $variable .= "&id_contratista=" . $arreglo ['nit'];
        $variable .= "&fecha_inicio_sub=" . $arreglo ['fecha\_inicial'];
        $variable .= "&fecha_final_sub=" . $arreglo ['fecha\_final'];
        $variable .= "&usuario=" . $_REQUEST ['usuario'];
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


//-------- Se toma codigo de consulta de polizas el submodulo de conttratos aprobados del modulo de compras
//--------- Pero como aun no se implmenetan las polizas a nivel contractual se deja comentado para su posterior ajuste

        $datos_contrato = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
        );

        $sqlFechaSuscripcion = $this->miSql->getCadenaSql('obtenerFechadeSuscripcion', $datos_contrato);
        $fechaSuscripcion = $DBContractual->ejecutarAcceso($sqlFechaSuscripcion, "busqueda");

        $esteCampo = 'fecha_inicio_validacion';
        $atributos ["id"] = $esteCampo; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ['valor'] = $fechaSuscripcion[0]['fecha_suscripcion'];
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);


        $cadenaSqlPolizas = $this->miSql->getCadenaSql('obtenerPolizas', $datos_contrato);
        $polizas = $DBContractual->ejecutarAcceso($cadenaSqlPolizas, "busqueda");

        if ($polizas) {


            $esteCampo = "AgrupacionPoliza";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ['leyenda'] = "Gestion de Pólizas";
            echo $this->miFormulario->agrupacion('inicio', $atributos);
            {
                echo "<div class='container'>
    
	<div class='row'>
        <div class='col-md-18'>
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<h3 class='panel-title'>Polizas</h3>
						
					</div>
					<table class='table table-hover' id='dev-table'>
						<thead>
							<tr>
								<th>#</th>
								<th>Numero Poliza</th>
								<th>Entidad Aseguradora</th>
								<th>Fecha Inicio</th>
								<th>Fecha Fin</th>
								<th>Descripcion</th>
								<th>Estado</th>
								<th>Amparos</th>
							</tr>
						</thead>
						<tbody>";
                for ($i = 0; $i < count($polizas); $i++) {

                    $sqlAmparos = $this->miSql->getCadenaSql('obtenerAmparos', $polizas[$i]['id_poliza']);
                    $amparos = $DBContractual->ejecutarAcceso($sqlAmparos, "busqueda");

                    if ($polizas[$i]['estado'] == 't') {
                        $estado = "ACTIVA";
                    } else {
                        $estado = "INACTIVA";
                    }

                    $contador = $i + 1;
                    echo "<tr>
								<td>$contador</td>
								<td>" . $polizas[$i]['numero_poliza'] . "</td>
								<td>" . $polizas[$i]['nombre_aseguradora'] . "</td>
								<td>" . $polizas[$i]['fecha_inicio'] . "</td>
								<td>" . $polizas[$i]['fecha_fin'] . "</td>
								<td>" . $polizas[$i]['descripcion_poliza'] . "</td>
								<td>" . $estado . "</td>";
                    echo "<td><a href='javascript:void(0);' onclick='VerAmparos($i)'>Ver Amparos</a>";

                    echo "<div id='amparodiv$i' style='display:none;'><a href='javascript:void(0);' onclick='CerrarAmparos($i)'>Cerrar</a> 
                                                    <table class='table table-hover' id='dev-table'>
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre Amparo</th>
								<th>Fecha Inicio</th>
								<th>Fecha Fin</th>
								<th>Unidad Amparo</th>
								<th>Tipo Unidad</th>
								<th>Estado</th>
								
							</tr>
						</thead>
						<tbody>";
                    for ($j = 0; $j < count($amparos); $j++) {

                        if ($amparos[$j]['estado'] == 't') {
                            $estadoAmparo = "ACTIVA";
                        } else {
                            $estadoAmparo = "INACTIVA";
                        }
                         if ($amparos[$j]['tipo_valor_amparo'] == '1') {
                            $tipUnidadoAmparo = "Porcentaje (%)";
                        } else {
                            $tipUnidadoAmparo = "SMLV";
                        }

                        $contadorAmparo = $j + 1;
                        echo "<tr>
								<td>$contadorAmparo</td>
								<td>" . $amparos[$j]['nombre_amparo'] . "</td>
								<td>" . $amparos[$j]['fecha_inicio'] . "</td>
								<td>" . $amparos[$j]['fecha_final'] . "</td>
								<td>" . $amparos[$j]['unidad_amparo'] . "</td>
								<td>" . $tipUnidadoAmparo . "</td>
							        <td>" . $estadoAmparo . "</td>";
                        echo "<tr>";
                    }
                    echo "</tbody>
					</table></div>";


                    echo "</td>
							</tr>";
                }
                echo "</tbody>
					</table>
				</div>
			</div>
			</div>
			</div>";
            }
            echo $this->miFormulario->agrupacion('fin');


            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'fecha_inicio_acta';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            // $atributos ["etiquetaObligatorio"] = true;
            $atributos ['columnas'] = 2;
            $atributos ['dobleLinea'] = 0;
            $atributos ['tabIndex'] = $tab;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['validar'] = 'required';

            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 200;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'fecha_final_acta';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            // $atributos ["etiquetaObligatorio"] = true;
            $atributos ['columnas'] = 2;
            $atributos ['dobleLinea'] = 0;
            $atributos ['tabIndex'] = $tab;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['validar'] = 'required';

            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 150;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'observaciones';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            $atributos ["etiquetaObligatorio"] = true;
            $atributos ['columnas'] = 105;
            $atributos ['filas'] = 5;
            $atributos ['dobleLinea'] = 0;
            $atributos ['tabIndex'] = $tab;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['validar'] = 'required, minSize[1],maxSize[250]';
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 10;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 220;
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoTextArea($atributos);
            unset($atributos);

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            // -----------------CONTROL: Botón ----------------------------------------------------------------
            $esteCampo = 'botonRegistrar';
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
        } else {
            $mensaje = "<h3>No Se Encontraron polizas asociadas al contrato numero: " . $_REQUEST['numero_contrato_suscrito'] . " con <br>"
                    . " Vigencia: " . $_REQUEST['vigencia'] . ", No se puede proceder con el Acta de Inicio Mientras no se registren las Debidas Polizas.</h3>";

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
        }
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
        // ---------------------------------------------------------
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
        $valorCodificado .= "&opcion=registrarActaInicio";
        $valorCodificado .= "&usuario=" . $_REQUEST['usuario'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST['numero_contrato'];
        $valorCodificado .= "&numero_contrato_suscrito=" . $_REQUEST['numero_contrato_suscrito'];
        $valorCodificado .= "&vigencia=" . $_REQUEST['vigencia'];

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
