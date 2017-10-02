<?php

namespace gestionCompras\consultaOrden;

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
                $cadenaSql = " SELECT  DISTINCT cg.numero_contrato||'-('||cg.vigencia||')' AS  data, cg.numero_contrato||' - ('||cg.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec, tipo_contrato tpc   ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora ='" . $variable['unidad'] . "' AND tpc.id = cg.tipo_contrato ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id AND ec.id =1 AND tpc.id_grupo_tipo_contrato = 1 AND cg.vigencia = '" . $variable['vigencia_curso'] . "' ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND ( cast(cg.numero_contrato as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= " OR cast(cg.vigencia as text ) LIKE '%" . $variable['parametro'] . "%' ) ";
                $cadenaSql .= " ORDER BY data ASC  LIMIT 10 ;";
                break;
                
              case "obtenerAmparosParametros" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos; ";

                break;  

               case "eliminarContratoPolizasGeneral" :
                $cadenaSql = " DELETE FROM argo.amparo_contrato WHERE numero_contrato='".$variable['numero_contrato']."' AND vigencia_contrato=".$variable['vigencia']."; ";
     
                break; 

                 case "obtenerAmparosParametros2" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos WHERE id=".$variable." ; ";
                 
                break;

                case "consultaContratoAmparo" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= "  FROM argo.amparo_contrato cga ";
                $cadenaSql .= " WHERE cga.numero_contrato='".$variable[0]."' AND cga.vigencia_contrato=".$variable[1]." ORDER BY id;  ";
                
                
                break;
            case 'buscar_contratista' :
                $cadenaSql = " SELECT num_documento||' - '||nom_proveedor AS  value, id_proveedor  AS data  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (cast(num_documento as text) LIKE '%" . $variable . "%'  ";
                $cadenaSql .= "  OR nom_proveedor  LIKE '%" . $variable . "%') LIMIT 15; ";
                break;


                  case "insertarContratoPolizaGeneral" :

                $cadenaSql = " INSERT INTO argo.amparo_contrato( ";
                $cadenaSql .="   vigencia, tipo_amparo,suficiencia, ";
                $cadenaSql .="   numero_contrato, vigencia_contrato) ";
                $cadenaSql .= " VALUES ('";               
                $cadenaSql .= $variable ['vigencia_amparo'] . "',";
                $cadenaSql .= $variable ['amparo'] . ",";
                $cadenaSql .= $variable ['suficiencia'] . ",";
                $cadenaSql .= "'".$variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia_contrato'] . ");";
         

              
                break;


                  case "obtenerAmparosParametrosNoRegistrados" :
                $cadenaSql = " SELECT amparos.id, amparos.nombre FROM core.amparos ";
                $cadenaSql .= " where not exists (SELECT id FROM argo.amparo_contrato ";
                $cadenaSql .= " WHERE numero_contrato='".$variable[0]."' AND vigencia_contrato=".$variable[1]." ";
                $cadenaSql .= " AND tipo_amparo=amparos.id) ";
           
                break;
            //--------------------------------------------------------------

            /**
             * Clausulas específicas
             */
            case "tipo_orden" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' and id_grupo_tipo_contrato = 1 ;";

                break;

            case "unidad_ejecutora_gasto" :

                $cadenaSql = " SELECT id , nombre   ";
                $cadenaSql .= " FROM kronos.unidad_ejecutora; ";

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
                $cadenaSql .= " JOIN \"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
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
            case "obtenerTipoPersona" :

                $cadenaSql = "SELECT tipopersona   ";
                $cadenaSql .= " FROM  agora.informacion_proveedor ";
                $cadenaSql .= "WHERE id_proveedor=$variable; ";
                break;
            case "dependenciasConsultadasNulo" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A' ; ";

                break;

            case "dependenciasElemetos" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"dependencia_SIC\" ";
                break;



            case "buscar_Proveedores" :
                $cadenaSql = " SELECT nit||' - ('||nomempresa||')' AS  value, nit AS data  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info ";
                $cadenaSql .= " WHERE cast(nit as text) LIKE '%$variable%' OR nomempresa LIKE '%$variable%' LIMIT 10; ";
                break;

            case "informacion_proveedor" :
                $cadenaSql = " SELECT nit, nomempresa, digitoverificacion,direccion,correo,telefono,pais,  ";
                $cadenaSql .= " tipopersona,primerapellido||' '||segundoapellido||' '||primernombre||' '||segundonombre as nombrerepresentate,"
                        . "tipodocumento,numdocumento,registromercantil  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info  ";
                $cadenaSql .= " WHERE nit= $variable ";

                break;


            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT DISTINCT contratista AS  value, contratista AS data  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE cast(contratista as text) LIKE '%$variable%' LIMIT 10; ";
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

            case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;

            case "buscar_participante" :

                $cadenaSql = " SELECT p.num_documento AS  data,  p.num_documento||'-('||p.nom_proveedor||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_proveedor p  ";
                $cadenaSql .= " WHERE (tipopersona = 'NATURAL' or  tipopersona = 'JURIDICA') AND  cast(p.num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR p.nom_proveedor  LIKE '%" . $variable . "%'  ";
                $cadenaSql .= " LIMIT 20;";

                break;

            case "consultarOrdenGeneral" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista  as proveedor,o.tipo_orden,cg.clase_contratista,cg.convenio, tpc.tipo_contrato,"
                        . " se.\"ESF_SEDE\" ||'-'|| dep.\"ESF_DEP_ENCARGADA\" as SedeDependencia, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado,cg.unidad_ejecutora  ";
                $cadenaSql .= "FROM orden o, parametros p, contrato_general cg, \"sedes_SIC\" se, \"dependencia_SIC\" dep, tipo_contrato tpc, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro AND tpc.id = cg.tipo_contrato ";
                $cadenaSql .= "AND se.\"ESF_ID_SEDE\" = cg.sede_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND dep.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia and tpc.id_grupo_tipo_contrato = 1 ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND cg.estado = 'true' AND cg.vigencia = " . $variable['vigencia_curso'] . " AND ec.id =1  AND cg.clase_contratista is not null ";

                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND  cg.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
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


                $cadenaSql .= " ORDER BY o.numero_contrato DESC; ";

                break;

            case "consultarOrdenIdexud" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,conv.\"NUMERO_PRO\","
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado ,cg.unidad_ejecutora ";
                $cadenaSql .= "FROM orden o, parametros p,  contrato_general cg, convenio conv, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.convenio_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND o.estado = 'true' AND cg.estado_aprobacion = 'f' AND cg.vigencia = " . $variable['vigencia_curso'] . " ";
                if ($variable ['tipo_orden'] != '') {
                    $cadenaSql .= " AND o.tipo_orden = '" . $variable ['tipo_orden'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND o.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND o.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND conv.\"NUMERO_PRO\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND o.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;


            case "validacionpoliza" :

                $cadenaSql = "SELECT descripcion  id, descripcion valor   ";
                $cadenaSql .= " FROM parametros  WHERE rel_parametro = 37; ";

                break;


            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza, estado ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza ORDER BY id_poliza; ";
                break;

            case "consultarFechaparaSuscribir" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " fecha_registro ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general ";
                $cadenaSql .= " WHERE numero_contrato ='" . $variable['numero_contrato'] . "' AND vigencia =" . $variable['vigencia'] . ";  ";
                break;

            case "consultarFechaMinimaParaSuscribir" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " MIN(fecha_registro) ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general ";
                $cadenaSql .= " WHERE CAST(numero_contrato as integer) IN (" . $variable[0] . ") AND vigencia=$variable[1] ;  ";
                break;


            case "cambioEstadoAprobarContrato" :
                $cadenaSql = " INSERT INTO contrato_estado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_registro,usuario,estado ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= $variable ['estado'] . ");";

                break;
            case "actualizar_sociedad_temporal" :

                $cadenaSql = " UPDATE  agora.informacion_sociedad_temporal SET ";
                $cadenaSql.=" documento_representante=" . $variable['documento_representante'] . ", ";
                $cadenaSql.=" documento_suplente=" . $variable['documento_suplente'] . ", ";
                $cadenaSql.=" digito_verificacion=" . $variable['digito_verificacion'] . " ";
                $cadenaSql.=" WHERE identificacion=" . $variable['identificacion'] . "; ";

                break;

            case "eliminar_participantes_actuales" :

                $cadenaSql = " DELETE FROM agora.informacion_sociedad_participante WHERE id_sociedad = $variable;";

                break;
            case "registrar_participante_sociedad" :

                $cadenaSql = "INSERT INTO agora.informacion_sociedad_participante(";
                $cadenaSql.=" id_sociedad, documento_contratista, ";
                $cadenaSql.=" porcentaje_participacion ";
                $cadenaSql.=" )VALUES ( " . $variable['id_sociedad'] . ", " . $variable['documento_contratista'] . ", " . $variable['porcentaje_participacion'] . " );";
                break;
            case "actualizar_telefono_sociedad" :

                $cadenaSql = " UPDATE agora.telefono SET numero_tel = " . $variable['telefono'] . " ";
                $cadenaSql.=" WHERE id_telefono = (SELECT pt.id_telefono ";
                $cadenaSql.=" FROM agora.proveedor_telefono pt, agora.informacion_proveedor ip";
                $cadenaSql.=" WHERE pt.id_proveedor = ip.id_proveedor ";
                $cadenaSql.=" AND ip.num_documento = " . $variable['num_documento'] . ") ; ";

                break;



            case "actualizar_porcentajes_participantes" :

                $cadenaSql = " UPDATE agora.informacion_sociedad_participante SET";
                $cadenaSql.=" porcentaje_participacion=" . $variable['porcentaje'] . "  ";
                $cadenaSql.=" WHERE id_participante=" . $variable['id'] . " AND porcentaje_participacion != " . $variable['porcentaje'] . " ; ";

                break;
            case "ObtenerSupervisor" :
                $cadenaSql = "SELECT * ";
                $cadenaSql .= "FROM supervisor_contrato  ";
                $cadenaSql .= "WHERE documento=" . $variable . "; ";
                break;

            case "insertarSupervisor" :

                $cadenaSql = " INSERT INTO supervisor_contrato( ";
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

            case "actuaizarSupervisor" :

                $cadenaSql = " UPDATE supervisor_contrato SET ";
                $cadenaSql.=" cargo='" . $variable['cargo'] . "', ";
                $cadenaSql.=" sede_supervisor='" . $variable['sede'] . "', ";
                $cadenaSql.=" dependencia_supervisor='" . $variable['dependencia'] . "', ";
                $cadenaSql.=" tipo=" . $variable['tipo'] . ", ";
                $cadenaSql.=" digito_verificacion=" . $variable['digito_verificacion'] . " ";
                $cadenaSql.=" WHERE documento = " . $variable['documento'] . ";";

                break;

            case 'actualizarLugarEjecucion' :

                $cadenaSql = " UPDATE lugar_ejecucion";
                $cadenaSql.=" SET direccion='" . $variable['direccion'] . "', sede='" . $variable['sede'] . "', ";
                $cadenaSql.=" dependencia='" . $variable['dependencia'] . "', ciudad=" . $variable['ciudad'] . "";
                $cadenaSql.=" WHERE id=" . $variable['lugar_ejecucion'] . ";";
                break;

            case 'insertarLugarEjecucion' :

                $cadenaSql = " INSERT INTO lugar_ejecucion(";
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



            case "polizasDocumento" :
                $cadenaSql = " SELECT p.descripcion_poliza, p.id_poliza, op.fecha_inicio, op.fecha_final FROM poliza p , orden o, orden_poliza op ";
                $cadenaSql .= " WHERE o.id_orden = op.orden and op.poliza = p.id_poliza and op.orden=$variable; ";
                break;

            case "ordenadorDocumento" :

                $cadenaSql = " 	SELECT ORG_ORDENADOR_GASTO as ordenador , ORG_NOMBRE as nombre , ORG_IDENTIFICACION as identificacion  ";
                $cadenaSql .= " FROM SICAARKA.ORDENADORES_GASTO  ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR = $variable ";
                $cadenaSql .= " AND ORG_ESTADO ='A'";
                break;

             case "ordenadorArgoDocumento" :

                $cadenaSql = " 	SELECT o.documento,o.info_resolucion, o.nombre_ordenador, o.rol_ordenador,c.nombre  ";
                $cadenaSql .= " FROM argo.ordenadores o , core.ciudad c  ";
                $cadenaSql .= " WHERE c.id_ciudad = o.id_ciudad AND id_ordenador = ".$variable['ordenador_gasto']." AND fecha_inicio<= '".$variable['fecha_suscripcion']."' AND fecha_fin>= '".$variable['fecha_suscripcion']."'; ";

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

            case "consultarServiciosOrden" :
                $cadenaSql = " SELECT so.* 	";
                $cadenaSql .= " FROM servicio_contrato so  ";
                $cadenaSql .= " WHERE  ";
                $cadenaSql .= " so.numero_contrato='$variable[0]' ";
                $cadenaSql .= " AND so.vigencia=$variable[1]; ";

                break;


            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28 ;";

                break;
            case "tipoComprador" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ";
                $cadenaSql .= " FROM \"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\" ";
                $cadenaSql .= " and p.id_parametro <> 202 ;";

                break;


            case "Consultar_Rubros" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO, RP.RUBRO_INTERNO,RB.DESCRIPCION, ";
                $cadenaSql.=" RP.VALOR FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_DISPONIBILIDAD=  $variable[0]";
                break;



            case "tipoComprador_idexud" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ";
                $cadenaSql .= " FROM \"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\" ";
                $cadenaSql .= " and p.id_parametro = 202 ;";

                break;


            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO != 'I' ";

                break;

            case "cargosFuncionarios" :

                $cadenaSql = " SELECT cargo  as data, cargo  as value ";
               $cadenaSql .= " FROM argo.cargo_supervisor_temporal ";
               $cadenaSql .= " ORDER BY data; ";
                break;


            case "funcionariosElementos" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION, FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO != 'I' ";

                break;
            case "interventores" :
                $cadenaSql = " SELECT ip.num_documento ||'-'||ip.nom_proveedor AS data , ip.num_documento ||'-'||ip.nom_proveedor as value from ";
                $cadenaSql.=" agora.informacion_proveedor ip, agora.informacion_persona_natural ipn ";
                $cadenaSql.=" where ip.num_documento = ipn.num_documento_persona;";
                $cadenaSql.=" ";
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

            case 'buscarDepartamento' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;
            case 'buscarDepartamentosColombia' : // Solo Departamentos de Colombia

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'WHERE id_pais=112';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;

            case 'buscarCiudad' :
                $cadenaSql = 'SELECT DISTINCT ';
                $cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.ciudad ';
                $cadenaSql .= 'ORDER BY NOMBRE;';
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


            case 'buscarPadresCiudad' :
                $cadenaSql = " select p.id_pais, d.id_departamento from core.pais p,core.departamento d,";
                $cadenaSql.=" core.ciudad c where p.id_pais = d.id_pais and d.id_departamento = c.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable ;";
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

            case 'buscarPais' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_pais as ID_PAIS, ';
                $cadenaSql .= 'nombre_pais as NOMBRE, ';
                $cadenaSql .= 'codigo_pais as COD_PAIS ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.pais ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;

            case "buscarDepartamentodeCiudad" :

                $cadenaSql = " select d.id_departamento ";
                $cadenaSql.=" from core.departamento d, core.ciudad c ";
                $cadenaSql.=" where c.id_departamento = d.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable;";

                break;



            case "cargoSuper" :

                $cadenaSql = " SELECT  FUN_CARGO || '('||FUN_DEP_NOM_ACADEMICA||')' ";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable ";

                break;

            case "cargos_existentes" :
                $cadenaSql = " SELECT  DISTINCT FUN_CARGO";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ORDER BY FUN_CARGO ASC";
                break;



            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;



            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  ORG_NOMBRE,  ORG_IDENTIFICACION ";
                $cadenaSql .= " FROM SICAARKA.ORDENADORES_GASTO  ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR = $variable and ORG_ESTADO = 'A'";

                break;


            case "obtenerPolizarOrden" :
                $cadenaSql = " 	SELECT poliza, fecha_inicio, fecha_final ";
                $cadenaSql .= " FROM contrato_poliza ";
                $cadenaSql .= " WHERE numero_contrato='" . $variable['numero_contrato'] . "' AND vigencia= " . $variable['vigencia'] . ";";

                break;

            case "ConsultarDescripcionParametro" :
                $cadenaSql = "SELECT descripcion ";
                $cadenaSql .= " FROM parametros ";
                $cadenaSql .= " WHERE id_parametro=" . $variable;

                break;
            case "insertarContratista" :
                $cadenaSql = " INSERT INTO contratista(";
                $cadenaSql .= " nombre_razon_social,direccion, telefono,digito_verificacion, ";
                $cadenaSql .= " correo,identificacion,tipo_naturaleza,tipo_documento,fecha_registro,nacionalidad, ";
                $cadenaSql .= " nombre_contratista,identificacion_contratista_representante,sitio_web,nombre_acesor, ";
                $cadenaSql .= " ubicacion,procedencia_contratista,cargo_contratista_representante) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['razonSocial'] . "',";
                $cadenaSql .= "'" . $variable ['direcccion'] . "',";
                $cadenaSql .= $variable ['telefono'] . ",";
                $cadenaSql .= $variable ['digito_verificacion'] . ",";
                $cadenaSql .= "'" . $variable ['correo'] . "',";
                $cadenaSql .= "'" . $variable ['nit'] . "',";
                $cadenaSql .= $variable ['tipo_persona'] . ",";
                $cadenaSql .= $variable ['tipo_documento'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['nacionalidad'] . "',";
                $cadenaSql .= "'" . $variable ['nombreRepresentante'] . "',";
                $cadenaSql .= "'" . $variable ['identificacionRepresentante'] . "',";
                $cadenaSql .= "'" . $variable ['sitio_web'] . "',";
                $cadenaSql .= "'" . $variable ['nombre_acesor'] . "',";
                $cadenaSql .= "'" . $variable ['ubicacion_proveedor'] . "',";
                $cadenaSql .= "'" . $variable ['procedencia'] . "',";
                $cadenaSql .= "'" . $variable ['cargo_contratista'] . "');";

                break;
            case "validarContratista" :
                $cadenaSql = "SELECT * From contratista WHERE identificacion=" . $variable;
                ;

                break;

            case "modificarContratista" :
                $cadenaSql = " UPDATE contratista ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " cargo_contratista_representante = '" . $variable['cargo'] . "' ";
                $cadenaSql .= " WHERE identificacion=" . $variable['id'] . ";";

                break;

            case "updateOrden" :
                $cadenaSql = " UPDATE orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " tipo_orden = " . $variable['tipo_orden'] . ", ";
                $cadenaSql .= " poliza = '" . $variable['poliza'] . "' ";
                $cadenaSql .= " WHERE id_orden=" . $variable['id_orden'] . ";";

                break;

            case "actualizarContratoGeneral" :
                $cadenaSql = " UPDATE contrato_general SET ";
                $cadenaSql.=" objeto_contrato='" . $variable['objeto_contrato'] . "', ";
                $cadenaSql.=" plazo_ejecucion=" . $variable['plazo_ejecucion'] . ", ";
                $cadenaSql.=" forma_pago=" . $variable['forma_pago'] . ", ";
                $cadenaSql.=" ordenador_gasto='" . $variable['ordenador_gasto'] . "', ";
                $cadenaSql.=" clausula_registro_presupuestal='" . $variable['clausula_presupuesto'] . "',";
                $cadenaSql.=" sede_solicitante='" . $variable['sede'] . "', ";
                $cadenaSql.=" dependencia_solicitante='" . $variable['dependencia'] . "', ";
                $cadenaSql.=" contratista=" . $variable['contratista'] . ", ";
                $cadenaSql.=" unidad_ejecucion=" . $variable['unidad_ejecucion_tiempo'] . ", ";
                $cadenaSql.=" valor_contrato=" . $variable['valor_contrato'] . ",";
                $cadenaSql.=" justificacion='" . $variable['justificacion'] . "', ";
                $cadenaSql.=" descripcion_forma_pago='" . $variable['descripcion_forma_pago'] . "', ";
                $cadenaSql.=" condiciones='" . $variable['condiciones'] . "', ";
                $cadenaSql.=" actividades='" . $variable['actividades'] . "', ";
                $cadenaSql.=" especificaciones_tecnicas='" . $variable['especificaciones_tecnicas'] . "', ";
                $cadenaSql.=" unidad_ejecutora=" . $variable['unidad_ejecutora'] . ",";
                $cadenaSql.=" tipologia_contrato=" . $variable['tipologia_especifica'] . ", ";
                $cadenaSql.=" tipo_contrato=" . $variable['tipo_orden'] . ", ";
                $cadenaSql.=" tipo_compromiso=" . $variable['tipo_compromiso'] . ", ";
                $cadenaSql.=" modalidad_seleccion=" . $variable['modalidad_seleccion'] . ",";
                $cadenaSql.=" procedimiento=" . $variable['procedimiento'] . ", ";
                $cadenaSql.=" regimen_contratacion=" . $variable['regimen_contratación'] . ", ";
                $cadenaSql.=" tipo_gasto=" . $variable['tipo_gasto'] . ", ";
                $cadenaSql.=" tema_gasto_inversion=" . $variable['tema_gasto_inversion'] . ",";
                $cadenaSql.=" origen_presupueso=" . $variable['origen_presupuesto'] . ", ";
                $cadenaSql.=" origen_recursos=" . $variable['origen_recursos'] . ", ";
                $cadenaSql.=" tipo_moneda=" . $variable['tipo_moneda'] . ", ";
                $cadenaSql.=" valor_contrato_me=" . $variable['valor_contrato_moneda_ex'] . ", ";
                $cadenaSql.=" valor_tasa_cambio=" . $variable['tasa_cambio'] . ", ";
                $cadenaSql.=" tipo_control=" . $variable['tipo_control'] . ", ";
                $cadenaSql.=" observaciones='" . $variable['observacionesContrato'] . "', ";
                $cadenaSql.=" lugar_ejecucion=" . $variable['lugar_ejecucion'] . ", ";
                $cadenaSql.=" supervisor=" . $variable['supervisor'] . ", ";
                $cadenaSql.=" clase_contratista=" . $variable['clase_contratista'] . ", ";
                $cadenaSql.=" convenio='" . $variable['convenio'] . "' ";
                $cadenaSql .= "WHERE numero_contrato='" . $variable ['numero_contrato'] . "' and ";
                $cadenaSql .= "vigencia=" . $variable ['vigencia'] . " ; ";

                break;


            case "insertarContratoDisponibilidad" :
                $cadenaSql = " INSERT INTO contrato_disponibilidad(";
                $cadenaSql.=" numero_cdp, numero_contrato, vigencia,vigencia_cdp)";
                $cadenaSql.=" VALUES (" . $variable['numero_disponibilidad'] . ", '" . $variable['numero_contrato'] . "', " . $variable['vigencia'] . ", " . $variable['vigencia_disponibilidad'] . ");";
                break;

            case "eliminarContratoDisponibilidad" :
                $cadenaSql = " DELETE FROM contrato_disponibilidad  ";
                $cadenaSql.="  WHERE  numero_contrato='" . $variable['numero_contrato'] . "' and vigencia = " . $variable['vigencia'] . ";";
                break;

            case "elimnarPolizas":
                $cadenaSql = "DELETE FROM contrato_poliza WHERE numero_contrato='" . $variable['numero_contrato'] . "' AND vigencia = " . $variable['vigencia'] . ";";
                break;

            case "insertarPoliza" :
                $cadenaSql = " INSERT INTO contrato_poliza(";
                $cadenaSql .= " numero_contrato,vigencia, poliza, fecha_inicio,fecha_final) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= $variable ['poliza'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_inicio'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_final'] . "');";

                break;


            case "updateEstadoAprobacion" :
                $cadenaSql = " UPDATE contrato_general SET estado_aprobacion='t' ";
                $cadenaSql.=" WHERE numero_contrato= '" . $variable['numero_contrato'] . "' and vigencia = " . $variable['vigencia'] . ";";

                break;

            case "aprobarContrato" :
                $cadenaSql = " INSERT INTO contrato_suscrito( ";
                $cadenaSql.=" numero_contrato, vigencia, fecha_registro, fecha_suscripcion, numero_contrato_suscrito, usuario)";
                $cadenaSql.=" VALUES ('" . $variable['numero_contrato'] . "', " . $variable['vigencia'] . ", ";
                $cadenaSql.=" '" . $variable['fecha_registro'] . "' ,'" . $variable['fecha_suscripcion'] . "' ,";
                $cadenaSql.=" '" . $variable['numero_contrato_suscrito'] . "', '" . $variable['usuario'] . "');";

                break;

            case "obtenerNumeroMaximoContratoVigencia" :
                $cadenaSql = " SELECT MAX(CAST(numero_contrato_suscrito AS integer)) AS numero_contrato_suscrito ";
                $cadenaSql.=" FROM argo.contrato_suscrito WHERE numero_contrato_suscrito NOT LIKE '%DVE%' ";
                $cadenaSql.=" AND vigencia = $variable;";
                break;


            case "obteneConsecutivoContratoAprobado" :
                $cadenaSql = " SELECT MAX(consecutivo_contrato) as consecutivo_contrato FROM contrato_aprobado; ";

                break;



            case 'Consultar_Contrato_Particular' :
                $cadenaSql = " SELECT  ";
                $cadenaSql .= " cg.*, s.documento, s.nombre,s.id as idSupervisor, s.cargo,s.sede_supervisor,s.dependencia_supervisor,s.digito_verificacion,  ";
                $cadenaSql .= " o.tipo_orden, o.id_orden, o.poliza , le.direccion, le.sede, le.dependencia, le.ciudad,s.tipo ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general cg, supervisor_contrato s, orden o, lugar_ejecucion le  ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " cg.supervisor= s.id and   cg.lugar_ejecucion = le.id  and ";
                $cadenaSql .= " cg.numero_contrato=o.numero_contrato and  ";
                $cadenaSql .= " cg.vigencia=o.vigencia and ";
                $cadenaSql .= " cg.numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " cg.vigencia = $variable[1] ; ";
                break;

            case "buscar_representante_suplente" :

                $cadenaSql = " SELECT p.num_documento_persona AS  data,  p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  ";
                $cadenaSql .= " WHERE cast(p.num_documento_persona as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " LIMIT 20;";

                break;


            case "informacion_sociedad_proveedor" :

                $cadenaSql = " SELECT num_documento,id_ciudad_contacto,correo,web,";
                $cadenaSql.= " tipo_cuenta_bancaria,num_cuenta_bancaria,";
                $cadenaSql.= " id_entidad_bancaria,nom_proveedor,";
                $cadenaSql.= " documento_representante, documento_suplente,digito_verificacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal, agora.informacion_proveedor  ";
                $cadenaSql.=" WHERE num_documento = identificacion and  num_documento=$variable; ";

                break;
            case "informacion_sociedad_telefono" :
                $cadenaSql = " SELECT t.numero_tel FROM agora.telefono t, ";
                $cadenaSql.=" agora.proveedor_telefono pt, agora.informacion_proveedor ip";
                $cadenaSql.=" WHERE t.id_telefono = pt.id_telefono ";
                $cadenaSql.=" AND pt.id_proveedor = ip.id_proveedor ";
                $cadenaSql.=" AND ip.num_documento = $variable;";
                break;

            case "actualizar_proveedor_sociedad_temporal" :
                $cadenaSql = " UPDATE agora.informacion_proveedor";
                $cadenaSql.=" SET tipopersona='" . $variable['tipopersona'] . "', num_documento=" . $variable['num_documento'] . ", id_ciudad_contacto=" . $variable['id_ciudad_contacto'] . ", ";
                $cadenaSql.=" correo='" . $variable['correo'] . "', web='" . $variable['web'] . "', anexorut='" . $variable['anexorut'] . "', tipo_cuenta_bancaria='" . $variable['tipo_cuenta_bancaria'] . "', ";
                $cadenaSql.=" num_cuenta_bancaria='" . $variable['num_cuenta_bancaria'] . "', id_entidad_bancaria=" . $variable['id_entidad_bancaria'] . ", ";
                $cadenaSql.=" fecha_ultima_modificacion='" . $variable['fecha_ultima_modificacion'] . "', nom_proveedor='" . $variable['nom_proveedor'] . "' ";
                $cadenaSql.=" WHERE num_documento=" . $variable['identificacion_anterior'] . ";";
                break;

            case "nombre_participante_natural" :

                $cadenaSql = " SELECT p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  WHERE num_documento_persona=$variable;   ";

                break;

            case "informacion_sociedad_temporal" :

                $cadenaSql = " SELECT identificacion, documento_representante, documento_suplente,nombre,digito_verificacion ";
                $cadenaSql.=" FROM sociedad_temporal WHERE identificacion=$variable; ";

                break;
            case "nombre_participante" :

                $cadenaSql = " SELECT nom_proveedor, tipopersona,puntaje_evaluacion ";
                $cadenaSql.=" FROM agora.informacion_proveedor WHERE num_documento=$variable; ";

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


            case "obtener_participantes" :

                $cadenaSql = " SELECT ip.num_documento ||'-'|| ip.nom_proveedor as nombre_participante, istp.porcentaje_participacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_participante istp, agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor = istp.id_contratista AND id_proveedor_sociedad = $variable; ";

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

            case "ConsultarDisponibilidadesContrato" :
                $cadenaSql = " SELECT numero_cdp, vigencia_cdp FROM contrato_disponibilidad ";
                $cadenaSql .= " WHERE numero_contrato='" . $variable[0] . "' and vigencia=" . $variable[1] . "; ";

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

            case "vigencias_sica_disponibilidades" :
                $cadenaSql = " SELECT DISTINCT SN.VIGENCIA AS valor, SN.VIGENCIA AS informacion  FROM CO.CO_SOLICITUD_ADQ SN ";
                $cadenaSql .= " ORDER BY SN.VIGENCIA DESC ";

                break;





            case "tipo_compromisoOrden" :

                $cadenaSql = " SELECT id as id, codigo_contraloria|| ' - ' || grupo_contrato as valor";
                $cadenaSql.=" FROM argo.grupo_tipo_contrato WHERE (id = 1 or id = 3) ;";
                break;

            case "tipo_ejecucion_tiempo" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_ejecucion_tiempo'; ";
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

            case "tipo_compromiso" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_compromiso'; ";
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




//------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------

            case "buscarUsuario" :
                $cadenaSql = "SELECT ";
                $cadenaSql .= "FECHA_CREACION, ";
                $cadenaSql .= "PRIMER_NOMBRE ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "USUARIOS ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "`PRIMER_NOMBRE` ='" . $variable . "' ";
                break;

            case "insertarRegistro" :
                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= $prefijo . "registradoConferencia ";
                $cadenaSql .= "( ";
                $cadenaSql .= "`idRegistrado`, ";
                $cadenaSql .= "`nombre`, ";
                $cadenaSql .= "`apellido`, ";
                $cadenaSql .= "`identificacion`, ";
                $cadenaSql .= "`codigo`, ";
                $cadenaSql .= "`correo`, ";
                $cadenaSql .= "`tipo`, ";
                $cadenaSql .= "`fecha` ";
                $cadenaSql .= ") ";
                $cadenaSql .= "VALUES ";
                $cadenaSql .= "( ";
                $cadenaSql .= "NULL, ";
                $cadenaSql .= "'" . $variable ['nombre'] . "', ";
                $cadenaSql .= "'" . $variable ['apellido'] . "', ";
                $cadenaSql .= "'" . $variable ['identificacion'] . "', ";
                $cadenaSql .= "'" . $variable ['codigo'] . "', ";
                $cadenaSql .= "'" . $variable ['correo'] . "', ";
                $cadenaSql .= "'0', ";
                $cadenaSql .= "'" . time() . "' ";
                $cadenaSql .= ")";
                break;

            case "actualizarRegistro" :
                $cadenaSql = "UPDATE ";
                $cadenaSql .= $prefijo . "conductor ";
                $cadenaSql .= "SET ";
                $cadenaSql .= "`nombre` = '" . $variable ["nombre"] . "', ";
                $cadenaSql .= "`apellido` = '" . $variable ["apellido"] . "', ";
                $cadenaSql .= "`identificacion` = '" . $variable ["identificacion"] . "', ";
                $cadenaSql .= "`telefono` = '" . $variable ["telefono"] . "' ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "`idConductor` =" . $_REQUEST ["registro"] . " ";
                break;

            /**
             * Clausulas genéricas.
             * se espera que estén en todos los formularios
             * que utilicen esta plantilla
             */
            case "iniciarTransaccion" :
                $cadenaSql = "START TRANSACTION";
                break;

            case "finalizarTransaccion" :
                $cadenaSql = "COMMIT";
                break;

            case "cancelarTransaccion" :
                $cadenaSql = "ROLLBACK";
                break;



            case "eliminarTemp" :

                $cadenaSql = "DELETE ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= $prefijo . "tempFormulario ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_sesion = '" . $variable . "' ";
                break;

            case "insertarTemp" :
                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= $prefijo . "tempFormulario ";
                $cadenaSql .= "( ";
                $cadenaSql .= "id_sesion, ";
                $cadenaSql .= "formulario, ";
                $cadenaSql .= "campo, ";
                $cadenaSql .= "valor, ";
                $cadenaSql .= "fecha ";
                $cadenaSql .= ") ";
                $cadenaSql .= "VALUES ";

                foreach ($_REQUEST as $clave => $valor) {
                    $cadenaSql .= "( ";
                    $cadenaSql .= "'" . $idSesion . "', ";
                    $cadenaSql .= "'" . $variable ['formulario'] . "', ";
                    $cadenaSql .= "'" . $clave . "', ";
                    $cadenaSql .= "'" . $valor . "', ";
                    $cadenaSql .= "'" . $variable ['fecha'] . "' ";
                    $cadenaSql .= "),";
                }

                $cadenaSql = substr($cadenaSql, 0, (strlen($cadenaSql) - 1));
                break;

            case "rescatarTemp" :
                $cadenaSql = "SELECT ";
                $cadenaSql .= "id_sesion, ";
                $cadenaSql .= "formulario, ";
                $cadenaSql .= "campo, ";
                $cadenaSql .= "valor, ";
                $cadenaSql .= "fecha ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= $prefijo . "tempFormulario ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_sesion='" . $idSesion . "'";
                break;

            /**
             * Clausulas Del Caso Uso.
             */
            case "dependenciasArreglo" :

                $cadenaSql = "SELECT DISTINCT ESF_ID_ESPACIO,ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE ESF_ID_SEDE='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;


            case "cargoSuper" :

                $cadenaSql = "SELECT f.\"cargo\" ";
                $cadenaSql .= "FROM \"funcionario\" f  ";
                $cadenaSql .= "WHERE f.\"identificacion\"='$variable' ";

                break;

            case "sedeConsulta" :
                $cadenaSql = "SELECT DISTINCT  ESF_ID_SEDE  ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE   ESF_ESTADO='A'";
                $cadenaSql .= " AND  ESF_ID_ESPACIO='" . $variable . "' ";
                break;

            case "proveedores" :
                $cadenaSql = " SELECT PRO_NIT,PRO_NIT||' - '||PRO_RAZON_SOCIAL AS proveedor ";
                $cadenaSql .= " FROM PROVEEDORES ";

                break;

            // case "dependencias" :
            // $cadenaSql = "SELECT DISTINCT ESF_COD_SEDE, ESF_NOMBRE_ESPACIO ";
            // $cadenaSql .= " FROM ESPACIOS_FISICOS ";
            // break;
            // case "sede" :
            // $cadenaSql = "SELECT DISTINCT ESF_COD_SEDE, ESF_SEDE ";
            // $cadenaSql .= " FROM ESPACIOS_FISICOS ";
            // break;
            case "informacionPresupuestal" :
                $cadenaSql = "SELECT  vigencia_dispo, numero_dispo, valor_disp, fecha_dip,
									letras_dispo, vigencia_regis, numero_regis, valor_regis, fecha_regis,
									letras_regis  ";
                $cadenaSql .= "FROM informacion_presupuestal_orden ";
                $cadenaSql .= "WHERE id_informacion ='" . $variable . "' ";

                break;



            case "consultarRubro" :
                $cadenaSql = " SELECT \"RUB_NOMBRE_RUBRO\" ";
                $cadenaSql .= " FROM arka_parametros.arka_rubros  ";
                $cadenaSql .= " WHERE  \"RUB_IDENTIFICADOR\"='" . $variable . "'";

                break;



            case "vigencia_contratista" :
                $cadenaSql = "SELECT CON_VIGENCIA AS VALOR , CON_VIGENCIA AS VIGENCIA  ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "GROUP BY CON_VIGENCIA ";
                break;


            case "vigencia_registro" :
                $cadenaSql = "SELECT REP_VIGENCIA AS VALOR,REP_VIGENCIA AS VIGENCIA ";
                $cadenaSql .= "FROM REGISTRO_PRESUPUESTAL ";
                $cadenaSql .= "GROUP BY REP_VIGENCIA ";

                break;

            case "buscar_registro" :
                $cadenaSql = "SELECT  \"REP_IDENTIFICADOR\" AS identificador,\"REP_IDENTIFICADOR\" AS numero ";
                $cadenaSql .= "FROM arka_parametros.arka_registropresupuestal ";
                $cadenaSql .= "WHERE \"REP_VIGENCIA\"='" . $variable [0] . "'";
                $cadenaSql .= "AND  \"REP_NUMERO_DISPONIBILIDAD\"='" . $variable [1] . "'";
                $cadenaSql .= "AND  \"REP_UNIDAD_EJECUTORA\"='" . $variable [2] . "'";
                break;
            case "info_registro" :
                $cadenaSql = "SELECT \"REP_FECHA_REGISTRO\" AS fecha, \"REP_VALOR\" valor ";
                $cadenaSql .= "FROM arka_parametros.arka_registropresupuestal  ";
                $cadenaSql .= "WHERE \"REP_VIGENCIA\"='" . $variable [1] . "'  ";
                $cadenaSql .= "AND  \"REP_IDENTIFICADOR\"='" . $variable [0] . "' ";

                break;

            case "informacion_supervisor" :
                $cadenaSql = " SELECT JEF_NOMBRE,JEF_IDENTIFICADOR ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                $cadenaSql .= " WHERE  JEF_IDENTIFICADOR='" . $variable . "' ";
                break;

            case "informacion_cargo_jefe" :
                $cadenaSql = " SELECT JEF_NOMBRE,JEF_IDENTIFICADOR ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                $cadenaSql .= " WHERE  JEF_IDENTIFICADOR='" . $variable . "' ";
                break;

            case "constratistas" :
                $cadenaSql = " SELECT CON_IDENTIFICADOR,CON_IDENTIFICACION ||' - '|| CON_NOMBRE ";
                $cadenaSql .= "FROM CONTRATISTAS ";

                break;

            case "buscar_nombre_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NOMBRE\"";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;


            case "cargo_jefe" :
                $cadenaSql = " SELECT JEF_IDENTIFICADOR,JEF_DEPENDENCIA_PERTENECIENTE ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                break;

            case "ordenadores_orden" :

                $cadenaSql = " SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO FROM SICAARKA.ORDENADORES_GASTO ";
                $cadenaSql.=" WHERE ORG_ESTADO='A' ";

                break;
            case "ordenadores_orden_idexud" :

                $cadenaSql = " SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO FROM SICAARKA.ORDENADORES_GASTO ";
                $cadenaSql.=" WHERE ORG_ESTADO='A' AND ORG_ORDENADOR_GASTO  LIKE '%IDEXUD%'";

                break;


            case "constratistas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_encargado,";
                $cadenaSql .= "identificacion ||' - '|| nombres ||' 	'||apellidos as contratista ";
                $cadenaSql .= " FROM";
                $cadenaSql .= " encargado ";
                $cadenaSql .= " WHERE id_tipo_encargado='3' AND estado='TRUE'";
                break;

            case "cargo_jefe" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_cargo,";
                $cadenaSql .= "descripcion ";
                $cadenaSql .= " FROM";
                $cadenaSql .= " tipo_cargo ; ";
                break;

            case "dependencia" :
                $cadenaSql = " SELECT DEP_IDENTIFICADOR, DEP_IDENTIFICADOR ||' - ' ||DEP_DEPENDENCIA  ";
                $cadenaSql .= "FROM DEPENDENCIAS ";
                break;

            case 'seleccion_contratista' :
                $cadenaSql = " SELECT id_contratista, ";
                $cadenaSql .= "  identificacion||' - '|| nombre_razon_social contratista ";
                $cadenaSql .= "FROM contratista_servicios;";

                break;




            // _________________________________________________



            case "consultarOrdenServicios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " dependencia_solicitante,rubro,objeto_contrato, poliza1,";
                $cadenaSql .= "poliza2, poliza3, poliza4, duracion_pago, fecha_inicio_pago,";
                $cadenaSql .= "fecha_final_pago, forma_pago, total_preliminar, iva, total,id_contratista,";
                $cadenaSql .= " id_ordenador_encargado,sede, ";
                $cadenaSql .= "id_supervisor ,info_presupuestal ";
                $cadenaSql .= " FROM orden_servicio ";
                $cadenaSql .= " WHERE id_orden_servicio='" . $variable . "' AND estado='TRUE';";
                break;

            case "consultarContratista" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " nombre_razon_social, identificacion,direccion,telefono, cargo ";
                $cadenaSql .= " FROM contratista_servicios ";
                $cadenaSql .= " WHERE id_contratista='" . $variable . "'";

                break;

            case "consultarContratistaDocumento" :
                $cadenaSql = "SELECT CON_IDENTIFICACION , CON_NOMBRE AS CONTRATISTA ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "WHERE CON_VIGENCIA ='" . $variable [1] . "' ";
                $cadenaSql .= "AND  CON_IDENTIFICADOR ='" . $variable [0] . "' ";
                break;

            case "consultarOrdenador_gasto" :
                $cadenaSql = " 	SELECT \"ORG_ORDENADOR_GASTO\",\"ORG_NOMBRE\" ";
                $cadenaSql .= " FROM arka_parametros.arka_ordenadores     ";
                $cadenaSql .= " WHERE     \"ORG_IDENTIFICACION\" ='" . $variable [0] . "'";
                $cadenaSql .= " AND       \"ORG_TIPO_ORDENADOR\"  ='" . $variable [1] . "'";

                break;

            case "consultarOrdenDocumento" :
                $cadenaSql = "SELECT o.id_orden,o.fecha_registro as fecha_registro_orden, cg.* , p.descripcion  as tipo_orden  ";
                $cadenaSql .= "FROM orden o, contrato_general cg, parametros p WHERE o.numero_contrato = cg.numero_contrato AND p.id_parametro = o.tipo_orden    ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia AND o.estado = true AND o.id_orden=$variable;  ";

                break;


            case "consultarSupervisorDocumento" :
                $cadenaSql = " SELECT * FROM SICAARKA.FUNCIONARIOS  ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable  ";
                break;


            case "consultarFormadePago" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;
            case "consultarParametroUnidadTiempoEjecucion" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;
            case "consultarFormadePago" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;

            case "consultarConvenio" :
                $cadenaSql = " SELECT nombre_convenio  FROM convenio  ";
                $cadenaSql .= " WHERE id_convenio = $variable;  ";
                break;

            case "consultarConvenioDocumento" :
                $cadenaSql = "SELECT \"NOMBRE\" FROM convenio WHERE \"NUMERO_PRO\" = '$variable';";

                break;

            case "consultarSede" :
                $cadenaSql = " SELECT \"ESF_SEDE\" FROM  \"sedes_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_ID_SEDE\" = '$variable';  ";
                break;


            case "consultarDependencia" :
                $cadenaSql = " SELECT \"ESF_DEP_ENCARGADA\" FROM \"dependencia_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_CODIGO_DEP\" = '$variable';  ";
                break;

            case "consultarProveedor" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= " FROM contratista ";
                $cadenaSql .= " WHERE identificacion='" . $variable . "'";
                break;

            case "consultarContratistas" :
                $cadenaSql = " SELECT nombres, identificacion, cargo ";
                $cadenaSql .= " FROM contratistas_adquisiones ";
                $cadenaSql .= " WHERE id_contratista_adq='" . $variable . "'";

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

            case "consultarEncargado" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " nombres ||' '||apellidos as nombre, cargo,asignacion  ";
                $cadenaSql .= " FROM encargado ";
                $cadenaSql .= " WHERE id_encargado='" . $variable . "' AND estado=TRUE";

                break;
            // ____________________________________update___________________________________________

            case "actualizarSolicitante" :

                $cadenaSql = " UPDATE ";
                $cadenaSql .= " solicitante_servicios";
                $cadenaSql .= " SET ";
                $cadenaSql .= " dependencia='" . $variable [0] . "',";
                $cadenaSql .= " rubro='" . $variable [1] . "' ";
                $cadenaSql .= "  WHERE id_solicitante='" . $variable [2] . "';";
                break;

            case "actualizarSupervisor" :
                $cadenaSql = " UPDATE supervisor_servicios ";
                $cadenaSql .= " SET nombre='" . $variable [0] . "', ";
                $cadenaSql .= " cargo='" . $variable [1] . "', ";
                $cadenaSql .= " dependencia='" . $variable [2] . "', ";
                $cadenaSql .= " sede='" . $variable [3] . "' ";
                $cadenaSql .= "  WHERE id_supervisor='" . $variable [4] . "';";

                break;

            case "actualizarProveedor" :
                $cadenaSql = " UPDATE proveedor_adquisiones ";
                $cadenaSql .= " SET razon_social='" . $variable [0] . "', ";
                $cadenaSql .= " identificacion='" . $variable [1] . "', ";
                $cadenaSql .= " direccion='" . $variable [2] . "', ";
                $cadenaSql .= " telefono='" . $variable [3] . "' ";
                $cadenaSql .= "  WHERE id_proveedor_adq='" . $variable [4] . "';";

                break;

            case "actualizarContratista" :
                $cadenaSql = " UPDATE contratistas_adquisiones	 ";
                $cadenaSql .= " SET nombres='" . $variable [0] . "', ";
                $cadenaSql .= " identificacion='" . $variable [1] . "', ";
                $cadenaSql .= " cargo='" . $variable [2] . "' ";
                $cadenaSql .= "  WHERE id_contratista_adq='" . $variable [3] . "';";

                break;

            case "actualizarEncargado" :
                $cadenaSql = " UPDATE encargado ";
                $cadenaSql .= " SET id_tipo_encargado='" . $variable [0] . "', ";
                $cadenaSql .= " nombre='" . $variable [1] . "', ";
                $cadenaSql .= " identificacion='" . $variable [2] . "', ";
                $cadenaSql .= " cargo='" . $variable [3] . "', ";
                $cadenaSql .= " asignacion='" . $variable [4] . "' ";
                $cadenaSql .= "  WHERE id_encargado='" . $variable [5] . "';";

                break;

            // UPDATE orden
            // SET id_orden=?, tipo_orden=?, vigencia=?, consecutivo_servicio=?,
            // consecutivo_compras=?, fecha_registro=?, info_presupuestal=?,
            // dependencia_solicitante=?, sede=?, rubro=?, objeto_contrato=?,
            // poliza1=?, poliza2=?, poliza3=?, poliza4=?, duracion_pago=?,
            // fecha_inicio_pago=?, fecha_final_pago=?, forma_pago=?, id_contratista=?,
            // id_supervisor=?, id_ordenador_encargado=?, tipo_ordenador=?,
            // estado=?
            // WHERE <condition>;

            case "actualizarOrden" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " dependencia_solicitante='" . $variable [0] . "', ";
                $cadenaSql .= " sede_solicitante='" . $variable [1] . "', ";
                $cadenaSql .= " objeto_contrato='" . $variable [2] . "', ";

                if ($variable [3] != '') {
                    $cadenaSql .= " poliza1='" . $variable [3] . "', ";
                } else {
                    $cadenaSql .= " poliza1='0', ";
                }
                if ($variable [4] != '') {
                    $cadenaSql .= " poliza2='" . $variable [4] . "', ";
                } else {
                    $cadenaSql .= " poliza2='0', ";
                }

                if ($variable [5] != '') {
                    $cadenaSql .= " poliza3='" . $variable [5] . "', ";
                } else {
                    $cadenaSql .= " poliza3='0', ";
                }
                if ($variable [6] != '') {
                    $cadenaSql .= " poliza4='" . $variable [6] . "', ";
                } else {
                    $cadenaSql .= " poliza4='0', ";
                }

                $cadenaSql .= " duracion_pago='" . $variable [7] . "', ";
                $cadenaSql .= " fecha_inicio_pago=" . $variable [8] . ", ";
                $cadenaSql .= " fecha_final_pago=" . $variable [9] . ", ";
                $cadenaSql .= " forma_pago='" . $variable [10] . "', ";
                $cadenaSql .= " id_ordenador_encargado='" . $variable [11] . "', ";
                $cadenaSql .= " tipo_ordenador='" . $variable [12] . "',  ";
                $cadenaSql .= " clausula_presupuesto='" . $variable [15] . "'  ";
                $cadenaSql .= "  WHERE id_orden='" . $variable [13] . "';";

                break;

            case "actualizarPresupuestal" :
                $cadenaSql = " UPDATE informacion_presupuestal_orden ";
                $cadenaSql .= " SET vigencia_dispo='" . $variable [0] . "', ";
                $cadenaSql .= " numero_dispo='" . $variable [1] . "', ";
                $cadenaSql .= " valor_disp='" . $variable [2] . "', ";
                $cadenaSql .= " fecha_dip='" . $variable [3] . "', ";
                $cadenaSql .= " letras_dispo='" . $variable [4] . "', ";
                $cadenaSql .= " vigencia_regis='" . $variable [5] . "', ";
                $cadenaSql .= " numero_regis='" . $variable [6] . "', ";
                $cadenaSql .= " valor_regis='" . $variable [7] . "', ";
                $cadenaSql .= " fecha_regis='" . $variable [8] . "', ";
                $cadenaSql .= " letras_regis='" . $variable [9] . "', ";
                $cadenaSql .= " unidad_ejecutora='" . $variable [11] . "' ";
                $cadenaSql .= "  WHERE id_informacion='" . $variable [10] . "';";

                break;

            case "insertarItems" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " items_orden_compra(";
                $cadenaSql .= " id_orden, item, unidad_medida, cantidad, descripcion, ";
                $cadenaSql .= " valor_unitario, valor_total)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "',";
                $cadenaSql .= "'" . $variable [5] . "',";
                $cadenaSql .= "'" . $variable [6] . "');";

                break;

            case "dependecia_solicitante" :

                $cadenaSql = "SELECT DISTINCT ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;

            case 'consultar_numero_orden' :
                $cadenaSql = " SELECT id_orden_servicio, id_orden_servicio  ";
                $cadenaSql .= " FROM orden_servicio; ";

                break;

            case "identificacion_contratista" :
                $cadenaSql = " SELECT CON_IDENTIFICACION  ";
                $cadenaSql .= " FROM CONTRATISTAS  ";
                $cadenaSql .= " WHERE CON_IDENTIFICADOR='" . $variable . "' ";

                break;





            case "dependencias" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM arka_parametros.arka_dependencia ad ";
                $cadenaSql .= " JOIN  arka_parametros.arka_espaciosfisicos ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  arka_parametros.arka_sedes sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A'";

                break;

            case "consultarElementos" :
                $cadenaSql = "SELECT *   ";
                $cadenaSql .= " FROM elemento_acta_recibido ";
                $cadenaSql .= " WHERE id_orden ='" . $variable . "';";

                break;

            case "consultarDependenciaOrden" :
                $cadenaSql = "SELECT \"ESF_DEP_ENCARGADA\"  ";
                $cadenaSql .= " FROM argo.\"dependencia_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_CODIGO_DEP\" ='" . $variable . "';";
      

                break;
            
            

            case "consultarElementosOrden" :
                $cadenaSql = "SELECT DISTINCT ela.*, ct.elemento_nombre nivel_nombre, tb.descripcion nombre_tipo, iv.descripcion nombre_iva,elemento_nombre ";
                $cadenaSql .= "FROM elemento_acta_recibido ela ";
                $cadenaSql .= "JOIN  arka.catalogo_elemento ct ON ct.elemento_id=ela.nivel ";
                $cadenaSql .= "JOIN  arka.tipo_bienes tb ON tb.id_tipo_bienes=ela.tipo_bien ";
                $cadenaSql .= "JOIN  arka.aplicacion_iva iv ON iv.id_iva=ela.iva  ";
                 $cadenaSql .= "WHERE ela.numero_contrato ='" . $variable[0] . "' and ela.vigencia=" . $variable[1] . "  ";
                $cadenaSql .= "AND  ela.estado=true; ";
                break;

            case "consultarElemento" :
                $cadenaSql = "SELECT  * ";
                $cadenaSql .= "FROM elemento_acta_recibido ";
                $cadenaSql .= "WHERE  id_elemento_ac ='" . $variable . "'  ;";

                break;

            case "consultar_nivel_inventario" :

                $cadenaSql = "SELECT ce.elemento_id, ce.elemento_codigo||' - '||ce.elemento_nombre ";
                $cadenaSql .= "FROM arka.catalogo_elemento  ce ";
                $cadenaSql .= "JOIN arka.catalogo_lista cl ON cl.lista_id = ce.elemento_catalogo  ";
                $cadenaSql .= "WHERE cl.lista_activo = 1  ";
                $cadenaSql .= "AND  ce.elemento_id > 0  ";
                $cadenaSql .= "AND  ce.elemento_padre > 0  ";
                $cadenaSql .= "ORDER BY ce.elemento_codigo ASC ;";

                break;

            case "consultar_tipo_poliza" :

                $cadenaSql = "SELECT id_tipo_poliza, descripcion ";
                $cadenaSql .= "FROM inventarios.tipo_poliza;";

                break;

            case "consultar_tipo_iva" :

                $cadenaSql = "SELECT id_iva, descripcion ";
                $cadenaSql .= "FROM arka.aplicacion_iva;";

                break;


            case "ConsultaTipoBien" :

                $cadenaSql = "SELECT ge.elemento_tipobien , tb.descripcion  ";
                $cadenaSql .= "FROM  arka.catalogo_elemento ce ";
                $cadenaSql .= "JOIN  arka.catalogo_elemento_grupo ge  ON (ge.elemento_id)::text =ce .elemento_grupoc  ";
                $cadenaSql .= "JOIN  arka.tipo_bienes tb ON tb.id_tipo_bienes = ge.elemento_tipobien  ";
                $cadenaSql .= "WHERE ce.elemento_id = '" . $variable . "';";

                break;

            case 'consultarExistenciaImagen' :

                $cadenaSql = "SELECT id_imagen ";
                $cadenaSql .= "FROM  asignar_imagen_acta ";
                $cadenaSql .= "WHERE  id_elemento_acta ='" . $variable . "';";

                break;

            case "ActualizarElementoImagen" :

                $cadenaSql = " UPDATE inventarios.asignar_imagen_acta ";
                $cadenaSql .= "SET  id_elemento_acta='" . $variable ['elemento'] . "', imagen='" . $variable ['imagen'] . "' ";
                $cadenaSql .= "WHERE id_imagen='" . $variable ['id_imagen'] . "';";

                break;

            case "RegistrarElementoImagen" :

                $cadenaSql = " 	INSERT INTO inventarios.asignar_imagen_acta(";
                $cadenaSql .= " id_elemento_acta, imagen ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['elemento'] . "',";
                $cadenaSql .= "'" . $variable ['imagen'] . "') ";
                $cadenaSql .= "RETURNING id_imagen; ";

                break;

            case "consultar_iva" :

                $cadenaSql = "SELECT iva ";
                $cadenaSql .= "FROM inventarios.aplicacion_iva ";
                $cadenaSql .= "WHERE id_iva='" . $variable . "';";

                break;

            case "actualizar_elemento_tipo_1" :
                $cadenaSql = "UPDATE elemento_acta_recibido ";
                $cadenaSql .= "SET nivel='" . $variable [0] . "', ";
                $cadenaSql .= "tipo_bien='" . $variable [1] . "', ";
                $cadenaSql .= "descripcion='" . $variable [2] . "', ";
                $cadenaSql .= "cantidad='" . $variable [3] . "', ";
                $cadenaSql .= "unidad='" . $variable [4] . "', ";
                $cadenaSql .= "valor='" . $variable [5] . "', ";
                $cadenaSql .= "iva='" . $variable [6] . "', ";
                $cadenaSql .= "subtotal_sin_iva='" . $variable [7] . "', ";
                $cadenaSql .= "total_iva='" . $variable [8] . "', ";
                $cadenaSql .= "total_iva_con='" . $variable [9] . "', ";
                $cadenaSql .= (is_null($variable [10]) == true) ? "marca=NULL, " : "marca='" . $variable [10] . "', ";
                $cadenaSql .= (is_null($variable [11]) == true) ? "serie=NULL,  " : "serie='" . $variable [11] . "',  ";
                $cadenaSql .= (is_null($variable [13]) == true) ? "referencia=NULL, " : "referencia='" . $variable [13] . "', ";
                $cadenaSql .= (is_null($variable [14]) == true) ? "placa=NULL,  " : "placa='" . $variable [14] . "',  ";
                $cadenaSql .= (is_null($variable [15]) == true) ? "observacion=NULL, " : "observacion='" . $variable [15] . "',  ";
                $cadenaSql .= (is_null($variable [16]) == true) ? "codigo_dependencia=NULL,  " : "codigo_dependencia='" . $variable [16] . "',  ";
                $cadenaSql .= (is_null($variable [17]) == true) ? "funcionario=NULL " : "funcionario='" . $variable [17] . "'  ";

                $cadenaSql .= "WHERE id_elemento_ac ='" . $variable [12] . "'  ";

                break;

            case "actualizar_elemento_tipo_2" :
                $cadenaSql = "UPDATE elemento_acta_recibido ";
                $cadenaSql .= "SET nivel='" . $variable [0] . "', ";
                $cadenaSql .= "tipo_bien='" . $variable [1] . "', ";
                $cadenaSql .= "descripcion='" . $variable [2] . "', ";
                $cadenaSql .= "cantidad='" . $variable [3] . "', ";
                $cadenaSql .= "unidad='" . $variable [4] . "', ";
                $cadenaSql .= "valor='" . $variable [5] . "', ";
                $cadenaSql .= "iva='" . $variable [6] . "', ";
                $cadenaSql .= "subtotal_sin_iva='" . $variable [7] . "', ";
                $cadenaSql .= "total_iva='" . $variable [8] . "', ";
                $cadenaSql .= "total_iva_con='" . $variable [9] . "', ";
                $cadenaSql .= "tipo_poliza='" . $variable [10] . "', ";
                if ($variable [10] == 0) {

                    $cadenaSql .= "fecha_inicio_pol=NULL, ";
                    $cadenaSql .= "fecha_final_pol=NULL, ";
                } else if ($variable [10] == 1) {

                    $cadenaSql .= "fecha_inicio_pol='" . $variable [11] . "', ";
                    $cadenaSql .= "fecha_final_pol='" . $variable [12] . "', ";
                }
                $cadenaSql .= (is_null($variable [13]) == true) ? "marca=NULL, " : "marca='" . $variable [13] . "', ";
                $cadenaSql .= (is_null($variable [14]) == true) ? "serie=NULL, " : "serie='" . $variable [14] . "',  ";

                $cadenaSql .= (is_null($variable [16]) == true) ? "referencia=NULL, " : "referencia='" . $variable [16] . "', ";
                $cadenaSql .= (is_null($variable [17]) == true) ? "placa=NULL,  " : "placa='" . $variable [17] . "',  ";
                $cadenaSql .= (is_null($variable [18]) == true) ? "observacion=NULL, " : "observacion='" . $variable [18] . "',  ";
                $cadenaSql .= (is_null($variable [19]) == true) ? "codigo_dependencia=NULL,  " : "codigo_dependencia='" . $variable [19] . "',  ";
                $cadenaSql .= (is_null($variable [20]) == true) ? "funcionario=NULL " : "funcionario='" . $variable [20] . "'  ";

                $cadenaSql .= "WHERE id_elemento_ac ='" . $variable [15] . "' ";

                break;

            case "eliminarElementoActa" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " elemento_acta_recibido  ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " estado='false'  ";
                $cadenaSql .= " WHERE id_elemento_ac='" . $variable . "'";
                break;

            // -- Modificar orden

            case "rubros" :
                $cadenaSql = " SELECT \"RUB_IDENTIFICADOR\", \"RUB_RUBRO\" ||' - '|| \"RUB_NOMBRE_RUBRO\" ";
                $cadenaSql .= "FROM arka_parametros.arka_rubros ";
                $cadenaSql .= "WHERE \"RUB_VIGENCIA\"='" . date('Y') . "';";

                break;







            case "registro_consultas" :
                $cadenaSql = "SELECT  \"REP_IDENTIFICADOR\" AS identificador,\"REP_IDENTIFICADOR\" AS numero ";
                $cadenaSql .= "FROM arka_parametros.arka_registropresupuestal ";
                $cadenaSql .= "WHERE \"REP_VIGENCIA\"='" . $variable [0] . "'";
                $cadenaSql .= "AND  \"REP_NUMERO_DISPONIBILIDAD\"='" . $variable [1] . "'";

                break;


            case "consultarInformaciónDisponibilidad" :

                $cadenaSql = "SELECT *  ";
                $cadenaSql .= " FROM disponibilidad_orden   ";
                $cadenaSql .= " WHERE id_orden='" . $variable . "' ";
                $cadenaSql .= " AND estado_registro='t'  ";
                $cadenaSql .= " ORDER BY id_orden ASC;  ";

                break;


            case "consultarConsecutivo" :

                $cadenaSql = "SELECT ro.vigencia,ro.unidad_ejecutora, ro.consecutivo_servicio,ro.consecutivo_compras,ro.tipo_orden   ";
                $cadenaSql .= " FROM orden ro  ";
                $cadenaSql .= " WHERE ro.id_orden='" . $variable . "'";
                break;

            case "consultarConsecutivoUnidad" :

                $cadenaSql = "SELECT 
								CASE ro.tipo_orden
								WHEN 1 THEN max(ro.consecutivo_compras)
								WHEN 9 THEn max(ro.consecutivo_servicio)
								END consecutivo ";
                $cadenaSql .= " FROM orden ro  ";
                $cadenaSql .= " WHERE ro.vigencia='" . $variable ['vigencia'] . "' ";
                $cadenaSql .= " AND  ro.unidad_ejecutora ='" . $variable ['unidad_ejecutora'] . "' ";
                $cadenaSql .= " AND  ro.tipo_orden ='" . $variable ['tipo_orden'] . "' ";
                $cadenaSql .= " GROUP BY ro.tipo_orden ; ";

                break;

            case "actualizarConsecutivoCompras" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " consecutivo_compras='" . $variable ['consecutivo'] . "', ";
                $cadenaSql .= " unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "'  ";
                $cadenaSql .= "  WHERE id_orden='" . $variable ['id_orden'] . "';";

                break;

            case "actualizarConsecutivoServicios" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " consecutivo_servicio='" . $variable ['consecutivo'] . "', ";
                $cadenaSql .= " unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "'  ";
                $cadenaSql .= "  WHERE id_orden='" . $variable ['id_orden'] . "';";

                break;

            //-------------------------Documento Novedades ------------------------------------------------


            case "consultarContratoProcesarAjax" :
                $cadenaSql = " SELECT  tp.tipo_contrato,  cg.unidad_ejecutora  FROM contrato_general cg, tipo_contrato tp ";
                $cadenaSql .= " WHERE tp.id = cg.tipo_contrato and numero_contrato='$variable[1]' and vigencia = $variable[2] ";
                break;


            case "acumuladoAdiciones" :
                $cadenaSql = "  SELECT SUM(valor_presupuesto) as acumulado  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc  ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;



            case "consultarAdcionesPresupuesto" :
                $cadenaSql = "  SELECT nc.*, a.numero_solicitud, a.numero_cdp, a.valor_presupuesto ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc    ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND tipo_adicion = 248;";
                break;


            case "consultarAdcionesTiempo" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as unidad_tiempo_ejecucion, a.valor_tiempo  ";
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
                $cadenaSql = "  SELECT nc.*, s.fecha_inicio, s.fecha_fin ";
                $cadenaSql .= " FROM suspension s , novedad_contractual nc   ";
                $cadenaSql .= " WHERE s.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1]; ";
                break;

            case "consultaCesiones" :
                $cadenaSql = "  SELECT nc.*, c.nuevo_contratista, c.antiguo_contratista, c.fecha_cesion  ";
                $cadenaSql .= " FROM cesion c , novedad_contractual nc   ";
                $cadenaSql .= " WHERE c.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1]; ";
                break;

            case "ConsultacambioSupervisor" :
                $cadenaSql = "  SELECT nc.*, cs.supervisor_antiguo, cs.supervisor_nuevo, cs.fecha_cambio, pr.descripcion as tipoCambio_parametro ";
                $cadenaSql .= " FROM cambio_supervisor cs , novedad_contractual nc, parametros pr   ";
                $cadenaSql .= " WHERE cs.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND cs.tipo_cambio = pr.id_parametro;";
                break;

            case "ConsultaOtras" :
                $cadenaSql = "  SELECT nc.numero_contrato,nc.vigencia,nc.estado,nc.fecha_registro,nc.usuario,nc.acto_administrativo, ";
                $cadenaSql .= "  nc.documento, nc.descripcion, pr.descripcion as parametro_descripcion ";
                $cadenaSql .= " FROM novedad_contractual nc, parametros pr  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[0]' AND vigencia = $variable[1] AND pr.id_parametro = nc.tipo_novedad ";
                $cadenaSql .= " AND ( nc.tipo_novedad = 217 or nc.tipo_novedad = 218 ) ; ";
                break;

            case "ConsultaSupervisorNovedad" :
                $cadenaSql = "   SELECT FUN_IDENTIFICACION ||' - '|| FUN_NOMBRE ";
                $cadenaSql .= "  FROM SICAARKA.FUNCIONARIOS WHERE FUN_IDENTIFICACION = $variable ";
                break;

            // Consultas modificacion y eliminacion de servicios 

            case "consultarServicio" :
                $cadenaSql = "SELECT descripcion,nombre,codigo_ciiu,valor_servicio FROM servicio_contrato WHERE id = $variable;";
                break;

            case "tipoServicio" :
                $cadenaSql = "SELECT id_clase, nombre FROM core.ciiu_clase;";
                break;

            case "serviciosPorClase" :
                $cadenaSql = "SELECT id_subclase, nombre FROM core.ciiu_subclase WHERE clase = '$variable';";
                break;

            case "consultarTipoServicio":
                $cadenaSql = "SELECT clase FROM core.ciiu_subclase where id_subclase = '$variable';";
                break;

            case "actualizarServicio":
                $cadenaSql = " UPDATE servicio_contrato";
                $cadenaSql.=" SET descripcion='" . $variable['descripcion_servicio'] . "', ";
                $cadenaSql.=" nombre='" . $variable['nombre'] . "',  valor_servicio=" . $variable['valor_servicio'] . ", ";
                $cadenaSql.=" codigo_ciiu='" . $variable['codigo_ciiu'] . "' ";
                $cadenaSql.=" WHERE id=" . $variable['id_servicio'] . ";";
                break;

            case "eliminarServicio":
                $cadenaSql = " DELETE FROM servicio_contrato ";
                $cadenaSql.=" WHERE id=" . $variable . ";";
                break;

            // ---------------Novedad de Modificacion ---------------------------------

            case "insertarDatosModificados" :
                $cadenaSql = " UPDATE modificacion_contractual";
                $cadenaSql.=" SET datos_modificados='$variable[1]', datos_antiguos='$variable[2]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "consultarInfoNovedadModificacion" :
                $cadenaSql = "  SELECT nc.*, mc.novedad, mc.razon ";
                $cadenaSql .= " FROM modificacion_contractual mc , novedad_contractual nc   ";
                $cadenaSql .= " WHERE mc.id = nc.id AND nc.id = $variable; ";
                break;

            //-----------------Informacion de suscripcion de contrato----

            case "ConsultaInfoSuscripcion" :
                $cadenaSql = "  SELECT fecha_suscripcion  ";
                $cadenaSql .= " FROM contrato_suscrito  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;

            //----------------------Estado del Contrato y Consulta de numero y consecutivo de elaboracion

            case 'consultarEstadoContrato' :
                $cadenaSql = " SELECT ce.estado, ec.nombre_estado  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND cg.numero_contrato = '" . $variable[0] . "' and cg.vigencia = " . $variable[1] . " ;";

                break;

            case 'consultarConsecutivoUnicoSuscrito' :
                $cadenaSql = " SELECT numero_contrato_suscrito, fecha_suscripcion  ";
                $cadenaSql .= " FROM contrato_suscrito cs  ";
                $cadenaSql .= " WHERE cs.numero_contrato = '" . $variable[0] . "' and cs.vigencia = " . $variable[1] . " ;";

                break;

            //--------------------------------Documento Unificado -----------------------------------

            case "infoContratoGeneralDocumento" :
                $cadenaSql = " SELECT cg.*, o.tipo_orden,o.poliza  ";
                $cadenaSql .= "  FROM contrato_general cg, orden o ";
                $cadenaSql .= " WHERE cg.numero_contrato= o.numero_contrato and cg.vigencia = o.vigencia  ";
                $cadenaSql .= " AND cg.numero_contrato='$variable[0]' and cg.vigencia = $variable[1];  ";
                break;


            case "consultaPlantilla" :
                $cadenaSql = " SELECT plantilla, estilo  ";
                $cadenaSql .= "  FROM plantilla_minuta ";
                $cadenaSql .= " WHERE tipo_contrato= " . $variable['tipo_contrato'] . " and tipo_plantilla = '" . $variable['tipo_plantilla'] . "';  ";

                break;



            case "obtenerInformacionElaborador" :

                $cadenaSql = " 	SELECT nombre , apellido  ";
                $cadenaSql .= " FROM frame_work.argo_usuario  ";
                $cadenaSql .= " WHERE id_usuario = '$variable'; ";

                break;
            case "ObtenerInfosupervisor" :
                $cadenaSql = " SELECT nombre, documento,cargo FROM supervisor_contrato   ";
                $cadenaSql .= " WHERE id= $variable; ";
                break;

            case "consultaContratistaDocumento" :
                $cadenaSql = " SELECT * FROM agora.informacion_proveedor WHERE id_proveedor = $variable; ";
                break;

            case "obtenerInfoCdp" :
                $cadenaSql = " SELECT SN.NUM_SOL_ADQ, SCDP.ID_SOL_CDP, CDP.NUMERO_DISPONIBILIDAD,SN.VIGENCIA ,DP.NOMBRE_DEPENDENCIA, ";
                $cadenaSql.=" SN.ESTADO, SN.JUSTIFICACION, CDP.OBJETO,SN.VALOR_CONTRATACION,CDP.ESTADO as ESTADOCDP , CDP.FECHA_REGISTRO,SN.RUBRO_INTERNO, RB.DESCRIPCION ";
                $cadenaSql.=" FROM CO.CO_SOLICITUD_ADQ SN, CO.CO_SOL_CDP SCDP, PR.PR_DISPONIBILIDADES CDP , CO.CO_DEPENDENCIAS DP, PR.PR_RUBRO RB  ";
                $cadenaSql.=" WHERE SN.NUM_SOL_ADQ = SCDP.NUM_SOL_ADQ and SN.VIGENCIA = SCDP.VIGENCIA and SN.DEPENDENCIA = DP.COD_DEPENDENCIA ";
                $cadenaSql.=" and SN.VIGENCIA = RB.VIGENCIA and SN.RUBRO_INTERNO = RB.INTERNO  ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and CDP.NUM_SOL_ADQ = SCDP.ID_SOL_CDP and CDP.CODIGO_COMPANIA = SCDP.CODIGO_COMPANIA  ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and SN.VIGENCIA=" . $variable['vigencia'] . " and ";
                $cadenaSql.="  SN.CODIGO_UNIDAD_EJECUTORA='0" . $variable['unidad_ejecutora'] . "' and CDP.NUMERO_DISPONIBILIDAD=" . $variable['numero_disponibilidad'] . " ";
                $cadenaSql.="  ORDER BY SN.NUM_SOL_ADQ ";

                break;


            case "consultaTipoDocumento" :
                $cadenaSql = " SELECT pe.valor_parametro, c.nombre FROM agora.informacion_persona_natural ipn, agora.parametro_estandar pe, core.ciudad c  ";
                $cadenaSql .= " WHERE c.id_ciudad = ipn.id_ciudad_expedicion_documento and ipn.tipo_documento = pe.id_parametro AND ipn.num_documento_persona = $variable; ";
                break;
            case "consultaParametro" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;

            case "consultaTipoContrato" :
                $cadenaSql = " SELECT tipo_contrato  FROM tipo_contrato  ";
                $cadenaSql .= " WHERE id = $variable;  ";
                break;


            //------------------------Consulta Proveedor ---------------------

            case "buscar_proveedor_contrato" :

                $cadenaSql = " SELECT num_documento ||'-'|| nom_proveedor|| '- ( PERSONA: '||tipopersona||')' AS value, id_proveedor AS "
                        . "data FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (tipopersona = 'NATURAL' or tipopersona = 'JURIDICA' or tipopersona = 'EXTRANJERA') AND (cast(num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR nom_proveedor  LIKE '%" . $variable . "%' ) AND estado = 1 ";
                $cadenaSql .= " LIMIT 20;";


                break;
            case "buscar_Informacion_contrato" :

                $cadenaSql = " SELECT ip.*, c.nombre as nombreCiudad, b.nombre_banco as nombreBanco FROM agora.informacion_proveedor ip, core.ciudad c, core.banco b ";
                $cadenaSql .= " WHERE c.id_ciudad = ip.id_ciudad_contacto AND b.id_codigo = ip.id_entidad_bancaria AND num_documento = $variable;";


                break;
            case "buscar_Informacion_proveedor" :

                $cadenaSql = " SELECT ip.*, c.nombre as nombreCiudad, b.nombre_banco as nombreBanco FROM agora.informacion_proveedor ip, core.ciudad c, core.banco b ";
                $cadenaSql .= " WHERE c.id_ciudad = ip.id_ciudad_contacto AND b.id_codigo = ip.id_entidad_bancaria AND ip.id_proveedor = $variable;";


                break;
            case "buscar_Informacion_proveedor_edicion" :

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
            case "buscar_sociedad_contrato" :

                $cadenaSql = " SELECT ip.num_documento ||'-'|| ip.nom_proveedor|| '- ( TIPO SOCIEDAD: '||ip.tipopersona||')' AS value, ip.id_proveedor AS "
                        . "data FROM agora.informacion_proveedor ip, informacion_sociedad_temporal ist WHERE ip.id_proveedor = ist.id_proveedor_sociedad ";
                $cadenaSql .= " AND (tipopersona = 'UNION TEMPORAL' or tipopersona = 'CONSORCIO') AND (cast(num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR nom_proveedor  LIKE '%" . $variable . "%' ) AND ist.estado = 't' ";
                $cadenaSql .= " LIMIT 20;";


                break;

             case "consultaContratoGeneralAmparo" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= "  FROM argo.amparo_contrato cga ";
                $cadenaSql .= " WHERE cga.numero_contrato='".$variable[0]."' AND cga.vigencia_contrato=".$variable[1]." ORDER BY id;  ";
                
               break;     

                
        }
        return $cadenaSql;
    }

}

?>
