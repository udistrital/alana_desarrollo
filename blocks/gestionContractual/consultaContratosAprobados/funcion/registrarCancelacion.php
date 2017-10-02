<?php

use gestionContractual\consultaContratosAprobados\funcion\redireccion;

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
        $datosCancelacion = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'fecha_cancelacion' => $_REQUEST['fecha_cancelacion'],
            'fecha_registo' => date("Y-m-d"),
            'motivo_cancelacion' => $_REQUEST['motivo_cancelacion'],
            'usuario' => $_REQUEST['usuario'],
            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
        );


        $cadenaSql['sql'] = $this->miSql->getCadenaSql('registroCancelacion', $datosCancelacion);
        $cadenaSql['descripcion'] = 'cancelarContrato';
        $cadenaSql['valores'] = $datosCancelacion;
        array_push($SQLs, $cadenaSql);


        $datosEstado = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'fecha' => date('Y-m-d H:i:s'),
            'usuario' => $_REQUEST['usuario'],
            'estado' => 7
        );

        $SQLsEstadoContratoGeneral['sql'] = $this->miSql->getCadenaSql('insertarEstadoActaContratoGeneral', $datosEstado);
        $SQLsEstadoContratoGeneral['descripcion'] = 'cambiareestadoCancelado';
        $SQLsEstadoContratoGeneral['valores'] = $datosEstado;
        array_push($SQLs, $SQLsEstadoContratoGeneral);
       
        $trans_Registro_Cancelacion = $esteRecursoDB->transaccion($SQLs);

        if ($trans_Registro_Cancelacion != false) {
            $this->miConfigurador->setVariableConfiguracion("cache", true);
            redireccion::redireccionar('registroCancelacion', $datosCancelacion);
            exit();
        } else {

            redireccion::redireccionar('noregistroCancelacion', $datosCancelacion);
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
?><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

