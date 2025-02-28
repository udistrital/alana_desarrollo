<?php

namespace gestionCompras\registrarElementoOrden\funcion;

use gestionCompras\registrarElementoOrden\funcion\redireccion;

$ruta_1 = $this->miConfigurador->getVariableConfiguracion('raizDocumento') . '/plugin/php_excel/Classes/PHPExcel.class.php';
$ruta_2 = $this->miConfigurador->getVariableConfiguracion('raizDocumento') . '/plugin/php_excel/Classes/PHPExcel/Reader/Excel2007.class.php';

include_once ($ruta_1);
include_once ($ruta_2);

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
        $fechaActual = date('Y-m-d');

        switch ($_REQUEST ['tipo_registro']) {

            case '1' :

                foreach ($_FILES as $key => $values) {

                    $archivo [] = $_FILES [$key];
                }

                $archivoImagen = $archivo [1];

                if ($archivoImagen ['error'] == 0) {

                    if ($archivoImagen ['type'] != 'image/jpeg') {

                        redireccion::redireccionar('noFormatoImagen');
                        exit();
                    }
                }

                $cadenaSql = $this->miSql->getCadenaSql('consultar_iva', $_REQUEST ['iva']);

                $valor_iva = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                $valor_iva = $valor_iva [0] [0];


                if ($_REQUEST ['id_tipo_bien'] == 1) {

                    $arreglo = array(
                        'fechaActual'=>$fechaActual,
                        'nivel'=>$_REQUEST ['nivel'],
                        'tipoBien'=>$_REQUEST ['id_tipo_bien'],
                        'descripcion'=>$_REQUEST ['descripcion'],
                        'cantidad'=>$_REQUEST ['cantidad'],
                        'unidad'=>$_REQUEST ['unidad'],
                        'valor'=>$_REQUEST ['valor'],
                        'iva'=>$_REQUEST ['iva'],
                        'subtotal_sin_iva'=>$_REQUEST ['subtotal_sin_iva'],
                        'total_iva'=>$_REQUEST ['total_iva'],
                        'total_iva_con'=>$_REQUEST ['total_iva_con'],
                        'marca'=>($_REQUEST ['marca'] != '') ? $_REQUEST ['marca'] : null,
                        'serie'=>($_REQUEST ['serie'] != '') ? $_REQUEST ['serie'] : null,
                        'dependencia_solicitante'=>(isset($_REQUEST ['dependencia_solicitante'])) ? $_REQUEST ['dependencia_solicitante'] : null,
                        'funcionario'=>(isset($_REQUEST ['funcionario'])) ? $_REQUEST ['funcionario'] : null,
                        'numero_contrato'=>$_REQUEST ['numero_contrato'],
                        'vigencia'=>$_REQUEST ['vigencia'],
                    );

                    $cadenaSql = $this->miSql->getCadenaSql('ingresar_elemento_tipo_1', $arreglo);

                    $elemento = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ingresar_elemento_tipo_1');
                } else if ($_REQUEST ['id_tipo_bien'] == 2) {

                    $arreglo = array(
                        'fechaActual'=>$fechaActual,
                        'nivel'=>$_REQUEST ['nivel'],
                        'tipoBien'=>$_REQUEST ['id_tipo_bien'],
                        'descripcion'=>$_REQUEST ['descripcion'],
                        'cantidad'=>$_REQUEST ['cantidad'] = 1,
                        'unidad'=>$_REQUEST ['unidad'],
                        'valor'=>$_REQUEST ['valor'],
                        'iva'=>$_REQUEST ['iva'],
                        'subtotal_sin_iva'=>$_REQUEST ['subtotal_sin_iva'],
                        'total_iva'=>$_REQUEST ['total_iva'],
                        'total_iva_con'=>$_REQUEST ['total_iva_con'],
                        'marca'=>($_REQUEST ['marca'] != '') ? $_REQUEST ['marca'] : null,
                        'serie'=>($_REQUEST ['serie'] != '') ? $_REQUEST ['serie'] : null,
                        'dependencia_solicitante'=>(isset($_REQUEST ['dependencia_solicitante'])) ? $_REQUEST ['dependencia_solicitante'] : null,
                        'funcionario'=>(isset($_REQUEST ['funcionario'])) ? $_REQUEST ['funcionario'] : null,
                        'numero_contrato'=>$_REQUEST ['numero_contrato'],
                        'vigencia'=>$_REQUEST ['vigencia'],
                    );

                    $cadenaSql = $this->miSql->getCadenaSql('ingresar_elemento_tipo_1', $arreglo);

                    $elemento = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ingresar_elemento_tipo_1');
                } else if ($_REQUEST ['id_tipo_bien'] == 3) {


                    $arreglo = array(
                        'fechaActual'=>$fechaActual,
                        'nivel'=>$_REQUEST ['nivel'],
                        'tipoBien'=>$_REQUEST ['id_tipo_bien'],
                        'descripcion'=>$_REQUEST ['descripcion'],
                        'cantidad'=>$_REQUEST ['cantidad'] = 1,
                        'unidad'=>$_REQUEST ['unidad'],
                        'valor'=>$_REQUEST ['valor'],
                        'iva'=>$_REQUEST ['iva'],
                        'subtotal_sin_iva'=>$_REQUEST ['subtotal_sin_iva'],
                        'total_iva'=>$_REQUEST ['total_iva'],
                        'total_iva_con'=>$_REQUEST ['total_iva_con'],
                        'marca'=>($_REQUEST ['marca'] != '') ? $_REQUEST ['marca'] : NULL,
                        'serie'=>($_REQUEST ['serie'] != '') ? $_REQUEST ['serie'] : NULL,
                        'dependencia_solicitante'=>(isset($_REQUEST ['dependencia_solicitante'])) ? $_REQUEST ['dependencia_solicitante'] : null,
                        'funcionario'=>(isset($_REQUEST ['funcionario'])) ? $_REQUEST ['funcionario'] : null,
                        'numero_contrato'=>$_REQUEST ['numero_contrato'],
                        'vigencia'=>$_REQUEST ['vigencia'],
                    );

                    $cadenaSql = $this->miSql->getCadenaSql('ingresar_elemento_tipo_2', $arreglo);
                    $elemento = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ingresar_elemento_tipo_2');
                }



                $datos = array(
                    $_REQUEST ['mensaje_titulo'],
                    $_REQUEST ['numero_contrato'],
                    $fechaActual,
                    (!isset($_REQUEST ['registroOrden'])) ? $_REQUEST ['arreglo'] : $_REQUEST ['registroOrden'],
                    $_REQUEST ['usuario'],
                    $_REQUEST ['numero_contrato'],
                    $_REQUEST ['vigencia'],
                );

                //
                foreach ($_FILES as $key) {

                    $archivo [] = $key;
                }

                $archivo = $archivo [1];

                if ($archivo ['type'] == 'image/jpeg') {

                    $data = base64_encode(file_get_contents($archivo ['tmp_name']));

                    $arreglo = array(
                        "elemento" => $elemento [0] [0],
                        "imagen" => $data
                    );

                    $cadenaSql = $this->miSql->getCadenaSql('ElementoImagen', $arreglo);

                    $imagen = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ElementoImagen');
                }


                if ($elemento) {
                    $this->miConfigurador->setVariableConfiguracion("cache", true);

                    redireccion::redireccionar("inserto", $datos);
                    exit();
                } else {

                    redireccion::redireccionar("noInserto", $datos);
                    exit();
                }

                break;
            case '2' : {

                    $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
                    // ** Ruta a directorio ******
                    $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionCompras/";
                    $rutaBloque .= $esteBloque ['nombre'];
                    $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/gestionCompras/" . $esteBloque ['nombre'];

                    $ingreso = 0;

                    $ruta_eliminar_xlsx = $rutaBloque . "/archivo/*.xlsx";

                    $ruta_eliminar_xls = $rutaBloque . "/archivo/*.xls";

                    foreach (glob($ruta_eliminar_xlsx) as $filename) {
                        unlink($filename);
                    }
                    foreach (glob($ruta_eliminar_xls) as $filename) {
                        unlink($filename);
                    }

                    foreach ($_FILES as $key => $values) {

                        $archivo [] = $_FILES [$key];
                    }

                    $archivo = $archivo [0];

                    $trozos = explode(".", $archivo ['name']);
                    $extension = end($trozos);
                    if ($extension == 'xlsx') {

                        if ($archivo) {
                            // obtenemos los datos del archivo
                            $tamano = $archivo ['size'];
                            $tipo = $archivo ['type'];
                            $archivo1 = $archivo ['name'];
                            $prefijo = "archivo";

                            if ($archivo1 != "") {
                                // guardamos el archivo a la carpeta files
                                $ruta_absoluta = $rutaBloque . "/archivo/" . $archivo1;
                                // echo $ruta_absoluta;exit;

                                if (copy($archivo ['tmp_name'], $ruta_absoluta)) {
                                    $status = "Archivo subido: <b>" . $archivo1 . "</b>";
                                } else {

                                    exit();
                                    redireccion::redireccionar('noArchivoCarga');
                                    exit();
                                }
                            } else {
                                exit();
                                redireccion::redireccionar('noArchivoCarga');
                                exit();
                            }
                        }

                        if (file_exists($ruta_absoluta)) {

                            // Cargando la hoja de cálculo

                            $objReader = new \PHPExcel_Reader_Excel2007 ();

                            $objPHPExcel = $objReader->load($ruta_absoluta);

                            $objFecha = new \PHPExcel_Shared_Date ();

                            // Asignar hoja de excel activa

                            $objPHPExcel->setActiveSheetIndex(0);

                            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                            
                            

                            $highestRow = $objWorksheet->getHighestRow();
                            $datos_enviar = array(
                                $_REQUEST ['mensaje_titulo'],
                                $_REQUEST ['numero_contrato'],
                                $fechaActual,
                                (!isset($_REQUEST ['registroOrden'])) ? $_REQUEST ['arreglo'] : $_REQUEST ['registroOrden']
                            );

                            for ($i = 2; $i <= $highestRow; $i ++) {

                                $datos [$i] ['Nivel'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                                if (is_null($datos [$i] ['Nivel']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }

                                $datos [$i] ['Tipo_Bien'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                                if (is_null($datos [$i] ['Tipo_Bien']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }
                                $datos [$i] ['Serie'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();

                                $datos [$i] ['Marca'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                             
                                $datos [$i] ['Descripcion'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                                if (is_null($datos [$i] ['Descripcion']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }
                                $datos [$i] ['Cantidad'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                                if (is_null($datos [$i] ['Cantidad']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }
                                $datos [$i] ['Unidad_Medida'] = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
                                if (is_null($datos [$i] ['Unidad_Medida']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }
                                $datos [$i] ['Valor_Precio'] = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                                if (is_null($datos [$i] ['Valor_Precio']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }
                                $datos [$i] ['Iva'] = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();

                                if (is_null($datos [$i] ['Iva']) == true) {

                                    redireccion::redireccionar('datosVacios', $datos_enviar);
                                    exit();
                                }
                                $datos [$i] ['Dependencia'] = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();

                                $datos [$i] ['Funcionario'] = $objPHPExcel->getActiveSheet()->getCell('Kz' . $i)->getCalculatedValue();
                            }

                            for ($i = 2; $i <= $highestRow; $i ++) {

                                switch ($datos [$i] ['Iva']) {

                                    case "1" :

                                        $IVA = 0;

                                        break;

                                    case "2" :

                                        $IVA = 0;

                                        break;

                                    case "3" :

                                        $IVA = 0.05;

                                        break;

                                    case "4" :

                                        $IVA = 0.04;

                                        break;

                                    case "5" :

                                        $IVA = 0.10;

                                        break;

                                    case "6" :

                                        $IVA = 0.16;

                                        break;
                                    case "7" :

                                        $IVA = 0.19;

                                        break;
                                    
                                }

                                if ($datos [$i] ['Tipo_Bien'] == 1) {

                                    $arreglo = array(
                                        'fechaActual'=>$fechaActual,
                                        'nivel'=>$datos [$i] ['Nivel'],
                                        'tipoBien'=>$datos [$i] ['Tipo_Bien'],
                                        'descripcion'=>trim($datos [$i] ['Descripcion'], "'"),
                                        'cantidad'=>$datos [$i] ['Cantidad'],
                                        'unidad'=>trim($datos [$i] ['Unidad_Medida'], "'"),
                                        'valor'=>$datos [$i] ['Valor_Precio'],
                                        'iva'=>$datos [$i] ['Iva'],
                                        'subtotal_sin_iva'=>$datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio'],
                                        'total_iva'=>$datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio'] * $IVA,
                                        'total_iva_con'=>($datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio'] * $IVA) + ($datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio']),
                                        'marca'=>(is_null($datos [$i] ['Marca']) == true) ? null : trim($datos [$i] ['Marca'], "'"),
                                        'serie'=>(is_null($datos [$i] ['Serie']) == true) ? null : trim($datos [$i] ['Serie'], "'"),
                                        'dependencia_solicitante'=>(is_null($datos [$i] ['Dependencia']) == true) ? null : trim($datos [$i] ['Dependencia'], "'"),
                                        'funcionario'=>(is_null($datos [$i] ['Funcionario']) == true) ? null : trim($datos [$i] ['Funcionario'], "'"),
                                        'numero_contrato'=>$_REQUEST ['numero_contrato'],
                                        'vigencia'=>$_REQUEST ['vigencia']
                                    );
                                    $cadenaSql = $this->miSql->getCadenaSql('ingresar_elemento_tipo_1', $arreglo);

                                    $elemento_id = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ingresar_elemento_tipo_1');
                                } else if ($datos [$i] ['Tipo_Bien'] == 2) {

                                    $arreglo = array(
                                        'fechaActual'=>$fechaActual,
                                        'nivel'=>$datos [$i] ['Nivel'],
                                        'tipoBien'=>$datos [$i] ['Tipo_Bien'],
                                        'descripcion'=>trim($datos [$i] ['Descripcion'], "'"),
                                        'cantidad'=>1,
                                        'unidad'=>trim($datos [$i] ['Unidad_Medida'], "'"),
                                        'valor'=>$datos [$i] ['Valor_Precio'],
                                        'iva'=>$datos [$i] ['Iva'],
                                        'subtotal_sin_iva'=>1 * $datos [$i] ['Valor_Precio'],
                                        'total_iva'=>1 * $datos [$i] ['Valor_Precio'] * $IVA,
                                        'total_iva_con'=>(1 * $datos [$i] ['Valor_Precio'] * $IVA) + (1 * $datos [$i] ['Valor_Precio']),
                                        'marca'=>(is_null($datos [$i] ['Marca']) == true) ? null : trim($datos [$i] ['Marca'], "'"),
                                        'serie'=>(is_null($datos [$i] ['Serie']) == true) ? null : trim($datos [$i] ['Serie'], "'"),
                                        'dependencia_solicitante'=> (is_null($datos [$i] ['Dependencia']) == true) ? null : trim($datos [$i] ['Dependencia'], "'"),
                                        'funcionario'=> (is_null($datos [$i] ['Funcionario']) == true) ? null : trim($datos [$i] ['Funcionario'], "'"),
                                        'numero_contrato'=>$_REQUEST ['numero_contrato'],
                                        'vigencia'=> $_REQUEST ['vigencia']
                                    );

                                    $cadenaSql = $this->miSql->getCadenaSql('ingresar_elemento_tipo_1', $arreglo);

                                    $elemento_id = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ingresar_elemento_tipo_1');
                                } else if ($datos [$i] ['Tipo_Bien'] == 3) {


                                    $arreglo = array(
                                        'fechaActual'=>$fechaActual,
                                        'nivel'=>$datos [$i] ['Nivel'],
                                        'tipoBien'=>$datos [$i] ['Tipo_Bien'],
                                        'descripcion'=>trim($datos [$i] ['Descripcion'], "'"),
                                        'cantidad'=>1,
                                        'unidad'=>trim($datos [$i] ['Unidad_Medida'], "'"),
                                        'valor'=>$datos [$i] ['Valor_Precio'],
                                        'iva'=>$datos [$i] ['Iva'],
                                        'subtotal_sin_iva'=>1 * $datos [$i] ['Valor_Precio'],
                                        'total_iva'=>1 * $datos [$i] ['Valor_Precio'] * $IVA,
                                        'total_iva_con'=>(1 * $datos [$i] ['Valor_Precio'] * $IVA) + (1 * $datos [$i] ['Valor_Precio']),
                                        'marca'=>(is_null($datos [$i] ['Marca']) == true) ? null : trim($datos [$i] ['Marca'], "'"),
                                        'serie'=>(is_null($datos [$i] ['Serie']) == true) ? null : trim($datos [$i] ['Serie'], "'"),
                                        'dependencia_solicitante'=>(is_null($datos [$i] ['Dependencia']) == true) ? null : trim($datos [$i] ['Dependencia'], "'"),
                                        'funcionario'=>(is_null($datos [$i] ['Funcionario']) == true) ? null : trim($datos [$i] ['Funcionario'], "'"),
                                        'numero_contrato'=>$_REQUEST ['numero_contrato'],
                                        'vigencia'=> $_REQUEST ['vigencia'],
                                    );


                                    $cadenaSql = $this->miSql->getCadenaSql('ingresar_elemento_tipo_1', $arreglo);
                                    $elemento_id = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $arreglo, 'ingresar_elemento_tipo_1');
                                }
                            }

                            foreach (glob($ruta_eliminar_xlsx) as $filename) {
                                unlink($filename);
                            }
                            foreach (glob($ruta_eliminar_xls) as $filename) {
                                unlink($filename);
                            }

                            $datos = array(
                                $_REQUEST ['mensaje_titulo'],
                                $_REQUEST ['numero_contrato'],
                                date('Y-m-d'),
                                (!isset($_REQUEST ['registroOrden'])) ? $_REQUEST ['arreglo'] : $_REQUEST ['registroOrden'],
                                $_REQUEST ['usuario']
                            );
                       
                            if ($elemento_id && $_REQUEST ['numero_contrato']) {
                                $this->miConfigurador->setVariableConfiguracion("cache", true);
                                redireccion::redireccionar('inserto_cargue_masivo', $datos);
                                exit();
                            } else {
                                redireccion::redireccionar('noInsertoMasivo', $datos);
                                exit();
                            }
                        }
                    } else {

                        redireccion::redireccionar('noExtension');
                        exit();
                    }
                }

                break;
        }
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>