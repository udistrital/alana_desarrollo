<?php

namespace gestionCompras\consultaOrden\funcion;

use gestionCompras\consultaOrden\funcion\redireccion;

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
        $SQLs = [];

        if (isset($_REQUEST['multiple']) && $_REQUEST['multiple'] = "true") {
            $datos = stripslashes($_REQUEST['datos']);
            $datos = urldecode($datos);
            $datos = unserialize($datos);
            for ($i = 0; $i < count($datos); $i++) {


                $SQLs = [];

                $SQLObtenerNumeroContrato = $this->miSql->getCadenaSql('obtenerNumeroMaximoContratoVigencia', date("Y"));
                $numeroVigenciaActual = $esteRecursoDB->ejecutarAcceso($SQLObtenerNumeroContrato, "busqueda");
                if ($numeroVigenciaActual[0][0] == null) {
                    $numeroContratoSuscrito = 1;
                } else {
                    $numeroContratoSuscrito = (int) $numeroVigenciaActual[0][0] + 1;
                }

                $datosAprobacion = array(
                    'numero_contrato' => $datos[$i]['numero_contrato'],
                    'vigencia' => $datos[$i]['vigencia'],
                    'fecha_registro' => date("Y-m-d"),
                    'usuario' => $_REQUEST['usuario'],
                    'fecha_suscripcion' => $_REQUEST['fecha_suscripcion'],
                    'numero_contrato_suscrito' => $numeroContratoSuscrito
                );
                $datosestado = array(
                    'numero_contrato' => $datos[$i]['numero_contrato'],
                    'vigencia' => $datos[$i]['vigencia'],
                    'fecha_registro' => date('Y-m-d H:i:s'),
                    'usuario' => $_REQUEST['usuario'],
                    'estado' => 3
                );

                $SQLAprobarContrato['sql'] = $this->miSql->getCadenaSql('aprobarContrato', $datosAprobacion);
                $SQLAprobarContrato['descripcion'] = 'suscribircontrato';
                $SQLAprobarContrato['valores'] = $datosAprobacion;
                array_push($SQLs, $SQLAprobarContrato);

                $SQLEstadoContrato['sql'] = $this->miSql->getCadenaSql('cambioEstadoAprobarContrato', $datosestado);
                $SQLEstadoContrato['descripcion'] = 'cambioEstadoContrato';
                $SQLEstadoContrato['valores'] = $datosAprobacion;
                array_push($SQLs, $SQLEstadoContrato);

                $trans_aprobar_contratos = $esteRecursoDB->transaccion($SQLs);

                if ($trans_aprobar_contratos == false) {
                    array_push($datos, $_REQUEST['fecha_suscripcion']);
                    redireccion::redireccionar('noAproboContratos', $datos);
                }
                $datos[$i]['numero_contrato_suscrito'] = $numeroContratoSuscrito;
            }

            array_push($datos, $_REQUEST['fecha_suscripcion']);
            redireccion::redireccionar('aproboContratos', $datos);
        } else {
            $SQLs = [];
            $datos = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'fecha_suscripcion' => $_REQUEST['fecha_suscripcion']
            );

            $SQLObtenerNumeroContrato = $this->miSql->getCadenaSql('obtenerNumeroMaximoContratoVigencia', date("Y"));
            $numeroVigenciaActual = $esteRecursoDB->ejecutarAcceso($SQLObtenerNumeroContrato, "busqueda");
            if ($numeroVigenciaActual[0][0] == null) {
                $numeroContratoSuscrito = 1;
            } else {
                $numeroContratoSuscrito = (INT) $numeroVigenciaActual[0][0] + 1;
            }

            $datosAprobacion = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'fecha_registro' => date("Y-m-d"),
                'usuario' => $_REQUEST['usuario'],
                'fecha_suscripcion' => $_REQUEST['fecha_suscripcion'],
                'numero_contrato_suscrito' => $numeroContratoSuscrito
            );


            $SQLAprobarContrato['sql'] = $this->miSql->getCadenaSql('aprobarContrato', $datosAprobacion);
            $SQLAprobarContrato['descripcion'] = 'suscribircontrato';
            $SQLAprobarContrato['valores'] = $datosAprobacion;
            array_push($SQLs, $SQLAprobarContrato);

            $datosEstadoContrato = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'fecha_registro' => date('Y-m-d H:i:s'),
                'usuario' => $_REQUEST['usuario'],
                'estado' => 3
            );

            $SQLEstadoContrato['sql'] = $this->miSql->getCadenaSql('cambioEstadoAprobarContrato', $datosEstadoContrato);
            $SQLEstadoContrato['descripcion'] = 'cambioEstadoContrato';
            $SQLEstadoContrato['valores'] = $datosAprobacion;
            array_push($SQLs, $SQLEstadoContrato);

            $trans_aprobar_contrato = $esteRecursoDB->transaccion($SQLs);

            if ($trans_aprobar_contrato != false) {
                redireccion::redireccionar('aproboContrato', $datosAprobacion);
            } else {
                redireccion::redireccionar('noAproboContrato', $datos);
            }
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