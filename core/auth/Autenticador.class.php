<?php

/**
 * Autenticador.class.php
 *
 * Encargado de gestionar las sesiones de usuario.
 *
 * @author  Paulo Cesar Coronado
 * @version     1.1.0.1
 * @package     Kixi
 * @copyright   Universidad Distrital Francisco Jose de Caldas - Grupo de Trabajo Academico GNU/Linux GLUD
 * @license     GPL Version 3 o posterior
 *
 */
class Autenticador {
	
	private static $instancia;
	
	/**
	 * Arreglo que contiene los datos de la página que se va revisar
	 *
	 * @var String[]
	 */
	var $pagina;
	
	/**
	 * Objeto.
	 * Con los atributos y métodos para gestionar la sesión de usuario
	 *
	 * @var Sesion
	 */
	var $sesionUsuario;
	
	var $tipoError;
	
	var $configurador;
	
	var $sesionSSO;
	
	const NIVEL = 'nivel';
	
	private function __construct() {
		
		$this->configurador = Configurador::singleton ();
		require_once ($this->configurador->getVariableConfiguracion ( "raizDocumento" ) . "/core/auth/Sesion.class.php");
		$this->sesionUsuario = Sesion::singleton ();
		$this->sesionUsuario->setSesionUsuario ( $this->configurador->fabricaConexiones->miLenguaje->getCadena ( "usuarioAnonimo" ) );
		$this->sesionUsuario->setConexion ( $this->configurador->fabricaConexiones->getRecursoDB ( "configuracion" ) );
		$this->sesionUsuario->setTiempoExpiracion ( $this->configurador->getVariableConfiguracion ( "expiracion" ) );
		$this->sesionUsuario->setPrefijoTablas ( $this->configurador->getVariableConfiguracion ( "prefijo" ) );
		
	}
	
	public static function singleton() {
		
		if (! isset ( self::$instancia )) {
			$className = __CLASS__;
			self::$instancia = new $className ();
		}
		return self::$instancia;
		
	
	}
	
	function iniciarAutenticacion() {
		
		$respuesta = '';
		$resultado = $this->verificarExistenciaPagina ();
               
		if ($resultado) {
			$resultado = $this->cargarSesionUsuario ();
                  
			if ($resultado) {
				// Verificar que el usuario está autorizado para el nivel de acceso de la página
				
				$resultado = $this->verificarAutorizacionUsuario ();
                   
                               
				if ($resultado) {
					$respuesta = true;
                                     
                                       
				} else {
					$this->tipoError = "usuarioNoAutorizado";
					$respuesta = false;
				}
			}  else {
                                        /*
                                         * Para la autenticación con SingleSignOn se verifica que esté habilitado en la base de datos "_configuracion"
                                         */
                                        $resultado = $this->verificarAutenticacionSSO();


                                        //La única página que no se valida por SSO es el index
                                        if($resultado){

                                                if($this->getPagina()=='index'){
                                                        return true;
                                                }

                                                $resultado = $this->iniciarAutenticacionSSO();

                                                if($resultado){
                                                        return true;
                                                } else {
                                                        $this->tipoError = "usuarioNoAutorizado";
                                                        return false;
                                                }
                                        } else {//Termina SingleSignOn
                                                                $this->tipoError = "sesionNoExiste";
                                                                $respuesta = false;
                                                        }
			}
		} else {
			
			$this->tipoError = "paginaNoExiste";
			$respuesta = false;
		}
		
		if (($this->sesionUsuario->getValorSesion ( 'sesionUsuarioId' )) != '') {
			
			$_REQUEST ['usuario'] = $this->sesionUsuario->getValorSesion ( 'sesionUsuarioId' );
			
		}
		
		if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] = 'true') {
			$respuesta = true;
		}
                
               
		
		return $respuesta;
	}
	
	function setPagina($pagina) {
		$this->pagina ["nombre"] = $pagina;
	}
	
	function getPagina() {
		return $this->pagina ["nombre"];
	}
	
	private function verificarExistenciaPagina() {
		
		$clausulaSQL = $this->sesionUsuario->miSql->getCadenaSql ( "seleccionarPagina", $this->pagina ["nombre"] );
		
		if ($clausulaSQL) {
			$registro = $this->configurador->conexionDB->ejecutarAcceso ( $clausulaSQL, "busqueda" );
			$totalRegistros = $this->configurador->conexionDB->getConteo ();
			
			if ($totalRegistros > 0) {
				$this->pagina [self::NIVEL] = $registro [0] [0];
				return true;
			}
		}
		$this->tipoError = "paginaNoExiste";
		return false;
	}
	
	function getError() {
		return $this->tipoError;
	}
	
	/**
	 * Método.
	 *
	 * @return boolean
	 */
	function cargarSesionUsuario() {
		
		// Asignar el nivel de la sesión conforme al nivel de la página que se está visitando
		$this->sesionUsuario->setSesionNivel ( $this->pagina [self::NIVEL] );
		
		
		$verificar = $this->sesionUsuario->verificarSesion ();
	
		if (! $verificar) {
			$this->tipoError = "sesionNoExiste";
			return false;
		}
		
		return true;
	}
	
	function verificarAutorizacionUsuario() {
                    
		if ($this->sesionUsuario->getSesionNivel () == $this->pagina [self::NIVEL]) {
			return true;
		}
		
		return false;
	}
	
	function verificarAutenticacionSSO(){
		 
		if($this->configurador->getVariableConfiguracion ('singleSignOn')==true){
			require_once ('SesionSso.class.php');
			$this->sesionSso = SesionSso::singleton ();
			return true;
		}
            
                    return false;
                
	
		
		 
	}
	
	function iniciarAutenticacionSSO(){
		
		//Si el sistema de logueo es por Single Sign On
		$resultado = $this->sesionSso->verificarSesion($this->getPagina());
		return $resultado;
	}
        
        function terminarAutenticacionSSO(){
		require_once ('SesionSso.class.php');
                $this->sesionSso = SesionSso::singleton ();
		//Si el sistema de logueo es por Single Sign On
		$this->sesionSso->terminarSesion();
		
	}
	
}
?>
