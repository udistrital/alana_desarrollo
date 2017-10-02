<?php

namespace contratos\registrarContrato;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {

    var $miConfigurador;

    function __construct() {
        $this->miConfigurador = \Configurador::singleton();
    }

    function getCadenaSql($tipo, $variable = "") {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            /**
             * Clausulas específicas
             */
            case "vigencias_solicitudes" :

                $cadenaSql = "SELECT DISTINCT vigencia , vigencia valor  ";
                $cadenaSql .= " FROM solicitud_necesidad  ";
                $cadenaSql .= "WHERE estado_registro=TRUE; ";

                break;
            
            case "obtenerAmparosParametros" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos; ";

                break;
            case "buscar_participante" :

                $cadenaSql = " SELECT p.num_documento AS  data,  p.num_documento||'-('||p.nom_proveedor||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_proveedor p  ";
                $cadenaSql .= " WHERE (tipopersona = 'NATURAL' or  tipopersona = 'JURIDICA') AND  cast(p.num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR p.nom_proveedor  LIKE '%" . $variable . "%'  ";
                $cadenaSql .= " LIMIT 20;";

                break;
            case "buscar_representante_suplente" :

                $cadenaSql = " SELECT p.num_documento_persona AS  data,  p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  ";
                $cadenaSql .= " WHERE cast(p.num_documento_persona as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " LIMIT 20;";

                break;
            case "buscar_Info_participante" :

                $cadenaSql = " SELECT p.num_documento, p.nom_proveedor, tipopersona, puntaje_evaluacion   ";
                $cadenaSql .= " FROM agora.informacion_proveedor p ";
                $cadenaSql .= " WHERE num_documento = $variable ;";


                break;

            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza WHERE estado = true ORDER BY id_poliza; ";
                break;

            case "insertarPoliza" :
                $cadenaSql = " INSERT INTO contrato_poliza(";
                $cadenaSql .= " numero_contrato,vigencia, poliza, fecha_inicio,fecha_final) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= $variable ['poliza'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_inicio'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_final'] . "');";

                break;
            
            case "consultaArrendamiento" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= "  FROM argo.argo.contrato_arrendamiento ca ";
                $cadenaSql .= " WHERE ca.numero_contrato='$variable[0]' and ca.vigencia = $variable[1] ";
              break;

            case "ConsultarNumeroNecesidades" :

                $cadenaSql = "SELECT * FROM (SELECT DISTINCT sl.numero_solicitud as descripcion, sl.id_sol_necesidad as id, sl.estado_registro,sl.vigencia  ";
                $cadenaSql .= " FROM solicitud_necesidad sl, orden_contrato oc,parametros pr,  "
                        . "contrato_general cg, contrato c ";
                $cadenaSql .= " WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad   ";
                $cadenaSql .= " and pr.id_parametro = sl.ejecucion ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato   ";
                $cadenaSql .= " EXCEPT ";
                $cadenaSql .= " SELECT DISTINCT sl.numero_solicitud as descripcion, sl.id_sol_necesidad as id, sl.estado_registro,sl.vigencia  ";
                $cadenaSql .= " FROM solicitud_necesidad sl, orden_contrato oc, parametros pr, "
                        . "  contrato_general cg, contrato c ";
                $cadenaSql .= "  WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad ";
                $cadenaSql .= "  and pr.id_parametro = sl.ejecucion  ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato  ";
                $cadenaSql .= " and cg.id_orden_contrato = oc.id_orden_contr ) as r ";
                $cadenaSql .= " WHERE vigencia=$variable;";

                break;

            case "consultarSolicitud" :
                $cadenaSql = "SELECT * FROM (SELECT DISTINCT sl.id_sol_necesidad, sl.vigencia, sl.numero_solicitud, sl.fecha_solicitud, sl.valor_contratacion, "
                        . " sl.unidad_tiempo_ejecucion ||' '||pr.descripcion duracion, sl.objeto_contrato,oc.id_orden_contr, sl.estado_registro  ";
                $cadenaSql .= " FROM solicitud_necesidad sl, orden_contrato oc, parametros pr,  "
                        . "contrato_general cg, contrato c ";
                $cadenaSql .= " WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad   ";
                $cadenaSql .= " and pr.id_parametro = sl.ejecucion ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato   ";
                $cadenaSql .= " EXCEPT ";
                $cadenaSql .= " SELECT DISTINCT sl.id_sol_necesidad, sl.vigencia, sl.numero_solicitud, sl.fecha_solicitud,sl.valor_contratacion, "
                        . "sl.unidad_tiempo_ejecucion ||' '||pr.descripcion duracion, sl.objeto_contrato,oc.id_orden_contr, sl.estado_registro    ";
                $cadenaSql .= " FROM solicitud_necesidad sl, orden_contrato oc, parametros pr, "
                        . "  contrato_general cg, contrato c ";
                $cadenaSql .= "  WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad ";
                $cadenaSql .= "  and pr.id_parametro = sl.ejecucion  ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato  ";
                $cadenaSql .= " and cg.id_orden_contrato = oc.id_orden_contr ) as r ";

                if ($variable ['vigencia'] != '' || $variable ['numero_solicitud'] != '' || $variable ['fecha_inicial'] != '') {
                    $cadenaSql .= " WHERE estado_registro= TRUE ";
                    if ($variable ['vigencia'] != '') {
                        $cadenaSql .= " AND vigencia = '" . $variable ['vigencia'] . "' ";
                    }
                    if ($variable ['numero_solicitud'] != '') {
                        $cadenaSql .= " AND  id_sol_necesidad = '" . $variable ['numero_solicitud'] . "' ";
                    }

                    if ($variable ['fecha_inicial'] != '') {
                        $cadenaSql .= " AND fecha_solicitud BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                        $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                    }
                }

                $cadenaSql .= "  ; ";

                break;

            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM \"sedes_SIC\" ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ;";
                break;

            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE sa.\"ESF_ID_SEDE\"='" . $variable . "' ";
                $cadenaSql .= " AND  ad.\"ESF_ESTADO\"='A'";

                break;

            case "obtenerDireccionSede" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_DIRECCION\" ";
                $cadenaSql .= " FROM \"sedes_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_ID_SEDE\"='" . $variable . "' ";
                $cadenaSql .= " AND  \"ESF_ESTADO\"='A'";

                break;

            case "cargoSuper" :

                $cadenaSql = " SELECT  FUN_CARGO || '('||FUN_DEP_NOM_ACADEMICA||')' ";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable ";

                break;

            case "cargosFuncionarios" :

                $cadenaSql = " SELECT cargo  as data, cargo  as value ";
                $cadenaSql .= " FROM argo.cargo_supervisor_temporal ";
                $cadenaSql .= " ORDER BY data; ";

                break;

            case "perfiles" :

                $cadenaSql = " SELECT id_parametro, INITCAP(valor_parametro) ";
                $cadenaSql .= " FROM agora.parametro_estandar  ";
                $cadenaSql .= " WHERE clase_parametro = 'Tipo Perfil'; ";

                break;

            case "insertarPerfilCPS" :
                $cadenaSql = " INSERT INTO argo.contrato_cps(";
                $cadenaSql.=" numero_contrato, vigencia, perfil)";
                $cadenaSql.=" VALUES (" . $variable['numero_contrato'] . ", " . $variable['vigencia'] . ", " . $variable['perfil'] . ");";

                break;
            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  ORG_NOMBRE,  ORG_IDENTIFICACION ";
                $cadenaSql .= " FROM SICAARKA.ORDENADORES_GASTO  ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR = $variable and ORG_ESTADO = 'A'";

                break;

            case "ordenadorGasto" :

                $cadenaSql = " SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO FROM SICAARKA.ORDENADORES_GASTO ";
                $cadenaSql.=" WHERE ORG_ESTADO='A' ";

                break;

            case "textos" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_parametro, ";
                $cadenaSql .= " descripcion ";
                $cadenaSql .= " FROM";
                $cadenaSql .= " parametros ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " estado_registro=TRUE ";
                $cadenaSql .= " AND ";
        $cadenaSql .= " rel_parametro=29;  ";
     
                break;


            case "Consultar_Registro_Presupuestales" :
                $cadenaSql = " SELECT rp.id_registro_pres, rp.numero_registro, rp.valor_registro, rp.vigencia,rp.fecha_rgs_pr  ";
                $cadenaSql .= " FROM registro_presupuestal rp ";
                $cadenaSql .= " WHERE rp.estado_registro=true and rp.disponibilidad_presupuestal=$variable;";
                break;


            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO != 'I' ";

                break;

            case "insertarEstadoContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_estado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_registro,usuario,estado ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= $variable ['estado'] . ");";

                break;

            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora  ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "ObtenerSupervisor" :
                $cadenaSql = "SELECT * ";
                $cadenaSql .= "FROM supervisor_contrato  ";
                $cadenaSql .= "WHERE documento=" . $variable . "; ";
                break;

            case "interventores" :
                $cadenaSql = " SELECT ip.num_documento ||'-'||ip.nom_proveedor AS data , ip.num_documento ||'-'||ip.nom_proveedor as value from ";
                $cadenaSql.=" agora.informacion_proveedor ip, agora.informacion_persona_natural ipn ";
                $cadenaSql.=" where ip.num_documento = ipn.num_documento_persona;";
                $cadenaSql.=" ";
                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28;";

                break;
            
            case "buscarContratoGeneral" :
                $cadenaSql = " 	SELECT numero_contrato, vigencia, objeto_contrato, plazo_ejecucion, forma_pago, ordenador_gasto, clausula_registro_presupuestal as clausula_presupuesto, sede_solicitante as sede, dependencia_solicitante as dependencia, ";
                $cadenaSql .= " contratista, unidad_ejecucion as unidad_ejecucion_tiempo, valor_contrato, justificacion, actividades , condiciones, especificaciones_tecnicas,descripcion_forma_pago,unidad_ejecutora, ";
                $cadenaSql .= " tipologia_contrato as tipologia_especifica, tipo_compromiso, modalidad_seleccion, procedimiento, regimen_contratacion as regimen_contratación, tipo_gasto, tema_gasto_inversion,origen_presupueso as origen_presupuesto, ";
                $cadenaSql .= " origen_recursos, tipo_moneda,valor_contrato_me as valor_contrato_moneda_ex,valor_tasa_cambio as tasa_cambio, tipo_control, observaciones as observacionesContrato, supervisor, clase_contratista, convenio, ";
                $cadenaSql .= " lugar_ejecucion, tipo_contrato, usuario ";
                $cadenaSql .= " FROM argo.contrato_general ";
                $cadenaSql .= " WHERE  ";
                $cadenaSql .= " vigencia=".$variable ['vigencia']." AND ";
                $cadenaSql .= " objeto_contrato='".$variable ['objeto_contrato']."' AND ";
                $cadenaSql .= " plazo_ejecucion=".$variable ['plazo_ejecucion']." AND ";
                $cadenaSql .= " forma_pago=".$variable ['forma_pago']." AND ";
                $cadenaSql .= " ordenador_gasto='".$variable ['ordenador_gasto']."' AND ";
                $cadenaSql .= " clausula_registro_presupuestal='".$variable ['clausula_presupuesto']."' AND ";
                $cadenaSql .= " sede_solicitante='".$variable ['sede']."' AND ";
                $cadenaSql .= " dependencia_solicitante='".$variable ['dependencia']."' AND ";
                $cadenaSql .= " contratista=".$variable ['contratista']." AND ";
                $cadenaSql .= " unidad_ejecucion=".$variable ['unidad_ejecucion_tiempo'] ." AND ";
                $cadenaSql .= " valor_contrato=".$variable ['valor_contrato']." AND ";
                $cadenaSql .= " justificacion='".$variable ['justificacion'] ."' AND ";
                $cadenaSql .= " descripcion_forma_pago='".$variable ['descripcion_forma_pago']."' AND ";
                $cadenaSql .= " condiciones='".$variable ['condiciones']."'  AND ";                
                $cadenaSql .= " unidad_ejecutora=".$variable ['unidad_ejecutora']." AND ";
                $cadenaSql .= " '".date('Y-m-d H:i:s')."'-fecha_registro<='00:05:00' AND ";
                $cadenaSql .= " tipologia_contrato=".$variable ['tipologia_especifica']." AND ";
                $cadenaSql .= " tipo_compromiso=".$variable ['tipo_compromiso']." AND " ;
                $cadenaSql .= " modalidad_seleccion=".$variable ['modalidad_seleccion']." AND ";
                $cadenaSql .= " procedimiento=".$variable ['procedimiento']." AND ";
                $cadenaSql .= " regimen_contratacion=".$variable ['regimen_contratación']." AND ";
                $cadenaSql .= " tipo_gasto=".$variable ['tipo_gasto']." AND ";
                $cadenaSql .= " tema_gasto_inversion=".$variable ['tema_gasto_inversion']." AND ";
                $cadenaSql .= " origen_presupueso=".$variable ['origen_presupuesto']." AND ";
                $cadenaSql .= " origen_recursos=".$variable ['origen_recursos']." AND ";
                $cadenaSql .= " tipo_moneda=".$variable ['tipo_moneda']." AND ";
                if($variable ['valor_contrato_moneda_ex']=='null'){
                    $cadenaSql .= " valor_contrato_me is null AND";
                }
                else{
                    $cadenaSql .= " valor_contrato_me=".$variable ['valor_contrato_moneda_ex']." AND ";
                }
                if($variable ['tasa_cambio']=='null'){
                    $cadenaSql .= " valor_tasa_cambio is null AND ";
                }
                else{
                    $cadenaSql .= " valor_tasa_cambio=".$variable ['tasa_cambio']." AND ";
                }          
                $cadenaSql .= " tipo_control=".$variable ['tipo_control']." AND ";
                $cadenaSql .= " observaciones='".$variable ['observacionesContrato']."' AND ";
                $cadenaSql .= " supervisor=".$variable ['supervisor']." AND ";
                $cadenaSql .= " clase_contratista=".$variable ['clase_contratista']." AND ";
                $cadenaSql .= " convenio='".$variable ['convenio']."' AND ";
                $cadenaSql .= " tipo_contrato=".$variable ['tipo_contrato']." AND ";
                $cadenaSql .= " lugar_ejecucion=".$variable ['lugar_ejecucion']." AND ";
                $cadenaSql .= " especificaciones_tecnicas='".$variable ['especificaciones_tecnicas']."' AND ";
                $cadenaSql .= " actividades='".$variable ['actividades']."' AND ";
                $cadenaSql .= " usuario='".$variable ['usuario']."' ";
         
                 
                break;
            
            case "buscar_info_proveedor_contrato" :

                $cadenaSql = " SELECT num_documento ||'-'|| nom_proveedor  AS value"
                        . "  FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE id_proveedor=".$variable;
              
                break;
            

            case "insertarContratoGeneral" :
                $cadenaSql = " INSERT INTO argo.contrato_general( ";
                $cadenaSql.=" vigencia, objeto_contrato, plazo_ejecucion,forma_pago, ";
                $cadenaSql.=" ordenador_gasto, clausula_registro_presupuestal, ";
                $cadenaSql.=" sede_solicitante, dependencia_solicitante,  ";
                $cadenaSql.=" contratista, unidad_ejecucion, valor_contrato, justificacion, ";
                $cadenaSql.=" descripcion_forma_pago, condiciones, unidad_ejecutora,";
                $cadenaSql.=" tipologia_contrato, tipo_compromiso, modalidad_seleccion, procedimiento,";
                $cadenaSql.=" regimen_contratacion, tipo_gasto, tema_gasto_inversion, origen_presupueso,";
                $cadenaSql.=" origen_recursos, tipo_moneda, valor_contrato_me, valor_tasa_cambio, ";
                $cadenaSql.=" tipo_control, observaciones,especificaciones_tecnicas,actividades, supervisor, "
                        . "clase_contratista,tipo_contrato,lugar_ejecucion,usuario,convenio,fecha_registro)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['objeto_contrato'] . "',";
                $cadenaSql .= $variable ['plazo_ejecucion'] . ",";
                $cadenaSql .= $variable ['forma_pago'] . ",";
                $cadenaSql .= "'" . $variable ['ordenador_gasto'] . "',";
                $cadenaSql .= $variable ['clausula_presupuesto'] . ",";
                $cadenaSql .= "'" . $variable ['sede'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia'] . "',";
                $cadenaSql .= $variable ['contratista'] . ",";
                $cadenaSql .= $variable ['unidad_ejecucion_tiempo'] . ",";
                $cadenaSql .= $variable ['valor_contrato'] . ",";
                $cadenaSql .= "'" . $variable ['justificacion'] . "',";
                $cadenaSql .= "'" . $variable ['descripcion_forma_pago'] . "',";
                $cadenaSql .= "'" . $variable ['condiciones'] . "',";
                $cadenaSql .= $variable ['unidad_ejecutora'] . ",";
                $cadenaSql .= $variable ['tipologia_especifica'] . ",";
                $cadenaSql .= $variable ['tipo_compromiso'] . ",";
                $cadenaSql .= $variable ['modalidad_seleccion'] . ",";
                $cadenaSql .= $variable ['procedimiento'] . ",";
                $cadenaSql .= $variable ['regimen_contratación'] . ",";
                $cadenaSql .= $variable ['tipo_gasto'] . ",";
                $cadenaSql .= $variable ['tema_gasto_inversion'] . ",";
                $cadenaSql .= $variable ['origen_presupuesto'] . ",";
                $cadenaSql .= $variable ['origen_recursos'] . ",";
                $cadenaSql .= $variable ['tipo_moneda'] . ",";
                $cadenaSql .= $variable ['valor_contrato_moneda_ex'] . ",";
                $cadenaSql .= $variable ['tasa_cambio'] . ",";
                $cadenaSql .= $variable ['tipo_control'] . ",";
                $cadenaSql .= "'" . $variable ['observacionesContrato'] . "',";
                $cadenaSql .= "'" . $variable ['especificaciones_tecnicas'] . "',";
                $cadenaSql .= "'" . $variable ['actividades'] . "',";
                $cadenaSql .= $variable ['supervisor'] . ",";
                $cadenaSql .= $variable ['clase_contratista'] . ",";
                $cadenaSql .= $variable ['tipo_contrato'] . ",";
                $cadenaSql .= $variable ['lugar_ejecucion'] . ",";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= "'" . $variable ['convenio'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_registro'] . "');";
               
                break;

            case "insertarContratoDisponibilidad" :
                $cadenaSql = " INSERT INTO argo.contrato_disponibilidad(";
                $cadenaSql.=" numero_cdp, numero_contrato, vigencia,vigencia_cdp)";
                $cadenaSql.=" VALUES (" . $variable['numero_disponibilidad'] . ", " . $variable['numero_contrato'] . ", " . $variable['vigencia'] . ", " . $variable['vigencia_disponibilidad'] . ");";
                break;

            case "insertarSupervisor" :

                $cadenaSql = " INSERT INTO argo.supervisor_contrato( ";
                $cadenaSql .=" nombre, documento, cargo, sede_supervisor, ";
                $cadenaSql .=" dependencia_supervisor,tipo,digito_verificacion)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['nombre_supervisor'] . "',";
                $cadenaSql .= $variable ['documento'] . ",";
                $cadenaSql .= "'" . $variable ['cargo'] . "',";
                $cadenaSql .= "'" . $variable ['sede'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia'] . "',";
                $cadenaSql .= $variable ['tipo'] . ",";
                $cadenaSql .= $variable ['digito_verificacion'] . ");";
             
                break;

            case "insertarContratoArrendamiento" :

                $cadenaSql = " INSERT INTO argo.contrato_arrendamiento( ";
                $cadenaSql .=" destinacion, plazo_pago_mensual, ";
                $cadenaSql .=" reajuste, plazo_administracion, valor_administracion, plazo_entrega, valor_arrendamiento, numero_contrato, vigencia) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['destinacion'] . "',";
                $cadenaSql .= $variable ['plazo_mensual'] . ",";
                $cadenaSql .= "'" . $variable ['reajuste'] . "',";
                if(isset($variable['valor_admin']) && isset($variable['plazo_admin'])){
                    $cadenaSql .= $variable ['plazo_admin'] . ",";
                    $cadenaSql .= $variable ['valor_admin'] . ",";
                }
                else{
                    $cadenaSql .= "null,";
                    $cadenaSql .= "null,";
                }
                
                $cadenaSql .= $variable ['plazo_entrega'] . ",";
                $cadenaSql .= $variable ['valor_arrendamiento'] . ",";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= $variable ['vigencia'] . ");";
        
                break;
            
             case "insertarContratoArrendamientoGeneral" :

                $cadenaSql = " INSERT INTO argo.amparo_contrato( ";
                $cadenaSql .="   vigencia, tipo_amparo,suficiencia, ";
                $cadenaSql .="   numero_contrato, vigencia_contrato) ";
                $cadenaSql .= " VALUES ('";               
                $cadenaSql .= $variable ['vigencia_amparo'] . "',";
                $cadenaSql .= $variable ['amparo'] . ",";
                $cadenaSql .= $variable ['suficiencia'] . ",";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= $variable ['vigencia_contrato'] . ");";
              
                break;
            
            
            

            
            
            


            case "obtenerInfoContrato" :
                $cadenaSql = " SELECT MAX(CAST(numero_contrato AS integer)) as numero_contrato";
                $cadenaSql .= " FROM ";
                $cadenaSql .= "contrato_general WHERE numero_contrato NOT LIKE '%DVE%' ; ";

                break;


            case "consultarBanco" :
                $cadenaSql = "SELECT";
                $cadenaSql .= " id_codigo,";
                $cadenaSql .= "	nombre_banco";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " core.banco";
                $cadenaSql .= " WHERE estado != 'INACTIVO' ";
                $cadenaSql .= " ORDER BY nombre_banco";
                break;

            case 'buscarDepartamento' : // Solo Departamentos de Colombia

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_pais = 112 ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;
            
            case 'buscarDepartamentoAjax' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_pais = ' . $variable . ' ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;

            case 'insertarLugarEjecucion' :
                $cadenaSql = " INSERT INTO argo.lugar_ejecucion(";
                $cadenaSql.=" direccion, sede, dependencia, ";
                $cadenaSql.=" ciudad)";
                $cadenaSql.=" VALUES ('" . $variable['direccion'] . "', ";
                $cadenaSql.=" '" . $variable['sede'] . "','" . $variable['dependencia'] . "'," . $variable['ciudad'] . ");";
              
                break;
            case 'ObtenerLugardeEjecucion' :

                $cadenaSql = " SELECT id FROM lugar_ejecucion ";
                $cadenaSql.=" WHERE direccion='" . $variable['direccion'] . "' AND sede='" . $variable['sede'] . "'  ";
                $cadenaSql.=" AND dependencia ='" . $variable['dependencia'] . "' AND ciudad =" . $variable['ciudad'] . "; ";

                break;

            case 'buscarCiudadAjax' :

                $cadenaSql = 'SELECT DISTINCT ';
                $cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
                $cadenaSql .= 'nombre as NOMBRECIUDAD ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.ciudad ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_departamento = ' . $variable . ' ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;

            case 'buscarPais' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_pais as ID_PAIS, ';
                $cadenaSql .= 'nombre_pais as NOMBRE, ';
                $cadenaSql .= 'codigo_pais as COD_PAIS ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.pais ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;


            case "registrar_proveedor_sociedad" :

                $cadenaSql = " INSERT INTO agora.informacion_proveedor(";
                $cadenaSql.=" tipopersona, num_documento, id_ciudad_contacto, ";
                $cadenaSql.=" direccion, correo, web, anexorut, estado, ";
                $cadenaSql.=" tipo_cuenta_bancaria, num_cuenta_bancaria, ";
                $cadenaSql.=" id_entidad_bancaria, fecha_registro, ";
                $cadenaSql.=" fecha_ultima_modificacion, nom_proveedor)";
                $cadenaSql.=" VALUES ('" . $variable['tipopersona'] . "', " . $variable['num_documento'] . ", " . $variable['id_ciudad_contacto'] . ", ";
                $cadenaSql.=" '" . $variable['direccion'] . "','" . $variable['correo'] . "', '" . $variable['web'] . "', ";
                $cadenaSql.=" '" . $variable['anexorut'] . "', " . $variable['estado'] . ", '" . $variable['tipo_cuenta_bancaria'] . "', ";
                $cadenaSql.=" '" . $variable['num_cuenta_bancaria'] . "', " . $variable['id_entidad_bancaria'] . ", '" . $variable['fecha_registro'] . "', ";
                $cadenaSql.=" '" . $variable['fecha_ultima_modificacion'] . "', '" . $variable['nom_proveedor'] . "');";
                break;
            case "registrar_sociedad_temporal" :

                $cadenaSql = " INSERT INTO agora.informacion_sociedad_temporal( identificacion, ";
                $cadenaSql.=" documento_representante, documento_suplente, ";
                $cadenaSql.=" digito_verificacion)";
                $cadenaSql.=" VALUES ( " . $variable['identificacion'] . ", " . $variable['documento_representante'] . ", " . $variable['documento_suplente'] . ", ";
                $cadenaSql.= $variable['digito_verificacion'] . ");";

                break;
            case "registrar_participante_sociedad" :

                $cadenaSql = "INSERT INTO agora.informacion_sociedad_participante(";
                $cadenaSql.=" id_sociedad, documento_contratista, ";
                $cadenaSql.=" porcentaje_participacion ";
                $cadenaSql.=" )VALUES ( " . $variable['id_sociedad'] . ", " . $variable['documento_contratista'] . ", " . $variable['porcentaje_participacion'] . " );";
                break;

            case "registrar_telefono" :
                $cadenaSql = "INSERT INTO agora.telefono(numero_tel, tipo) VALUES (" . $variable['telefono'] . "," . $variable['estado'] . ");";
                break;
            case "vincular_telefono_sociedad" :
                $cadenaSql = "INSERT INTO agora.proveedor_telefono(id_proveedor, id_telefono) ";
                $cadenaSql .= "VALUES (currval('agora.prov_proveedor_info_id_proveedor_seq'),currval('agora.prov_proveedor_telefono')); ";
                break;
            
            case "obtenerFechaTerminoContratista" :
                $cadenaSql = "SELECT fecha_final_contrato,tipo_contrato, unidad_ejecutora FROM( ";
                $cadenaSql .= "SELECT DISTINCT cg.contratista, ";
                $cadenaSql .= "CASE WHEN unidad_ejecucion=205 THEN (pol.fecha_aprobacion::date +CAST('\"' || (plazo_ejecucion/30) || 'months\"' AS INTERVAL) +CAST('\"' || (plazo_ejecucion%30) || 'days\"' AS INTERVAL)) ::date  ";
                $cadenaSql .= " WHEN unidad_ejecucion=206 THEN  (pol.fecha_aprobacion::date +CAST('\"' || (plazo_ejecucion) || 'months\"' AS INTERVAL)) ::date  ";
                $cadenaSql .= " WHEN unidad_ejecucion=207 THEN (pol.fecha_aprobacion::date +CAST('\"' || (plazo_ejecucion) || 'years\"' AS INTERVAL)) ::date  ";
                $cadenaSql .= " END as fecha_final_contrato, tipo_contrato, unidad_ejecutora ";
                $cadenaSql .= " FROM argo.contrato_general cg ";
                $cadenaSql .= " LEFT JOIN argo.contrato_cps as cps ON cps.numero_contrato=cg.numero_contrato ";
                $cadenaSql .= "LEFT JOIN argo.poliza as pol ON pol.numero_contrato=cg.numero_contrato AND pol.vigencia=cg.vigencia) as contratistas ";
                $cadenaSql .= "WHERE current_timestamp::date <= fecha_final_contrato AND contratista=".$variable;
                break;
            
            


     
    


            case "convenios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio; ";
                break;

            case "conveniosxvigencia" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio ";
                $cadenaSql .= " WHERE \"ANIO_PRO\" = '$variable' ; ";
                break;

            case "vigencia_convenios" :
                $cadenaSql = " SELECT DISTINCT ";
                $cadenaSql .= " \"ANIO_PRO\" as value,";
                $cadenaSql .= " \"ANIO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio ORDER BY \"ANIO_PRO\" DESC; ";
                break;

            case "buscar_nombre_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NOMBRE\"";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;

            case "cargos_existentes" :
                $cadenaSql = " SELECT  DISTINCT FUN_CARGO";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ORDER BY FUN_CARGO ASC";
                break;



            case "tipo_configuracion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_configuracion'; ";
                break;

            case "tipo_clase_contratista" :

                $cadenaSql = "SELECT id_parametro, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contratista' and pr.estado_registro = 't'; ";
                break;

            case "obtenerTipoPersona" :

                $cadenaSql = "SELECT tipopersona   ";
                $cadenaSql .= " FROM  agora.informacion_proveedor ";
                $cadenaSql .= "WHERE id_proveedor=$variable; ";
                break;

            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contrato'; ";

                break;

            case "tipo_compromisoContrato" :

                $cadenaSql = " SELECT id as id, codigo_contraloria|| ' - ' || grupo_contrato as valor";
                $cadenaSql.=" FROM argo.grupo_tipo_contrato WHERE (id = 2 or id = 3) ;";

                break;
            case "tipo_contrato" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' and id_grupo_tipo_contrato = 2 ;";

                break;

            case "tipo_ejecucion_tiempo" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_ejecucion_tiempo'; ";
                break;

            case "consulta_dependencia" :

                $cadenaSql = "SELECT id_dependencia  ,nombre    ";
                $cadenaSql .= "FROM dependencia ";
                $cadenaSql .= "WHERE estado_registro = TRUE ;";

                break;

            case "tipologia_contrato" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipologia_contrato'; ";
                break;

            case "modalidad_seleccion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='modalidad_seleccion'; ";
                break;

            case "tipo_procedimiento" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='procedimiento'; ";
                break;

            case "regimen_contratacion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='regimen_contratacion'; ";
                break;

            case "tipo_moneda" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_moneda'; ";
                break;

            case "consulta_ordenador" :

                $cadenaSql = "SELECT og.id_ordenador, pr.descripcion || ': ' ||og.nombre_cp ordenador  ";
                $cadenaSql .= "FROM ordenador_gasto og  ";
                $cadenaSql .= "JOIN parametros pr ON pr.id_parametro= og.tipo_ordenador  ";
                $cadenaSql .= "JOIN parametros rp ON rp.id_parametro= og.estado ";
                $cadenaSql .= "WHERE rp.descripcion='Activo' ";
                $cadenaSql .= "AND  og.estado_registro= TRUE;  ";
                break;

            case "tipo_gasto" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_gasto'; ";
                break;

            case "origen_recursos" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='origen_recursos'; ";
                break;

            case "origen_presupuesto" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='origen_presupuesto'; ";
                break;

            case "tema_gasto" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tema_gasto'; ";
                break;

            case "tipo_control" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_control'; ";
                break;



            case "obtenerUnidadUsuario" :

                $cadenaSql = " select unidad_ejecutora from frame_work.argo_usuario   ";
                $cadenaSql .= " where id_usuario = '$variable'; ";


                break;

            //------------------Agora Consultas Necesidades ----------------------------------------

            case "vigencias_agora" :
                $cadenaSql = " SELECT DISTINCT vigencia AS valor, vigencia AS informacion  FROM agora.objeto_contratar ";
                $cadenaSql .= " WHERE vigencia= $variable ORDER BY vigencia DESC ";
                break;


            case "obtenerSolicitudesAgora" :
                $cadenaSql = "  SELECT oc.*, u.unidad FROM agora.objeto_contratar oc, agora.unidad u ";
                $cadenaSql .= "  WHERE u.id_unidad = oc.id_unidad ";
                if ($variable['vigencia_solicitud_consulta'] != '') {
                    $cadenaSql .= " AND oc.vigencia = " . $variable['vigencia_solicitud_consulta'] . " ";
                }
                if ($variable['numero_solicitud'] != '') {
                    $cadenaSql .= " AND oc.numero_solicitud = " . $variable['numero_solicitud'] . " ";
                }

                $cadenaSql .= " ; ";
                break;

            case "obtenerCDPSica" :
                $cadenaSql = " SELECT CDP.NUMERO_DISPONIBILIDAD FROM PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql.=" CO.CO_SOLICITUD_ADQ SN";
                $cadenaSql.=" WHERE CDP.NUM_SOL_ADQ = SN.NUM_SOL_ADQ and SN.VIGENCIA=CDP.VIGENCIA ";
                $cadenaSql.=" AND SN.VIGENCIA = $variable[0] and CDP.NUM_SOL_ADQ= $variable[1] ";
                break;
            
                



            case "buscar_proveedor_contrato" :

                $cadenaSql = " SELECT num_documento ||'-'|| nom_proveedor|| '- ( PERSONA: '||tipopersona||')' AS value, id_proveedor AS "
                        . "data FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (tipopersona = 'NATURAL' or tipopersona = 'JURIDICA' or tipopersona = 'EXTRANJERA') AND (cast(num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR nom_proveedor  LIKE '%" . $variable . "%' ) AND estado = 1 ";
                $cadenaSql .= " LIMIT 20;";


                break;

            case "buscar_sociedad_contrato" :

                $cadenaSql = " SELECT ip.num_documento ||'-'|| ip.nom_proveedor|| '- ( TIPO SOCIEDAD: '||ip.tipopersona||')' AS value, ip.id_proveedor AS "
                        . "data FROM agora.informacion_proveedor ip, informacion_sociedad_temporal ist WHERE ip.id_proveedor = ist.id_proveedor_sociedad ";
                $cadenaSql .= " AND (tipopersona = 'UNION TEMPORAL' or tipopersona = 'CONSORCIO') AND (cast(num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR nom_proveedor  LIKE '%" . $variable . "%' ) AND ist.estado = 't' ";
                $cadenaSql .= " LIMIT 20;";


                break;
            case "buscar_Informacion_proveedor" :

                $cadenaSql = " SELECT ip.*, c.nombre as nombreCiudad, b.nombre_banco as nombreBanco FROM agora.informacion_proveedor ip, core.ciudad c, core.banco b ";
                $cadenaSql .= " WHERE c.id_ciudad = ip.id_ciudad_contacto AND b.id_codigo = ip.id_entidad_bancaria AND ip.id_proveedor = $variable;";


                break;

            case "buscar_Informacion_sociedad" :

                $cadenaSql = " SELECT ip.*, c.nombre as nombreCiudad, b.nombre_banco as nombreBanco,ist.digito_verificacion, ";
                $cadenaSql .= " ir.num_documento ||'-'|| ir.nom_proveedor as inforepresentante , irs.num_documento  ||'-'|| irs.nom_proveedor as  inforepresentantesuplente    ";
                $cadenaSql .= " FROM agora.informacion_proveedor ip, core.ciudad c, core.banco b, agora.informacion_sociedad_temporal ist,  ";
                $cadenaSql .= " agora.informacion_proveedor ir , agora.informacion_proveedor irs  ";
                $cadenaSql .= " WHERE c.id_ciudad = ip.id_ciudad_contacto AND ist.id_proveedor_sociedad = ip.id_proveedor ";
                $cadenaSql .= " AND ir.id_proveedor = ist.representante AND irs.id_proveedor = ist.representante_suplente ";
                $cadenaSql .= " AND b.id_codigo = ip.id_entidad_bancaria AND ip.id_proveedor = $variable; ";

                break;

            case "buscar_participantes_sociedad" :

                $cadenaSql = " SELECT ip.num_documento||'-'||ip.nom_proveedor as participante, sp.porcentaje_participacion ";
                $cadenaSql .= " FROM agora.informacion_sociedad_participante sp , agora.informacion_proveedor ip  ";
                $cadenaSql .= " WHERE sp.id_contratista = ip.id_proveedor ";
                $cadenaSql .= " AND sp.id_proveedor_sociedad = $variable; ";

                break;

            //---------------------SICapital--------------------------------------------------


            case "vigencias_sica_disponibilidades" :
                $cadenaSql = " SELECT DISTINCT SN.VIGENCIA AS valor, SN.VIGENCIA AS informacion  FROM CO.CO_SOLICITUD_ADQ SN ";
                $cadenaSql .= " ORDER BY SN.VIGENCIA DESC ";

                break;


            case "obtenerInfoCdp" :
                $cadenaSql = " SELECT SN.NUM_SOL_ADQ, SCDP.ID_SOL_CDP, CDP.NUMERO_DISPONIBILIDAD,SN.VIGENCIA ,DP.NOMBRE_DEPENDENCIA,DE.OBSERVACIONES, ";
                $cadenaSql.=" SN.ESTADO, SN.JUSTIFICACION, SN.OBJETO,SN.VALOR_CONTRATACION,CDP.ESTADO as ESTADOCDP , CDP.FECHA_REGISTRO,SN.RUBRO_INTERNO, RB.DESCRIPCION ";
                $cadenaSql.=" FROM CO.CO_SOL_CDP SCDP, PR.PR_DISPONIBILIDADES CDP , CO.CO_DEPENDENCIAS DP, PR.PR_RUBRO RB, CO.CO_SOLICITUD_ADQ SN   ";
                $cadenaSql.=" LEFT JOIN CO.CO_DTLLE_SOL_ADQ_S DE ON  DE.VIGENCIA = SN.VIGENCIA and DE.NUM_SOL_ADQ = SN.NUM_SOL_ADQ   ";
                $cadenaSql.=" WHERE SN.NUM_SOL_ADQ = SCDP.NUM_SOL_ADQ and SN.VIGENCIA = SCDP.VIGENCIA and SN.DEPENDENCIA = DP.COD_DEPENDENCIA ";
                $cadenaSql.=" and SN.VIGENCIA = RB.VIGENCIA and SN.RUBRO_INTERNO = RB.INTERNO  ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and CDP.NUM_SOL_ADQ = SCDP.ID_SOL_CDP and CDP.CODIGO_COMPANIA = SCDP.CODIGO_COMPANIA  ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and SN.VIGENCIA=" . $variable['vigencia'] . " and ";
                $cadenaSql.="  SN.CODIGO_UNIDAD_EJECUTORA='0" . $variable['unidad_ejecutora'] . "' and CDP.NUMERO_DISPONIBILIDAD=" . $variable['numero_disponibilidad'] . " ";
                $cadenaSql.="  ORDER BY SN.NUM_SOL_ADQ ";

                break;

            case "obtener_cdps_vigencia" :
                $cadenaSql = " SELECT CDP.NUMERO_DISPONIBILIDAD as valor, CDP.NUMERO_DISPONIBILIDAD as informacion ";
                $cadenaSql.=" FROM CO.CO_SOLICITUD_ADQ SN, CO.CO_SOL_CDP SCDP, PR.PR_DISPONIBILIDADES CDP  ";
                $cadenaSql.=" WHERE SN.NUM_SOL_ADQ = SCDP.NUM_SOL_ADQ and SN.VIGENCIA = SCDP.VIGENCIA ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and CDP.NUM_SOL_ADQ = SCDP.ID_SOL_CDP and CDP.CODIGO_COMPANIA = SCDP.CODIGO_COMPANIA  ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and SN.VIGENCIA=" . $variable['vigencia'] . " and CDP.NUMERO_DISPONIBILIDAD NOT IN (" . $variable['cdps_seleccion'] . ") and ";
                $cadenaSql.="  SN.CODIGO_UNIDAD_EJECUTORA='0" . $variable['unidad_ejecutora'] . "' ";
                $cadenaSql.="  ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;


            case "solicitudesRegistradas" :

                $cadenaSql = " select string_agg(cast(numero_solicitud_necesidad as text),',' ";
                $cadenaSql.=" order by numero_solicitud_necesidad) from contrato_general;";

                break;

            case "solicitudesRegistradasNovedades" :

                $cadenaSql = " select string_agg(cast(numero_solicitud as text),',' ";
                $cadenaSql.=" order by numero_solicitud) from adicion where vigencia_adicion = $variable;";

                break;



            case "obtener_cdp_numerosol" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD as valor , CDP.NUMERO_DISPONIBILIDAD as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.VIGENCIA =  CDP.VIGENCIA  and SN.CODIGO_UNIDAD_EJECUTORA =  CDP.CODIGO_UNIDAD_EJECUTORA";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [0] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = " . $variable [1] . " ";
                $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[3]) ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;

            case "dependencia_solicitud_consulta" :
                $cadenaSql = " SELECT  DP.COD_DEPENDENCIA as VALOR, DP.NOMBRE_DEPENDENCIA as INFORMACION   ";
                $cadenaSql .= " FROM CO.CO_DEPENDENCIAS DP ";
                break;




            case "Consultar_Disponibilidad" :
                $cadenaSql = " SELECT CDP.NUMERO_DISPONIBILIDAD, CDP.VIGENCIA, RB.DESCRIPCION, ";
                $cadenaSql.=" CDP.RUBRO_INTERNO , CDP.VALOR ";
                $cadenaSql.=" FROM PR.PR_DISPONIBILIDAD_RUBRO CDP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE CDP.VIGENCIA = RB.VIGENCIA and CDP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and CDP.VIGENCIA = $variable[1] AND CDP.CODIGO_UNIDAD_EJECUTORA='0$variable[2]' ";
                $cadenaSql.=" AND CDP.NUMERO_DISPONIBILIDAD = $variable[0] ";
                break;
            case "Consultar_Rubros" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO, RP.RUBRO_INTERNO,RB.DESCRIPCION, ";
                $cadenaSql.=" RP.VALOR FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_DISPONIBILIDAD=  $variable[0]";
                break;


            case "Consultar_Solicitud_Particular" :
                $cadenaSql = " SELECT NUM_SOL_ADQ, OBJETO as objeto, DEPENDENCIA as dependencia, ";
                $cadenaSql.=" VALOR_CONTRATACION as valor_contrato, JUSTIFICACION as justificacion FROM CO.CO_SOLICITUD_ADQ WHERE ";
                $cadenaSql.=" NUM_SOL_ADQ=$variable[0] and VIGENCIA=$variable[1] ";

                break;



            /*
             *
             *
             */
        }
        return $cadenaSql;
    }

}

?>

