<?php

namespace gestionCompras\consultaOrden\funcion;

use gestionCompras\consultaOrden\funcion\redireccion;

include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorOrden {

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


        $SQLs = [];
        $SQLsAgora = [];

        $datos_modificados = array();
        $Identificadores = array('numero_contrato' => $_REQUEST['numerocontrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'id_orden' => $_REQUEST['id_orden']);

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionCompras/";
        $rutaBloque .= $esteBloque ['nombre'];

        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/gestionCompras/" . $esteBloque ['nombre'];

        //Validacion del tipo de compromiso, para determinar si el contrato 
        //tiene o no convenio asociado
        if ($_REQUEST ['tipo_compromiso'] != '3') {
            $numero_convenio = "";
        } else {
            $numero_convenio = $_REQUEST ['convenio_solicitante'];
        }
        //Validacion campos nulos de moneda y tasa extranjera
        if (isset($_REQUEST ['valor_contrato_moneda_ex']) && $_REQUEST ['valor_contrato_moneda_ex'] != "") {
            $valor_moneda_extranjera = $_REQUEST ['valor_contrato_moneda_ex'];
        } else {
            $valor_moneda_extranjera = "null";
        }
        if (isset($_REQUEST ['tasa_cambio']) && $_REQUEST ['tasa_cambio'] != "") {
            $tasa_cambio = $_REQUEST ['tasa_cambio'];
        } else {
            $tasa_cambio = "null";
        }

        //Obtener la Clausula de Presupuesto
        if (isset($_POST['clausula_presupuesto'])) {
            $clausula_presupuesto = $_POST['clausula_presupuesto'];
        } else {
            $clausula_presupuesto = 'false';
        }
        if (isset($_REQUEST ['especificaciones_tecnicas']) && $_REQUEST ['especificaciones_tecnicas'] != "") {
            $_REQUEST ['especificaciones_tecnicas'] = $_REQUEST ['especificaciones_tecnicas'];
        } else {
            $_REQUEST ['especificaciones_tecnicas'] = "";
        }
        if (isset($_REQUEST ['observacionesContrato']) && $_REQUEST ['observacionesContrato'] != "") {
            $_REQUEST ['observacionesContrato'] = $_REQUEST ['observacionesContrato'];
        } else {
            $_REQUEST ['observacionesContrato'] = "";
        }
        if (isset($_REQUEST ['condiciones']) && $_REQUEST ['condiciones'] != "") {
            $_REQUEST ['condiciones'] = $_REQUEST ['condiciones'];
        } else {
            $_REQUEST ['condiciones'] = "";
        }

        //validar tipo de persona para registrar la clase de contratista

        $sqlTipoPersona = $this->miSql->getCadenaSql('obtenerTipoPersona', $_REQUEST['id_proveedor']);
        $infoTipoPersona = $esteRecursoDBAgora->ejecutarAcceso($sqlTipoPersona, "busqueda");
        if ($infoTipoPersona[0]['tipopersona'] == 'CONSORCIO') {
            $_REQUEST ['clase_contratista'] = 32;
        } elseif ($infoTipoPersona[0]['tipopersona'] == 'UNION TEMPORAL') {
            $_REQUEST ['clase_contratista'] = 31;
        } else {
            $_REQUEST ['clase_contratista'] = 33;
        }
        //Validar Tipo de supervisor para determinar registro


        if ($_REQUEST['tipo_supervisor'] == 1) {
            $supervisor = $_REQUEST['nombre_supervisor'];
        } else {
            $supervisor = $_REQUEST['nombre_supervisor_interventor'];
        }

        $infoSupervisor = explode("-", $supervisor);

        //Validar Supervisor 
        $SqlValidarSupervisor = $this->miSql->getCadenaSql('ObtenerSupervisor', $infoSupervisor[0]);
        $InfoSupervisorRegistrado = $esteRecursoDB->ejecutarAcceso($SqlValidarSupervisor, "busqueda");
        $datosSupervisor = array(
            'documento' => $infoSupervisor[0],
            'nombre_supervisor' => $infoSupervisor[1],
            'cargo' => $_REQUEST ['cargo_supervisor'],
            'sede' => $_REQUEST ['sede_super'],
            'dependencia' => $_REQUEST ['dependencia_supervisor'],
            'digito_verificacion' => $_REQUEST ['digito_supervisor'],
            'tipo' => $_REQUEST ['tipo_supervisor'],
        );


        $datos_modificados = array_merge($datos_modificados, $datosSupervisor);
        if ($InfoSupervisorRegistrado == false) {
            //Registro de supervisor si no existe
            $SqlSupervisorContrato['sql'] = $this->miSql->getCadenaSql('insertarSupervisor', $datosSupervisor);
            $SqlSupervisorContrato['descripcion'] = 'registroSupervisor';
            $SqlSupervisorContrato['valores'] = $datosSupervisor;
            array_push($SQLs, $SqlSupervisorContrato);
            $infoSupervisor[0] = "currval('supervisor_contrato_id_seq')";
        } else {

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
                $infoSupervisor[0] = "currval('supervisor_contrato_id_seq')";
                $SqlSupervisorContrato['sql'] = $this->miSql->getCadenaSql('insertarSupervisor', $datosSupervisor);
                $SqlSupervisorContrato['descripcion'] = 'registroSupervisor';
                $SqlSupervisorContrato['valores'] = $datosSupervisor;
                array_push($SQLs, $SqlSupervisorContrato);
            } else {

                $infoSupervisor[0] = $id_supervisor;
            }
        }
        $datos_modificados = array_merge($datos_modificados, $datosSupervisor);

        //Ejecucion del contrato
        $arreglo_info_ejecucion = array(
            'direccion' => $_REQUEST['direccion_ejecucion'],
            'sede' => $_REQUEST['sede_ejecucion'],
            'dependencia' => $_REQUEST['dependencia_ejecucion'],
            'ciudad' => $_REQUEST['ejecucionCiudad'],
            'lugar_ejecucion' => $_REQUEST['lugar_ejecucion'],
        );

        $SqlValidarLugarEjecucion = $this->miSql->getCadenaSql('ObtenerLugardeEjecucion', $arreglo_info_ejecucion);
        $InfoLugarEjecucion = $esteRecursoDB->ejecutarAcceso($SqlValidarLugarEjecucion, "busqueda");
        if ($InfoLugarEjecucion == false) {

            $SqlLugarEjecucion['sql'] = $this->miSql->getCadenaSql('insertarLugarEjecucion', $arreglo_info_ejecucion);
            $SqlLugarEjecucion['descripcion'] = 'registroLugarEjecucion';
            $SqlLugarEjecucion['valores'] = $arreglo_info_ejecucion;
            array_push($SQLs, $SqlLugarEjecucion);
            $lugarEjecucion = "currval('argo.lugar_ejecucion_id_seq')";
        } else {

            $lugarEjecucion = $InfoLugarEjecucion[0][0];
        }



        $datos_modificados = array_merge($datos_modificados, $arreglo_info_ejecucion);


        //Datos Generales del  Contrato 
        $arreglo_contrato_general = array(
            'vigencia' => $Identificadores['vigencia'],
            'numero_contrato' => $Identificadores['numero_contrato'],
            'objeto_contrato' => $_REQUEST ['objeto_contrato'],
            'plazo_ejecucion' => $_REQUEST ['plazo_ejecucion'],
            'forma_pago' => $_REQUEST ['formaPago'],
            'ordenador_gasto' => $_REQUEST ['ordenador_gasto'],
            'clausula_presupuesto' => $clausula_presupuesto,
            'sede' => $_REQUEST ['sede'],
            'dependencia' => $_REQUEST ['dependencia_solicitante'],
            'contratista' => $_REQUEST['id_proveedor'],
            'unidad_ejecucion_tiempo' => $_REQUEST ['unidad_ejecucion_tiempo'],
            'valor_contrato' => $_REQUEST ['valor_contrato'],
            'justificacion' => $_REQUEST ['justificacion'],
            'condiciones' => $_REQUEST ['condiciones'],
            'actividades' => $_REQUEST ['actividades'],
            'especificaciones_tecnicas' => $_REQUEST ['especificaciones_tecnicas'],
            'descripcion_forma_pago' => $_REQUEST ['descripcion_forma_pago'],
            'unidad_ejecutora' => $_REQUEST ['unidad_ejecutora_hidden'],
            'tipologia_especifica' => $_REQUEST ['tipologia_especifica'],
            'tipo_orden' => $_REQUEST ['tipo_orden'],
            'tipo_compromiso' => $_REQUEST ['tipo_compromiso'],
            'modalidad_seleccion' => $_REQUEST ['modalidad_seleccion'],
            'procedimiento' => $_REQUEST ['procedimiento'],
            'regimen_contratación' => $_REQUEST ['regimen_contratación'],
            'tipo_gasto' => $_REQUEST ['tipo_gasto'],
            'tema_gasto_inversion' => $_REQUEST ['tema_gasto_inversion'],
            'origen_presupuesto' => $_REQUEST ['origen_presupuesto'],
            'origen_recursos' => $_REQUEST ['origen_recursos'],
            'tipo_moneda' => $_REQUEST ['tipo_moneda'],
            'valor_contrato_moneda_ex' => $valor_moneda_extranjera,
            'tasa_cambio' => $tasa_cambio,
            'tipo_control' => $_REQUEST ['tipo_control'],
            'lugar_ejecucion' => $lugarEjecucion,
            'observacionesContrato' => $_REQUEST ['observacionesContrato'],
            'supervisor' => $infoSupervisor[0],
            'clase_contratista' => $_REQUEST ['clase_contratista'],
            'convenio' => $numero_convenio,
        );
        $datos_modificados = array_merge($datos_modificados, $arreglo_contrato_general);

        $SqlcontratoGeneral['sql'] = $this->miSql->getCadenaSql('actualizarContratoGeneral', $arreglo_contrato_general);
        $SqlcontratoGeneral['descripcion'] = 'actualizarContratoGeneral';
        $SqlcontratoGeneral['valores'] = $arreglo_contrato_general;
        array_push($SQLs, $SqlcontratoGeneral);


        $datos_contrato = array(
            'vigencia' => $Identificadores['vigencia'],
            'numero_contrato' => $Identificadores['numero_contrato'],
        );

        $sqlEliminarDisponibilidades['sql'] = $this->miSql->getCadenaSql('eliminarContratoDisponibilidad', $datos_contrato);
        $sqlEliminarDisponibilidades['descripcion'] = 'eliminarDisponibilidadContrato';
        $sqlEliminarDisponibilidades['valores'] = $datos_contrato;
        array_push($SQLs, $sqlEliminarDisponibilidades);

        $disponibilidades = explode(",", substr($_REQUEST['indices_cdps_vigencias'], 1));

        for ($i = 0; $i < count($disponibilidades); $i++) {
            $datos = array(
                'numero_contrato' => $Identificadores['numero_contrato'],
                'vigencia' => $Identificadores['vigencia'],
                'numero_disponibilidad' => explode("-", $disponibilidades[$i])[0],
                'vigencia_disponibilidad' => explode("-", $disponibilidades[$i])[1],
            );

            $sqlDisponibilidad['sql'] = $this->miSql->getCadenaSql('insertarContratoDisponibilidad', $datos);
            $sqlDisponibilidad['descripcion'] = 'insertarDisponibilidadContrato';
            $sqlDisponibilidad['valores'] = $datos;
            array_push($SQLs, $sqlDisponibilidad);
        }


        if ($_REQUEST ['poliza'] == 'Si Aplica') {
            $poliza = 't';
        } else {
            $poliza = 'f';
        }
        $datosOrden = array('tipo_orden' => $_REQUEST ['tipo_orden'],
            'id_orden' => $Identificadores['id_orden'],
            'poliza' => $poliza,
        );
        // Registro Orden
        $SQLsOrden['sql'] = $this->miSql->getCadenaSql('updateOrden', $datosOrden);
        $SQLsOrden['descripcion'] = 'insertarInfoOrden';
        $SQLsOrden['valores'] = $datosOrden;
        array_push($SQLs, $SQLsOrden);

//

        if (isset($_REQUEST['idnovedadModificacion'])) {

            $datos = "";

            $datos_modificados = json_encode($datos_modificados);

            $arreglo_json = array(
                2 => str_replace("\\", "", $_REQUEST['datosActualesContrato']),
                1 => $datos_modificados,
                0 => $_REQUEST['idnovedadModificacion']
            );
            $cadenaSqlDatosModificados = $this->miSql->getCadenaSql('insertarDatosModificados', $arreglo_json);
            array_push($SQLs, $cadenaSqlDatosModificados);

            $datosModificacion = array("numero_contrato" => $Identificadores['numero_contrato'],
                "vigencia" => $_REQUEST['vigencia'], 'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
                'idnovedadModificacion' => $_REQUEST['idnovedadModificacion']);
        }

        $arreglo_eliminar = array(
            'numero_contrato' => $Identificadores['numero_contrato'],
            'vigencia' => $Identificadores['vigencia']
        );

        if ($_REQUEST['poliza'] == 'Si Aplica') {
            $SqContratoArrendamientoEl['sql'] = $this->miSql->getCadenaSql('eliminarContratoPolizasGeneral', $arreglo_eliminar);
            $SqContratoArrendamientoEl['descripcion'] = 'eliminarContratoPolizasGeneral';
            $SqContratoArrendamientoEl['valores'] = $arreglo_eliminar;
            array_push($SQLs, $SqContratoArrendamientoEl);

            if ($_REQUEST['tablAmparos_hidden'] == '') {
                $_REQUEST['tablAmparos_hidden'] = 'N/A,0';
                $_REQUEST['tablaSuficiencia_hidden'] = 'N/A,0';
                $_REQUEST['tablaVigencia_hidden'] = '0,0';
            }


            $arrayAmparos = explode(",", $_REQUEST['tablAmparos_hidden']);
            $arraySuficiencia = explode(",", $_REQUEST['tablaSuficiencia_hidden']);
            $arrayVigencia = explode(",", $_REQUEST['tablaVigencia_hidden']);


            $count = 0;

            while ($count < $_REQUEST['cantidadAmparos_hidden']) {


                $arreglo_contratoGeneral = array(
                    'numero_contrato' => $Identificadores['numero_contrato'],
                    'vigencia_contrato' => $Identificadores['vigencia'],
                    'amparo' => $arrayAmparos [$count],
                    'suficiencia' => $arraySuficiencia [$count],
                    'vigencia_amparo' => $arrayVigencia [$count],
                );



                $SqContratoArrendamientoGeneral['sql'] = $this->miSql->getCadenaSql('insertarContratoPolizaGeneral', $arreglo_contratoGeneral);
                $SqContratoArrendamientoGeneral['descripcion'] = 'insertarContratoPolizaGeneral';
                $SqContratoArrendamientoGeneral['valores'] = $arreglo_contratoGeneral;
                array_push($SQLs, $SqContratoArrendamientoGeneral);


                $count++;
            }
        }

        $trans_actualizacion_orden = $esteRecursoDB->transaccion($SQLs);



        $datos = array('numero_contrato' => $Identificadores['numero_contrato'],
            'vigencia' => $Identificadores['vigencia']);


        if ($trans_actualizacion_orden != false) {
            $this->miConfigurador->setVariableConfiguracion("cache", true);

            if (isset($_REQUEST['idnovedadModificacion'])) {
                redireccion::redireccionar("novedaddeModificacion", $datosModificacion);
            } else {

                redireccion::redireccionar('actualizoOrden', $datos);
            }
        } else {

            redireccion::redireccionar('noActualizo', $datos);
        }
    }

    function resetForm() {
        foreach ($_REQUEST as $clave => $valor) {

            if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
                unset($_REQUEST [$clave]);
            }
        }
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>