<?php

namespace gestionPolizas\gestionPolizas\funcion;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class redireccion {

    public static function redireccionar($opcion, $valor = "") {
        $miConfigurador = \Configurador::singleton();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {


            case "actualizarAmparo" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=actualizarAmparo";
                $variable .= "&amparo=" . $valor ['amparo'];
                $variable .= "&fecha_inicio=" . $valor ['fecha_inicio'];
                $variable .= "&fecha_final=" . $valor ['fecha_final'];
                $variable .= "&id_poliza=" . $valor ['id_poliza'];
                $variable .= "&id_amparo=" . $valor ['id_amparo'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&tipo_unidad=" . $valor ['tipo_unidad'];
                $variable .= "&unidad_amparo=" . $valor ['unidad_amparo'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];
               
                break;

            case "noactualizarAmparo" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noactualizarAmparo";
                $variable .= "&amparo=" . $valor ['amparo'];
                $variable .= "&fecha_inicio=" . $valor ['fecha_inicio'];
                $variable .= "&fecha_final=" . $valor ['fecha_final'];
                $variable .= "&id_poliza=" . $valor ['id_poliza'];
                $variable .= "&id_amparo=" . $valor ['id_amparo'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&tipo_unidad=" . $_REQUEST ['tipo_unidad'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&unidad_amparo=" . $valor ['unidad_amparo'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;
            case "actualizarPoliza" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=actualizarPoliza";
                $variable .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variable .= "&descripcion=" . $valor ['descripcion'];
                $variable .= "&id_poliza=" . $valor ['id_poliza'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];
                break;

            case "noactualizarPoliza" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noactualizarPoliza";
                $variable .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variable .= "&descripcion=" . $valor ['descripcion'];
                $variable .= "&id_poliza=" . $valor ['id_poliza'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;
            case "registroPoliza" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=registroPoliza";
                $variable .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variable .= "&descripcion=" . $valor ['descripcion'];
                $variable .= "&id_poliza=" . $valor ['id_poliza'];
                $variable .= "&usuario=" . $valor ['usuario'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];
                break;

            case "noregistroPoliza" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noregistroPoliza";
                $variable .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variable .= "&descripcion=" . $valor ['descripcion'];
                $variable .= "&id_poliza=" . $valor ['id_poliza'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;
            case "cambioEstado" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=cambioEstado";
                $variable .= "&id_poliza=" . $valor [1];
                $variable .= "&estadoNuevo=" . $valor [0];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];
                break;

            case "noCambioEstado" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noCambioEstado";
                $variable .= "&id_poliza=" . $valor [1];
                $variable .= "&estadoNuevo=" . $valor [0];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_poliza=" . $valor ['numero_poliza'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;
            case "cambioEstadoAmparo" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=cambioEstadoAmparo";
                $variable .= "&id_poliza=" . $valor [1];
                $variable .= "&estadoNuevo=" . $valor [0];
                $variable .= "&nombrePoliza=" . $valor [2];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&id_amparo=" . $valor ['id_amparo'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];
                break;

            case "noCambioEstadoAmparo" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noCambioEstadoAmparo";
                $variable .= "&id_poliza=" . $valor [1];
                $variable .= "&estadoNuevo=" . $valor [0];
                $variable .= "&nombrePoliza=" . $valor [2];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&id_amparo=" . $valor ['id_amparo'];
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;

            case "registroAmparos" :

                $datos = serialize($valor);
                $datos = urlencode($datos);

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=registroAmparos";
                $variable .= "&id_poliza=" . $valor[count($valor) - 1]['id_poliza'];
                $variable .= "&vigencia=" . $valor[count($valor) - 1]['vigencia'];
                $variable .= "&numero_contrato=" . $valor[count($valor) - 1]['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor[count($valor) - 1]['numero_contrato_suscrito'];
                $variable .= "&tipo_amparo_registro=" . $valor[count($valor) - 1]['tipo_amparo_registro'];
                $variable .= "&mensaje_titulo=" . $valor[count($valor) - 1]['mensaje_titulo'];
                $variable .= "&datos=" . $datos;
                break;

            case "noRegistroAmparos" :

                $datos = serialize($valor);
                $datos = urlencode($datos);

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noRegistroAmparos";
                $variable .= "&id_poliza=" . $valor[count($valor) - 1]['id_poliza'];
                $variable .= "&vigencia=" . $valor[count($valor) - 1]['vigencia'];
                $variable .= "&numero_contrato=" . $valor[count($valor) - 1]['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor[count($valor) - 1]['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor[count($valor) - 1]['mensaje_titulo'];
                $variable .= "&datos=" . $datos;

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