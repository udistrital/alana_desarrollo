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


        $cadenaSql = $this->miSql->getCadenaSql('ordenadorDocumento', $contrato ['ordenador_gasto']);
        $ordenador = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $ordenador = $ordenador [0];

        $cadenaSql = $this->miSql->getCadenaSql('consultaContratistaDocumento', $contrato ['contratista']);
        $contratista = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
        $contratista = $contratista [0];


        $cadenaSql = $this->miSql->getCadenaSql('consultaParametro', $contrato ['forma_pago']);
        $formaPago = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $formaPago = $formaPago[0][0];

        $cadenaSql = $this->miSql->getCadenaSql('consultaParametro', $contrato ['tipologia_contrato']);
        $tipo_contrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $tipo_contrato = $tipo_contrato[0][0];




        $sqlAdicionesPresupuesto = $this->miSql->getCadenaSql('consultarAdcionesPresupuesto', $datosContrato);
        $adicionesPresupuesto = $esteRecursoDB->ejecutarAcceso($sqlAdicionesPresupuesto, "busqueda");


        $sqlAdicionesTiempo = $this->miSql->getCadenaSql('consultarAdcionesTiempo', $datosContrato);
        $adicionesTiempo = $esteRecursoDB->ejecutarAcceso($sqlAdicionesTiempo, "busqueda");


        $sqlEstadoContrato = $this->miSql->getCadenaSql('consultarEstadoContrato', $datosContrato);
        $estadoContrato = $esteRecursoDB->ejecutarAcceso($sqlEstadoContrato, "busqueda");

        if ($estadoContrato[0]['estado'] != 1) {
            $sqlConsecutivo_unico_contrato = $this->miSql->getCadenaSql('consultarConsecutivoUnicoSuscrito', $datosContrato);
            $consecutivo_unico_contrato = $esteRecursoDB->ejecutarAcceso($sqlConsecutivo_unico_contrato, "busqueda");
        }



        $cadenaSql = $this->miSql->getCadenaSql('Consultar_Info_Suscripcion', $datosContrato);
        $infoSuscripcion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $infoSuscripcion = $infoSuscripcion[0];
        $fechaSucripcion = explode("-", $infoSuscripcion['fecha_suscripcion']);
        setlocale(LC_TIME, "es_ES.UTF-8");
        $fechaSucripcion = strftime("%A, %d de %B de %Y", gmmktime(12, 0, 0, $fechaSucripcion[1], $fechaSucripcion[2], $fechaSucripcion[0]));


        $contenidoPagina = "
<style type=\"text/css\">
    table { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
		
       
    }
    
    table.mainelementos { 
       
        border: 1px solid black;
        
    }
    td.mainelementos { 
         border: 1px solid black;
        
    }

    td, th { 
         height: 20px;
    } /* Make cells a bit taller */

	col{
	width=50%;
	
	}			
				
    th {
        background: #F3F3F3; /* Light grey background */
        font-weight: bold; /* Make sure they're bold */
        text-align: center;
        font-size:10px
    }

    td {
        background: #FAFAFA; /* Lighter grey background */
        text-align: left;
        font-size:10px
    }
    
    td.sinespacionInferior {
        padding-bottom: 0.5px
    }
</style>				
				
				
<page backtop='5mm' backbottom='5mm' backleft='10mm' backright='10mm'>
	

        <table align='center' style='width:100%;' >
           
            <tr>
                <td align='center' >
                    <img src='" . $directorio . "/css/images/escudoud.png'  width='80' height='100'>
                </td>
                              
            </tr>
           
        </table><br>";
        $contenidoPagina .= "<table align='left' style='width:100%;' >
            <tr>
	    <td style='width:100%;text-align:center;'><font size='1px'><b>ESTADO CONTRATO: " . strtoupper($estadoContrato[0]['nombre_estado']) . "</b></font></td>	
	    </tr>";

        if (isset($consecutivo_unico_contrato) && $consecutivo_unico_contrato[0]['numero_contrato_suscrito'] != null) {
            $contenidoPagina .= "<tr>
	    <td style='width:100%;text-align:center;'><font size='1px'><b>CONTRATO NUMERO " . $consecutivo_unico_contrato[0]['numero_contrato_suscrito'] . "</b></font></td>	
	    </tr>";
        } else {
            $contenidoPagina .= "<tr>
	    <td style='width:100%;text-align:center;'><font size='1px'><b>CONSECUTIVO DE ELABORACIÓN " . $_REQUEST['numero_contrato'] . "</b></font></td>	
	    </tr>";
        }
        $_REQUEST['numeracionOtrosi'] = $_REQUEST['numeracionOtrosi'] + 1;
        $contenidoPagina .= " <tr>
	    <td style='width:100%;text-align:center;'><font size='1px'><b>VIGENCIA " . $_REQUEST['vigencia'] . "</b></font></td>	
	    </tr>
            <tr>
	    <td style='width:100%;text-align:justify;'><font size='1px'><p><b>OTROSI No: " . $_REQUEST['numeracionOtrosi'] . "  AL CONTRATO DE PRESTACIÓN  "
                . "DE SERVICIOS No. " . $consecutivo_unico_contrato[0]['numero_contrato_suscrito'] . " "
                . " DEL " . strtoupper($fechaSucripcion) . " "
                . "CELBRADO ENTRE LA UNIVERSIDAD DISTRITAL FRANSISCO JOSÉ DE CALDAS Y  " . strtoupper($contratista['nom_proveedor']) . "</b></p></font></td>	
	    </tr>
                   
        </table>";
        $contenidoPagina .= "<br><br><br><table align='left' style='width:100%;' >
           
            <tr>
			<td style='width:100%;text-align:justify;'><font size='1px'>Entre los suscritos, de una parte, " . $ordenador['nombre'] . ", mayor de edad vecino(a) de esta ciudad, identificado con cédula de ciudadania No.
                         " . $ordenador['identificacion'] . " expedida en ___________________________, quien actua en calidad de " . $ordenador['ordenador'] . " segun Resolucion de Rectoria
                         N° 278 del 10 de junio del 2016, debidamente autorizado para contratar, segun acuerdo N°003 del 2015 (Estatuto de Contratación de la Universidad
                         Distrital Fransisco Jose de Caldas) y Resoluciones rectorales N° 262 de 2015, 443 de 2015 y 003 de 2016, quien en lo sucesivo se denominará LA UNIVERSIDAD,
                         con NIT 899999230-7, ente universitario autónomo de conformidad con la ley 30 de 1992, y " . $contratista['nom_proveedor'] . " mayor de edad, identificado(a) 
                         con cedula de ciudadania N°. " . $contratista['num_documento'] . " de ciuddaCedulaContratista, vecino(a) de esta ciudad quien en lo sucesivo se denominará
                         EL CONTRATISTA, hemos convenido celebrar el presente OTROSI al Contrato de Prestacion de Servicios No. " . $consecutivo_unico_contrato[0]['numero_contrato_suscrito'] . " 
                         de ".$_REQUEST['vigencia'].", previa a las siguientes CONSIDERACIONES 1)Que el Contrato de Prestacion de Servicios No. " . $consecutivo_unico_contrato[0]['numero_contrato_suscrito'] . " 
                         de ".$_REQUEST['vigencia']." se encuentra vigente 2) Que el plazo inicial para el desarrollo del objeto contractual se pacto en  ----------------,
                         contados a partir de la suscricpion del acta de inicio por parte de supervisor y contratista. 3)Que se pactó como valor del presente contrato de prestación de servicios
                         la sume de -----------------.4)que mediante oficio de fecha ----------------, el --------------------- solicito reliazar a la oficina acesora juridica Otro si para prorrogar por --------, 
                         y adicionael valor de --------------------- al presente contrato. Que el acto aqui planteado es juridicamente viable de acuero a la establecido en las normas civiles y comerciales vigentes
                         y en especial del estatuto de contratación de la universidad   y normas reglamentarias. En consecuencia a lo anterior, las partes acuerdan: PRIMERO- ADICIONAR
                         al valor del Contrato de Prestacion de Servicios No". $consecutivo_unico_contrato[0]['numero_contrato_suscrito']."  de ".$_REQUEST['vigencia']. " la suma de
                         ----------------, SEGUNDO - PRORROGAR la duración delContrato de Prestación de Servicios No". $consecutivo_unico_contrato[0]['numero_contrato_suscrito']."  de ".$_REQUEST['vigencia']. "
                        ,----------------------- MAS contados a partir de la fecha de terminacion del mismo. TERCERO - APROPIACIÓN PRESUPUESTAL. La universidad pagará el valor de la presente adicion
                        con cargo al Certificacdo de Disponibilidad Presupuestal No. ------- del -------.CUARTO .- El contratista se obliga a mantener actualizadas las polizas del presente OTROSI para
                        asegurar el cumplimiento de la obligaciones adquiridas. QUINTO- La cláusulas y condiciones no modificadas por el presente instrumento continúan vigentes en los términos
                         del contrato primigenio. Las partes manifiestan libremente que han procedido a la lectuta total y cuidadosa del presente documento, por lo que, en consecuencua, se obligan en todos 
                         sus órdenes y manifestaciones.\n
                         
                         Para Constancia ser firma en Bogota D.C.
                         
                        </font></td>	
			</tr>
           
        </table>";


        $contenidoPagina .= "<table align='left' style='width:100%;' >
           
            <tr>
			<td style='width:100%;text-align:center;'><font size='1px'><b>ELEMENTOS Y SERVICIOS ASOCIADOS</b></font></td>	
			</tr>
           
        </table><br><br>";



        $contenidoPagina .= "<table style='width:100%; background:#FFFFFF ; border: 0px  #FFFFFF;'>
			<tr>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			</tr>
			<tr>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>" . strtoupper($contratista['num_documento'] . "-" . $contratista['nom_proveedor']) . "</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'>" . $ordenador ['identificacion'] . "-" . $ordenador['nombre'] . "</td>
			</tr>
			<tr>";
        if ($contrato['clase_contratista'] == '33') {
            $prefijo = "PERSONA: ";
        } else {
            $prefijo = "SOCIEDAD TEMPORAL: ";
        }
        $contenidoPagina .= "<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'> CONTRASTISTA - (" . $prefijo . strtoupper($contratista['tipopersona']) . ")</td>
			<td class='sinespacionInferior' style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>ORDENADOR GASTO - (" . $ordenador['ordenador'] . ")</td>
			</tr>
			</table>";

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