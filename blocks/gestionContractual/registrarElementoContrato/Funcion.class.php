<?php

namespace gestionContractual\registrarElementoContrato;

use gestionContractual\registrarElementoContrato\funcion\redireccion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/InspectorHTML.class.php");
include_once ("core/builder/Mensaje.class.php");
include_once ("core/crypto/Encriptador.class.php");

// Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
// metodos mas utilizados en la aplicacion

// Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
// en camel case precedido por la palabra Funcion
class Funcion {
	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $miInspectorHTML;
	var $error;
	var $miRecursoDB;
	var 

	$crypto;
	function funcionEjemplo() {
		include_once ($this->ruta . "/funcion/funcionEjemplo.php");
	}
	function procesarAjax() {
		include_once ($this->ruta . "funcion/procesarAjax.php");
	}
	function regitrar() {
		include_once ($this->ruta . "funcion/registrar.php");
	}
	function action() {
		
		//
		// Evitar qu44444444rrrre se ingrese codigo HTML y PHP en los campos de texto
		// Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir = "";
		$_REQUEST = $this->miInspectorHTML->limpiarPHPHTML ( $_REQUEST );
		
		// Aquí se coloca el código que procesará los diferentes formularios que pertenecen al bloque
		// aunque el código fuente puede ir directamente en este script, para facilitar el mantenimiento
		// se recomienda que aqui solo sea el punto de entrada para incluir otros scripts que estarán
		// en la carpeta funcion
		
		// Importante: Es adecuado que sea una variable llamada opcion o action la que guie el procesamiento:
		if (isset ( $_REQUEST ['procesarAjax'] )) {
			$this->procesarAjax ();
		} elseif (isset ( $_REQUEST ["botonActa"] ) && $_REQUEST ["botonActa"] = 'true') {
			
			\inventarios\gestionActa\registrarElementoOrden\funcion\redireccion::redireccionar ( 'RegistrarActa', $_REQUEST );
			
			exit ();
		} elseif (isset ( $_REQUEST ["opcion"] )) {
			
			switch ($_REQUEST ['opcion']) {
				
				case "registrar" :
					$this->regitrar ();
					break;
				
				case "redireccionar" :
					
					if (isset ( $_REQUEST ["botonContinuar"] ) && $_REQUEST ['botonContinuar'] == 'true') {
						
						redireccion::redireccionar ( 'Salir' );
						exit ();
					}
					
					if (isset ( $_REQUEST ["botonSalida"] ) && $_REQUEST ['botonSalida'] == 'true') {
						
						redireccion::redireccionar ( 'SalidaElemento', $_REQUEST ['numero_entrada'], $_REQUEST ['datosGenerales'] );
						exit ();
					}
					
					break;
			}
		}
	}
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miInspectorHTML = \InspectorHTML::singleton ();
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->miMensaje = \Mensaje::singleton ();
		
		$conexion = "aplicativo";
		$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		if (! $this->miRecursoDB) {
			
			$this->miConfigurador->fabricaConexiones->setRecursoDB ( $conexion, "tabla" );
			$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		}
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->formulario = $formulario;
	}
}
?>
