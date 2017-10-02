<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class registrarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function miForm() {

        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/inventarios/gestionActa/";
        $rutaBloque .= $esteBloque ['nombre'];

        $atributosGlobales ['campoSeguro'] = 'true';

        $_REQUEST ['tiempo'] = time();
        $tiempo = $_REQUEST ['tiempo'];

        // lineas para conectar base de d atos-------------------------------------------------------------------------------------------------
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

        $conexionCore = "core";
        $esteRecursoDBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);



        $seccion ['tiempo'] = $tiempo;


        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        // $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = false;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos); {

            $cadenaSqlServicio = $this->miSql->getCadenaSql("consultarServicio", $_REQUEST['id_servicio']);
            $servicio = $esteRecursoDB->ejecutarAcceso($cadenaSqlServicio, "busqueda");

            $servicio = $servicio[0];
            $cadenaSqlTipoServicio = $this->miSql->getCadenaSql("consultarTipoServicio", $servicio['codigo_ciiu']);

            $tiposervicio = $esteRecursoDBCore->ejecutarAcceso($cadenaSqlTipoServicio, "busqueda");





            $arreglo_info_servicio = array(
                'tipo_servicio' => $tiposervicio[0][0],
                'codigo_ciiu' => $servicio['codigo_ciiu'],
                'resumen_servicio' => $servicio['nombre'],
                'valor_servicio' => $servicio['valor_servicio'],
                'descripcion_servicio' => $servicio['descripcion'],
            );
            $_REQUEST = array_merge($arreglo_info_servicio, $_REQUEST);


            $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

            $directorio = $this->miConfigurador->getVariableConfiguracion("host");
            $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
            $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
            $arreglo = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
            $arreglo = unserialize($arreglo);

            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=consultaElementos";
            $variable .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
            $variable .= "&numerocontrato=" . $_REQUEST ['numerocontrato'];
            $variable .= "&id\_contrato=";
            $variable .= "&numero\_contrato=";
            $variable .= "&clase\_contrato=";
            $variable .= "&id_contratista=";
            $variable .= "&fecha\_inicio\_consulta=";
            $variable .= "&fecha\_final\_consulta=";
            $variable .= "&usuario=";
            $variable .= "&vigencia=" . $_REQUEST ['vigencia'];
            $variable .= "&arreglo=" . $_REQUEST ['arreglo'];

            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);


            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = $_REQUEST ['mensaje_titulo'];
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos); {

                $esteCampo = 'botonRegresar';
                $atributos ['id'] = $esteCampo;
                $atributos ['enlace'] = $variable;
                $atributos ['tabIndex'] = 1;
                $atributos ['estilo'] = 'textoSubtitulo';
                $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['ancho'] = '10%';
                $atributos ['alto'] = '10%';
                $atributos ['redirLugar'] = true;
                echo $this->miFormulario->enlace($atributos);
                unset($atributos);


                $atributos ["id"] = "cargar_servicio";
                $atributos ["estiloEnLinea"] = "display:block";
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {

                    $esteCampo = "AgrupacionInformacion";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Modificar Servicio";
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {

                        // ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
                        $esteCampo = "AgrupacionInformacion";
                        $atributos ['id'] = $esteCampo;
                        $atributos ['leyenda'] = "Informacion General del Servicio";
                        echo $this->miFormulario->agrupacion('inicio', $atributos);

                        unset($atributos); {


                            $esteCampo = 'tipo_servicio';
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['seleccion'] = - 1;
                            $atributos ['evento'] = '';
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tab'] = $tab;
                            $atributos ['tamanno'] = 1;
                            $atributos ['columnas'] = 1;
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['validar'] = 'required';
                            $atributos ['limitar'] = false;
                            $atributos ['anchoCaja'] = 60;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 200;

                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipoServicio");
                            $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");


                            $atributos ['matrizItems'] = $matrizItems;

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['seleccion'] = - 1;
                            }

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);
                            unset($atributos);

                            $esteCampo = 'codigo_ciiu';
                            $atributos ['columnas'] = 1;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['id'] = $esteCampo;

                            $atributos ['evento'] = '';
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = false;
                            $atributos ['tab'] = $tab;
                            $atributos ['tamanno'] = 1;
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['validar'] = '';
                            $atributos ['limitar'] = true;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 330;
                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['seleccion'] = - 1;
                            }
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("serviciosPorClase", $_REQUEST['tipo_servicio']);

                            $matrizItems = $esteRecursoDBCore->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                            $atributos ['matrizItems'] = $matrizItems;

                            // Utilizar lo siguiente cuando no se pase un arreglo:
                            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);


                            $esteCampo = 'resumen_servicio';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ['columnas'] = 2;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required, minSize[10]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tamanno'] = 40;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 300;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'valor_servicio';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ['columnas'] = 2;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required, custom[number]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tamanno'] = 40;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 300;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                        }
                        echo $this->miFormulario->agrupacion("fin");
                        unset($atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'descripcion_servicio';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 90;
                        $atributos ['filas'] = 5;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[10]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);
                        unset($atributos);




                        // ---------------
                    }
                    echo $this->miFormulario->agrupacion('fin');
                }

                $atributos ["id"] = "botones";
                $atributos ["estilo"] = "marcoBotones";
                echo $this->miFormulario->division("inicio", $atributos);

                // -----------------CONTROL: Botón ----------------------------------------------------------------
                $esteCampo = 'botonActualizarServicio';
                $atributos ["id"] = $esteCampo;
                $atributos ["tabIndex"] = $tab;
                $atributos ["tipo"] = 'boton';
                // submit: no se coloca si se desea un tipo button genérico
                $atributos ['submit'] = 'true';
                $atributos ["estiloMarco"] = '';
                $atributos ["estiloBoton"] = 'jqueryui';
                // verificar: true para verificar el formulario antes de pasarlo al servidor.
                $atributos ["verificar"] = '';
                $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoBoton($atributos);
                // -----------------FIN CONTROL: Botón -----------------------------------------------------------

                echo $this->miFormulario->division('fin');
                echo $this->miFormulario->agrupacion('fin');


                // ------------------Division para los botones-------------------------


                echo $this->miFormulario->marcoAgrupacion('fin');

                // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
                // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
                // Se debe declarar el mismo atributo de marco con que se inició el formulario.
            }

            // -----------------FIN CONTROL: Botón -----------------------------------------------------------
            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");

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

            $valorCodificado = "action=" . $esteBloque ["nombre"];
            $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
            $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
            $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
            $valorCodificado .= "&opcion=modificarServicio";
            $valorCodificado .= "&id_servicio=" . $_REQUEST['id_servicio'];
            $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];

            /**
             * SARA permite que los nombres de los campos sean dinámicos.
             * Para ello utiliza la hora en que es creado el formulario para
             * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
             * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
             * (b) asociando el tiempo en que se está creando el formulario
             */
            $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
            $valorCodificado .= "&tiempo=" . time();
            // Paso 2: codificar la cadena resultante
            $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

            $atributos ["id"] = "formSaraData"; // No cambiar este nombre
            $atributos ["tipo"] = "hidden";
            $atributos ['estilo'] = '';
            $atributos ["obligatorio"] = false;
            $atributos ['marco'] = true;
            $atributos ["etiqueta"] = "";
            $atributos ["valor"] = $valorCodificado;
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $atributos ['marco'] = true;
            $atributos ['tipoEtiqueta'] = 'fin';
            echo $this->miFormulario->formulario($atributos);

            unset($atributos);
            return true;
        }
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);
$miSeleccionador->miForm();
?>
