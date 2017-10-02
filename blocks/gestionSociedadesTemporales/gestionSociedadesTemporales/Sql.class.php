<?php

namespace gestionSociedadesTemporales;

use gestionSociedadesTemporales\funcion\redireccion;

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
            //-------Formulario de Consulta 
            case 'buscar_sociedad_identificacion' :

                $cadenaSql = " SELECT ip.num_documento||'-('||ip.nom_proveedor||')'  AS  value,  ip.num_documento AS data  ";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal ist,";
                $cadenaSql.=" agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor = ist.id_proveedor_sociedad AND";
                $cadenaSql .= " (cast(ip.num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR ip.nom_proveedor  LIKE '%" . $variable . "%')  ";
                $cadenaSql .= " LIMIT 20;";
                break;

            case "tipo_sociedad" :

                $cadenaSql = " SELECT DISTINCT tipopersona AS data, tipopersona as value ";
                $cadenaSql .= " FROM agora.informacion_proveedor ";
                $cadenaSql .= " WHERE tipopersona <> 'NATURAL' AND tipopersona <> 'JURIDICA';";

                break;


            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;


            //---------------Consulta Sociedades Existentes ------------

            case "consultarSociedadesTemporal" :
                $cadenaSql = " SELECT ip.tipopersona,ip.num_documento,ip.nom_proveedor,";
                $cadenaSql.=" ist.digito_verificacion,ist.estado, ip.fecha_registro,ist.id_sociedad";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal ist,";
                $cadenaSql.=" agora.informacion_proveedor ip";
                $cadenaSql.=" WHERE ip.id_proveedor = ist.id_proveedor_sociedad ";

                if (isset($variable['identificacionsociedad']) && $variable['identificacionsociedad'] != '') {
                    $cadenaSql.=" AND ip.num_documento = " . $variable['identificacionsociedad'] . " ";
                }
                if (isset($variable['tiposociedad']) && $variable['tiposociedad'] != '') {
                    $cadenaSql.=" AND ip.tipopersona = '" . $variable['tiposociedad'] . "' ";
                }
                if (isset($variable['fechainicio']) && $variable['fechainicio'] != '') {
                    $cadenaSql .= " AND ip.fecha_registro BETWEEN '" . $variable ['fechainicio'] . "' ";
                    $cadenaSql .= " AND  '" . $variable ['fechafinal'] . "' ";
                }


                $cadenaSql.=" ; ";



                break;


            //-------------Registro Sociedad ---------------------------

            case "consultarBanco" :
                $cadenaSql = "SELECT";
                $cadenaSql .= " id_codigo,";
                $cadenaSql .= "	nombre_banco";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " core.banco";
                $cadenaSql .= " WHERE estado_activo != 'f' ";
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

            case "buscar_representante" :

                $cadenaSql = " SELECT p.num_documento_persona AS  data, '('||ip.id_proveedor||')-'||p.num_documento_persona||'-'||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p, agora.informacion_proveedor ip  ";
                $cadenaSql .= " WHERE p.num_documento_persona = ip.num_documento  ";
                $cadenaSql .= " AND (cast(p.num_documento_persona as text) LIKE '%" . $variable . "%' OR p.num_documento_persona||'-'||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre  LIKE '%" . $variable . "%') ";
                $cadenaSql .= " LIMIT 20;";

                break;

            case "buscar_participante" :

                $cadenaSql = " SELECT p.num_documento||'-'||p.id_proveedor AS  data, '('||p.id_proveedor ||')-'|| p.num_documento||'-'||p.nom_proveedor AS value  ";
                $cadenaSql .= " FROM  agora.informacion_proveedor p  ";
                $cadenaSql .= " WHERE (tipopersona = 'NATURAL' or  tipopersona = 'JURIDICA') AND  cast(p.num_documento as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= " OR p.nom_proveedor  LIKE '%" . $variable . "%'  ";
                $cadenaSql .= " LIMIT 20;";

                break;

            case "tipo_clase_contratista" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contratista' and id_parametro <> 33; ";
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

                $cadenaSql = " INSERT INTO agora.informacion_sociedad_temporal( id_proveedor_sociedad, ";
                $cadenaSql.=" representante, representante_suplente, ";
                $cadenaSql.=" digito_verificacion)";
                $cadenaSql.=" VALUES ( " . $variable['identificacion'] . ", " . $variable['documento_representante'] . ", " . $variable['documento_suplente'] . ", ";
                $cadenaSql.= $variable['digito_verificacion'] . ");";

                break;
            case "registrar_participante_sociedad" :

                $cadenaSql = "INSERT INTO agora.informacion_sociedad_participante(";
                $cadenaSql.=" id_proveedor_sociedad, id_contratista, ";
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


            //Ediccion Sociedad Temporal

            case "informacion_sociedad_proveedor" :

                $cadenaSql = " SELECT ip.num_documento,ip.id_ciudad_contacto,ip.correo,ip.web,";
                $cadenaSql.= " ip.tipo_cuenta_bancaria,ip.num_cuenta_bancaria,";
                $cadenaSql.= " ip.id_entidad_bancaria,ip.nom_proveedor, ip.tipopersona,";
                $cadenaSql.= " ist.representante_suplente, ist.representante,ist.digito_verificacion,ist.id_proveedor_sociedad ";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal ist, agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor = ist.id_proveedor_sociedad and ist.id_sociedad=$variable; ";

                break;

            case "informacion_sociedad_telefono" :
                $cadenaSql = " SELECT t.numero_tel FROM agora.telefono t, ";
                $cadenaSql.=" agora.proveedor_telefono pt, agora.informacion_proveedor ip";
                $cadenaSql.=" WHERE t.id_telefono = pt.id_telefono ";
                $cadenaSql.=" AND pt.id_proveedor = ip.id_proveedor ";
                $cadenaSql.=" AND ip.id_proveedor = $variable;";
                break;

            case "nombre_participante_natural" :

                $cadenaSql = " SELECT p.num_documento_persona AS  data, '('||ip.id_proveedor||')-'||p.num_documento_persona||'-'||p.primer_apellido||' '"
                        . "||p.segundo_apellido||' '||p.primer_nombre||' '||p.segundo_nombre AS value  ";
                $cadenaSql .= " FROM  agora.informacion_persona_natural p, agora.informacion_proveedor ip  ";
                $cadenaSql .= " WHERE p.num_documento_persona = ip.num_documento AND ip.id_proveedor=$variable; ";

                break;

            case "nombre_participante" :

                $cadenaSql = " SELECT '('||id_proveedor||')-'||num_documento||'-'||nom_proveedor AS nombre, tipopersona,puntaje_evaluacion ";
                $cadenaSql.=" FROM agora.informacion_proveedor WHERE id_proveedor=$variable; ";

                break;

            case "obtener_participantes" :

                $cadenaSql = " SELECT id_participante, id_proveedor_sociedad, id_contratista, porcentaje_participacion ";
                $cadenaSql.=" FROM agora.informacion_sociedad_participante WHERE id_proveedor_sociedad = $variable;";

                break;

            case "buscarDepartamentodeCiudad" :

                $cadenaSql = " select d.id_departamento ";
                $cadenaSql.=" from core.departamento d, core.ciudad c ";
                $cadenaSql.=" where c.id_departamento = d.id_departamento ";
                $cadenaSql.=" and c.id_ciudad = $variable;";

                break;

            case 'buscarDepartamento' : // Solo Departamentos de Colombia

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'core.departamento ';
                $cadenaSql .= 'ORDER BY NOMBRE';
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

            case "actualizar_proveedor_sociedad_temporal" :
                $cadenaSql = " UPDATE agora.informacion_proveedor";
                $cadenaSql.=" SET tipopersona='" . $variable['tipopersona'] . "', num_documento=" . $variable['num_documento'] . ", id_ciudad_contacto=" . $variable['id_ciudad_contacto'] . ", ";
                $cadenaSql.=" correo='" . $variable['correo'] . "', web='" . $variable['web'] . "', anexorut='" . $variable['anexorut'] . "', tipo_cuenta_bancaria='" . $variable['tipo_cuenta_bancaria'] . "', ";
                $cadenaSql.=" num_cuenta_bancaria='" . $variable['num_cuenta_bancaria'] . "', id_entidad_bancaria=" . $variable['id_entidad_bancaria'] . ", ";
                $cadenaSql.=" fecha_ultima_modificacion='" . $variable['fecha_ultima_modificacion'] . "', nom_proveedor='" . $variable['nom_proveedor'] . "' ";
                $cadenaSql.=" WHERE id_proveedor=" . $variable['id_sociedad_proveedor'] . ";";
                break;

            case "actualizar_sociedad_temporal" :

                $cadenaSql = " UPDATE  agora.informacion_sociedad_temporal SET ";
                $cadenaSql.=" representante=" . $variable['documento_representante'] . ", ";
                $cadenaSql.=" representante_suplente=" . $variable['documento_suplente'] . ", ";
                $cadenaSql.=" digito_verificacion=" . $variable['digito_verificacion'] . " ";
                $cadenaSql.=" WHERE id_sociedad=" . $variable['id_sociedad'] . "; ";

                break;

            case "actualizar_telefono_sociedad" :

                $cadenaSql = " UPDATE agora.telefono SET numero_tel = " . $variable['telefono'] . " ";
                $cadenaSql.=" WHERE id_telefono = (SELECT pt.id_telefono ";
                $cadenaSql.=" FROM agora.proveedor_telefono pt, agora.informacion_proveedor ip";
                $cadenaSql.=" WHERE pt.id_proveedor = ip.id_proveedor ";
                $cadenaSql.=" AND ip.id_proveedor = " . $variable['id_sociedad_proveedor'] . ") ; ";

                break;

            case "eliminar_participantes_actuales" :

                $cadenaSql = " DELETE FROM agora.informacion_sociedad_participante WHERE id_proveedor_sociedad = $variable;";

                break;


            //inactivar Sociedad

            case "obtenerEstadoSociedad" :
                $cadenaSql = " SELECT ip.nom_proveedor, ip.tipopersona, ip.num_documento, ist.estado ";
                $cadenaSql.=" FROM agora.informacion_sociedad_temporal ist , agora.informacion_proveedor ip ";
                $cadenaSql.=" WHERE ip.id_proveedor =  ist.id_proveedor_sociedad AND id_sociedad =$variable; ";
                break;
           
            case "cambiarEstadoSociedad" :
                $cadenaSql = " UPDATE agora.informacion_sociedad_temporal SET estado = '$variable[0]' ";
                $cadenaSql.=" WHERE id_sociedad =$variable[1]; ";
                break;
        }
        return $cadenaSql;
    }

}

?>
