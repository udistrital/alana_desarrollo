<?php

namespace gestionContractual\registrarElementoContrato;

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
            case "tipo_orden" :

                $cadenaSql = " 	SELECT 	id_parametro, ";
                $cadenaSql .= " descripcion ";
                $cadenaSql .= " FROM  ";
                $cadenaSql .= " parametros ";

                $cadenaSql .= " WHERE  ";
                $cadenaSql .= " estado_registro=TRUE  ";
                $cadenaSql .= " AND  ";
                $cadenaSql .= " rel_parametro=30;  ";

                break;


            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;


            case "convenios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio; ";
                break;

            case "buscar_nombre_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NOMBRE\"";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;

            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM \"sedes_SIC\" ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ";
                $cadenaSql .= " ORDER BY \"ESF_SEDE\" ;";
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

            case "nombre_participante_natural" :

                $cadenaSql = " SELECT p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  WHERE num_documento_persona=$variable;   ";

                break;

            case "nombre_participante" :

                $cadenaSql = " SELECT nom_proveedor, tipopersona,puntaje_evaluacion ";
                $cadenaSql.=" FROM agora.informacion_proveedor WHERE num_documento=$variable; ";

                break;


//-----------------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------

            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO='A' ";
                $cadenaSql .= " ORDER BY FUN_NOMBRE";

                break;


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
            case "consultarContratosGeneral" :

                $cadenaSql = "SELECT DISTINCT cg.clase_contratista,p.descripcion, cg.numero_contrato, cg.vigencia, cg.fecha_registro, cg.contratista as proveedor,cg.tipologia_contrato,tpc.tipo_contrato , "
                        . "   ec.nombre_estado, ce.fecha_registro as fecha_registro_estado, cg.convenio,se.\"ESF_SEDE\" ||'-'|| dep.\"ESF_DEP_ENCARGADA\" as SedeDependencia ";
                $cadenaSql .= "FROM parametros p, contrato_general cg, tipo_contrato tpc, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec, \"sedes_SIC\" se, \"dependencia_SIC\" dep  ";
                $cadenaSql .= "WHERE cg.tipologia_contrato = p.id_parametro ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND se.\"ESF_ID_SEDE\" = cg.sede_solicitante AND  cg.tipo_contrato = tpc.id  ";
                $cadenaSql .= "AND dep.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " AND cg.vigencia = " . $variable['vigencia_curso'] . "  and tpc.id_grupo_tipo_contrato = 2  ";
                $cadenaSql .= "AND cg.estado = 'true' AND ec.id =1  AND cg.clase_contratista is not null ";
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND cg.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND cg.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['contratista'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['contratista'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND cg.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ORDER BY cg.vigencia,cg.numero_contrato DESC; ";

                break;




            case "consultarContratosGeneral" :

                $cadenaSql = "SELECT DISTINCT cg.clase_contratista,p.descripcion, cg.numero_contrato, cg.vigencia, cg.fecha_registro, cg.contratista as proveedor,cg.tipologia_contrato, "
                        . "  cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado, cg.convenio ";
                $cadenaSql .= "FROM parametros p, contrato_general cg, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE cg.tipologia_contrato = p.id_parametro ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . "   and cg.tipo_contrato = 2  ";
                $cadenaSql .= "AND cg.estado = 'true' AND ec.id =1  AND cg.clase_contratista is not null ";
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipologia_contrato = '" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND cg.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND cg.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['contratista'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['contratista'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND cg.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;



            case "consultarOrdenIdexud" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,cg.unidad_ejecutora,"
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado,conv.\"NUMERO_PRO\" ";
                $cadenaSql .= "FROM orden o, parametros p,  contrato_general cg, convenio conv, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.convenio_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND o.estado = 'true' AND cg.estado_aprobacion = 'f' ";
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

            case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;

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
            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE sa.\"ESF_ID_SEDE\"='" . $variable . "' ";
                $cadenaSql .= " AND  ad.\"ESF_ESTADO\"='A'";
                $cadenaSql .= " ORDER BY  \"ESF_DEP_ENCARGADA\" ";

                break;

            case "dependencias" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM arka_parametros.arka_dependencia ad ";
                $cadenaSql .= " JOIN  arka_parametros.arka_espaciosfisicos ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  arka_parametros.arka_sedes sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A'";

                break;



            // ---- conulta Acta
            case "consultar_id_acta" :
                $cadenaSql = " SELECT id_actarecibido, id_actarecibido as acta_serial";
                $cadenaSql .= " FROM registro_actarecibido ";
                $cadenaSql .= " ORDER BY  id_actarecibido DESC;  ";
                break;



            case "consultar_iva" :

                $cadenaSql = "SELECT iva ";
                $cadenaSql .= "FROM arka.aplicacion_iva ";
                $cadenaSql .= "WHERE id_iva='" . $variable . "';";

                break;

            // ----

            case "ConsultaTipoBien" :

                $cadenaSql = "SELECT ge.elemento_tipobien , tb.descripcion  ";
                $cadenaSql .= "FROM  arka.catalogo_elemento ce ";
                $cadenaSql .= "JOIN  arka.catalogo_elemento_grupo ge  ON (ge.elemento_id)::text =ce .elemento_grupoc  ";
                $cadenaSql .= "JOIN  arka.tipo_bienes tb ON tb.id_tipo_bienes = ge.elemento_tipobien  ";
                $cadenaSql .= "WHERE ce.elemento_id = '" . $variable . "';";
                break;

            case "buscar_placa_maxima" :
                $cadenaSql = " SELECT  MAX(placa::FLOAT) placa_max ";
                $cadenaSql .= " FROM elemento_individual ";
                break;

            case "buscar_repetida_placa" :
                $cadenaSql = " SELECT  count (placa) ";
                $cadenaSql .= " FROM elemento_individual ";
                $cadenaSql .= " WHERE placa ='" . $variable . "';";
                break;

            case "proveedor_informacion" :
                $cadenaSql = " SELECT PRO_NIT,PRO_RAZON_SOCIAL  ";
                $cadenaSql .= " FROM PROVEEDORES ";
                $cadenaSql .= " WHERE PRO_NIT='" . $variable . "'";

                break;

            case "proveedores" :
                $cadenaSql = " SELECT \"PRO_NIT\",\"PRO_NIT\"||' - '||\"PRO_RAZON_SOCIAL\" AS proveedor ";
                $cadenaSql .= " FROM arka_parametros.arka_proveedor ";

                break;

            case "clase_entrada" :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "id_clase, descripcion  ";
                $cadenaSql .= "FROM clase_entrada;";

                break;

            case "consultar_tipo_bien" :

                $cadenaSql = "SELECT id_tipo_bienes, descripcion ";
                $cadenaSql .= "FROM arka.tipo_bienes;";

                break;

            case "consultar_tipo_poliza" :

                $cadenaSql = "SELECT id_tipo_poliza, descripcion ";
                $cadenaSql .= "FROM arka.tipo_poliza;";

                break;

            case "consultar_tipo_iva" :

                $cadenaSql = "SELECT id_iva, descripcion ";
                $cadenaSql .= "FROM arka.aplicacion_iva;";

                break;

            case "consultar_bodega" :

                $cadenaSql = "SELECT id_bodega, descripcion ";
                $cadenaSql .= "FROM arka.bodega;";

                break;

            case "consultar_placa" :

                $cadenaSql = "SELECT MAX( placa) ";
                $cadenaSql .= "FROM elemento ";
                $cadenaSql .= "WHERE tipo_bien='1';";

                break;

            case "consultar_entrada_acta" :

                $cadenaSql = "SELECT acta_recibido ";
                $cadenaSql .= "FROM entrada ";
                $cadenaSql .= "WHERE id_entrada='" . $variable . "'";

                break;

            case "consultar_elementos_acta" :

                $cadenaSql = "SELECT id_items ";
                $cadenaSql .= "FROM items_actarecibido ";
                $cadenaSql .= "WHERE id_acta='" . $variable . "'";

                break;

            case "consultar_elementos_entrada" :

                $cadenaSql = "SELECT id_elemento ";
                $cadenaSql .= "FROM elemento  ";
                $cadenaSql .= "WHERE id_entrada='" . $variable . "'";

                break;

            case "idElementoMax" :

                $cadenaSql = "SELECT max(id_elemento) ";
                $cadenaSql .= "FROM elemento  ";

                break;

            case "idElementoMaxIndividual" :

                $cadenaSql = "SELECT max(id_elemento_ind) ";
                $cadenaSql .= "FROM elemento_individual  ";

                break;

            case "consultar_tipo_iva" :

                $cadenaSql = "SELECT id_iva, descripcion ";
                $cadenaSql .= "FROM arka.aplicacion_iva;";

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

            case "ElementoImagen" :

                $cadenaSql = " 	INSERT INTO asignar_imagen_acta(";
                $cadenaSql .= " id_elemento_acta, imagen ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['elemento'] . "',";
                $cadenaSql .= "'" . $variable ['imagen'] . "') ";
                $cadenaSql .= "RETURNING id_imagen; ";

                break;

            case "ingresar_elemento_individual" :

                $cadenaSql = " 	INSERT INTO elemento_individual(";
                $cadenaSql .= "fecha_registro, placa, serie, id_elemento_gen,id_elemento_ind) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= ((is_null($variable [1])) ? 'null' . "," : "'" . $variable [1] . "',");
                $cadenaSql .= ((is_null($variable [2])) ? 'null' . "," : "'" . $variable [2] . "',");
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "') ";
                $cadenaSql .= "RETURNING id_elemento_ind; ";

                break;

           case "ingresar_elemento_tipo_1" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " elemento_acta_recibido(fecha_registro, nivel, tipo_bien, descripcion, 
						cantidad, unidad, valor, iva, subtotal_sin_iva, total_iva, total_iva_con,
                                                marca, serie,codigo_dependencia,funcionario,numero_contrato,vigencia) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['fechaActual'] . "',";
                $cadenaSql .= "'" . $variable ['nivel'] . "',";
                $cadenaSql .= "'" . $variable ['tipoBien'] . "',";
                $cadenaSql .= "'" . $variable ['descripcion'] . "',";
                $cadenaSql .= "'" . $variable ['cantidad'] . "',";
                $cadenaSql .= "'" . $variable ['unidad'] . "',";
                $cadenaSql .= "'" . $variable ['valor'] . "',";
                $cadenaSql .= "'" . $variable ['iva'] . "',";
                $cadenaSql .= "'" . $variable ['subtotal_sin_iva'] . "',";
                $cadenaSql .= "'" . $variable ['total_iva'] . "',";
                $cadenaSql .= "'" . $variable ['total_iva_con'] . "',";
                $cadenaSql .= "'" . $variable ['marca'] . "',";
                $cadenaSql .= "'" . $variable ['serie'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['funcionario'] . "',";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "', ";
                $cadenaSql .= "" . $variable ['vigencia']. ") ";
                $cadenaSql .= "RETURNING  id_elemento_ac ";

                break;

            case "ingresar_elemento_tipo_2" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " elemento_acta_recibido(";
                $cadenaSql .= " fecha_registro, nivel, tipo_bien, descripcion,
			        cantidad, unidad, valor, iva, subtotal_sin_iva, total_iva, total_iva_con,
				marca, serie,codigo_dependencia,funcionario,numero_contrato,vigencia)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['fechaActual'] . "',";
                $cadenaSql .= "'" . $variable ['nivel'] . "',";
                $cadenaSql .= "'" . $variable ['tipoBien'] . "',";
                $cadenaSql .= "'" . $variable ['descripcion'] . "',";
                $cadenaSql .= "'" . $variable ['cantidad'] . "',";
                $cadenaSql .= "'" . $variable ['unidad'] . "',";
                $cadenaSql .= "'" . $variable ['valor'] . "',";
                $cadenaSql .= "'" . $variable ['iva'] . "',";
                $cadenaSql .= "'" . $variable ['subtotal_sin_iva'] . "',";
                $cadenaSql .= "'" . $variable ['total_iva'] . "',";
                $cadenaSql .= "'" . $variable ['total_iva_con'] . "',";
                $cadenaSql .= "'" . $variable ['marca'] . "',";
                $cadenaSql .= "'" . $variable ['serie'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['funcionario'] . "',";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= "'" . $variable ['vigencia'] . "')";
                $cadenaSql .= "RETURNING  id_elemento_ac; ";

                break;

            case "ElementoImagen" :

                $cadenaSql = " 	INSERT INTO asignar_imagen_acta(";
                $cadenaSql .= " id_elemento_acta, imagen ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['elemento'] . "',";
                $cadenaSql .= "'" . $variable ['imagen'] . "') ";
                $cadenaSql .= "RETURNING id_imagen; ";

                break;

            case "ingresar_elemento_masivo" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " elemento(";
                $cadenaSql .= "fecha_registro,nivel,tipo_bien, descripcion, cantidad, ";
                $cadenaSql .= "unidad, valor, ajuste, bodega, subtotal_sin_iva, total_iva, ";
                $cadenaSql .= "total_iva_con,tipo_poliza, fecha_inicio_pol, fecha_final_pol,marca,serie,id_entrada) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "',";
                $cadenaSql .= "'" . $variable [5] . "',";
                $cadenaSql .= "'" . $variable [6] . "',";
                $cadenaSql .= "'" . $variable [7] . "',";
                $cadenaSql .= "'" . $variable [8] . "',";
                $cadenaSql .= "'" . $variable [9] . "',";
                $cadenaSql .= "'" . $variable [10] . "',";
                $cadenaSql .= "'" . $variable [11] . "',";
                $cadenaSql .= "'" . $variable [12] . "',";
                $cadenaSql .= "'" . $variable [13] . "',";
                $cadenaSql .= "'" . $variable [14] . "',";
                $cadenaSql .= "'" . $variable [15] . "',";
                $cadenaSql .= "'" . $variable [16] . "',";
                $cadenaSql .= "'" . $variable [17] . "') ";
                $cadenaSql .= "RETURNING  id_elemento; ";

                break;

            case "buscar_entradas" :
                $cadenaSql = " SELECT DISTINCT id_entrada valor, consecutivo||' - ('||entrada.vigencia||')' descripcion  ";
                $cadenaSql .= " FROM entrada  ";
                $cadenaSql .= "WHERE cierre_contable='f' ";
                $cadenaSql .= "AND   estado_registro='t' ";
                $cadenaSql .= "AND   estado_entrada = 1  ";
                $cadenaSql .= "ORDER BY id_entrada DESC ;";

                break;

            case "consultarEntrada" :
                $cadenaSql = "SELECT DISTINCT ";
                $cadenaSql .= "en.id_entrada, en.fecha_registro,  ";
                $cadenaSql .= " ce.descripcion,pr.\"PRO_NIT\" as nit , en.consecutivo||' - ('||en.vigencia||')' entradas , en.vigencia ,  pr.\"PRO_RAZON_SOCIAL\" as razon_social  ";
                $cadenaSql .= "FROM entrada en  ";
                $cadenaSql .= "JOIN clase_entrada ce ON ce.id_clase = en.clase_entrada ";
                $cadenaSql .= "LEFT JOIN arka_parametros.arka_proveedor pr ON pr.\"PRO_NIT\" = CAST(en.proveedor AS CHAR(50)) ";
                $cadenaSql .= "WHERE en.cierre_contable='f'  ";
                $cadenaSql .= "AND   en.estado_registro='t' ";
                $cadenaSql .= "AND   en.estado_entrada = 1  ";

                if ($variable [0] != '') {
                    $cadenaSql .= " AND en.id_entrada = '" . $variable [0] . "' ";
                }

                if ($variable [1] != '') {
                    $cadenaSql .= " AND en.fecha_registro BETWEEN CAST ( '" . $variable [1] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable [2] . "' AS DATE)  ";
                }

                if ($variable [3] != '') {
                    $cadenaSql .= " AND clase_entrada = '" . $variable [3] . "' ";
                }
                if ($variable [4] != '') {
                    $cadenaSql .= " AND en.proveedor = '" . $variable [4] . "' ";
                }

                $cadenaSql .= "ORDER BY en.id_entrada DESC ;";

                break;

            case "consultarEntradaParticular" :

                $cadenaSql = "SELECT  ";
                $cadenaSql .= "entrada.id_entrada, entrada.fecha_registro,  ";
                $cadenaSql .= " cl.descripcion,proveedor, consecutivo||' - ('||entrada.vigencia||')' entradas,entrada.vigencia    ";
                $cadenaSql .= "FROM arka.entrada ";
                $cadenaSql .= "JOIN arka.clase_entrada cl ON cl.id_clase = entrada.clase_entrada ";
                $cadenaSql .= "WHERE entrada.id_entrada = '" . $variable . "';";

                break;

            case "buscar_Proveedores" :
                $cadenaSql = " SELECT nit||' - ('||nomempresa||')' AS  value, nit AS data  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info ";
                $cadenaSql .= " WHERE cast(nit as text) LIKE '%$variable%' OR nomempresa LIKE '%$variable%' LIMIT 10; ";
                break;

            case "consultar_tipos_bien" :
                $cadenaSql = " SELECT id_tipo_bien, descripcion  ";
                $cadenaSql .= " FROM tipo_bien; ";
                break;


            case "buscar_numero_orden" :

                $cadenaSql = " 	SELECT 	o.numero_contrato ||'-'|| o.vigencia as value, o.numero_contrato ||'-'||o.vigencia as orden ";
                $cadenaSql .= " FROM orden o, contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE o.numero_contrato = cg.numero_contrato and o.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= " and tipo_orden ='" . $variable['tipo_orden'] . "' AND ec.id = 1 AND cg.tipo_contrato = 1 ;";

                break;
            case "cargos_existentes" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " distinct \"FUN_CARGO\" ";
                $cadenaSql .= " FROM arka_parametros.arka_funcionarios; ";

                break;


            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT DISTINCT contratista AS  value, contratista AS data  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE cast(contratista as text) LIKE '%$variable%' LIMIT 10; ";
                break;


            //------------------------- Nuevos SQLs-----------------------------------------------------------

            case "tipo_contrato" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' and id_grupo_tipo_contrato <> 1 ;";

                break;


            case "unidad_ejecutora_gasto" :

                $cadenaSql = " SELECT id , nombre   ";
                $cadenaSql .= " FROM kronos.unidad_ejecutora; ";

                break;

            case 'buscar_contratista' :
                $cadenaSql = " SELECT num_documento||' - '||nom_proveedor AS  value, id_proveedor  AS data  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (cast(num_documento as text) LIKE '%" . $variable . "%'  ";
                $cadenaSql .= "  OR nom_proveedor  LIKE '%" . $variable . "%') LIMIT 15; ";
                break;

            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.id_rel_parametro= 8 or  rl.id_rel_parametro= 6; ";

                break;

            case 'buscar_contrato' :
                $cadenaSql = " SELECT  DISTINCT cg.numero_contrato||'-('||cg.vigencia||')' AS  data, cg.numero_contrato||' - ('||cg.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec, tipo_contrato tpc   ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora ='" . $variable['unidad'] . "' AND cg.tipo_contrato=tpc.id ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id AND ec.id =1 AND tpc.id_grupo_tipo_contrato = 2 AND cg.vigencia = '" . $variable['vigencia_curso'] . "'  ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND ( cast(cg.numero_contrato as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= " OR cast(cg.vigencia as text ) LIKE '%" . $variable['parametro'] . "%' ) ";
                $cadenaSql .= "   ORDER BY data ASC  LIMIT 10 ;";
                break;



            //------------------------- Nuevos SQLs-----------------------------------------------------------
        }
        return $cadenaSql;
    }

}

?>
