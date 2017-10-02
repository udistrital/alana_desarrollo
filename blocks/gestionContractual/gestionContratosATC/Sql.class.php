<?php

namespace gestionContractual\gestionContratosATC\funcion;

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
            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora  ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "ordenesATC" :
                $cadenaSql = "SELECT id_parametro,descripcion  ";
                $cadenaSql .= "FROM parametros  ";
                $cadenaSql .= "WHERE rel_parametro=35; ";
                break;

            case "vigencias" :
                $cadenaSql = "SELECT distinct cg.vigencia as value, cg.vigencia as data ";
                $cadenaSql .= "FROM contrato_general cg; ";

                break;

           case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;


            case "consultarContratosGeneral" :

                $cadenaSql = "SELECT DISTINCT cg.clase_contratista,p.descripcion, cg.numero_contrato, cg.vigencia, cg.fecha_registro, cg.contratista as proveedor,cg.tipologia_contrato,tpc.tipo_contrato, "
                        . "  cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado, cg.convenio, ec.id as estado_contrato, cs.numero_contrato_suscrito  ";
                $cadenaSql .= "FROM parametros p, contrato_general cg, tipo_contrato tpc, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec, contrato_suscrito cs  ";
                $cadenaSql .= "WHERE cg.tipologia_contrato = p.id_parametro ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND cg.numero_contrato = cs.numero_contrato and cg.vigencia = cs.vigencia AND  cg.tipo_contrato = tpc.id  ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . "   and tpc.id_grupo_tipo_contrato = 2   ";
                $cadenaSql .= "AND cg.estado = 'true'  AND ec.id = " . $variable ['estado'] . " AND cg.vigencia = ".$variable['vigencia']."  ";

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;




            case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
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

            case 'Consultar_Contrato_Particular' :
                $cadenaSql = " SELECT DISTINCT  ";
                $cadenaSql .= " cg.vigencia,cs.numero_contrato_suscrito,cg.contratista,ue.id||' - '||ue.nombre as unidad, s.documento ||'-'|| s.nombre as supervisor,  ";
                $cadenaSql .= " cg.numero_solicitud_necesidad, cg.numero_cdp, sede.\"ESF_SEDE\", dependencia.\"ESF_DEP_ENCARGADA\", cg.valor_contrato ,cg.convenio,  ";
                $cadenaSql .= "  cg.clase_contratista, ec.nombre_estado, ec.id as estado_contrato ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general cg, supervisor_contrato s, unidad_ejecutora ue, \"sedes_SIC\" sede, ";
                $cadenaSql .= " \"dependencia_SIC\" dependencia, contrato_estado ce, estado_contrato ec , contrato_suscrito cs ";
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

            case 'registrarLiquidacion' :
                $cadenaSql = " INSERT INTO argo.contrato_liquidado(";
                $cadenaSql.=" numero_contrato, vigencia, ";
                $cadenaSql.=" fecha_registro, usuario, fecha_liquidacion, ";
                $cadenaSql.=" numero_acto, observaciones, documento)";
                $cadenaSql.=" VALUES ( '" . $variable['numero_contrato'] . "', " . $variable['vigencia'] . ", '" . $variable['fecha_registro'] . "',";
                $cadenaSql.=" '" . $variable['usuario'] . "', '" . $variable['fecha_liquidacion'] . "', '" . $variable['numero_acto'] . "', ";
                $cadenaSql.=" '" . $variable['observaciones'] . "', '" . $variable['documento'] . "');";
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
        }
        return $cadenaSql;
    }

}

?>
