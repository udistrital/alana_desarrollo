<?php

namespace gestionCompras\novedadOrden\registrarNovedadOrden;

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


            //------------------ Consulta Contratos ------------------------


            case 'buscar_contrato' :

                $cadenaSql = " SELECT  DISTINCT cs.numero_contrato_suscrito||'-('||cg.vigencia||')' AS  data, cs.numero_contrato_suscrito||' - ('||cg.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec, contrato_suscrito cs, tipo_contrato tpc   ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora ='" . $variable['unidad'] . "' AND tpc.id = cg.tipo_contrato  ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id AND (ec.id = 4 or ec.id = 2) AND tpc.id_grupo_tipo_contrato = 1  AND cg.vigencia = '" . $variable['vigencia_curso'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = cs.numero_contrato and cg.vigencia = cs.vigencia ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND ( cast(cs.numero_contrato_suscrito as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= " OR cast(cg.vigencia as text ) LIKE '%" . $variable['parametro'] . "%' ) ";
                $cadenaSql .= " ORDER BY data ASC  LIMIT 10 ;";



                break;

            case 'buscar_contratista' :
                $cadenaSql = " SELECT num_documento||' - '||nom_proveedor AS  value, id_proveedor  AS data  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (cast(num_documento as text) LIKE '%" . $variable . "%'  ";
                $cadenaSql .= "  OR nom_proveedor  LIKE '%" . $variable . "%') LIMIT 15; ";
                break;

            //--------------------------------------------------------------


            /**
             * Clausulas específicas para la consulta de ordenes 
             */
            case "tipo_orden" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' and id_grupo_tipo_contrato = 1 ;";

                break;

            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contrato'; ";

                break;



            case "unidad_ejecutora_gasto" :

                $cadenaSql = " SELECT id , nombre   ";
                $cadenaSql .= " FROM kronos.unidad_ejecutora; ";

                break;




            case "consultarOrdenGeneral" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista  as proveedor,o.tipo_orden,cg.clase_contratista,cg.convenio,tpc.tipo_contrato,"
                        . " se.\"ESF_SEDE\" ||'-'|| dep.\"ESF_DEP_ENCARGADA\" as SedeDependencia, cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado,"
                        . "cg.unidad_ejecutora, cs.numero_contrato_suscrito  ";
                $cadenaSql .= "FROM orden o, parametros p, contrato_general cg, \"sedes_SIC\" se, \"dependencia_SIC\" dep, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec, contrato_suscrito cs,  tipo_contrato tpc    ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro AND tpc.id = cg.tipo_contrato  ";
                $cadenaSql .= "AND se.\"ESF_ID_SEDE\" = cg.sede_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND cg.numero_contrato = cs.numero_contrato and cg.vigencia = cs.vigencia ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND dep.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia and tpc.id_grupo_tipo_contrato = 1 ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND cg.estado = 'true' AND cg.vigencia = " . $variable['vigencia_curso'] . " AND (ec.id = 4 or ec.id = 2)   AND cg.clase_contratista is not null ";
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND  cs.numero_contrato_suscrito = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND cg.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND cg.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

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


            case 'Consultar_Info_Acta_inicio' :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= " FROM acta_inicio ai  ";
                $cadenaSql .= " WHERE ai.numero_contrato = '" . $variable[0] . "' and ai.vigencia = " . $variable[1] . " ;";

                break;

            case "buscar_Proveedores" :
                $cadenaSql = " SELECT nit||' - ('||nomempresa||')' AS  value, nit AS data  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info ";
                $cadenaSql .= " WHERE cast(nit as text) LIKE '%$variable%' OR nomempresa LIKE '%$variable%' LIMIT 10; ";
                break;

            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT DISTINCT contratista AS  value, contratista AS data  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE cast(contratista as text) LIKE '%$variable%'  LIMIT 10; ";
                break;



            //----------------Registrar Novedad--------------------

            case "informacion_proveedor" :
                $cadenaSql = " SELECT nit, nomempresa, digitoverificacion,direccion,correo,telefono,pais,  ";
                $cadenaSql .= " tipopersona,primerapellido||' '||segundoapellido||' '||primernombre||' '||segundonombre as nombrerepresentate,"
                        . "tipodocumento,numdocumento,registromercantil  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info  ";
                $cadenaSql .= " WHERE nit= $variable ";

                break;



            case "buscarTerceroCesion" :
                $cadenaSql = " SELECT  num_documento||'-'||nom_proveedor||'-'||tipopersona AS  value, num_documento||'-'||nom_proveedor||' ('||tipopersona||')' AS data  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE cast(num_documento as text) LIKE '%$variable%'  LIMIT 10; ";
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


            case "insertarEstadoNovedadContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_estado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_registro,usuario,estado ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= $variable ['estado'] . ");";

                break;

            case "obtenerInformacionSuspension" :
                $cadenaSql = " select s.id,nc.acto_administrativo, s.fecha_inicio, s.fecha_fin from novedad_contractual nc, suspension s";
                $cadenaSql.=" where nc.id=s.id and numero_contrato = '$variable[0]' and vigencia = $variable[1] and "
                        . "fecha_registro = (select MAX(nc.fecha_registro) ";
                $cadenaSql.=" from novedad_contractual nc, suspension s";
                $cadenaSql.=" where nc.id=s.id );";

                break;


            case "reanudarSuspension" :
                $cadenaSql = "UPDATE suspension SET fecha_reanudacion = '" . $variable['fecha_reanudacion'] . "', ";
                $cadenaSql .= " estado = '" . $variable['estado'] . "', id_reanudacion = " . $variable['id_reanudacion'] . " ";
                $cadenaSql .= "WHERE id = " . $variable['id_suspension'] . "; ";
                break;
            case "ObtenerSupervisor" :
                $cadenaSql = "SELECT * ";
                $cadenaSql .= "FROM supervisor_contrato  ";
                $cadenaSql .= "WHERE documento=" . $variable . "; ";
                break;

            case "insertarSupervisor" :

                $cadenaSql = " INSERT INTO supervisor_contrato( ";
                $cadenaSql .=" nombre, documento, cargo, sede_supervisor, ";
                $cadenaSql .=" dependencia_supervisor, digito_verificacion)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['nombre_supervisor'] . "',";
                $cadenaSql .= $variable ['documento'] . ",";
                $cadenaSql .= "'" . $variable ['cargo'] . "',";
                $cadenaSql .= "'" . $variable ['sede'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia'] . "',";
                $cadenaSql .= $variable ['digito_verificacion'] . ");";
                break;


            case 'Consultar_Contrato_Particular' :
                $cadenaSql = " SELECT DISTINCT  ";
                $cadenaSql .= " cg.vigencia,cs.numero_contrato_suscrito,cg.contratista,ue.id||' - '||ue.nombre as unidad, s.documento ||'-'|| s.nombre as supervisor,  ";
                $cadenaSql .= " cg.numero_solicitud_necesidad, cg.numero_cdp, sede.\"ESF_SEDE\", dependencia.\"ESF_DEP_ENCARGADA\", cg.valor_contrato ,cg.convenio,  ";
                $cadenaSql .= "  cg.clase_contratista, ec.nombre_estado, ec.id as estado_contrato, s.id as idsupervisor ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general cg, supervisor_contrato s, unidad_ejecutora ue, \"sedes_SIC\" sede, ";
                $cadenaSql .= " \"dependencia_SIC\" dependencia, contrato_estado ce, estado_contrato ec, contrato_suscrito cs ";
                $cadenaSql .= " WHERE  cg.unidad_ejecutora = ue.id  and ";
                $cadenaSql .= " cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id and ";
                $cadenaSql .= " cg.numero_contrato = cs.numero_contrato and cg.vigencia = cs.vigencia and ";
                $cadenaSql .= " ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) and ";
                $cadenaSql .= " sede.\"ESF_ID_SEDE\" = cg.sede_solicitante  and ";
                $cadenaSql .= " dependencia.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante  and ";
                $cadenaSql .= " cg.supervisor= s.id and ";
                $cadenaSql .= " cg.numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " cg.vigencia = $variable[1] ; ";
                break;


            case "tipo_novedad" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_novedad' and pr.estado_registro = 't' and pr.id_parametro <> 217 order by pr.descripcion ASC ; ";
                break;

            case "tipo_modificacion" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.id_rel_parametro = 36 and pr.estado_registro = 't' order by pr.descripcion ASC ; ";
                break;

            case "consultarNovedadesContrato" :

                $cadenaSql = " SELECT nc.id, nc.tipo_novedad,p.descripcion, nc.estado, nc.fecha_registro, ";
                $cadenaSql.=" nc.usuario, nc.acto_administrativo, nc.documento, nc.descripcion as observaciones ";
                $cadenaSql.=" FROM argo.novedad_contractual nc, argo.parametros p";
                $cadenaSql.=" WHERE p.id_parametro = nc.tipo_novedad and numero_contrato= '$variable[0]' ";
                $cadenaSql.=" AND vigencia=$variable[1] and nc.tipo_novedad <> 218 and nc.tipo_novedad <> 257 and nc.tipo_novedad <> 224 and nc.tipo_novedad <> 216 and  nc.tipo_novedad <> 217;";
                break;

            case "tipo_novedad_suspendido" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_novedad' and pr.estado_registro = 't' and (pr.id_parametro = 217 or  pr.id_parametro = 234) "
                        . "order by pr.descripcion ASC ; ";
                break;

            case "consultarValorElementos" :

                $cadenaSql = "SELECT id_orden,SUM(total_iva_con) valor ";
                $cadenaSql .= " FROM elemento_acta_recibido  ";
                $cadenaSql .= " WHERE id_orden='" . $variable . "' and estado='t' ";
                $cadenaSql .= " GROUP BY id_orden;  ";
                break;

            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;

            case "tipo_anulacion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=33; ";

                break;

            case "tipo_cambio_supervisor" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=34; ";

                break;

            case "tipo_adicion" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_adicion' and pr.estado_registro = 't' order by pr.descripcion ASC ; ";
                break;

            case "consultarTipoNovedad" :

                $cadenaSql = " SELECT pr.descripcion ";
                $cadenaSql .= " FROM parametros pr ";
                $cadenaSql .= " WHERE pr.id_parametro = $variable ; ";
                break;

            case "vigencias_sica_disponibilidades" :
                $cadenaSql = " SELECT DISTINCT SN.VIGENCIA AS valor, SN.VIGENCIA AS informacion  FROM CO.CO_SOLICITUD_ADQ SN ";
                $cadenaSql .= " WHERE SN.VIGENCIA = $variable ORDER BY SN.VIGENCIA DESC ";

                break;


            case "obtener_solicitudes_vigencia" :
                $cadenaSql = " SELECT SCDP.ID_SOL_CDP as valor, SCDP.NUM_SOL_ADQ as informacion from ";
                $cadenaSql.=" CO.CO_SOL_CDP SCDP, CO.CO_SOLICITUD_ADQ SN where SCDP.NUM_SOL_ADQ = SN.NUM_SOL_ADQ ";
                $cadenaSql.=" and SCDP.VIGENCIA = SN.VIGENCIA and SCDP.VIGENCIA=$variable[0] and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[1]'";
                $cadenaSql.=" ORDER BY SN.NUM_SOL_ADQ ASC";

                break;



            case "obtener_cdp_numerosol" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD as valor , CDP.NUMERO_DISPONIBILIDAD as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.VIGENCIA =  CDP.VIGENCIA  and SN.CODIGO_UNIDAD_EJECUTORA =  CDP.CODIGO_UNIDAD_EJECUTORA";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [0] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = " . $variable [1] . " ";
                $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[3]) and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[4]) ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;



            case "obtener_cdp_numerosol_editar" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD as valor , CDP.NUMERO_DISPONIBILIDAD as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [0] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = " . $variable [1] . " ";
                $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[3])  ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;

            case "Consultar_RpsxCdp" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO as valor,  RP.NUMERO_REGISTRO||' ('|| RP.RUBRO_INTERNO ||'-'|| RB.DESCRIPCION ||')' as informacion ";
                $cadenaSql.=" FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB ";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_DISPONIBILIDAD=  $variable[0]";
                break;

            case "Consultar_Info_Registro" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO, RP.RUBRO_INTERNO,RB.DESCRIPCION, ";
                $cadenaSql.=" RP.VALOR FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_REGISTRO=  $variable[0]";
                break;

            case "info_disponibilidad" :
                $cadenaSql = " SELECT CDP.FECHA_REGISTRO AS FECHA , SN.VALOR_CONTRATACION AS VALOR  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [2] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[3]'  and SN.NUM_SOL_ADQ = " . $variable [1] . " and CDP.NUMERO_DISPONIBILIDAD = $variable[0] ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";


                break;


            case "cdpRegistradas" :

                $cadenaSql = " select string_agg(cast(numero_cdp as text),',' ";
                $cadenaSql.=" order by numero_cdp) from contrato_general where vigencia = $variable ;";

                break;

            case "cdpRegistradasNovedades" :

                $cadenaSql = " select string_agg(cast(numero_cdp as text),',' ";
                $cadenaSql.=" order by numero_cdp) from adicion where vigencia_adicion = $variable;";

                break;




            case "consultarContratoGeneral" :

                $cadenaSql = "SELECT DISTINCT  cg.clase_contratista, p.descripcion, cg.tipologia_contrato, cg.numero_contrato, cg.vigencia, cg.fecha_registro, cg.contratista  as proveedor,"
                        . "  cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado, cg.convenio ";
                $cadenaSql .= "FROM  parametros p, contrato_general cg,  ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE  cg.tipologia_contrato = p.id_parametro  ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . "  and cg.tipo_contrato = 2  ";
                $cadenaSql .= "AND (ec.id = 4 or ec.id = 2) AND cg.clase_contratista is not null ";
                if ($variable ['tipo_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipologia_contrato = '" . $variable ['tipo_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND cg.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND cg.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['sede'] != '') {
                    $cadenaSql .= " AND se.\"ESF_ID_SEDE\" = '" . $variable ['sede'] . "' ";
                }

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND dep.\"ESF_CODIGO_DEP\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND cg.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;


            case "consultarContratoIdexud" :

                $cadenaSql = "SELECT DISTINCT c.id_contrato_normal, p.descripcion,cg.tipologia_contrato, c.numero_contrato, c.vigencia, c.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,"
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado, conv.\"NUMERO_PRO\" ";
                $cadenaSql .= "FROM contrato c, parametros p,  contrato_general cg, convenio conv, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE cg.tipologia_contrato = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.convenio_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where c.numero_contrato = cee.numero_contrato and  c.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND c.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND c.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND c.estado_registro = 'true' AND cg.estado_aprobacion = 't' AND ec.id = 4 ";
                if ($variable ['tipo_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipologia_contrato = '" . $variable ['tipo_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND c.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND c.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND conv.\"NUMERO_PRO\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }
                $cadenaSql .= " ; ";

                break;

            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;




            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO='A' ";

                break;
            case "funcionarios_cambio" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO='A' AND FUN_IDENTIFICACION <> $variable ";

                break;
            case "consultaSupervisor" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' -- '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS  WHERE FUN_IDENTIFICACION = $variable ";

                break;


            case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;

            case "consultarBanco" :
                $cadenaSql = "SELECT";
                $cadenaSql .= " id_codigo,";
                $cadenaSql .= "	nombre_banco";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " agora.banco";
                $cadenaSql .= " WHERE estado != 'INACTIVO' ";
                $cadenaSql .= " ORDER BY nombre_banco";
                break;

            case "informacion_contratista_unico" :
                $cadenaSql = " SELECT p.tipopersona, p.num_documento,c.nombre , ";
                $cadenaSql.=" p.direccion, p.correo, p.web, p.puntaje_evaluacion, p.clasificacion_evaluacion, ";
                $cadenaSql.=" pe.valor_parametro, p.tipo_cuenta_bancaria, p.num_cuenta_bancaria, ";
                $cadenaSql.=" eb.nombre_banco, p.fecha_registro, p.nom_proveedor";
                $cadenaSql.=" FROM agora.informacion_proveedor p, agora.parametro_estandar pe, core.ciudad c, core.banco eb ";
                $cadenaSql.=" WHERE pe.id_parametro = p.estado AND p.id_ciudad_contacto = c.id_ciudad";
                $cadenaSql.=" AND eb.id_codigo = p.id_entidad_bancaria AND p.id_proveedor = $variable;";

                break;

            case "informacion_sociedad_temporal_consulta" :
                $cadenaSql = " SELECT p.tipopersona, p.num_documento,c.nombre , ";
                $cadenaSql.=" p.direccion, p.correo, p.web, p.puntaje_evaluacion, p.clasificacion_evaluacion, ";
                $cadenaSql.=" pe.valor_parametro, p.tipo_cuenta_bancaria, p.num_cuenta_bancaria, ";
                $cadenaSql.=" eb.nombre_banco, p.fecha_registro, p.nom_proveedor, pr.num_documento||' - '||pr.nom_proveedor as representante, ";
                $cadenaSql.=" prs.num_documento||' - '||prs.nom_proveedor as representante_suplente ";
                $cadenaSql.=" FROM agora.informacion_proveedor p, agora.parametro_estandar pe, core.ciudad c, core.banco eb,  ";
                $cadenaSql.=" agora.informacion_sociedad_temporal ist, agora.informacion_proveedor pr, agora.informacion_proveedor prs  ";
                $cadenaSql.=" WHERE pe.id_parametro = p.estado AND p.id_ciudad_contacto = c.id_ciudad ";
                $cadenaSql.=" AND ist.id_proveedor_sociedad = p.id_proveedor ";
                $cadenaSql.=" AND ist.representante = pr.id_proveedor ";
                $cadenaSql.=" AND ist.representante_suplente = prs.id_proveedor ";
                $cadenaSql.=" AND eb.id_codigo = p.id_entidad_bancaria AND p.id_proveedor = $variable;";

                break;

            case "nombre_participante" :

                $cadenaSql = " SELECT nom_proveedor, tipopersona,puntaje_evaluacion ";
                $cadenaSql.=" FROM agora.informacion_proveedor WHERE num_documento=$variable; ";

                break;

            case "nombre_participante_natural" :

                $cadenaSql = " SELECT p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  WHERE num_documento_persona=$variable;   ";

                break;


            case "obtener_participantes" :

                $cadenaSql = " SELECT ip.num_documento ||'-'|| ip.nom_proveedor as nombre_participante, istp.porcentaje_participacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_participante istp, agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor = istp.id_contratista AND id_proveedor_sociedad = $variable; ";

                break;



            case "ConsultarInformacionOrden" :
                $cadenaSql = "SELECT DISTINCT ";
                $cadenaSql .= "cg.numero_contrato,cg.vigencia, ";
                $cadenaSql .= "cg.tipo_contrato,cg.unidad_ejecutora, ";
                $cadenaSql .= "cg.fecha_final,cg.plazo_ejecucion, ";
                $cadenaSql .= "cg.objeto_contrato,cg.fecha_inicio, ";
                $cadenaSql .= "cg.forma_pago,cg.ordenador_gasto, ";
                $cadenaSql .= "cg.supervisor,cg.clausula_registro_presupuestal, ";
                $cadenaSql .= "cg.sede_supervisor,cg.dependencia_supervisor,cg.cargo_supervisor, ";
                $cadenaSql .= "cg.sede_solicitante,cg.dependencia_solicitante, ";
                $cadenaSql .= "cg.contratista,o.tipo_orden,o.id_orden, cg.unidad_ejecucion ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contrato_general cg, orden o, ";
                $cadenaSql .= "\"funcionario\" f ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "cg.numero_contrato=o.numero_contrato and  ";
                $cadenaSql .= "cg.vigencia=o.vigencia and ";
                $cadenaSql .= "cg.numero_contrato ='" . $variable['numerocontrato'] . "' and ";
                $cadenaSql .= "cg.vigencia =" . $variable['vigencia'] . "; ";

                break;



            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  \"ORG_NOMBRE\",  \"ORG_IDENTIFICACION\",  \"ORG_IDENTIFICADOR\"  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_ESTADO\" = 'A' and  \"ORG_IDENTIFICADOR_UNICO\" = '$variable';";

                break;

            case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;



            case "ConsultarDescripcionParametro" :
                $cadenaSql = "SELECT descripcion ";
                $cadenaSql .= " FROM parametros ";
                $cadenaSql .= " WHERE id_parametro=" . $variable;

                break;

            case "registroNovedadContractual" :
                $cadenaSql = " INSERT INTO novedad_contractual( ";
                $cadenaSql .= " tipo_novedad, numero_contrato, vigencia, fecha_registro,";
                $cadenaSql .= "  usuario, acto_administrativo, documento, descripcion ) ";
                $cadenaSql .= " VALUES ($variable[0], '$variable[1]', $variable[2], '$variable[3]',";
                $cadenaSql .= " '$variable[4]', '$variable[5]', '$variable[6]', '$variable[7]');";

                break;

            case "registroNovedadModificacion" :
                $cadenaSql = " INSERT INTO modificacion_contractual(";
                $cadenaSql.=" id,tipo, razon, novedad) VALUES ($variable[0], $variable[1],'$variable[2]',$variable[3]) RETURNING id;";

                break;
            case "obtenerIdModificacion" :
                $cadenaSql = " SELECT currval('argo.novedad_contractual_id_seq');";

                break;
            case "consultarTipoAdcion" :
                $cadenaSql = " SELECT tipo_adicion FROM adicion WHERE id =$variable;";

                break;

            case "registroNovedadAdicionPresupuesto" :
                $cadenaSql = " INSERT INTO adicion( ";
                $cadenaSql .= " id, tipo_adicion, numero_solicitud, numero_cdp, valor_presupuesto,vigencia_adicion) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " $variable[3],";
                $cadenaSql .= " $variable[4],";
                $cadenaSql .= " $variable[5]";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadAdicionTiempo" :
                $cadenaSql = " INSERT INTO adicion( ";
                $cadenaSql .= " id, tipo_adicion, unidad_tiempo_ejecucion, valor_tiempo) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " $variable[3]";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadAnulacion" :
                $cadenaSql = " INSERT INTO anulacion( ";
                $cadenaSql .= " id, tipo_anulacion ) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1]";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadCambioSupervisor" :
                $cadenaSql = " INSERT INTO cambio_supervisor( ";
                $cadenaSql .= " id, tipo_cambio,supervisor_antiguo,supervisor_nuevo,fecha_cambio) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " $variable[3],";
                $cadenaSql .= " '$variable[4]'";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadCesion" :
                $cadenaSql = " INSERT INTO cesion( ";
                $cadenaSql .= " id,nuevo_contratista,antiguo_contratista,fecha_cesion) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " '$variable[3]'";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadSuspension" :
                $cadenaSql = " INSERT INTO suspension( ";
                $cadenaSql .= " id,fecha_inicio ,fecha_fin) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " '$variable[1]',";
                $cadenaSql .= " '$variable[2]'";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadTerminacionAnticipada" :
                $cadenaSql = " INSERT INTO terminacion_anticipada(id, fecha)";
                $cadenaSql.= " VALUES (" . $variable[0] . ", '" . $variable[1] . "');";
                break;

            case "registroNovedadReduccion" :
                $cadenaSql = " INSERT INTO reduccion(";
                $cadenaSql.=" id, numero_rp, valor_presupuesto, vigencia)";
                $cadenaSql.=" VALUES (" . $variable[0] . "," . $variable[1] . ", " . $variable[2] . "," . $variable[3] . ");";
                break;

            case "actualizarSupervisor" :
                $cadenaSql = "  UPDATE contrato_general ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " supervisor = $variable[0] ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[1]' and vigencia = $variable[2]; ";
                break;

            case "actualizarContratista" :
                $cadenaSql = "  UPDATE contrato_general ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " contratista = $variable[0] , ";
                $cadenaSql .= " clase_contratista = $variable[4]  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[2]' and vigencia = $variable[3];";
                break;

            case "acumuladoAdiciones" :
                $cadenaSql = "  SELECT SUM(valor_presupuesto) as acumulado  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc  ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;
            case "acumuladoReducciones" :
                $cadenaSql = "  SELECT SUM(valor_presupuesto) as acumulado  ";
                $cadenaSql .= " FROM reduccion r , novedad_contractual nc  ";
                $cadenaSql .= " WHERE r.id = nc.id AND numero_contrato = '$variable[0]' AND nc.vigencia = $variable[1];";
                break;

            case "acumuladoAdicionesTiempo" :
                $cadenaSql = "  SELECT SUM(valor_tiempo) as acumulado  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc  ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;

            case "tiempo_contrato" :
                $cadenaSql = "  SELECT unidad_ejecucion, plazo_ejecucion ";
                $cadenaSql .= " FROM contrato_general  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;



            case "consultarAdcionesPresupuesto" :
                $cadenaSql = "  SELECT nc.*, a.numero_solicitud, a.numero_cdp, a.valor_presupuesto, a.tipo_adicion ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc    ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND tipo_adicion = 248;";
                break;


            case "consultarAdcionesTiempo" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as unidad_tiempo_ejecucion, a.valor_tiempo, a.tipo_adicion  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc, parametros pr    ";
                $cadenaSql .= " WHERE a.id = nc.id AND a.unidad_tiempo_ejecucion = pr.id_parametro ";
                $cadenaSql .= " AND tipo_adicion = 249 AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ;";
                break;

            case "consultarAnulaciones" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as parametro_anulacion  ";
                $cadenaSql .= " FROM anulacion n , novedad_contractual nc, parametros pr    ";
                $cadenaSql .= " WHERE n.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND pr.id_parametro= n.tipo_anulacion;";
                break;

            case "consultarSuspensiones" :
                $cadenaSql = "  SELECT nc.*, s.fecha_inicio, s.fecha_fin, s.fecha_reanudacion ";
                $cadenaSql .= " FROM suspension s , novedad_contractual nc   ";
                $cadenaSql .= " WHERE s.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1]; ";
                break;

            case "consultaCesiones" :
                $cadenaSql = "  SELECT nc.*, c.nuevo_contratista, c.antiguo_contratista, c.fecha_cesion  ";
                $cadenaSql .= " FROM cesion c , novedad_contractual nc   ";
                $cadenaSql .= " WHERE c.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1]; ";
                break;

            case "ConsultaReducciones" :
                $cadenaSql = "  SELECT nc.*, r.numero_rp, r.valor_presupuesto  ";
                $cadenaSql .= " FROM reduccion r , novedad_contractual nc   ";
                $cadenaSql .= " WHERE r.id = nc.id AND numero_contrato = '$variable[0]' AND nc.vigencia = $variable[1]; ";
                break;

            case "ConsultaReduccionModificacion" :
                $cadenaSql = "  SELECT nc.*, r.numero_rp, r.valor_presupuesto, r.vigencia  ";
                $cadenaSql .= " FROM reduccion r , novedad_contractual nc   ";
                $cadenaSql .= " WHERE r.id = nc.id AND nc.id = $variable; ";
                break;

            case "consultarTercero" :
                $cadenaSql = "  SELECT nom_proveedor ";
                $cadenaSql .= " FROM agora.informacion_proveedor   ";
                $cadenaSql .= " WHERE num_documento = $variable; ";
                break;

            case "ConsultacambioSupervisor" :
                $cadenaSql = "  SELECT nc.*, cs.supervisor_antiguo, cs.supervisor_nuevo, cs.fecha_cambio, pr.descripcion as tipoCambio_parametro ";
                $cadenaSql .= " FROM cambio_supervisor cs , novedad_contractual nc, parametros pr   ";
                $cadenaSql .= " WHERE cs.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND cs.tipo_cambio = pr.id_parametro;";
                break;

            case "ConsultaOtras" :
                $cadenaSql = "  SELECT nc.numero_contrato,nc.vigencia,nc.estado,nc.fecha_registro,nc.usuario,nc.acto_administrativo, ";
                $cadenaSql .= "  nc.documento, nc.descripcion, pr.descripcion as parametro_descripcion, nc.id, nc.tipo_novedad ";
                $cadenaSql .= " FROM novedad_contractual nc, parametros pr  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[0]' AND vigencia = $variable[1] AND pr.id_parametro = nc.tipo_novedad ";
                $cadenaSql .= " AND  nc.tipo_novedad = 217; ";
                break;

            case "consultarAdcionPresupuesto" :
                $cadenaSql = "  SELECT nc.*, a.numero_solicitud, a.numero_cdp, a.valor_presupuesto, a.tipo_adicion, a.vigencia_adicion ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc    ";
                $cadenaSql .= " WHERE a.id = nc.id AND nc.id = $variable; ";

                break;


            case "consultarAdcionTiempo" :
                $cadenaSql = "  SELECT nc.*, a.valor_tiempo, a.tipo_adicion, a.unidad_tiempo_ejecucion  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc ";
                $cadenaSql .= " WHERE a.id = nc.id  ";
                $cadenaSql .= " AND  nc.id = $variable;";
                break;

            case "consultarAnulacion" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as parametro_anulacion, n.tipo_anulacion  ";
                $cadenaSql .= " FROM anulacion n , novedad_contractual nc, parametros pr    ";
                $cadenaSql .= " WHERE n.id = nc.id AND nc.id = $variable  ";
                $cadenaSql .= " AND pr.id_parametro= n.tipo_anulacion;";
                break;

            case "consultarSuspension" :
                $cadenaSql = "  SELECT nc.*, s.fecha_inicio, s.fecha_fin ";
                $cadenaSql .= " FROM suspension s , novedad_contractual nc   ";
                $cadenaSql .= " WHERE s.id = nc.id AND nc.id = $variable; ";
                break;

            case "consultarInfoNovedadModificacion" :
                $cadenaSql = "  SELECT nc.*, mc.novedad, mc.razon ";
                $cadenaSql .= " FROM modificacion_contractual mc , novedad_contractual nc   ";
                $cadenaSql .= " WHERE mc.id = nc.id AND nc.id = $variable; ";
                break;

            case "consultaCesion" :
                $cadenaSql = "  SELECT nc.*, c.nuevo_contratista, c.antiguo_contratista, c.fecha_cesion  ";
                $cadenaSql .= " FROM cesion c , novedad_contractual nc   ";
                $cadenaSql .= " WHERE c.id = nc.id AND nc.id = $variable; ";
                break;

            case "ConsultarcambioSupervisorPaticular" :
                $cadenaSql = "  SELECT nc.*, cs.supervisor_antiguo, cs.supervisor_nuevo, cs.fecha_cambio,cs.tipo_cambio  ";
                $cadenaSql .= " FROM cambio_supervisor cs , novedad_contractual nc   ";
                $cadenaSql .= " WHERE cs.id = nc.id AND nc.id = $variable; ";
                break;

            case "validarSupervisor" :
                $cadenaSql = "  SELECT id FROM supervisor_contrato WHERE documento = $variable;  ";
                break;

            case "cargos_existentes" :
                $cadenaSql = " SELECT  DISTINCT FUN_CARGO";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ORDER BY FUN_CARGO ASC";
                break;
            case "cargoSuper" :

                $cadenaSql = " SELECT  FUN_CARGO ";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable ";

                break;


            case "ConsultaOtra" :
                $cadenaSql = "  SELECT nc.numero_contrato,nc.vigencia,nc.estado,nc.fecha_registro,nc.usuario,nc.acto_administrativo, ";
                $cadenaSql .= "  nc.documento, nc.descripcion, pr.descripcion as parametro_descripcion, nc.id, nc.tipo_novedad ";
                $cadenaSql .= " FROM novedad_contractual nc, parametros pr  ";
                $cadenaSql .= " WHERE nc.id = $variable AND pr.id_parametro = nc.tipo_novedad;";
                break;

            case "ConsultaSupervisorNovedad" :
                $cadenaSql = "   SELECT FUN_IDENTIFICACION ||' - '|| FUN_NOMBRE ";
                $cadenaSql .= "  FROM SICAARKA.FUNCIONARIOS WHERE FUN_IDENTIFICACION = $variable ";
                break;

            case "consultarInfoGeneralNovedad" :
                $cadenaSql = "   SELECT acto_administrativo,descripcion,documento ";
                $cadenaSql .= "  FROM novedad_contractual WHERE id = $variable ";
                break;


            case "updateNovedadContractualconArchivo" :
                $cadenaSql = " UPDATE novedad_contractual";
                $cadenaSql.=" SET acto_administrativo= '$variable[5]', documento='$variable[6]', ";
                $cadenaSql.=" descripcion='$variable[7]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "updateNovedadContractualsinArchivo" :
                $cadenaSql = " UPDATE novedad_contractual";
                $cadenaSql.=" SET acto_administrativo= '$variable[5]', ";
                $cadenaSql.=" descripcion='$variable[7]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "updateNovedadAdicionPresupuesto" :
                $cadenaSql = " UPDATE adicion ";
                $cadenaSql.=" SET  numero_solicitud=$variable[2], ";
                $cadenaSql.=" numero_cdp=$variable[3], valor_presupuesto=$variable[4], vigencia_adicion = $variable[5] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;
            case "updateNovedadAdicionTiempo" :
                $cadenaSql = " UPDATE adicion ";
                $cadenaSql.=" SET  unidad_tiempo_ejecucion=$variable[2], ";
                $cadenaSql.=" valor_tiempo=$variable[3] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;

            case "updateNovedadAnulacion" :
                $cadenaSql = " UPDATE anulacion ";
                $cadenaSql.=" SET  tipo_anulacion=$variable[1] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;

            case "updateNovedadReduccion" :
                $cadenaSql = " UPDATE reduccion ";
                $cadenaSql.=" SET  numero_rp=$variable[1], valor_presupuesto=$variable[2], vigencia= $variable[3] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;

            case "updateNovedadCambioSupervisor" :
                $cadenaSql = " UPDATE cambio_supervisor";
                $cadenaSql.=" SET  tipo_cambio=$variable[1], supervisor_antiguo='$variable[2]', ";
                $cadenaSql.=" supervisor_nuevo='$variable[3]', fecha_cambio='$variable[4]'";
                $cadenaSql.=" WHERE id=$variable[0] ;";
                break;

            case "updateNovedadCesion" :
                $cadenaSql = " UPDATE cesion";
                $cadenaSql.=" SET  nuevo_contratista=$variable[1],";
                $cadenaSql.=" antiguo_contratista=$variable[2], fecha_cesion='$variable[3]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "updateNovedadSuspension" :
                $cadenaSql = " UPDATE suspension";
                $cadenaSql.=" SET fecha_inicio='$variable[1]', fecha_fin='$variable[2]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "insertarDatosModificados" :
                $cadenaSql = " UPDATE modificacion_contractual";
                $cadenaSql.=" SET datos_modificados='$variable[1]', datos_antiguos='$variable[2]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "ConsultarCDPContrato" :
                $cadenaSql = " 	SELECT numero_cdp  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE numero_contrato = '" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";
                break;

            case "Consultar_rps" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO, RP.NUMERO_REGISTRO ";
                $cadenaSql.=" FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_DISPONIBILIDAD=  $variable[0]";
                break;

            case "informacion_RP" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO, RP.RUBRO_INTERNO,DESCRIPCION, ";
                $cadenaSql.=" RP.VALOR FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_REGISTRO=  $variable[0]";
                break;

//------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------
            case "sedeConsulta" :
                $cadenaSql = "SELECT DISTINCT  ESF_ID_SEDE  ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE   ESF_ESTADO='A'";
                $cadenaSql .= " AND  ESF_ID_ESPACIO='" . $variable . "' ";
                break;



            case "consultarConvenioDocumento" :
                $cadenaSql = "SELECT \"NOMBRE\" FROM convenio WHERE \"NUMERO_PRO\" = '$variable';";

                break;

            case "consultarSede" :
                $cadenaSql = " SELECT \"ESF_SEDE\" FROM  \"sedes_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_ID_SEDE\" = '$variable';  ";
                break;


            case "consultarDependencia" :
                $cadenaSql = " SELECT \"ESF_DEP_ENCARGADA\" FROM  \"dependencia_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_CODIGO_DEP\" = '$variable';  ";
                break;



            case "consultarDependenciaSupervisor" :
                $cadenaSql = " SELECT   ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= "FROM ESPACIOS_FISICOS  ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";
                break;

            case "consultarSolicitante" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= "dependencia, rubro ";
                $cadenaSql .= " FROM solicitante_servicios ";
                $cadenaSql .= " WHERE id_solicitante='" . $variable . "'";

                break;

            //Documento OtroSI


            case "infoContratoGeneralDocumento" :
                $cadenaSql = " SELECT cg.* ";
                $cadenaSql .= "  FROM contrato_general cg ";
                $cadenaSql .= " WHERE cg.numero_contrato='$variable[0]' and cg.vigencia = $variable[1];  ";
                break;

            case "consultaParametro" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;

            case "consultaContratistaDocumento" :
                $cadenaSql = " SELECT * FROM agora.informacion_proveedor WHERE num_documento = $variable; ";
                break;

            case "ordenadorDocumento" :
                $cadenaSql = " 	SELECT \"ORG_ORDENADOR_GASTO\" as ordenador , \"ORG_NOMBRE\" as nombre , \"ORG_IDENTIFICACION\" as identificacion  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_IDENTIFICADOR_UNICO\" ='$variable';";
                break;

            case 'consultarEstadoContrato' :
                $cadenaSql = " SELECT ce.estado, ec.nombre_estado  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND cg.numero_contrato = '" . $variable[0] . "' and cg.vigencia = " . $variable[1] . " ;";

                break;

            case 'consultarConsecutivoUnicoSuscrito' :
                $cadenaSql = " SELECT numero_contrato_suscrito  ";
                $cadenaSql .= " FROM contrato_suscrito cs  ";
                $cadenaSql .= " WHERE cs.numero_contrato = '" . $variable[0] . "' and cs.vigencia = " . $variable[1] . " ;";

                break;

            case 'Consultar_Info_Suscripcion' :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= " FROM contrato_suscrito cs  ";
                $cadenaSql .= " WHERE cs.numero_contrato = '" . $variable[0] . "' and cs.vigencia = " . $variable[1] . " ;";

                break;
        }
        return $cadenaSql;
    }

}

?>
