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
		$esteCampo = 'bannerAplicativo';
		$atributos ['id'] = $esteCampo;
		$atributos ['estilo'] = 'bannerAplicativo';
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
				
				
				echo "<h2>ARGO</h2>
						";
				
				
				// ------------------- Inicio División -------------------------------
			}
			
			// ---------------------Fin Division -----------------------------------
			echo $this->miFormulario->division ( "fin" );
			
			
			
			// ------------------- Inicio División -------------------------------
			$esteCampo = 'texto2';
			$atributos ['id'] = $esteCampo;
			$atributos ['estilo'] = 'texto2';
			$atributos ['estiloEnLinea'] = '';
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			echo $this->miFormulario->division ( "inicio", $atributos );
			{
			
			
				echo "<h3>Sistema de Gestión</h3>
					 <h3>Contractual y Compras</h3>";;
			
			
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