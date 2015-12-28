<?php

namespace blocks\gui\bannerApp\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
	}
	function formulario() {
		$this->estructura ();
	}
	function estructura() {
		// ------------------- Inicio División -------------------------------
		$esteCampo = 'banner';
		$atributos ['id'] = $esteCampo;
		$atributos ['estilo'] = 'banner';
		$atributos ['estiloEnLinea'] = '';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		echo $this->miFormulario->division ( "inicio", $atributos );
		{
			
			// ------------------- Inicio División -------------------------------
			$esteCampo = 'texto';
			$atributos ['id'] = $esteCampo;
			$atributos ['estilo'] = 'texto';
			$atributos ['estiloEnLinea'] = '';
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			echo $this->miFormulario->division ( "inicio", $atributos );
			{
				
				// ------------------- Inicio División -------------------------------
			}
			
			// ---------------------Fin Division -----------------------------------
			echo $this->miFormulario->division ( "fin" );
		}
		
		// ---------------------Fin Division -----------------------------------
		echo $this->miFormulario->division ( "fin" );
	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario );

$miFormulario->formulario ();
?>