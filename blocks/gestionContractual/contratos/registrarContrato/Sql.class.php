<?php

namespace contratos\registrarContrato;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	function getCadenaSql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			
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
				$cadenaSql .= "'" . time () . "' ";
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
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadenaSql .= "( ";
					$cadenaSql .= "'" . $idSesion . "', ";
					$cadenaSql .= "'" . $variable ['formulario'] . "', ";
					$cadenaSql .= "'" . $clave . "', ";
					$cadenaSql .= "'" . $valor . "', ";
					$cadenaSql .= "'" . $variable ['fecha'] . "' ";
					$cadenaSql .= "),";
				}
				
				$cadenaSql = substr ( $cadenaSql, 0, (strlen ( $cadenaSql ) - 1) );
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
				
				$cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
				$cadenaSql .= " FROM relacion_parametro rl ";
				$cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
				$cadenaSql .= "WHERE rl.descripcion ='clase_contratista'; ";
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
				$cadenaSql = "SELECT DISTINCT ";
				$cadenaSql .= " *  ";
				$cadenaSql .= "FROM solicitud_necesidad ";
				$cadenaSql .= "WHERE solicitud_necesidad.estado_registro= TRUE ";
				$cadenaSql .= " AND id_sol_necesidad = '" . $variable . "' ;";
				
				break;
			
			case "Consultar_Disponibilidad" :
				$cadenaSql = "SELECT DISTINCT ";
				$cadenaSql .= " *  ";
				$cadenaSql .= "FROM disponibilidad_presupuestal  ";
				$cadenaSql .= "WHERE estado_registro=TRUE ";
				$cadenaSql .= " AND solicitud_necesidad='" . $variable . "' ;";
				break;
			
			case "Consultar_Registro_Presupuestales" :
				$cadenaSql = "SELECT id_registro_pres, numero_registro, valor_registro,
									disponibilidad_presupuestal, fecha_rgs_pr  ";
				$cadenaSql .= "FROM registro_presupuestal rp  ";
				$cadenaSql .= "JOIN disponibilidad_presupuestal dp ON dp.id_disponibilidad=rp.disponibilidad_presupuestal  ";
				$cadenaSql .= "JOIN solicitud_necesidad sl ON sl.id_sol_necesidad=dp.solicitud_necesidad  ";
				$cadenaSql .= "WHERE rp.estado_registro= TRUE ";
				$cadenaSql .= " AND sl.id_sol_necesidad='" . $variable . "' ;";
				break;
			
			case "Consultar_Contratista" :
				$cadenaSql = " SELECT cns.*, ib.tipo_cuenta,ib.nombre_banco,ib.numero_cuenta,ib.id_inf_bancaria,oc.id_orden_contr  ";
				$cadenaSql .= " FROM contratista cns";
				$cadenaSql .= " LEFT JOIN inf_bancaria ib ON ib.contratista=cns.id_contratista ";
				$cadenaSql .= " JOIN orden_contrato oc ON oc.contratista=cns.id_contratista";
				$cadenaSql .= " JOIN solicitud_necesidad sl ON sl.id_sol_necesidad=oc.solicitud_necesidad";
				$cadenaSql .= " WHERE cns.estado_registro=TRUE ";
				$cadenaSql .= " AND sl.id_sol_necesidad= '" . $variable . "';";
				
				break;
			
			case "actualizar_contratista" :
				$cadenaSql = " UPDATE contratista";
				$cadenaSql .= " SET primer_nombre='" . $variable ['primer_nombre'] . "',";
				$cadenaSql .= " segundo_nombre='" . $variable ['segundo_nombre'] . "', ";
				$cadenaSql .= " primer_apellido='" . $variable ['primer_apellido'] . "',";
				$cadenaSql .= " direccion='" . $variable ['direccion'] . "', ";
				$cadenaSql .= " telefono='" . $variable ['telefono'] . "', ";
				$cadenaSql .= " digito_verificacion='" . $variable ['digito_verificacion'] . "', ";
				$cadenaSql .= " correo='" . $variable ['correo'] . "', ";
				$cadenaSql .= " identificacion='" . $variable ['numero_identificacion'] . "', ";
				$cadenaSql .= " genero='" . $variable ['genero'] . "', ";
				$cadenaSql .= " tipo_naturaleza='" . $variable ['tipo_persona'] . "', ";
				$cadenaSql .= " tipo_documento='" . $variable ['tipo_identificacion'] . "', ";
				$cadenaSql .= " segundo_apellido='" . $variable ['segundo_apellido'] . "',";
				$cadenaSql .= " nacionalidad='" . $variable ['nacionalidad'] . "', ";
				$cadenaSql .= " perfil='" . $variable ['perfil'] . "', ";
				$cadenaSql .= " profesion='" . $variable ['profesion'] . "',";
				$cadenaSql .= " especialidad='" . $variable ['especialidad'] . "'";
				$cadenaSql .= " WHERE id_contratista='" . $variable ['id_contratista'] . "';";
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
