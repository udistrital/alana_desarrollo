<?php


class Logout {
	
	var $miAutenticador;
		
	function __construct() {
               $this->miAutenticador = \Autenticador::singleton ();
	}
	function procesarFormulario() {
             
	     return $this->miAutenticador->terminarAutenticacionSSO();
	}
}

$miProcesador = new Logout ();
$miProcesador->procesarFormulario();
?>
