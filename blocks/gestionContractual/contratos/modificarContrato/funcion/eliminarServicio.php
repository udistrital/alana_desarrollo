<?php
namespace contratos\modificarContrato\funcion;

use contratos\modificarContrato\funcion\redireccion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistradorOrden {
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
		$conexion = "contractual";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'eliminarServicio', $_REQUEST ['id_servicio'] );
		$servicioEliminado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso",$_REQUEST ['id_servicio'] ,"eliminarServicio" );
		
		if ($servicioEliminado) {
			$this->miConfigurador->setVariableConfiguracion ( "cache", true );
			redireccion::redireccionar ( 'eliminoServicio' );
			exit ();
		} else {
			
			redireccion::redireccionar ( 'noeliminoServicio' );
			exit ();
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();
?>