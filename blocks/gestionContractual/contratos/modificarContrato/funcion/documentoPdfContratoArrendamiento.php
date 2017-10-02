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
    function Nombre_Mes($numero_mes) {
        switch ($numero_mes) {
                
                Case 1 :
                    $t = "Enero";
                    break;
                Case 2 :
                    $t = "Febrero";
                    break;
                Case 3 :
                    $t = "Marzo";
                    break;
                Case 4 :
                    $t = "Abril";
                    break;
                Case 5 :
                    $t = "Mayo";
                    break;
                Case 6 :
                    $t = "Junio";
                    break;
                Case 7 :
                    $t = "Julio";
                    break;
                Case 8 :
                    $t = "Agosto";
                    break;
                Case 9 :
                    $t = "Septiembre";
                    break;
                Case 10 :
                    $t = "Octubre";
                    break;
                Case  11:
                    $t = "Noviembre";
                break;
                Case  12:
                    $t = "Diciembre";
                break;
                default :
                    $t = "No existe mes";
                break;
    
        }
        
        Return $t;
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
        
        $conexionCore = "core";
        $DBCore = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionCore);

        $directorio = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque');

        $datosContrato = array(
            0 => $_REQUEST ['numero_contrato'],
            1 => $_REQUEST ['vigencia']
        );
        
         // Obtiene las Polizas Asociadas Al contrato
        $cadenaSql = $this->miSql->getCadenaSql('polizasDocumento', $datosContrato);
        $polizas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
        
        // Obtiene la  Toda la  Informacion de la tabla contrato general

        $cadenaSql = $this->miSql->getCadenaSql('infoContratoGeneralDocumento', $datosContrato);
        $contrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $contrato=$contrato[0];
        

        

        // Obtiene las Polizas Asociadas Al contrato
        $cadenaSqlelaboro = $this->miSql->getCadenaSql('obtenerInformacionElaborador', $contrato['usuario']);
        $usuario = $DBFrameWork->ejecutarAcceso($cadenaSqlelaboro, "busqueda");


        $cadenaSql = $this->miSql->getCadenaSql('ordenadorDocumento', $contrato ['ordenador_gasto']);
        $ordenador = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
        $ordenador = $ordenador [0];
//
//
//        $cadenaSql = $this->miSql->getCadenaSql('ordenadorArgoDocumento', $contrato ['ordenador_gasto']);
//        $ordenadorInfoExtra = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

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


        $cadenaSql = $this->miSql->getCadenaSql('consultaParametro', $contrato ['unidad_ejecucion']);
        $plazo = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $plazo = $plazo[0][0];
        
        $meses=0;
        $dias=0;
   
        if ($contrato ['unidad_ejecucion'] == '205') {
            $meses = $contrato['plazo_ejecucion'] / 30;
            if ($meses > 1) {
                $meses = floor($meses);
                $parcial = $meses * 30;
                $dias = $contrato['plazo_ejecucion'] - $parcial;
                $plazo = $meses . " mes(es) y " . $dias . " dia(s) ";
            } else {
                $plazo = $contrato['plazo_ejecucion'] . " dia(s) ";
                $dias = $contrato['plazo_ejecucion'];
            }
        } elseif ($contrato ['unidad_ejecucion'] == '206') {
            $plazo = $contrato['plazo_ejecucion'] . " Mes(es) ";
            $meses = $contrato['plazo_ejecucion'];
            $dias = 2 ;
        } else {
            $meses = $contrato['plazo_ejecucion'] * 12;
            $plazo = $meses . " mes(es) ";
        }
        
      
        $fecha_inicio_poliza = date_create($polizas[0][2]);
        date_add($fecha_inicio_poliza, date_interval_create_from_date_string("'".$meses." months'"));
        date_add($fecha_inicio_poliza, date_interval_create_from_date_string("'".$dias." days'"));
        
        $dia_final_contrato = date_format($fecha_inicio_poliza,'d');
        $mes_final_contrato = date_format($fecha_inicio_poliza,'m');
        $ano_final_contrato = date_format($fecha_inicio_poliza,'Y');
       
        
        
        $cadenaSql = $this->miSql->getCadenaSql('consultaTipoContrato', $contrato ['tipo_contrato']);
        $tipo_contrato = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $tipo_contrato = $tipo_contrato[0][0];
        
        $datosContrato = array($_REQUEST ['numero_contrato'], $_REQUEST ['vigencia']);
        $cadenaSql = $this->miSql->getCadenaSql('ConsultarperfilCPS', $datosContrato);
        $perfil = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $perfil = $perfil[0];

        $cadenaSql = $this->miSql->getCadenaSql('ConsultarNombrePerfil', $perfil['perfil']);
        $nombreperfil = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
        $nombreperfil = $nombreperfil[0]['valor_parametro'];
        
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
       
	
	$numeroContratoDin= $_REQUEST ['numero_contrato'];
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

	     $numeroContratoDin=$consecutivo_unico_contrato[0]['numero_contrato_suscrito'];

        }
        else{
            
            $parametros = array(
                'ordenador_gasto' => $contrato ['ordenador_gasto'],
                'fecha_suscripcion' =>  $contrato ['fecha_registro'],
               );
           
            $cadenaSql = $this->miSql->getCadenaSql('ordenadorArgoDocumento', $parametros);
             $ordenadorInfoExtra = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        }
        
        
      
        
        $datos_disponibilidad = array(0 => $_REQUEST ['numero_contrato'], 1 => $_REQUEST['vigencia']);
        $cadena_sql = $this->miSql->getCadenaSql('ConsultarDisponibilidadesContrato', $datos_disponibilidad);
        $disponibilidades = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
        $infoCdp = "";
        $infoRubro = "";
        for ($index = 0; $index < count($disponibilidades); $index++) {
           
            $datos_cdp = array('numero_disponibilidad' => $disponibilidades[$index]['numero_cdp'], 'vigencia' => $disponibilidades[$index]['vigencia_cdp'], 'unidad_ejecutora' => $_REQUEST['unidad']);
            $sqlInfoCDP = $this->miSql->getCadenaSql('obtenerInfoCdp', $datos_cdp);
            $rubro = $DBSICA->ejecutarAcceso($sqlInfoCDP, "busqueda");
            
            $date = date_create($rubro[0]['FECHA_REGISTRO']);
            $fecha_nueva=date_format($date, 'Y-m-d');
                  
            $fechaCDP = explode("-", $fecha_nueva);
            setlocale(LC_TIME, "es_ES.UTF-8");
            $fechaCDP= strftime("%A, %d de %B de %Y", gmmktime(12, 0, 0, $fechaCDP[1], $fechaCDP[2], $fechaCDP[0]));
            $infoCdp = $infoCdp . " " . $disponibilidades[$index]['numero_cdp'] . " expedido el " . $fechaCDP . ", ";
            $infoRubro = $infoRubro . " " . $rubro[0]['DESCRIPCION'] ;
        }
        $solicitud_objeto = $rubro[0]['JUSTIFICACION'];
        
        

        $cadenaSql = $this->miSql->getCadenaSql('ObtenerInfosupervisor', $contrato ['supervisor']);
        $supervisor = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
//        $cadenaSql = $this->miSql->getCadenaSql('ObtenerInfosupervisorDetalle', $supervisor [0]['documento']);
//        $info_detalle_supervisor = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
//        
        
        $supervisor_contrato=" Nombre: " .$supervisor [0]['nombre'];
        $supervisor_contrato.=" , Cargo: " .$supervisor [0]['cargo'];
//        $supervisor_contrato.=" , Cédula de Ciudadanía: " .$supervisor [0]['documento'].". ";
       

        $funcionLetras = new EnLetras ();

        $valorContrato = $funcionLetras->ValorEnLetras($contrato['valor_contrato'], ' Pesos ');



        if ($contratista['tipopersona'] == 'NATURAL') {

            $cadenaSql = $this->miSql->getCadenaSql('consultaTipoDocumento', $contratista ['num_documento']);
            $tipoDocumento = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
            
            $InfoContratistaBasica = strtoupper($contratista['nom_proveedor']) ." (". $tipoDocumento[0][0] . "  " . $contratista['num_documento'] . ") ";
            
            $InfoContratista =   strtoupper($contratista['nom_proveedor']) . ", mayor de edad y vecino de esta ciudad, identificado con ". $tipoDocumento[0][0] . " No. ". $contratista['num_documento'] . " expedida en ".$tipoDocumento[0][1] ;

          
            
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
             
          
        }


        $contarlineas = strlen($contrato['objeto_contrato'] . $contrato['actividades'] . $solicitud_objeto);

        if (is_numeric($_REQUEST['tamanoletra']) && $_REQUEST['tamanoletra'] != null) {
            $letra = $_REQUEST['tamanoletra'];
        } else {
            $letra = 10;
        }


        if ($contratista['regimen_contributivo'] == 'COMUN') {
            $infoRegimenSimplificado = "";
        } else {
            $infoRegimenSimplificado = ", incluido IVA";
        }
        
        

        if ($contrato['clase_contratista'] == '33') {
            $prefijo = "PERSONA: ";
        } else {
            $prefijo = "SOCIEDAD TEMPORAL: ";
        }
        
        $funcionLetras = new EnLetras ();
        
        //busqueda para contrato arrendamiento
        
        $cadenaSql = $this->miSql->getCadenaSql('consultaArrendamiento', $datosContrato);
        $arrendamiento = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
       
//        if($arrendamiento[0]['reajuste']==''){
//           $arrendamiento[0]['reajuste'] = ''; 
//         
//        }
//        else{
//            
//            $arrendamiento[0]['reajuste']=' Esta cifra se ajustará anualmente ' . $arrendamiento[0]['reajuste']; 
//        }
//        
//       
        
        
        $diasHabilesCanon = $funcionLetras->ValorEnLetras($arrendamiento[0]['plazo_pago_mensual'], '');
        $informacionArrendamientoDias = $diasHabilesCanon . ' (' .$arrendamiento[0]['plazo_pago_mensual']. ') ';
        
        
        
         
        $valorArrendamiento = $funcionLetras->ValorEnLetras($arrendamiento[0]['valor_arrendamiento'], ' Pesos ');
        $informacionArrendamientoValor = strtoupper($valorArrendamiento). ' (' .number_format($arrendamiento[0]['valor_arrendamiento'], 2, ",", "."). ' M/Cte) ';
        
        
         $diasHabilesAdmin = $funcionLetras->ValorEnLetras($arrendamiento[0]['plazo_administracion'], ''); 
         $InformacionAdministracionDias = $diasHabilesAdmin . ' (' .$arrendamiento[0]['plazo_administracion']. ') ';
         
            $valorAdministracion = $funcionLetras->ValorEnLetras($arrendamiento[0]['valor_administracion'], ' Pesos ');
            $informacionAdministracionValor = strtoupper($valorAdministracion) . ' (' .number_format($arrendamiento[0]['valor_administracion'], 2, ",", "."). ' M/Cte) ';
   
        

//        
//        if($arrendamiento[0]['plazo_administracion']==null || $arrendamiento[0]['valor_administracion']==null ){
//            $administracion=' ';
//        }
//        else{
//        
//            

//            
//            $arrayAdmin = array(
//                   'P[DIAS_HABILES_ADMINISTRACION]' => $arrendamiento[0]['plazo_administracion'],
//                     'P[DIAS_HABILES_ADMINISTRACION_LETRA]' => $diasHabilesAdmin,
//                     'P[VALOR_ADMINISTRACION]'=>number_format($arrendamiento[0]['valor_administracion'], 2, ",", "."),
//                    'P[VALOR_ADMINISTRACION_LETRA]'=>strtoupper($valorAdministracion),
//                );
//           
//             
//             $administracion='ii) A título de cuotas ordinarias de administración, un pago anticipado a EL ARRENDADOR, quien deberá a su vez cancelar a la administración correspondiente, dentro de los      '
//                     . '     primeros'.$arrayAdmin['P[DIAS_HABILES_ADMINISTRACION_LETRA]'].'  ('.$arrayAdmin['P[DIAS_HABILES_ADMINISTRACION]'].')  días hábiles de cada mes, por valor de '.$arrayAdmin['P[VALOR_ADMINISTRACION_LETRA]'].'  MONEDA CORRIENTE ('.$arrayAdmin['P[VALOR_ADMINISTRACION]'].' M/Cte). <b>LA UNIVERSIDAD</b> en ningún caso pagará o reconocerá valor alguno por las cuotas               extraordinarias de administración, las cuales están a cargo de <b>EL ARRENDADOR</b>';
//        }
//        
  
      
 
               
        $parametrosFormaPago = array(
            '[DIAS HABILES PAGO MENSUAL]' => $informacionArrendamientoDias,
            '[VALOR MENSUAL ARRENDAMIENTO]' => $informacionArrendamientoValor,
            '[REAJUSTE]' => $arrendamiento[0]['reajuste'],
            '[DIAS HABILES ADMINISTRACION]' => $InformacionAdministracionDias,
            '[VALOR ADMINISTRACION]' => $informacionAdministracionValor
        );

        foreach ($parametrosFormaPago as $clave => $valor) {

            $contrato['descripcion_forma_pago'] = str_replace($clave, $valor, $contrato['descripcion_forma_pago']);
        }

    $forma_pago = $contrato['descripcion_forma_pago'];
                
                
       
        $diasHabilesEntrega = $funcionLetras->ValorEnLetras($arrendamiento[0]['plazo_entrega'], '');

       
        
         $arregloBusqueda = array(
            'numero_contrato' =>  $arrendamiento[0]['numero_contrato'],
            'vigencia_contrato' =>  $arrendamiento[0]['vigencia']
        );
        
        $cadenaSql = $this->miSql->getCadenaSql('consultaArrendamientoAmparo', $datosContrato);
        $arrendamientoGeneral = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
        
     $tablaDeAmparos=' <table align="center" style="width:100% ; border: 1  ;"> 
            <tr>            
              <td style="text-align:center;">AMPARO</td> 
              <td style="text-align:center;">SUFICIENCIA</td> 
              <td style="text-align:center;">VIGENCIA</td> 
           </tr> 
          ';
   
        $contadorArrend =0;
        
        while($contadorArrend<count($arrendamientoGeneral)){
            
            $cadenaAmparosParametros = $this->miSql->getCadenaSql("obtenerAmparosParametros2", $arrendamientoGeneral[$contadorArrend]['tipo_amparo']);
            $amparosParametros = $DBCore->ejecutarAcceso($cadenaAmparosParametros, "busqueda");
            
     
            
           
            
            $tablaDeAmparos.= '<tr> ';
            $tablaDeAmparos.= '<td>'.$amparosParametros[0]['nombre'].'</td> ';
            $tablaDeAmparos.= '<td>'.$arrendamientoGeneral[$contadorArrend]['suficiencia']."%".'</td> ';
            $tablaDeAmparos.= '<td>'.$arrendamientoGeneral[$contadorArrend]['vigencia'].'</td> ';
            $tablaDeAmparos.= '</tr>  '; 
                
            
        
       
            
       

            
            
            $contadorArrend++;
        }
       
      
         $tablaDeAmparos.='</table>';
      
     
        
        
        
        
       
        //-------------------------------------
        
        $lugarEjecucion=$contrato['lugar_ejecucion'];
        
        $cadenaSql = $this->miSql->getCadenaSql('consultaLugarEjecucion', $lugarEjecucion);
        $direccionEjecucion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
      
           
        $cadenaSql = $this->miSql->getCadenaSql('consultaPlantilla', array('tipo_contrato' => $contrato['tipo_contrato'], 'tipo_plantilla' => 'plantillaArrendamiento'));
        $plantilla = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $plantilla = $plantilla[0];
        $parametros = array(
            'P[DIRECTORIO_IMAGEN]' => $directorio . "/css/images/escudoud.png",
            'P[NUMERO_CONTRATO]' => $numeroContratoDin,
            'P[DOCUMENTO_PROVEEDOR]' => $contratista['num_documento'],
            'P[NOMBRE_PROVEEDOR]' => strtoupper($contratista['nom_proveedor']),
            'P[TIPO_CONTRATO]' => strtoupper($tipo_contrato),
            'P[TIPO_PERSONA]' => strtoupper($contratista['tipopersona']),
            'P[NOMBRE_ORDENADOR]' => $ordenador['NOMBRE'],
            'P[DOCUMENTO_ORDENADOR]' => $ordenadorInfoExtra[0]['documento'],
            'P[CIUDAD_DOCUMENTO_ORDENADOR]' => $ordenadorInfoExtra[0]['nombre'],
            'P[ORDENADOR]' => $ordenador['ORDENADOR'],
            'P[RESOLUCION_ORDENADOR]' => $ordenadorInfoExtra[0]['info_resolucion'],
            'P[INFO_CONTRATISTA]' => $InfoContratista,
            'P[INFO_CONTRATISTA_BASICA]'=>$InfoContratistaBasica,
            'P[SOLICITUD_OBJETO]'=>$solicitud_objeto,
            'P[VIGENCIA_ACTUAL]'=>  date(Y),
            'P[VALOR_LETRAS]' => strtoupper($valorContrato),
            'P[VALOR_NUMERO]' => number_format($contrato['valor_contrato'], 2, ",", "."),
            'P[REGIMEN_CONTRATISTA]' => $infoRegimenSimplificado,
            'P[INFO_CDP]' => $infoCdp,
            'P[INFO_RUBRO]' => $infoRubro,
            'P[CODIGO_RUBRO]' => $rubro[0]['RUBRO_INTERNO'],
            'P[OBJETO_CONTRATO]' => $contrato['objeto_contrato'],
            'P[PLAZO]' => $plazo,
            'P[DIA_FIN_CONTRATO]' => $dia_final_contrato,
            'P[MES_FIN_CONTRATO]' => $funcionLetras->Nombre_Mes($mes_final_contrato),
            'P[PERIODO_FIN_CONTRATO]' => $ano_final_contrato,
            'P[FECHA_SUSCRIPCION]' =>$fechaSucripcion,
            'P[INFO_SUPERVISOR]' =>$supervisor_contrato,
            'P[NOMBRE_SUPERVISOR]' =>$supervisor [0]['nombre'],
            'P[DIRECCION_CATASTRAL]' => $direccionEjecucion[0][1],
            'P[DESTINACION_ARRENDAMIENTO]' => $arrendamiento[0]['destinacion'],
            'P[DIAS_HABILES_CANON_LETRA]'=>$diasHabilesCanon,
            'P[DIAS_HABILES_CANON]'=>  $arrendamiento[0]['plazo_pago_mensual'],
            'P[VALOR_CANON_LETRA]' =>strtoupper($valorArrendamiento),
            'P[VALOR_CANON]' =>number_format($arrendamiento[0]['valor_arrendamiento'], 2, ",", "."),
            'P[REAJUSTE_ANUAL]' => $arrendamiento[0]['reajuste'],
            'P[ADMINISTRACION]' => $administracion,
            'P[DIAS_HABILES_ENTREGA]'=>$arrendamiento[0]['plazo_entrega'],
            'P[DIAS_HABILES_ENTREGA_LETRA]'=>$diasHabilesEntrega,
            'P[TABLAAMPAROS]'=>$tablaDeAmparos,
            'P[ELABORO_NOMBRE]' => strtoupper($usuario[0]['nombre']),
            'P[ELABORO_APELLIDO]' => strtoupper($usuario[0]['apellido']),
            'P[FORMA_PAGO]' => $forma_pago
        );

        foreach ($parametros as $clave => $valor) {

            $plantilla['plantilla'] = str_replace($clave, $valor, $plantilla['plantilla']);
            $plantilla['estilo'] = str_replace($clave, $valor, $plantilla['estilo']);
        }

    $contenidoPagina = $plantilla['plantilla'];
 

        $contenidoPiePagina = "";

        $estilos = $plantilla['estilo'];
   

        $contenidoPaginaEncabezado = "";

        $textos = array(0 => $contenidoPaginaEncabezado, 1 => $contenidoPagina, 2 => $contenidoPiePagina, 3 => $estilos, 4 => "Contrato Arrendamiento" . $datosContrato[0].'-'.$datosContrato[1]);

        return $textos;
    }

}

echo "<script>javascript: alert('Fuente')></script>";

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$textos = $miRegistrador->documento();

$mpdf = new mPDF('', 'LETTER', 10, 'ARIAL', 20, 15, 5, 15, 7, 10);
$mpdf->AddPage();
// asignamos los estilos
$mpdf->WriteHTML($textos[3], 1);
$mpdf->setFooter('{PAGENO}');
$mpdf->SetHTMLHeader($textos[0], 'O', true);

// colocamos el html para el documento
$mpdf->WriteHTML($textos[1]);
// colocamos el html para el pie de pagina

$mpdf->setHTMLFooter($textos[2]);
$mpdf->setFooter('{PAGENO}');

// establecemos el nombre del archivo
$mpdf->Output($textos[4] . '.pdf', 'D');
?>
