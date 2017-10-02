<?php

namespace gestionPolizas;

use gestionPolizas\funcion\redireccion;

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
            case "unidad_ejecutora_gasto" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='unidad_ejecutora_gasto' ORDER BY id_parametro DESC ; ";
                break;



            case "obtenerPolizarOrden" :
                $cadenaSql = " 	SELECT poliza, fecha_inicio, fecha_final ";
                $cadenaSql .= " FROM contrato_poliza ";
                $cadenaSql .= " WHERE numero_contrato='" . $variable['numero_contrato'] . "' AND vigencia= " . $variable['vigencia'] . ";";

                break;

            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza, estado ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza ORDER BY id_poliza; ";
                break;



            case "buscar_Proveedores" :
                $cadenaSql = " SELECT nit||' - ('||nomempresa||')' AS  value, nit AS data  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info ";
                $cadenaSql .= " WHERE cast(nit as text) LIKE '%$variable%' OR nomempresa LIKE '%$variable%' LIMIT 10; ";
                break;

            case "info_orden_Cancelada" :

                $cadenaSql = " 	SELECT fecha_cancelacion, motivo_cancelacion, usuario  ";
                $cadenaSql .= " FROM contrato_cancelado ";
                $cadenaSql .= " WHERE numero_contrato = '" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";

                break;
            case "info_orden_Anulada" :

                $cadenaSql = " 	SELECT n.fecha_registro, n.usuario, n.acto_administrativo, n.descripcion, n.documento, p.descripcion as tipoAnulacion   ";
                $cadenaSql .= " FROM novedad_contractual n, anulacion a, parametros p  ";
                $cadenaSql .= " WHERE n.id = a.id AND p.id_parametro = a.tipo_anulacion ";
                $cadenaSql .= " AND numero_contrato = '" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";

                break;

            case "info_orden_termminada" :

                $cadenaSql = " 	SELECT fecha_registro, usuario, acto_administrativo, descripcion, documento   ";
                $cadenaSql .= " FROM novedad_contractual ";
                $cadenaSql .= " WHERE tipo_novedad=218 ";
                $cadenaSql .= " AND numero_contrato = '" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";

                break;

            case "info_orden_terminada_anticipada" :

                $cadenaSql = " 	SELECT ta.fecha, n.usuario, n.acto_administrativo, n.descripcion, n.documento   ";
                $cadenaSql .= " FROM novedad_contractual n, terminacion_anticipada ta ";
                $cadenaSql .= " WHERE n.id = ta.id and tipo_novedad=257 ";
                $cadenaSql .= " AND n.numero_contrato = '" . $variable['numero_contrato'] . "' AND n.vigencia=" . $variable['vigencia'] . ";";

                break;
            case "info_contrato_liquidado" :

                $cadenaSql = " 	SELECT *   ";
                $cadenaSql .= " FROM contrato_liquidado ";
                $cadenaSql .= " WHERE  ";
                $cadenaSql .= " numero_contrato = '" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";

                break;


            case "ConsultarCDPContrato" :
                $cadenaSql = " 	SELECT numero_cdp  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE numero_contrato = '" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";
                break;


            case "informacion_RP" :
                $cadenaSql = " SELECT NUMERO_REGISTRO, RUBRO_INTERNO, VALOR ";
                $cadenaSql.=" FROM PR.PR_REGISTRO_DISPONIBILIDAD ";
                $cadenaSql.=" WHERE VIGENCIA = $variable[1] and CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and NUMERO_REGISTRO= $variable[0] ";
                break;
            case "registroRp" :
                $cadenaSql = " UPDATE contrato_general SET  ";
                $cadenaSql.=" resgistro_presupuestal = " . $variable['rp'] . " ";
                $cadenaSql .= " WHERE numero_contrato='" . $variable['numero_contrato'] . "' AND vigencia= " . $variable['vigencia'] . ";";
                break;

            case "convenios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio; ";
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

            case "consultarContratosGeneral" :

                $cadenaSql = "SELECT DISTINCT cg.clase_contratista,p.descripcion, cg.numero_contrato, "
                        . "cg.vigencia, cg.fecha_registro, cg.contratista as proveedor,cg.tipologia_contrato, "
                        . " ec.nombre_estado, tpc.tipo_contrato,"
                        . "ce.fecha_registro as fecha_registro_estado, cg.convenio, cs.numero_contrato_suscrito ";
                $cadenaSql .= "FROM parametros p, contrato_general cg, tipo_contrato tpc,";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec, contrato_suscrito cs   ";
                $cadenaSql .= "WHERE cg.tipologia_contrato = p.id_parametro AND  cg.tipo_contrato = tpc.id   ";
                $cadenaSql .= "AND cg.numero_contrato = cs.numero_contrato and cg.vigencia = cs.vigencia ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " AND cg.vigencia = " . $variable['vigencia_curso'] . "  ";
                $cadenaSql .= "AND cg.estado = 'true' AND ec.id =3  AND cg.clase_contratista is not null ";
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND cs.numero_contrato_suscrito = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND cs.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND cg.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ORDER BY cs.numero_contrato_suscrito DESC; ";

                break;
            //-------------------- Agregadas -----------------------------------------------------

            case "buscar_numero_orden" :

                $cadenaSql = " 	SELECT 	o.numero_contrato ||'-'|| o.vigencia as value, o.numero_contrato ||'-'||o.vigencia as orden ";
                $cadenaSql .= " FROM orden o, contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE o.numero_contrato = cg.numero_contrato and o.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= " and tipo_orden ='" . $variable['tipo_orden'] . "' and cg.estado_aprobacion = 't' AND ec.id = 3 ;";

                break;
            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT num_documento||' - '||nom_proveedor AS  value, id_proveedor  AS data  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (cast(num_documento as text) LIKE '%" . $variable . "%'  ";
                $cadenaSql .= "  OR nom_proveedor  LIKE '%" . $variable . "%') LIMIT 15; ";
                break;

            case "registroCancelacion" :
                $cadenaSql = " INSERT INTO contrato_cancelado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_cancelacion ,motivo_cancelacion,usuario,fecha_registro) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_cancelacion'] . "',";
                $cadenaSql .= "'" . $variable ['motivo_cancelacion'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_registo'] . "');";

                break;

            case "obtenerInformacionElaborador" :

                $cadenaSql = " 	SELECT nombre , apellido  ";
                $cadenaSql .= " FROM frame_work.argo_usuario  ";
                $cadenaSql .= " WHERE id_usuario = '$variable'; ";

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


            case 'buscar_contrato' :
                $cadenaSql = " SELECT  DISTINCT cs.numero_contrato_suscrito||'-('||cs.vigencia||')' AS  data, cs.numero_contrato_suscrito||' - ('||cs.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec, contrato_suscrito cs  ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = cs.numero_contrato and cg.vigencia = cs.vigencia ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id and cg.vigencia = " . $variable['vigencia_curso'] . " ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND ec.id = 3 AND (cast(cs.numero_contrato_suscrito as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= " OR cast(cg.vigencia as text ) LIKE '%" . $variable['parametro'] . "%' ) ";
                $cadenaSql .= " ORDER BY data ASC LIMIT 10;";
                break;


            case "tipo_contrato" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' ;";

                break;



            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.id_rel_parametro= 8 or  rl.id_rel_parametro= 6; ";

                break;

            case 'buscarDepartamento' : // Solo Departamentos de Colombia

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;

            case 'buscarCiudad' :
                $cadenaSql = 'SELECT ';
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
                $cadenaSql .= 'agora.ciudad ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_departamento = ' . $variable . ' ';
                $cadenaSql .= 'ORDER BY NOMBRE';
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
            case "informacion_sociedad_temporal" :

                $cadenaSql = " SELECT identificacion, documento_representante, documento_suplente,nombre,digito_verificacion ";
                $cadenaSql.=" FROM sociedad_temporal WHERE identificacion=$variable; ";

                break;
            case "nombre_participante" :

                $cadenaSql = " SELECT nom_proveedor, tipopersona,puntaje_evaluacion ";
                $cadenaSql.=" FROM agora.informacion_proveedor WHERE num_documento=$variable; ";

                break;

            case 'consultarConsecutivoUnicoSuscrito' :
                $cadenaSql = " SELECT numero_contrato_suscrito, fecha_suscripcion  ";
                $cadenaSql .= " FROM contrato_suscrito cs  ";
                $cadenaSql .= " WHERE cs.numero_contrato = '" . $variable[0] . "' and cs.vigencia = " . $variable[1] . " ;";

                break;


            case "nombre_participante_natural" :

                $cadenaSql = " SELECT p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  WHERE num_documento_persona=$variable;   ";

                break;



            case "consultarContratoProcesarAjax" :
                $cadenaSql = " SELECT  tp.tipo_contrato,  cg.unidad_ejecutora  FROM contrato_general cg, tipo_contrato tp ";
                $cadenaSql .= " WHERE tp.id = cg.tipo_contrato and numero_contrato='$variable[1]' and vigencia = $variable[2] ";
                break;


            case "obtener_participantes" :

                $cadenaSql = " SELECT ip.num_documento ||'-'|| ip.nom_proveedor as nombre_participante, istp.porcentaje_participacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_participante istp, agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor = istp.id_contratista AND id_proveedor_sociedad = $variable; ";

                break;
            case "buscarDepartamentodeCiudad" :

                $cadenaSql = " select d.id_departamento ";
                $cadenaSql.=" from core.departamento d, core.ciudad c ";
                $cadenaSql.=" where c.id_departamento = d.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable;";

                break;


            case 'Consultar_Contrato_Particular' :
                $cadenaSql = " SELECT  ";
                $cadenaSql .= " cg.*, s.documento, s.nombre, s.cargo,s.sede_supervisor,s.dependencia_supervisor,s.digito_verificacion,  ";
                $cadenaSql .= " le.direccion, le.sede, le.dependencia, le.ciudad,s.tipo ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general cg, supervisor_contrato s, lugar_ejecucion le ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " cg.supervisor= s.id and cg.lugar_ejecucion = le.id and ";
                $cadenaSql .= " cg.numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " cg.vigencia = $variable[1] ; ";
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
                $cadenaSql.=" from agora.departamento d, agora.ciudad c ";
                $cadenaSql.=" where c.id_departamento = d.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable;";

                break;



            case 'buscarPadresCiudad' :
                $cadenaSql = " select p.id_pais, d.id_departamento from core.pais p,core.departamento d,";
                $cadenaSql.=" core.ciudad c where p.id_pais = d.id_pais and d.id_departamento = c.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable ;";
                break;


            case "obtenerIdsTerceros" :

                $cadenaSql = " SELECT id_proveedor FROM agora.solicitud_cotizacion where id_objeto = $variable;";
                break;


            case "obtenerTerceros" :

                $cadenaSql = " SELECT id_proveedor,nom_proveedor,num_documento,tipopersona,puntaje_evaluacion FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE id_proveedor IN ($variable) ;";
                break;


            case "obtenerIdObjeto" :
                $cadenaSql = " SELECT id_objeto  FROM agora.objeto_contratar  ";
                $cadenaSql .= " WHERE numero_solicitud = " . $variable[0] . " and vigencia =" . $variable[1] . ";";
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
                $cadenaSql .= " WHERE  ad.\"ESF_ESTADO\"='A' ";

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


            case "tipo_clase_contratista" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contratista'; ";
                break;

            case "tipo_compromiso" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_compromiso'; ";
                break;

            case "tipo_ejecucion_tiempo" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_ejecucion_tiempo'; ";
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

            case "ordenadorGasto" :

                $cadenaSql = " 	select \"ORG_IDENTIFICADOR_UNICO\", \"ORG_ORDENADOR_GASTO\"   from argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" <> 'DIRECTOR IDEXUD'; ";

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

            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  \"ORG_NOMBRE\",  \"ORG_IDENTIFICACION\",  \"ORG_IDENTIFICADOR\"  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_ESTADO\" = 'A' and  \"ORG_IDENTIFICADOR_UNICO\" = '$variable';";

                break;


            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO='A' ";

                break;

            case "interventores" :
                $cadenaSql = " SELECT it.num_documento ||'-'||ip.nom_proveedor AS data, it.num_documento ||'-'||ip.nom_proveedor as value  FROM ";
                $cadenaSql.=" agora.informacion_proveedor ip , agora.informacion_interventor it";
                $cadenaSql.=" WHERE ip.num_documento = it.num_documento;";
                break;


            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;

            case "ConsultarDescripcionParametro" :
                $cadenaSql = "SELECT descripcion ";
                $cadenaSql .= " FROM parametros ";
                $cadenaSql .= " WHERE id_parametro=" . $variable;

                break;

            case "registroActaInicio" :
                $cadenaSql = " INSERT INTO acta_inicio(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_inicio,fecha_fin,usuario,descripcion) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_inicio_acta'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_final_acta'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= "'" . $variable ['observaciones'] . "');";

                break;


            case "insertarEstadoActaContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_estado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_registro,usuario,estado ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= $variable ['estado'] . ");";

                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28 and id_parametro=240;";

                break;


            //-----------Gestion Amparos y Polizas

            case "obtenerPolizas" :
                $cadenaSql = "SELECT p.id_poliza,p.descripcion_poliza,p.fecha_registro,p.estado,  ";
                $cadenaSql .= " ea.nombre as nombre_aseguradora ,p.fecha_inicio,p.fecha_fin,p.numero_poliza,p.fecha_aprobacion  ";
                $cadenaSql .= "FROM argo.poliza p, core.entidad_aseguradora ea  ";
                $cadenaSql .= "WHERE p.numero_contrato = '" . $variable['numero_contrato'] . "' and p.vigencia = " . $variable['vigencia'] . " AND ";
                $cadenaSql .= " p.entidad_aseguradora = ea.id  ";
                $cadenaSql .= "ORDER BY p.id_poliza; ";
                break;
            case "obtenerPolizasActivas" :
                $cadenaSql = "SELECT p.id_poliza,p.descripcion_poliza,p.fecha_registro,p.estado,p.usuario,  ";
                $cadenaSql .= " ea.nombre as nombre_aseguradora ,p.fecha_inicio,p.fecha_fin,p.numero_poliza,p.fecha_aprobacion  ";
                $cadenaSql .= "FROM argo.poliza p, core.entidad_aseguradora ea  ";
                $cadenaSql .= "WHERE p.numero_contrato = '" . $variable['numero_contrato'] . "' and p.vigencia = " . $variable['vigencia'] . " AND ";
                $cadenaSql .= " p.entidad_aseguradora = ea.id  and p.estado='t' ";
                $cadenaSql .= "ORDER BY p.id_poliza; ";
                break;

            case "obtenerFechaAprobacionMaximaPolizasActivas" :
                $cadenaSql = "SELECT MAX(p.fecha_aprobacion) as fecha_aprobacion  ";
                $cadenaSql .= "FROM argo.poliza p, core.entidad_aseguradora ea  ";
                $cadenaSql .= "WHERE p.numero_contrato = '" . $variable['numero_contrato'] . "' and p.vigencia = " . $variable['vigencia'] . " AND ";
                $cadenaSql .= " p.entidad_aseguradora = ea.id  and p.estado='t'; ";
                break;

            case "ConsultarTipoContrato" :
                $cadenaSql = " SELECT tp.tipo_contrato  ";
                $cadenaSql .= " FROM argo.tipo_contrato tp, argo.contrato_general cg  ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " cg.tipo_contrato = tp.id and id = $variable ;";
                break;

            case "obtenerEstadoPoliza" :
                $cadenaSql = " SELECT numero_poliza,estado";
                $cadenaSql.=" FROM poliza WHERE id_poliza =$variable;";
                break;

            case "obtenerEstadoAmparo" :
                $cadenaSql = " SELECT amparo, estado";
                $cadenaSql.=" FROM amparo_poliza WHERE id =$variable;";
                break;

            case "cambiarEstadoPoliza" :
                $cadenaSql = " UPDATE poliza SET estado = '$variable[0]'";
                $cadenaSql.="  WHERE id_poliza =$variable[1];";
                break;
            case "cambiarEstadoAmparo" :
                $cadenaSql = " UPDATE amparo_poliza SET estado = '$variable[0]'";
                $cadenaSql.="  WHERE id =$variable[1];";
                break;

            case "obtenerMaxIdPoliza" :
                $cadenaSql = "SELECT MAX(id_poliza) FROM poliza;";
                break;

            case "insertarPoliza" :
                $cadenaSql = " INSERT INTO poliza( id_poliza,numero_poliza, ";
                $cadenaSql .= " descripcion_poliza,entidad_aseguradora,fecha_inicio,fecha_fin,fecha_aprobacion,"
                        . "numero_contrato,vigencia, usuario)VALUES (";
                $cadenaSql .= $variable['id_poliza'] . ", ";
                $cadenaSql .= "'" . $variable['numero_poliza'] . "', ";
                $cadenaSql .= "'" . $variable['descripcion'] . "', ";
                $cadenaSql .= " " . $variable['entidad_aseguradora'] . ", ";
                $cadenaSql .= "'" . $variable['fecha_inicio'] . "', ";
                $cadenaSql .= "'" . $variable['fecha_final'] . "', ";
                $cadenaSql .= "'" . $variable['fecha_aprobacion'] . "', ";
                $cadenaSql .= "'" . $variable['numero_contrato'] . "', ";
                $cadenaSql .= " " . $variable['vigencia'] . ", ";
                $cadenaSql .= "'" . $variable['usuario'] . "'); ";
                break;

            case "insertarAmparo" :
                $cadenaSql = " INSERT INTO argo.amparo_poliza(";
                $cadenaSql.=" poliza, fecha_inicio, fecha_final, ";
                $cadenaSql.=" amparo,unidad_amparo,tipo_valor_amparo) VALUES";
                $cadenaSql.=" (" . $variable['id_poliza'] . ",'" . $variable['fecha_inicio'] . "', "
                        . "'" . $variable['fecha_final'] . "', " . $variable['amparo'] . ", "
                        . " " . $variable['unidad_amparo'] . ", " . $variable['tipo_unidad'] . ");";
                break;

            case "obtenerPoliza" :
                $cadenaSql = "SELECT numero_poliza,descripcion_poliza,"
                        . "fecha_registro,estado,entidad_aseguradora,fecha_inicio,fecha_fin,fecha_aprobacion  ";
                $cadenaSql .= "FROM poliza WHERE id_poliza = $variable; ";
                break;
            case "obtenerAmparos" :
                $cadenaSql = "SELECT ap.*, a.nombre as nombre_amparo from amparo_poliza ap, core.amparos a ";
                $cadenaSql .= "WHERE ap.amparo = a.id AND ap.poliza  = $variable; ";
                break;
            case "obtenerAmparosActivos" :
                $cadenaSql = "SELECT ap.*, a.nombre as nombre_amparo, p.numero_poliza from amparo_poliza ap, core.amparos a, poliza p ";
                $cadenaSql .= "WHERE ap.amparo = a.id AND p.id_poliza = ap.poliza AND ap.poliza  = $variable and ap.estado='t' ; ";
                break;
            case "obtenerAmparo" :
                $cadenaSql = "SELECT * from amparo_poliza  ";
                $cadenaSql .= "WHERE id = $variable; ";
                break;

            case "editarPoliza" :
                $cadenaSql = " UPDATE poliza SET  ";
                $cadenaSql .= " numero_poliza='" . $variable['numero_poliza'] . "',";
                $cadenaSql .= " descripcion_poliza= '" . $variable['descripcion'] . "', ";
                $cadenaSql .= " entidad_aseguradora=" . $variable['entidad_aseguradora'] . ",";
                $cadenaSql .= " fecha_inicio= '" . $variable['fecha_inicio'] . "', ";
                $cadenaSql .= " fecha_fin='" . $variable['fecha_final'] . "',";
                $cadenaSql .= " fecha_aprobacion='" . $variable['fecha_aprobacion'] . "'";
                $cadenaSql .= " WHERE id_poliza =" . $variable['id_poliza'] . ";";
                break;

            case "editarAmparo" :
                $cadenaSql = " UPDATE amparo_poliza";
                $cadenaSql.=" SET ";
                $cadenaSql.=" fecha_inicio='" . $variable['fecha_inicio'] . "',";
                $cadenaSql.=" fecha_final='" . $variable['fecha_final'] . "',";
                $cadenaSql.=" amparo=" . $variable['amparo'] . ",";
                $cadenaSql.=" unidad_amparo=" . $variable['unidad_amparo'] . ", ";
                $cadenaSql.=" tipo_valor_amparo=" . $variable['tipo_unidad'] . " ";
                $cadenaSql.=" WHERE id=" . $variable['id_amparo'] . ";";
                break;

            case "entidad_aseguradora" :
                $cadenaSql = " SELECT id, '('||nit||') '|| nombre FROM core.entidad_aseguradora ";
                $cadenaSql.=" WHERE estado = 't'; ";
                break;

            case "obtenerMinimoVigente" :
                $cadenaSql = " SELECT valor, decreto  FROM core.salario_minimo ";
                $cadenaSql.=" WHERE vigencia = $variable; ";
                break;

            case "obtenerValorContrato" :
                $cadenaSql = " SELECT valor_contrato FROM contrato_general ";
                $cadenaSql.=" WHERE numero_contrato='" . $variable['numero_contrato'] . "' and vigencia=" . $variable['vigencia'] . "; ";
                break;

            case "obtenerAmparosParametros" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos; ";

                break;
            case "obtenerAmparoResponsabilidadCivil" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos WHERE id= 10; ";

                break;
            case "obtenerNombreAmparo" :
                $cadenaSql = " SELECT nombre FROM core.amparos WHERE id = $variable; ";

                break;

            case 'Consultar_Info_Suscripcion' :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= " FROM contrato_suscrito cs  ";
                $cadenaSql .= " WHERE cs.numero_contrato = '" . $variable[0] . "' and cs.vigencia = " . $variable[1] . " ;";

                break;

            case 'obtenerInfoProveedor' :
                $cadenaSql = " SELECT tipopersona, num_documento, nom_proveedor  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE id_proveedor = $variable ;";

                break;
        }
        return $cadenaSql;
    }

}

?>
