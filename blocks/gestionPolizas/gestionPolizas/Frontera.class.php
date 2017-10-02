<?php

namespace gestionPolizas;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");

class Frontera {

    var $ruta;
    var $sql;
    var $funcion;
    var $lenguaje;
    var $formulario;
    var $miConfigurador;

    function __construct() {
        $this->miConfigurador = \Configurador::singleton();
    }

    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }

    function frontera() {
        $this->html();
    }

    function setSql($a) {
        $this->sql = $a;
    }

    function setFuncion($funcion) {
        $this->funcion = $funcion;
    }

    function html() {

        include_once ("core/builder/FormularioHtml.class.php");

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->miFormulario = new \FormularioHtml ();

        if (isset($_REQUEST ['opcion'])) {

            switch ($_REQUEST ['opcion']) {

                case "mensaje" :
                    include_once ($this->ruta . "/formulario/mensaje.php");
                    break;
                case "ConsultarContratos" :
                    include_once ($this->ruta . "/formulario/resultado.php");
                    break;
                case "consultarContrato" :
                    include_once ($this->ruta . "/formulario/consultarContrato.php");
                    break;
                case "gestionAmparos" :
                    include_once ($this->ruta . "/formulario/gestionAmparos.php");
                    break;
                case "gestionPolizas" :
                    include_once ($this->ruta . "/formulario/consulta_polizas.php");
                    break;
                case "registrarPoliza" :
                    include_once ($this->ruta . "/formulario/registroPoliza.php");
                    break;
                case "editarPoliza" :
                    include_once ($this->ruta . "/formulario/editarPoliza.php");
                    break;
                case "editarAmparo" :
                    include_once ($this->ruta . "/formulario/editarAmparo.php");
                    break;
            }
        } else {
            $_REQUEST ['opcion'] = "mostrar";
            include_once ($this->ruta . "/formulario/consulta.php");
        }
    }

}

?>
