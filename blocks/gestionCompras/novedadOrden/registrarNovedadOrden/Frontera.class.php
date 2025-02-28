<?php

namespace gestionCompras\novedadOrden\registrarNovedadOrden;

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

                case "consultar" :
                    include_once ($this->ruta . "/formulario/resultadoContratos.php");
                    break;
               
                case "nuevaNovedad" :
                    include_once ($this->ruta . "/formulario/registro.php");
                    break;
                
                case "consultanovedades" :
                    include_once ($this->ruta . "/formulario/consultanovedades.php");
                    break;
                
              case "modificarNovedad" :
                    include_once ($this->ruta . "/formulario/modificarNovedad.php");
                    break;
                
                case "novedadModificarNovedad" :
                    include_once ($this->ruta . "/formulario/modificarNovedad.php");
                    break;

                default :
                    include_once ($this->ruta . "/formulario/consulta.php");
                    break;
            }
        } else {
            $_REQUEST ['opcion'] = "mostrar";
            include_once ($this->ruta . "/formulario/consulta.php");
        }
    }

}

?>
