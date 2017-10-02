<?php

$ruta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

$host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/plugin/html2pfd/";

include ($ruta . "/plugin/html2pdf/html2pdf.class.php");

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class EnLetras {

    var $Void = "";
    var $SP = " ";
    var $Dot = ".";
    var $Zero = "0";
    var $Neg = "Menos";

    function ValorEnLetras($x, $Moneda) {
        $s = "";
        $Ent = "";
        $Frc = "";
        $Signo = "";

        if (floatVal($x) < 0)
            $Signo = $this->Neg . " ";
        else
            $Signo = "";

        if (intval(number_format($x, 2, '.', '')) != $x) // <- averiguar si tiene decimales
            $s = number_format($x, 2, '.', '');
        else
            $s = number_format($x, 0, '.', '');

        $Pto = strpos($s, $this->Dot);

        if ($Pto === false) {
            $Ent = $s;
            $Frc = $this->Void;
        } else {
            $Ent = substr($s, 0, $Pto);
            $Frc = substr($s, $Pto + 1);
        }

        if ($Ent == $this->Zero || $Ent == $this->Void)
            $s = "Cero ";
        elseif (strlen($Ent) > 7) {
            $s = $this->SubValLetra(intval(substr($Ent, 0, strlen($Ent) - 6))) . "Millones " . $this->SubValLetra(intval(substr($Ent, - 6, 6)));
        } else {
            $s = $this->SubValLetra(intval($Ent));
        }

        if (substr($s, - 9, 9) == "Millones " || substr($s, - 7, 7) == "Millón ")
            $s = $s . "de ";

        $s = $s . $Moneda;

        if ($Frc != $this->Void) {
            $s = $s . " Con " . $this->SubValLetra(intval($Frc)) . "Centavos";
            // $s = $s . " " . $Frc . "/100";
        }
        return ($Signo . $s . "");
    }

    function SubValLetra($numero) {
        $Ptr = "";
        $n = 0;
        $i = 0;
        $x = "";
        $Rtn = "";
        $Tem = "";

        $x = trim("$numero");
        $n = strlen($x);

        $Tem = $this->Void;
        $i = $n;

        while ($i > 0) {
            $Tem = $this->Parte(intval(substr($x, $n - $i, 1) . str_repeat($this->Zero, $i - 1)));
            If ($Tem != "Cero")
                $Rtn .= $Tem . $this->SP;
            $i = $i - 1;
        }

        // --------------------- GoSub FiltroMil ------------------------------
        $Rtn = str_replace(" Mil Mil", " Un Mil", $Rtn);
        while (1) {
            $Ptr = strpos($Rtn, "Mil ");
            If (!($Ptr === false)) {
                If (!(strpos($Rtn, "Mil ", $Ptr + 1) === false))
                    $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr);
                else
                    break;
            } else
                break;
        }

        // --------------------- GoSub FiltroCiento ------------------------------
        $Ptr = - 1;
        do {
            $Ptr = strpos($Rtn, "Cien ", $Ptr + 1);
            if (!($Ptr === false)) {
                $Tem = substr($Rtn, $Ptr + 5, 1);
                if ($Tem == "M" || $Tem == $this->Void)
                    ;
                else
                    $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr);
            }
        } while (!($Ptr === false));

        // --------------------- FiltroEspeciales ------------------------------
        $Rtn = str_replace("Diez Un", "Once", $Rtn);
        $Rtn = str_replace("Diez Dos", "Doce", $Rtn);
        $Rtn = str_replace("Diez Tres", "Trece", $Rtn);
        $Rtn = str_replace("Diez Cuatro", "Catorce", $Rtn);
        $Rtn = str_replace("Diez Cinco", "Quince", $Rtn);
        $Rtn = str_replace("Diez Seis", "Dieciseis", $Rtn);
        $Rtn = str_replace("Diez Siete", "Diecisiete", $Rtn);
        $Rtn = str_replace("Diez Ocho", "Dieciocho", $Rtn);
        $Rtn = str_replace("Diez Nueve", "Diecinueve", $Rtn);
        $Rtn = str_replace("Veinte Un", "Veintiun", $Rtn);
        $Rtn = str_replace("Veinte Dos", "Veintidos", $Rtn);
        $Rtn = str_replace("Veinte Tres", "Veintitres", $Rtn);
        $Rtn = str_replace("Veinte Cuatro", "Veinticuatro", $Rtn);
        $Rtn = str_replace("Veinte Cinco", "Veinticinco", $Rtn);
        $Rtn = str_replace("Veinte Seis", "Veintiseís", $Rtn);
        $Rtn = str_replace("Veinte Siete", "Veintisiete", $Rtn);
        $Rtn = str_replace("Veinte Ocho", "Veintiocho", $Rtn);
        $Rtn = str_replace("Veinte Nueve", "Veintinueve", $Rtn);

        // --------------------- FiltroUn ------------------------------
        If (substr($Rtn, 0, 1) == "M")
            $Rtn = "Un " . $Rtn;
        // --------------------- Adicionar Y ------------------------------
        for ($i = 65; $i <= 88; $i ++) {
            If ($i != 77)
                $Rtn = str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
        }
        $Rtn = str_replace("*", "a", $Rtn);
        return ($Rtn);
    }

    function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) {
        $x = substr($x, 0, $Ptr) . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
    }

    function Parte($x) {
        $Rtn = '';
        $t = '';
        $i = '';
        Do {
            switch ($x) {
                Case 0 :
                    $t = "Cero";
                    break;
                Case 1 :
                    $t = "Un";
                    break;
                Case 2 :
                    $t = "Dos";
                    break;
                Case 3 :
                    $t = "Tres";
                    break;
                Case 4 :
                    $t = "Cuatro";
                    break;
                Case 5 :
                    $t = "Cinco";
                    break;
                Case 6 :
                    $t = "Seis";
                    break;
                Case 7 :
                    $t = "Siete";
                    break;
                Case 8 :
                    $t = "Ocho";
                    break;
                Case 9 :
                    $t = "Nueve";
                    break;
                Case 10 :
                    $t = "Diez";
                    break;
                Case 20 :
                    $t = "Veinte";
                    break;
                Case 30 :
                    $t = "Treinta";
                    break;
                Case 40 :
                    $t = "Cuarenta";
                    break;
                Case 50 :
                    $t = "Cincuenta";
                    break;
                Case 60 :
                    $t = "Sesenta";
                    break;
                Case 70 :
                    $t = "Setenta";
                    break;
                Case 80 :
                    $t = "Ochenta";
                    break;
                Case 90 :
                    $t = "Noventa";
                    break;
                Case 100 :
                    $t = "Cien";
                    break;
                Case 200 :
                    $t = "Doscientos";
                    break;
                Case 300 :
                    $t = "Trescientos";
                    break;
                Case 400 :
                    $t = "Cuatrocientos";
                    break;
                Case 500 :
                    $t = "Quinientos";
                    break;
                Case 600 :
                    $t = "Seiscientos";
                    break;
                Case 700 :
                    $t = "Setecientos";
                    break;
                Case 800 :
                    $t = "Ochocientos";
                    break;
                Case 900 :
                    $t = "Novecientos";
                    break;
                Case 1000 :
                    $t = "Mil";
                    break;
                Case 1000000 :
                    $t = "Millón";
                    break;
            }

            If ($t == $this->Void) {
                $i = $i + 1;
                $x = $x / 1000;
                If ($x == 0)
                    $i = 0;
            } else
                break;
        } while ($i != 0);

        $Rtn = $t;
        Switch ($i) {
            Case 0 :
                $t = $this->Void;
                break;
            Case 1 :
                $t = " Mil";
                break;
            Case 2 :
                $t = " Millones";
                break;
            Case 3 :
                $t = " Billones";
                break;
        }
        return ($Rtn . $t);
    }

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

    function documento() {

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);

        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);

        $directorio = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque');


        //-------------- Se accede al Servicio de Agora para Consultar el Proveedor de la Orden de Compra -------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------------               
        $datosContrato = array(
            0 => $_REQUEST ['numero_contrato'],
            1 => $_REQUEST ['vigencia'],
            'numero_contrato' => $_REQUEST ['numero_contrato'],
            'vigencia' => $_REQUEST ['vigencia']
        );


        $sqlConsecutivo_unico_contrato = $this->miSql->getCadenaSql('consultarConsecutivoUnicoSuscrito', $datosContrato);
        $consecutivo_unico_contrato = $esteRecursoDB->ejecutarAcceso($sqlConsecutivo_unico_contrato, "busqueda");

        // Obtiene las Polizas Asociadas Al contrato
        $cadenaSql = $this->miSql->getCadenaSql('obtenerPolizasActivas', $datosContrato);
        $polizas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $numero_poliza = "";
        $aseguradoras = "";
        $amparos = [];
        $usuarios = "";

        for ($i = 0; $i < count($polizas); $i++) {

            $cadenaSqlelaboro = $this->miSql->getCadenaSql('obtenerInformacionElaborador', $polizas[$i]['usuario']);

            $usuario = $DBFrameWork->ejecutarAcceso($cadenaSqlelaboro, "busqueda");

            $usuarios = $usuarios .
                    "<table align='justify' style='width:100%;' >                   
                    <tr>
                        <td style='width:100%;text-align:left;height: 20px'>Elaborado por </td>	
                    </tr>
                     <tr>
                        <td style='width:100%;text-align:left;'>Firma ___________________________</td>	
                    </tr>
                     <tr>
                        <td style='width:100%;text-align:left;'>Nombre. " . strtoupper($usuario[0]['nombre']) . " " . strtoupper($usuario[0]['apellido']) . "</td>	
                    </tr>
                     <tr>
                        <td style='width:100%;text-align:left;'>Contratista Oficina Asesora Jurídica</td>	
                    </tr>
                                    
                     
                </table><br><br>";




            $numero_poliza = $numero_poliza . $polizas[$i]['numero_poliza'] . "<br>";
            $aseguradoras = $aseguradoras . $polizas[$i]['nombre_aseguradora'] . "<br>";
            $cadenaSql = $this->miSql->getCadenaSql('obtenerAmparosActivos', $polizas[$i]['id_poliza']);
            $amparosPoliza = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
            if ($amparosPoliza) {
                $amparos = array_merge($amparos, $amparosPoliza);
            }
        }


        $cadenaSql = $this->miSql->getCadenaSql('Consultar_Info_Suscripcion', $datosContrato);
        $infoSuscripcion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $infoSuscripcion = $infoSuscripcion[0];

        $cadenaSql = $this->miSql->getCadenaSql('Consultar_Contrato_Particular', $datosContrato);
        $contrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $contrato = $contrato[0];


        $cadenaSql = $this->miSql->getCadenaSql('ConsultarDescripcionParametro', $contrato['tipologia_contrato']);
        $tipoContrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
       
        $cadenaSql = $this->miSql->getCadenaSql('ConsultarTipoContrato', $contrato['tipo_contrato']);
        
        $tipoContrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
        $cadenaSql = $this->miSql->getCadenaSql('obtenerInfoProveedor', $contrato['contratista']);

        $contratista = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
        $contratista = $contratista[0];

        if ($contratista['tipopersona'] = "NATURAL") {
            $contratista = $contratista['nom_proveedor'] . "<br><b> DOCUMENTO: " . $contratista['num_documento'] . "</b>";
        } else {
            $contratista = $contratista['nom_proveedor'] . "<br><b> NIT: " . $contratista['num_documento'] . "</b>";
        }

        $funcionLetras = new EnLetras ();

        $Letras = $funcionLetras->ValorEnLetras($contrato['valor_contrato'], ' Pesos ');

        $valorContrato = $Letras . "($" . number_format($contrato['valor_contrato'], 2, ",", ".") . ")";


        if ($contrato ['unidad_ejecucion'] == '205') {
            $meses = $contrato['plazo_ejecucion'] / 30;
            if ($meses > 1) {
                $meses = floor($meses);
                $parcial = $meses * 30;
                $dias = $contrato['plazo_ejecucion'] - $parcial;
                $plazo = $meses . " mes(es) y " . $dias . " dia(s) ";
            } else {
                $plazo = $contrato['plazo_ejecucion'] . " dia(s) ";
            }
        } elseif ($contrato ['unidad_ejecucion'] == '206') {
            $plazo = $contrato['plazo_ejecucion'] . " Mes(es) ";
        } else {
            $meses = $contrato['plazo_ejecucion'] * 12;
            $plazo = $meses . " mes(es) ";
        }


        $plazoEjecucion = $plazo;

        $fechaSucripcion = explode("-", $infoSuscripcion['fecha_suscripcion']);
        setlocale(LC_TIME, "es_ES.UTF-8");
        $fechaSucripcion = strftime("%A, %d de %B de %Y", gmmktime(12, 0, 0, $fechaSucripcion[1], $fechaSucripcion[2], $fechaSucripcion[0]));

        $sqlfechaMaximaAprobacion = $this->miSql->getCadenaSql('obtenerFechaAprobacionMaximaPolizasActivas', $datosContrato);
        $fechaMaximaAprobacion = $esteRecursoDB->ejecutarAcceso($sqlfechaMaximaAprobacion, "busqueda");

        if ($fechaMaximaAprobacion == false || $fechaMaximaAprobacion[0][0] == null) {

            $fechaMaximaAprobacion = "(NO APLICA - MIENTRAS NO EXISTAN POLIZAS REGISTRADAS)";
        } else {

            $fechaMaximaAprobacion = explode("-", $fechaMaximaAprobacion[0]['fecha_aprobacion']);
            $fechaMaximaAprobacion = strftime("%A, %d de %B de %Y", gmmktime(12, 0, 0, $fechaMaximaAprobacion[1], $fechaMaximaAprobacion[2], $fechaMaximaAprobacion[0]));
        }

        $cadenaMinimoVigente = $this->miSql->getCadenaSql("obtenerMinimoVigente", date("Y"));
        $minimoVigente = $esteRecursoDB->ejecutarAcceso($cadenaMinimoVigente, "busqueda");



        if (is_numeric($_REQUEST['tamanoletra']) && $_REQUEST['tamanoletra'] != null) {
            $letra = $_REQUEST['tamanoletra'];
        } else {
            $letra = 10;
        }



        $contenidoPagina = "
<style type=\"text/css\">
    table.main { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
	border: 0.5px solid black;	
        
    }
    
    td {
        background: #FAFAFA; /* Lighter grey background */
        text-align: left;
        font-size:" . $letra . "px
    }
   
    table.mainamparo { 
        border-collapse: collapse;
        border: 1px solid black;
        
    }
    td.mainamparo { 
         border: 1px solid black;
        
    }

   col{
	width=50%;
	
	}			
				
    th {
        background: #F3F3F3; /* Light grey background */
        font-weight: bold; /* Make sure they're bold */
        text-align: center;
        font-size:" . $letra . "px
    }

    
    td.main1 {
        border: 0.5px solid black;
        border-bottom: 0px;
        border-right: 0px;
        border-top: 0px;
    }
    td.main2 {
        border: 0.5px solid black;
        border-bottom: 0px;
        border-left: 0px;
        border-top: 0px;
    }
    td.main3 {
        border: 0.5px solid black;
        border-left: 0px;
        border-top: 0px;
        border-right: 0px;
        height='100'

    }
    td.main4 {
        border: 0.5px solid black;
        border-left: 0px;
        border-top: 0px;
        border-bottom: 0px;
    }
    td.main5 {
        border: 0.5px solid black;
        border-left: 0px;
        border-top: 0px;
        border-bottom: 0px;
        border-right: 0px;
    }
</style>				
				
				
<page backtop='5mm' backbottom='5mm' backleft='10mm' backright='10mm'>
	

        <table class='main' align='center' style='width:100%;' >
           
            <tr>
                <td class='main2' style='width:20%;text-align:justify;' >
                    <img src='" . $directorio . "/css/images/escudoud.png'  width='100' height='100'>
                </td>
                <td class='main4' style='width:30%;text-align:justify;' >
                    <table align='center' style='width:100%;' >
                        <tr>
                            <td class='main3' style='width:100%;text-align:center;height: 30px;' >
                                 <font size='5px'>ACTA DE APROBACIÓN DE PÓlIZA</font>
                            </td>
                        </tr>
                        <tr>
                            <td class='main3' style='width:100%;text-align:center;height: 30px;' >
                                <font size='5px'>Macroproceso: Gestión Administrativa y Contratación</font>
                            </td>
                        </tr>    
                        <tr>
                            <td class='main5' style='width:100%;text-align:center;height: 30px;' >
                                 <font size='5px'>Proceso: Gestión Jurídica</font>
                            </td>
                        </tr>
                       
                    </table>
                </td>
                <td   style='width:25%;text-align:justify;' >
                   <table align='center' style='width:100%;' >
                        <tr>
                            <td class='main3' style='width:100%;text-align:justify;height: 30px' >
                                 <font size='3px'>Código: GJ-PR-001-FR-001</font>
                            </td>
                        </tr>
                        <tr>
                            <td class='main3' style='width:100%;text-align:justify;height: 30px' >
                                <font size='3px'>Versión: 01</font>
                            </td>
                        </tr>    
                        <tr>
                            <td class='main5' style='width:100%;text-align:justify;height: 30px' >
                                 <font size='3px'>Fecha de Aprobación: 20/0314</font>
                            </td>
                        </tr>
                       
                    </table>
                </td>
                <td class='main1' style='width:25%;text-align:justify;' >
                    <img src='" . $directorio . "/css/images/sigud.jpg'  width='100' height='100'>
                </td>
                                          
            </tr>
           
        </table><br><br>";


        $contenidoPagina .=

                "<table align='justify' style='width:100%;' >                   
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Número de Contrato.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>" . $tipoContrato[0][0] . " No. " . $consecutivo_unico_contrato[0]['numero_contrato_suscrito'] . "</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Fecha Suscripción.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>" . $fechaSucripcion . "</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Contratante.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>Universidad Distrital Fransisco José de Caldas</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Contratista.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>$contratista</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td class= 'objeto' style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Objeto.</b></font></td>	
                        <td class= 'objeto' style='width:55%;text-align:justify;height: 30px'><font size='1px'>" . $contrato['objeto_contrato'] . "</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Compañia(s) Aseguradora(s).</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>" . $aseguradoras . "</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Número de Poliza</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'><b>" . $numero_poliza . "</b></font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Valor Contrato.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>" . $valorContrato . "</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Plazo de Ejecución.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'>" . $plazoEjecucion . "</font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                     <tr>
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                        <td style='width:35%;text-align:justify;height: 30px'><font size='3px'><b>Amparos y Vigencias.</b></font></td>	
                        <td style='width:55%;text-align:justify;height: 30px'><font size='3px'></font></td>	
                        <td style='width:5%;text-align:left;height: 30px'></td>	
                    </tr>
                </table>";



        if ($amparos) {


            $contenidoPagina .= "
		<table class='mainamparo' style='width:100%;'>
		<tr>
		<td class='mainamparo' style='width:60%;text-align=center;'>AMPAROS</td>
		<td class='mainamparo' style='width:20%;text-align=center;'>VIGENCIA</td>
		</tr>
		</table>
		<table class='mainamparo' style='width:100%;'>
		<tr>
		<td class='mainamparo' style='width:15%;text-align=center;'>Tipo de Amparo</td>
		<td class='mainamparo' style='width:15%;text-align=center;'>Valor Unidad</td>
		<td class='mainamparo' style='width:15%;text-align=center;'>Unidad</td>
		<td class='mainamparo' style='width:15%;text-align=center;'>Valor Asegurado</td>
		<td class='mainamparo' style='width:10%;text-align=center;'>Fecha Inicial</td>
		<td class='mainamparo' style='width:10%;text-align=center;'>Fecha Final</td>
		<td class='mainamparo' style='width:20%;text-align=center;'>Numero Poliza</td>
		</tr>
		</table>
		<table class='mainamparo' style='width:100%;'>";


            foreach ($amparos as $valor => $item) {
                $contenidoPagina .= "<tr>";
                $contenidoPagina .= "<td class='mainamparo' style='width:15%;text-align=justify;'>" . $item['nombre_amparo'] . "</td>";
                if ($item['tipo_valor_amparo'] == 1) {
                    $titulo = "Porcentaje %";
                    $valor = number_format(($item ['unidad_amparo'] * $contrato['valor_contrato']) / 100, 2, ",", ".");
                } else {
                    $titulo = "SMLV";
                    $valor = number_format($item ['unidad_amparo'] * $minimoVigente[0][0], 2, ",", ".");
                }
                $contenidoPagina .= "<td class='mainamparo' style='width:15%;text-align=center;'>" . $titulo . "</td>";
                $contenidoPagina .= "<td class='mainamparo' style='width:15%;text-align=center;'>" . $item ['unidad_amparo'] . "</td>";
                $contenidoPagina .= "<td class='mainamparo' style='width:15%;text-align=center;'>$" . $valor . "</td>";
                $contenidoPagina .= "<td class='mainamparo' style='width:10%;text-align=center;'> " . $item ['fecha_inicio'] . "</td>";
                $contenidoPagina .= "<td class='mainamparo' style='width:10%;text-align=center;'>" . $item ['fecha_final'] . "</td>";
                $contenidoPagina .= "<td class='mainamparo' style='width:20%;text-align=center;'> " . $item ['numero_poliza'] . "</td>";
                $contenidoPagina .= "</tr>";
            }

            $contenidoPagina .= "</table><br>";
        }



        $contenidoPagina .=

                "<table align='justify' style='width:100%;' >                   
                     <tr>
                        <td style='width:20%;text-align:left;height: 30px'></td>	
                        <td style='width:25%;text-align:justify;height: 30px'><font size='3px'><b>Certificado de pago:</b></font></td>	
                        <td style='width:25%;text-align:justify;height: 30px'><font size='3px'>Si_____  No_____</font></td>	
                        <td style='width:30%;text-align:left;height: 30px'></td>	
                    </tr>
                                    
                     <tr>
                        <td style='width:20%;text-align:left;height: 30px'></td>	
                        <td style='width:25%;text-align:justify;height: 30px'><font size='3px'><b>Firma de las partes:</b></font></td>	
                        <td style='width:25%;text-align:justify;height: 30px'><font size='3px'>Si_____  No_____</font></td>	
                        <td style='width:30%;text-align:left;height: 30px'></td>	
                    </tr>
                    
                                    
                     
                </table><br><br>";
        $contenidoPagina .=

                "<table align='justify' style='width:100%;' >                   
                     <tr>
                        <td style='width:100%;text-align:justify;'>SE  APRUEBA  LA  PÓLIZA  POR  ENCONTRARSE  DE  CONFORMIDAD  
                        CON LOS REQUERIMIENTOS CONTRACTUALES. </td>	
                    </tr>
                    </table>
                    <br>
                    <table align='justify' style='width:100%;' > 
                     <tr>
                        <td style='width:100%;text-align:justify;'>NOTA. De conformidad con la Resolución No. 629 de 
                        2016 artículo 8° - numeral 1. Objetivos de la Interventoría y Supervisión. Tendrá como 
                        objetivo corroborar la vigencia del contrato y las pólizas asociadas. <br> </td>	
                    </tr>
                    </table>
                    <br>
                    <table align='justify' style='width:100%;' > 
                     <tr>
                     <td style='width:100%;text-align:justify;'>Se firma la presente aprobación en Bogotá, el " . $fechaMaximaAprobacion . "    . </td>	
                    </tr>
                     </table>
                     <br>
                    <table align='justify' style='width:100%;' > 
                   <tr>
                        <td style='width:100%;text-align:left;'>Aprobado por: </td>	
                    </tr>
                     <tr>
                        <td style='width:100%;text-align:left;height: 20px'>________________________________________ </td>	
                    </tr>
                     <tr>
                        <td style='width:100%;text-align:left;'>CARLOS ARTURO QUINTANA ASTRO</td>	
                    </tr>
                     <tr>
                        <td style='width:100%;text-align:left;'>Jefe Oficina Asesora Jurídica</td>	
                    </tr>
                    
                                    
                     
                </table><br><br>";
        $contenidoPagina .= $usuarios;
        $contenidoPagina .= "<page_footer  backleft='10mm' backright='10mm'>
				
			
			<table style='width:100%;'>		
                      <tr>
            <td align='center' style='width:88%;' ><
                    <font size='9px'><b>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS </b></font>
                     <br>
                    <font size='7px'><b>NIT: 899.999.230-7</b></font>
                     <br>
                    <font size='3px'>CARRERA 7 No. 40-53 PISO 7. TELEFONO 3239300 EXT. 2609 -2605</font>
                     <br>		
                    <font size='5px'>www.udistrital.edu.co</font>
                     <br>
                    <font size='4px'>" . date("Y-m-d") . "</font>
                </td>
            </tr>
			</table>
			</page_footer></page> ";

        return $contenidoPagina;
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$textos = $miRegistrador->documento();
ob_start();
$html2pdf = new \HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8');
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->WriteHTML($textos);

$html2pdf->Output("Documento" . '.pdf', 'D');
?>





