<?php

use gestionCompras\gestionOrdenesATC\funcion\redireccion;

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
        $SQls = [];

        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionCompras/";
        $rutaBloque .= $esteBloque ['nombre'];
        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . $rutaBloque;

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
        }
        if ($estado != FALSE) {
            $datosLiquidacion = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'numero_acto' => $_REQUEST['numero_acto'],
                'fecha_liquidacion' => $_REQUEST['fecha_liquidacion'],
                'observaciones' => $_REQUEST['observaciones'],
                'usuario' => $_REQUEST['usuario'],
                'fecha_registro' => date("Y-m-d"),
                'documento' => $prefijo . "_" . $archivo1,
                'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
            );

            $SqlregistroLiquidacion = $this->miSql->getCadenaSql('registrarLiquidacion', $datosLiquidacion);
            array_push($SQls, $SqlregistroLiquidacion);

            $datosEstado = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'fecha' => date('Y-m-d H:i:s'),
                'usuario' => $_REQUEST['usuario'],
                'estado' => 9
            );

            $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoNovedadContratoGeneral', $datosEstado);
            array_push($SQls, $SQLsEstadoContratoGeneral);


            $trans_Registro_Liquidacion = $esteRecursoDB->transaccion($SQls);
        } else {

            $datosLiquidacionError = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
            );

            redireccion::redireccionar('errorDocumentoLiquidacion', $datosLiquidacionError);
            exit();
        }


        if (isset($trans_Registro_Liquidacion) && $trans_Registro_Liquidacion != false) {
            redireccion::redireccionar('registroLiquidacion', $datosLiquidacion);
            exit();
        } else {
            $datosLiquidacionError = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
                'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
            );
            redireccion::redireccionar('noregistroLiquidacion', $datosLiquidacionError);
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