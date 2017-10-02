<?php

namespace gestionContractual\novedad\registrarNovedad;

use gestionContractual\novedad\registrarNovedad;

// include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorContrato {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miFuncion;
    var $miSql;
    var $conexion;

    function __construct($lenguaje, $sql, $funcion) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
        $this->miFuncion = $funcion;
    }

    function procesarFormulario() {


        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionContractual/novedad/";
        $rutaBloque .= $esteBloque ['nombre'];
        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . $rutaBloque;
        $SQls = [];


        foreach ($_FILES as $key => $values) {
            $archivo = $_FILES [$key];
        }

        $acceptedFormats = array('pdf', 'png', 'jpg', 'doc', 'docx', 'xls', 'csv');

        if (!in_array(pathinfo($archivo['name'], PATHINFO_EXTENSION), $acceptedFormats)) {
            $estado = false;
        } elseif ($archivo['size'] > 262144000) {
            $estado = false;
        } else {

            if ($archivo ['name'] != '') {
                // obtenemos los datos del archivo
                $tamano = $archivo ['size'];
                $tipo = $archivo ['type'];
                $archivo1 = $archivo ['name'];
                $prefijo = substr(md5(uniqid(rand())), 0, 6);

                if ($archivo1 != "") {
                    // guardamos el archivo a la carpeta files
                    $destino1 = $rutaBloque . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
                    if (copy($archivo ['tmp_name'], $destino1)) {
                        $status = "Archivo subido: <b>" . $archivo1 . "</b>";
                        $destino1 = $host . "/archivoSoporte/" . $prefijo . "_" . $archivo1;

                        $estado = true;
                    } else {
                        $estado = FALSE;
                    }
                } else {
                    $estado = FALSE;
                }
            } else {
                $estado = FALSE;
            }

            if ($estado != FALSE) {

                $arreglo_novedad = array(
                    0 => $_REQUEST['tipo_novedad'],
                    1 => $_REQUEST['numero_contrato'],
                    2 => $_REQUEST['vigencia'],
                    3 => date('Y-m-d H:i:s'),
                    4 => $_REQUEST['usuario'],
                    5 => $_REQUEST['numero_acto'],
                    6 => $prefijo . "_" . $archivo1,
                    7 => $_REQUEST['observaciones'],
                );


                $cadenaSqlNovedad = $this->miSql->getCadenaSql('registroNovedadContractual', $arreglo_novedad);

                array_push($SQls, $cadenaSqlNovedad);


                if ($_REQUEST['tipo_novedad'] == '') {
                    
                } elseif ($_REQUEST['tipo_novedad'] == '220') {
                    if ($_REQUEST['tipo_adicion'] == '248') {


                        $cadenaAcumulado = $cadenaSqlParticular = $this->miSql->getCadenaSql('acumuladoAdiciones', array(0 => $_REQUEST['numero_contrato'],
                            1 => $_REQUEST['vigencia']));
                        $acumulado = $esteRecursoDB->ejecutarAcceso($cadenaAcumulado, "busqueda");

                        if ($acumulado[0][0] == null) {
                            $acumulado[0][0] = 0;
                        }
                        $valorTope = $_REQUEST['valor_contrato'] * 0.5;
                        $valorOtrosSi = $acumulado[0][0] + $_REQUEST['valor_adicion_presupuesto'];

                        if ($valorOtrosSi > $valorTope) {

                            $datosRebasaOtroSi = array(
                                'acumulado' => $acumulado[0][0],
                                'valor_tope' => $valorTope,
                                'valor_adicion' => $_REQUEST['valor_adicion_presupuesto'],
                                'numero_contrato' => $_REQUEST['numero_contrato'],
                                'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                                'tipo_novedad' => $_REQUEST['tipo_novedad'],
                                'vigencia' => $_REQUEST['vigencia'],
                                'valor_contrado' => $_REQUEST['valor_contrato']
                            );

                            redireccion::redireccionar("rebasaOtroSi", $datosRebasaOtroSi);
                        } elseif ($_REQUEST['vigencia_novedad'] != date("Y")) {

                            $datosVigenciaError = array(
                                'numero_contrato' => $_REQUEST['numero_contrato'],
                                'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                                'vigencia' => $_REQUEST['vigencia'],
                                'vigencia_novedad' => $_REQUEST['vigencia_novedad'],
                                'tipo_novedad' => $_REQUEST['tipo_novedad'],
                            );
                            echo "date no correcto";
                            redireccion::redireccionar("errorVigencia", $datosVigenciaError);
                        } else {

                            $arreglo_novedad_particular = array(
                                0 => "currval('novedad_contractual_id_seq')",
                                1 => $_REQUEST['tipo_adicion'],
                                2 => $_REQUEST['numero_solicitud'],
                                3 => $_REQUEST['numero_cdp'],
                                4 => $_REQUEST['valor_adicion_presupuesto'],
                                5 => $_REQUEST['vigencia_novedad'],
                            );
                            $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAdicionPresupuesto', $arreglo_novedad_particular);
                            array_push($SQls, $cadenaSqlParticular);
                        }
                    } else {

                        $cadenaAcumulado = $cadenaSqlParticular = $this->miSql->getCadenaSql('acumuladoAdicionesTiempo', array(0 => $_REQUEST['numero_contrato'],
                            1 => $_REQUEST['vigencia']));
                        $acumulado = $esteRecursoDB->ejecutarAcceso($cadenaAcumulado, "busqueda");

                        if ($acumulado[0][0] == null) {
                            $acumulado = 0;
                        } else {
                            $acumulado = $acumulado[0][0];
                        }

                        $cadenaTiempoContrato = $cadenaSqlParticular = $this->miSql->getCadenaSql('tiempo_contrato', array(0 => $_REQUEST['numero_contrato'],
                            1 => $_REQUEST['vigencia']));
                        $tiempoContrato = $esteRecursoDB->ejecutarAcceso($cadenaTiempoContrato, "busqueda");
                        if ($tiempoContrato[0]['unidad_ejecucion'] == '206') {
                            $tiempoContrato[0]['plazo_ejecucion'] *= 12;
                        } elseif ($tiempoContrato[0]['unidad_ejecucion'] == '207') {
                            $tiempoContrato[0]['plazo_ejecucion'] *= 365;
                        }

                        $valorAcumuladoTiempo = $_REQUEST['valor_adicion_tiempo'] + $acumulado;
                        $valorTopeTiempo = $tiempoContrato[0]['plazo_ejecucion'] * 0.5;

                        $datosRebasaOtroSiTiempo = array(
                            'vigencia' => $_REQUEST['vigencia'],
                            'numero_contrato' => $_REQUEST['numero_contrato'],
                            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                            'tiempo_contrato' => $tiempoContrato[0]['plazo_ejecucion'],
                            'acumuladoadicion' => $valorAcumuladoTiempo,
                            'valor_adicion' => $_REQUEST['valor_adicion_tiempo'],
                            'acumuladoNovedades' => $acumulado,
                            'valor_tope' => $valorTopeTiempo,
                            'tipo_novedad' => $_REQUEST['tipo_novedad'],
                        );

                        if ($valorAcumuladoTiempo > $valorTopeTiempo) {
                            redireccion::redireccionar("rebasaOtroSitiempo", $datosRebasaOtroSiTiempo);
                        }

                        $arreglo_novedad_particular = array(
                            0 => "currval('novedad_contractual_id_seq')",
                            1 => $_REQUEST['tipo_adicion'],
                            2 => 205,
                            3 => $_REQUEST['valor_adicion_tiempo']
                        );
                        $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAdicionTiempo', $arreglo_novedad_particular);
                        array_push($SQls, $cadenaSqlParticular);
                    }
                } elseif ($_REQUEST['tipo_novedad'] == '234') {

                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['tipo_anulacion'],
                    );

                    $datosEstado = array(
                        'numero_contrato' => $_REQUEST['numero_contrato'],
                        'vigencia' => $_REQUEST['vigencia'],
                        'fecha' => date('Y-m-d H:i:s'),
                        'usuario' => $_REQUEST['usuario'],
                        'estado' => 5
                    );
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAnulacion', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);

                    $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoNovedadContratoGeneral', $datosEstado);
                    array_push($SQls, $SQLsEstadoContratoGeneral);
                } elseif ($_REQUEST['tipo_novedad'] == '222') {

                    $infoSupervisor = explode("-", $_REQUEST['nuevoSupervisor']);
                    $cadenaSupervisorActual = explode("-", $_REQUEST['supervisor_actual']);

                    //Validar Supervisor 
                    $SqlValidarSupervisor = $this->miSql->getCadenaSql('ObtenerSupervisor', $infoSupervisor[0]);
                    $InfoSupervisorRegistrado = $esteRecursoDB->ejecutarAcceso($SqlValidarSupervisor, "busqueda");
                    $bandera = false;
                    for ($i = 0; $i < count($InfoSupervisorRegistrado); $i++) {
                        if ($InfoSupervisorRegistrado[$i]['cargo'] == $_REQUEST ['cargo_supervisor'] &&
                                $InfoSupervisorRegistrado[$i]['sede_supervisor'] == $_REQUEST ['sede_super'] &&
                                $InfoSupervisorRegistrado[$i]['dependencia_supervisor'] == $_REQUEST ['dependencia_supervisor']) {
                            $id_supervisor = $InfoSupervisorRegistrado[$i]['id'];
                            $bandera = true;
                            break;
                        }
                    }
                    if ($bandera == false) {
                        //Registro de supervisor
                        $datosSupervisor = array(
                            'documento' => $infoSupervisor[0],
                            'nombre_supervisor' => $infoSupervisor[1],
                            'cargo' => $_REQUEST ['cargo_supervisor'],
                            'sede' => $_REQUEST ['sede_super'],
                            'dependencia' => $_REQUEST ['dependencia_supervisor'],
                            'digito_verificacion' => $_REQUEST ['digito_supervisor'],
                        );
                        $infoSupervisor[0] = "currval('supervisor_contrato_id_seq')";
                        $SqlSupervisorContrato = $this->miSql->getCadenaSql('insertarSupervisor', $datosSupervisor);
                        array_push($SQls, $SqlSupervisorContrato);
                    } else {
                        $infoSupervisor[0] = $id_supervisor;
                    }

                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['tipoCambioSupervisor'],
                        2 => $_REQUEST['id_supervisor'],
                        3 => $infoSupervisor[0],
                        4 => $_REQUEST['fecha_oficial_cambio']
                    );
                    $arregloCambioSupervisor = array(
                        0 => $infoSupervisor[0],
                        1 => $_REQUEST['numero_contrato'],
                        2 => $_REQUEST['vigencia'],
                    );
                

                    $cadenaSqlSupervisor = $this->miSql->getCadenaSql('actualizarSupervisor', $arregloCambioSupervisor);
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadCambioSupervisor', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                    array_push($SQls, $cadenaSqlSupervisor);
                   
                } elseif ($_REQUEST['tipo_novedad'] == '219') {

                    $cadenaContratistaActual = explode(" - ", $_REQUEST['actualContratista']);
                    $cadenaContratistaNuevo = explode("-", $_REQUEST['selec_proveedor']);
                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $cadenaContratistaNuevo[0],
                        2 => $cadenaContratistaActual[0],
                        3 => $_REQUEST['fecha_inicio_cesion']
                    );
                    if ($cadenaContratistaNuevo[2] == 'UNION TEMPORAL') {
                        $clase_contratista = 31;
                    } elseif ($cadenaContratistaNuevo[2] == 'CONSORCIO') {
                        $clase_contratista = 32;
                    } else {
                        $clase_contratista = 33;
                    }

                    $arregloCambioContratista = array(
                        0 => $cadenaContratistaNuevo[0],
                        1 => $cadenaContratistaNuevo[1],
                        2 => $_REQUEST['numero_contrato'],
                        3 => $_REQUEST['vigencia'],
                        4 => $clase_contratista,
                    );
                    $cadenaSqlContratista = $this->miSql->getCadenaSql('actualizarContratista', $arregloCambioContratista);
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadCesion', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                    array_push($SQls, $cadenaSqlContratista);
                } elseif ($_REQUEST['tipo_novedad'] == '216') {

                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['fecha_inicio_suspension'],
                        2 => $_REQUEST['fecha_fin_suspension'],
                    );
                    $datosEstado = array(
                        'numero_contrato' => $_REQUEST['numero_contrato'],
                        'vigencia' => $_REQUEST['vigencia'],
                        'fecha' => date('Y-m-d H:i:s'),
                        'usuario' => $_REQUEST['usuario'],
                        'estado' => 2
                    );
                    $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoNovedadContratoGeneral', $datosEstado);
                    array_push($SQls, $SQLsEstadoContratoGeneral);
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadSuspension', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                } elseif ($_REQUEST['tipo_novedad'] == '218') {

                    $datosEstado = array(
                        'numero_contrato' => $_REQUEST['numero_contrato'],
                        'vigencia' => $_REQUEST['vigencia'],
                        'fecha' => date('Y-m-d H:i:s'),
                        'usuario' => $_REQUEST['usuario'],
                        'estado' => 6
                    );

                    $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoNovedadContratoGeneral', $datosEstado);
                    array_push($SQls, $SQLsEstadoContratoGeneral);
                } elseif ($_REQUEST['tipo_novedad'] == '217') {


                    $datosEstado = array(
                        'numero_contrato' => $_REQUEST['numero_contrato'],
                        'vigencia' => $_REQUEST['vigencia'],
                        'fecha' => date('Y-m-d H:i:s'),
                        'usuario' => $_REQUEST['usuario'],
                        'estado' => 4
                    );

                    $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoNovedadContratoGeneral', $datosEstado);
                    array_push($SQls, $SQLsEstadoContratoGeneral);

                    $datosReanudacion = array(
                        'fecha_reanudacion' => $_REQUEST['fecha_reanuadion'],
                        'id_suspension' => $_REQUEST['identificador_suspension'],
                        'estado' => "false",
                        'id_reanudacion' => "currval('novedad_contractual_id_seq')"
                    );

                    $SQLsReanudarContrato = $this->miSql->getCadenaSql('reanudarSuspension', $datosReanudacion);
                    array_push($SQls, $SQLsReanudarContrato);
                } elseif ($_REQUEST['tipo_novedad'] == '257') {

                    $datosEstado = array(
                        'numero_contrato' => $_REQUEST['numero_contrato'],
                        'vigencia' => $_REQUEST['vigencia'],
                        'fecha' => date('Y-m-d H:i:s'),
                        'usuario' => $_REQUEST['usuario'],
                        'estado' => 8
                    );

                    $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoNovedadContratoGeneral', $datosEstado);
                    array_push($SQls, $SQLsEstadoContratoGeneral);

                    $datosTerminacionAnticipada = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['fecha_Terminacion_anticipada']
                    );

                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadTerminacionAnticipada', $datosTerminacionAnticipada);
                    array_push($SQls, $cadenaSqlParticular);
                } elseif ($_REQUEST['tipo_novedad'] == '258') {
                    $valor_tope_reduccion = $_REQUEST['valor_rp_hidden'] * 0.5;
                    $cadenaSqlAculumadoReducciones = $this->miSql->getCadenaSql('acumuladoReducciones', array(0 => $_REQUEST['numero_contrato'],
                        1 => $_REQUEST['vigencia']));
                    $acumulado_reduccion = $esteRecursoDB->ejecutarAcceso($cadenaSqlAculumadoReducciones, "busqueda");
                    $acumulado_reduccion = $acumulado_reduccion[0][0];
                    $acumuladototal = $acumulado_reduccion + $_REQUEST['valor_reduccion'];
                    if ($acumuladototal <= $valor_tope_reduccion) {
                        $datosReduccion = array(
                            0 => "currval('novedad_contractual_id_seq')",
                            1 => $_REQUEST['registro_presupuestal_reduccion'],
                            2 => $_REQUEST['valor_reduccion'],
                            3 => $_REQUEST['vigencia']
                        );
                        $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadReduccion', $datosReduccion);
                        array_push($SQls, $cadenaSqlParticular);
                    } else {
                        $datosRebasaReduccion = array(
                            'acumulado' => $acumulado_reduccion,
                            'valor_tope' => $valor_tope_reduccion,
                            'valor_reduccion' => $_REQUEST['valor_reduccion'],
                            'numero_contrato' => $_REQUEST['numero_contrato'],
                            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                            'tipo_novedad' => $_REQUEST['tipo_novedad'],
                            'vigencia' => $_REQUEST['vigencia'],
                            'valor_rp' => $_REQUEST['valor_rp_hidden']
                        );

                        redireccion::redireccionar("rebasaReduccion", $datosRebasaReduccion);
                    }
                }
                $trans_Registro_Novedad = $esteRecursoDB->transaccion($SQls);
            }
        }


        $datosContrato = array('numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'], 'tipo_novedad' => $_REQUEST['tipo_novedad'],
            'acto_administrativo' => $_REQUEST['numero_acto'], 'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito']);

        if (isset($trans_Registro_Novedad) && $trans_Registro_Novedad != false) {
            redireccion::redireccionar("Inserto", $datosContrato);
            exit();
        } else {
            redireccion::redireccionar("ErrorRegistro", $datosContrato);
            exit();
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>