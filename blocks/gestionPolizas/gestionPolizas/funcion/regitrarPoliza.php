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

        $cadenaSql = $this->miSql->getCadenaSql('obtenerMaxIdPoliza');
        $maxId = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $datosPoliza = array(
            'id_poliza' => $maxId[0][0] + 1,
            'descripcion' => $_REQUEST['descripcion_poliza'],
            'usuario' => $_REQUEST['usuario'],
            'numero_poliza' => $_REQUEST['numero_poliza'],
            'fecha_aprobacion' => $_REQUEST['fecha_aprobacion'],
            'entidad_aseguradora' => $_REQUEST['entidad_aseguradora'],
            'fecha_inicio' => $_REQUEST['fecha_inicio'],
            'fecha_final' => $_REQUEST['fecha_final'],
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
            'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
        );

        $cadenaSql = $this->miSql->getCadenaSql('insertarPoliza', $datosPoliza);
        $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso",$datosPoliza,"registroPoliza");
          
        if ($resultado != false) {
            redireccion::redireccionar('registroPoliza', $datosPoliza);
            exit();
        } else {

            redireccion::redireccionar('noregistroPoliza', $datosPoliza);
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