<?php

namespace gestionPolizas\gestionPolizas\funcion;

use gestionPolizas\gestionPolizas\funcion\redireccion;

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
        $datos_contrato = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'numero_contrato_suscrito' => $_REQUEST['numero_contrato_suscrito'],
            'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
            'id_poliza' => $_REQUEST['id_poliza'],
            'tipo_amparo_registro' => $_REQUEST['tipo_amparo_registro']
        );
        $infoRegistros = [];

        if ($_REQUEST['tipo_amparo_registro'] == '1') {


            for ($i = 0; $i < count($_POST); $i++) {
                if (isset($_POST["amparo$i"])) {
                    $datosAmparo = array(
                        'id_poliza' => $_REQUEST['id_poliza'],
                        'fecha_inicio' => $_POST["fechainiamparo$i"],
                        'fecha_final' => $_POST["fechafinamparo$i"],
                        'amparo' => $_POST["amparo$i"],
                        'valor' => $_POST["valoramparo$i"],
                        'unidad_amparo' => $_POST["porcentajeamparo$i"],
                        'tipo_unidad' => 1
                    );
                    array_push($infoRegistros, $datosAmparo);

                    $SQLsRegistrarAmparo['sql'] = $this->miSql->getCadenaSql('insertarAmparo', $datosAmparo);
                    $SQLsRegistrarAmparo['descripcion'] = 'registroamparo';
                    $SQLsRegistrarAmparo['valores'] = $datosAmparo;
                    array_push($SQLs, $SQLsRegistrarAmparo);
                }
            }
            array_push($infoRegistros, $datos_contrato);
        } else {

            $datosAmparo = array(
                'id_poliza' => $_REQUEST['id_poliza'],
                'fecha_inicio' => $_REQUEST["fecha_inicio_amparo"],
                'fecha_final' => $_REQUEST["fecha_final_amparo"],
                'amparo' => 10,
                'valor' => $_REQUEST["valor"],
                'unidad_amparo' => $_REQUEST["numero_minimos"],
                'tipo_unidad' => 2
            );
            $SQLsRegistrarAmparo['sql'] = $this->miSql->getCadenaSql('insertarAmparo', $datosAmparo);
            $SQLsRegistrarAmparo['descripcion'] = 'registroamparo';
            $SQLsRegistrarAmparo['valores'] = $datosAmparo;
            array_push($SQLs, $SQLsRegistrarAmparo);

            array_push($infoRegistros, $datosAmparo);
            array_push($infoRegistros, $datos_contrato);
        }

        $trans_Registro_Amparos = $esteRecursoDB->transaccion($SQLs);

        if ($trans_Registro_Amparos != false) {
            redireccion::redireccionar('registroAmparos', $infoRegistros);
            exit();
        } else {

            redireccion::redireccionar('noRegistroAmparos', $infoRegistros);
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