<?php

namespace gestionSociedadesTemporales\gestionSociedadesTemporales\funcion;

use gestionSociedadesTemporales\gestionSociedadesTemporales\funcion\redireccion;

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

        $conexion = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $cadenaSql = $this->miSql->getCadenaSql('obtenerEstadoSociedad', $_REQUEST ['id_sociedad']);
        $estadoActual = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
       
        if ($estadoActual[0]['estado'] == "t") {
            $nuevoEstado = 'f';
        } else {
            $nuevoEstado = 't';
        }

        $cadenaSql = $this->miSql->getCadenaSql('cambiarEstadoSociedad', array(0 => $nuevoEstado, 1 => $_REQUEST ['id_sociedad']));
        $resultado = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "acceso",array(0 => $nuevoEstado, 1 => $_REQUEST ['id_sociedad']),"cambioestadosociedad");
      
        $datos = array(
            0 => $nuevoEstado,
            1 => $_REQUEST ['id_sociedad'],
            'arreglo' => $_REQUEST['arreglo'],
            'tipopersona' => $estadoActual[0]['tipopersona'],
            'num_documento' => $estadoActual[0]['num_documento'],
            'nom_proveedor' => $estadoActual[0]['nom_proveedor'],
            'usuario' => $_REQUEST['usuario'],
        );
        if ($resultado != false) {
            redireccion::redireccionar('cambioEstado', $datos);
            exit();
        } else {

            redireccion::redireccionar('noCambioEstado', $datos);
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