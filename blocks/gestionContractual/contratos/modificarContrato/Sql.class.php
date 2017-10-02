<?php

namespace contratos\modificarContrato;

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
            case 'buscar_contrato' :
                $cadenaSql = " SELECT  DISTINCT cg.numero_contrato||'-('||cg.vigencia||')' AS  data, cg.numero_contrato||' - ('||cg.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec, tipo_contrato tpc  ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora ='" . $variable['unidad'] . "' AND cg.tipo_contrato=tpc.id ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id AND ec.id =1 AND  tpc.id_grupo_tipo_contrato = 2 AND cg.vigencia = '" . $variable['vigencia_curso'] . "' ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND ( cast(cg.numero_contrato as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= " OR cast(cg.vigencia as text ) LIKE '%" . $variable['parametro'] . "%' ) ";
                $cadenaSql .= "   ORDER BY data ASC  LIMIT 10 ;";
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
            
             case 'buscarContratoGeneral' :
                $cadenaSql = " SELECT  DISTINCT cg.numero_contrato||'-('||cg.vigencia||')' AS  data, cg.numero_contrato||' - ('||cg.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato_general cg, contrato_estado ce, estado_contrato ec, tipo_contrato tpc  ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora ='" . $variable['unidad'] . "' AND cg.tipo_contrato=tpc.id ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id AND ec.id =1 AND  tpc.id_grupo_tipo_contrato = 2 AND cg.vigencia = '" . $variable['vigencia_curso'] . "' ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND ( cast(cg.numero_contrato as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= " OR cast(cg.vigencia as text ) LIKE '%" . $variable['parametro'] . "%' ) ";
                $cadenaSql .= "   ORDER BY data ASC  LIMIT 10 ;";
                break;
            
            case 'consultaLugarEjecucion' :
                $cadenaSql = " SELECT id, direccion, sede, dependencia, ciudad  ";
                $cadenaSql .= " FROM argo.lugar_ejecucion ";
                $cadenaSql .= " WHERE id= ". $variable. "; ";
                break;
            
            case "obtenerAmparosParametros" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos; ";

                break;
            
             case "obtenerAmparosParametros2" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos WHERE id=".$variable." ; ";
                 
                break;

             case "obtenerAmparosParametrosNoRegistrados" :
                $cadenaSql = " SELECT amparos.id, amparos.nombre FROM core.amparos ";
                $cadenaSql .= " where not exists (SELECT id FROM argo.amparo_contrato ";
                $cadenaSql .= " WHERE numero_contrato='".$variable[0]."' AND vigencia_contrato=".$variable[1]." ";
                $cadenaSql .= " AND tipo_amparo=amparos.id) ";
           
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

            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO != 'I' ";

                break;


            case "cargosFuncionarios" :

                $cadenaSql = " SELECT cargo  as data, cargo  as value ";
                $cadenaSql .= " FROM argo.cargo_supervisor_temporal ";
                $cadenaSql .= " ORDER BY data; ";
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

            case 'buscarDepartamento' : // Solo Departamentos de Colombia

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'ORDER BY NOMBRE';
                break;
            case 'buscarDepartamentoColombia' : // Solo Departamentos de Colombia

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'WHERE id_pais =112 ';
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

            case 'actualizarLugarEjecucion' :

                $cadenaSql = " UPDATE lugar_ejecucion";
                $cadenaSql.=" SET direccion='" . $variable['direccion_ejecucion'] . "', sede='" . $variable['sede_ejecucion'] . "', ";
                $cadenaSql.=" dependencia='" . $variable['dependencia_ejecucion'] . "', ciudad=" . $variable['ciudad_ejecucion'] . "";
                $cadenaSql.=" WHERE id=" . $variable['lugar_ejecucion'] . ";";
                break;

            case 'insertarLugarEjecucion' :

                $cadenaSql = " INSERT INTO lugar_ejecucion(";
                $cadenaSql.=" direccion, sede, dependencia, ";
                $cadenaSql.=" ciudad)";
                $cadenaSql.=" VALUES ('" . $variable['direccion_ejecucion'] . "', ";
                $cadenaSql.=" '" . $variable['sede_ejecucion'] . "','" . $variable['dependencia_ejecucion'] . "'," . $variable['ciudad_ejecucion'] . ");";
                break;

            case 'ObtenerLugardeEjecucion' :

                $cadenaSql = " SELECT id FROM lugar_ejecucion ";
                $cadenaSql.=" WHERE direccion='" . $variable['direccion_ejecucion'] . "' AND sede='" . $variable['sede_ejecucion'] . "'  ";
                $cadenaSql.=" AND dependencia ='" . $variable['dependencia_ejecucion'] . "' AND ciudad =" . $variable['ciudad_ejecucion'] . "; ";

                break;



            case "informacion_sociedad_temporal" :

                $cadenaSql = " SELECT identificacion, documento_representante, documento_suplente,digito_verificacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal WHERE identificacion=$variable; ";

                break;
            case "informacion_sociedad_proveedor" :

                $cadenaSql = " SELECT num_documento,id_ciudad_contacto,correo,web,";
                $cadenaSql.= " tipo_cuenta_bancaria,num_cuenta_bancaria,";
                $cadenaSql.= " id_entidad_bancaria,nom_proveedor,";
                $cadenaSql.= " documento_representante, documento_suplente,digito_verificacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal, agora.informacion_proveedor  ";
                $cadenaSql.=" WHERE num_documento = identificacion and  num_documento=$variable; ";

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

            case "info_representante" :

                $cadenaSql = " SELECT   p.num_documento_persona ||' - '|| p.primer_apellido||' '||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p, agora.informacion_proveedor ip  ";
                $cadenaSql .= " WHERE p.num_documento_persona = ip.num_documento AND ip.id_proveedor = $variable;  ";


                break;




            case "eliminar_participantes_actuales" :

                $cadenaSql = " DELETE FROM agora.informacion_sociedad_participante WHERE id_sociedad = $variable;";

                break;
            case "consultarInfoNovedadModificacion" :
                $cadenaSql = "  SELECT nc.*, mc.novedad, mc.razon ";
                $cadenaSql .= " FROM modificacion_contractual mc , novedad_contractual nc   ";
                $cadenaSql .= " WHERE mc.id = nc.id AND nc.id = $variable; ";
                break;

            case "buscarDepartamentodeCiudad" :

                $cadenaSql = " select d.id_departamento ";
                $cadenaSql.=" from core.departamento d, core.ciudad c ";
                $cadenaSql.=" where c.id_departamento = d.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable;";

                break;

            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza, estado ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza ORDER BY id_poliza; ";
                break;
            case "obtenerPolizarOrden" :
                $cadenaSql = " 	SELECT poliza, fecha_inicio, fecha_final ";
                $cadenaSql .= " FROM contrato_poliza ";
                $cadenaSql .= " WHERE numero_contrato='" . $variable['numero_contrato'] . "' AND vigencia= " . $variable['vigencia'] . ";";

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

            case "consultaPlantilla" :
                $cadenaSql = " SELECT plantilla, estilo  ";
                $cadenaSql .= "  FROM plantilla_minuta ";
                $cadenaSql .= " WHERE tipo_contrato= " . $variable['tipo_contrato'] . " and tipo_plantilla = '" . $variable['tipo_plantilla'] . "';  ";

                break;


            case "actualizar_sociedad_temporal" :

                $cadenaSql = " UPDATE  agora.informacion_sociedad_temporal SET ";
                $cadenaSql.=" documento_representante=" . $variable['documento_representante'] . ", ";
                $cadenaSql.=" documento_suplente=" . $variable['documento_suplente'] . ", ";
                $cadenaSql.=" digito_verificacion=" . $variable['digito_verificacion'] . " ";
                $cadenaSql.=" WHERE identificacion=" . $variable['identificacion'] . "; ";

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
            
            case "consultaRepresentanteLegal" :

                $cadenaSql = " SELECT num_documento_persona documento, primer_nombre || ' ' || segundo_nombre || ' ' || primer_apellido || ' ' || segundo_apellido nombre, pe.valor_parametro tipo_documento, c.nombre ciudad , pn.cargo ";
                $cadenaSql .=  "FROM agora.informacion_proveedor ip  ";
                $cadenaSql .=  "JOIN agora.proveedor_representante_legal as rl ON rl.id_proveedor=ip.id_proveedor  ";
                $cadenaSql .=  "JOIN agora.informacion_persona_natural as pn ON pn.num_documento_persona=rl.id_representante  ";
                $cadenaSql .=  "JOIN agora.parametro_estandar as pe ON pe.id_parametro=pn.tipo_documento  ";
                $cadenaSql .=  "JOIN core.ciudad as c ON c.id_ciudad=pn.id_ciudad_expedicion_documento  ";
                $cadenaSql .=  "WHERE ip.id_proveedor =".$variable;   
                break;

		case "consultaDigitoVerificacion" :

                $cadenaSql = " SELECT digito_verificacion ";
                $cadenaSql .=  "FROM agora.informacion_persona_juridica ";
                $cadenaSql .=  "WHERE num_nit_empresa=".$variable;   
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
            case "dependenciasConsultadasNulo" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A' ; ";

                break;

            case "cargoSuper" :

                $cadenaSql = " SELECT  FUN_CARGO || '('||FUN_DEP_NOM_ACADEMICA||')' ";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable ";

                break;


            case "perfiles" :

                $cadenaSql = " SELECT id_parametro, INITCAP(valor_parametro) ";
                $cadenaSql .= " FROM agora.parametro_estandar  ";
                $cadenaSql .= " WHERE clase_parametro = 'Tipo Perfil'; ";

                break;

            case "insertarPerfilCPS" :
                $cadenaSql = " INSERT INTO argo.contrato_cps(";
                $cadenaSql.=" numero_contrato, vigencia, perfil)";
                $cadenaSql.=" VALUES ('" . $variable['numero_contrato'] . "', " . $variable['vigencia'] . ", " . $variable['perfil'] . ");";

                break;

            case "ConsultarperfilCPS" :
                $cadenaSql = " SELECT perfil from  argo.contrato_cps ";
                $cadenaSql.=" WHERE ";
                $cadenaSql .= " numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " vigencia = $variable[1] ; ";

                break;

            case "ConsultarNombrePerfil" :
                $cadenaSql = " SELECT valor_parametro  from  agora.parametro_estandar ";
                $cadenaSql.=" WHERE id_parametro =  $variable; ";


                break;

            case "EliminarRelacionperfilCPS" :
                $cadenaSql = " DELETE from  argo.contrato_cps ";
                $cadenaSql.=" WHERE ";
                $cadenaSql .= " numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " vigencia = $variable[1] ; ";

                break;


            case "actualizarPerfilCPs" :
                $cadenaSql = " UPDATE argo.contrato_cps";
                $cadenaSql.=" SET perfil=" . $variable['perfil'] . " ";
                $cadenaSql.=" WHERE numero_contrato='" . $variable['numero_contrato'] . "' AND vigencia=" . $variable['vigencia'] . ";";

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

            case "obtenerNumeroMaximoContratoVigencia" :
                $cadenaSql = " SELECT MAX(CAST(numero_contrato_suscrito AS integer)) AS numero_contrato_suscrito ";
                $cadenaSql.=" FROM argo.contrato_suscrito WHERE numero_contrato_suscrito NOT LIKE '%DVE%' ";
                $cadenaSql.=" AND vigencia = $variable;";
                break;


            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "ordenadorGasto" :

                $cadenaSql = " SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO FROM SICAARKA.ORDENADORES_GASTO ";
                $cadenaSql.=" WHERE ORG_ESTADO='A' ";

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

            case "obteneConsecutivoContratoAprobado" :
                $cadenaSql = " SELECT MAX(consecutivo_contrato) as consecutivo_contrato FROM contrato_aprobado; ";

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
            case "vigencias_solicitudes" :

                $cadenaSql = "SELECT DISTINCT vigencia , vigencia valor  ";
                $cadenaSql .= " FROM solicitud_necesidad  ";
                $cadenaSql .= "WHERE estado_registro=TRUE; ";

                break;

            case "ConsultarNumeroNecesidades" :

                $cadenaSql = "SELECT DISTINCT numero_solicitud id , numero_solicitud descripcion   ";
                $cadenaSql .= " FROM solicitud_necesidad  ";
                $cadenaSql .= "WHERE vigencia='" . $variable . "';";

                break;

            case "tipo_identificacion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_indentificacion_contratista'; ";

                break;

            case "tipo_persona" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_persona'; ";

                break;

            case "tipo_genero" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='genero'; ";

                break;

            case "tipo_genero_ajax" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='genero' and ";
                if ($variable == 1) {
                    $condicion = " id_parametro <> 247; ";
                } else {
                    $condicion = " id_parametro = 247; ";
                }

                $cadenaSql .= $condicion;

                break;

            case "tipo_perfil" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_perfil'; ";

                break;

            case "tipo_nacionalidad" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='nacionalidad'; ";

                break;


            case "consultarContratosGeneral" :

                $cadenaSql = "SELECT DISTINCT cg.clase_contratista,p.descripcion, cg.numero_contrato, cg.vigencia, cg.fecha_registro, cg.contratista as proveedor,cg.tipologia_contrato, "
                        . "  ec.nombre_estado, ce.fecha_registro as fecha_registro_estado, cg.convenio, tpc.tipo_contrato ";
                $cadenaSql .= "FROM parametros p, contrato_general cg, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec, argo.tipo_contrato tpc  ";
                $cadenaSql .= "WHERE cg.tipologia_contrato = p.id_parametro AND cg.tipo_contrato = tpc.id ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where cg.numero_contrato = cee.numero_contrato and  cg.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . "   and tpc.id_grupo_tipo_contrato = 2  ";
                $cadenaSql .= "AND cg.estado = 'true' AND ec.id =1  AND cg.vigencia = " . $variable['vigencia_curso'] . "  ";
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['clase_contrato'] . "' ";
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

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND cg.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ORDER BY cg.vigencia, cg.numero_contrato DESC; ";

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




            case "tipo_cuenta" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_cuenta_bancaria'; ";

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
                $cadenaSql .= "WHERE rl.id_rel_parametro= 8 or  rl.id_rel_parametro= 6; ";

                break;

            case "tipo_compromisoContrato" :

                $cadenaSql = " SELECT id as id, codigo_contraloria|| ' - ' || grupo_contrato as valor";
                $cadenaSql.=" FROM argo.grupo_tipo_contrato WHERE (id = 2 or id = 3) ;";

                break;
            case "tipo_contrato" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' and id_grupo_tipo_contrato <> 1 ;";

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

            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  ORG_NOMBRE,  ORG_IDENTIFICACION ";
                $cadenaSql .= " FROM SICAARKA.ORDENADORES_GASTO  ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR = $variable and ORG_ESTADO = 'A'";

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

            case "consultarSolicitud" :
                $cadenaSql = "SELECT DISTINCT ";
                $cadenaSql .= "id_sol_necesidad, vigencia, numero_solicitud, fecha_solicitud,
				               valor_contratacion, unidad_tiempo_ejecucion ||' '||descripcion duracion, objeto_contrato ";
                $cadenaSql .= "FROM solicitud_necesidad ";
                $cadenaSql .= "JOIN parametros pr ON pr.id_parametro = ejecucion   ";
                $cadenaSql .= "WHERE solicitud_necesidad.estado_registro= TRUE ";

                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND vigencia = '" . $variable ['vigencia'] . "' ";
                }
                if ($variable ['numero_solicitud'] != '') {
                    $cadenaSql .= " AND numero_solicitud = '" . $variable ['numero_solicitud'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '') {
                    $cadenaSql .= " AND fecha_solicitud BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;

            case "Consultar_Solicitud_Particular" :
                $cadenaSql = " SELECT NUM_SOL_ADQ, OBJETO as objeto, DEPENDENCIA as dependencia, ";
                $cadenaSql.=" VALOR_CONTRATACION as valor_contrato FROM CO.CO_SOLICITUD_ADQ WHERE ";
                $cadenaSql.=" NUM_SOL_ADQ=$variable[0] and VIGENCIA=$variable[1] and CODIGO_UNIDAD_EJECUTORA = '0$variable[2]'";

                break;

            case "Consultar_Disponibilidad" :
                $cadenaSql = " SELECT CDP.NUMERO_DISPONIBILIDAD, CDP.VIGENCIA, RB.DESCRIPCION, ";
                $cadenaSql.=" CDP.RUBRO_INTERNO , CDP.VALOR ";
                $cadenaSql.=" FROM PR.PR_DISPONIBILIDAD_RUBRO CDP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE CDP.VIGENCIA = RB.VIGENCIA and CDP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and CDP.VIGENCIA = $variable[1] AND CDP.CODIGO_UNIDAD_EJECUTORA='0$variable[2]' ";
                $cadenaSql.=" AND CDP.NUMERO_DISPONIBILIDAD = $variable[0] ";
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



            case "Consultar_Rubros" :
                $cadenaSql = " SELECT RP.NUMERO_REGISTRO, RP.RUBRO_INTERNO,RB.DESCRIPCION, ";
                $cadenaSql.=" RP.VALOR FROM PR.PR_REGISTRO_DISPONIBILIDAD RP, PR.PR_RUBRO RB";
                $cadenaSql.=" WHERE RP.VIGENCIA = RB.VIGENCIA and RP.RUBRO_INTERNO = RB.INTERNO ";
                $cadenaSql.=" and RP.VIGENCIA = $variable[1]  and RP.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";
                $cadenaSql.=" and RP.NUMERO_DISPONIBILIDAD=  $variable[0]";
                break;


            case "Consultar_Registro_Presupuestales" :
                $cadenaSql = " SELECT rp.id_registro_pres, rp.numero_registro, rp.valor_registro, rp.vigencia,rp.fecha_rgs_pr  ";
                $cadenaSql .= " FROM registro_presupuestal rp ";
                $cadenaSql .= " WHERE rp.estado_registro=true and rp.disponibilidad_presupuestal=$variable;";
                break;

            case "Consultar_Contratista" :
                $cadenaSql = " SELECT cns.*, ib.tipo_cuenta,ib.nombre_banco,ib.numero_cuenta,ib.id_inf_bancaria,oc.id_orden_contr, sl.funcionario_solicitante  ";
                $cadenaSql .= " FROM contratista cns";
                $cadenaSql .= " LEFT JOIN inf_bancaria ib ON ib.contratista=cns.id_contratista ";
                $cadenaSql .= " LEFT JOIN orden_contrato oc ON oc.contratista=cns.id_contratista";
                $cadenaSql .= " LEFT JOIN solicitud_necesidad sl ON sl.id_sol_necesidad=oc.solicitud_necesidad";
                $cadenaSql .= " WHERE cns.estado_registro=TRUE ";
                $cadenaSql .= " AND sl.id_sol_necesidad= '" . $variable . "';";

                break;


            case "actualizar_contratista" :
                $cadenaSql = " UPDATE contratista";
                $cadenaSql .= " SET ";
                $cadenaSql .= " direccion='" . $variable ['direccion'] . "', ";
                $cadenaSql .= " telefono='" . $variable ['telefono'] . "', ";
                $cadenaSql .= " digito_verificacion='" . $variable ['digito_verificacion'] . "', ";

                if ($variable ['correo'] != '') {

                    $cadenaSql .= " correo='" . $variable ['correo'] . "', ";
                } else {

                    $cadenaSql .= " correo=NULL, ";
                }
                $cadenaSql .= " identificacion='" . $variable ['numero_identificacion'] . "', ";
                $cadenaSql .= " genero='" . $variable ['genero'] . "', ";
                $cadenaSql .= " tipo_naturaleza='" . $variable ['tipo_persona'] . "', ";
                $cadenaSql .= " tipo_documento='" . $variable ['tipo_identificacion'] . "', ";
                $cadenaSql .= " nombre_razon_social='" . $variable ['razon_social'] . "',";
                $cadenaSql .= " nacionalidad='" . $variable ['nacionalidad'] . "', ";
                $cadenaSql .= " perfil='" . $variable ['perfil'] . "', ";
                $cadenaSql .= " profesion='" . $variable ['profesion'] . "',";
                $cadenaSql .= " especialidad='" . $variable ['especialidad'] . "'";
                $cadenaSql .= " WHERE id_contratista='" . $variable ['id_contratista'] . "';";

                break;


            case 'actualizar_informacion_bancaria' :

                $cadenaSql = " UPDATE inf_bancaria";
                $cadenaSql .= " SET tipo_cuenta='" . $variable ['tipo_cuenta'] . "',";
                $cadenaSql .= " nombre_banco='" . $variable ['entidad_bancaria'] . "', ";
                $cadenaSql .= " numero_cuenta='" . $variable ['numero_cuenta'] . "' ";
                $cadenaSql .= " WHERE id_inf_bancaria='" . $variable ['id_info_bancaria'] . "' ;";

                break;

            case 'registrar_informacion_bancaria' :
                $cadenaSql = " INSERT INTO inf_bancaria(tipo_cuenta, nombre_banco, numero_cuenta,contratista, fecha_registro)";
                $cadenaSql .= " VALUES ( '" . $variable ['tipo_cuenta'] . "',";
                $cadenaSql .= " '" . $variable ['entidad_bancaria'] . "',";
                $cadenaSql .= " '" . $variable ['numero_cuenta'] . "',";
                $cadenaSql .= " '" . $variable ['id_contratista'] . "', ";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "');";
                break;


            case 'registrar_contratista' :
                $cadenaSql = " INSERT INTO contratista(  ";
                $cadenaSql .= " direccion, telefono, digito_verificacion, correo, ";
                $cadenaSql .= " identificacion, genero, tipo_naturaleza, tipo_documento,";
                $cadenaSql .= " fecha_registro, nacionalidad, perfil, profesion,nombre_razon_social, ";
                $cadenaSql .= " especialidad)";
                $cadenaSql .= " VALUES ('" . $variable ['direccion'] . "',";
                $cadenaSql .= " '" . $variable ['telefono'] . "',";
                $cadenaSql .= " '" . $variable ['digito_verificacion'] . "',";
                $cadenaSql .= " '" . $variable ['correo'] . "',";
                $cadenaSql .= " '" . $variable ['numero_identificacion'] . "', ";
                $cadenaSql .= " '" . $variable ['genero'] . "', ";
                $cadenaSql .= " '" . $variable ['tipo_persona'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_identificacion'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= " '" . $variable ['nacionalidad'] . "', ";
                $cadenaSql .= " '" . $variable ['perfil'] . "',";
                $cadenaSql .= " '" . $variable ['profesion'] . "',";
                $cadenaSql .= " '" . $variable ['razon_social'] . "',";
                $cadenaSql .= " '" . $variable ['especialidad'] . "') RETURNING id_contratista ;";

                break;

            case 'registrar_contrato' :

                $cadenaSql = " INSERT INTO contrato(vigencia, numero_contrato, fecha_sub, plazo_ejecucion, ";
                $cadenaSql .= " fecha_inicio, fecha_final, valor_moneda_ext, valor_tasa_cb, fecha_sub_super, ";
                $cadenaSql .= " fecha_lim_ejec, observacion_inter, observacion_contr, solicitud_necesidad, ";
                $cadenaSql .= " contratista, tipologia_contrato, tipo_configuracion, clase_contratista, ";
                $cadenaSql .= " clase_contrato, clase_compromiso, numero_constancia, unidad_ejecucion_tiempo, ";
                $cadenaSql .= " modalidad_seleccion, procedimiento, regimen_contratacion, tipo_moneda, ";
                $cadenaSql .= " tipo_gasto, origen_recursos, origen_presupuesto, tema_corr_gst_inv, ";
                $cadenaSql .= " tipo_control_ejecucion, orden_contrato, fecha_registro)";
                $cadenaSql .= " VALUES ('" . $variable ['vigencia'] . "',";
                $cadenaSql .= " '" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_subcripcion'] . "',";
                $cadenaSql .= " '" . $variable ['plazo_ejecucion'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_inicio_poliza'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_final_poliza'] . "',";
                $cadenaSql .= " '" . $variable ['valor_contrato_moneda_ex'] . "',";
                $cadenaSql .= " '" . $variable ['tasa_cambio'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_suscrip_super'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_limite'] . "',";
                $cadenaSql .= " '" . $variable ['observaciones_interventoria'] . "',";
                $cadenaSql .= " '" . $variable ['observacionesContrato'] . "',";
                $cadenaSql .= " '" . $variable ['solicitud_necesidad'] . "',";
                $cadenaSql .= " '" . $variable ['contratista'] . "',";
                $cadenaSql .= " '" . $variable ['tipologia_especifica'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_configuracion'] . "',";
                $cadenaSql .= " '" . $variable ['clase_contratista'] . "',";
                $cadenaSql .= " '" . $variable ['clase_contrato'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_compromiso'] . "',";
                $cadenaSql .= " '" . $variable ['numero_constancia'] . "',";
                $cadenaSql .= " '" . $variable ['unidad_ejecucion_tiempo'] . "',";
                $cadenaSql .= " '" . $variable ['modalidad_seleccion'] . "',";
                $cadenaSql .= " '" . $variable ['procedimiento'] . "',";
                $cadenaSql .= " '" . $variable ['regimen_contratación'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_moneda'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_gasto'] . "',";
                $cadenaSql .= " '" . $variable ['origen_recursos'] . "',";
                $cadenaSql .= " '" . $variable ['origen_presupuesto'] . "',";
                $cadenaSql .= " '" . $variable ['tema_gasto_inversion'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_control'] . "',";
                $cadenaSql .= " '" . $variable ['orden_contrato'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "');";
                break;

            case 'consultar_supervisores' :

                $cadenaSql = " SELECT DISTINCT id_funcionario identificador, identificacion||' - ' ||nombre_cp supervisor";
                $cadenaSql .= " FROM funcionario";
                $cadenaSql .= " WHERE estado_registro=TRUE";

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
                $cadenaSql.=" actividades='" . $variable['actividades'] . "', ";
                $cadenaSql.=" especificaciones_tecnicas='" . $variable['especificaciones_tecnicas'] . "', ";
                $cadenaSql.=" descripcion_forma_pago='" . $variable['descripcion_forma_pago'] . "', ";
                $cadenaSql.=" condiciones='" . $variable['condiciones'] . "', ";
                $cadenaSql.=" unidad_ejecutora=" . $variable['unidad_ejecutora'] . ",";
                $cadenaSql.=" tipologia_contrato=" . $variable['tipologia_especifica'] . ", ";
                $cadenaSql.=" tipo_compromiso=" . $variable['tipo_compromiso'] . ", ";
                $cadenaSql.=" modalidad_seleccion=" . $variable['modalidad_seleccion'] . ",";
                $cadenaSql.=" procedimiento=" . $variable['procedimiento'] . ", ";
                $cadenaSql.=" regimen_contratacion=" . $variable['regimen_contratación'] . ", ";
                $cadenaSql.=" tipo_gasto=" . $variable['tipo_gasto'] . ", ";
                $cadenaSql.=" tema_gasto_inversion=" . $variable['tema_gasto_inversion'] . ",";
                $cadenaSql.=" origen_presupueso=" . $variable['origen_presupuesto'] . ", ";
                $cadenaSql.=" origen_recursos=" . $variable['origen_recursos'] . ", ";
                $cadenaSql.=" tipo_moneda=" . $variable['tipo_moneda'] . ", ";
                $cadenaSql.=" tipo_contrato=" . $variable['tipo_contrato'] . ", ";
                $cadenaSql.=" valor_contrato_me=" . $variable['valor_contrato_moneda_ex'] . ", ";
                $cadenaSql.=" valor_tasa_cambio=" . $variable['tasa_cambio'] . ", ";
                $cadenaSql.=" tipo_control=" . $variable['tipo_control'] . ", ";
                $cadenaSql.=" lugar_ejecucion=" . $variable['lugar_ejecucion'] . ", ";
                $cadenaSql.=" observaciones='" . $variable['observacionesContrato'] . "', ";
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
                $cadenaSql .= $variable ['documento_supervisor'] . ",";
                $cadenaSql .= "'" . $variable ['cargo_supervisor'] . "',";
                $cadenaSql .= "'" . $variable ['sede_supervisor'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_supervisor'] . "',";
                $cadenaSql .= $variable ['tipo_supervisor'] . ",";
                $cadenaSql .= $variable ['digito_verificacion_supervisor'] . ");";
                break;


            case "actuaizarSupervisor" :

                $cadenaSql = " UPDATE supervisor_contrato SET ";
                $cadenaSql.=" cargo='" . $variable['cargo_supervisor'] . "', ";
                $cadenaSql.=" sede_supervisor='" . $variable['sede_supervisor'] . "', ";
                $cadenaSql.=" dependencia_supervisor='" . $variable['dependencia_supervisor'] . "', ";
                $cadenaSql.=" tipo=" . $variable['tipo_supervisor'] . ", ";
                $cadenaSql.=" digito_verificacion=" . $variable['digito_verificacion_supervisor'] . " ";
                $cadenaSql.=" WHERE id = " . $variable['id_supervisor'] . ";";

                break;



            /*
             * CONSULTA CONTRATO
             *
             */

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28;";

                break;

            case 'buscar_contratista' :
                $cadenaSql = " SELECT num_documento||' - '||nom_proveedor AS  value, id_proveedor  AS data  ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE (cast(num_documento as text) LIKE '%" . $variable . "%'  ";
                $cadenaSql .= "  OR nom_proveedor  LIKE '%" . $variable . "%') LIMIT 15; ";
                break;

            case "unidad_ejecutora_gasto" :

                $cadenaSql = " SELECT id , nombre   ";
                $cadenaSql .= " FROM kronos.unidad_ejecutora; ";

                break;

            case "consultarContrato" :

                $cadenaSql = " SELECT cg.numero_contrato, cg.vigencia,  ";
                $cadenaSql .= " cg.contratista || '-'|| cg.nombre_contratista as contratista, ";
                $cadenaSql .= " cg.numero_solicitud_necesidad, cg.numero_cdp  ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato c, contrato_general cg ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " c.numero_contrato=cg.numero_contrato and ";
                $cadenaSql .= " c.vigencia=cg.vigencia ";
                if ($variable ['id_contrato'] != '') {
                    $cadenaSql .= " AND cg.numero_contrato='" . $variable ['id_contrato'] . "' ";
                }
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato='" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['id_contratista'] != '') {
                    $cadenaSql .= " AND cg.contratista='" . $variable ['id_contratista'] . "' ";
                }
                if ($variable ['unidad_ejecutora'] != '') {
                    $cadenaSql .= " AND cg.unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND CAST ( '" . $variable ['fecha_final'] . "' AS DATE) ";
                }
                $cadenaSql .= " ;  ";

                break;


            case 'Actualizar_Contrato' :

                $cadenaSql = " UPDATE contrato SET ";
                $cadenaSql .= " observacion_inter='" . $variable ['observaciones_interventoria'] . "',";
                $cadenaSql .= " observacion_contr='" . $variable ['observacionesContrato'] . "',";
                $cadenaSql .= " clase_contratista='" . $variable ['clase_contratista'] . "',";
                $cadenaSql .= " numero_constancia='" . $variable ['numero_constancia'] . "',";
                $cadenaSql .= " perfil='" . $variable ['perfil'] . "',";
                $cadenaSql .= " fecha_registro='" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= "numero_convenio=" . $variable ['numero_convenio'] . ",";
                $cadenaSql .= "vigencia_convenio=" . $variable ['vigencia_convenio'] . ",";
                $cadenaSql .= "digito_verificacion_supervisor='" . $variable ['digito_supervisor'] . "' ";
                $cadenaSql .= "WHERE id_contrato_normal=" . $variable ['id_contrato_normal'] . ";";

                break;

            case 'Consultar_Contrato_Particular' :
                $cadenaSql = " SELECT  ";
                $cadenaSql .= " cg.*, s.documento, s.nombre,s.id as idSupervisor, s.cargo,s.sede_supervisor,s.dependencia_supervisor,s.digito_verificacion,  ";
                $cadenaSql .= " le.direccion, le.sede, le.dependencia, le.ciudad,s.tipo ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contrato_general cg, supervisor_contrato s, lugar_ejecucion le ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " cg.supervisor= s.id and cg.lugar_ejecucion = le.id and ";
                $cadenaSql .= " cg.numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " cg.vigencia = $variable[1] ; ";
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

            case "obtener_participantes" :

                $cadenaSql = " SELECT ip.num_documento ||'-'|| ip.nom_proveedor as nombre_participante, istp.porcentaje_participacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_participante istp, agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor = istp.id_contratista AND id_proveedor_sociedad = $variable; ";

                break;



            case "cargos_existentes" :
                $cadenaSql = " SELECT  DISTINCT FUN_CARGO";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ORDER BY FUN_CARGO ASC";
                break;


            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION||'-'||FUN_NOMBRE , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO != 'I' ";

                break;

            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM \"sedes_SIC\" ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ;";
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



            case 'Actualizar_Supervisor' :

                $cadenaSql = " UPDATE funcionario";
                $cadenaSql .= " SET codigo_verificacion='" . $variable ['digito_supervisor'] . "'";
                $cadenaSql .= " WHERE id_funcionario='" . $variable ['id_funcionario'] . "';";

                break;




            case 'Actualizar_Solicitud_necesidad' :

                $cadenaSql = " UPDATE solicitud_necesidad";
                $cadenaSql .= " SET valor_contratacion='" . $variable ['valor_contrato'] . "',";
                $cadenaSql .= " dependencia_destino='" . $variable ['dependencia'] . "',";
                $cadenaSql .= " objeto_contrato='" . $variable ['objeto_contrato'] . "'";
                $cadenaSql .= " WHERE id_sol_necesidad='" . $variable ['id_solicitud'] . "'";

                break;

            case 'insertarInformacionContratoTemporal' :

                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= " temporal_contrato_edicion( ";
                $cadenaSql .= " id_contrato_temp,";
                $cadenaSql .= " campo_formulario,";
                $cadenaSql .= " informacion_campo,";
                $cadenaSql .= " usuario,";
                $cadenaSql .= " fecha) ";
                $cadenaSql .= " VALUES(";
                $cadenaSql .= $variable['id'];
                $cadenaSql .= ",'" . $variable['campo'] . "',";
                $cadenaSql .= "'" . $variable['informacion'] . "',";
                $cadenaSql .= "'" . $variable['usuario'] . "',";
                $cadenaSql .= "'" . $variable['fecha'] . "');";


                break;
            case 'obtenerInfoTemporal' :

                $cadenaSql = "SELECT  DISTINCT ";
                $cadenaSql .= "id_contrato_temp ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "temporal_contrato_edicion ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
            case 'eliminarInfoTemporal' :

                $cadenaSql = "DELETE  FROM ";
                $cadenaSql .= "temporal_contrato_edicion ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;




            case 'obtener_id_contratista' :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "MAX(id_contratista) ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contratista; ";
                break;

            case 'Consultar_info_Temporal' :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "campo_formulario, ";
                $cadenaSql .= "informacion_campo ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "temporal_contrato_edicion ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;

            //-------Elementos y Servicios---------------------------------------------------------------------------

            case "consultarElementosOrden" :
                $cadenaSql = "SELECT DISTINCT ela.*, ct.elemento_nombre nivel_nombre, tb.descripcion nombre_tipo, iv.descripcion nombre_iva,elemento_nombre,  ";
                $cadenaSql .= " dep.\"ESF_DEP_ENCARGADA\"   ";
                $cadenaSql .= "FROM elemento_acta_recibido ela ";
                $cadenaSql .= "JOIN  arka.catalogo_elemento ct ON ct.elemento_id=ela.nivel ";
                $cadenaSql .= "JOIN \"dependencia_SIC\" dep ON dep.\"ESF_CODIGO_DEP\"=ela.codigo_dependencia ";
                $cadenaSql .= "JOIN  arka.tipo_bienes tb ON tb.id_tipo_bienes=ela.tipo_bien ";
                $cadenaSql .= "JOIN  arka.aplicacion_iva iv ON iv.id_iva=ela.iva  ";
                $cadenaSql .= "WHERE ela.numero_contrato ='" . $variable[0] . "' and ela.vigencia=" . $variable[1] . "  ";
                $cadenaSql .= "AND  ela.estado=true; ";
                break;

            case "consultarServiciosOrden" :
                $cadenaSql = " SELECT so.* 	";
                $cadenaSql .= " FROM servicio_contrato so  ";
                $cadenaSql .= " WHERE  ";
                $cadenaSql .= " so.numero_contrato='$variable[0]' ";
                $cadenaSql .= " AND so.vigencia=$variable[1]; ";
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

            case "consultar_tipo_iva" :

                $cadenaSql = "SELECT id_iva, descripcion ";
                $cadenaSql .= "FROM arka.aplicacion_iva;";

                break;

            case "dependenciasElemetos" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"dependencia_SIC\" ";
                break;

            case "funcionariosElementos" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION, FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS WHERE FUN_ESTADO != 'I' ";

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

            case "insertarDatosModificados" :
                $cadenaSql = " UPDATE modificacion_contractual";
                $cadenaSql.=" SET datos_modificados='$variable[1]', datos_antiguos='$variable[2]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;


            //---------------------Documento Contrato Formato ---------------------------------


            case "polizasDocumento" :
                $cadenaSql = " SELECT p.descripcion_poliza, p.id_poliza, p.fecha_aprobacion  ";
                $cadenaSql .= "  FROM argo.poliza p , argo.contrato_general cg ";
                $cadenaSql .= " WHERE cg.numero_contrato = p.numero_contrato ";
                $cadenaSql .= " and cg.vigencia = p.vigencia and p.id_poliza = p.id_poliza and p.numero_contrato='$variable[0]' and p.vigencia = $variable[1];  ";
                
                break;
            case "infoContratoGeneralDocumento" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= "  FROM contrato_general cg ";
                $cadenaSql .= " WHERE cg.numero_contrato='$variable[0]' and cg.vigencia = $variable[1];  ";
                break;
             case "consultaArrendamientoAmparo" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= "  FROM argo.amparo_contrato cga ";
                $cadenaSql .= " WHERE cga.numero_contrato='".$variable[0]."' AND cga.vigencia_contrato=".$variable[1]." ORDER BY id;  ";
                
                
                break;
            
            case "actualizarContratoArrendamiento" :
                $cadenaSql = " UPDATE argo.contrato_arrendamiento  ";
                $cadenaSql .= " SET  destinacion='".$variable['destinacion']."', plazo_pago_mensual=".$variable['plazo_mensual'].",  ";
                $cadenaSql .= "  reajuste='".$variable['reajuste']."', plazo_entrega=".$variable['plazo_entrega'].",  valor_arrendamiento=".$variable['valor_arrendamiento']." ";
                if(isset($variable['valor_admin']) && isset($variable['plazo_admin'])){
                    $cadenaSql .= ", plazo_administracion=".$variable['plazo_admin'].", valor_administracion=".$variable['valor_admin']." ";
                }
                else{
                    $cadenaSql .= ", plazo_administracion=null, valor_administracion=null ";
                }
                $cadenaSql .= "WHERE id=".$variable["id_arrendamiento"].";  ";
              
                  
                break;
            
             case "eliminarContratoArrendamientoGeneral" :
                $cadenaSql = " DELETE FROM argo.amparo_contrato WHERE numero_contrato='".$variable['numero_contrato']."' AND vigencia_contrato=".$variable['vigencia']."; ";
     
                break;
         
             case "insertarContratoArrendamientoGeneral" :

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
            
            
 
 
            case "consultaArrendamiento" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= "  FROM argo.contrato_arrendamiento ca ";
                $cadenaSql .= " WHERE ca.numero_contrato='$variable[0]' and ca.vigencia = $variable[1] ";
                
         
             
               
               
                break;
            
            
            case "consultaContratistaDocumento" :
                $cadenaSql = " SELECT * FROM agora.informacion_proveedor WHERE id_proveedor = $variable; ";
                break;

      
            case "ordenadorDocumento" :

                $cadenaSql = " 	SELECT ORG_ORDENADOR_GASTO as ordenador , ORG_NOMBRE as nombre , ORG_IDENTIFICACION as identificacion  ";
                $cadenaSql .= " FROM SICAARKA.ORDENADORES_GASTO  ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR = $variable AND ORG_ESTADO='A' ";

                break;

            case "obtenerInformacionElaborador" :



                $cadenaSql = " 	SELECT nombre , apellido  ";
                $cadenaSql .= " FROM frame_work.argo_usuario  ";
                $cadenaSql .= " WHERE id_usuario = '$variable'; ";

                break;

            case "ordenadorArgoDocumento" :

                $cadenaSql = " 	SELECT o.documento,o.info_resolucion, o.nombre_ordenador, o.rol_ordenador,c.nombre  ";
                $cadenaSql .= " FROM argo.ordenadores o , core.ciudad c  ";
                $cadenaSql .= " WHERE c.id_ciudad = o.id_ciudad AND id_ordenador = ".$variable['ordenador_gasto']." AND fecha_inicio<= '".$variable['fecha_suscripcion']."' AND fecha_fin>= '".$variable['fecha_suscripcion']."'; ";
              
                break;



            case "consultaTipoContrato" :
                $cadenaSql = " SELECT tipo_contrato  FROM tipo_contrato  ";
                $cadenaSql .= " WHERE id = $variable;  ";
                break;

            case "consultaTipoDocumento" :
                $cadenaSql = " SELECT pe.valor_parametro, c.nombre FROM agora.informacion_persona_natural ipn, agora.parametro_estandar pe, core.ciudad c  ";
                $cadenaSql .= " WHERE c.id_ciudad = ipn.id_ciudad_expedicion_documento and ipn.tipo_documento = pe.id_parametro AND ipn.num_documento_persona = $variable; ";
                break;

            case "ObtenerInfosupervisor" :
                $cadenaSql = " SELECT nombre, documento, cargo FROM supervisor_contrato   ";
                $cadenaSql .= " WHERE id= $variable; ";
                break;
            
            case "ObtenerInfosupervisorDetalle" :
                $cadenaSql = " SELECT nom_proveedor nombre FROM agora.informacion_proveedor   ";
                $cadenaSql .= " WHERE num_documento = $variable; ";
                break;  
            
            case "consultaPerfil" :
                $cadenaSql = " SELECT pe.valor_parametro ,ipn.profesion , ipn.especialidad FROM agora.informacion_persona_natural ipn, agora.parametro_estandar pe  ";
                $cadenaSql .= " WHERE ipn.perfil = pe.id_parametro AND ipn.num_documento_persona = $variable; ";
                break;

            case "ObtenerObjetoSolicitud" :
                $cadenaSql = " SELECT OBJETO FROM  CO.CO_SOLICITUD_ADQ WHERE NUM_SOL_ADQ=$variable[1] AND VIGENCIA = $variable[2] AND CODIGO_UNIDAD_EJECUTORA='0$variable[3]'  ";

                break;

            case "consultarContratoProcesarAjax" :
                $cadenaSql = " SELECT  tp.tipo_contrato,  cg.unidad_ejecutora  FROM contrato_general cg, tipo_contrato tp ";
                $cadenaSql .= " WHERE tp.id = cg.tipo_contrato and numero_contrato='$variable[1]' and vigencia = $variable[2] ";
                break;

            case "consultarFormadePago" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;
            case "consultaParametro" :
                $cadenaSql = " SELECT descripcion  FROM parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
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
        }
        return $cadenaSql;
    }

}

?>

