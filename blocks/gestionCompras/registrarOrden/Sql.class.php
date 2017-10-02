<?php

namespace gestionCompras\registrarOrden;

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

            case "obtenerAmparosParametros" :
                $cadenaSql = " SELECT id, nombre FROM core.amparos; ";

                break;    

            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza WHERE estado = true ORDER BY id_poliza; ";
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

            case "tipo_orden" :

                $cadenaSql = " SELECT id as id, tipo_contrato as valor";
                $cadenaSql.=" FROM argo.tipo_contrato WHERE estado = 't' and id_grupo_tipo_contrato = 1 ;";

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





            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;





            case "ordenadores_orden" :

                $cadenaSql = " SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO FROM SICAARKA.ORDENADORES_GASTO ";
                $cadenaSql.=" WHERE ORG_ESTADO='A' ";

                break;
            case "ordenadores_orden_idexud" :

                $cadenaSql = " SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO FROM SICAARKA.ORDENADORES_GASTO ";
                $cadenaSql.=" WHERE ORG_ESTADO='A' AND ORG_ORDENADOR_GASTO  LIKE '%IDEXUD%'";

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
                $cadenaSql.=" NUM_SOL_ADQ=$variable[0] and VIGENCIA=$variable[1] and CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' ";

                break;

            case "cargoSuper" :

                $cadenaSql = " SELECT  FUN_CARGO || '('||FUN_DEP_NOM_ACADEMICA||')' ";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable ";

                break;

            case "cargos_existentes" :
                $cadenaSql = " SELECT DISTINCT FUN_CARGO";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ORDER BY FUN_CARGO ASC";
                break;


            case "solicitudesRegistradas" :

                $cadenaSql = " select string_agg(cast(numero_solicitud_necesidad as text),',' ";
                $cadenaSql.=" order by numero_solicitud_necesidad) from contrato_general;";

                break;

            case "solicitudesRegistradasNovedades" :

                $cadenaSql = " select string_agg(cast(numero_solicitud as text),',' ";
                $cadenaSql.=" order by numero_solicitud) from adicion where vigencia_adicion = $variable;";

                break;

            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  ORG_NOMBRE,  ORG_IDENTIFICACION ";
                $cadenaSql .= " FROM SICAARKA.ORDENADORES_GASTO  ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR = $variable and ORG_ESTADO = 'A'";

                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28;";

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

            case "nombre_participante" :

                $cadenaSql = " SELECT nom_proveedor, tipopersona,puntaje_evaluacion ";
                $cadenaSql.=" FROM agora.informacion_proveedor WHERE num_documento=$variable; ";

                break;

            case "obtener_participantes" :

                $cadenaSql = " SELECT id, id_sociedad, documento_contratista, porcentaje_participacion ";
                $cadenaSql.=" FROM sociedad_contratista WHERE id_sociedad = $variable;";

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

            case "insertarContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_general( ";
                $cadenaSql.=" vigencia, objeto_contrato, plazo_ejecucion,forma_pago, ";
                $cadenaSql.=" ordenador_gasto, clausula_registro_presupuestal, ";
                $cadenaSql.=" sede_solicitante, dependencia_solicitante,  ";
                $cadenaSql.="  contratista, unidad_ejecucion, valor_contrato, justificacion, ";
                $cadenaSql.=" descripcion_forma_pago, condiciones, unidad_ejecutora,";
                $cadenaSql.=" tipologia_contrato, tipo_compromiso, modalidad_seleccion, procedimiento,";
                $cadenaSql.=" regimen_contratacion, tipo_gasto, tema_gasto_inversion, origen_presupueso,";
                $cadenaSql.=" origen_recursos, tipo_moneda, valor_contrato_me, valor_tasa_cambio, ";
                $cadenaSql.=" tipo_control, observaciones,especificaciones_tecnicas,actividades,"
                        . " supervisor, clase_contratista,tipo_contrato,lugar_ejecucion,usuario,convenio)";
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
                $cadenaSql .= "'" . $variable ['convenio'] . "');";
                break;

            case "insertarAmparosContratoGeneral" :

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
            case "insertarContratoDisponibilidad" :
                $cadenaSql = " INSERT INTO contrato_disponibilidad(";
                $cadenaSql.=" numero_cdp, numero_contrato, vigencia,vigencia_cdp)";
                $cadenaSql.=" VALUES (" . $variable['numero_disponibilidad'] . ", " . $variable['numero_contrato'] . ", " . $variable['vigencia'] . ", " . $variable['vigencia_disponibilidad'] . ");";
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


            case "ObtenerSupervisor" :
                $cadenaSql = "SELECT * ";
                $cadenaSql .= "FROM supervisor_contrato  ";
                $cadenaSql .= "WHERE documento=" . $variable . "; ";
                break;




            //--------------Sociedades Temporales -------------------------------

            case "informacion_sociedad_temporal_consulta" :
                $cadenaSql = " SELECT identificacion, tipo, nombre, digito_verificacion , documento_representante, documento_suplente, ";
                $cadenaSql.=" fecha_registro, estado";
                $cadenaSql.=" FROM sociedad_temporal";
                $cadenaSql.=" WHERE identificacion=$variable ;";
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

            case "buscar_representante_suplente" :

                $cadenaSql = " SELECT p.num_documento_persona AS  data,  p.num_documento_persona||'-('||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p  ";
                $cadenaSql .= " WHERE cast(p.num_documento_persona as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " LIMIT 20;";

                break;



            //---------------------------------------------------------------


            case "interventores" :
                $cadenaSql = " SELECT ip.num_documento ||'-'||ip.nom_proveedor AS data , ip.num_documento ||'-'||ip.nom_proveedor as value from ";
                $cadenaSql.=" agora.informacion_proveedor ip, agora.informacion_persona_natural ipn ";
                $cadenaSql.=" where ip.num_documento = ipn.num_documento_persona;";
                $cadenaSql.=" ";
                break;

            case "insertarOrden" :
                $cadenaSql = " INSERT INTO orden(";
                $cadenaSql .= " tipo_orden,numero_contrato, vigencia,poliza,fecha_registro) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['tipo_orden'] . ",";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['poliza'] . "',";
                $cadenaSql .= "'" . $variable ['fecha'] . "');";

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


            case "obtenerInfoOrden" :
                $cadenaSql = " SELECT MAX(CAST(numero_contrato AS integer)) as numero_contrato";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE numero_contrato not like '%DVE%'; ";

                break;


            case "validarContratista" :
                $cadenaSql = "SELECT * From contratista WHERE identificacion=" . $variable;
                ;

                break;




            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contrato'; ";

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


            case "tipologia_contrato" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipologia_contrato'; ";
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



//-----------------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------
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
            case "ubicacionesConsultadas" :
                $cadenaSql = "SELECT DISTINCT  ef.\"ESF_ID_ESPACIO\" , ef.\"ESF_NOMBRE_ESPACIO\" ";
                $cadenaSql .= " FROM arka_parametros.arka_espaciosfisicos ef  ";
                $cadenaSql .= " JOIN arka_parametros.arka_dependencia ad ON ad.\"ESF_ID_ESPACIO\"=ef.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " WHERE ad.\"ESF_CODIGO_DEP\"='" . $variable . "' ";
                $cadenaSql .= " AND  ef.\"ESF_ESTADO\"='A'";

                break;




            case "proveedores" :
                $cadenaSql = " SELECT \"PRO_NIT\",\"PRO_NIT\"||' - '||\"PRO_RAZON_SOCIAL\" AS proveedor ";
                $cadenaSql .= " FROM arka_parametros.arka_proveedor ";

                break;



            case "dependencias" :
                $cadenaSql = "SELECT DISTINCT  ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE ESF_ID_SEDE='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;

            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM arka_parametros.arka_sedes ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ;";
                break;

            case "buscar_contratista" :
                $cadenaSql = "SELECT CON_IDENTIFICADOR AS IDENTIFICADOR , CON_IDENTIFICACION ||'  -  '||CON_NOMBRE AS CONTRATISTA ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "WHERE CON_VIGENCIA ='" . $variable . "' ";
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

            case "insertarProveedor" :
                $cadenaSql = " INSERT INTO proveedor_adquisiones(";
                $cadenaSql .= " id_proveedor_adq ,razon_social, identificacion,direccion, telefono,fecha_registro) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable [4] . ",";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . date('Y-m-d') . "') ";
                $cadenaSql .= "RETURNING  id_proveedor_adq; ";


                break;



            case "insertarEncargado" :
                $cadenaSql = " INSERT INTO inventarios.encargado(";
                $cadenaSql .= " id_tipo_encargado,";
                $cadenaSql .= " nombre, ";
                $cadenaSql .= " identificacion,";
                $cadenaSql .= " cargo, ";
                $cadenaSql .= " asignacion)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "') ";
                $cadenaSql .= "RETURNING  id_encargado; ";
                break;

            // INSERT
            // orden(
            // id_orden, tipo_orden, vigencia, consecutivo_servicio, consecutivo_compras,
            // fecha_registro, info_presupuestal, dependencia_solicitante, sede,
            // rubro, objeto_contrato, poliza1, poliza2, poliza3, poliza4, duracion_pago,
            // fecha_inicio_pago, fecha_final_pago, forma_pago, id_ordenador_encargado,
            // estado)
            // ;

            case "insertarOrden" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " orden(";
                $cadenaSql .= "tipo_orden, vigencia, consecutivo_servicio, consecutivo_compras, 
								            fecha_registro, dependencia_solicitante, sede_solicitante, 
								            objeto_contrato, poliza1, poliza2, poliza3, poliza4, duracion_pago, 
								            fecha_inicio_pago, fecha_final_pago, forma_pago,id_contratista,id_supervisor, id_ordenador_encargado, tipo_ordenador,id_proveedor,clausula_presupuesto,unidad_ejecutora)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['tipo_orden'] . "',";
                $cadenaSql .= "'" . $variable ['vigencia'] . "',";
                $cadenaSql .= "" . $variable ['consecutivo_servicio'] . ",";
                $cadenaSql .= "" . $variable ['consecutivo_compras'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['sede_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['objeto_contrato'] . "',";



                if ($variable ['poliza1'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza1'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }


                if ($variable ['poliza2'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza2'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }
                if ($variable ['poliza3'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza3'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }

                if ($variable ['poliza4'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza4'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }

                $cadenaSql .= "'" . $variable ['duracion_pago'] . "',";
                $cadenaSql .= $variable ['fecha_inicio_pago'] . ",";
                $cadenaSql .= $variable ['fecha_final_pago'] . ",";
                $cadenaSql .= "'" . $variable ['forma_pago'] . "',";
                $cadenaSql .= "'" . $variable ['id_contratista'] . "',";
                $cadenaSql .= "'" . $variable ['id_supervisor'] . "',";
                $cadenaSql .= "'" . $variable ['id_ordenador_encargado'] . "',";
                $cadenaSql .= "'" . $variable ['tipo_ordenador'] . "',";
                $cadenaSql .= "'" . $variable ['id_proveedor'] . "',";
                $cadenaSql .= "'" . $variable ['clausula_presupuesto'] . "',";
                $cadenaSql .= "'" . $variable ['unidad_ejecutora'] . "') ";
                $cadenaSql .= "RETURNING  consecutivo_compras,consecutivo_servicio,id_orden  ; ";

                break;

            case "insertarInformacionPresupuestal" :
                $cadenaSql = " INSERT INTO informacion_presupuestal_orden( ";
                $cadenaSql .= " vigencia_dispo, numero_dispo, valor_disp, fecha_dip,
								letras_dispo, vigencia_regis, numero_regis, valor_regis, fecha_regis,
								letras_regis, fecha_registro,unidad_ejecutora)";
                $cadenaSql .= " VALUES (";
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
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [11] . "') ";
                $cadenaSql .= "RETURNING  id_informacion; ";

                break;

            case "consultarDependencia" :
                $cadenaSql = " SELECT   ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= "FROM ESPACIOS_FISICOS  ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;

            case "consultarRubro" :
                $cadenaSql = " SELECT RUB_NOMBRE_RUBRO ";
                $cadenaSql .= " FROM RUBROS ";
                $cadenaSql .= " WHERE  RUB_IDENTIFICADOR='" . $variable . "'";

                break;

            case "consultarDependenciaSupervisor" :
                $cadenaSql = " SELECT   ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= "FROM ESPACIOS_FISICOS  ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";
                break;

            case "consultarSupervisor" :
                $cadenaSql = " SELECT nombre, cargo, dependencia ";
                $cadenaSql .= " FROM supervisor_servicios ";
                $cadenaSql .= " WHERE id_supervisor='" . $variable . "'";
                break;

            case "consultarOrdenador_gasto" :
                $cadenaSql = " 	SELECT ORG_ORDENADOR_GASTO,ORG_NOMBRE ";
                $cadenaSql .= " FROM ORDENADORES_GASTO ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR ='" . $variable . "' ";
                $cadenaSql .= " AND ORG_ESTADO='A' ";
                break;

            case "consultarContratista" :
                $cadenaSql = "SELECT CON_IDENTIFICACION , CON_NOMBRE AS CONTRATISTA ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "WHERE CON_VIGENCIA ='" . $variable [1] . "' ";
                $cadenaSql .= "AND  CON_IDENTIFICADOR ='" . $variable [0] . "' ";
                break;


            case "consultarCosntraistaServicios" :
                $cadenaSql = " SELECT nombre_razon_social, identificacion, direccion,telefono, cargo ";
                $cadenaSql .= " FROM contratista_servicios ";
                $cadenaSql .= " WHERE id_contratista='" . $variable . "'";
                break;

            case "informacionPresupuestal" :
                $cadenaSql = "SELECT  vigencia_dispo, numero_dispo, valor_disp, fecha_dip,
									letras_dispo, vigencia_regis, numero_regis, valor_regis, fecha_regis,
									letras_regis  ";
                $cadenaSql .= "FROM informacion_presupuestal_orden ";
                $cadenaSql .= "WHERE id_informacion ='" . $variable . "' ";

                break;

            case "consultarOrdenServicios" :
                $cadenaSql = "SELECT  fecha_registro, info_presupuestal, dependencia_solicitante,
				rubro, objeto_contrato, poliza1, poliza2, poliza3, poliza4, duracion_pago,
				fecha_inicio_pago, fecha_final_pago, forma_pago, total_preliminar,
				iva, total, id_contratista,id_supervisor,
				id_ordenador_encargado, estado ";
                $cadenaSql .= "FROM orden_servicio  ";
                $cadenaSql .= "WHERE  id_orden_servicio='" . $variable . "';";

                break;

            case "validacionpoliza" :

                $cadenaSql = "SELECT descripcion  id, descripcion valor   ";
                $cadenaSql .= " FROM parametros  WHERE rel_parametro = 37; ";

                break;




            case "consecutivo_compra" :

                $cadenaSql = " 	SELECT max(consecutivo_compras)  ";
                $cadenaSql .= " FROM orden ";
                $cadenaSql .= " WHERE vigencia ='" . $variable ['vigencia'] . "' ";
                $cadenaSql .= " AND unidad_ejecutora ='" . $variable ['unidad_ejecutora'] . "';";

                break;

            case "consecutivo_servicios" :

                $cadenaSql = " 	SELECT max(consecutivo_servicio)  ";
                $cadenaSql .= " FROM orden ";
                $cadenaSql .= " WHERE vigencia ='" . $variable['vigencia'] . "' ";
                $cadenaSql .= " AND unidad_ejecutora ='" . $variable['unidad_ejecutora'] . "';";
                break;

            case "obtenerIdSupervisor" :

                $cadenaSql = " 	SELECT max(id_supervisor)  ";
                $cadenaSql .= " FROM supervisor_servicios; ";


                break;
            case "obtenerIdProveedor" :

                $cadenaSql = " 	SELECT max(id_proveedor_adq)  ";
                $cadenaSql .= " FROM proveedor_adquisiones; ";


                break;
            case "obtenerIdContratista" :

                $cadenaSql = " 	SELECT max(id_contratista_adq)  ";
                $cadenaSql .= " FROM contratistas_adquisiones; ";


                break;

            case "obtenerUnidadUsuario" :

                $cadenaSql = " select unidad_ejecutora from frame_work.argo_usuario   ";
                $cadenaSql .= " where id_usuario = '$variable'; ";


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


            case "buscar_participante" :

                $cadenaSql = " SELECT p.num_documento AS  data,  p.num_documento||'-('||p.nom_proveedor||')' AS value  ";
                $cadenaSql .= " FROM  agora.informacion_proveedor p  ";
                $cadenaSql .= " WHERE (tipopersona = 'NATURAL' or  tipopersona = 'JURIDICA') AND  cast(p.num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR p.nom_proveedor  LIKE '%" . $variable . "%'  ";
                $cadenaSql .= " LIMIT 20;";

                break;
            case "buscar_Info_participante" :

                $cadenaSql = " SELECT p.num_documento, p.nom_proveedor, tipopersona, puntaje_evaluacion   ";
                $cadenaSql .= " FROM agora.informacion_proveedor p ";
                $cadenaSql .= " WHERE num_documento = $variable ;";


                break;
            case "obtener_solicitudes_vigencia" :
                $cadenaSql = " SELECT SCDP.ID_SOL_CDP as valor, SCDP.NUM_SOL_ADQ as informacion from ";
                $cadenaSql.=" CO.CO_SOL_CDP SCDP, CO.CO_SOLICITUD_ADQ SN where SCDP.NUM_SOL_ADQ = SN.NUM_SOL_ADQ ";
                $cadenaSql.=" and SCDP.VIGENCIA = SN.VIGENCIA and SCDP.VIGENCIA=$variable[1] and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[0]'";
                $cadenaSql.=" and SCDP.NUM_SOL_ADQ NOT IN ($variable[2]) and SCDP.NUM_SOL_ADQ NOT IN ($variable[3]) ";
                $cadenaSql.=" ORDER BY SN.NUM_SOL_ADQ ASC";

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


            case "obtenerSolicitudesCdp" :
                $cadenaSql = " SELECT SN.NUM_SOL_ADQ, SCDP.ID_SOL_CDP, CDP.NUMERO_DISPONIBILIDAD,SN.VIGENCIA ,DP.NOMBRE_DEPENDENCIA, ";
                $cadenaSql.=" SN.ESTADO, CDP.OBJETO,SN.VALOR_CONTRATACION,CDP.ESTADO as ESTADOCDP , CDP.FECHA_REGISTRO ";
                $cadenaSql.=" FROM CO.CO_SOLICITUD_ADQ SN, CO.CO_SOL_CDP SCDP, PR.PR_DISPONIBILIDADES CDP , CO.CO_DEPENDENCIAS DP ";
                $cadenaSql.=" WHERE SN.NUM_SOL_ADQ = SCDP.NUM_SOL_ADQ and SN.VIGENCIA = SCDP.VIGENCIA and SN.DEPENDENCIA = DP.COD_DEPENDENCIA ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and CDP.NUM_SOL_ADQ = SCDP.ID_SOL_CDP and CDP.CODIGO_COMPANIA = SCDP.CODIGO_COMPANIA  ";
                $cadenaSql.=" and CDP.VIGENCIA = SCDP.VIGENCIA and SN.VIGENCIA=" . $variable['vigencia_solicitud_consulta'] . " and ";
                $cadenaSql.="  SN.CODIGO_UNIDAD_EJECUTORA='0" . $variable['unidad_ejecutora'] . "' and SCDP.ID_SOL_CDP=" . $variable['numero_solicitud'] . " ";
                $cadenaSql.="  ORDER BY SN.NUM_SOL_ADQ ";

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
        }
        return $cadenaSql;
    }

}

?>
