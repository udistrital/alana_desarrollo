<?php

namespace gestionCompras\consultaOrden\funcion;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class redireccion {

    public static function redireccionar($opcion, $valor = "") {
        $miConfigurador = \Configurador::singleton();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {

            case "ActualizoElemento" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=ActualizoElemento";
                $variable .= "&id_orden=" . $valor[0];
                $variable .= "&mensaje_titulo=" . $valor[1];
                $variable .= "&arreglo=" . $valor[2];
                $variable .= "&id_elemento_acta=" . $valor[3];

                break;
            case "ActualizoServicio" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=ActualizoServicio";
                $variable .= "&id_servicio=" . $valor['id_servicio'];

                break;
            case "actualizoOrden" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=actualizoOrden";
                $variable .= "&numero_contrao=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];

                break;
            case "noActualizo" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noactualizoOrden";
                $variable .= "&numero_contrao=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];

                break;

            case "ErrorRegistroSociedadTemporal" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=ErrorRegistroSociedadTemporal";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;

            case "aproboContrato" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=aproboContrato";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&fecha_aprobacion=" . $valor['fecha_suscripcion'];
                $variable .= "&usuario=" . $valor['usuario'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];

                break;

            case "noAproboContrato" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noAproboContrato";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];

            case "aproboContratos" :

                $datos = serialize($valor);
                $datos = urlencode($datos);
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=aproboContratos";
                $variable .= "&datos=" . $datos;
                break;

            case "noAproboContratos" :
                $datos = serialize($valor);
                $datos = urlencode($datos);
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noAproboContratos";
                $variable .= "&datos=" . $datos;

                break;

            case "noActualizoElemento" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noActualizoElemento";

                break;

            case "novedaddeModificacion" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=novedaddeModificacion";
                $variable .= "&numero_contrato=" . $valor ['numero_contrato'];
                $variable .= "&vigencia=" . $valor ['vigencia'];
                $variable .= "&idnovedadModificacion=" . $valor ['idnovedadModificacion'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&numero_contrato_suscrito=" . $valor ['numero_contrato_suscrito'];
                $variable .= "&mensaje_titulo=" . $valor ['mensaje_titulo'];

                break;
            case "noActualizoServicio" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noActualizoServicio";

                break;

            case "eliminoElemento" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=eliminoElemento";

                break;

            case "eliminoServicio" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=eliminoServicio";

                break;

            case "noeliminoElemento" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noeliminoElemento";

                break;
            case "noeliminoServicio" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noeliminoServicio";

                break;

            case "inserto" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=actualizo";
                $variable .= "&numero_orden=" . $valor [0];
                $variable .= "&mensaje_titulo=" . $valor [1];
                $variable .= "&arreglo=" . $valor [2];
                break;

            case "noInserto" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=error";

                break;

            case "notextos" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=otros";
                $variable .= "&errores=notextos";

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