<?php

namespace gestionCompras\novedadOrden\registrarNovedadOrden;

use gestionCompras\novedadOrden\registrarNovedadOrden\funcion;

// include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorContrato {

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

        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionCompras/novedadOrden/";
        $rutaBloque .= $esteBloque ['nombre'];
        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . $rutaBloque;
        $SQls = [];

        foreach ($_FILES as $key => $values) {
            $archivo = $_FILES [$key];
        }

        $acceptedFormats = array('pdf', 'png', 'jpg', 'doc', 'docx', 'xls', 'csv');

        if (!in_array(pathinfo($archivo['name'], PATHINFO_EXTENSION), $acceptedFormats)) {
            $estado = false;
        } elseif ($archivo['size'] > 262144000) {
            $estado = false;
        } else {

            if ($archivo ['name'] != '') {
                // obtenemos los datos del archivo
                $tamano = $archivo ['size'];
                $tipo = $archivo ['type'];
                $archivo1 = $archivo ['name'];
                $prefijo = substr(md5(uniqid(rand())), 0, 6);

                if ($archivo1 != "") {
                    // guardamos el archivo a la carpeta files
                    $destino1 = $rutaBloque . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
                    if (copy($archivo ['tmp_name'], $destino1)) {
                        $status = "Archivo subido: <b>" . $archivo1 . "</b>";
                        $destino1 = $host . "/archivoSoporte/" . $prefijo . "_" . $archivo1;

                        $estado = true;
                    } else {
                        $estado = FALSE;
                    }
                } else {
                    $estado = FALSE;
                }
            } else {
                $estado = FALSE;
            }

            if ($estado != FALSE) {

                $arreglo_novedad = array(
                    0 => $_REQUEST['tipo_novedad'],
                    1 => $_REQUEST['numero_contrato'],
                    2 => $_REQUEST['vigencia'],
                    3 => date('Y-m-d H:i:s'),
                    4 => $_REQUEST['usuario'],
                    5 => $_REQUEST['numero_acto'],
                    6 => $prefijo . "_" . $archivo1,
                    7 => $_REQUEST['observaciones'],
                );


                $cadenaSqlNovedad = $this->miSql->getCadenaSql('registroNovedadContractual', $arreglo_novedad);

                array_push($SQls, $cadenaSqlNovedad);
                if ($_REQUEST['tipo_modificacion'] == '262') {
                    if (!isset($_REQUEST['radioinput'])) {
                        redireccion::redireccionar("ErrorSeleccionNovedad");
                        exit();
                    }
                    $id_novedad = explode("-", $_REQUEST['radioinput'])[0];
                } else {
                    $id_novedad = 'null';
                    $_REQUEST['radioinput'] = "";
                }

                $arreglo_novedad_modificacion = array(
                    0 => "currval('novedad_contractual_id_seq')",
                    1 => $_REQUEST['tipo_modificacion'],
                    2 => $_REQUEST['razon_modificacion'],
                    3 => $id_novedad
                );

                $cadenaSqlNovedadModificacion = $this->miSql->getCadenaSql('registroNovedadModificacion', $arreglo_novedad_modificacion);
                array_push($SQls, $cadenaSqlNovedadModificacion);
                $trans_Registro_Novedad = $esteRecursoDB->transaccion($SQls);
            }
        }

        if (isset($trans_Registro_Novedad) && $trans_Registro_Novedad != false) {

            $cadenaObtenerIdModificacion = $this->miSql->getCadenaSql('obtenerIdModificacion');
            $idNovedadModificacion = $esteRecursoDB->ejecutarAcceso($cadenaObtenerIdModificacion, "busqueda");
            $datosContrato = array('numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'tipo_novedad' => $_REQUEST['tipo_novedad'],
                'acto_administrativo' => $_REQUEST['numero_acto'],
                'info_novedad' => $_REQUEST['radioinput'],
                'id_orden' => $_REQUEST['id_orden'],
                'idnovedadModificacion' => $idNovedadModificacion[0][0],
                'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                'mensaje_titulo' => $_REQUEST['mensaje_titulo'],);

            if ($_REQUEST['tipo_modificacion'] == '262') {
                redireccion::redireccionar("novedadModificacionNovedad", $datosContrato);
            } else {
                redireccion::redireccionar("novedadModificacionContrato", $datosContrato);
            }

            exit();
        } else {
            redireccion::redireccionar("ErrorRegistro", $datosContrato);
            exit();
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>