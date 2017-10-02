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
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $conexionCore = "core";
        $DBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

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
        $atributos ["leyenda"] = "Registrar Amparos a la Poliza: " . $_REQUEST['id_poliza'] . " del Contrato " . $_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


        $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
        $variable .= "&opcion=gestionPolizas";
        $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
        $variable .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $variable .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
        $variable .= "&usuario=" . $_REQUEST ['usuario'];
        $variable .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

        $esteCampo = 'botonRegresar';
        $atributos ['id'] = $esteCampo;
        $atributos ['enlace'] = $variable;
        $atributos ['tabIndex'] = 1;
        $atributos ['estilo'] = '';
        $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['ancho'] = '10%';
        $atributos ['alto'] = '10%';
        $atributos ['redirLugar'] = true;
        echo $this->miFormulario->enlace($atributos);

        unset($atributos);


//-------- Se toma codigo de consulta de polizas el submodulo de conttratos aprobados del modulo de compras
//--------- Pero como aun no se implmenetan las polizas a nivel contractual se deja comentado para su posterior ajuste

        $cadenaAmparos = $this->miSql->getCadenaSql("obtenerAmparos", $_REQUEST['id_poliza']);
        $amparos = $esteRecursoDB->ejecutarAcceso($cadenaAmparos, "busqueda");

        $datos_contrato = array('numero_contrato' => $_REQUEST['numero_contrato'], 'vigencia' => $_REQUEST['vigencia']);

        $cadenaValorContato = $this->miSql->getCadenaSql("obtenerValorContrato", $datos_contrato);
        $valorContrato = $esteRecursoDB->ejecutarAcceso($cadenaValorContato, "busqueda");


        $cadenaMinimoVigente = $this->miSql->getCadenaSql("obtenerMinimoVigente", date("Y"));
        $minimoVigente = $esteRecursoDB->ejecutarAcceso($cadenaMinimoVigente, "busqueda");


        $cadenaAmparosParametros = $this->miSql->getCadenaSql("obtenerAmparosParametros");
        $amparosParametros = $DBCore->ejecutarAcceso($cadenaAmparosParametros, "busqueda");


        if ($amparos) {

            echo "<table id='tablaAmparos'>";

            echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Amparo</th>            
                                <th>Unidad Amparo</th>            
                                <th>Tipo de Unidad</th>            
                                <th>Valor</th>            
                                <th>Fecha Inicio</th>            
            			<th>Fecha Fin</th>
            			<th>Estado</th>
                                <th>Modificar Amparo</th>            
            			<th>Cambiar Estado</th>
                            </tr>
            </thead>
            <tbody>";
            $contador = 1;
            foreach ($amparos as $valor) {


                $variableActualizar = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variableActualizar .= "&opcion=editarAmparo";
                $variableActualizar .= "&usuario=" . $_REQUEST['usuario'];
                $variableActualizar .= "&id_amparo=" . $valor ['id'];
                $variableActualizar .= "&id_poliza=" . $valor ['poliza'];
                $variableActualizar .= "&vigencia=" . $_REQUEST ['vigencia'];
                $variableActualizar .= "&tipo_valor_amparo=" . $valor ['tipo_valor_amparo'];
                $variableActualizar .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                $variableActualizar .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                $variableActualizar .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                $variableActualizar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableActualizar, $directorio);

                $variableCambioEstado = "action=" . $esteBloque ["nombre"];
                $variableCambioEstado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variableCambioEstado .= "&bloque=" . $esteBloque ['nombre'];
                $variableCambioEstado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                $variableCambioEstado .= "&opcion=cambiarEstadoAmparo";
                $variableCambioEstado .= "&usuario=" . $_REQUEST['usuario'];
                $variableCambioEstado .= "&id_poliza=" . $_REQUEST ['id_poliza'];
                $variableCambioEstado .= "&id_amparo=" . $valor ['id'];
                $variableCambioEstado .= "&vigencia=" . $_REQUEST ['vigencia'];
                $variableCambioEstado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                $variableCambioEstado .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                $variableCambioEstado .= "&mensaje_titulo=" . $_REQUEST['mensaje_titulo'];
                $variableCambioEstado = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableCambioEstado, $directorio);

                if ($valor ['tipo_valor_amparo'] == '1') {
                    $tipo_unidad = 'Porcentaje(%)';
                    $valor_amparo = number_format(($valor ['unidad_amparo'] * $valorContrato[0][0]) / 100, 2, ",", ".");
                } else {
                    $tipo_unidad = 'Numero de SMLV';
                    $valor_amparo = number_format(($valor ['unidad_amparo'] * $minimoVigente[0][0]), 2, ",", ".");
                }


                $mostrarHtml = "<tr>
                    <td><center>" . $contador . "</center></td>
                    <td><center>" . $valor ['nombre_amparo'] . "</center></td>
                    <td><center>" . $valor ['unidad_amparo'] . "</center></td>
                    <td><center>" . $tipo_unidad . "</center></td>
                    <td><center>" . $valor_amparo . "</center></td>
                    <td><center>" . $valor ['fecha_inicio'] . "</center></td>
                    <td><center>" . $valor ['fecha_final'] . "</center></td>";

                if ($valor["estado"] == 't') {
                    $mostrarHtml .= "<td><center>Activa</center></td>";
                } else {
                    $mostrarHtml .= "<td><center>Inactiva</center></td>";
                }


                $mostrarHtml .= "<td><center><a href='" . $variableActualizar . "'><img src='" . $rutaBloque . "/css/images/edit.png' width='15px'></a></center> </td>
                                 <td><center><a href='" . $variableCambioEstado . "'><img src='" . $rutaBloque . "/css/images/intercambio.png' width='15px'></a></center> </td>
                                
                      
                     </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
                $contador += 1;
            }
            echo "</tbody>";
            echo "</table>";
        } else {

            $mensaje = "No Se Amparos Asociados a la  Poliza del Contrato.";

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

        $datos_contrato = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
        );

        echo "<br><br><br>";
        echo "<center><h3>Seleccione el Tipo de Registro</h3>";

        $esteCampo = "tipo_amparo_registro";
        $atributos ['nombre'] = $esteCampo;
        $atributos ['id'] = $esteCampo;
        $atributos ["etiquetaObligatorio"] = false;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab ++;
        $atributos ['anchoEtiqueta'] = 150;
        $atributos ['evento'] = '';
        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['seleccion'] = -1;
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['columnas'] = 1;
        $atributos ['tamanno'] = 1;
        $atributos ['estilo'] = "jqueryui";
        $atributos ['validar'] = "required";
        $atributos ['limitar'] = false;
        $atributos ['anchoCaja'] = 60;
        $atributos ['miEvento'] = '';

        // Valores a mostrar en el control
        $matrizItems = array(
            array('1', 'REGISTRO DE AMPAROS'),
            array('2', 'REGISTRO DE AMPARO DE RESPONSABILIDAD CIVIL POR MINIMOS')
        );
        $atributos ['matrizItems'] = $matrizItems;
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
        
         echo "</center>";

        $atributos ["id"] = "divisionAmparoCivilporMinimos";
        $atributos = array_merge($atributos, $atributosGlobales);
        $atributos ["estiloEnLinea"] = "display:none";
        echo $this->miFormulario->division("inicio", $atributos);
        unset($atributos);
        {





            echo "<center><h2>Registrar Amparo de Responsabilidad Civil. <br>Valor Salario Minimo Legal Vigente: " . number_format($minimoVigente[0][0], 2, ",", ".") . " Pesos, "
            . "<br> Decreto " . $minimoVigente[0][1] . "</h2></center>";

            $esteCampo = 'numero_minimos';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['columnas'] = 2;
            $atributos ['dobleLinea'] = 0;
            $atributos ['tabIndex'] = $tab;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['validar'] = 'required, custom[number]';

            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 35;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 180;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $esteCampo = 'salario_minimo';
            $atributos ["id"] = $esteCampo; // No cambiar este nombre
            $atributos ["tipo"] = "hidden";
            $atributos ['estilo'] = '';
            $atributos ["obligatorio"] = false;
            $atributos ['marco'] = true;
            $atributos ["etiqueta"] = "";
            $atributos ['valor'] = $minimoVigente[0][0];
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);


            $esteCampo = 'fecha_inicio_amparo';
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
            $atributos ['deshabilitado'] = true;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 213;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);

            $esteCampo = 'valor';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['columnas'] = 2;
            $atributos ['dobleLinea'] = 0;
            $atributos ['tabIndex'] = $tab;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['validar'] = 'required, custom[number]';

            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = true;
            $atributos ['tamanno'] = 35;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 180;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'fecha_final_amparo';
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
            $atributos ['deshabilitado'] = true;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 213;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);

            unset($atributos);
        }
        echo $this->miFormulario->division("fin");




        $atributos ["id"] = "divisionAmparos";
        $atributos = array_merge($atributos, $atributosGlobales);
        $atributos ["estiloEnLinea"] = "display:none";
        echo $this->miFormulario->division("inicio", $atributos);
        {


            echo "<center><h2>Adicionar Nuevos Amparos. <br>Valor Contrato: " . number_format($valorContrato[0][0], 2, ",", ".") . "</h2></center>";

            echo "<div class='container'>
                <div class='row clearfix'>
                        <div class='col-md-20 column'>
                            <table class='table table-bordered table-hover' id='tab_amparos'>
                                	<thead>
                                        	<tr >
                                                	<th class='text-center'>
                                                                	#
                                                        </th>
                                                        <th class='text-center'>
        							Amparo
        						</th>
                					<th class='text-center'>
        							Porcentaje
        						</th>
                					<th class='text-center'>
        							Valor
        						</th>
                					<th class='text-center'>
                        					Fecha Inicial
                                			</th>
                					<th class='text-center'>
                        					Fecha Final
                                			</th>
                                        	</tr>
                                        </thead>
                                        <tbody>
        					<tr id='addr0'>
        						<td>
        						1
        						</td>
        						<td>";
            echo "<select  id='amparo0' name='amparo0'  class='selectpicker  validate[required]'/>";
            echo "<option value=''>Seleccione  ....</option>";
            for ($i = 0; $i < count($amparosParametros); $i++) {
                echo "<option value='" . $amparosParametros[$i]['id'] . "'>" . $amparosParametros[$i]['nombre'] . "</option>";
            }
            echo "</select>";
            echo "</td>
        						<td>
                					<input type='text' id='porcentajeamparo0' name='porcentajeamparo0' placeholder='Porcentaje(%)-> 10%' class='form-control validate[required] custom[number]'/>
                        				</td>
        						<td>
                					<input type='text' id='valoramparo0' name='valoramparo0' placeholder='Valor' class='form-control validate[required] custom[number]' readonly/>
                        				</td>
                                			<td>
                                        		<input type='text' id='fechainiamparo0' name='fechainiamparo0' placeholder='Fecha Inicial' class='form-control validate[required] '/>
                                                	</td>
                                			<td>
                                        		<input type='text' id='fechafinamparo0' name='fechafinamparo0' placeholder='Fecha Final' class='form-control validate[required] '/>
                                                	</td>
                                                </tr>
                                                <tr id='addr1'></tr>
                                        </tbody>
                            </table>
                        </div>
                </div>
	<a id='add_row' class='btn btn-default pull-left'>Nuevo Amparo</a><a id='delete_row' class='pull-right btn btn-default'>Eliminar Amparo</a></div>";


            $esteCampo = 'valor_contrato';
            $atributos ["id"] = $esteCampo; // No cambiar este nombre
            $atributos ["tipo"] = "hidden";
            $atributos ['estilo'] = '';
            $atributos ["obligatorio"] = false;
            $atributos ['marco'] = true;
            $atributos ["etiqueta"] = "";
            $atributos ['valor'] = $valorContrato[0][0];
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $esteCampo = 'amparos_lista';
            $atributos ["id"] = $esteCampo; // No cambiar este nombre
            $atributos ["tipo"] = "hidden";
            $atributos ['estilo'] = '';
            $atributos ["obligatorio"] = false;
            $atributos ['marco'] = true;
            $atributos ["etiqueta"] = "";
            $atributos ['valor'] = json_encode($amparosParametros);
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);
            // ------------------Division para los botones-------------------------


            echo "<input id='amparosOculto' name='amparosOculto' type='hidden' value='" . json_encode($amparosParametros) . "'>";
        }
        echo $this->miFormulario->division("fin");





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
        $valorCodificado .= "&opcion=registraAmparos";
        $valorCodificado .= "&usuario=" . $_REQUEST['usuario'];
        $valorCodificado .= "&id_poliza=" . $_REQUEST ['id_poliza'];
        $valorCodificado .= "&vigencia=" . $_REQUEST ['vigencia'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $valorCodificado .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
        $valorCodificado .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];

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
