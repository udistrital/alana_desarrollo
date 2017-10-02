<?php
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class consulta {

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
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $miSesion = \Sesion::singleton();
        //identifca lo roles para la busqueda de subsistemas
        $User = $miSesion->idUsuario();
        $parametro = array('id_usuario' => $User);
        $cadena_sql = $this->miSql->getCadenaSql("consultarUsuarios", $parametro);
        $resultadoUsuarios = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

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

        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Reporte de Contratos";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


        $reporte = $_REQUEST['reporte'];
        $usuarioReporte = 'biconsulta';
        $accesoReporte = 'biconsulta';
        $rolReporte = '/spagobi/user';
        isset($_REQUEST['usrReporte']) ? $usuarioReporte = $_REQUEST['usrReporte'] : 'biconsulta';
        isset($_REQUEST['passReporte']) ? $accesoReporte = $_REQUEST['passReporte'] : 'biconsulta';
        isset($_REQUEST['roleReporte']) ? $rolReporte = '/spagobi/' . $_REQUEST['roleReporte'] : '/spagobi/user';
        ?>


        <html>
            <head>

                <script type="text/javascript" src="blocks/reportes/spagobi/formulario/sbisdk-all-production.js"></script>

                <script type="text/javascript">

                    Sbi.sdk.services.setBaseUrl({
                        protocol: 'https'
                        , host: 'intelligentia.udistrital.edu.co'
                        , port: '8443'
                        , contextPath: 'SpagoBI'
                        , controllerPath: 'servlet/AdapterHTTP'
                    });

                    var cb = function (result, args, success) {

                        if (success === true) {
                            this.execTest1();

                        } else {
                            alert('ERROR: Wrong username or password');
                        }
                    };
                    execTest1 = function () {
                        var url = Sbi.sdk.api.getDocumentUrl({
                            documentLabel: <?php echo "'$reporte'"; ?>
                            , executionRole: <?php echo "'$rolReporte'"; ?>
                            , displayToolbar: true
                            , displaySliders: false
                        
                            
                        });
                        document.getElementById('execiframe').src = url;
                    };
                    Sbi.sdk.api.authenticate({
                        params: {
                            user: <?php echo "'$usuarioReporte'"; ?>
                            , password: <?php echo "'$accesoReporte'"; ?>
                        }

                        , callback: {
                            fn: cb
                            , scope: this
                                    //, args: {arg1: 'A', arg2: 'B', ...}
                        }
                    });
                </script>
            </head>


            <body>

                <hr>
                <iframe id="execiframe" src='' height="400px" width="100%"></iframe>
                <hr>


            </body>
        </html>

        <?php
        echo $this->miFormulario->marcoAgrupacion('fin');


        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
    }

}

$miSeleccionador = new consulta($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
