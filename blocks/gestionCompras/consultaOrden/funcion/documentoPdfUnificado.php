<?php

$ruta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

$host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/plugin/html2pfd/";

require_once ($ruta . "/plugin/mpdf/mpdf.php");

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


        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);

        $conexionCore = "core";
        $DBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);

        $directorio = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque');


        //-------------- Se accede al Servicio de Agora para Consultar el Proveedor de la Orden de Compra -------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
        $datosContrato = array(
            0 => $_REQUEST ['numero_contrato'],
            1 => $_REQUEST ['vigencia']
        );

        // Obtiene la  Toda la  Informacion de la tabla contrato general

        $cadenaSql = $this->miSql->getCadenaSql('infoContratoGeneralDocumento', $datosContrato);
        $contrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $contrato = $contrato[0];


        $cadenaSqlelaboro = $this->miSql->getCadenaSql('obtenerInformacionElaborador', $contrato['usuario']);
        $usuario = $DBFrameWork->ejecutarAcceso($cadenaSqlelaboro, "busqueda");



        $cadenaSql = $this->miSql->getCadenaSql('ordenadorDocumento', $contrato ['ordenador_gasto']);
        $ordenador = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
        $ordenador = $ordenador [0];


        $cadenaSql = $this->miSql->getCadenaSql('consultaContratistaDocumento', $contrato ['contratista']);
        $contratista = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
        $contratista = $contratista [0];



        $cadenaSql = $this->miSql->getCadenaSql('consultarElementosOrden', $datosContrato);
        $ElementosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


        $cadenaSqlServicios = $this->miSql->getCadenaSql('consultarServiciosOrden', $datosContrato);
        $ServiciosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSqlServicios, "busqueda");


        $cadenaSql = $this->miSql->getCadenaSql('consultaParametro', $contrato ['forma_pago']);
        $formaPago = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $formaPago = $formaPago[0][0];

        $cadenaSql = $this->miSql->getCadenaSql('consultaTipoContrato', $contrato ['tipo_contrato']);
        $tipo_contrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $tipo_contrato = $tipo_contrato[0][0];

        $sqlAdicionesPresupuesto = $this->miSql->getCadenaSql('consultarAdcionesPresupuesto', $datosContrato);
        $adicionesPresupuesto = $esteRecursoDB->ejecutarAcceso($sqlAdicionesPresupuesto, "busqueda");


        $sqlAdicionesTiempo = $this->miSql->getCadenaSql('consultarAdcionesTiempo', $datosContrato);
        $adicionesTiempo = $esteRecursoDB->ejecutarAcceso($sqlAdicionesTiempo, "busqueda");

        $sqlAdicionesAnulaciones = $this->miSql->getCadenaSql('consultarAnulaciones', $datosContrato);
        $anulaciones = $esteRecursoDB->ejecutarAcceso($sqlAdicionesAnulaciones, "busqueda");

        $sqlAdicionesSuspension = $this->miSql->getCadenaSql('consultarSuspensiones', $datosContrato);
        $suspensiones = $esteRecursoDB->ejecutarAcceso($sqlAdicionesSuspension, "busqueda");

        $sqlCesiones = $this->miSql->getCadenaSql('consultaCesiones', $datosContrato);
        $cesiones = $esteRecursoDB->ejecutarAcceso($sqlCesiones, "busqueda");

        $sqlCambiosSupervisor = $this->miSql->getCadenaSql('ConsultacambioSupervisor', $datosContrato);
        $cambioSupervisor = $esteRecursoDB->ejecutarAcceso($sqlCambiosSupervisor, "busqueda");

        $sqlOtras = $this->miSql->getCadenaSql('ConsultaOtras', $datosContrato);
        $otras = $esteRecursoDB->ejecutarAcceso($sqlOtras, "busqueda");

        $sqlEstadoContrato = $this->miSql->getCadenaSql('consultarEstadoContrato', $datosContrato);
        $estadoContrato = $esteRecursoDB->ejecutarAcceso($sqlEstadoContrato, "busqueda");

        if ($estadoContrato[0]['estado'] != 1) {
            $sqlConsecutivo_unico_contrato = $this->miSql->getCadenaSql('consultarConsecutivoUnicoSuscrito', $datosContrato);

            $consecutivo_unico_contrato = $esteRecursoDB->ejecutarAcceso($sqlConsecutivo_unico_contrato, "busqueda");
            $fechaSucripcion = explode("-", $consecutivo_unico_contrato[0]['fecha_suscripcion']);
            setlocale(LC_TIME, "es_ES.UTF-8");
            $fechaSucripcion = strftime("%A, %d de %B de %Y", gmmktime(12, 0, 0, $fechaSucripcion[1], $fechaSucripcion[2], $fechaSucripcion[0]));
              $parametros = array(
                'ordenador_gasto' => $contrato ['ordenador_gasto'],
                'fecha_suscripcion' => $consecutivo_unico_contrato[0]['fecha_suscripcion'],
               );

            $cadenaSql = $this->miSql->getCadenaSql('ordenadorArgoDocumento', $parametros);
             $ordenadorInfoExtra = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        }
        
        else{
                $parametros = array(
                'ordenador_gasto' => $contrato ['ordenador_gasto'],
                'fecha_suscripcion' =>  $contrato ['fecha_registro'],
               );
           
            $cadenaSql = $this->miSql->getCadenaSql('ordenadorArgoDocumento', $parametros);
             $ordenadorInfoExtra = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
            
        }

        if ($contratista['tipopersona'] == 'NATURAL') {

            $cadenaSql = $this->miSql->getCadenaSql('consultaTipoDocumento', $contratista ['num_documento']);
            $tipoDocumento = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");

            $InfoContratistaBasica = strtoupper($contratista['nom_proveedor']) ." (". $tipoDocumento[0][0] . "  " . $contratista['num_documento'] . ") ";


            $InfoContratista = strtoupper($contratista['nom_proveedor']) . "</b> persona natural mayor de edad, identificado(a)
                         con " . strtolower($tipoDocumento[0][0]) . " <b>N°. " . $contratista['num_documento'] . "</b> de " . $tipoDocumento[0][1] . " ";
        } elseif ($contratista['tipopersona'] == 'JURIDICA') {
            $cadenaSql = $this->miSql->getCadenaSql('consultaRepresentanteLegal', $contrato ['contratista']);
            $representanteLegal = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
            
                        
            $cadenaSql = $this->miSql->getCadenaSql('consultaDigitoVerificacion', $contratista['num_documento']);
            $digitoVerificacion = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
            
            
            
           if($representanteLegal[0]['cargo'] === 'REPRESENTANTE LEGAL' || $representanteLegal[0]['cargo'] === ' '){
                   $InfoContratista =  $representanteLegal[0]['nombre']. ", mayor de edad y vecino de esta ciudad, identificado con ". $representanteLegal[0]['tipo_documento'] . " No. ". $representanteLegal[0]['documento'] .
                                " expedida en ".$representanteLegal[0]['ciudad'].
                                ", quien actúa en nombre y representación legal de ".strtoupper($contratista['nom_proveedor']) . 
                                " con NIT " . $contratista['num_documento']."-".$digitoVerificacion[0][0];
                        
                $InfoContratistaBasica = strtoupper($contratista['nom_proveedor']) ." ( NIT " . $contratista['num_documento'] . "-".$digitoVerificacion[0][0].") ";
             
            }
            else {
                 $InfoContratista =  $representanteLegal[0]['nombre']. ", mayor de edad y vecino de esta ciudad, identificado con ". 
                                $representanteLegal[0]['tipo_documento'] . " No. ". $representanteLegal[0]['documento'] .
                                " expedida en ".$representanteLegal[0]['ciudad'].
                                ", quien actúa en nombre y representación legal "." en calidad de ". $representanteLegal[0]['cargo'] ." de ".strtoupper($contratista['nom_proveedor']) . 
                                " con NIT " . $contratista['num_documento'] . "-".$digitoVerificacion[0][0] ;
            
                 $InfoContratistaBasica = strtoupper($contratista['nom_proveedor']) ." ( NIT " . $contratista['num_documento'] ."-".$digitoVerificacion[0][0]. ") ";
          
                
            }
        } else {
            $InfoContratista = strtoupper($contratista['nom_proveedor']) . "</b>, " . $contratista['tipopersona'] . " identificado(a)
                         con nit  <b>N°. " . $contratista['num_documento'] . "</b>  ";
        }



        //$cadenaSql = $this->miSql->getCadenaSql('ordenadorArgoDocumento', $contrato ['ordenador_gasto']);
        //$ordenadorInfoExtra = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


        //--------------------------------------------------------------------------

        $cadenaSql = $this->miSql->getCadenaSql('consultaParametro', $contrato ['unidad_ejecucion']);
        $plazo = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $plazo = $plazo[0][0];


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


        $cadenaSql = $this->miSql->getCadenaSql('ObtenerInfosupervisor', $contrato ['supervisor']);
        $supervisor = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
       

         if($supervisor [0]['cargo'] != ''){
            $supervisor = strtoupper($supervisor[0]['nombre']) . " identificado(a) con cédula de ciudadanía  No. " .strtoupper($supervisor[0]['documento']) ." con el cargo de ".strtoupper($supervisor [0]['cargo']);
        }
        else{
            $supervisor = strtoupper($supervisor[0]['nombre']) . " identificado(a) con cédula de ciudadanía  No. " .strtoupper($supervisor[0]['documento']) ;
        }


        $datos_disponibilidad = array(0 => $_REQUEST ['numero_contrato'], 1 => $_REQUEST['vigencia']);
        $cadena_sql = $this->miSql->getCadenaSql('ConsultarDisponibilidadesContrato', $datos_disponibilidad);
        $disponibilidades = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

        $infoCdp = "";
        $infoRubro = "";
        for ($index = 0; $index < count($disponibilidades); $index++) {
            $infoCdp = $infoCdp . " " . $disponibilidades[$index]['numero_cdp'] . " del " . $disponibilidades[$index]['vigencia_cdp'] . ", ";
            $datos_cdp = array('numero_disponibilidad' => $disponibilidades[$index]['numero_cdp'], 'vigencia' => $disponibilidades[$index]['vigencia_cdp'], 'unidad_ejecutora' => $_REQUEST['unidad']);
            $sqlInfoCDP = $this->miSql->getCadenaSql('obtenerInfoCdp', $datos_cdp);
            $rubro = $DBSICA->ejecutarAcceso($sqlInfoCDP, "busqueda");
            $infoRubro = $infoRubro . " " . $rubro[0]['DESCRIPCION'] . ".";
        }
        $solicitud_objeto = $rubro[0]['JUSTIFICACION'];


        $funcionLetras = new EnLetras ();

        $valorContrato = $funcionLetras->ValorEnLetras($contrato['valor_contrato'], ' Pesos ');

        if (is_numeric($_REQUEST['tamanoletra']) && $_REQUEST['tamanoletra'] != null) {
            $letra = $_REQUEST['tamanoletra'];
        } else {
            $letra = 10;
        }

        if ($contrato['clase_contratista'] == '33') {
            $prefijo = "PERSONA: ";
        } else {
            $prefijo = "SOCIEDAD TEMPORAL: ";
        }





        if ($ElementosOrden) {
            $elementosyservicios .= "<table align='left' style='width:100%;PAGE-BREAK-AFTER: always' >

            <tr>
			<td style='width:100%;text-align:center;'><font size='1px'><b></b></font></td>
			</tr>

            </table><br><br>";


            $elementosyservicios .= "<table align='left' style='width:100%;' >

            <tr>
			<td style='width:100%;text-align:center;'><font size='1px'><p><b>ANEXOS</b></p></font></td>
			</tr>

        </table><br><br>";

            $elementosyservicios .= "<table align='left' style='width:100%;' >

            <tr>
			<td style='width:100%;text-align:left;'><font size='1px'><p><b>".strtoupper($tipo_contrato). " NUMERO  _________</b></font></p></td>
			</tr>

        </table><br><br>";

             $elementosyservicios .= "<table align='left' style='width:100%;' >

            <tr>
			<td style='width:100%;text-align:left;'><font size='1px'><p><b>".strtoupper($tipo_contrato). " CELEBRADA ENTRE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS Y ".strtoupper($contratista['tipopersona'])."</b></font></p></td>
			</tr>

        </table><br><br>";





            $elementosyservicios .= "
		<table style='width:100%;'>
		<tr>
		<td  style='width:100%;text-align=center;'><p><b>ELEMENTOS ASOCIADOS</b></p></td>
		</tr>
		</table>
		<table style='width:100%;'>
		<tr>
		<td style='width:10%;text-align=center;'><p>Item</p></td>
		<td style='width:14%;text-align=center;'><p>Unidad</p></td>
		<td style='width:10%;text-align=center;'><p>Cantidad</p></td>
		<td style='width:25%;text-align=center;'><p>Descripción</p></td>
		<td style='width:15.8%;text-align=center;'><p>Valor Unitario($)</p></td>
		<td style='width:8.3%;text-align=center;'><p>Iva</p></td>
		<td style='width:15.8%;text-align=center;'><p>Total</p></td>
		</tr>
		</table>
		<table class='mainelementos' style='width:100%;'>";

            $sumatoriaTotal = 0;

            $sumatoriaIva = 0;
            $sumatoriaSubtotal = 0;
            $j = 1;




            foreach ($ElementosOrden as $valor => $it) {
                $elementosyservicios .= "<tr>";
                $elementosyservicios .= "<td style='width:10%;text-align=center;'><p>" . $j . "</p></td>";
                $elementosyservicios .= "<td style='width:15%;text-align=center;'><p>" . $it ['unidad'] . "</p></td>";
                $elementosyservicios .= "<td style='width:10%;text-align=center;'><p>" . $it ['cantidad'] . "</p></td>";
                $elementosyservicios .= "<td style='width:25%;text-align=justify;'><p>" . $it ['descripcion'] . "</p></td>";
                $elementosyservicios .= "<td style='width:15.8%;text-align=center;'><p>$ " . number_format($it ['valor'], 2, ",", ".") . "</p></td>";
                $elementosyservicios .= "<td style='width:8.3%;text-align=center;'><p>" . $it ['nombre_iva'] . "</p></td>";
                $elementosyservicios .= "<td style='width:15.8%;text-align=center;'><p>$ " . number_format($it ['total_iva_con'], 2, ",", ".") . "</p></td>";
                $elementosyservicios .= "</tr>";

                $sumatoriaTotal = $sumatoriaTotal + $it ['total_iva_con'];
                $sumatoriaSubtotal = $sumatoriaSubtotal + $it ['subtotal_sin_iva'];
                $sumatoriaIva = $sumatoriaIva + $it ['total_iva'];
                $j ++;
            }

	    //------------- Redondeo Valores Totales --------------------------------------

		$sumatoriaTotal = round($sumatoriaTotal);
		$sumatoriaSubtotal = round($sumatoriaSubtotal);
		$sumatoriaIva = round($sumatoriaIva);

	    //-----------------------------------------------------------------------------

            $elementosyservicios .= "</table>";

            $elementosyservicios .= "		<table class='mainelementos' style='width:100%;'>
		<tr>

		<td style='width:75%;text-align=left;'><p><b>SUBTOTAL  : </b></p></td>
		<td style='width:25%;text-align=center;'><p><b>$" . number_format($sumatoriaSubtotal, 2, ",", ".") . "</b></p></td>
		</tr>
		<tr>

		<td style='width:75%;text-align=left;'><p><b>TOTAL IVA  : </b></p></td>
		<td style='width:25%;text-align=center;'><p><b>$" . number_format($sumatoriaIva, 2, ",", ".") . "</b></p></td>
		</tr>

		<tr>

		<td style='width:75%;text-align=center;'><p><b>TOTAL  : </b></p></td>
		<td style='width:25%;text-align=center;'><p><b>$" . number_format($sumatoriaTotal, 2, ",", ".") . "</b></p></td>
		</tr>


	</table>
				";

            $funcionLetras = new EnLetras ();

            $Letras = $funcionLetras->ValorEnLetras($sumatoriaTotal, ' Pesos ');

            $elementosyservicios .= "<table class='mainelementos' style='width:100%;'>
		<tr>
		<td style='width:100%;text-align=right;text-transform:uppercase;'><p><b>" . $Letras . "</b></p></td>
		</tr>

		</table><br><br><br>";

             $elementosyservicios .="

            <table align='left' style='width:100%;'>
		<tr>
		<td style='width:100%;text-align:justify;'>Para constancia se firma, a los, </td>
		</tr>

		</table>";

             $elementosyservicios .=" <table style='width:100%; background:#FFFFFF ; border: 0px  #FFFFFF;'>

                         <tr>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			</tr>
			<tr>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>".$contratista['num_documento']."-".strtoupper($contratista['nom_proveedor'])."</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'>".$ordenadorInfoExtra[0]['documento']."-".$ordenador['NOMBRE']."</td>
			</tr>
			<tr>

                        <td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'> CONTRASTISTA</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>ORDENADOR GASTO - ".$ordenador['ORDENADOR']."</td>
			</tr>
			</table><br><br><br><br><table class='bordes'>
                        <tr>
                      	<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>Elaborado por</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>".strtoupper($usuario[0]['nombre'])." ". strtoupper($usuario[0]['apellido'])."</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>                        </td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>                        </td>
			</tr>
			 <tr>
                      	<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>Aprobado por </td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>TULIO BERNARDO ISAZA SANTAMARIA</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>JEFE SECCIÓN DE COMPRAS</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>                          </td></tr>
			</table><br><br>
			<p class='pie'>

                            UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS NIT: 899.999.230-7
                            CARRERA 7 No. 40-53 PISO 7. TELEFONO 3239300 EXT. 2609 -2605<br>
                            Institución Acreditada de Alta Calidad según Resolución 23096 del
                            15 de Diciembre de 2016 del Ministerio de Educación Nacional<br>
                            www.udistrital.edu.co

                        </p> ";
        }
        if ($ServiciosOrden) {

            $elementosyservicios .= "<table align='left' style='width:100%;PAGE-BREAK-AFTER: always' >

            <tr>
			<td style='width:100%;text-align:center;'><font size='1px'><b></b></font></td>
			</tr>

            </table><br><br>";


            $elementosyservicios .= "<table align='left' style='width:100%;' >

            <tr>
			<td style='width:100%;text-align:center;'><font size='1px'><p><b>ANEXOS</b></p></font></td>
			</tr>

        </table><br><br>";

             $elementosyservicios .= "<table align='left' style='width:100%;' >

            <tr>
			<td style='width:100%;text-align:left;'><font size='1px'><p><b>".strtoupper($tipo_contrato). " NUMERO  _________</b></font></p></td>
			</tr>

        </table><br><br>";

             $elementosyservicios .= "<table align='left' style='width:100%;' >

            <tr>
			<td style='width:100%;text-align:left;'><font size='1px'><p><b>".strtoupper($tipo_contrato). " CELEBRADA ENTRE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS Y ".strtoupper($contratista['tipopersona'])."</b></font></p></td>
			</tr>

        </table><br><br>";



            $elementosyservicios .= "<br>
		<table class='mainelementos' style='width:100%;'>
		<tr>
		<td style='width:100%;text-align=center;'><p><b>SERVICIOS</b></p></td>
		</tr>
		</table>
		<table class='mainelementos' style='width:100%;'>
		<tr>
		<td style='width:5%;text-align=center;'><p>Item</p></td>
		<td style='width:30%;text-align=center;'><p>Descripcion</p></td>
		<td style='width:30%;text-align=center;'><p>Nombre</p></td>
		<td style='width:10%;text-align=center;'><p>Codigo DIAN</p></td>
		<td style='width:8%;text-align=center;'><p>Servicio</p></td>
		<td style='width:17%;text-align=center;'><p>Valor($)</p></td>
		</tr>
		</table>
		<table class='mainelementos' style='width:100%;'>";

            $sumatoriaTotalServicios = 0;

            $c = 1;


            foreach ($ServiciosOrden as $valor => $it) {
                $elementosyservicios .= "<tr>";
                $elementosyservicios .= "<td style='width:5%;text-align=center;'><p>" . $c . "</p></td>";
                $elementosyservicios .= "<td style='width:30%;text-align=center;'><p>" . $it ['descripcion'] . "</p></td>";
                $elementosyservicios .= "<td style='width:30%;text-align=justify;'><p>" . $it ['nombre'] . "</p></td>";
                $elementosyservicios .= "<td style='width:10%;text-align=center;'><p>$ " . $it ['codigo_ciiu'] . "</p></td>";
                $elementosyservicios .= "<td style='width:8%;text-align=center;'><p>" . $it ['codigo_ciiu'] . "</p></td>";
                $elementosyservicios .= "<td style='width:17%;text-align=center;'><p>$ " . number_format($it ['valor_servicio'], 2, ",", ".") . "</p></td>";
                $elementosyservicios .= "</tr>";

                $sumatoriaTotalServicios = $sumatoriaTotalServicios + $it ['valor_servicio'];
                $c ++;
            }


		//------------- Redondeo Valores Totales --------------------------------------

		$sumatoriaTotalServicios = round($sumatoriaTotalServicios);

	   	//-----------------------------------------------------------------------------

            $elementosyservicios .= "</table>";

            $elementosyservicios .= "		<table class='mainelementos' style='width:100%;'>
		<tr>

		<td style='width:75%;text-align=left;'><p><b>TOTAL  : </b></p></td>
		<td style='width:25%;text-align=center;'><p><b>$" . number_format($sumatoriaTotalServicios, 2, ",", ".") . "</b></p></td>
		</tr>


	</table>
				";

            $LetrastotalServicios = $funcionLetras->ValorEnLetras($sumatoriaTotalServicios, ' Pesos ');

            $elementosyservicios .= "<table class='mainelementos' style='width:100%;'>
		<tr>

		<td style='width:100%;text-align=center;text-transform:uppercase;'><p><b>" . $LetrastotalServicios . "</b></p></td>
		</tr>

		</table>";






            $elementosyservicios .= "<br><br><table class='mainelementos' style='width:100%;'>
		<tr>

		<td style='width:75%;text-align=left;'><p><b>TOTAL ORDEN: </b></p></td>
		<td style='width:25%;text-align=center;'><p><b>$" . number_format($sumatoriaTotalServicios + $sumatoriaTotal, 2, ",", ".") . "</b></p></td>
		</tr>


	</table>
				";

            $LetrasTotalOrden = $funcionLetras->ValorEnLetras($sumatoriaTotalServicios + $sumatoriaTotal, ' Pesos ');

            $elementosyservicios .= "<table class='mainelementos' style='width:100%;'>
		<tr>

		<td style='width:100%;text-align=left;text-transform:uppercase;'><p><b>" . $LetrasTotalOrden . "</b></p></td>
		</tr>

		</table>";
              $elementosyservicios .="<br><br>

            <table align='left' style='width:100%;'>
		<tr>
		<td style='width:100%;text-align:justify;'>Para constancia se firma, a los, </td>
		</tr>

		</table>";

             $elementosyservicios .=" <table style='width:100%; background:#FFFFFF ; border: 0px  #FFFFFF;'>

                         <tr>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			</tr>
			<tr>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>".$contratista['num_documento']."-".strtoupper($contratista['nom_proveedor'])."</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'>".$ordenadorInfoExtra[0]['documento']."-".$ordenador['NOMBRE']."</td>
			</tr>
			<tr>

                        <td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'> CONTRASTISTA</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>ORDENADOR GASTO - ".$ordenador['ORDENADOR']."</td>
			</tr>
			</table><br><br><br><br><table class='bordes'>
                        <tr>
                      	<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>Elaborado por</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>".strtoupper($usuario[0]['nombre'])." ". strtoupper($usuario[0]['apellido'])."</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>                        </td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>                        </td>
			</tr>
			 <tr>
                      	<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>Aprobado por </td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>TULIO BERNARDO ISAZA SANTAMARIA</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>JEFE SECCIÓN DE COMPRAS</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; '>                          </td></tr>
			</table><br><br>
			<p class='pie'>

                            UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS NIT: 899.999.230-7
                            CARRERA 7 No. 40-53 PISO 7. TELEFONO 3239300 EXT. 2609 -2605<br>
                            Institución Acreditada de Alta Calidad según Resolución 23096 del
                            15 de Diciembre de 2016 del Ministerio de Educación Nacional<br>
                            www.udistrital.edu.co

                        </p> ";
        }

        $cadenaSql = $this->miSql->getCadenaSql('consultaContratoGeneralAmparo', $datosContrato);
        
        $amparoGeneral = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
       

        $tablaDeAmparos=' <table align="center" style="width:100% ;border: 1px solid black;"> 
            <tr>            
              <td style="text-align:center;font-weight:bold;border: 1px solid black;">AMPARO</td> 
              <td style="text-align:center;font-weight:bold;border: 1px solid black;">SUFICIENCIA</td> 
              <td style="text-align:center;font-weight:bold;border: 1px solid black;">DESCRIPCION</td> 
           </tr> 
          ';
   
        $contadorArrend =0;
        
        while($contadorArrend<count($amparoGeneral)){
            
            $cadenaAmparosParametros = $this->miSql->getCadenaSql("obtenerAmparosParametros2", $amparoGeneral[$contadorArrend]['tipo_amparo']);
            $amparosParametros = $DBCore->ejecutarAcceso($cadenaAmparosParametros, "busqueda");
            
     
            
           
            
            $tablaDeAmparos.= '<tr> ';
            $tablaDeAmparos.= '<td>'.$amparosParametros[0]['nombre'].'</td> ';
            $tablaDeAmparos.= '<td>'.$amparoGeneral[$contadorArrend]['suficiencia']."%".'</td> ';
            $tablaDeAmparos.= '<td>'.$amparoGeneral[$contadorArrend]['vigencia'].'</td> ';
            $tablaDeAmparos.= '</tr>  '; 
                
            
        
       
            
       

            
            
            $contadorArrend++;
        }
       
      
         $tablaDeAmparos.='</table>';



        //------------------------------------- Generacion de Documento -----------------------------------------------------------




        if ($contrato['poliza'] == 't') {
            $tipo_plantilla = "plantillaconPoliza";
        } else {
            $tipo_plantilla = "plantillaSinPoliza";
        }
        $cadenaSql = $this->miSql->getCadenaSql('consultaPlantilla', array('tipo_contrato' => $contrato['tipo_contrato'], 'tipo_plantilla' => $tipo_plantilla));
        $plantilla = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $plantilla = $plantilla[0];

        $parametros = array(
            'P[LETRA]' => $letra,
            'P[DIRECTORIO_IMAGEN]' => $directorio . "/css/images/escudoud.png",
            'P[TIPO_CONTRATO]' => strtoupper($tipo_contrato),
            'P[NOMBRE_PROVEEDOR]' => strtoupper($contratista['nom_proveedor']),
            'P[TIPO_PERSONA]' => strtoupper($contratista['tipopersona']),
            'P[NOMBRE_ORDENADOR]' => $ordenadorInfoExtra[0]['nombre_ordenador'],
            'P[DOCUMENTO_ORDENADOR]' => $ordenadorInfoExtra[0]['documento'],
            'P[CIUDAD_DOCUMENTO_ORDENADOR]' => $ordenadorInfoExtra[0]['nombre'],
            'P[ORDENADOR]' => $ordenadorInfoExtra[0]['rol_ordenador'],
            'P[RESOLUCION_ORDENADOR]' => $ordenadorInfoExtra[0]['info_resolucion'],
            'P[INFO_CONTRATISTA]' => $InfoContratista,
            'P[OBJETO_CONTRATO]' => $contrato['objeto_contrato'],
            'P[VALOR_LETRAS]' => strtolower($valorContrato),
            'P[VALOR_NUMERO]' => number_format($contrato['valor_contrato'], 2, ",", "."),
            'P[INFO_CDP]' => $infoCdp,
            'P[INFO_RUBRO]' => $infoRubro,
            'P[PLAZO]' => $plazo,
            'P[SUPERVISOR]' => $supervisor,
            'P[TABLAAMPAROS]'=>$tablaDeAmparos,
            'P[DOCUMENTO_PROVEEDOR]' => $contratista['num_documento'],
            'P[ELABORO_NOMBRE]' => strtoupper($usuario[0]['nombre']),
            'P[ELABORO_APELLIDO]' => strtoupper($usuario[0]['apellido']),
            'P[ELEMENTOS_SERVICIO]' => $elementosyservicios,
        );

        $contenidoPiePagina = "";

        foreach ($parametros as $clave => $valor) {

            $plantilla['plantilla'] = str_replace($clave, $valor, $plantilla['plantilla']);
            $plantilla['estilo'] = str_replace($clave, $valor, $plantilla['estilo']);
        }

        $contenidoPaginaEncabezado = "";
        $textos = array(0 => $contenidoPaginaEncabezado, 1 => $plantilla['plantilla'], 2 => $contenidoPiePagina, 3 => $plantilla['estilo'],4=>$tipo_contrato);


        return $textos;
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);
$textos = $miRegistrador->documento();
$mpdf = new mPDF('', 'LETTER', 11, 'ARIAL', 20, 20, 30, 20, 7, 10);
$mpdf->AddPage();
// asignamos los estilos
$mpdf->WriteHTML($textos[3], 1);

$mpdf->SetHTMLHeader($textos[0], 'O', true);
// colocamos el html para el pie de pagina
$mpdf->setHTMLFooter($textos[2]);
// colocamos el html para el documento
$mpdf->WriteHTML($textos[1]);
// establecemos el nombre del archivo
$mpdf->Output($textos[4].'.pdf', 'D');
