<?php

namespace contratos\modificarContrato\funcion;

use contratos\modificarContrato\funcion\redireccion;

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
        // ------- Registro de Imagen
        $arreglo_info_servicio = array(
            'tipo_servicio' => $_REQUEST['codigo_ciiu'],
            'codigo_ciiu' => $_REQUEST['codigo_ciiu'],
            'nombre' => $_REQUEST['resumen_servicio'],
            'valor_servicio' => $_REQUEST['valor_servicio'],
            'descripcion_servicio' => $_REQUEST['descripcion_servicio'],
            'id_servicio' => $_REQUEST['id_servicio']
        );


        $cadenaSql = $this->miSql->getCadenaSql('actualizarServicio', $arreglo_info_servicio);

        $servicio = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso", $arreglo_info_servicio, "modificarservicio");

        if ($servicio) {
            redireccion::redireccionar('ActualizoServicio', $arreglo_info_servicio);
            exit();
        } else {
            redireccion::redireccionar('noActualizoServicio', $arreglo_info_servicio);
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