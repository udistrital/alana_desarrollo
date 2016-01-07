<?php

namespace contratos\registrarContrato\funcion;

use contratos\registrarContrato\funcion\redireccion;

// include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistradorContrato {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql, $funcion) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function procesarFormulario() {
		var_dump ( $_REQUEST );
		$conexion = "contractual";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		
		
		$arreglo_contratista = array (
				
				"tipo_identificacion" => $_REQUEST ['tipo_identificacion'],
				"numero_identificacion" => $_REQUEST ['numero_identificacion'],
				"digito_verificacion" => $_REQUEST ['digito_verificacion'],
				"tipo_persona" => $_REQUEST ['tipo_persona'],
				"primer_nombre" => $_REQUEST ['primer_nombre'],
				"segundo_nombre" => $_REQUEST ['segundo_nombre'],
				"primer_apellido" => $_REQUEST ['primer_apellido'],
				"segundo_apellido" => $_REQUEST ['segundo_apellido'],
				"genero" => $_REQUEST ['genero'],
				"nacionalidad" => $_REQUEST ['nacionalidad'],
				"direccion" => $_REQUEST ['direccion'],
				"telefono" => $_REQUEST ['telefono'],
				"correo" => $_REQUEST ['correo'],
				"perfil" => $_REQUEST ['perfil'],
				"profesion" => $_REQUEST ['profesion'],
				"especialidad" => $_REQUEST ['especialidad'],
				"id_contratista" => $_REQUEST ['id_contratista']
		);
		
		$arreglo_info_bancaria = array (
				
				"tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
				"numero_cuenta" => $_REQUEST ['numero_cuenta'],
				"entidad_bancaria" => $_REQUEST ['entidad_bancaria'] 
		);
		
		$arreglo_contrato = array (
				
				"vigencia" => date('Y'),
				"numero_contrato" => $_REQUEST ['numero_contrato'],
				"tipo_configuracion" => $_REQUEST ['tipo_configuracion'],
				"clase_contratista" => $_REQUEST ['clase_contratista'],
				"identificacion_clase_contratista" => $_REQUEST ['identificacion_clase_contratista'],
				"digito_verificacion_clase_contratista" => $_REQUEST ['digito_verificacion_clase_contratista'],
				"porcentaje_clase_contratista" => $_REQUEST ['porcentaje_clase_contratista'],
				"clase_contrato" => $_REQUEST ['clase_contrato'],
				"tipo_compromiso" => $_REQUEST ['tipo_compromiso'],
				"numero_convenio" => $_REQUEST ['numero_convenio'],
				"vigencia_convenio" => $_REQUEST ['vigencia_convenio'],
				"objeto_contrato" => $_REQUEST ['objeto_contrato'],
				"fecha_subcripcion" => $_REQUEST ['fecha_subcripcion'],
				"plazo_ejecucion" => $_REQUEST ['plazo_ejecucion'],
				"unidad_ejecucion_tiempo" => $_REQUEST ['unidad_ejecucion_tiempo'],
				"fecha_inicio_poliza" => $_REQUEST ['fecha_inicio_poliza'],
				"fecha_final_poliza" => $_REQUEST ['fecha_final_poliza'],
				"dependencia" => $_REQUEST ['dependencia'],
				"tipologia_especifica" => $_REQUEST ['tipologia_especifica'],
				"numero_constancia" => $_REQUEST ['numero_constancia'],
				"modalidad_seleccion" => $_REQUEST ['modalidad_seleccion'],
				"procedimiento" => $_REQUEST ['procedimiento'],
				"regimen_contratación" => $_REQUEST ['regimen_contratación'],
				"tipo_moneda" => $_REQUEST ['tipo_moneda'],
				"valor_contrato" => $_REQUEST ['valor_contrato'],
				"ordenador_gasto" => $_REQUEST ['ordenador_gasto'],
				"tipo_gasto" => $_REQUEST ['tipo_gasto'],
				"origen_recursos" => $_REQUEST ['origen_recursos'],
				"origen_presupuesto" => $_REQUEST ['origen_presupuesto'],
				"tema_gasto_inversion" => $_REQUEST ['tema_gasto_inversion'],
				"valor_contrato_moneda_ex" => $_REQUEST ['valor_contrato_moneda_ex'],
				"tasa_cambio" => $_REQUEST ['tasa_cambio'],
				"observacionesContrato" => $_REQUEST ['observacionesContrato'],
				"tipo_control" => $_REQUEST ['tipo_control'],
				"supervisor" => $_REQUEST ['supervisor'],
				"identificacion_supervisor" => $_REQUEST ['identificacion_supervisor'],
				"digito_supervisor" => $_REQUEST ['digito_supervisor'],
				"fecha_suscrip_super" => $_REQUEST ['fecha_suscrip_super'],
				"fecha_limite" => $_REQUEST ['fecha_limite'],
				"observaciones_interventoria" => $_REQUEST ['observaciones_interventoria'],
				
		);
		
		if (isset ( $_REQUEST ['id_contratista'] ) == true && $_REQUEST ['id_contratista'] != '') {
			
			$cadenaSql = $this->miSql->getCadenaSql ( 'actualizar_contratista', $arreglo_contratista );
			$contratista = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso", $arreglo_contratista, 'actualizar_contratista' );
			
			
			
			
		} else {
			
// 			$cadenaSql = $this->miSql->getCadenaSql ( 'registrar_contratista', $arreglo_contratista );
// 			$contratista = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso", $arreglo_contratista, 'actualizar_contratista' );
				
			
		}
		
		$fechaActual = date ( 'Y-m-d' );
	}
}

$miRegistrador = new RegistradorContrato ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>