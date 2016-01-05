	<?php
	if (! isset ( $GLOBALS ["autorizado"] )) {
		include ("../index.php");
		exit ();
	}
	class registrarForm {
		var $miConfigurador;
		var $lenguaje;
		var $miFormulario;
		var $miSql;
		function __construct($lenguaje, $formulario, $sql) {
			$this->miConfigurador = \Configurador::singleton ();
			
			$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
			
			$this->lenguaje = $lenguaje;
			
			$this->miFormulario = $formulario;
			
			$this->miSql = $sql;
		}
		function miForm() {
			
			// Rescatar los datos de este bloque
			$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
			
			// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
			/**
			 * Atributos que deben ser aplicados a todos los controles de este formulario.
			 * Se utiliza un arreglo
			 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
			 *
			 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
			 * $atributos= array_merge($atributos,$atributosGlobales);
			 */
			$atributosGlobales ['campoSeguro'] = 'true';
			
			$_REQUEST ['tiempo'] = time ();
			
			// -------------------------------------------------------------------------------------------------
			$conexion = "contractual";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			// Limpia Items Tabla temporal
			// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
			$esteCampo = $esteBloque ['nombre'];
			
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			
			/**
			 * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
			 * validationEngine.
			 */
			$atributos ['validar'] = false;
			
			// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
			$atributos ['tipoFormulario'] = 'multipart/form-data';
			// Si no se coloca, entonces toma el valor predeterminado 'POST'
			$atributos ['metodo'] = 'POST';
			// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
			$atributos ['action'] = 'index.php';
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
			// Si no se coloca, entonces toma el valor predeterminado.
			$atributos ['estilo'] = '';
			$atributos ['marco'] = false;
			$tab = 1;
			// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
			// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos = array_merge ( $atributos );
			echo $this->miFormulario->formulario ( $atributos );
			// ---------------- SECCION: Controles del Formulario -----------------------------------------------
			
			$esteCampo = "marcoDatosBasicos";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos ["leyenda"] = "Registrar Contrato";
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			{
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "ventanaA";
				echo $this->miFormulario->division ( "inicio", $atributos );
				unset ( $atributos );
				{
					
					echo "<h3>Datos Personales</h3>
							<section>";
					
					{
						$esteCampo = 'numero_contrato';
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'text';
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['marco'] = true;
						$atributos ['estiloMarco'] = '';
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['columnas'] = 1;
						$atributos ['dobleLinea'] = 0;
						$atributos ['tabIndex'] = $tab;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'required,custom[onlyNumberSp]';
						
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['valor'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['valor'] = '';
						}
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['deshabilitado'] = false;
						$atributos ['tamanno'] = 8;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 213;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						// ------------------Division para los botones-------------------------
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							$esteCampo = 'tipo_identificacion';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = true;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_identificacion" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'numero_identificacion';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						//
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'digito_verificacion';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'tipo_persona';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = true;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_persona" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						//
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'primer_nombre';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'segundo_nombre';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = false;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = ' ';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'primer_apellido';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'segundo_apellido';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = false;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = ' ';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							$esteCampo = 'genero';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = true;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_genero" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'nacionalidad';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = true;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_nacionalidad" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'direccion';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'telefono';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'correo';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required, custom[email] ';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'perfil';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = false;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_perfil" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'profesion';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = false;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'especialidad';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = false;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'tipo_cuenta';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = true;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_cuenta" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'numero_cuenta';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'entidad_bancaria';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 2;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 20;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 213;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'tipo_configuracion';
							$atributos ['columnas'] = 2;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = true;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							$atributos ['anchoCaja'] = 22;
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_configuracion" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
						
						$atributos ["id"] = "division";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'clase_contratista';
							$atributos ['columnas'] = 1;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['id'] = $esteCampo;
							$atributos ['evento'] = '';
							$atributos ['deshabilitado'] = false;
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['tab'] = $tab;
							$atributos ['tamanno'] = 1;
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['validar'] = 'required';
							$atributos ['limitar'] = false;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['anchoEtiqueta'] = 213;
							$atributos ['anchoCaja'] = 35;
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['seleccion'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['seleccion'] = - 1;
							}
							
							$matrizItems = array (
									array (
											' ',
											'Sin Solicitud de Necesidad' 
									) 
							);
							
							// $atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							$atributos ['baseDatos'] = 'contractual';
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "tipo_clase_contratista" );
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							
							$atributos ["id"] = "divisionClaseContratista";
							$atributos ["estiloEnLinea"] = "display:none";
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->division ( "inicio", $atributos );
							unset ( $atributos );
							{
								
								$esteCampo = 'identificacion_clase_contratista';
								$atributos ['id'] = $esteCampo;
								$atributos ['nombre'] = $esteCampo;
								$atributos ['tipo'] = 'text';
								$atributos ['estilo'] = 'jqueryui';
								$atributos ['marco'] = true;
								$atributos ['estiloMarco'] = '';
								$atributos ["etiquetaObligatorio"] = true;
								$atributos ['columnas'] = 1;
								$atributos ['dobleLinea'] = 0;
								$atributos ['tabIndex'] = $tab;
								$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
								$atributos ['validar'] = 'required,custom[onlyNumberSp]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 20;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 213;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
								
								$esteCampo = 'digito_verificacion_clase_contratista';
								$atributos ['id'] = $esteCampo;
								$atributos ['nombre'] = $esteCampo;
								$atributos ['tipo'] = 'text';
								$atributos ['estilo'] = 'jqueryui';
								$atributos ['marco'] = true;
								$atributos ['estiloMarco'] = '';
								$atributos ["etiquetaObligatorio"] = true;
								$atributos ['columnas'] = 2;
								$atributos ['dobleLinea'] = 0;
								$atributos ['tabIndex'] = $tab;
								$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
								$atributos ['validar'] = 'required,custom[onlyNumberSp]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 20;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 213;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
								
								$esteCampo = 'porcentaje_clase_contratista';
								$atributos ['id'] = $esteCampo;
								$atributos ['nombre'] = $esteCampo;
								$atributos ['tipo'] = 'text';
								$atributos ['estilo'] = 'jqueryui';
								$atributos ['marco'] = true;
								$atributos ['estiloMarco'] = '';
								$atributos ["etiquetaObligatorio"] = true;
								$atributos ['columnas'] = 2;
								$atributos ['dobleLinea'] = 0;
								$atributos ['tabIndex'] = $tab;
								$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
								$atributos ['validar'] = 'required,custom[number]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 5;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 213;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
							}
							// ------------------Fin Division para los botones-------------------------
							echo $this->miFormulario->division ( "fin" );
							unset ( $atributos );
						}
						// ------------------Fin Division para los botones-------------------------
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					
					echo "</section>
							<h3>Datos Contrato</h3>
							<section>";
					{
						// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
						$esteCampo = 'wer';
						$atributos ['columnas'] = 2;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['evento'] = '';
						$atributos ['deshabilitado'] = false;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ['tab'] = $tab;
						$atributos ['tamanno'] = 1;
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['validar'] = 'required';
						$atributos ['limitar'] = true;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 213;
						
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['seleccion'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['seleccion'] = - 1;
						}
						
						// $atributos ['matrizItems'] = $matrizItems;
						
						// Utilizar lo siguiente cuando no se pase un arreglo:
						$atributos ['baseDatos'] = 'contractual';
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "vigencias_solicitudes" );
						$tab ++;
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
					}
					
					echo "</section>
							<h3>Datos Presupustales</h3>
							<section>";
					{
						// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
						$esteCampo = 'vigeeeeencia';
						$atributos ['columnas'] = 2;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['evento'] = '';
						$atributos ['deshabilitado'] = false;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ['tab'] = $tab;
						$atributos ['tamanno'] = 1;
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['validar'] = ' ';
						$atributos ['limitar'] = true;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 213;
						
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['seleccion'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['seleccion'] = - 1;
						}
						
						// $atributos ['matrizItems'] = $matrizItems;
						
						// Utilizar lo siguiente cuando no se pase un arreglo:
						$atributos ['baseDatos'] = 'contractual';
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "vigencias_solicitudes" );
						$tab ++;
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
					}
					
					echo "</section>";
				}
				
				// ------------------Fin Division para los botones-------------------------
				echo $this->miFormulario->division ( "fin" );
				unset ( $atributos );
				
				// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			}
			
			// ------------------- SECCION: Paso de variables ------------------------------------------------
			
			/**
			 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
			 * SARA permite realizar esto a través de tres
			 * mecanismos:
			 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
			 * la base de datos.
			 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
			 * formsara, cuyo valor será una cadena codificada que contiene las variables.
			 * (c) a través de campos ocultos en los formularios. (deprecated)
			 */
			// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
			// Paso 1: crear el listado de variables
			
			$valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
			$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
			$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
			$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
			$valorCodificado .= "&opcion=ConsultarSolicitudes";
			$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
			/**
			 * SARA permite que los nombres de los campos sean dinámicos.
			 * Para ello utiliza la hora en que es creado el formulario para
			 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
			 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
			 * (b) asociando el tiempo en que se está creando el formulario
			 */
			$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
			$valorCodificado .= "&tiempo=" . time ();
			// Paso 2: codificar la cadena resultante
			$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
			
			$atributos ["id"] = "formSaraData"; // No cambiar este nombre
			$atributos ["tipo"] = "hidden";
			$atributos ['estilo'] = '';
			$atributos ["obligatorio"] = false;
			$atributos ['marco'] = true;
			$atributos ["etiqueta"] = "";
			$atributos ["valor"] = $valorCodificado;
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			
			$atributos ['marco'] = true;
			$atributos ['tipoEtiqueta'] = 'fin';
			echo $this->miFormulario->formulario ( $atributos );
		}
	}
	
	$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );
	
	$miSeleccionador->miForm ();
	?>
