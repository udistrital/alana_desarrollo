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

        if ($_REQUEST['tipo_valor_amparo'] == '1') {
            $unidad = $_REQUEST['porcentaje_amparo'];
        } else {
            $unidad = $_REQUEST['numero_minimos'];
        }

        $datoAmparo = array(
            'id_poliza' => $_REQUEST['id_poliza'],
            'id_amparo' => $_REQUEST['id_amparo'],
            'amparo' => $_REQUEST['amparo'],
            'unidad_amparo' => $unidad,
            'tipo_unidad' => $_REQUEST['tipo_valor_amparo'],
            'usuario' => $_REQUEST['usuario'],
            'fecha_inicio' => $_REQUEST['fecha_inicio_amparo'],
            'fecha_final' => $_REQUEST['fecha_final_amparo'],
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
            'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
        );

        $cadenaSql = $this->miSql->getCadenaSql('editarAmparo', $datoAmparo);
      
        $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso",$datoAmparo,"editarAmparo");
        if ($resultado != false) {
            redireccion::redireccionar('actualizarAmparo', $datoAmparo);
            exit();
        } else {

            redireccion::redireccionar('noactualizarAmparo', $datoAmparo);
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