<?php

use gestionCompras\consultaOrdenesAprobadas\funcion\redireccion;

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

        $datosRP = array(
            'numero_cdp' => explode("-", $_REQUEST['numero_disponibilidad_contrato'])[0],
            'vigencia_rp' => $_REQUEST['vigencia_rp_hidden'],
            'rp' => $_REQUEST['registro_presupuestal'],
            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
            'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
            'arreglo' => $_REQUEST['arreglo'],
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'usuario' => $_REQUEST['usuario']
        );

        $cadenaSql = $this->miSql->getCadenaSql('registroRp', $datosRP);
         $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso",$datosRP,"asocarRP");

        if ($resultado != false) {
            redireccion::redireccionar('registroRP', $datosRP);
            exit();
        } else {

            redireccion::redireccionar('noregistroRP', $datosRP);
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