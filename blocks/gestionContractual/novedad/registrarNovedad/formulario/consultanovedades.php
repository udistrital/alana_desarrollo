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
        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);
        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);


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



        if (isset($_REQUEST['gestionContratosATC']) && $_REQUEST['gestionContratosATC'] == "true") {

            $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
            $arreglo = unserialize($_REQUEST['arreglo']);

            $variable = "pagina=gestionContratosATC";
            $variable .= "&opcion=ConsultarContratos";
            $variable .= "&fecha_inicial=" . $arreglo['fecha\_inicial'];
            $variable .= "&fecha_final=" . $arreglo['fecha\_final'];
            $variable .= "&unidad_ejecutora=" . $arreglo['unidad\_ejecutora'];
            $variable .= "&estado=" . $arreglo['estado'];
            $variable .= "&vigencia=" . $arreglo['vigencia'];
            $variable .= "&tipo_contrato=" . $arreglo['tipo'];
        } else {

            $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
            $arreglo = unserialize($_REQUEST['arreglo']);

            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=consultar";
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=consultar";
            $variable .= "&id_contrato=" . $arreglo ['numero\_contrato'] . "-(" . $arreglo ['vigencia'] . ")";
            $variable .= "&clase_contrato=" . $arreglo ['clase\_contrato'];
            $variable .= "&id_contratista=" . $arreglo ['nit'];
            $variable .= "&fecha_inicio_consulta=" . $arreglo ['fecha\_inicial'];
            $variable .= "&fecha_final_consulta=" . $arreglo ['fecha\_final'];
        }

        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/gestionContractual/novedad/" . $esteBloque ['nombre'] . "/archivoSoporte/";




        //Consultas Base de Datos Novedades-----------------------------------------------------

        $datosContrato = array(
            0 => $_REQUEST['numero_contrato'],
            1 => $_REQUEST['vigencia']
        );

        $sqlAdicionesPresupuesto = $this->miSql->getCadenaSql('consultarAdcionesPresupuesto', $datosContrato);
        $adicionesPresupuesto = $esteRecursoDB->ejecutarAcceso($sqlAdicionesPresupuesto, "busqueda");

        $sqlAdicionesTiempo = $this->miSql->getCadenaSql('consultarAdcionesTiempo', $datosContrato);
        $adicionesTiempo = $esteRecursoDB->ejecutarAcceso($sqlAdicionesTiempo, "busqueda");

        $sqlAdicionesAnulaciones = $this->miSql->getCadenaSql('consultarAnulaciones', $datosContrato);
        $anulaciones = $esteRecursoDB->ejecutarAcceso($sqlAdicionesAnulaciones, "busqueda");

        $sqlAdicionesSuspension = $this->miSql->getCadenaSql('consultarSuspensiones', $datosContrato);
        $suspensiones = $esteRecursoDB->ejecutarAcceso($sqlAdicionesSuspension, "busqueda");

        $sqlCesiones = $this->miSql->getCadenaSql('consultaCesiones', $datosContrato);
        $cesiones = $esteRecursoDB->ejecutarAcceso($sqlCesiones, "busqueda");

        $sqlCambiosSupervisor = $this->miSql->getCadenaSql('ConsultacambioSupervisor', $datosContrato);
        $cambioSupervisor = $esteRecursoDB->ejecutarAcceso($sqlCambiosSupervisor, "busqueda");

        $sqlReducciones = $this->miSql->getCadenaSql('ConsultaReducciones', $datosContrato);
        $reducciones = $esteRecursoDB->ejecutarAcceso($sqlReducciones, "busqueda");

        $sqlOtras = $this->miSql->getCadenaSql('ConsultaOtras', $datosContrato);
        $otras = $esteRecursoDB->ejecutarAcceso($sqlOtras, "busqueda");





        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Consulta de Novedades " . $_REQUEST['mensaje_titulo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        {

//         var_dump($adicionesTiempo);
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

            echo "<br>";
            echo "<br>";
            echo "<br>";

            $atributos ["id"] = "ventanaA";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                echo "<h3>Adiciones</h3><section>";

                echo "<center><h4>ADICIONES EN PRESUPUESTO</h4></center>";

                if ($adicionesPresupuesto) {






                    echo "<table id='tablaAdicionPresupuesto'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Estado</th>            
            			<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Numero Solicitud</th>
                                <th>Numero CDP</th>
                                <th>Valor Adición</th>
                                <th>Descripcion</th>
                                <th>Documento OtroSi</th>
                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    $totalAddicionPresupuesto = 0;
                    for ($i = 0; $i < count($adicionesPresupuesto); $i ++) {
                        $numerador = $i + 1;
                        if ($adicionesPresupuesto [$i] ['estado'] == 't') {
                            $estado = "Activa";
                        } else {
                            $estado = "Inactiva";
                        }

                        $totalAddicionPresupuesto += $adicionesPresupuesto [$i] ['valor_presupuesto'];

                        $variableDocumentoOtroSi = "action=" . $esteBloque ["nombre"];
                        $variableDocumentoOtroSi .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                        $variableDocumentoOtroSi .= "&bloque=" . $esteBloque ['nombre'];
                        $variableDocumentoOtroSi .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                        $variableDocumentoOtroSi .= "&opcion=generarDocumentoOtroSI";
                        $variableDocumentoOtroSi .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
                        $variableDocumentoOtroSi .= "&numero_contrato_suscrito=" . $_REQUEST ['numero_contrato_suscrito'];
                        $variableDocumentoOtroSi .= "&vigencia=" . $_REQUEST['vigencia'];
                        $variableDocumentoOtroSi .= "&idotroSi=" . $adicionesPresupuesto[$i] ['id'];
                        $variableDocumentoOtroSi .= "&numeracionOtrosi=" . $i;
                        $variableDocumentoOtroSi .= "&usuario=" . $_REQUEST ['usuario'];
                        $variableDocumentoOtroSi = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableDocumentoOtroSi, $directorio);


                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $adicionesPresupuesto [$i] ['numero_contrato'] . " - " . $adicionesPresupuesto [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $estado . "</center></td>		
                                <td><center>" . $adicionesPresupuesto [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $adicionesPresupuesto [$i] ['usuario'] . "</center></td>
                                <td><center>" . $adicionesPresupuesto [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $adicionesPresupuesto [$i] ['numero_solicitud'] . "</center></td>
                                <td><center>" . $adicionesPresupuesto [$i] ['numero_cdp'] . "</center></td>
                                <td><center>" . number_format($adicionesPresupuesto [$i] ['valor_presupuesto'], 2, ",", ".") . "</center></td>
                                <td><center>" . $adicionesPresupuesto [$i] ['descripcion'] . "</center></td>
                               <td><center>
                                    <a href='" . $variableDocumentoOtroSi . "'>
                                        <img src='" . $rutaBloque . "/css/images/documento.png' width='15px'>
                                    </a>
                                </center> </td>
                              
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";
                    echo "<center><p><h5>TOTAL ADICIONES = " . number_format($totalAddicionPresupuesto, 2, ",", ".") . "<p></h5></center>";
                    echo "<br>";
                } else {

                    $mensaje = "El contrato  numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta novedades de Adicion en Presupuesto.";

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

                echo "<center><h4>ADICIONES EN TIEMPO</h4></center>";

                if ($adicionesTiempo) {

                    echo "<table id='tablaAdicionTiempo'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Estado</th>            
            			<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Unidad de Tiempo</th>
                                <th>Valor Tiempo</th>
                                <th>Descripcion</th>
                               
                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    for ($i = 0; $i < count($adicionesTiempo); $i ++) {
                        $numerador = $i + 1;
                        if ($adicionesTiempo [$i] ['estado'] == 't') {
                            $estado = "Activa";
                        } else {
                            $estado = "Inactiva";
                        }




                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $adicionesTiempo [$i] ['numero_contrato'] . " - " . $adicionesTiempo [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $estado . "</center></td>		
                                <td><center>" . $adicionesTiempo [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $adicionesTiempo [$i] ['usuario'] . "</center></td>
                                <td><center>" . $adicionesTiempo [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $adicionesTiempo [$i] ['unidad_tiempo_ejecucion'] . "</center></td>
                                <td><center>" . $adicionesTiempo [$i] ['valor_tiempo'] . "</center></td>
                                <td><center>" . $adicionesTiempo [$i] ['descripcion'] . "</center></td>
                               
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";
                } else {

                    $mensaje = "El contrato numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta novedades de Adicion en Tiempo.";

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


                echo "</section>";

                echo "<h3>Reducciones</h3><section>";

                if ($reducciones) {

                    echo "<center><h4>REDUCCIONES</h4></center>";

                    echo "<table id='tablareducciones'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Estado</th>            
            			<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Registro Presupuestal</th>
                                <th>Valor Reducción</th>
                                <th>Descripcion</th>
                                
                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    $totalReduccionesPresupuesto = 0;
                    for ($i = 0; $i < count($reducciones); $i ++) {
                        $numerador = $i + 1;
                        if ($reducciones [$i] ['estado'] == 't') {
                            $estado = "Activa";
                        } else {
                            $estado = "Inactiva";
                        }

                        $totalReduccionesPresupuesto += $reducciones [$i] ['valor_presupuesto'];




                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $reducciones [$i] ['numero_contrato'] . " - " . $reducciones [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $estado . "</center></td>		
                                <td><center>" . $reducciones [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $reducciones [$i] ['usuario'] . "</center></td>
                                <td><center>" . $reducciones [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $reducciones [$i] ['numero_rp'] . "</center></td>
                                <td><center>" . $reducciones [$i] ['valor_presupuesto'] . "</center></td>
                                <td><center>" . $reducciones [$i] ['descripcion'] . "</center></td>
                                 
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";

                    echo "<center><p><h5>TOTAL REDUCCIONES = " . number_format($totalReduccionesPresupuesto, 2, ",", ".") . "<p></h5></center>";
                    echo "<br>";
                } else {

                    $mensaje = "El contrato numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta novedades de Reduccion.";

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



                echo "</section>";

//          
                echo "<h3>Cesiones</h3><section>";

                if ($cesiones) {

                    echo "<center><h4>CESIONES</h4></center>";

                    echo "<table id='tablacesiones'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Estado</th>            
            			<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Contratista Actual</th>
                                <th>Contratista Anterior</th>
                                <th>Fecha Oficial de Cesión</th>
                                <th>Descripcion</th>
                               
                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    for ($i = 0; $i < count($cesiones); $i ++) {
                        $numerador = $i + 1;
                        if ($cesiones [$i] ['estado'] == 't') {
                            $estado = "Activa";
                        } else {
                            $estado = "Inactiva";
                        }

                        $sqlContratista = $this->miSql->getCadenaSql('consultarTercero', $cesiones [$i] ['nuevo_contratista']);
                        $nuevo_contratista = $esteRecursoDBAgora->ejecutarAcceso($sqlContratista, "busqueda");
                        $sqlContratista2 = $this->miSql->getCadenaSql('consultarTercero', $cesiones [$i] ['antiguo_contratista']);
                        $anterior_contratista = $esteRecursoDBAgora->ejecutarAcceso($sqlContratista2, "busqueda");




                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $cesiones [$i] ['numero_contrato'] . " - " . $cesiones [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $estado . "</center></td>		
                                <td><center>" . $cesiones [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $cesiones [$i] ['usuario'] . "</center></td>
                                <td><center>" . $cesiones [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $cesiones [$i] ['nuevo_contratista'] . " - " . $nuevo_contratista[0][0] . "</center></td>
                                <td><center>" . $cesiones [$i] ['antiguo_contratista'] . " - " . $anterior_contratista[0][0] . "</center></td>
                                <td><center>" . $cesiones [$i] ['fecha_cesion'] . "</center></td>
                                <td><center>" . $cesiones [$i] ['descripcion'] . "</center></td>
                                  
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";
                } else {

                    $mensaje = "El contrato numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta novedades de Cesión.";

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



                echo "</section>";
                echo "<h3>Cambios de Supervisor</h3><section>";
                if ($cambioSupervisor) {
                    echo "<center><h4>CAMBIOS DE SUPERVISOR</h4></center>";

                    echo "<table id='tablacambioSupervisor'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Estado</th>            
            			<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Tipo de Cambio</th>
                                <th>Supervisor Actual</th>
                                <th>Supervisor Anterior</th>
                                <th>Fecha Oficial de Cambio</th>
                                <th>Descripcion</th>
                                
                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    for ($i = 0; $i < count($cambioSupervisor); $i ++) {
                        $numerador = $i + 1;
                        if ($cambioSupervisor [$i] ['estado'] == 't') {
                            $estado = "Activa";
                        } else {
                            $estado = "Inactiva";
                        }

                        $consultaSuperNuevo = $this->miSql->getCadenaSql('ConsultaSupervisorNovedad', $cambioSupervisor [$i] ['supervisor_nuevo']);
                        $consultaSuperAntiguo = $this->miSql->getCadenaSql('ConsultaSupervisorNovedad', $cambioSupervisor [$i] ['supervisor_antiguo']);

                        $supervisorNuevo = $esteRecursoDB->ejecutarAcceso($consultaSuperNuevo, "busqueda");
                        $supervisorAntiguo = $esteRecursoDB->ejecutarAcceso($consultaSuperAntiguo, "busqueda");

                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $cambioSupervisor [$i] ['numero_contrato'] . " - " . $cambioSupervisor [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $estado . "</center></td>		
                                <td><center>" . $cambioSupervisor [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $cambioSupervisor [$i] ['usuario'] . "</center></td>
                                <td><center>" . $cambioSupervisor [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $cambioSupervisor [$i] ['tipocambio_parametro'] . "</center></td>
                                <td><center>" . $supervisorNuevo[0][0] . "</center></td>
                                <td><center>" . $supervisorAntiguo[0][0] . "</center></td>
                                <td><center>" . $cambioSupervisor [$i] ['fecha_cambio'] . "</center></td>
                                <td><center>" . $cambioSupervisor [$i] ['descripcion'] . "</center></td>
                                   
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";
                } else {

                    $mensaje = "El contrato numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta novedades de Cambio de Supervisor.";

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




                echo "</section>";
                echo "<h3>Suspension</h3><section>";

                if ($suspensiones) {
                    echo "<center><h4>SUSPENSIONES</h4></center>";

                    echo "<table id='tablasuspension'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Fecha Inicio Suspensión</th>
                                <th>Fecha Fin Suspensión</th>
                                <th>Fechade Reanudación</th>
                                <th>Descripcion</th>
                                
                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    for ($i = 0; $i < count($suspensiones); $i ++) {
                        $numerador = $i + 1;
                        if ($suspensiones [$i] ['estado'] == 't') {
                            $estado = "Activa";
                        } else {
                            $estado = "Inactiva";
                        }

                        $variableModificar = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                        $variableModificar .= "&opcion=modificarNovedad";
                        $variableModificar .= "&id_novedad=" . $suspensiones [$i] ['id'];
                        $variableModificar .= "&tipo_novedad=" . $suspensiones [$i] ['tipo_novedad'];
                        $variableModificar .= "&numero_contrato=" . $suspensiones [$i] ['numero_contrato'];
                        $variableModificar .= "&vigencia=" . $suspensiones [$i] ['vigencia'];
                        $variableModificar .= "&arreglo=" . $_REQUEST ['arreglo'];
                        $variableModificar .= "&usuario=" . $_REQUEST['usuario'];
                        $variableModificar .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
                        $variableModificar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableModificar, $directorio);

                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $suspensiones [$i] ['numero_contrato'] . " - " . $suspensiones [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $suspensiones [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $suspensiones [$i] ['usuario'] . "</center></td>
                                <td><center>" . $suspensiones [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $suspensiones [$i] ['fecha_inicio'] . "</center></td>
                                <td><center>" . $suspensiones [$i] ['fecha_fin'] . "</center></td>
                                <td><center>" . $suspensiones [$i] ['fecha_reanudacion'] . "</center></td>
                                <td><center>" . $suspensiones [$i] ['descripcion'] . "</center></td>
                                
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";
                } else {

                    $mensaje = "El contrato numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta novedades de Suspensioón.";

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
                if ($otras) {


                    echo "<center><h4>REANUDACIONES</h4></center>";

                    echo "<table id='tablaotras'>";
                    echo "<thead>
                             <tr>
                                <th>Numeración</th>
                                <th>Numero Contrato-Vigencia</th>
                              	<th>Fecha de Registro</th>
            			<th>Usuario</th>
                                <th>Numero Acto Administrativo</th>
                                <th>Descripcion</th>
                                                                                    	
                             </tr>
                          </thead>
                    <tbody>";
                    for ($i = 0; $i < count($otras); $i ++) {
                        $numerador = $i + 1;




                        $mostrarHtml = "<tr>
                                <td><center>" . $numerador . "</center></td>
                                <td><center>" . $otras [$i] ['numero_contrato'] . " - " . $otras [$i] ['vigencia'] . "</center></td>		
                                <td><center>" . $otras [$i] ['fecha_registro'] . "</center></td>
                                <td><center>" . $otras [$i] ['usuario'] . "</center></td>
                                <td><center>" . $otras [$i] ['acto_administrativo'] . "</center></td>
                                <td><center>" . $otras [$i] ['descripcion'] . "</center></td>
                               
                                </tr>";
                        echo $mostrarHtml;
                        unset($mostrarHtml);
                        unset($variableModificar);
                    }

                    echo "</tbody>";

                    echo "</table>";
                } else {

                    $mensaje = "El contrato numero " . $_REQUEST['numero_contrato_suscrito'] . " "
                            . "con vigencia: " . $_REQUEST['vigencia'] . "<br>no presenta otro tipo de novedades.";

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

            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");
            unset($atributos);
        }
        // ------------------Fin Division para los botones-------------------------





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
