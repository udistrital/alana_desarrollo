<?php

namespace gestionPolizas\gestionPolizas\funcion;

use gestionPolizas\gestionPolizas\funcion\redireccion;

include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorOrden {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miFuncion;
    var $miSql;
    var $conexion;

    function __construct($lenguaje, $sql, $funcion) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
        $this->miFuncion = $funcion;
    }

    function procesarFormulario() {

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $cadenaSql = $this->miSql->getCadenaSql('obtenerEstadoAmparo', $_REQUEST ['id_amparo']);
        $estadoActual = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        if ($estadoActual[0]['estado'] == "t") {
            $nuevoEstado = 'f';
        } else {
            $nuevoEstado = 't';
        }

        $cadenaSql = $this->miSql->getCadenaSql('cambiarEstadoAmparo', array(0 => $nuevoEstado, 1 => $_REQUEST ['id_amparo']));
        $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso", array(0 => $nuevoEstado, 1 => $_REQUEST ['id_amparo']), "cambiarEstadoAmparo");

        $datos = array(
            0 => $nuevoEstado,
            1 => $_REQUEST ['id_poliza'],
            2 => $estadoActual[0]['amparo'],
            'id_amparo' => $_REQUEST['id_amparo'],
            'id_poliza' => $_REQUEST['id_poliza'],
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
            'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
        );

        if ($resultado != false) {
            redireccion::redireccionar('cambioEstadoAmparo', $datos);
            exit();
        } else {

            redireccion::redireccionar('noCambioEstadoAmparo', $datos);
            exit();
        }
    }

    function resetForm() {
        foreach ($_REQUEST as $clave => $valor) {

            if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
                unset($_REQUEST [$clave]);
            }
        }
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>