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
        $atributosGlobales ['campoSeguro'] = 'true';

        $_REQUEST ['tiempo'] = time();
        //-----Esto es una Actualizacion del repositorio 
        // -------------------------------------------------------------------------------------------------
        $conexionContractual = "contractual";
        $DBContractual = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionContractual);

        // Limpia Items Tabla temporal
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
        $atributos ['marco'] = true;
        $tab = 1;


        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        if ($unidad[0]['unidad_ejecutora'] == 1) {
            $unidadEjecutora = 1;
        } else {
            $unidadEjecutora = 2;
        }

        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Consultar Contrato(s)";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


        $esteCampo = 'vigencia_contrato';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['estiloMarco'] = '';
        $atributos ["etiquetaObligatorio"] = false;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = 0;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['validar'] = '';
        $atributos ['textoFondo'] = 'Digite el numero del contrato';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 35;
        $atributos ['maximoTamanno'] = '';
        $atributos ['anchoEtiqueta'] = 300;
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        $esteCampo = 'id_contrato';
        $atributos ["id"] = $esteCampo; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);


        $esteCampo = 'unidad_ejecutora_consulta';
        $atributos ['columnas'] = 2;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['id'] = $esteCampo;
        $atributos ['evento'] = '';
        $atributos ['deshabilitado'] = true;
        $atributos ["etiquetaObligatorio"] = false;
        $atributos ['tab'] = $tab;
        $atributos ['tamanno'] = 1;
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['validar'] = '';
        $atributos ['limitar'] = true;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 213;
        $atributos ['baseDatos'] = 'contractual';
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("unidad_ejecutora_gasto");
        $tab ++;
        if ($unidad[0]['unidad_ejecutora'] == 1) {
            $atributos ['seleccion'] = 1;
        } else {
            $atributos ['seleccion'] = 2;
        }

        $matrizItems = array(
            array(
                ' ',
                'Sin Datos'
            )
        );

// 				$atributos ['matrizItems'] = $matrizItems;
        // Utilizar lo siguiente cuando no se pase un arreglo:

        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);

        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'clase_contrato';
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
        $atributos ['limitar'] = false;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 213;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['seleccion'] = - 1;
        }

        // $atributos ['matrizItems'] = $matrizItems;
        // Utilizar lo siguiente cuando no se pase un arreglo:
        $atributos ['baseDatos'] = 'contractual';
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_contrato");
        $tab ++;
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);



       // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'contratista';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['estiloMarco'] = '';
        $atributos ["etiquetaObligatorio"] = false;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = 0;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['validar'] = '';
        $atributos ['textoFondo'] = 'Ingrese Mínimo 3 Caracteres de Búsqueda';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 50;
        $atributos ['maximoTamanno'] = '';
        $atributos ['anchoEtiqueta'] = 213;
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        $esteCampo = 'id_contratista';
        $atributos ["id"] = $esteCampo; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'fecha_inicio_consulta';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['estiloMarco'] = '';
        // $atributos ["etiquetaObligatorio"] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = 0;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['validar'] = '';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 8;
        $atributos ['maximoTamanno'] = '';
        $atributos ['anchoEtiqueta'] = 213;
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);

        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'fecha_final_consulta';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['estiloMarco'] = '';
        // $atributos ["etiquetaObligatorio"] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = 0;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['validar'] = '';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 8;
        $atributos ['maximoTamanno'] = '';
        $atributos ['anchoEtiqueta'] = 213;
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);

        unset($atributos);
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonConsultar';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
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
        // ---------------------------------------------------------
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");

        echo $this->miFormulario->marcoAgrupacion('fin');

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
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=consultar";
        $valorCodificado .= "&usuario=" . $_REQUEST['usuario'];
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
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
