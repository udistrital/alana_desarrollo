<?php

namespace gestionContractual\novedad\registrarNovedad;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class redireccion {

    public static function redireccionar($opcion, $valor = "", $valor1 = "") {
        $miConfigurador = \Configurador::singleton();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {
            case "Inserto" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=Inserto";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&acto_administrativo=" . $valor['acto_administrativo'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];

                break;

            case "ErrorRegistro" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&acto_administrativo=" . $valor['acto_administrativo'];
                $variable .= "&mensaje=noInserto";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            case "actualizo" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=actualizo";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&acto_administrativo=" . $valor['acto_administrativo'];
                $variable .= "&idnovedadModificacion=" . $valor['idnovedadModificacion'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];


                break;

            case "ErrorActualizo" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=ErrorActualizo";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&acto_administrativo=" . $valor['acto_administrativo'];
                $variable .= "&idnovedadModificacion=" . $valor['idnovedadModificacion'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            case "ErrorSeleccionNovedad" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=ErrorSeleccionNovedad";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            
            case "errorVigencia" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=errorVigencia";
                $variable .= "&vigencia_novedad=" . $valor['vigencia_novedad'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;

            case "rebasaReduccion" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&acumulado=" . $valor['acumulado'];
                $variable .= "&valor_tope=" . $valor['valor_tope'];
                $variable .= "&valor_rp=" . $valor['valor_rp'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&valor_reduccion=" . $valor['valor_reduccion'];
                $variable .= "&mensaje=rebasaReduccion";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            case "rebasaOtroSi" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&acumulado=" . $valor['acumulado'];
                $variable .= "&valor_tope=" . $valor['valor_tope'];
                $variable .= "&valor_contrado=" . $valor['valor_contrado'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&valor_adicion=" . $valor['valor_adicion'];
                $variable .= "&mensaje=rebasaOtroSI";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            
            case "rebasaOtroSitiempo" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&acumuladoadicion=" . $valor['acumuladoadicion'];
                $variable .= "&acumuladoNovedades=" . $valor['acumuladoNovedades'];
                $variable .= "&valor_tope=" . $valor['valor_tope'];
                $variable .= "&tiempo_contrato=" . $valor['tiempo_contrato'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=" . $valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&valor_adicion=" . $valor['valor_adicion'];
                $variable .= "&mensaje=rebasaOtroSitiempo";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            
            
            case "novedadModificacionNovedad" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=novedadModificarNovedad";
                $variable .= "&numero_contrato=".$valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=".$valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=".$valor['vigencia'];
                $variable .= "&info_novedad=".$valor['info_novedad'];
                $variable .= "&tipo_novedad=".$valor['tipo_novedad'];
                $variable .= "&idnovedadModificacion=".$valor['idnovedadModificacion'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
            case "novedadModificacionContrato" :
                $variable = "pagina=modificarContrato";
                $variable .= "&bloque=contratos";
                $variable .= "&bloqueGrupo=gestionContractual";
                $variable .= "&opcion=modificarContratos";
                $variable .= "&numero_contrato=".$valor['numero_contrato'];
                $variable .= "&numero_contrato_suscrito=".$valor['numero_contrato_suscrito'];
                $variable .= "&vigencia=".$valor['vigencia'];
                $variable .= "&idnovedadModificacion=".$valor['idnovedadModificacion'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
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