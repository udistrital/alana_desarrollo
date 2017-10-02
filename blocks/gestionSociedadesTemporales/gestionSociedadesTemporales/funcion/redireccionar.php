<?php

namespace gestionSociedadesTemporales\gestionSociedadesTemporales\funcion;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class redireccion {

    public static function redireccionar($opcion, $valor = "") {
        $miConfigurador = \Configurador::singleton();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {


            case "registroSociedad" :


                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=registroSociedad";
                $variable .= "&tipopersona=" . $valor ['tipopersona'];
                $variable .= "&num_documento=" . $valor ['num_documento'];
                $variable .= "&nom_proveedor=" . $valor ['nom_proveedor'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&arreglo=" . $valor ['arreglo'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;

            case "noregistroSociedad" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noregistroSociedad";
                $variable .= "&tipopersona=" . $valor ['tipopersona'];
                $variable .= "&num_documento=" . $valor ['num_documento'];
                $variable .= "&nom_proveedor=" . $valor ['nom_proveedor'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&arreglo=" . $valor ['arreglo'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;
            case "actualizoSociedad" :


                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=actualizoSociedad";
                $variable .= "&tipopersona=" . $valor ['tipopersona'];
                $variable .= "&num_documento=" . $valor ['num_documento'];
                $variable .= "&nom_proveedor=" . $valor ['nom_proveedor'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&arreglo=" . $valor ['arreglo'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;

            case "noActualizoSociedad" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noActualizoSociedad";
                $variable .= "&tipopersona=" . $valor ['tipopersona'];
                $variable .= "&num_documento=" . $valor ['num_documento'];
                $variable .= "&nom_proveedor=" . $valor ['nom_proveedor'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&arreglo=" . $valor ['arreglo'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;


            case "cambioEstado" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=cambioEstado";
                $variable .= "&id_sociedad=" . $valor [1];
                $variable .= "&estadoNuevo=" . $valor [0];
                $variable .= "&tipopersona=" . $valor ['tipopersona'];
                $variable .= "&num_documento=" . $valor ['num_documento'];
                $variable .= "&nom_proveedor=" . $valor ['nom_proveedor'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&arreglo=" . $valor ['arreglo'];
                break;

            case "noCambioEstado" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noCambioEstado";
                $variable .= "&id_sociedad=" . $valor [1];
                $variable .= "&estadoNuevo=" . $valor [0];
                $variable .= "&tipopersona=" . $valor ['tipopersona'];
                $variable .= "&num_documento=" . $valor ['num_documento'];
                $variable .= "&nom_proveedor=" . $valor ['nom_proveedor'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&arreglo=" . $valor ['arreglo'];

                break;


            case "regresar" :
                $variable = "pagina=" . $miPaginaActual;
                break;

            case "paginaPrincipal" :
                $variable = "pagina=" . $miPaginaActual;
                break;
        }

        foreach ($_REQUEST as $clave => $valor) {
            unset($_REQUEST [$clave]);
        }

        $url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion ['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
        $_REQUEST [$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST [$enlace];

        echo "<script>location.replace('" . $redireccion . "')</script>";
    }

}

?>